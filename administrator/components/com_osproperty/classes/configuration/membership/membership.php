<?php 
/*------------------------------------------------------------------------
# membership.php - Ossolution Property
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
	<legend><?php echo JTextOs::_('Membership integration setting')?></legend>
	<table cellpadding="0" cellspacing="0" width="100%" class="admintable">
		<tr>
			<td class="key" nowrap="nowrap">
				<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Membership integration' );?>">
                     <label for="checkbox_general_agent_listings">
                         <?php echo JTextOs::_( 'Membership integration' ).':'; ?>
                     </label>
				</span>
			</td>
			<td>
                <?php
                OspropertyConfiguration::showCheckboxfield('integrate_membership',$configs['integrate_membership']);
                ?>
			</td>
			<td width="80%" style="text-align:left;">
				<?php echo JText::_('OS_MEMBERSHIP_EXPLAIN')?>
			</td>
		</tr>
		<tr>
			<td class="key" nowrap="nowrap">
				<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'No subscription redirect link' );?>::<?php echo JTextOs::_('No subscription redirect link explain'); ?>">
					<label for="configuration[no_subscription_link]">
						<?php echo JTextOs::_( 'No subscription redirect link' ).':'; ?>
					</label>
				</span>
			</td>
			<td colspan="2">
				<input type="text" name="configuration[no_subscription_link]" value="<?php echo isset($configs['no_subscription_link'])? $configs['no_subscription_link']: JURI::root(); ?>" size="70">
			</td>
		</tr>
	</table>
</fieldset>