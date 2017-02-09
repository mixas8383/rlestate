<?php
/*------------------------------------------------------------------------
# country.html.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');


class HTML_OspropertyCountry{
	/**
	 * Extra field list HTML
	 *
	 * @param unknown_type $option
	 * @param unknown_type $rows
	 * @param unknown_type $pageNav
	 * @param unknown_type $lists
	 */
	function country_list($option,$rows,$pageNav,$lists,$modal,$keyword){
		global $mainframe;
		JHtml::_('behavior.multiselect');
		JToolBarHelper::title(JText::_('OS_MANAGE_COUNTRIES'),"folder");
		if (count($rows)){
			JToolBarHelper::editList('country_edit');
		}
		JToolbarHelper::custom('cpanel_list','featured.png', 'featured_f2.png',JText::_('OS_DASHBOARD'),false);
		?>
		<form method="POST" action="index.php?option=com_osproperty&task=country_list" name="adminForm" id="adminForm">
		<table  width="100%">
			<tr>
				<td width="100%">
					<input type="text" name="keyword" value="<?php echo $keyword;?>" class="input-medium search-query" placeholder="<?php echo JText::_('OS_KEYWORD'); ?>"/>
					<input type="submit" class="btn btn-primary" value="<?php echo JText::_('OS_SUBMIT')?>" />
				</td>
			</tr>
		</table>
		<table class="adminlist table table-striped">
			<thead>
				<tr>
					<th width="5%" style="text-align:center;">
					#
					</th>
					<th width="90%">
						<?php echo JHTML::_('grid.sort',   JText::_('OS_COUNTRY_NAME'), 'country_name', @$lists['order_Dir'], @$lists['order'] ,'country_list'); ?>
					</th>
					<th width="5%" style="text-align:center;">
						<?php echo JHTML::_('grid.sort',   JText::_('ID'), 'id', @$lists['order_Dir'], @$lists['order'] ,'country_list'); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td width="100%" colspan="7" style="text-align:center;">
						<?php
							echo $pageNav->getListFooter();
						?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php
			$db = JFactory::getDBO();
			$k = 0;
			for ($i=0, $n=count($rows); $i < $n; $i++) {
				$row = $rows[$i];
				$checked = JHtml::_('grid.id', $i, $row->id);
				$link 		= JRoute::_( 'index.php?option=com_osproperty&task=country_edit&cid[]='. $row->id );
				$published 	= JHTML::_('jgrid.published', $row->published, $i, 'country_');
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td align="center" style="text-align:center;">
						<?php echo $pageNav->getRowOffset( $i ); ?>
					</td>
					<td align="left">
						<?php
						if(file_exists(JPATH_ROOT.'/media/com_osproperty/flags/'.strtolower($row->country_code).'.png')){
							?>
							<img style="width:16px;" src="<?php echo JUri::root() ?>media/com_osproperty/flags/<?php echo strtolower($row->country_code); ?>.png" />
							<?php
						}
						?>
						<a href="<?php echo $link; ?>">
							<?php echo $row->country_name; ?>
						</a>
					</td>
					<td style="text-align:center;">
						<?php echo $row->id;?>
					</td>
				</tr>
			<?php
				$k = 1 - $k;	
			}
			?>
			</tbody>
		</table>
		<input type="hidden" name="option" value="com_osproperty" />
		<input type="hidden" name="task" value="country_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $lists['order'];?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir'];?>"  />
		<input type="hidden" name="modal" value="<?php echo $modal?>" />
		<?php
		if($modal == 1){
		?>
			<input type="hidden" name="tmpl" id="tmpl" value="component" />
		<?php
		}
		?>
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
		global $mainframe,$languages,$jinput;
		$jinput->set( 'hidemainmenu', 1 );
		$db = JFactory::getDBO();
		JHtml::_('behavior.tooltip');
		if ($row->id){
			$title = ' ['.JText::_('OS_EDIT').']';
		}else{
			$title = ' ['.JText::_('OS_NEW').']';
		}
		JToolBarHelper::title(JText::_('OS_COUNTRY').$title);
		JToolBarHelper::save('country_save');
		JToolBarHelper::apply('country_apply');
		JToolBarHelper::cancel('country_cancel');
		?>
		<form method="POST" action="index.php" name="adminForm" id="adminForm">
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
			<table width="100%" class="admintable" style="background-color:white;">
				<tr>
					<td class="key">
						<?php echo JText::_('OS_COUNTRY_NAME'); ?>
					</td>
					<td>
						<input type="text" name="country_name" id="country_name" size="40" value="<?php echo $row->country_name;?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo JText::_('OS_COUNTRY_CODE')?>
					</td>
					<td>
						<input type="text" name="country_code" id="country_code" size="40" value="<?php echo $row->country_code;?>" disabled />
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
										<td class="key">
											<?php echo JText::_('OS_COUNTRY_NAME'); ?>
										</td>
										<td>
											<input type="text" name="country_name_<?php echo $sef; ?>" id="country_name_<?php echo $sef; ?>" size="40" value="<?php echo $row->{'country_name_'.$sef}?>" />
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
		<?php if ($_jversion == "1.5"){?>
			function submitbutton(pressbutton)
		<?php }else{?>
			Joomla.submitbutton = function(pressbutton)
		<?php }?>
			{
				form = document.adminForm;
				if (pressbutton == 'country_cancel'){
					submitform( pressbutton );
					return;
				}else if (form.country_name.value == ''){
					alert('<?php echo JText::_('OS_PLEASE_ENTER_COUNTRY'); ?>');
					form.country_name.focus();
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