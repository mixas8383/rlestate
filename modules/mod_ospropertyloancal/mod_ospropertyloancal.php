<?php
/*------------------------------------------------------------------------
# mod_ospropertyloancal.php - mod_oscategoryloancal
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2010 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
global $mainframe;
require_once(JPATH_ROOT.DIRECTORY_SEPARATOR."components".DIRECTORY_SEPARATOR."com_osproperty".DIRECTORY_SEPARATOR."helpers".DIRECTORY_SEPARATOR."helper.php");
if (version_compare(JVERSION, '3.0', 'lt')) {
	OSPHelper::loadBootstrapStylesheet();
}else{
	$db = Jfactory::getDBO();
	$db->setQuery("Select fieldvalue from #__osrs_configuration where fieldname like 'load_bootstrap'");
	$loadbootstrap = $db->loadResult();
	if($loadbootstrap == 1){
		OSPHelper::loadBootstrapStylesheet();	
	}
}
require(JModuleHelper::getLayoutPath('mod_ospropertyloancal'));
