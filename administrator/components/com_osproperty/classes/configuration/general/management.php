<?php 
/*------------------------------------------------------------------------
# management.php - Ossolution Property
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
	<legend><?php echo JTextOs::_('Expiration Management setting')?></legend>
	<table cellpadding="0" cellspacing="0" width="100%" class="admintable">
		<tr>
			<td class="key" nowrap="nowrap">
				<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Use expiration Management' );?>::<?php echo JTextOs::_('Do you want to use the expiration management system. This allows you to limit how long listings are displayed for based on either time or page impressions.'); ?>">
                      <label for="checkbox_general_use_expiration_management">
                          <?php echo JTextOs::_( 'Use expiration Management' ).':'; ?>
                      </label>
				</span>
			</td>
			<td>
				<?php
                OspropertyConfiguration::showCheckboxfield('general_use_expiration_management',$configs['general_use_expiration_management']);
				?>
			</td>
		</tr>
		<tr>
			<td class="key" nowrap="nowrap">
				<span class="editlinktip hasTip" title="<?php echo JText::_('OS_TIME_IN_DAYS_EXPLAIN'); ?>">
                     <label for="configurationgeneral_time_in_days">
                         <?php echo JText::_( 'OS_LIVE_TIME_OF_STANDARD_PROPERTIES' ).':'; ?>
                     </label>
				</span>
			</td>
			<td>
				<input type="text" name="configuration[general_time_in_days]" id="configurationgeneral_time_in_days" value="<?php echo isset($configs['general_time_in_days'])?$configs['general_time_in_days']:'' ?>" class="text-area-order input-mini" size="5" />
				&nbsp;
				<?php echo JText::_('OS_DAYS');?>
			</td>
		</tr>
		<tr>
			<td class="key" nowrap="nowrap">
				<span class="editlinktip hasTip" title="<?php echo JText::_("OS_LIVE_TIME_OF_FEATURED_PROPERTIES_EXPLAIN"); ?>">
                     <label for="configurationgeneral_time_in_days_featured">
                         <?php echo JText::_( 'OS_LIVE_TIME_OF_FEATURED_PROPERTIES' ).':'; ?>
                     </label>
				</span>
			</td>
			<td>
				<input type="text" name="configuration[general_time_in_days_featured]" id="configurationgeneral_time_in_days_featured" value="<?php echo isset($configs['general_time_in_days_featured'])?$configs['general_time_in_days_featured']:'' ?>" class="text-area-order input-mini" size="5" />
				&nbsp;
				<?php echo JText::_('OS_DAYS');?>
			</td>
		</tr>
		<tr>
			<td class="key" nowrap="nowrap">
				<span class="editlinktip hasTip" title="<?php echo JText::_("OS_REMOVING_AFTER_EXPLAIN"); ?>">
                      <label for="configurationgeneral_unpublished_days">
                          <?php echo JText::_( 'OS_REMOVING_AFTER' ).':'; ?>
                      </label>
				</span>
			</td>
			<td>
				<input type="text" name="configuration[general_unpublished_days]" id="configurationgeneral_unpublished_days" value="<?php echo isset($configs['general_unpublished_days'])?$configs['general_unpublished_days']:'' ?>" class="text-area-order input-mini" size="5" />
				&nbsp;
				<?php echo JText::_('OS_DAYS');?>
			</td>
		</tr>
	</table>
</fieldset>