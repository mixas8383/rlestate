<?php
/*------------------------------------------------------------------------
# configuration.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

class JTextOs{
	function _($string){
		if ($string != ''){
			$string = str_replace(",","",$string);
			$string = str_replace(".","",$string);
			$string = str_replace("'","",$string);
			
			$string = str_replace(" - ","_",$string);
			$string = str_replace("-","_",$string);
			$string = str_replace(" ","_",$string);
			
			$string = str_replace("?","",$string);
			$string = str_replace("/","",$string);
			$string = str_replace("(","",$string);
			$string = str_replace(")","",$string);
			$string = strtoupper('OS_'.$string);
			
		}
		return JText::_($string);
	}
}


class OspropertyConfiguration{
	/**
	 * default function 
	 *
	 * @param unknown_type $option
	 * @param unknown_type $task
	 */
	function display($option,$task){
		global $mainframe;
		switch ($task){
			case "configuration_list":
				OspropertyConfiguration::configuration_list($option);
			break;
			case 'configuration_cancel':
				$mainframe->redirect("index.php?option=$option");
			break;	
			case "configuration_save":
				OspropertyConfiguration::configuration_save($option,$task);
			break;
			case "configuration_apply":
				OspropertyConfiguration::configuration_save($option,$task);
			break;
            case "configuration_help":
                OspropertyConfiguration::helpLayout($option,$task);
            break;
            case "configuration_connectfb":
				if (version_compare(phpversion(), '5.4.0', 'ge')) {
					OspropertyConfiguration::connectFb($option);
				}
            break;
			case "configuration_changecurrencystatus":
				OspropertyConfiguration::changecurrencystatus($option);
			break;
		}
	}
	
	/**
	 * configuration list
	 *
	 * @param unknown_type $option
	 */
	function configuration_list($option){
		global $mainframe;
		$db = JFactory::getDBO();
		$db->setQuery('SELECT * FROM #__osrs_configuration ');
		$configs = array();
		foreach ($db->loadObjectList() as $config) {
			$configs[$config->fieldname] = $config->fieldvalue;
		}

		$db->setQuery("Select * from #__osrs_currencies order by currency_name");
		$used_currencies = $db->loadObjectList();

		HTML_OspropertyConfiguration::configurationHTML($option,$configs,$used_currencies);
	}
	
	/**
	 * save configuation
	 *
	 * @param unknown_type $option
	 * @param unknown_type $task
	 */
	function configuration_save($option,$task){
		global $mainframe,$languages,$jinput;
		$db = JFactory::getDbo();
		
		$agentArr = array();
		$db->setQuery("Select user_id from #__osrs_agents");
		$agents = $db->loadOBjectList();
		if(count($agents) > 0){
			for($i=0;$i<count($agents);$i++){
				$agentArr[] = $agents[$i]->user_id;
			}
		}
		
		$configuration = $jinput->get('configuration',array(),'array');
		
		$agent_joomla_group_id = $configuration['agent_joomla_group_id'];
		$db->setQuery("Select fieldvalue from #__osrs_configuration where fieldname like 'agent_joomla_group_id'");
		$old_agent_joomla_group_id = $db->loadResult();
		if($old_agent_joomla_group_id != ""){
			if($old_agent_joomla_group_id != $agent_joomla_group_id){
				if(count($agentArr) > 0){
					$db->setQuery("Delete from #__user_usergroup_map where user_id in (".implode(",",$agentArr).") and group_id = '$old_agent_joomla_group_id'");
					$db->query();
				}
			}
		}
		if($agent_joomla_group_id != ""){
			for($i=0;$i<count($agentArr);$i++){
				$agent_id = $agentArr[$i];
				$db->setQuery("Select count(user_id) from #__user_usergroup_map where user_id = '$agent_id' and group_id = '$agent_joomla_group_id'");
				$count = $db->loadResult();
				if($count == 0){
					$db->setQuery("Insert into #__user_usergroup_map (user_id,group_id) values ('$agent_id','$agent_joomla_group_id')");
					$db->query();
				}
			}
		}
		
		$companyArr = array();
		$db->setQuery("Select user_id from #__osrs_companies");
		$companies = $db->loadOBjectList();
		if(count($companies) > 0){
			for($i=0;$i<count($companies);$i++){
				$companyArr[] = $companies[$i]->user_id;
			}
		}
		
		
		$company_joomla_group_id = $configuration['company_joomla_group_id'];
		$db->setQuery("Select fieldvalue from #__osrs_configuration where fieldname like 'company_joomla_group_id'");
		$old_company_joomla_group_id = $db->loadResult();
		if($old_company_joomla_group_id != ""){
			if($old_company_joomla_group_id != $company_joomla_group_id){
				if(count($companyArr) > 0){
					$db->setQuery("Delete from #__user_usergroup_map where user_id in (".implode(",",$companyArr).") and group_id = '$old_company_joomla_group_id'");
					$db->query();
				}
			}
		}
		if($company_joomla_group_id != ""){
			for($i=0;$i<count($companyArr);$i++){
				$company_id = $companyArr[$i];
				$db->setQuery("Select count(user_id) from #__user_usergroup_map where user_id = '$company_id' and group_id = '$company_joomla_group_id'");
				$count = $db->loadResult();
				if($count == 0){
					$db->setQuery("Insert into #__user_usergroup_map (user_id,group_id) values ('$company_id','$company_joomla_group_id')");
					$db->query();
				}
			}
		}

        $db->setQuery("Select * from #__osrs_types order by ordering");
        $property_types = $db->loadObjectList();
        for($i=0;$i<count($property_types);$i++) {
            $property_type = $property_types[$i];
            $type = $jinput->getInt('type'.$property_type->id,0);
            if($type == 1){
                $configuration['type'.$property_type->id] = 1;
            }else{
                $valueTemp = array();
                $valueTemp[] = 0;
                $min = $jinput->getInt('min'.$property_type->id,0);
                $max = $jinput->getInt('max'.$property_type->id,0);
                $step = $jinput->getInt('step'.$property_type->id,0);
                $valueTemp[] = $min;
                $valueTemp[] = $max;
                $valueTemp[] = $step;
                $value = implode("|",$valueTemp);
                $configuration['type'.$property_type->id] = $value;
            }
        }
		
		foreach ($configuration as $fieldname => $fieldvalue) {
			if (is_array($fieldvalue)) $fieldvalue = implode(',',$fieldvalue);
			$fieldvalue = addslashes($fieldvalue);
			$db->setQuery("SELECT count(id) FROM #__osrs_configuration WHERE `fieldname` = '$fieldname'");
			if ($db->loadResult()){
				$db->setQuery("UPDATE #__osrs_configuration SET `fieldvalue` = '$fieldvalue' WHERE `fieldname` = '$fieldname'");
				$db->query();
			}else{
				$db->setQuery("INSERT INTO #__osrs_configuration VALUES ('NULL','$fieldname','$fieldvalue')");
				$db->query();
			}
		}
		
		$show_top_menus_in = $jinput->get('show_top_menus_in',array(),'array');
	//	if(count($show_top_menus_in) > 0){
		$show_top_menus_in = implode("|",$show_top_menus_in);
		$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$show_top_menus_in' WHERE fieldname like 'show_top_menus_in'");
		$db->query();
		//}
		
		$db->setQuery("Select fieldvalue from #__osrs_configuration where fieldname like 'general_unpublished_days'");
		$default_currency = $db->loadResult();
		if(intval($default_currency) > 0){
			$db->setQuery("Update #__osrs_properties set curr = '$default_currency' where curr = '0'");
			$db->query();
		}
		
		//Upload watermark
		$remove_watermark_photo = $jinput->getInt('remove_watermark_photo',0);
		if(is_uploaded_file($_FILES['watermark_photo']['tmp_name'])){
			$filename    = $_FILES['watermark_photo']['name'];
			$filenameArr = explode(".",$filename);
			$ext         = $filenameArr[count($filenameArr)-1];
			$filename    = "ospwatermark.".$ext;
			move_uploaded_file($_FILES['watermark_photo']['tmp_name'],JPATH_ROOT.DS."images".DS.$filename);
			$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$filename' WHERE fieldname like 'watermark_photo'");
			$db->query();
		}elseif($remove_watermark_photo == 1){
			$filename 	 =  "";
			$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$filename' WHERE fieldname like 'watermark_photo'");
			$db->query();
		}
		
		$adv_type_ids = $jinput->get('adv_type_ids',array(),'ARRAY');
		if(count($adv_type_ids) > 0){
			if(in_array(0,$adv_type_ids)){
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '0' WHERE fieldname LIKE 'adv_type_ids'");
				$db->query();
			}else{
				$adv_type_ids1 = array();
				for($i=0;$i<count($adv_type_ids);$i++){
					if($adv_type_ids[$i] != 0){
						$adv_type_ids1[count($adv_type_ids1)] = $adv_type_ids[$i];
					}
				}
				$adv_type_ids = implode("|",$adv_type_ids1);
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$adv_type_ids' WHERE fieldname LIKE 'adv_type_ids'");
				$db->query();
			}
		}
		
		$locator_type_ids = $jinput->get('locator_type_ids',array(),'ARRAY');
        //print_r($locator_type_ids);die();
		if(count($locator_type_ids) > 0){
			if(in_array(0,$locator_type_ids)){
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '0' WHERE fieldname LIKE 'locator_type_ids'");
				$db->query();
			}else{
				$locator_type_ids1 = array();
				for($i=0;$i<count($locator_type_ids);$i++){
					if($locator_type_ids[$i] != 0){
						$locator_type_ids1[count($locator_type_ids1)] = $locator_type_ids[$i];
					}
				}
				$locator_type_ids = implode("|",$locator_type_ids1);
                //echo $locator_type_ids;die();
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$locator_type_ids' WHERE fieldname LIKE 'locator_type_ids'");
				$db->query();
			}
		}
		
		
		$show_date_search_in = $jinput->get('show_date_search_in',array(),'ARRAY');
		if(count($show_date_search_in) > 0){
			if(in_array(0,$show_date_search_in)){
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '0' WHERE fieldname LIKE 'show_date_search_in'");
				$db->query();
			}else{
				$show_date_search_in1 = array();
				for($i=0;$i<count($show_date_search_in);$i++){
					if($show_date_search_in[$i] != 0){
						$show_date_search_in1[count($show_date_search_in1)] = $show_date_search_in[$i];
					}
				}
				$show_date_search_in = implode("|",$show_date_search_in1);
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$show_date_search_in' WHERE fieldname LIKE 'show_date_search_in'");
				$db->query();
			}
		}
		
		$db->setQuery("Select count(id) from #__osrs_configuration where fieldname like 'sold_property_types'");
		$count_sold = $db->loadResult();
		if($count_sold == 0){
			$db->setQuery("Insert into #__osrs_configuration (id,fieldname) values (NULL,'sold_property_types');");
			$db->query();
		}
		$adv_type_ids = $jinput->get('sold_property_types',array(),'ARRAY');
		if(count($adv_type_ids) > 0){
			if(in_array(0,$adv_type_ids)){
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '0' WHERE fieldname LIKE 'sold_property_types'");
				$db->query();
			}else{
				$adv_type_ids1 = array();
				for($i=0;$i<count($adv_type_ids);$i++){
					if($adv_type_ids[$i] != 0){
						$adv_type_ids1[count($adv_type_ids1)] = $adv_type_ids[$i];
					}
				}
				$adv_type_ids = implode("|",$adv_type_ids1);
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$adv_type_ids' WHERE fieldname LIKE 'sold_property_types'");
				$db->query();
			}
		}else{
			$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '' WHERE fieldname LIKE 'sold_property_types'");
			$db->query();
		}
		
		$image_code = $jinput->getString('image_code','');
		if($image_code != ""){
			$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$image_code' WHERE fieldname LIKE 'image_background_color'");
			$db->query();
		}

		$enable_cardtypes = $jinput->get('enable_cardtypes',array(),'ARRAY');
		$enable_cardtypes  = implode(",",$enable_cardtypes);
		$db->setQuery("Select count(id) from #__osrs_configuration where fieldname like 'enable_cardtypes'");
		$count = $db->loadResult();
		if($count > 0){
			$db->setQuery("Update #__osrs_configuration set fieldvalue = '$enable_cardtypes' where fieldname like 'enable_cardtypes'");
			$db->query();
		}else{
			$db->setQuery("Insert into #__osrs_configuration (id,fieldname,fieldvalue) values (NULL,'enable_cardtypes','$enable_cardtypes')");
			$db->query();
		}

		if (isset($configuration['custom_css']))
		{
			JFile::write(JPATH_ROOT . '/media/com_osproperty/assets/css/custom.css', trim($configuration['custom_css']));
		}

		$msg = JText::_("OS_CONFIGURE_OPTION_HAVE_BEEN_SAVED");
		if ($task == 'configuration_save'){
			$mainframe->redirect("index.php?option=$option",$msg);
		}else{
			$mainframe->redirect("index.php?option=$option&task=configuration_list",$msg);
		}
	}

    /**
     * Return the configuration field checkboxes
     * @param $fieldname
     * @param $fieldvalue
     */
    public static function showCheckboxfield($fieldname,$fieldvalue,$option1='',$option2=''){
        if($option1 == ""){
            $option1 = JText::_('OS_YES');
        }
        if($option2 == ""){
            $option2 = JText::_('OS_NO');
        }
        if (version_compare(JVERSION, '3.0', 'lt')) {
            $optionArr = array();
            $optionArr[] = JHTML::_('select.option',1,$option1);
            $optionArr[] = JHTML::_('select.option',0,$option2);
            echo JHTML::_('select.genericlist',$optionArr,'configuration['.$fieldname.']','class="input-mini"','value','text',$fieldvalue);
        }else{
            $name = $fieldname;
            if(intval($fieldvalue) == 0){
                $checked2 = 'checked="checked"';
                $checked1 = "";
            }else{
                $checked1 = 'checked="checked"';
                $checked2 = "";
            }
            ?>
            <fieldset id="jform_params_<?php echo $name;?>" class="radio btn-group">
                <input type="radio" id="jform_params_<?php echo $name;?>0" name="configuration[<?php echo $name; ?>]" value="1" <?php echO $checked1;?>/>
                <label for="jform_params_<?php echo $name;?>0"><?php echo $option1;?></label>
                <input type="radio" id="jform_params_<?php echo $name;?>1" name="configuration[<?php echo $name; ?>]" value="0" <?php echO $checked2;?>/>
                <label for="jform_params_<?php echo $name;?>1"><?php echo $option2;?></label>
            </fieldset>
        <?php
        }
    }

    static function helpLayout($option,$task){
        JToolBarHelper::title(JText::_('JTOOLBAR_HELP'),"help");
        ?>
        <div class="row-fluid">
            <div class="span12" style="border:1px solid #DDD;padding:15px;border-radius:10px;-webkit-box-shadow: 6px 15px 26px -5px rgba(0,0,0,0.61);-moz-box-shadow: 6px 15px 26px -5px rgba(0,0,0,0.61);box-shadow: 6px 15px 26px -5px rgba(0,0,0,0.61);">
                OS Property official page: <a title="OS Property official page" href="http://joomdonation.com/joomla-extensions/os-property-joomla-real-estate.html" target="_blank">http://joomdonation.com/joomla-extensions/os-property-joomla-real-estate.html</a>
                <BR /><BR />
                Demo site: <a title="Demo site" href="http://osproperty.ext4joomla.com" target="_blank">http://osproperty.ext4joomla.com</a>
                <BR /><BR />
                Documentation: <a title="Documentation" href="http://osproperty.ext4joomla.com/OS_Property_Instructions.pdf" target="_blank">http://osproperty.ext4joomla.com/OS_Property_Instructions.pdf</a>
                <BR /><BR />
                If you have any questions regarding the OS Property, you can choose one of following ways to get the best supports:
                <BR />
                <ol>
                    <li>
                        Login to your account and
                        <a target="new" href="http://joomdonation.com/support-tickets.html">Submit a Support Ticket</a>
                    </li>
                    <li>
                        Leave questions on
                        <a target="new" href="http://joomdonation.com/forum/os-property.html">Forum</a>
                    </li>
                    <li>
                        Drop me an email to
                        <a href="mailto:damdt@joomservices.com">damdt@joomservices.com</a>
                    </li>
                    <li>
                        Contact me via Skype, YM or Gtalk for instant chat. You can find my contact information below:
                        <ul>
                            <li>Skype: thucdam84</li>
                            <li>YM: thucdam84@yahoo.com</li>
                            <li>Gtalk: thucdam84@gmail.com</li>
                        </ul>
                    </li>
                </ol>
            </div>
        </div>
        <BR /><BR />
    <?php
    }

	public function connectFb($option){
		$input = JFactory::getApplication()->input;
        $app_id = $input->get('app_id','','string');
        $app_secret = $input->get('app_secret','','string');
		include_once(JPATH_ROOT.'/components/com_osproperty/helpers/inc/osfacebook.php');
		OSPFacebook::fbConnect($app_id,$app_secret);
	}

	static function changecurrencystatus($option){
        global $jinput;
		$db = JFactory::getDbo();
		$id = $jinput->getInt('id',0);
		$status = $jinput->getInt('status',0);
		$db->setQuery("Update #__osrs_currencies set published = '$status' where id = '$id'");
		$db->query();
		if($status == 1){
			?>
			<a href="javascript:changePublishedStatus(0,<?php echo $id?>,'<?php echo JUri::base();?>')" title="<?php echo JText::_('OS_CLICK_HERE_TO_UNPUBLISH_CURRENCY');?>">
				<i class="icon-star" style="color:green !important;"></i>
			</a>
			
			<?php
		}else{
			?>
			
			<a href="javascript:changePublishedStatus(1,<?php echo $id?>,'<?php echo JUri::base();?>')" title="<?php echo JText::_('OS_CLICK_HERE_TO_PUBLISH_CURRENCY');?>">
				<i class="icon-star"  style="color:red !important;"></i>
			</a>
			
			<?php
		}
		exit();
	}
}
?>