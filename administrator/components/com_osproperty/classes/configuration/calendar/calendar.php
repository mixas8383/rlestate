<?php 
/*------------------------------------------------------------------------
# calendar.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die;

?>
<fieldset>
	<legend><?php echo JTextOs::_('OS Calendar integration setting')?></legend>
	<table cellpadding="0" cellspacing="0" width="100%" class="admintable">
		<tr>
			<td class="key" nowrap="nowrap">
				<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'OS Calendar integration' );?>">
                     <label for="checkbox_general_agent_listings">
                         <?php echo JTextOs::_( 'OS Calendar integration' ).':'; ?>
                     </label>
				</span>
			</td>
			<td>
                <?php
                OspropertyConfiguration::showCheckboxfield('integrate_oscalendar',$configs['integrate_oscalendar']);
                ?>
			</td>
			<td width="80%" style="text-align:left;">
				<?php echo JText::_('OS_OSCALENDAR_EXPLAIN')?>
			</td>
		</tr>
		<tr>
			<td class="key" nowrap="nowrap" valign="top">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_SELECT_PROPERTY_TYPES' );?>::<?php echo JText::_('OS_SELECT_PROPERTY_TYPES_THAT_THE_DATE_RANGE_SEARCHING_WILL_BE_SHOWN_EXPLAIN'); ?>">
	                <label for="configuration[category_layout]">
	                    <?php echo JText::_( 'OS_SELECT_PROPERTY_TYPES' ).':'; ?>
	                </label>
				</span>
			</td>
			<td valign="top">
				<?php
					$type_lists = $configs['show_date_search_in'];
					$type_lists = explode("|",$type_lists);

					$type_arr = array();
					$db = JFactory::getDbo();
					$db->setQuery("Select id as value, type_name as text from #__osrs_types where published = '1' order by type_name");
					$types = $db->loadObjectList();
					echo JHtml::_('select.genericlist',$types,'show_date_search_in[]','multiple class="chosen input-large"','value','text',$type_lists);
				?>
			</td>
		</tr>
	</table>
</fieldset>