<?php 
/*------------------------------------------------------------------------
# agent.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die;
$db = JFactory::getDbo();
?>
<table width="100%" class="admintable">
	<tr>
		<td width="50%" valign="top">
			<legend><?php echo JText::_('OS_SELECT_USER_TYPES')?></legend>
			<?php echo JText::_('OS_SELECT_USER_TYPES_EXPLAIN'); ?>
			<BR />
			<?php
			$user_types = array();
			$user_types[0]->value = 0;
			$user_types[0]->text = JText::_('OS_AGENT');

			$user_types[1]->value = 1;
			$user_types[1]->text = JText::_('OS_OWNER');

			$user_types[2]->value = 2;
			$user_types[2]->text = JText::_('OS_REALTOR');

			$user_types[3]->value = 3;
			$user_types[3]->text = JText::_('OS_BROKER');

			$user_types[4]->value = 4;
			$user_types[4]->text = JText::_('OS_BUILDER');

			$user_types[5]->value = 5;
			$user_types[5]->text = JText::_('OS_LANDLORD');

			$user_types[6]->value = 6;
			$user_types[6]->text = JText::_('OS_SELLER');

			$checkbox_user_types = array();
			if (isset($configs['user_types'])){
				$checkbox_user_types = explode(',',$configs['user_types']);
			}
			if($configs['user_types'] == ""){
				$checkbox_user_types[] = 0;
				$checkbox_user_types[] = 1;
			}
			echo JHTML::_('select.genericlist',$user_types,'configuration[user_types][]','multiple class="inputbo chosen"','value','text',$checkbox_user_types);
			?>
			<BR /><BR />
			<?php echo JText::_('OS_SELECT_DEFAULT_USER_TYPE_REGISTER'); ?>
			<BR />
			<?php
			$usertypelabels = array(JText::_('OS_AGENT'),JText::_('OS_OWNER'),JText::_('OS_REALTOR'),JText::_('OS_BROKER'),JText::_('OS_BUILDER'),JText::_('OS_LANDLORD'),JText::_('OS_SELLER'));
			if($configs['user_types'] == ""){
				$configs['user_types'] = "0,1";
			}
			$user_types_array = $configs['user_types'];
			$user_types_array = explode(",",$user_types_array);
			?>
			<select class="input-medium chosen" name="configuration[default_user_type]">
				<?php 
				for($i=0;$i<count($user_types_array);$i++){
					if($user_types_array[$i] == $configs['default_user_type']){
						$selected = "selected";
					}else{
						$selected = "";
					}
					?>
					<option value="<?php echo $user_types_array[$i]?>" <?php echo $selected ;?>><?php echo $usertypelabels[$user_types_array[$i]];?></option>
					<?php
				}
				?>
			</select>
		</td>
		<td width="50%" valign="top">
			<legend><?php echo JText::_('OS_USER_REGISTRATION')?></legend>
			<?php echo JText::_('OS_USER_REGISTRATION_EXPLAIN')?>
			<br />
			<table width="100%" class="admintable">
				<tr>
					<td class="key" nowrap="nowrap">
						<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Agent registered' );?>::<?php echo JTextOs::_('Would you like to allow the registered members can register to become agent members.'); ?>">
							  <label for="checkbox_general_agent_registered">
								  <?php echo JTextOs::_( 'Agent registered' ).':'; ?>
							  </label>
						</span>
					</td>
					<td>
						<?php
						OspropertyConfiguration::showCheckboxfield('allow_agent_registration',intval($configs['allow_agent_registration']));
						?>
					</td>
				</tr>
				<tr>
					<td class="key" nowrap="nowrap">
						<span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_AGENT_USER_GROUP' );?>::<?php echo JText::_('OS_AGENT_USER_GROUP_EXPLAIN'); ?>">
							 <label for="checkbox_general_agent_listings">
								 <?php echo JText::_( 'OS_AGENT_USER_GROUP' ).':'; ?>
							 </label>
						</span>
					</td>
					<td>
						<?php 
						$db 		= JFactory::getDbo();
						$params 	= &JComponentHelper::getParams('com_users');
						$register_usertype = $params->get('new_usertype');
						$db->setQuery("Select id as value, title as text from #__usergroups where id <> '$register_usertype'");
						$groups 	= $db->loadObjectList();
						$groupArr 	= array();
						$groupArr[] = JHTML::_('select.option','',JText::_("OS_SELECT_ADDITIONAL_GROUP"));
						$groupArr   = array_merge($groupArr,$groups);
						echo JHTML::_('select.genericlist',$groupArr,'configuration[agent_joomla_group_id]','class="chosen input-large"','value','text',$configs['agent_joomla_group_id']);
						?>
					</td>
				</tr>
				<tr>
					<td class="key" nowrap="nowrap">
						<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Auto approval agent register request' );?>::<?php echo JTextOs::_('Would you like to allow auto approval the agent register request.'); ?>">
							  <label for="checkbox_auto_approval_agent_registration">
								  <?php echo JTextOs::_( 'Auto approval agent register request' ).':'; ?>
							  </label>
						</span>
					</td>
					<td>
						<?php
						OspropertyConfiguration::showCheckboxfield('auto_approval_agent_registration',intval($configs['auto_approval_agent_registration']));
						?>
					</td>
				</tr>
				<tr>
					<td class="key" nowrap="nowrap">
						<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Captcha_agent_register' );?>::In case you want to use reCaptcha, you need to publish the plugin :reCaptcha at Plugins manager. You also need to register Public and Private key">
							<label for="configuration[Captcha_agent_register]">
								<?php echo JTextOs::_( 'Captcha_agent_register').':'; ?>
							</label>
						</span>
					</td>
					<td>
						<?php 
						$value = isset($configs['captcha_agent_register'])? $configs['captcha_agent_register']:0;
						$optionArr = array();
						$optionArr[] = JHTML::_('select.option',2,JText::_('OS_YES').' - '.'reCaptcha');
						$optionArr[] = JHTML::_('select.option',1,JText::_('OS_YES'));
						$optionArr[] = JHTML::_('select.option',0,JText::_('OS_NO'));
						echo JHTML::_('select.genericlist',$optionArr,'configuration[captcha_agent_register]','class="chosen input-medium"','value','text',$value);
						?>
					</td>
				</tr>
				<tr>
					<td class="key" nowrap="nowrap">
						<span class="editlinktip hasTip" title="<?php echo JText::_('OS_SHOW_TERM_AND_CONDITION_IN_REGISTRATION_PAGE_EXPLAIN'); ?>">
							  <label for="checkbox_auto_approval_agent_registration">
								  <?php echo JText::_( 'OS_SHOW_TERM_AND_CONDITION' ).':'; ?>
							  </label>
						</span>
					</td>
					<td>
						<?php
						OspropertyConfiguration::showCheckboxfield('agent_term_condition',intval($configs['agent_term_condition']));
						?>
					</td>
				</tr>
				<tr>
					<td class="key" nowrap="nowrap">
						<span class="editlinktip hasTip" title="<?php echo JText::_('OS_SELECT_TERM_AND_CONDITION_ARTICLE'); ?>">
							  <label for="checkbox_auto_approval_agent_registration">
								  <?php echo JText::_( 'OS_SELECT_ARTICLE' ).':'; ?>
							  </label>
						</span>
					</td>
					<td>
						<?php
						$sql = 'SELECT id, title FROM #__content WHERE `state` = 1 ORDER BY title ';
						$db->setQuery($sql) ;
						$rows = $db->loadObjectList();
						$options = array() ;
						$options[] = JHTML::_('select.option', '' ,'', 'id', 'title') ;
						$options = array_merge($options, $rows) ;		
						echo JHTML::_('select.genericlist', $options, 'configuration[agent_article_id]', ' class="input-large chosen" ', 'id', 'title', $configs['agent_article_id']) ;
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
			
<BR />
<fieldset>
	<table width="100%" class="admintable">
		<tr>
			<td width="50%" valign="top">
				<legend><?php echo JText::_('OS_USER_FIELDS')?></legend>
				<br />
				<table width="100%" class="admintable">
					<?php 
						$Agent_array = array('Show agent image','Show agent address','Show agent email','Show agent fax','Show agent mobile','Show agent phone','Show Agent MSN','Show Agent Yahoo','Show Agent Skype'
						,'Show Agent Gtalk','Show License','Show Agent Facebook');
						foreach ($Agent_array as $agent) {
							$name = str_replace(' ','_',strtolower($agent));
							$value = isset($configs[$name])? $configs[$name]:0;
						?>
						<tr>
							<td class="key" nowrap="nowrap">
								<span class="editlinktip hasTip" title="<?php echo JTextOs::_( $agent );?>">
									<label for="configuration[<?php echo $name; ?>]">
										<?php echo JTextOs::_( $agent).':'; ?>
									</label>
								</span>
							</td>
							<td>
								<?php 
								if (version_compare(JVERSION, '3.0', 'lt')) {
									//echo JHtml::_('select.booleanlist','configuration['.$name.']','',$value);
									$optionArr = array();
									$optionArr[] = JHTML::_('select.option',1,JText::_('OS_YES'));
									$optionArr[] = JHTML::_('select.option',0,JText::_('OS_NO'));
									echo JHTML::_('select.genericlist',$optionArr,'configuration['.$name.']','class="chosen input-mini"','value','text',$value);
								}else{
									if($value == 0){
										$checked2 = 'checked="checked"';
										$checked1 = "";
									}else{
										$checked1 = 'checked="checked"';
										$checked2 = "";
									}
									?>
									<fieldset id="jform_params_<?php echo $name;?>" class="radio btn-group">
										<input type="radio" id="jform_params_<?php echo $name;?>0" name="configuration[<?php echo $name; ?>]" value="1" <?php echO $checked1;?>/>
										<label for="jform_params_<?php echo $name;?>0"><?php echo JText::_('OS_YES');?></label>
										<input type="radio" id="jform_params_<?php echo $name;?>1" name="configuration[<?php echo $name; ?>]" value="0" <?php echO $checked2;?>/>
										<label for="jform_params_<?php echo $name;?>1"><?php echo JText::_('OS_NO');?></label>
									</fieldset>
								<?php } ?>
							</td>
						</tr>
						<?php 	
						}
					?>
				</table>
			</td>
			<td width="50%" valign="top">
				<legend><?php echo JText::_('OS_FRONTEND_SETTING')?></legend>
				<br />
				<table width="100%" class="admintable">
					<tr>
						<td class="key" nowrap="nowrap">
							<span class="editlinktip hasTip" title="<?php echo JText::_('OS_SHOW_SEARCH_FORM_IN_LIST_AGENTS_EXPLAIN'); ?>">
								<label for="checkbox_property_show_rating">
									<?php echo JText::_( 'OS_SHOW_SEARCH_FORM_IN_LIST_AGENTS' ).':'; ?>
								</label>
							</span>
						</td>
						<td>
							<?php
							OspropertyConfiguration::showCheckboxfield('show_agent_search_tab',intval($configs['show_agent_search_tab']));
							?>

						</td>
					</tr>
					<tr>
						<td class="key" nowrap="nowrap">
							<span class="editlinktip hasTip" title="<?php echo JText::_('OS_SHOW_ALPHABET_FILTERING_IN_LIST_AGENTS_EXPLAIN'); ?>">
								<label for="checkbox_property_show_rating">
									<?php echo JText::_( 'OS_SHOW_ALPHABET_FILTERING_IN_LIST_AGENTS' ).':'; ?>
								</label>
							</span>
						</td>
						<td>
							<?php
							OspropertyConfiguration::showCheckboxfield('show_alphabet',intval($configs['show_alphabet']));
							?>
						</td>
					</tr>
					<tr>
						<td class="key" nowrap="nowrap">
							<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Agent listings' );?>::<?php echo JTextOs::_('Would you like to allow agent members to list properties for sale via the front-end listings panel?'); ?>">
								 <label for="checkbox_general_agent_listings">
									 <?php echo JTextOs::_( 'Agent listings' ).':'; ?>
								 </label>
							</span>
						</td>
						<td>
							<?php 
							OspropertyConfiguration::showCheckboxfield('general_agent_listings',intval($configs['general_agent_listings']));
							?>
						</td>
					</tr>
					<tr>
						<td class="key" nowrap="nowrap">
							<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Show most rated' );?>::<?php echo JTextOs::_('Show most rated explain'); ?>">
								 <label for="checkbox_general_agent_listings">
									 <?php echo JTextOs::_( 'Show most rated' ).':'; ?>
								 </label>
							</span>
						</td>
						<td>
							<?php 
							OspropertyConfiguration::showCheckboxfield('agent_mostrated',intval($configs['agent_mostrated']));
							?>
						</td>
					</tr>
					<tr>
						<td class="key" nowrap="nowrap">
							<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Show most viewed' );?>::<?php echo JTextOs::_('Show most viewed explain'); ?>">
								 <label for="checkbox_general_agent_listings">
									 <?php echo JTextOs::_( 'Show most viewed' ).':'; ?>
								 </label>
							</span>
						</td>
						<td>
							<?php 
							OspropertyConfiguration::showCheckboxfield('agent_mostviewed',intval($configs['agent_mostviewed']));
							?>
						</td>
					</tr>
					<tr>
						<td class="key" nowrap="nowrap">
							<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Show agent contact' );?>::<?php echo JTextOs::_('Show agent contact explain'); ?>">
								 <label for="checkbox_general_agent_listings">
									 <?php echo JTextOs::_( 'Show agent contact' ).':'; ?>
								 </label>
							</span>
						</td>
						<td>
							<?php 
							OspropertyConfiguration::showCheckboxfield('show_agent_contact',intval($configs['agent_mostviewed']));
							?>
						</td>
					</tr>
					<tr>
						<td class="key" nowrap="nowrap">
							<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Show agent properties' );?>::<?php echo JTextOs::_('Show agent properties explain'); ?>">
								 <label for="checkbox_general_agent_listings">
									 <?php echo JTextOs::_( 'Show agent properties' ).':'; ?>
								 </label>
							</span>
						</td>
						<td>
							<?php 
							OspropertyConfiguration::showCheckboxfield('show_agent_properties',intval($configs['agent_mostviewed']));
							?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</fieldset>