<?php
/*------------------------------------------------------------------------
# fieldgroup.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

class OspropertyFieldgroup{
	function display($option,$task){
		global $jinput, $mainframe;
		$cid = $jinput->get('cid',array(),'ARRAY');
		switch ($task){
			case "fieldgroup_list":
				OspropertyFieldgroup::fieldgroup_list($option);
			break;
			case "fieldgroup_add":
				OspropertyFieldgroup::fieldgroup_edit($option,0);
			break;
			case "fieldgroup_edit":
				OspropertyFieldgroup::fieldgroup_edit($option,$cid[0]);
			break;
			case "fieldgroup_save":
				OspropertyFieldgroup::save($option,1);
			break;
			case "fieldgroup_new":
				OspropertyFieldgroup::save($option,2);
			break;
			case "fieldgroup_apply":
				OspropertyFieldgroup::save($option,0);
			break;
			case "fieldgroup_remove":
				OspropertyFieldgroup::removeList($option,$cid);
			break;
			case "fieldgroup_publish":
				OspropertyFieldgroup::changState($option,$cid,1);
			break;
			case "fieldgroup_unpublish":
				OspropertyFieldgroup::changState($option,$cid,0);
			break;
			case "fieldgroup_saveorder":
				OspropertyFieldgroup::saveorder($option);
			break;
			case "fieldgroup_saveorderAjax":
				OspropertyFieldgroup::saveorderAjax($option);
			break;
			case "fieldgroup_orderup":
				OspropertyFieldgroup::direction($option,$cid[0],-1);
			break;
			case "fieldgroup_orderdown":
				OspropertyFieldgroup::direction($option,$cid[0],1);
			break;
			case "fieldgroup_gotolist":
				OspropertyFieldgroup::gotolist($option);
			break;			
		}
	}
	
	/**
	 * Field Groups listing
	 *
	 * @param unknown_type $option
	 */
	function fieldgroup_list($option){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
        //Update access level to Public for all existing field groups
        $db->setQuery("Update #__osrs_fieldgroups set `access` = '1' where `access` = '0'");
        $db->query();

		$lists							= array();
		
		$limit							= $jinput->getInt('limit',20);
		$limitstart						= $jinput->getInt('limitstart',0);
		$keyword						= $jinput->getString('keyword','');
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
	
		
		$query = "Select count(id) from #__osrs_fieldgroups where 1=1";
		if($keyword != ""){
			$query .= " and group_name like '%$keyword%'";
		}
		$db->setQuery($query);
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		
		$pageNav = new JPagination($total,$limitstart,$limit);
		
		$query = "Select * from #__osrs_fieldgroups where 1=1";
		if($keyword != ""){
			$query .= " and group_name like '%$keyword%'";
		}
		$query .= " order by $filter_order $filter_order_Dir";
		
		$db->setQuery($query,$pageNav->limitstart,$pageNav->limit);
		
		$rows = $db->loadObjectList();
		
		HTML_OspropertyFieldgroup::listfieldgroup($option,$rows,$pageNav,$lists);
	}
	
	/**
	 * Edit extra field groups
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	function fieldgroup_edit($option,$id){
		global $jinput, $mainframe,$languages;
		$db = JFactory::getDBO();
		$row = &JTable::getInstance('Fieldgroup','OspropertyTable');
		if($id > 0){
			$row->load((int)$id);
		}else{
			$row->published = 1;
            $row->access = 0;
		}
		//$lists['state'] = JHTML::_('select.booleanlist', 'published', '', $row->published);
		$optionArr = array();
		$optionArr[] = JHTML::_('select.option',1,JText::_('OS_YES'));
		$optionArr[] = JHTML::_('select.option',0,JText::_('OS_NO'));
		$lists['state']   = JHTML::_('select.genericlist',$optionArr,'published','class="input-mini"','value','text',$row->published);

        $lists['access'] = OSPHelper::accessDropdown('access',$row->access);

		$translatable = JLanguageMultilang::isEnabled() && count($languages);
		HTML_OspropertyFieldgroup::editGroup($option,$row,$lists,$translatable);
	}
	
	/**
	 * Save fieldgroup
	 *
	 * @param unknown_type $option
	 * @param unknown_type $save
	 */
	function save($option,$save){
		global $jinput, $mainframe,$languages;
		$db = JFactory::getDBO();
		$row = &JTable::getInstance('Fieldgroup','OspropertyTable');
		$post = $jinput->post->getArray();
		$row->bind($post);
		$id = $jinput->getInt('id',0);
		if($id == 0){
			//get the ordering
			$db->setQuery("Select ordering from #__osrs_fieldgroups order by ordering desc limit 1");
			$ordering = $db->loadResult();
			$row->ordering = $ordering + 1;
		}
		$row->store();
		if($id == 0){
			$id = $db->insertID();
		}
		$translatable = JLanguageMultilang::isEnabled() && count($languages);
		if($translatable){
			foreach ($languages as $language){	
				$sef = $language->sef;
				$group_name_language = $jinput->getString('group_name_'.$sef,'');
				if($group_name_language == ""){
					$group_name_language = $row->group_name;
					$group = &JTable::getInstance('Fieldgroup','OspropertyTable');
					$group->id = $id;
					$group->{'group_name_'.$sef} = $group_name_language;
					$group->store();
				}
			}
		}
		$msg = JText::_('OS_ITEM_SAVED');
		if($save == 1){
			$mainframe->redirect("index.php?option=com_osproperty&task=fieldgroup_list",$msg);
		}elseif($save == 2){
			$mainframe->redirect("index.php?option=com_osproperty&task=fieldgroup_add",$msg);
		}else{
			$mainframe->redirect("index.php?option=com_osproperty&task=fieldgroup_edit&cid[]=$id",$msg);
		}
   }
		
	/**
	 * Remove field groups
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 */
	function removeList($option,$cid){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		if($cid){
			$cids = implode(",",$cid);
			$db->setQuery("Delete from #__osrs_fieldgroups where id in ($cids)");
			$db->query();
			//remove fields
			$db->setQuery("Delete from #__osrs_extra_fields where group_id in ($cids)");
			$db->query();
		}
		$msg = JText::_('OS_ITEM_HAS_BEEN_DELETED');
		$mainframe->redirect("index.php?option=com_osproperty&task=fieldgroup_list",$msg);
	}
	
	/**
	 * Change status of the field group(s)
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 * @param unknown_type $state
	 */
	function changState($option,$cid,$state){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		if($cid){
			$cids = implode(",",$cid);
			$db->setQuery("Update #__osrs_fieldgroups set published = '$state' where id in ($cids)");
			$db->query();
		}
		$msg = JText::_("OS_ITEM_STATUS_HAS_BEEN_CHANGED");
		$mainframe->redirect("index.php?option=com_osproperty&task=fieldgroup_list",$msg);
	}

	function saveorderAjax($option){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		$cid 	= $jinput->get( 'cid', array(), 'array' );
		$order 	= $jinput->get( 'order', array(). 'array' );
		
		$row = &JTable::getInstance('Fieldgroup','OspropertyTable');
		$groupings	= array();
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
	 * Save order
	 *
	 * @param unknown_type $option
	 */
	function saveorder($option){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		$msg = JText::_( 'OS_NEW_ORDERING_SAVED' );
		$cid 	= $jinput->getString( 'cid', array(),'array' );
		$order 	= $jinput->getString( 'order', array(),  'array' );
		
		$row = &JTable::getInstance('Fieldgroup','OspropertyTable');
		// update ordering values
		$groupings	= array();
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
		$mainframe->redirect("index.php?option=com_osproperty&task=fieldgroup_list",$msg);
	}
	
	/**
	 * Save order
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 * @param unknown_type $direction
	 */
	function direction($option,$id,$direction){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		$row = &JTable::getInstance('Fieldgroup','OspropertyTable');
		
		if (!$row->load($id)) {
			$msg = $db->getErrorMsg();
		}
		if (!$row->move( $direction)) {
			$msg = $db->getErrorMsg();
		}
		
		$msg = JText::_("OS_NEW_ORDERING_SAVED");		
		$mainframe->redirect("index.php?option=com_osproperty&task=fieldgroup_list",$msg);
	}
	
	
	/**
	 * Go to list
	 *
	 * @param unknown_type $option
	 */
	function gotolist($option){
		global $jinput, $mainframe;
		$mainframe->redirect("index.php?option=com_osproperty&task=fieldgroup_list");
	}
}
?>