<?php
/*------------------------------------------------------------------------
# amenities.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

class OspropertyAmenities{
	/**
	 * Default function
	 *
	 * @param unknown_type $option
	 */
	function display($option,$task){
		global $jinput, $mainframe;
		$cid = $jinput->get( 'cid', array(),'ARRAY');
		//update ordering
		self::initOrdering();
		switch ($task){
			case "amenities_list":
				OspropertyAmenities::amenities_list($option);
			break;
			case "amenities_unpublish":
				OspropertyAmenities::amenities_change_publish($option,$cid,0);	
			break;
			case "amenities_publish":
				OspropertyAmenities::amenities_change_publish($option,$cid,1);
			break;
			case "amenities_remove":
				OspropertyAmenities::amenities_remove($option,$cid);
			break;
			case "amenities_add":
				OspropertyAmenities::amenities_edit($option,0);
			break;
			case "amenities_edit":
				OspropertyAmenities::amenities_edit($option,$cid[0]);
			break;
			case 'amenities_cancel':
				$mainframe->redirect("index.php?option=$option&task=amenities_list");
			break;	
			case "amenities_save":
				OspropertyAmenities::amenities_save($option,1);
			break;
			case "amenities_new":
				OspropertyAmenities::amenities_save($option,2);
			break;
			case "amenities_apply":
				OspropertyAmenities::amenities_save($option,0);
			break;
			case "amenities_saveorder":
				OspropertyAmenities::saveorder($option);
			break;
			case "amenities_saveorderAjax":
				OspropertyAmenities::saveorderAjax($option);
			break;
			case "amenities_orderup":
				OspropertyAmenities::orderup($option);
			break;
			case "amenities_orderdown":
				OspropertyAmenities::orderdown($option);
			break;
		}
	}
	
	/**
	 * Amenitie list
	 *
	 * @param unknown_type $option
	 */
	function amenities_list($option){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		$lists = array();
		$condition = '';
        $catid = $mainframe->getUserStateFromRequest('amena_list.filter.catid','catid','-1');

        $filter_order 	 				= $jinput->getString('filter_order','ordering');
        $filter_order_Dir 				= $jinput->getString('filter_order_Dir','');
        $filter_full_ordering			= $jinput->getString('filter_full_ordering','ordering asc');
		$filter_Arr						= explode(" ",$filter_full_ordering);
		$filter_order					= $filter_Arr[0];
		$filter_order_Dir				= $filter_Arr[1];
		if($filter_order == ""){
			$filter_order = 'ordering';
		}
		if($filter_order != "category_id"){
			$filter_orders = "category_id ".$filter_order_Dir.",".$filter_order;
		}else{
			$filter_orders = $filter_order;
		}
		
		$lists['filter_order'] 			= $filter_order;
		$lists['filter_order_Dir']		= $filter_order_Dir;
		
		$limit = $jinput->getInt('limit',20);
		$limitstart = $jinput->getInt('limitstart',0);
		$keyword = $jinput->getString('keyword','');
		if($keyword != ""){
			$condition .= " AND (amenities LIKE '%$keyword%')";
		}
		if($catid > -1){
            $condition .= " AND category_id = '$catid'";
        }
		$count = "SELECT count(id) FROM #__osrs_amenities WHERE 1=1";
		$count .= $condition;
		$db->setQuery($count);
		$total = $db->loadResult();
		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total,$limitstart,$limit);
		
		$list  = "SELECT * FROM #__osrs_amenities WHERE 1=1 ";
		$list .= $condition;
		$list .= " ORDER BY $filter_orders $filter_order_Dir";
		$db->setQuery($list,$pageNav->limitstart,$pageNav->limit);
		$rows = $db->loadObjectList();

        $optionArr = array();
        $optionArr[] = JHTML::_('select.option','-1',JText::_('OS_SELECT_CATEGORIES'));
        $optionArr[] = JHTML::_('select.option',0,JText::_('OS_GENERAL_AMENITIES'));
        $optionArr[] = JHTML::_('select.option',1,JText::_('OS_ACCESSIBILITY_AMENITIES'));
        $optionArr[] = JHTML::_('select.option',2,JText::_('OS_APPLIANCE_AMENITIES'));
        $optionArr[] = JHTML::_('select.option',3,JText::_('OS_COMMUNITY_AMENITIES'));
        $optionArr[] = JHTML::_('select.option',4,JText::_('OS_ENERGY_SAVINGS_AMENITIES'));
        $optionArr[] = JHTML::_('select.option',5,JText::_('OS_EXTERIOR_AMENITIES'));
        $optionArr[] = JHTML::_('select.option',6,JText::_('OS_INTERIOR_AMENITIES'));
        $optionArr[] = JHTML::_('select.option',7,JText::_('OS_LANDSCAPE_AMENITIES'));
        $optionArr[] = JHTML::_('select.option',8,JText::_('OS_SECURITY_AMENITIES'));
        $lists['categories'] = JHtml::_('select.genericlist',$optionArr,'catid','class="input-large" onChange="javascript:document.adminForm.submit();"','value','text',$catid);

		HTML_OspropertyAmenities::amenities_list($option,$rows,$pageNav,$lists);
	}
	
	/**
	 * publish or unpublish amenitie
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 * @param unknown_type $state
	 */
	function amenities_change_publish($option,$cid,$state){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		if(count($cid)>0)	{
			$cids = implode(",",$cid);
			$db->setQuery("Update #__osrs_amenities SET `published` = '$state' WHERE id IN ($cids)");
			$db->query();
		}
		$msg = JText::_("OS_ITEM_STATUS_HAS_BEEN_CHANGED");
		$mainframe->redirect("index.php?option=$option&task=amenities_list",$msg);
	}
	
	/**
	 * remove amenitie
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 */
	function amenities_remove($option,$cid){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		if(count($cid)>0)	{
			$cids = implode(",",$cid);
			$db->setQuery("DELETE FROM #__osrs_amenities WHERE id IN ($cids)");
			$db->query();
		}
		$msg = JText::_("OS_ITEM_HAS_BEEN_DELETED");
		$mainframe->redirect("index.php?option=$option&task=amenities_list",$msg);
	}
	
	
	/**
	 * Amenitie Detail
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	function amenities_edit($option,$id){
		global $jinput, $mainframe,$languages;
		$db = JFactory::getDBO();
		$row = &JTable::getInstance('Amenities','OspropertyTable');
		if($id > 0){
			$row->load((int)$id);
		}else{
			$row->published = 1;
		}
		
		//$lists['state'] = JHTML::_('select.booleanlist', 'published', '', $row->published);
		$optionArr = array();
		$optionArr[] = JHTML::_('select.option',1,JText::_('OS_YES'));
		$optionArr[] = JHTML::_('select.option',0,JText::_('OS_NO'));
		$lists['state']   = JHTML::_('select.genericlist',$optionArr,'published','class="input-mini"','value','text',$row->published);
		$translatable = JLanguageMultilang::isEnabled() && count($languages);
		HTML_OspropertyAmenities::editHTML($option,$row,$lists,$translatable);
	}
	
	/**
	 * save Amenitie
	 *
	 * @param unknown_type $option
	 */
	function amenities_save($option,$save){
		global $jinput, $mainframe,$languages;
		$db = JFactory::getDBO();
		$post = $jinput->post->getArray();
		$row = &JTable::getInstance('Amenities','OspropertyTable');
		$row->bind($post);		 
		$row->check();
		$msg = JText::_('OS_ITEM_HAS_BEEN_SAVED'); 
	 	if (!$row->store()){
		 	$msg = JText::_('OS_ERROR_SAVING'); ;		 			 	
		}
		$id = $jinput->getInt('id',0);
		if($id == 0){
			$id = $db->insertID();
		}
		$translatable = JLanguageMultilang::isEnabled() && count($languages);
		if($translatable){
			foreach ($languages as $language) {	
				$sef = $language->sef;
				$amenities_language = $jinput->getString('amenities_'.$sef);
				if($amenities_language == ""){
					$amenities_language = $row->amenities;
					$row = &JTable::getInstance('Amenities','OspropertyTable');
					$row->id = $id;
					$row->{'amenities_'.$sef} = $amenities_language;
					$row->store();
				}
			}
		}
		if($save == 1){
			$mainframe->redirect("index.php?option=$option&task=amenities_list",$msg);
		}elseif($save == 2){
			$mainframe->redirect("index.php?option=$option&task=amenities_add",$msg);
		}else{
			$mainframe->redirect("index.php?option=$option&task=amenities_edit&cid[]=".$id,$msg);
		}
	}

	function saveorderAjax($option){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		$cid 	= $jinput->get( 'cid', array(), 'array' );
	
		$row = &JTable::getInstance('Amenities','OspropertyTable');
		
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
	 * Save order
	 *
	 * @param unknown_type $option
	 */
	function saveorder($option){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		$msg = JText::_( 'OS_ERROR_SAVING_ORDERING' );
		$cid 	= $jinput->get( 'cid', array(), 'array' );
	
		$row = &JTable::getInstance('Amenities','OspropertyTable');
		
		$groupings	= array();

		$order		= $jinput->get( 'order', array(), 'array' );

		// update ordering values
		for( $i=0; $i < count($cid); $i++ ) {
			$row->load( $cid[$i] );
			// track parents
			$groupings[] = $row->parent_id;
			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					return false;
				}
			} // if
		} // for

		// execute updateOrder for each parent group
		$groupings = array_unique( $groupings );
		foreach ($groupings as $group){
			$row->reorder(' parent_id = '.(int) $group.' AND published = 1');
		}
		
		$mainframe->redirect("index.php?option=com_osproperty&task=amenities_list",$msg);
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
			$mainframe->redirect('index.php?option=com_osproperty&task=amenities_list', JText::_('OS_NO_ITEM_SELECTED'));
			return false;
		}

		if (self::orderItem($id, -1)) {
			$msg = JText::_( 'OS_MENU_ITEM_MOVED_UP' );
		}
		
		$mainframe->redirect("index.php?option=com_osproperty&task=amenities_list",$msg);
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
			$mainframe->redirect('index.php?option=com_osproperty&task=amenities_list', JText::_('OS_NO_ITEM_SELECTED'));
			return false;
		}

		if (self::orderItem($id, 1)) {
			$msg = JText::_( 'OS_MENU_ITEM_MOVED_DOWN' );
		}
		
		$mainframe->redirect("index.php?option=com_osproperty&task=amenities_list",$msg);
	}
	
