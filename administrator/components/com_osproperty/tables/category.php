<?php
/*------------------------------------------------------------------------
# category.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// No direct access.
defined('_JEXEC') or die;

/**
 * Banner table
 *
 * @package		Joomla.Administrator
 * @subpackage	com_osproperty
 * @since		1.5
 */
class OspropertyTableCategory extends JTable
{
	/**
	 * Constructor
	 *
	 * @since	1.5
	 */
	
	function __construct(&$_db)
	{
		parent::__construct('#__osrs_categories', 'id', $_db);
	}
}