<?php
/*------------------------------------------------------------------------
# admin.osproperty.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2010 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

error_reporting(E_CORE_ERROR | E_ERROR | E_PARSE | E_USER_ERROR | E_COMPILE_ERROR);
define('DS', DIRECTORY_SEPARATOR);
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

jimport('joomla.filesystem.folder');
//Include files from classes folder
$dir = JFolder::files(JPATH_COMPONENT_ADMINISTRATOR.DS."classes");
if(count($dir) > 0){
	for($i=0;$i<count($dir);$i++){
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS."classes".DS.$dir[$i]);
	}
}

//Include files from helpers folder
$dir = JFolder::files(JPATH_COMPONENT_ADMINISTRATOR.DS."helpers");
if(count($dir) > 0){
	for($i=0;$i<count($dir);$i++){
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS."helpers".DS.$dir[$i]);
	}
}

include_once(JPATH_ROOT.DS."components".DS."com_osproperty".DS."helpers".DS."libraries".DS."libraries.php");
include_once(JPATH_ROOT.DS."components".DS."com_osproperty".DS."helpers".DS."helper.php");
OSLibraries::checkMembership();
OSPHelper::chosen();

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root()."components/com_osproperty/style/backend_style.css");
$document->addScript(JURI::root()."components/com_osproperty/js/ajax.js");
$document->addScript(JURI::root()."components/com_osproperty/js/lib.js");
//JRequest::setVar('hidemainmenu',1);

global $_jversion,$configs,$mainframe,$languages,$jinput;
$jinput = JFactory::getApplication()->input;
$languages = OSPHelper::getLanguages();
$db = JFactory::getDBO();
$db->setQuery("select * from #__osrs_configuration");
$configs = $db->loadOBjectList();

$version = new JVersion();
$current_joomla_version = $version->getShortVersion();
$three_first_char = substr($current_joomla_version,0,3);
$mainframe = JFactory::getApplication();

$user = JFactory::getUser();

global $langArr;

$langArr[0]->country_id = 12;
$langArr[0]->file_name = "au_australia.txt";

$langArr[1]->country_id = 28;
$langArr[1]->file_name = "br_brazil.txt";

$langArr[2]->country_id = 35;
$langArr[2]->file_name = "ca_canada.txt";

$langArr[3]->country_id = 169;
$langArr[3]->file_name = "es_spain.txt";

$langArr[4]->country_id = 66;
$langArr[4]->file_name = "fr_france.txt";

$langArr[5]->country_id = 193;
$langArr[5]->file_name = "gb_united.txt";

$langArr[6]->country_id = 86;
$langArr[6]->file_name = "in_india.txt";

$langArr[7]->country_id = 92;
$langArr[7]->file_name = "it_italy.txt";

$langArr[8]->country_id = 130;
$langArr[8]->file_name = "nl_netherlands.txt";

$langArr[9]->country_id = 147;
$langArr[9]->file_name = "pt_portugal.txt";

$langArr[10]->country_id = 187;
$langArr[10]->file_name = "tr_turkey.txt";

$langArr[11]->country_id = 152;
$langArr[11]->file_name = "ru_russia.txt";

$langArr[12]->country_id = 162;
$langArr[12]->file_name = "sg_singapore.txt";

$langArr[13]->country_id = 175;
$langArr[13]->file_name = "se_sweden.txt";

$langArr[14]->country_id = 71;
$langArr[14]->file_name = "de_germany.txt";

$langArr[15]->country_id = 9;
$langArr[15]->file_name = "ar_argentina.txt";

$langArr[16]->country_id = 13;
$langArr[16]->file_name = "at_austria.txt";

$langArr[17]->country_id = 18;
$langArr[17]->file_name = "bb_barbados.txt";

$langArr[18]->country_id = 20;
$langArr[18]->file_name = "be_belgium.txt";

$langArr[19]->country_id = 15;
$langArr[19]->file_name = "bs_bahamas.txt";

$langArr[20]->country_id = 51;
$langArr[20]->file_name = "dk_denmark.txt";

$langArr[21]->country_id = 65;
$langArr[21]->file_name = "fi_finland.txt";

$langArr[22]->country_id = 73;
$langArr[22]->file_name = "gr_greece.txt";

$langArr[23]->country_id = 90;
$langArr[23]->file_name = "ie_ireland.txt";

$langArr[24]->country_id = 120;
$langArr[24]->file_name = "mx_mexico.txt";

$langArr[25]->country_id = 136;
$langArr[25]->file_name = "no_norway.txt";

$langArr[26]->country_id = 167;
$langArr[26]->file_name = "za_southafrica.txt";

$langArr[27]->country_id = 87;
$langArr[27]->file_name = "id_indonesia.txt";

$langArr[28]->country_id = 39;
$langArr[28]->file_name = "cl_chile.txt";

$langArr[29]->country_id = 47;
$langArr[29]->file_name = "hr_croatia.txt";

$langArr[30]->country_id = 55;
$langArr[30]->file_name = "ec_ecuador.txt";

$langArr[31]->country_id = 114;
$langArr[31]->file_name = "my_malaysia.txt";

$langArr[32]->country_id = 138;
$langArr[32]->file_name = "pk_pakistan.txt";

$langArr[33]->country_id = 144;
$langArr[33]->file_name = "pe_peru.txt";

$langArr[34]->country_id = 176;
$langArr[34]->file_name = "ch_switzerland.txt";

$langArr[35]->country_id = 181;
$langArr[35]->file_name = "th_thailand.txt";

$langArr[36]->country_id = 195;
$langArr[36]->file_name = "uy_uruguay.txt";


$langArr[37]->country_id = 91;
$langArr[37]->file_name = "il_israel.txt";

$langArr[38]->country_id = 149;
$langArr[38]->file_name = "qa_qatar.txt";


$langArr[39]->country_id = 151;
$langArr[39]->file_name = "ro_romania.txt";

$langArr[40]->country_id = 110;
$langArr[40]->file_name = "lu_luxembourg.txt";

$langArr[41]->country_id = 41;
$langArr[41]->file_name = "co_colombia.txt";

$langArr[42]->country_id = 145;
$langArr[42]->file_name = "ph_philippines.txt";

$langArr[43]->country_id = 3;
$langArr[43]->file_name = "al_albania.txt";

$langArr[44]->country_id = 5;
$langArr[44]->file_name = "ad_andorra.txt";

$langArr[45]->country_id = 77;
$langArr[45]->file_name = "gt_guatemala.txt";

$langArr[46]->country_id = 45;
$langArr[46]->file_name = "cr_costarica.txt";

$langArr[47]->country_id = 82;
$langArr[47]->file_name = "hn_honduras.txt";

$langArr[48]->country_id = 93;
$langArr[48]->file_name = "jm_jamaica.txt";

$langArr[49]->country_id = 25;
$langArr[49]->file_name = "bo_bolivia.txt";

$langArr[50]->country_id = 135;
$langArr[50]->file_name = "ng_nigeria.txt";

$langArr[51]->country_id = 146;
$langArr[51]->file_name = "pl_poland.txt";

$langArr[52]->country_id = 50;
$langArr[52]->file_name = "cz_czech.txt";

$langArr[53]->country_id = 206;
$langArr[53]->file_name = "mv_maldives.txt";

$langArr[54]->country_id = 163;
$langArr[54]->file_name = "sk_slovakia.txt";

$langArr[55]->country_id = 170;
$langArr[55]->file_name = "sk_srilanka.txt";

$langArr[56]->country_id = 192;
$langArr[56]->file_name = "ae_uae.txt";

$langArr[57]->country_id = 125;
$langArr[57]->file_name = "mo_morocco.txt";

$langArr[58]->country_id = 132;
$langArr[58]->file_name = "nz_newzealand.txt";

$langArr[59]->country_id = 198;
$langArr[59]->file_name = "ve_venezuela.txt";

$langArr[60]->country_id = 84;
$langArr[60]->file_name = "hu_hungary.txt";

$langArr[61]->country_id = 54;
$langArr[61]->file_name = "do_dominican.txt";

$langArr[62]->country_id = 185;
$langArr[62]->file_name = "tt_trinidad.txt";

$langArr[63]->country_id = 97;
$langArr[63]->file_name = "ke_kenya.txt";

$langArr[64]->country_id = 56;
$langArr[64]->file_name = "eg_egypt.txt";

$langArr[65]->country_id = 191;
$langArr[65]->file_name = "uk_ukraine.txt";

$langArr[66]->country_id = 207;
$langArr[66]->file_name = "sl_scotland.txt";

$langArr[67]->country_id = 208;
$langArr[67]->file_name = "nr_northern_ireland.txt";

$langArr[68]->country_id = 209;
$langArr[68]->file_name = "wa_wales.txt";

$langArr[69]->country_id = 116;
$langArr[69]->file_name = "mt_malta.txt";

$langArr[70]->country_id = 4;
$langArr[70]->file_name = "dz_algeria.txt";

$langArr[71]->country_id = 30;
$langArr[71]->file_name = "bg_bulgaria.txt";

$langArr[72]->country_id = 49;
$langArr[72]->file_name = "cy_cyprus.txt";


global $configs,$configClass;
$db = JFactory::getDBO();
$db->setQuery('SELECT * FROM #__osrs_configuration ');
$configs = array();
$configClass = array();
foreach ($db->loadObjectList() as $config) {
	$configs[$config->fieldname] = $config->fieldvalue;
	$configClass[$config->fieldname] = $config->fieldvalue;
}

if (version_compare(JVERSION, '3.0', 'lt')) {
	OSPHelper::loadBootstrap(true);	
}else{
    $document->addStyleSheet(JUri::root().'media/jui/css/jquery.searchtools.css');
}

if($configClass['load_lazy']){
	?>
	<script src="<?php echo JUri::root(); ?>components/com_osproperty/js/lazy.js" type="text/javascript"></script>
	<?php
}


/**
 * Multiple languages processing
 */
