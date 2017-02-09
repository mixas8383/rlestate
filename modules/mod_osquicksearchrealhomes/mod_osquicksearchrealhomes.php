<?php
/**
 * @subpackage  mod_osquicksearchrealhomes
 * @author      Dang Thuc Dam
 * @copyright   Copyright (C) 2007 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';
require_once JPATH_ROOT.'/components/com_osproperty/helpers/helper.php';
require_once JPATH_ROOT.'/components/com_osproperty/helpers/route.php';
$doc =  JFactory::getDocument();

$needs = array();
$needs[] = "property_advsearch";
$needs[] = "ladvsearch";
$itemid = OSPRoute::getItemid($needs);
$widthsize = $params->get('widthsize','715');
$module_name             = basename(dirname(__FILE__));
$url = JURI::base(true) . '/modules/' . $module_name . '/asset/';
$doc->addStyleSheet($url . 'css.css');

$osp_type = $params->get('osp_type',array());
require JModuleHelper::getLayoutPath('mod_osquicksearchrealhomes');
?>
