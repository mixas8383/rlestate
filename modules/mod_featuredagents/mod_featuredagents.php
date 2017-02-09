<?php
/**
 * @package 	mod_featuredagents - Featured agents
 * @version		1.0
 * @created		July 2013

 * @author		Dang Thuc Dam
 * @email		damdt@joomservices.com
 * @website		http://joomdonation.com
 * @copyright	Copyright (C) 2013 Joomdonation. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die;
error_reporting(0);
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'modules/mod_featuredagents/style/style.css');
require_once JPATH_SITE.'/modules/mod_featuredagents/helper.php';
$number_agents = $params->get('number_agents',4);
$sort_by = $params->get('sort_by','name');
$items = modFeaturedAgentsHelper::getList($params);
require JModuleHelper::getLayoutPath('mod_featuredagents');
