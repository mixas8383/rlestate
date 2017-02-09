<?php
/*------------------------------------------------------------------------
# type.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

class OspropertyType{
	/**
	 * Default function
	 *
	 * @param unknown_type $option
	 */
	function display($option,$task){
		global $jinput, $mainframe;
		$cid = $jinput->get( 'cid', array() ,'ARRAY');
		switch ($task){
			case "type_list":
				OspropertyType::type_list($option);
			break;
			case "type_unpublish":
				OspropertyType::type_change_publish($option,$cid,0);	
			break;
			case "type_publish":
				OspropertyType::type_change_publish($option,$cid,1);
			break;
			case "type_remove":
				OspropertyType::type_remove($option,$cid);
			break;
			case "type_add":
				OspropertyType::type_edit($option,0);
			break;
			case "type_edit":
				OspropertyType::type_edit($option,$cid[0]);
			break;
			case 'type_cancel':
				$mainframe->redirect("index.php?option=$option&task=type_list");
			break;	
			case "type_save":
				OspropertyType::type_save($option,1);
			break;	
			case "type_apply":
				OspropertyType::type_save($option,0);
			break;
			case "type_new":
				OspropertyType::type_save($option,2);
			break;
			case "type_saveorder":
				OspropertyType::saveorder($option);
			break;
			case "type_saveorderAjax":
				OspropertyType::saveorderAjax($option);
			break;
			case "type_orderup":
				OspropertyType::orderup($option);
			break;
			case "type_orderdown":
				OspropertyType::orderdown($option);
			break;
		}
	}
	
	/**
	 * Type list
	 *
	 * @param unknown_type $option
	 */
	function type_list($option){
		global $jinput, $mainframe;
		$db								= JFactory::getDBO();
		$lists							= array();
        $filter_order					= $jinput->getString('filter_order','ordering');
        $filter_order_Dir				= $jinput->getString('filter_order_Dir','');
        $filter_full_ordering			= $jinput->getString('filter_full_ordering','ordering asc');
		$filter_Arr						= explode(" ",$filter_full_ordering);
		$filter_order					= $filter_Arr[0];
		$filter_order_Dir				= $filter_Arr[1];

		if($filter_order == ""){
			$filter_order				= 'ordering';
		}
		$lists['filter_order']			= $filter_order;
		$lists['filter_order_Dir']		= $filter_order_Dir;
        $limit							= $jinput->getInt('limit',20);
        $limitstart						= $jinput->getInt('limitstart',0);
        $keyword						= $jinput->getString('keyword','');
		$condition						= '';
		
		$count = "SELECT count(id) FROM #__osrs_types WHERE 1=1";
		if($keyword != ""){
			$condition .= " AND (type_name LIKE '%$keyword%' OR type_description LIKE '%$keyword%')";
		}
		$count .= $condition;
		$db->setQuery($count);
		$total = $db->loadResult();
		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total,$limitstart,$limit);
		
		$list  = "SELECT * FROM #__osrs_types WHERE 1=1 ";
		$list .= $condition;
		$list .= " ORDER BY $filter_order $filter_order_Dir";
		$db->setQuery($list,$pageNav->limitstart,$pageNav->limit);
		$rows = $db->loadObjectList();
		
		if(count($rows) > 0){
			for($i=0;$i<count($rows);$i++){
				$row = $rows[$i];
				$alias = $row->type_alias;
				if($alias == ""){
					$alias = OSPHelper::generateAlias('type',$row->id);
					$db->setQuery("Update #__osrs_types set type_alias = '$alias' where id = '$row->id'");
					$db->query();
					$row->type_alias = $alias;
				}

				$db->setQuery("Select count(id) from #__osrs_properties where pro_type = '$row->id'");
				$row->nproperties = (int)$db->loadResult();
			}
		}
		
		HTML_OspropertyType::type_list($option,$rows,$pageNav,$lists);
	}
	
	/**
	 * publish or unpublish type
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 * @param unknown_type $state
	 */
	function type_change_publish($option,$cid,$state){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		if(count($cid)>0)	{
			$cids = implode(",",$cid);
			$db->setQuery("Update #__osrs_types SET `published` = '$state' WHERE id IN ($cids)");
			$db->query();
		}
		$msg = JText::_("OS_ITEM_STATUS_HAS_BEEN_CHANGED");
		$mainframe->redirect("index.php?option=$option&task=type_list",$msg);
	}
	
	/**
	 * remove type
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 */
	function type_remove($option,$cid){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		if(count($cid)>0)	{
			$cids = implode(",",$cid);
			$db->setQuery("DELETE FROM #__osrs_types WHERE id IN ($cids)");
			$db->query();
			
			$db->setQuery("Select id from #__osrs_properties where pro_type in ($cids)");
			$rows = $db->loadObjectList();
			$property_id_array = array();
			if(count($rows) > 0){
				for($i=0;$i<count($rows);$i++){
					$property_id_array[$i] = $rows[$i]->id;
				}
				OspropertyProperties::remove($option,$property_id_array,0);
			}
		}
		$msg = JText::_("OS_ITEM_HAS_BEEN_DELETED");
		$mainframe->redirect("index.php?option=$option&task=type_list",$msg);
	}
	
	/**
	 * Type Detail
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	function type_edit($option,$id){
		global $jinput, $mainframe,$languages;
		$db = JFactory::getDBO();
		$lists = array();
		
		$row = &JTable::getInstance('Type','OspropertyTable');
		if($id > 0){
			$row->load((int)$id);
		}else{
			$row->published = 1;
		}
		
		$optionArr = array();
		$optionArr[] = JHTML::_('select.option',0,JText::_('OS_HOLIDAY'));
		$optionArr[] = JHTML::_('select.option',1,JText::_('OS_PROPERTY'));
		$lists['price_type'] = JHTML::_('select.genericlist',$optionArr,'price_type','class="input-small"','value','text',$row->price_type);
		
		//$lists['state'] = JHTML::_('select.booleanlist', 'published', '', $row->published);
		$optionArr = array();
		$optionArr[] = JHTML::_('select.option',1,JText::_('OS_YES'));
		$optionArr[] = JHTML::_('select.option',0,JText::_('OS_NO'));
		$lists['state']   = JHTML::_('select.genericlist',$optionArr,'published','class="input-mini"','value','text',$row->published);
		$translatable = JLanguageMultilang::isEnabled() && count($languages);
		HTML_OspropertyType::editHTML($option,$row,$lists,$translatable);
	}
	
	/**
	 * save Type
	 *
	 * @param unknown_type $option
	 */
	function type_save($option,$save){
		global $jinput, $mainframe,$languages;
		$db = JFactory::getDBO();
		$post = $jinput->post->getArray();
		$row = &JTable::getInstance('Type','OspropertyTable');
		$row->bind($post);		 
		$row->check();
		$msg = JText::_('OS_ITEM_SAVED'); 
	 	if (!$row->store()){
		 	$msg = JText::_('OS_ERROR_SAVING'); ;		 			 	
		}
		$id = $jinput->getInt('id',0);
		if($id == 0){
			$id = $db->insertID();
		}
		$type_alias = $jinput->getString('type_alias','');
		$type_alias = OSPHelper::generateAlias('type',$id,$type_alias);
		$db->setQuery("Update #__osrs_types set type_alias = '$type_alias' where id = '$id'");
		$db->query();
		$translatable = JLanguageMultilang::isEnabled() && count($languages);
		if($translatable){
			foreach ($languages as $language){	
				$sef = $language->sef;
				
				$type_name_language = $jinput->getString('type_name_'.$sef,'');
				if($type_name_language == ""){
					$type_name_language = $row->type_name;
					$type = &JTable::getInstance('Type','OspropertyTable');
					$type->id = $id;
					$type->{'type_name_'.$sef} = $type_name_language;
					$type->store();
				}
				
				$type_alias = $jinput->getString('type_alias_'.$sef,'');
				$type_alias = OSPHelper::generateAliasMultipleLanguages('type',$id,$type_alias,$sef);
				$db->setQuery("Update #__osrs_types set type_alias_".$sef." = '$type_alias' where id = '$id'");
				$db->query();
			}
		}
		if($save == 1){
			$mainframe->redirect("index.php?option=$option&task=type_list",$msg);
		}elseif($save == 2){
			$mainframe->redirect("index.php?option=$option&task=type_add",$msg);
		}else{
			$mainframe->redirect("index.php?option=$option&task=type_edit&cid[]=".$id,$msg);
		}
	}
	
