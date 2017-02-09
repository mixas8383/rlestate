<?php
/*------------------------------------------------------------------------
# helper.php - mod_ospropertysearch
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2015 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/

defined('_JEXEC') or die('Restricted access');

class modOspropertySearchHelper
{
	public static function loadCity($option,$state_id,$city_id,$random_id,$show_labels){
		global $mainframe;
		$db = JFactory::getDBO();
		$cityArr = array();
		if($show_labels == 0){
			$cityArr[]= JHTML::_('select.option',0,JText::_('OS_CITY'));
		}else{
			$cityArr[]= JHTML::_('select.option',0,JText::_('OS_ANY'));
		}
		if($state_id > 0){
			$db->setQuery("Select id as value, city as text from #__osrs_cities where  published = '1' and state_id = '$state_id' order by city");
			$cities = $db->loadObjectList();
			$cityArr   = array_merge($cityArr,$cities);
			$disabled  = "";
		}else{
			$disabled  = "disabled";
		}
		return JHTML::_('select.genericlist',$cityArr,'city'.$random_id,'class="input-medium" '.$disabled,'value','text',$city_id);
	}
		
	static function listCategories($category_ids,$onChangeScript,$inputbox_width_site){
		global $mainframe;
        if($inputbox_width_site != ""){
            $width_style = "width: ".$inputbox_width_site."px !important;";
        }

        if(count($category_ids) == 0){
            $view = JRequest::getVar('view','');
            switch($view){
                case "ltype":
                    $category_ids = JRequest::getVar('catIds',array());
                break;
                case "lcity":
                    $menus = JSite::getMenu();
                    $menu = $menus->getActive();
                    if (is_object($menu)) {
                        $params = new JRegistry();
                        $params->loadString($menu->params);
                        $category_ids = $params->get('catIds', 0);
                    }
                break;
            }
        }

		$parentArr = self::loadCategoryOptions($onChangeScript);
        //print_r($parentArr);
		$output = JHTML::_('select.genericlist', $parentArr, 'category_ids[]', 'style="min-height:100px;'.$width_style.'" class="input-medium chosen" multiple '.$onChangeScript, 'value', 'text', $category_ids );
		return $output;
	}
	
	
	static function loadCategoryOptions($onChangeScript){
		global $mainframe;
		$db = JFactory::getDBO();
		$lang_suffix = OSPHelper::getFieldSuffix();
		// get a list of the menu items
		// excluding the current cat item and its child elements
		$query = 'SELECT *, category_name'.$lang_suffix.' AS title,category_name'.$lang_suffix.' as category_name,parent_id as parent ' .
				 ' FROM #__osrs_categories ' .
				 ' WHERE published = 1' ;
        $query .= ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
		$query.= ' ORDER BY parent_id, ordering';
		$db->setQuery( $query );
		$mitems = $db->loadObjectList();

		// establish the hierarchy of the menu
		$children = array();

		if ( $mitems )
		{
			// first pass - collect children
			foreach ( $mitems as $v )
			{
				$pt 	= $v->parent_id;
				$list 	= @$children[$pt] ? $children[$pt] : array();
				array_push( $list, $v );
				$children[$pt] = $list;
			}
		}

		// second pass - get an indent list of the items
		$list = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0 );
		// assemble menu items to the array
		$parentArr 	= array();
		
		foreach ( $list as $item ) {
			if($item->treename != ""){
				//$item->treename = str_replace("&nbsp;","",$item->treename);
			}
			$var = explode("-",$item->treename);
			$treename = "";
			for($i=0;$i<count($var)-1;$i++){
				$treename .= " - ";
			}
			$text = $item->treename;
			$parentArr[] = JHTML::_('select.option',  $item->id,$text);
		}
		return $parentArr;
	}
}
?>
