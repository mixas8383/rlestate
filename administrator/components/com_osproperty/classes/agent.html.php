<?php
/*------------------------------------------------------------------------
# agent.html.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');


class HTML_OspropertyAgent{
	/**
	 * Extra field list HTML
	 *
	 * @param unknown_type $option
	 * @param unknown_type $rows
	 * @param unknown_type $pageNav
	 * @param unknown_type $lists
	 */
	function agent_list($option,$rows,$pageNav,$lists){
		global $jinput, $mainframe,$configClass;
		JHtml::_('behavior.multiselect');
		JHtml::_('behavior.modal', 'a.osmodal');
		JToolBarHelper::title(JText::_('OS_MANAGE_AGENTS'),"user");
		JToolBarHelper::addNew('agent_add');
		if (count($rows)){
			JToolBarHelper::editList('agent_edit');
			JToolBarHelper::deleteList(JText::_('OS_ARE_YOU_SURE_TO_REMOVE_ITEM'),'agent_remove');
			JToolBarHelper::publish('agent_publish');
			JToolBarHelper::unpublish('agent_unpublish');
		}
		JToolbarHelper::custom('cpanel_list','featured.png', 'featured_f2.png',JText::_('OS_DASHBOARD'),false);
		
		$tmpl = $jinput->getString('tmpl','');
		if($tmpl == "component"){
			$tmpl_url = "&tmpl=component";
		}else{
			$tmpl_url = "";
		}

		$listOrder	= $lists['filter_order'];
		$listDirn	= $lists['filter_order_Dir'];

		$saveOrder	= $listOrder == 'a.ordering';
		$ordering	= ($listOrder == 'a.ordering');

		if ($saveOrder)
		{
			$saveOrderingUrl = 'index.php?option=com_osproperty&task=agent_saveorderAjax';
			JHtml::_('sortablelist.sortable', 'agentList', 'adminForm', strtolower($listDirn), $saveOrderingUrl, false, true);
		}

		$customOptions = array(
			'filtersHidden'       => true,
			'defaultLimit'        => JFactory::getApplication()->get('list_limit', 20),
			'orderFieldSelector'  => '#filter_full_ordering'
		);

		JHtml::_('searchtools.form', '#adminForm', $customOptions);
		if (count($rows))
		{
			foreach ($rows as $item)
			{
				$ordering[$item->parent_id][] = $item->id;
			}
		}

		?>
		<form method="POST" action="index.php?option=com_osproperty&task=agent_list&layout=<?php echo $jinput->getString('layout','')?><?php echo $tmpl_url?>" name="adminForm" id="adminForm">
		<div class="row-fluid js-stools clearfix">
            <div class="span12 clearfix">
                <div class="span6 js-stools-container-bar">
                    <DIV class="btn-wrapper input-append">
                        <input type="text" name="keyword" placeholder="<?php echo JText::_('OS_SEARCH');?>" value="<?php echo $jinput->getString('keyword','')?>" class="input-medium" />
                        <button class="btn hasTooltip" title="" type="submit" data-original-title="<?php echo Jtext::_('OS_SEARCH');?>">
                            <i class="icon-search"></i>
                        </button>
                    </DIV>
                </div>
                <div class="span6 pull-right js-stools-container-list hidden-phone hidden-tablet shown">
                    <div class="ordering-select hidden-phone">
                        <div class="js-stools-field-list">
                            <?php echo OSPHelper::loadAgentTypeDropdownFilter($jinput->getInt('agent_type',-1),'chosen input-medium','onChange="javascript:document.adminForm.submit();"');?>
                        </div>
                        <div class="js-stools-field-list">
                            <?php echo $lists['filter_company'];?>
                        </div>
                        <div class="js-stools-field-list">
                            <?php echo $lists['filter_request']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div id="editcell">
        <?php
        if(count($rows) > 0) {
        ?>
		<table width="100%" class="adminlist table table-striped" id="agentList">
			<thead>
				<tr>
					<?php
					if($tmpl != "component"){
						?>
						<th width="5%" class="nowrap center hidden-phone">
							<?php echo JHtml::_('searchtools.sort', '', 'a.ordering', @$lists['filter_order_Dir'], @$lists['filter_order'], null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
						</th>
						<th width="3%" style="text-align:center;">
							<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('Jglobal $jinput,_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
						</th>
					<?php } ?>
					<th width="7%" style="text-align:center;">
						<?php echo JText::_("OS_IMAGE")?>
					</th>
					
					<th width="5%" style="text-align:center;">
						<?php echo JHTML::_('searchtools.sort',   JText::_('OS_TYPE'), 'a.agent_type', @$lists['filter_order_Dir'], @$lists['order'] ,'agent_list'); ?>
					</th>
					
					<th width="15%" style="text-align:left;">
						<?php echo JHTML::_('searchtools.sort',   JText::_('OS_NAME'), 'a.name', @$lists['filter_order_Dir'], @$lists['filter_order'] ,'agent_list'); ?>
					</th>
					
					<th width="10%" style="text-align:left;">
						<?php echo JHTML::_('searchtools.sort',   JText::_('Joomla User'), 'u.username', @$lists['filter_order_Dir'], @$lists['filter_order'],'agent_list' ); ?>
					</th>
					<th width="10%" style="text-align:left;">
						<?php echo JHTML::_('searchtools.sort',   JText::_('OS_COMPANY'), 'c.company_name', @$lists['filter_order_Dir'], @$lists['filter_order'],'agent_list' ); ?>
					</th>
					<th width="10%" style="text-align:left;">
						<?php echo JHTML::_('searchtools.sort',   JText::_('OS_EMAIL'), 'a.email', @$lists['filter_order_Dir'], @$lists['filter_order'],'agent_list' ); ?>
					</th>
					<?php
					if($tmpl != "component"){
						?>
						<th width="15%" style="text-align:center;">
							<?php echo JText::_('OS_FEATURED')."/ ".JText::_('OS_PUBLISH'); ?>
						</th>
						<?php
						if($configClass['auto_approval_agent_registration']==0){
						?>
						<th width="10%" style="text-align:center;">
							<?php echo JHTML::_('grid.sort',   JText::_('OS_APPROVED'), 'a.request_to_approval', @$lists['filter_order_Dir'], @$lists['filter_order'],'agent_list' ); ?>
						</th>
						<?php
						}
						?>
					<?php 
					} 
					?>
					<th style="text-align:center;" width="3%">
					<?php echo JHTML::_('grid.sort',   'ID', 'a.id', @$lists['filter_order_Dir'], @$lists['filter_order'] ,'agent_list'); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td width="100%" colspan="14" style="text-align:center;">
						<?php
							echo $pageNav->getListFooter();
						?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php
			$k = 0;
			$canChange = true;
			for ($i=0, $n=count($rows); $i < $n; $i++) {
				$row = $rows[$i];
				$checked = JHtml::_('grid.id', $i, $row->id);
				$link 		= JRoute::_( 'index.php?option=com_osproperty&task=agent_edit&cid[]='. $row->id );
				$published 	= JHTML::_('jgrid.published', $row->published, $i , 'agent_');
				$img 	= $row->request_to_approval ? 'tick.png' : 'publish_x.png';
				$alt = JText::_( 'OS_REQUEST_TO_APPROVAL' );
				$request_to_approval = JHtml::_('image','admin/'.$img, $alt, NULL, true);
				?>
				<tr class="<?php echo "row$k"; ?>" sortable-group-id="<?php echo $row->company_id; ?>" item-id="<?php echo $row->id ?>" parents="<?php echo $parentsStr ?>" level="0">
					<?php
					if($tmpl != "component"){
						?>
						<td class="order nowrap center hidden-phone" style="text-align:center;">
							<?php
							$iconClass = '';
							if (!$canChange)
							{
								//echo "1";
								$iconClass = ' inactive';
							}
							elseif (!$saveOrder)
							{
								//echo "2";
								$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
							}
							?>
							<span class="sortable-handler<?php echo $iconClass ?>">
								<span class="icon-menu"></span>
							</span>
							<?php if ($canChange && $saveOrder) : ?>
								<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $row->ordering; ?>" />
							<?php endif; ?>
						</td>
						
						<td align="center" style="text-align:center;"><?php echo $checked; ?></td>
					<?php } ?>
					<td align="center" style="text-align:center;">
						<?php
						
						if((file_exists(JPATH_ROOT.DS.'images'.DS.'osproperty'.DS.'agent'.DS.'thumbnail'.DS.$row->photo)) and ($row->photo != "")){
						?>
						<a class="osmodal" href="<?php echo PATH_URL_PHOTO_AGENT_FULL; ?><?php echo $row->photo?>">
							<img alt="" style="height:55px;" src="<?php echo PATH_URL_PHOTO_AGENT_THUMB?><?php echo $row->photo?>">
						</a>
						<?php
						}else{
							?>
							<img src="<?php echo JURI::root()?>components/com_osproperty/images/assets/noimage.jpg" style="height:55px" />
							<?php
						}
						?>
					</td>
					<td align="center" style="text-align:center;">
						<?php
						echo OSPHelper::loadAgentType($row->id);
						?>
					</td>
					<td align="left">
						<?php
						if($tmpl == "component"){
						?>
						<a class="pointer" onclick="if (window.parent) window.parent.jSelectUser_agent_id('<?php echo $row->id?>', '<?php echo str_replace("'","\'",$row->name);?>');">
						<?php	
						}else{
						?>
						<a href="<?php echo $link; ?>">
						<?php
						}
						?>
							<?php echo $row->name; ?>
						</a>
						<BR />
						(Alias: <?php echo $row->alias;?>)
					</td>
					
					<td align="left"><?php echo $row->username?> </td>
					
					<td><?php 
					if($row->company_name != ""){
						echo $row->company_name;
					}else{
						echo "--";
					}
					?></td>
					
					<td><a href="mailto:<?php echo $row->email?>" target="_blank"><?php echo $row->email?></a></td>
					<?php
					if($tmpl != "component"){
					?>
						<td align="center" style="text-align:center;">
							<div class="btn-group">
								<?php
								if($row->featured == 1){
									?>
									<a class="btn btn-micro active hasTooltip" href="index.php?option=com_osproperty&task=agent_changeunfeatured&cid[]=<?php echo $row->id?>&limitstart=<?php echo $pageNav->limitstart?>&limit=<?php echo $pageNav->limit?>" title="<?php echo JText::_('OS_CHANGE_FEATURED_STATUS');?>" style="color:orange;">
										<i class="osicon-star"></i>
									</a>
									<?php
								}else{
									?>
									<a class="btn btn-micro active hasTooltip" href="index.php?option=com_osproperty&task=agent_changefeatured&cid[]=<?php echo $row->id?>&v=1&limitstart=<?php echo $pageNav->limitstart?>&limit=<?php echo $pageNav->limit?>" title="<?php echo JText::_('OS_CHANGE_FEATURED_STATUS');?>" style="color:black;">
										<i class="osicon-star"></i>
									</a>
									<?php
								}
								?>
								<?php echo $published?>
							</div>
						</td>
						<?php
						if($configClass['auto_approval_agent_registration']==0){
						?>
						<td align="center" style="text-align:center;">
							<?php 
								if($row->request_to_approval == 1){
									echo JText::_('OS_NO');
								}else{
									echo JText::_('OS_YES');
								}
							?>
						</td>
						<?php
						}
					}//tmpl
					?>
					<td  style="text-align:center;">
						<?php echo $row->id;?>
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
		</div>
		<input type="hidden" name="option" value="com_osproperty" />
		<input type="hidden" name="task" value="agent_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order"  id="filter_order" value="<?php echo $lists['filter_order']; ?>" />
		<input type="hidden" name="filter_order_Dir" id="filter_order_Dir" value="<?php echo $lists['filter_order_Dir']; ?>" />
		<input type="hidden" name="filter_full_ordering" id="filter_full_ordering" value="" />
		</form>
		<?php
	}
	
	
	/**
	 * Agent field
	 *
	 * @param unknown_type $option
	 * @param unknown_type $row
	 * @param unknown_type $lists
	 */
	function editHTML($option,$row,$lists,$translatable){
		global $jinput, $mainframe,$_jversion,$configClass,$languages;
        $jinput->set( 'hidemainmenu', 1 );
		$db = JFactory::getDBO();
		JHtml::_('behavior.tooltip');
		if ($row->id){
			$title = ' ['.JText::_('OS_EDIT').']';
		}else{
			$title = ' ['.JText::_('OS_NEW').']';
		}
		JToolBarHelper::title(JText::_('OS_AGENT').'/'.JText::_('OS_OWNER').$title);
		JToolBarHelper::save('agent_save');
		JToolBarHelper::save2new('agent_new');
		JToolBarHelper::apply('agent_apply');
		JToolBarHelper::cancel('agent_cancel');
		
		$editor = JFactory::getEditor();
		?>
		<style>
		fieldset label, fieldset span.faux-label {
		    clear: right;
		}
		</style>
		<?php
		if (version_compare(JVERSION, '3.5', 'ge')){
		?>
			<script src="<?php echo JUri::root()?>media/jui/js/fielduser.min.js" type="text/javascript"></script>
		<?php } ?>
		<form method="POST" action="index.php" name="adminForm" id="adminForm" enctype="multipart/form-data">
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
			<table  width="100%" class="admintable" style="background-color:white;">
				<tr>
					<td width="65%" valign="top">
						<fieldset class="fieldset_detail" >
							<legend><?php echo JText::_("OS_DETAILS")?></legend>
							<table width="100%" >
								<tr>
									<td class="key"><?php echo JText::_('OS_TYPE'); ?></td>
									<td width="80%">
										<?php OSPHelper::loadAgentTypeDropdown($row->agent_type,"input-medium","");?>
									</td>
								</tr>
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
									<td class="key"><?php echo JText::_('OS_SELECT_JOOMLA_USER')?></td>
									<td>
										<?php 
										echo OspropertyAgent::getUserInput($row->user_id);
										?>
									</td>
								</tr>
								<tr>
									<td class="key"><?php echo JText::_('OS_EMAIL'); ?></td>
									<td width="80%"><input type="text" name="email" id="email" size="40" value="<?php echo $row->email?>" class="input-medium"></td>
								</tr>
								<tr>
									<td class="key"><?php echo JText::_('OS_NAME'); ?></td>
									<td width="80%"><input type="text" name="name" id="name" size="40" value="<?php echo $row->name?>" class="input-medium"></td>
								</tr>
								<tr>
									<td class="key"><?php echo JText::_('OS_ALIAS'); ?></td>
									<td width="80%"><input type="text" name="alias" id="alias" size="40" value="<?php echo $row->alias?>" class="input-medium"></td>
								</tr>
								<tr>
									<td class="key"><?php echo JText::_('OS_COMPANY'); ?></td>
									<td width="80%"><?php echo $lists['company_id']; ?></td>
								</tr>
								<tr>
									<td class="key"><?php echo JText::_('OS_LICENSE'); ?></td>
									<td width="80%"><input type="text" name="license" id="license" size="40" value="<?php echo $row->license?>"></td>
								</tr>
								<tr>
									<td class="key"><?php echo JText::_('OS_PUBLISHED'); ?></td>
									<td width="80%"><?php echo $lists['published'];?></td>
								</tr>
								<tr>
									<td class="key" valign="top"><?php echo JText::_('OS_BIO'); ?></td>
									<td width="80%" >
										<?php
										echo $editor->display( 'bio',  stripslashes($row->bio) , '95%', '250', '75', '20' ) ;
										?>
									</td>
								</tr>
							</table>
						</fieldset>
					</td>
					<td width="35%" valign="top">
						<fieldset class="fieldset_photo">
							<legend><?php echo JText::_('OS_PHOTO')?></legend>
							<table width="100%">
								<tr>
									<td width="100%">
										<?php if ($row->id && $row->photo){?>
											<a class="osmodal" href="<?php echo PATH_URL_PHOTO_AGENT_FULL; ?><?php echo $row->photo?>">
												<img style="width: 150px;" alt="" src="<?php echo PATH_URL_PHOTO_AGENT_THUMB?><?php echo $row->photo?>" />
											</a>
											<div style="clear:both;"></div>
											<input type="checkbox" name="remove_photo" value="1"><?php echo JText::_('Remove Photo')?>
											<div style="clear:both;"></div>
											
										<?php }?>
										<input type="file" name="file_photo" id="file_photo" size="40" onchange="javascript:checkUploadPhotoFiles('file_photo')" /> 
										<div class="clearfix"></div>
										(<?php echo Jtext::_('OS_ONLY_SUPPORT_JPG_IMAGES');?>)
										<input type="hidden" name="photo" id="photo" value="<?php echo $row->photo?>" />
									</td>
								</tr>
							</table>
						</fieldset>
						<fieldset class="fieldset_web">
							<legend><?php echo JText::_('OS_USER_ADDRESS')?></legend>
							<table width="100%">
								<?php
								if(HelperOspropertyCommon::checkCountry()){
								?>
								<tr>
									<td class="key"><?php echo JText::_('OS_COUNTRY'); ?></td>
									<td ><?php echo $lists['country']; ?></td>
								</tr>
								<?php
								}else{
									echo $lists['country'];
								}
								?>
								<tr>
									<td class="key"><?php echo JText::_('OS_STATE'); ?></td>
									<td >
										<div id="country_state">
											<?php echo $lists['states']; ?>
										</div>
									</td>
								</tr>
								<tr>
									<td class="key"><?php echo JText::_('OS_CITY'); ?></td>
									<td >
										<div id="city_div">
											<?php echo $lists['city']?>
										</div>
									</td>
								</tr>
								<tr>
									<td class="key"><?php echo JText::_('OS_ADDRESS'); ?></td>
									<td ><input type="text" name="address" id="address" size="40" value="<?php echo $row->address?>"></td>
								</tr>
							</table>
						</fieldset>

						<fieldset class="fieldset_web">
							<legend><?php echo JText::_('OS_OTHER_FIELDS')?></legend>
							<table width="100%">
								<tr>
									<td class="key" style="text-align:center;"><img alt="" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/phone.jpg"></td>
									<td><input type="text" name="phone" id="phone" size="40" value="<?php echo $row->phone?>" class="input-medium" placeholder="<?php echo Jtext::_('OS_PHONE');?>"></td>
								</tr>
								<tr>
									<td class="key" style="text-align:center;"><img alt="" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/mobile.jpg"></td>
									<td><input type="text" name="mobile" id="mobile" size="40" value="<?php echo $row->mobile?>" class="input-medium" placeholder="<?php echo Jtext::_('OS_MOBILE');?>" /></td>
								</tr>
								<tr>
									<td class="key" style="text-align:center;"><img alt="" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/fax.jpg"></td>
									<td><input type="text" name="fax" id="fax" size="40" value="<?php echo $row->fax?>" class="input-medium" placeholder="<?php echo Jtext::_('OS_FAX');?>" /></td>
								</tr>
								<tr>
									<td class="key" style="text-align:center;"><img alt="" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/skype.jpg"> </td>
									<td width="70%"><input type="text" name="skype" id="skype" size="40" maxlength="100" value="<?php echo $row->skype?>" class="input-medium" placeholder="<?php echo Jtext::_('Skype');?>"/></td>
								</tr>
								<tr>
									<td class="key" style="text-align:center;"><img alt="" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/msn.jpg"> </td>
									<td width="70%"><input type="text" name="msn" id="msn" size="40" maxlength="100" value="<?php echo $row->msn?>" class="input-medium" placeholder="<?php echo Jtext::_('Line Messages');?>"/></td>
								</tr>
								<tr>
									<td class="key" style="text-align:center;"><img alt="" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/gtalk.jpg"> </td>
									<td width="70%"><input type="text" name="gtalk" id="gtalk" size="40" maxlength="100" value="<?php echo $row->gtalk?>" class="input-medium" placeholder="<?php echo Jtext::_('GTalk');?>"/></td>
								</tr>
								<tr>
									<td class="key" style="text-align:center;"><img alt="" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/facebook.jpg"> </td>
									<td width="70%"><input type="text" name="facebook" id="facebook" size="40" maxlength="100" value="<?php echo $row->facebook?>" class="input-medium" placeholder="<?php echo Jtext::_('Facebook');?>" /></td>
								</tr>
							</table>
						</fieldset>
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
										<td class="key" valign="top"><?php echo JText::_('OS_BIO'); ?></td>
										<td width="80%" >
											<?php
											echo $editor->display( 'bio_'.$sef,  stripslashes($row->{'bio_'.$sef}) , '95%', '250', '75', '20',false ) ;
											?>
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
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		</form>
		<script type="text/javascript">
			var live_site = '<?php echo JURI::root()?>';
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
				var user_id = document.getElementById('user_id_id');
                if(user_id != null) {
                    user_id = user_id.value;
                }else{
                    user_id = document.adminForm.user_id.value;
                }
				user_id = parseInt(user_id);
				var username = document.getElementById('username');
				var password = document.getElementById('password');

				var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if (pressbutton == 'agent_cancel'){
					submitform( pressbutton );
					return;
				}else if (form.name.value == ''){
					alert('<?php echo JText::_('OS_PLEASE_ENTER_AGENT_NAME'); ?>');
					form.name.focus();
					return;
				}else if ((user_id == 0) && (username.value == "") && (password.value == "")){
					alert('<?php echo JText::_('OS_PLEASE_SELECT_OR_CREATE_NEW_JOOMLA_USER_FOR_THIS_AGENT'); ?>');
					form.username.focus();
					return;
				}else if (form.email.value == ''){
					alert('<?php echo JText::_('OS_PLEASE_ENTER_EMAIL'); ?>');
					form.email.focus();
					return;
				}else if (!filter.test(form.email.value)){
					alert('<?php echo JText::_('OS_EMAIL_INVALID'); ?>');
					form.email.value = '';
					form.email.focus();
					return;	
				}else{
					submitform( pressbutton );
					return;
				}
			}
		</script>
		<?php
	}
}
?>