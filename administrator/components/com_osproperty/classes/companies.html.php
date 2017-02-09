<?php
/*------------------------------------------------------------------------
# companies.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');


class HTML_OspropertyCompanies{
	/**
	 * Extra field list HTML
	 *
	 * @param unknown_type $option
	 * @param unknown_type $rows
	 * @param unknown_type $pageNav
	 * @param unknown_type $lists
	 */
	function companies_list($option,$rows,$pageNav,$lists){
		global $mainframe,$_jversion;
		$db = JFactory::getDBO();		
		JHtml::_('behavior.multiselect');
		JHTML::_('behavior.modal');
		JToolBarHelper::title(JText::_('OS_MANAGE_COMPANIES'),"user");
		JToolBarHelper::addNew('companies_add');
		if (count($rows)){
			JToolBarHelper::editList('companies_edit');
			JToolBarHelper::deleteList(JText::_('OS_ARE_YOU_SURE_TO_REMOVE_ITEM'),'companies_remove');
			JToolBarHelper::publish('companies_publish');
			JToolBarHelper::unpublish('companies_unpublish');
		}
		JToolbarHelper::custom('cpanel_list','featured.png', 'featured_f2.png',JText::_('OS_DASHBOARD'),false);
		?>

		<form method="POST" action="index.php?option=com_osproperty&task=companies_list" name="adminForm" id="adminForm">
		<table  width="100%">
			<tr>
				<td width="100%">
                    <DIV class="btn-wrapper input-append">
                        <input type="text" name="keyword" placeholder="<?php echo JText::_('OS_SEARCH');?>" value="<?php echo JRequest::getVar('keyword','')?>" class="input-medium" />
                        <button class="btn hasTooltip" title="" type="submit" data-original-title="<?php echo Jtext::_('OS_SEARCH');?>">
                            <i class="icon-search"></i>
                        </button>
                    </DIV>
				</td>
			</tr>
		</table>
        <?php
        if(count($rows) > 0) {
        ?>
		<table class="adminlist table table-striped">
			<thead>
				<tr>
					<th width="2%">
				
					</th>
					<th width="3%"  style="text-align:center;">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
					</th>
					<th width="10%">
						<?php echo JHTML::_('grid.sort',   JText::_('OS_COMPANY_NAME'), 'company_name', @$lists['order_Dir'], @$lists['order'] ,'companies_list'); ?>
					</th>
					<th width="10%">
						<?php echo JHTML::_('grid.sort',   JText::_('OS_COMPANY_ADMIN'), 'company_name', @$lists['order_Dir'], @$lists['order'] ,'companies_list'); ?>
					</th>
					<th width="10%">
						<?php echo JText::_('OS_ADDRESS'); ?>
					</th>
					<th width="5%">
						<?php echo JHTML::_('grid.sort',   JText::_('OS_PHONE'), 'phone', @$lists['order_Dir'], @$lists['order'] ,'companies_list'); ?>
					</th>
					<th width="8%">
						<?php echo JText::_('OS_PHOTO'); ?>
					</th>
					<th width="5%" style="text-align:center;">
						<?php echo JHTML::_('grid.sort',   JText::_('OS_PUBLISH'), 'published', @$lists['order_Dir'], @$lists['order'] ,'companies_list'); ?>
					</th>
					<?php
					if($configClass['auto_approval_company_register_request']==0){
					?>
					<th width="5%" style="text-align:center;">
						<?php echo JHTML::_('grid.sort',   JText::_('OS_APPROVAL'), 'request_to_approval', @$lists['order_Dir'], @$lists['order'] ,'companies_list'); ?>
					</th>
					<?php
					}
					?>
					<th width="5%">
						<?php echo JText::_('OS_AGENTS')?>
					</th>
					<th width="3%" style="text-align:center;">
						<?php echo JHTML::_('grid.sort',   JText::_('ID'), 'id', @$lists['order_Dir'], @$lists['order'] ,'companies_list'); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td width="100%" colspan="13" style="text-align:center;">
						<?php
							echo $pageNav->getListFooter();
						?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php
			$k = 0;
			for ($i=0, $n=count($rows); $i < $n; $i++) {
				$row = $rows[$i];
				$checked = JHtml::_('grid.id', $i, $row->id);
				$link 		= JRoute::_( 'index.php?option=com_osproperty&task=companies_edit&cid[]='. $row->id );
				$published 	= JHTML::_('jgrid.published', $row->published, $i, 'companies_');
				
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td align="center">
						<?php echo $pageNav->getRowOffset( $i ); ?>
					</td>
					<td align="center" style="text-align:center;">
						<?php echo $checked; ?>
					</td>
					<td align="left">
						<a href="<?php echo $link; ?>">
							<?php echo $row->company_name; ?>
						</a>
						<BR />
						(Alias: <?php echo $row->company_alias;?>)
					</td>
					<td align="left">
						<?php
						$u = JFactory::getUser($row->user_id);
						echo $u->name;
						?>
					</td>
					<td align="left">
						<?php echo OSPHelper::generateAddress($row); ?>
					</td>
					<td align="left">
						<?php echo $row->phone; ?>
					</td>
					<td align="center">
						<a class="modal" href="<?php echo PATH_URL_PHOTO_COMPANY_FULL; ?><?php echo $row->photo?>">
							<img width="80" alt="" src="<?php echo PATH_URL_PHOTO_COMPANY_THUMB; ?><?php echo $row->photo?>">
						</a>
					</td>
					<td align="center" style="text-align:center;">
						<?php echo $published?>
					</td>
					<?php
					if($configClass['auto_approval_company_register_request']==0){
					?>
						<td align="center" style="text-align:center;">
							<?php
								if($row->request_to_approval == 1){
									?>
									<img src="<?php echo JUri::root(); ?>components/com_osproperty/images/assets/publish_x.png" />
									<?php
								}else{
									?>
									<img src="<?php echo JUri::root(); ?>components/com_osproperty/images/assets/tick.png" />
									<?php
								}
							?>
						</td>
					<?php
					}
					?>
				 	<td align="center" style="text-align:center;">
				 		<?php
				 		$db->setQuery("Select count(id) from #__osrs_company_agents where company_id = '$row->id'");
				 		$nagents = $db->loadResult();
				 		echo intval($nagents);
				 		?>
				 	</td>
				 	<td align="center" style="text-align:center;">
				 		<?php
				 		echo $row->id;
				 		?>
				 	</td>
				</tr>
			<?php
				$k = 1 - $k;	
			}
			?>
			</tbody>
		</table>
        <?php
        }else{
            ?>
            <div class="alert alert-no-items"><?php echo Jtext::_('OS_NO_MATCHING_RESULTS');?></div>
        <?php
        }
        ?>
		<input type="hidden" name="option" value="com_osproperty" />
		<input type="hidden" name="task" value="companies_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $lists['order'];?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir'];?>" />
		</form>
		<?php
	}
	
	
	/**
	 * Edit Extra field
	 *
	 * @param unknown_type $option
	 * @param unknown_type $row
	 * @param unknown_type $lists
	 */
	function editHTML($option,$row,$lists,$translatable){
		global $mainframe,$configClass,$_jversion,$languages;
		JRequest::setVar( 'hidemainmenu', 1 );
		$db = JFactory::getDBO();
		JHtml::_('behavior.tooltip');
		if ($row->id){
			$title = ' ['.JText::_('OS_EDIT').']';
		}else{
			$title = ' ['.JText::_('OS_NEW').']';
		}
		JToolBarHelper::title(JText::_('OS_COMPANY').$title);
		JToolBarHelper::save('companies_save');
		JToolBarHelper::save2new('companies_new');
		JToolBarHelper::apply('companies_apply');
		JToolBarHelper::cancel('companies_cancel');
		$editor =& JFactory::getEditor();
		?>
		<script language="javascript">
		/**
		 * move option this select box to that select box
		 * @param from
		 * @param to
		 * @param from_tmp
		 * @param to_tmp
		 * @return
		 */
		function moveOptions(from,to,from_tmp,to_tmp) {
		  // Move them over
		  for (var i=0; i<from.options.length; i++) {
			var o = from.options[i];
			if (o.selected) {
			  to.options[to.options.length] = new Option( o.text, o.value, false, false);
			  to_tmp.options[to_tmp.options.length] = new Option( o.text, o.value, false, false);
			}
		  }
		  // Delete them from original
		  for (var i=(from.options.length-1); i>=0; i--) {
			var o = from.options[i];
			if (o.selected) {
			  for (var j=(from_tmp.options.length-1); j>=0; j--) {
				 var o_tmp = from_tmp.options[j];
				 if (o.value == o_tmp.value){
					 from_tmp.options[j] = null;
				 }
			  }
			  from.options[i] = null;
			}
		  }
		  from.selectedIndex = -1;
		  to.selectedIndex = -1;
		  from_tmp.selectedIndex = -1;
		  to_tmp.selectedIndex = -1;
		}
		
		/**
		 * select all option in selec box
		 * @param element
		 * @return
		 */	
		function allSelected(element) {
		   for (var i=0; i<element.options.length; i++) {
				var o = element.options[i];
				o.selected = true;
			}
		 }
		 
		function change_country_agent(country_id,state_id,city_id){
			var live_site = '<?php echo JURI::root()?>';
			loadLocationInfoStateCity(country_id,state_id,city_id,'country','state',live_site);
		}
		function change_state(state_id,city_id){
			var live_site = '<?php echo JURI::root()?>';
			loadLocationInfoCity(state_id,city_id,'state_id',live_site);
		}
		function loadCity(state_id,city_id){
			var live_site = '<?php echo JURI::root()?>';
			loadLocationInfoCity(state_id,city_id,'state',live_site);
		}
		</script>
		<?php
		if (version_compare(JVERSION, '3.5', 'ge')){
		?>
			<script src="<?php echo JUri::root()?>media/jui/js/fielduser.min.js" type="text/javascript"></script>
		<?php } ?>
		<form method="POST" action="index.php?option=com_osproperty" name="adminForm" id="adminForm" enctype="multipart/form-data">
		<?php 
		if ($translatable)
		{
		?>
			<ul class="nav nav-tabs">
				<li class="active"><a href="#general-page" data-toggle="tab"><?php echo JText::_('OS_GENERAL'); ?></a></li>
				<li><a href="#translation-page" data-toggle="tab"><?php echo JText::_('OS_TRANSLATION'); ?></a></li>									
			</ul>		
			<div class="tab-content">
				<div class="tab-pane active" id="general-page">			
		<?php	
		}
		?>
		<table width="100%">
			<tr>
				<td width="62%" valign="top">
					<table  width="100%" class="admintable" style="background-color:white;">
						<tr>
							<td class="key"><?php echo JText::_('OS_USERNAME'); ?></td>
							<td width="80%"><input type="text" name="username" id="username" class="input-medium" value="" />
							<?php echo JText::_('OS_CREATE_NEW_USER');?>
							</td>
						</tr>
						<tr>
							<td class="key"><?php echo JText::_('OS_PASSWORD'); ?></td>
							<td width="80%"><input type="password" name="password" id="password" class="input-medium" value="" /></td>
						</tr>
						<tr>
							<td class="key">
								<?php echo JText::_('OS_COMPANY_NAME'); ?>
							</td>
							<td>
								<input type="text" name="company_name" id="company_name" size="40" value="<?php echo $row->company_name?>" class="input-large" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo JText::_('OS_ALIAS'); ?>
							</td>
							<td>
								<input type="text" name="company_alias" id="company_alias" size="40" value="<?php echo $row->company_alias?>" class="input-large" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo JText::_('OS_COMPANY_ADMIN'); ?>
							</td>
							<td>
								<?php 
								echo OspropertyCompanies::getUserInput($row->user_id);
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo JText::_('OS_EMAIL'); ?>
							</td>
							<td>
								<input type="text" name="email" id="email" size="20" value="<?php echo $row->email?>" class="input-large" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo JText::_('OS_PUBLISHED')?>
							</td>
							<td>
								<?php
								echo $lists['published'];
								?>
							</td>
						</tr>
						<?php
						if(($configClass['auto_approval_company_register_request'] == 0) and ($row->request_to_approval == 1)){
							?>
							<tr>
								<td class="key">
									<?php echo JText::_('OS_APPROVAL')?>
								</td>
								<td>
									<?php
									echo $lists['approval'];
									?>
								</td>
							</tr>
							<?php
						}
						?>
					</table>
				</td>
				<td width="38%" valign="top">
					<table  width="100%" class="admintable" style="background-color:white;">
						<tr>
							<td class="key" width="30%">
								<?php echo JText::_('OS_ADDRESS')?>
							</td>
							<td width="70%">
								<input type="text" name="address" id="address" class="input-large" value="<?php echo $row->address?>" />
							</td>
						</tr>
						<?php
						if(HelperOspropertyCommon::checkCountry()){
						?>
						<tr>
							<td class="key">
								<?php echo JText::_('OS_COUNTRY'); ?>
							</td>
							<td>
								<?php echo $lists['country'];?>
							</td>
						</tr>
						<?php
						}else{
							echo $lists['country'];
						}
						?>
						<tr>
							<td class="key">
								<?php echo JText::_('OS_STATE'); ?>
							</td>
							<td id="country_state">
								<?php echo $lists['states']; ?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo JText::_('OS_CITY'); ?>
							</td>
							<td>
								<div id="city_div">
								<?php
								echo $lists['city'];
								?>
								</div>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo JText::_('OS_POSTCODE'); ?>
							</td>
							<td>
								<input type="text" name="postcode" id="postcode" size="10" value="<?php echo $row->postcode?>" class="input-small">
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo JText::_('OS_PHONE'); ?>
							</td>
							<td>
								<input type="text" name="phone" id="phone" size="10" value="<?php echo $row->phone?>" class="input-small">
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo JText::_('OS_FAX'); ?>
							</td>
							<td>
								<input type="text" name="fax" id="fax" size="10" value="<?php echo $row->fax?>" class="input-small">
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo JText::_('OS_WEB'); ?>
							</td>
							<td>
								<input type="text" name="website" id="website" size="30" value="<?php echo $row->website?>" class="input-medium">
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo JText::_('OS_PHOTO'); ?>
							</td>
							<td>
								<?php if($row->id && $row->photo){?>
									<a class="modal" href="<?php echo PATH_URL_PHOTO_COMPANY_FULL; ?><?php echo $row->photo?>">
										<img width="80" alt="" src="<?php echo PATH_URL_PHOTO_COMPANY_THUMB; ?><?php echo $row->photo?>">
									</a>
									<div class="clearfix"></div>
									<input type="checkbox" name="remove_photo" value="1">&nbsp;<?php echo JText::_("OS_REMOVE_PHOTO")?>
									<br>
								<?php }?>
								<div class="clearfix"></div>
								<input type="file" name="file_photo" id="file_photo" size="40" onchange="javascript:checkUploadPhotoFiles('file_photo')"> 
								<div class="clearfix"></div>
								(<?php echo Jtext::_('OS_ONLY_SUPPORT_JPG_IMAGES');?>)
								<input type="hidden" name="photo" id="photo" size="40" value="<?php echo $row->photo?>">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table class="admintable" width="100%">
				<tr>
					<td class="key" valign="top">
						<?php echo JText::_('OS_DESCRIPTION')?>
					</td>
					<td>
						<?php
						// parameters : areaname, content, width, height, cols, rows, show xtd buttons
						echo $editor->display( 'company_description',  htmlspecialchars($row->company_description, ENT_QUOTES), '550', '300', '60', '20', array() ) ;
						?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<?php echo JText::_('OS_MANAGE_AGENTS')?>
					</td>
					<td style="border:1px solid #FACC82;background-color:#FEEACA;padding:5px;">
						<table  width="100%">
							<tr>
								<td width="40%" valign="top" style="text-align:right;">
									<b><?php echo JText::_('OS_FREE_AGENT')?></b>
									<BR>
									<?php
									echo JHTML::_('select.genericlist',$lists['agentsnotinCompany'],'users_not_selected[]','class="inputbox" multiple style="height:180px;" onDblClick="moveOptions(document.adminForm.users_not_selected, document.adminForm[\'users_selected[]\'],document.adminForm.users_not_selected_tmp,document.adminForm.users_selected_tmp)"','value','text');
									
									echo JHTML::_('select.genericlist',$lists['agentsnotinCompany'],'users_not_selected_tmp','style="display:none;"','value','text');
									?>
								</td>
								<td width="20%" valign="middle" style="text-align:center;">
									<input  type="button" name="Button" value="&gt;&gt;" onclick="moveOptions(document.adminForm.users_not_selected, document.adminForm['users_selected[]'],document.adminForm.users_not_selected_tmp,document.adminForm.users_selected_tmp)" />
									<br/> <br/>
								 	<input  type="button" name="Button" value="&lt;&lt;" onclick="moveOptions(document.adminForm.users_selected_tmp,document.adminForm.users_not_selected,document.adminForm['users_selected[]'],document.adminForm.users_not_selected_tmp)" />
								</td>
								<td width="40%" valign="top" style="text-align:left;">
									<b><?php echo JText::_('OS_AGENT_OF_THIS_COMPANY')?></b>
									<BR>
									<?php
									echo JHTML::_('select.genericlist',$lists['agentinCompany'],'users_selected_tmp','class="inputbox" multiple style="height:180px;" onDblClick="moveOptions(document.adminForm.users_selected_tmp,document.adminForm.users_not_selected,document.adminForm[\'users_selected[]\'], document.adminForm.users_not_selected_tmp)"','value','text');
									echo JHTML::_('select.genericlist',$lists['agentinCompany'],'users_selected[]','style="display:none;" multiple','value','text');
									?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		<?php 
		if ($translatable)
		{
		?>
		</div>
			<div class="tab-pane" id="translation-page">
				<ul class="nav nav-tabs">
					<?php
						$i = 0;
						foreach ($languages as $language) {						
							$sef = $language->sef;
							?>
							<li <?php echo $i == 0 ? 'class="active"' : ''; ?>><a href="#translation-page-<?php echo $sef; ?>" data-toggle="tab"><?php echo $language->title; ?>
								<img src="<?php echo JURI::root(); ?>media/com_osproperty/flags/<?php echo $sef.'.png'; ?>" /></a></li>
							<?php
							$i++;	
						}
					?>			
				</ul>		
				<div class="tab-content">			
					<?php	
						$i = 0;
						foreach ($languages as $language)
						{												
							$sef = $language->sef;
						?>
							<div class="tab-pane<?php echo $i == 0 ? ' active' : ''; ?>" id="translation-page-<?php echo $sef; ?>">													
								<table width="100%" class="admintable" style="background-color:white;">
									<tr>
										<td class="key" valign="top">
											<?php echo JText::_('OS_DESCRIPTION')?>
										</td>
										<td>
											<?php echo $editor->display( 'company_description_'.$sef,  stripslashes($row->{'company_description_'.$sef}) , '80%', '250', '75', '20' ) ; ?>
										</td>
									</tr>
								</table>
							</div>										
						<?php				
							$i++;		
						}
					?>
				</div>	
		</div>
		<?php				
		}
		?>
		<input type="hidden" name="option" value="com_osproperty" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" value="<?php echo intval($row->id);?>" />
		<input type="hidden" name="boxchecked" id="boxchecked" value="0" />
		</form>
		<script type="text/javascript">
			var live_site = '<?php echo JURI::root()?>';
			function change_country_company(country_id,state_id,city_id){
				var live_site = '<?php echo JURI::root()?>';
				loadLocationInfoStateCity(country_id,state_id,city_id,'country','state',live_site);
			}
			
			function loadCity(state_id,city_id){
				var live_site = '<?php echo JURI::root()?>';
				loadLocationInfoCity(state_id,city_id,'state',live_site);
			}

            function loadStateBackend(country_id,state_id,city_id){
                var live_site = '<?php echo JURI::root()?>';
                loadLocationInfoStateCityBackend(country_id,state_id,city_id,'country','state',live_site);
            }
            function loadCityBackend(state_id,city_id){
                var live_site = '<?php echo JURI::root()?>';
                loadLocationInfoCityAddProperty(state_id,city_id,'state',live_site);
            }
			
			
			Joomla.submitbutton = function(pressbutton)
			{
				var form = document.adminForm;
				var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				var user_id = document.getElementById('user_id_id');
                if(user_id != null) {
                    user_id = user_id.value;
                }else{
                    user_id = document.adminForm.user_id.value;
                }
				user_id = parseInt(user_id);
				var username = document.getElementById('username');
				var password = document.getElementById('password');

				if (pressbutton == 'companies_cancel'){
					submitform( pressbutton );
					return;
				}else if ((user_id == 0) && (username.value == "") && (password.value == "")){
					alert('<?php echo JText::_('OS_PLEASE_SELECT_OR_CREATE_NEW_JOOMLA_USER_FOR_THIS_AGENT'); ?>');
					form.username.focus();
					return;
				}else if (form.company_name.value == ''){
					alert('<?php echo JText::_('OS_PLEASE_ENTER_COMPANY_NAME'); ?>');
					form.company_name.focus();
					return;
				}else if (form.email.value == ''){
					alert('<?php echo JText::_('OS_PLEASE_SELECT_EMAIL'); ?>');
					form.email.focus();
					return;	
				}else if (!filter.test(form.email.value)){
					alert('<?php echo JText::_('OS_EMAIL_INVALID'); ?>');
					form.email.value = '';
					form.email.focus();
					return;
				}else if (form.country.value == '0'){
					alert('<?php echo JText::_('OS_PLEASE_SELECT_COUNTRY'); ?>');
					form.country.focus();
					return;
				}else if ((form.state.value == '0') && (form.nstate.value == "")){
					alert('<?php echo JText::_('OS_PLEASE_SELECT_STATE'); ?>');
					form.state.focus();
					return;	
				}else{
					if((pressbutton == "companies_apply") || (pressbutton == "companies_save")){
						allSelected(document.adminForm['users_selected[]']);
					}
					submitform( pressbutton );
					return;
				}
			}
		</script>
		<?php
	}
}
?>