if (JLanguageMultilang::isEnabled() && !OSPHelper::isSyncronized())
{
	OSPHelper::setupMultilingual();
}

$option = $jinput->getString('option','com_osproperty');
$task = $jinput->getString('task','');
if($task != ""){
	$taskArr = explode("_",$task);
	$maintask = $taskArr[0];
}else{
	//cpanel
	$maintask = "";
}

include(JPATH_COMPONENT_ADMINISTRATOR.DS."helpers".DS."osproperty");
if (version_compare(JVERSION, '3.0', 'ge')) {
	//OSPropertyHelper::addSubmenu($task);
}
$tmpl = $jinput->getString('tmpl','');
if($maintask != "ajax"){
	$blacktaskarry = array('properties_showphotosinzipfile','properties_print','extrafield_addfieldoption','extrafield_removefieldoption','extrafield_savechangeoption','upload_ajaxupload','agent_getstate','configuration_connectfb');
	$fromarray = array('oscalendar');
	$from = $jinput->getString('from','');
	if((!in_array($task,$blacktaskarry)) and (!in_array($from,$fromarray)) and ($tmpl != "component")){
		HelperOspropertyCommon::renderSubmenu($task);	
	}
}
//OSPHelper::initSetup();

switch ($maintask){
	default:
	case "cpanel":
		OspropertyCpanel::cpanel($option);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "plugin":
		if (!JFactory::getUser()->authorise('plugin_list', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyPlugin::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "fieldgroup":
		if (!JFactory::getUser()->authorise('extrafieldgroups', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyFieldgroup::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "extrafield":
		if (!JFactory::getUser()->authorise('extrafields', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyExtrafield::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "categories":
		if (!JFactory::getUser()->authorise('categories', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyCategories::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "properties":
		if ((!JFactory::getUser()->authorise('properties', 'com_osproperty')) and ($task != "properties_reGeneratePictures") and ($task != "properties_sefoptimize")) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyProperties::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "amenities":
		if (!JFactory::getUser()->authorise('convenience', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyAmenities::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "type":
		if (!JFactory::getUser()->authorise('propertytypes', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyType::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "pricegroup":
		if (!JFactory::getUser()->authorise('pricelists', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyPricegroup::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "companies":
		if (!JFactory::getUser()->authorise('companies', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyCompanies::display($option,$task);
	break;
	case "country":
		if (!JFactory::getUser()->authorise('location', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyCountry::display($option,$task);
	break;
	case "state":
		if (!JFactory::getUser()->authorise('location', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyState::display($option,$task);
	break;
	case "agent":
		if ((!JFactory::getUser()->authorise('agents', 'com_osproperty')) and ($tmpl != "component")){
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyAgent::display($option,$task);
	break;
	case "coupon":
		OspropertyCoupon::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case 'comment':
		if (!JFactory::getUser()->authorise('comments', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyComment::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case 'configuration':
		if (!JFactory::getUser()->authorise('configuration', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyConfiguration::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case 'email':
		if (!JFactory::getUser()->authorise('email', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyEmail::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "transaction":
		if (!JFactory::getUser()->authorise('translation', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyTransaction::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "form":
		if (!JFactory::getUser()->authorise('csv', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyCsvform::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "city":
		if (!JFactory::getUser()->authorise('location', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyCity::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "translation":
		if (!JFactory::getUser()->authorise('translation', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyTranslation::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "theme":
		if (!JFactory::getUser()->authorise('themes', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyTheme::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "csvexport":
		if (!JFactory::getUser()->authorise('csv', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyCsvExport::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "report":
		if (!JFactory::getUser()->authorise('report', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyReport::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "tag":
		if (!JFactory::getUser()->authorise('tags', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyTag::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
	case "upload":
		OspropertyUpload::display($option,$task);
	break;
	case "xml":
		if (!JFactory::getUser()->authorise('xml', 'com_osproperty')) {
			return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		OspropertyXml::display($option,$task);
		HelperOspropertyCommon::loadFooter($option);
	break;
}

if($configClass['load_lazy']){
	?>
	<script type="text/javascript">
	jQuery(function() {
		jQuery("img.oslazy").lazyload();
	});
	</script>
	<?php
}
?>