/**
	 * Order Item
	 *
	 * @param unknown_type $item
	 * @param unknown_type $movement
	 * @return unknown
	 */
	public static function orderItem($item, $movement){
		$row = &JTable::getInstance('Amenities','OspropertyTable');
		$row->load( $item );
		if (!$row->move( $movement, '')) {
			//$this->setError($row->getError());
			return false;
		}
		$row->reorder(' category_id = '.$row->category_id.' AND published = 1');
		return true;
	}
	
	public static function initOrdering()
	{
		$db = JFactory::getDbo();
		$db->setQuery("Select * from #__osrs_amenities where ordering = '0'");
		$amenities = $db->loadObjectList();
		if(count($amenities) > 0){
			foreach ($amenities as $amenity)
			{
				$db->setQuery("Select ordering from #__osrs_amenities order by ordering desc limit 1");
				$ordering = $db->loadResult();
				$ordering = $ordering + 1;
				$db->setQuery("Update #__osrs_amenities set ordering = '$ordering' where id = '$amenity->id'");
				$db->query();
			}
		}
	}
	
	public static function returnAmenityCategory($catid){
		switch ($catid) {
			case 0:
				return JText::_('OS_GENERAL_AMENITIES');
			break;
			case 1:
				return JText::_('OS_ACCESSIBILITY_AMENITIES');
			break;
			case 2:
				return JText::_('OS_APPLIANCE_AMENITIES');
			break;
			case 3:
				return JText::_('OS_COMMUNITY_AMENITIES');
			break;
			case 4:
				return JText::_('OS_ENERGY_SAVINGS_AMENITIES');
			break;
			case 5:
				return JText::_('OS_EXTERIOR_AMENITIES');
			break;
			case 6:
				return JText::_('OS_INTERIOR_AMENITIES');
			break;
			case 7:
				return JText::_('OS_LANDSCAPE_AMENITIES');
			break;
			case 8:
				return JText::_('OS_SECURITY_AMENITIES');
			break;
			default:
				return JText::_('OS_GENERAL_AMENITIES');
			break;
		}
	}
	
	public static function makeAmenityCategoryDropdown($catid){
		$optionArr = array();
		$optionArr[] = JHTML::_('select.option',0,JText::_('OS_GENERAL_AMENITIES'));
		$optionArr[] = JHTML::_('select.option',1,JText::_('OS_ACCESSIBILITY_AMENITIES'));
		$optionArr[] = JHTML::_('select.option',2,JText::_('OS_APPLIANCE_AMENITIES'));
		$optionArr[] = JHTML::_('select.option',3,JText::_('OS_COMMUNITY_AMENITIES'));
		$optionArr[] = JHTML::_('select.option',4,JText::_('OS_ENERGY_SAVINGS_AMENITIES'));
		$optionArr[] = JHTML::_('select.option',5,JText::_('OS_EXTERIOR_AMENITIES'));
		$optionArr[] = JHTML::_('select.option',6,JText::_('OS_INTERIOR_AMENITIES'));
		$optionArr[] = JHTML::_('select.option',7,JText::_('OS_LANDSCAPE_AMENITIES'));
		$optionArr[] = JHTML::_('select.option',8,JText::_('OS_SECURITY_AMENITIES'));
		return JHtml::_('select.genericlist',$optionArr,'category_id','class="input-medium chosen"','value','text',intval($catid));
	}
}
?>