/**
	 * Save order
	 *
	 * @param unknown_type $option
	 */
	function saveorder($option){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		$msg = JText::_( 'OS_NEW_ORDERING_SAVED' );
		$cid 	= $jinput->get( 'cid', array(), 'array' );
	
		$row = &JTable::getInstance('Type','OspropertyTable');
		
		$groupings	= array();

		$order		= $jinput->get( 'order', array(), 'array' );

		// update ordering values
		for( $i=0; $i < count($cid); $i++ ) {
			$row->load( $cid[$i] );
			// track parents
			$groupings[] = $row->ordering;
			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$this->setError($row->getError());
					return false;
				}
			} // if
		} // for

		// execute updateOrder for each parent group
		$groupings = array_unique( $groupings );
		foreach ($groupings as $group){
			$row->reorder(' published = 1');
		}
		
		$mainframe->redirect("index.php?option=com_osproperty&task=type_list",$msg);
	}
	
	
	function saveorderAjax($option){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		$cid 	= $jinput->get( 'cid', array(), 'array' );
	
		$row = &JTable::getInstance('Type','OspropertyTable');
		
		$groupings	= array();

		$order		= $jinput->get( 'order', array(), 'array' );

		// update ordering values
		for( $i=0; $i < count($cid); $i++ ) {
			$row->load( $cid[$i] );
			// track parents
			$groupings[] = $row->ordering;
			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$this->setError($row->getError());
					return false;
				}
			} // if
		} // for

		// execute updateOrder for each parent group
		$groupings = array_unique( $groupings );
		foreach ($groupings as $group){
			$row->reorder(' published = 1');
		}
	}
	
	/**
	 * Order up
	 *
	 * @return unknown
	 */
	function orderup(){
		global $jinput, $mainframe,$_jversion;

		$cid	= $jinput->get( 'cid', array(), 'array' );

		if (isset($cid[0]) && $cid[0]) {
			$id = $cid[0];
		} else {
			$this->setRedirect(
				'index.php?option=com_osproperty&task=type_list',
				JText::_('OS_NO_ITEM_SELECTED')
			);
			return false;
		}

		if (self::orderItem($id, -1)) {
			$msg = JText::_( 'OS_MENU_ITEM_MOVED_UP' );
		}
		
		$mainframe->redirect("index.php?option=com_osproperty&task=type_list",$msg);
	}
	
	/**
	 * Order down
	 *
	 * @param unknown_type $option
	 */
	function orderdown($option){
		global $jinput, $mainframe,$_jversion;

		$cid	= $jinput->get( 'cid', array(), 'array' );

		if (isset($cid[0]) && $cid[0]) {
			$id = $cid[0];
		} else {
			$this->setRedirect(
				'index.php?option=com_osproperty&task=type_list',
				JText::_('OS_NO_ITEM_SELECTED')
			);
			return false;
		}

		if (self::orderItem($id, 1)) {
			$msg = JText::_( 'OS_MENU_ITEM_MOVED_DOWN' );
		}
		$mainframe->redirect("index.php?option=com_osproperty&task=type_list",$msg);
	}
	
	/**
	 * Order Item
	 *
	 * @param unknown_type $item
	 * @param unknown_type $movement
	 * @return unknown
	 */
	public static function orderItem($item, $movement){
		$row = &JTable::getInstance('Type','OspropertyTable');
		$row->load( $item );
		if (!$row->move( $movement, '' )) {
			return false;
		}
		return true;
	}
}
?>