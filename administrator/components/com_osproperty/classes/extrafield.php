<?php
/*------------------------------------------------------------------------
# extrafield.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

class OspropertyExtrafield{
	/**
	 * Default function
	 *
	 * @param unknown_type $option
	 */
	function display($option,$task){
		global $jinput, $mainframe;
		$cid = $jinput->get('cid',array(),'ARRAY');
		switch ($task){
			case "extrafield_list":
				OspropertyExtrafield::extrafield_list($option);
			break;
			case "extrafield_add":
				OspropertyExtrafield::extrafield_edit($option,0);
			break;
			case "extrafield_edit":
				OspropertyExtrafield::extrafield_edit($option,$cid[0]);
			break;
			case "extrafield_save":
				OspropertyExtrafield::save($option,1);
			break;
			case "extrafield_apply":
				OspropertyExtrafield::save($option,0);
			break;
			case "extrafield_new":
				OspropertyExtrafield::save($option,2);
			break;
			case "extrafield_changeType":
				OspropertyExtrafield::changeType($option,$cid[0]);
			break;
			case "extrafield_remove":
				OspropertyExtrafield::removeList($option,$cid);
			break;
			case "extrafield_publish":
				OspropertyExtrafield::changState($option,$cid,1);
			break;
			case "extrafield_unpublish":
				OspropertyExtrafield::changState($option,$cid,0);
			break;
			case "extrafield_saveorder":
				OspropertyExtrafield::saveorder($option);
			break;
			case "extrafield_saveorderAjax":
				OspropertyExtrafield::saveorderAjax($option);
			break;
			case "extrafield_gotolist":
				OspropertyExtrafield::gotolist($option);
			break;
			case "extrafield_addfieldoption":
				OspropertyExtrafield::savefieldoption($option);
			break;
			case "extrafield_removefieldoption":
				OspropertyExtrafield::removefieldoption($option);
			break;
			case "extrafield_savechangeoption":
				OspropertyExtrafield::saveChangeOption($option);
			break;
			case "extrafield_orderdown":
				OspropertyExtrafield::orderdown($option);
			break;
			case "extrafield_orderup":
				OspropertyExtrafield::orderup($option);
			break;
            case "extrafield_copy":
                OspropertyExtrafield::copyField($cid[0]);
            break;
		}
	}

	/**
	 * Extra field list
	 *
	 * @param unknown_type $option
	 */
	function extrafield_list($option){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();

        //Update access level to Public for all existing fields
        $db->setQuery("Update #__osrs_extra_fields set `access` = '1' where `access` = '0'");
        $db->query();

        $group_id						= $jinput->getInt('group_id',0);
        if($group_id == 0){
            $group_id						= $mainframe->getUserStateFromRequest('field_list.filter.group_id','group_id',0);
        }

        $filter_order					= $jinput->getString('filter_order','');
        $filter_order_Dir				= $jinput->getString('filter_order_Dir','');
        $filter_full_ordering			= $jinput->getString('filter_full_ordering','a.ordering asc');
		$filter_Arr						= explode(" ",$filter_full_ordering);
		$filter_order					= $filter_Arr[0];
		$filter_order_Dir				= $filter_Arr[1];
		$lists['filter_order']			= $filter_order;
		$lists['filter_order_Dir']		= $filter_order_Dir;

		$db->setQuery("Select * from #__osrs_extra_fields");
		$rows = $db->loadObjectList();
		if(count($rows) > 0){
			for($i=0;$i<count($rows);$i++){
				$row = $rows[$i];
				switch ($row->field_type){
					case "radio":
					case "singleselect":
					case "multipleselect":
					case "checkbox":
						$db->setQuery("Select count(id) from #__osrs_extra_field_options where field_id = '$row->id'");
						$count = $db->loadResult();
						if(($count == 0) and ($row->options != "")){
							HelperOspropertyFields::saveNewOption($row->options,$row->id);
						}
					break;
				}
			}
		}

        //property types
        $pro_type = $jinput->getInt('pro_type',0);
        $typeArr[] = JHTML::_('select.option','',JText::_('OS_ALL_PROPERTY_TYPES'));
        $db->setQuery("Select id as value,type_name as text from #__osrs_types where published = '1' $id_in_types order by type_name");
        $protypes = $db->loadObjectList();
        $typeArr   = array_merge($typeArr,$protypes);
        $lists['type'] = JHTML::_('select.genericlist',$typeArr,'pro_type','class="chosen input-large" onChange="javascript:document.adminForm.submit();"','value','text',$pro_type);

        $fieldtype = $jinput->getString('fieldtype','');
        $typeArr = array();
        $typeArr[] = Jhtml::_('select.option','',JText::_('OS_SELECT_FIELD_TYPE'));
        $typeArr[] = JHTML::_('select.option','text',JText::_('Text Field'));
        $typeArr[] = JHTML::_('select.option','textarea',JText::_('Text Area Field'));
        $typeArr[] = JHTML::_('select.option','singleselect',JText::_('Single Select list'));
        $typeArr[] = JHTML::_('select.option','multipleselect',JText::_('Multiple Select list'));
        $typeArr[] = JHTML::_('select.option','checkbox',JText::_('Checkbox'));
        $typeArr[] = JHTML::_('select.option','radio',JText::_('Radio button'));
        $typeArr[] = JHTML::_('select.option','date',JText::_('Date'));
        $lists['fieldtype'] = Jhtml::_('select.genericlist',$typeArr,'fieldtype','class="chosen input-large" onChange="javascript:document.adminForm.submit();"','value','text',$fieldtype);

        $groupArr[] = JHTML::_('select.option','',Jtext::_('OS_SELECT_FIELD_GROUP'));
        $db->setQuery("Select id as value, group_name as text from #__osrs_fieldgroups where published = '1' order by group_name");
        $groups = $db->loadObjectList();
        $groupArr = array_merge($groupArr,$groups);
        $lists['group'] = JHTML::_('select.genericlist',$groupArr,'group_id','class="chosen input-medium" onChange="document.adminForm.submit();"','value','text',$group_id);

		$limit = $jinput->getInt('limit',20);
		$limitstart = $jinput->getInt('limitstart',0);
		$keyword = $jinput->getString('keyword','');


		$mainframe->setUserState('field_list.filter.group_id',$group_id);
		
		$query = "Select count(id) from #__osrs_extra_fields where 1=1";
		if($keyword != ""){
			$query .= " and (field_name like '%$keyword%' or field_label like '%$keyword%' or field_description like '%$keyword%' or options like '%$keyword%' or default_value like '%$keyword%')";
		}
        if($fieldtype != ""){
            $query .= " and field_type like '$fieldtype'";
        }
		if($group_id > 0){
			$query .= " and group_id = '$group_id'";
		}
        if($pro_type > 0){
            $query .= " and id in (Select fid from #__osrs_extra_field_types where type_id = '$pro_type')";
        }
		$db->setQuery($query);
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		
		$pageNav = new JPagination($total,$limitstart,$limit);
		
		$query = "Select a.*,b.group_name from #__osrs_extra_fields as a "
				." inner join #__osrs_fieldgroups as b on b.id = a.group_id";
		if($keyword != ""){
			$query .= " and (a.field_name like '%$keyword%' or a.field_label like '%$keyword%' or a.field_description like '%$keyword%' or a.options like '%$keyword%' or a.default_value like '%$keyword%')";
		}
        if($fieldtype != ""){
            $query .= " and a.field_type like '$fieldtype'";
        }
		if($group_id > 0){
			$query .= " and a.group_id = '$group_id'";
		}
        if($pro_type > 0){
            $query .= " and a.id in (Select fid from #__osrs_extra_field_types where type_id = '$pro_type')";
        }
		if($filter_order == ""){
			$query .= " order by b.group_name, a.ordering";
		}else{
			$query .= " order by b.group_name, $filter_order $filter_order_Dir";
		}
		$db->setQuery($query,$pageNav->limitstart,$pageNav->limit);
		$rows = $db->loadObjectList();
		
		if(count($rows) > 0) {
            foreach ($rows as $row) {
                $query = $db->getQuery(true);
                $query
                    ->select("b.id,b.type_name")
                    ->from($db->quoteName("#__osrs_extra_field_types", "a"))
                    ->join('inner', $db->quoteName('#__osrs_types', 'b') . ' ON (' . $db->quoteName('a.type_id') . ' = ' . $db->quoteName('b.id') . ')')
                    ->where("a.fid = '$row->id'")
                    ->order('b.type_name', 'asc');
                $db->setQuery($query);
                $typeLists = $db->loadObjectList();
                if (count($typeLists) > 0) {
                    $temp = array();
                    foreach($typeLists as $type){
                        if($type->id == $pro_type){
                            $temp[] = "<strong>".$type->type_name."</strong>";
                        }else{
                            $temp[] = $type->type_name;
                        }
                    }
                    $row->typeLists = implode(", ", $temp);
                } else {
                    $row->typeLists = "N/A";
                }
            }
        }
		
		HTML_OspropertyExtrafield::extrafield_list($option,$rows,$pageNav,$lists);
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
				'index.php?option=com_osproperty&task=extrafield_list',
				JText::_('OS_NO_ITEM_SELECTED')
			);
			return false;
		}

		if (OspropertyExtrafield::orderItem($id, 1)) {
			$msg = JText::_( 'OS_MENU_ITEM_MOVED_DOWN' );
		}
		$mainframe->redirect("index.php?option=com_osproperty&task=extrafield_list",$msg);
	}


	
	/**
	 * Order down
	 *
	 * @param unknown_type $option
	 */
	function orderup($option){
		global $jinput, $mainframe,$_jversion;
		$cid	= $jinput->get( 'cid', array(), 'array' );

		if (isset($cid[0]) && $cid[0]) {
			$id = $cid[0];
		} else {
			$this->setRedirect(
				'index.php?option=com_osproperty&task=extrafield_list',
				JText::_('OS_NO_ITEM_SELECTED')
			);
			return false;
		}

		if (OspropertyExtrafield::orderItem($id, -1)) {
			$msg = JText::_( 'OS_MENU_ITEM_MOVED_DOWN' );
		}
		
		$mainframe->redirect("index.php?option=com_osproperty&task=extrafield_list",$msg);
	}
	
	/**
	 * Order Item
	 *
	 * @param unknown_type $item
	 * @param unknown_type $movement
	 * @return unknown
	 */
	function orderItem($item, $movement){
		$row = &JTable::getInstance('Extrafield','OspropertyTable');
		$row->load( $item );
		if (!$row->move( $movement, ' group_id = '.(int) $row->group_id )) {
			$this->setError($row->getError());
			return false;
		}
		$row->reorder(' group_id = '.$row->group_id.' AND published = 1');
		return true;
	}
	
	
	/**
	 * Extra field list
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	function extrafield_edit($option,$id){
		global $jinput, $mainframe,$languages;
		$db = JFactory::getDBO();
		$row = &JTable::getInstance('Extrafield','OspropertyTable');
		if($id > 0){
			$row->load((int)$id);
			$query = $db->getQuery(true);
			$query->select("type_id");
			$query->from("#__osrs_extra_field_types");
			$query->where("fid = '$id'");
			$db->setQuery($query);
			$typeList = $db->loadColumn(0);
		}else{
			$row->published = 1;
            $row->access = 0;
            $row->readonly = 0;
            $row->required = 0;
            $row->show_on_list = 0;
		}
		
		$optionArr 						= array();
		$optionArr[] 					= JHTML::_('select.option',1,JText::_('OS_YES'));
		$optionArr[] 					= JHTML::_('select.option',0,JText::_('OS_NO'));
		$lists['state']   				= JHTML::_('select.genericlist',$optionArr,'published','class="input-mini"','value','text',$row->published);
		
		$lists['searchable']   			= JHTML::_('select.genericlist',$optionArr,'searchable','class="input-mini"','value','text',$row->searchable);
		$lists['readonly']   			= JHTML::_('select.genericlist',$optionArr,'readonly','class="input-mini"','value','text',$row->readonly);
		$lists['required']   			= JHTML::_('select.genericlist',$optionArr,'required','class="input-mini"','value','text',$row->required);
		$lists['show_description']   	= JHTML::_('select.genericlist',$optionArr,'show_description','class="input-mini"','value','text',$row->show_description);
		$lists['show_on_list']   	= JHTML::_('select.genericlist',$optionArr,'show_on_list','class="input-mini"','value','text',$row->show_on_list);
	
		$typeArr[] = JHTML::_('select.option','text',JText::_('Text Field'));
		$typeArr[] = JHTML::_('select.option','textarea',JText::_('Text Area Field'));
		$typeArr[] = JHTML::_('select.option','singleselect',JText::_('Single Select list'));
		$typeArr[] = JHTML::_('select.option','multipleselect',JText::_('Multiple Select list'));
		$typeArr[] = JHTML::_('select.option','checkbox',JText::_('Checkbox'));
		$typeArr[] = JHTML::_('select.option','radio',JText::_('Radio button'));
		$typeArr[] = JHTML::_('select.option','date',JText::_('Date'));
		$lists['field_type'] = JHTML::_('select.genericlist',$typeArr,'field_type','class="input-medium" onChange="javascript:showDiv()"','value','text',$row->field_type);
		
		$groupArr[] = JHTML::_('select.option','','Select field group');
		$db->setQuery("Select id as value, group_name as text from #__osrs_fieldgroups where published = '1' order by group_name");
		$groups = $db->loadObjectList();
		$groupArr = array_merge($groupArr,$groups);
		$lists['group'] = JHTML::_('select.genericlist',$groupArr,'group_id','class="input-medium required"','value','text',$row->group_id);

        $lists['access'] = OSPHelper::accessDropdown('access',$row->access);

        $displayArr = array();
        $displayArr[] = Jhtml::_('select.option','1',JText::_('OS_TITLE').": ".JText::_('OS_VALUE'));
        $displayArr[] = Jhtml::_('select.option','2',JText::_('OS_TITLE'));
        $displayArr[] = Jhtml::_('select.option','3',JText::_('OS_VALUE'));
        $lists['displaytitle'] = JHTML::_('select.genericlist',$displayArr,'displaytitle','class="input-medium"','value','text',$row->displaytitle);
		//only for update new version case
		switch ($row->field_type){
			case "radio":
			case "singleselect":
			case "multipleselect":
			case "checkbox":
				$db->setQuery("Select count(id) from #__osrs_extra_field_options where field_id = '$row->id'");
				$count = $db->loadResult();
				if(($count == 0) and ($row->options != "")){
					HelperOspropertyFields::saveNewOption($row->options,$row->id);
				}
			break;
		}
		
		$db->setQuery("Select id as value, type_name as text from #__osrs_types order by type_name");
		$types = $db->loadObjectList();
		$lists['type'] = JHtml::_('select.genericlist',$types,'type_id[]',' class="required" style="height:150px;" multiple','value','text',$typeList);
		
		
		$translatable = JLanguageMultilang::isEnabled() && count($languages);
		HTML_OspropertyExtrafield::editHTML($option,$row,$lists,$translatable);
	}
	
	
	function gotolist($option){
		global $jinput, $mainframe;
		$mainframe->redirect("index.php?option=com_osproperty&task=extrafield_list");
	}
	
	
	/**
	 * Save function
	 *
	 * @param unknown_type $option
	 * @param unknown_type $save
	 */
	function save($option,$save){
		global $jinput, $mainframe,$languages;
		$db = JFactory::getDbo();
		
		
		
		$row = &JTable::getInstance('Extrafield','OspropertyTable');
		$post = $jinput->post->getArray();
		$row->bind($post);
		
		$id = $jinput->getInt('id',0);
		if($id == 0){
			//get the ordering
			$db->setQuery("Select ordering from #__osrs_extra_fields where group_id = '$row->group_id' order by ordering desc limit 1");
			$ordering = $db->loadResult();
			$row->ordering = (int)$ordering + 1;
		}
		//field name
		$row->field_name = strtolower($row->field_name);
		$blackCharArr = array(" ","|",".",",","'","-","?",":");
		foreach ($blackCharArr as $blackchar){
			$row->field_name = str_replace($blackchar,"",$row->field_name);
		}
		$blacknameArr = array('task','view','id','cid','list_id','category_id','pro_type','nbath','nbed','price','state_id','country_id','city','nfloors','nroom','lot_size','living_areas','garage_description','built_on','remodeled_on','house_style','house_construction','exterior_finish','roof','flooring','floor_area_lower','floor_area_main_level','floor_area_upper','floor_area_total','basement_foundation','basement_size','percent_finished','subdivision','land_holding_type','total_acres','lot_dimensions','frontpage','depth','takings','returns','net_profit','business_type','stock','fixtures','fittings','percent_office','percent_warehouse','loading_facilities','fencing','rainfall','soil_type','grazing','cropping','irrigation','water_resources','carrying_capacity','storage');
		if(in_array($row->field_name,$blacknameArr)){
			$row->field_name = "var_".$row->field_name;
		}
		if($id == 0){
			//new field
			$row->field_name = str_replace(" ","_",$row->field_name);
			$db->setQuery("Select count(id) from #__osrs_extra_fields where field_name like '$row->field_name'");
			$count = $db->loadResult();
			if($count > 0){
				$row->field_name = $row->field_name.$count;
			}
		}else{
			$db->setQuery("select count(id) from #__osrs_extra_fields where field_name like '$row->field_name' and id= '$id'");
			$count = $db->loadResult();
			if($count == 0){
				//name has been changed. Update new one
				$db->setQuery("Select count(id) from #__osrs_extra_fields where field_name like '$row->field_name'");
				$count = $db->loadResult();
				if($count > 0){
					$row->field_name = $row->field_name.$count;
				}
			}
		}
		
		//update other information
		$field_type = $jinput->getString('field_type','');
		switch ($field_type){
			case "singleselect":
			case "multipleselect":
				$row->size = $jinput->getString('select_size','');
				$row->options = "";
			break;
			case "checkbox":
			case "radio":
				$row->options = "";
			break;
			case "text":
			case "date":
				$row->size = $jinput->getString('text_size','');
				$row->maxlength = $jinput->getString('maxlength','');
			break;
			case "textarea":
				$row->ncols = $jinput->get('ncols','');
				$row->nrows = $jinput->get('nrows','');
			break;
		}
		$row->store();
		if($id == 0){
			$id = $db->insertID();
			$isNew = 1;
		}else{
			$isNew = 0;
		}
		
		$query = $db->getQuery(true);
		$query->delete("#__osrs_extra_field_types");
		$query->where("fid = '$id'");
		$db->setQuery($query);
		$db->execute();
		
		$columns = array('id','fid','type_id');
		$values  = array();
		$type_id = $jinput->get('type_id',array(),'ARRAY');
		if(count($type_id) > 0){
			for($i=0;$i<count($type_id);$i++){
				$tid = $type_id[$i];
				$query = $db->getQuery(true);
				$query
					    ->insert($db->quoteName('#__osrs_extra_field_types'))
					    ->columns($db->quoteName($columns))
					    ->values("NULL,$id,$tid");
				$db->setQuery($query);
				$db->execute();
			}
		}
		
		$translatable = JLanguageMultilang::isEnabled() && count($languages);
		if($translatable){
			foreach ($languages as $language){
				$sef = $language->sef;
				$field_label_language 					= $jinput->getString('field_label_'.$sef,'');
				$field_description_language 			= $_POST['field_description_'.$sef];
				if($field_label_language == ""){
					$field_label_language 				= $row->field_label;
					if($field_label_language != ""){
						$field 								= &JTable::getInstance('Extrafield','OspropertyTable');
						$field->id 							= $id;
						$field->access						= $row->access;
						$field->value_type				 	= $row->value_type;
						$field->{'field_label_'.$sef} 		= $field_label_language;
						$field->store();
					}
				}
				if($field_description_language == ""){
					$field_description_language 		= $row->field_description;
					if($field_description_language != ""){
						$field 								= &JTable::getInstance('Extrafield','OspropertyTable');
						$field->id 							= $id;
						$field->access						= $row->access;
						$field->value_type				 	= $row->value_type;
						$field->{'field_description_'.$sef} = $field_description_language;
						$field->store();
					}
				}
			}
		}
		
		
		if($isNew == 1){
			switch ($field_type){
				case "singleselect":
				case "multipleselect":
					$options = $jinput->getString('select_options','');
					HelperOspropertyFields::saveNewOption($options,$id);
				break;
				case "checkbox":
				case "radio":
					$options = $jinput->getString('checkbox_options','');
					HelperOspropertyFields::saveNewOption($options,$id);
				break;
			}
		}
		
		$msg = JText::_('OS_ITEM_SAVED');
		if($save == 1){
			$mainframe->redirect("index.php?option=com_osproperty&task=extrafield_list",$msg);
		}elseif($save == 2){
			$mainframe->redirect("index.php?option=com_osproperty&task=extrafield_add",$msg);
		}else{
			$mainframe->redirect("index.php?option=com_osproperty&task=extrafield_edit&cid[]=$id",$msg);
		}
	}
	
	/**
	 * Change other information type
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	function changeType($option,$id){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		$type  = $jinput->getString('type','');
		$value = $jinput->getString('v','');
		$db->setQuery("Update #__osrs_extra_fields set $type = '$value' where id = '$id'");
		$db->query();
		$first_letter = substr($type,0,1);
		$remain_letters = substr($type,1);
		$type = strtoupper($first_letter).$remain_letters;
		$msg = $type." ".JText::_('OS_STATUS_CHANGED');
		$mainframe->redirect("index.php?option=com_osproperty&task=extrafield_list",$msg);
	}
	
	/**
	 * Change status of the extra field(s)
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
			$db->setQuery("Update #__osrs_extra_fields set published = '$state' where id in ($cids)");
			$db->query();
		}
		$msg = JText::_("OS_ITEM_STATUS_HAS_BEEN_CHANGED");
		$mainframe->redirect("index.php?option=com_osproperty&task=extrafield_list",$msg);
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
		$order 	= $jinput->get( 'order', array(), 'array' );
		
		$row = &JTable::getInstance('Extrafield','OspropertyTable');
		// update ordering values
		for( $i=0; $i < count($cid); $i++ ){
			$row->load( (int) $cid[$i] );
			$groupings[] = $row->group_id;
			if ($row->ordering != $order[$i]){
				$row->ordering = $order[$i];
				if (!$row->store()) {
					return false;
				}
			}
		}
		
		$groupings = array_unique( $groupings );
		foreach ($groupings as $group){
			$row->reorder(' AND published = 1');
		}
		// execute updateOrder
		$mainframe->redirect("index.php?option=com_osproperty&task=extrafield_list",$msg);
	}

	function saveorderAjax($option){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		$cid 	= $jinput->get( 'cid', array(), 'array' );
		$order 	= $jinput->get( 'order', array(), 'array' );
		
		$row = &JTable::getInstance('Extrafield','OspropertyTable');
		// update ordering values
		for( $i=0; $i < count($cid); $i++ ){
			$row->load( (int) $cid[$i] );
			$groupings[] = $row->group_id;
			if ($row->ordering != $order[$i]){
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$msg = $db->getErrorMsg();
					return false;
				}
			}
		}
		
		$groupings = array_unique( $groupings );
		foreach ($groupings as $group){
			$row->reorder(' group_id = '.(int) $group.' AND published = 1');
		}
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
		$row = &JTable::getInstance('Extrafield','OspropertyTable');
		
		if (!$row->load($id)) {
			$msg = $db->getErrorMsg();
		}
		if (!$row->move( $direction)) {
			$msg = $db->getErrorMsg();
		}
		
		$msg = JText::_("OS_NEW_ORDERING_SAVED");		
		$mainframe->redirect("index.php?option=com_osproperty&task=extrafield_list",$msg);
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
			$db->setQuery("Delete from #__osrs_extra_fields where id in ($cids)");
			$db->query();
			
			$db->setQuery("Delete from #__osrs_extra_field_options where field_id in ($cids)");
			$db->query();
		}
		$msg = JText::_('OS_ITEM_HAS_BEEN_DELETED');
		$mainframe->redirect("index.php?option=com_osproperty&task=extrafield_list",$msg);
	}
	
	/**
	 * Save field option
	 *
	 * @param unknown_type $option
	 */
	function savefieldoption($option){
		global $jinput, $mainframe,$languages;
		$db = JFactory::getDbo();
		$fid = $jinput->getInt('fid',0);
		$value = $jinput->getString('value','');
		$value = addslashes($value);
		$value = str_replace("@plus@","+",$value);
		
		$translatable = JLanguageMultilang::isEnabled() && count($languages);
		$default_language = OSPHelper::getDefaultLanguage();
		$default_language = substr($default_language,0,2);
		
		$db->setQuery("Select ordering from #__osrs_extra_field_options where field_id = '$fid' order by ordering desc limit 1");
		$ordering = $db->loadResult();
		$ordering = intval($ordering) + 1;
		
		$valueArr = explode("||",$value);
		if(count($valueArr) > 0){
			for($i=0;$i<count($valueArr);$i++){
				$tempvalue = $valueArr[$i];
				$tempvalue = explode("@@",$tempvalue);
				$lang = $tempvalue[0];
				$value = $tempvalue[1];
				if($lang == $default_language){
					$db->setQuery("INSERT INTO #__osrs_extra_field_options (id,field_id,field_option,ordering) VALUES (NULL,'$fid','$value','$ordering')");
					$db->query();
					$option_id = $db->insertID();
				}
			}
			
			for($i=0;$i<count($valueArr);$i++){
				$tempvalue = $valueArr[$i];
				$tempvalue = explode("@@",$tempvalue);
				$lang = $tempvalue[0];
				$value = $tempvalue[1];
				if($lang != $default_language){
					$db->setQuery("UPDATE #__osrs_extra_field_options set field_option_".$lang." = '$value' where id = '$option_id'");
					$db->query();
				}
			}
		}
	
		
		$div_name = $jinput->getString('div_name','');
		$type = $jinput->getString('type','');
		HelperOspropertyFields::manageFieldOptions($fid,$div_name,$type);
	}
	
	function removefieldoption($option){
		global $jinput, $mainframe;
		$db = JFactory::getDbo();
		$fid = $jinput->getInt('fid',0);
		$oid = $jinput->getInt('oid',0);
		$db->setQuery("DELETE FROM #__osrs_extra_field_options WHERE id = '$oid'");
		$db->query();
		$div_name = $jinput->getString('div_name','');
		$type = $jinput->getString('type','');
		HelperOspropertyFields::manageFieldOptions($fid,$div_name,$type);
	}
	
	function saveChangeOption($option){
        global $jinput,$languages;
		$db = JFactory::getDbo();
		$fid = $jinput->getInt('fid',0);
		$oid = $jinput->getInt('oid',0);
		$value = $jinput->getString('value','');
		$value = addslashes($value);
		$value = str_replace("@plus@","+",$value);
		$ordering = $jinput->getString('ordering',0);
		
		$translatable = JLanguageMultilang::isEnabled() && count($languages);
		$default_language = OSPHelper::getDefaultLanguage();
		$default_language = substr($default_language,0,2);
	
		$valueArr = explode("||",$value);
		if(count($valueArr) > 0){
			for($i=0;$i<count($valueArr);$i++){
				$tempvalue = $valueArr[$i];
				$tempvalue = explode("@@",$tempvalue);
				$lang = $tempvalue[0];
				$value = $tempvalue[1];
				if($lang == $default_language){
					$db->setQuery("UPDATE #__osrs_extra_field_options SET field_option = '$value' where id = '$oid'");
					$db->query();
					$option_id = $db->insertID();
				}
			}
			
			for($i=0;$i<count($valueArr);$i++){
				$tempvalue = $valueArr[$i];
				$tempvalue = explode("@@",$tempvalue);
				$lang = $tempvalue[0];
				$value = $tempvalue[1];
				if($lang != $default_language){
					$db->setQuery("UPDATE #__osrs_extra_field_options set field_option_".$lang." = '$value' where id = '$oid'");
					$db->query();
				}
			}
		}
		
		$db->setQuery("UPDATE #__osrs_extra_field_options SET ordering = '$ordering' where id = '$oid'");
		$db->query();
		$div_name = $jinput->getString('div_name','');
		$type = $jinput->getString('type','');
		HelperOspropertyFields::manageFieldOptions($fid,$div_name,$type);
	}

    /**
     * @param $id
     * Copy field
     */
    function copyField($id){
        global $jinput, $mainframe;
        $db = Jfactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')->from('#__osrs_extra_fields')->where("id='$id'");
        $db->setQuery($query);
        $field = $db->loadObject();

        $newfield = &JTable::getInstance('Extrafield','OspropertyTable');
        $cols = array_keys($db->getTableColumns('#__osrs_extra_fields'));
        foreach($cols as $col){
            $newfield->{$col}  = $field->{$col};
        }
        $newfield->id = 0;
        $newfield->store();

        $newfield_id = $db->insertid();
        $ordering = (int)$field->ordering++;
        $db->setQuery("Update #__osrs_extra_fields set `field_name` = '".$field->field_name."_".$newfield_id."',`field_label` = '".JText::_('OS_COPY')." ".$field->field_label."',`ordering` = '$ordering' where id = '$newfield_id'");
        $db->query();

        //field types
        $query = $db->getQuery(true);
        $query->select('type_id')->from('#__osrs_extra_field_types')->where("fid='$id'");
        $db->setQuery($query);
        $types = $db->loadObjectList();

        if(count($types) > 0){
            foreach($types as $type){
                $db->setQuery("Insert into #__osrs_extra_field_types (id,fid,type_id) values (NULL,'$newfield_id','$type->type_id')");
                $db->query();
            }
        }

        //field options
        $query = $db->getQuery(true);
        $query->select('*')->from('#__osrs_extra_field_options')->where("field_id = '$id'");
        $db->setQuery($query);
        $fieldoptions = $db->loadObjectList();

        $newfieldoption = &JTable::getInstance('Fieldoption','OspropertyTable');
        $cols = array_keys($db->getTableColumns('#__osrs_extra_field_options'));
        foreach($cols as $col){
            $newfieldoption->{$col}  = $fieldoptions->{$col};
        }
        $newfieldoption->id = 0;
        $newfieldoption->field_id = $newfield_id;
        $newfieldoption->store();

        $msg = JText::_('OS_FIELD_HAS_BEEN_DUPLICATED');
        $mainframe->redirect("index.php?option=com_osproperty&task=extrafield_list",$msg);
    }
}
?>