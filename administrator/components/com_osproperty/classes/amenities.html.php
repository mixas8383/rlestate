<?php
/*------------------------------------------------------------------------
# amenities.html.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');


class HTML_OspropertyAmenities{
	/**
	 * Extra field list HTML
	 *
	 * @param unknown_type $option
	 * @param unknown_type $rows
	 * @param unknown_type $pageNav
	 * @param unknown_type $lists
	 */
	function amenities_list($option,$rows,$pageNav,$lists){
		global $jinput, $mainframe,$_jversion;
		JHtml::_('behavior.multiselect');
		JToolBarHelper::title(JText::_('OS_MANAGE_CONVENIENCE'),"star");
		JToolBarHelper::addNew('amenities_add');
		if (count($rows)){
			JToolBarHelper::editList('amenities_edit');
			JToolBarHelper::deleteList(JText::_('OS_ARE_YOU_SURE_TO_REMOVE_ITEM'),'amenities_remove');
			JToolBarHelper::publish('amenities_publish');
			JToolBarHelper::unpublish('amenities_unpublish');
		}
		JToolbarHelper::custom('cpanel_list','featured.png', 'featured_f2.png',JText::_('OS_DASHBOARD'),false);

		$listOrder	= $lists['filter_order'];
		$listDirn	= $lists['filter_order_Dir'];

		$saveOrder	= $listOrder == 'ordering';
		$ordering	= ($listOrder == 'ordering');

		if ($saveOrder)
		{
			$saveOrderingUrl = 'index.php?option=com_osproperty&task=amenities_saveorderAjax';
			JHtml::_('sortablelist.sortable', 'amenitiesList', 'adminForm', strtolower($listDirn), $saveOrderingUrl, false, true);
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
		<form method="POST" action="index.php?option=com_osproperty&task=amenities_list" name="adminForm" id="adminForm">
		<table  width="100%">
			<tr>
				<td width="50%" class="pull-left">
                    <DIV class="btn-wrapper input-append">
                        <input type="text" name="keyword" placeholder="<?php echo JText::_('OS_SEARCH');?>" value="<?php echo $jinput->getString('keyword','')?>" class="input-medium" />
                        <button class="btn hasTooltip" title="" type="submit" data-original-title="<?php echo Jtext::_('OS_SEARCH');?>">
                            <i class="icon-search"></i>
                        </button>
                    </DIV>
				</td>
                <td width="50%" style="text-align:right;">
                    <?php echo $lists['categories']; ?>
                </td>
			</tr>
		</table>
		<table class="table table-striped" id="amenitiesList">
			<thead>
				<tr>
					<th width="5%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('searchtools.sort', '', 'ordering', @$lists['filter_order_Dir'], @$lists['filter_order'], null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
					</th>
					<th width="3%">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('Jglobal $jinput,_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
					</th>
					<th width="40%">
						<?php echo JHTML::_('grid.sort',   JText::_('OS_AMENITY_NAME'), 'amenities', @$lists['order_Dir'], @$lists['order'] ,'amenities_list'); ?>
					</th>
					<th width="25%">
						<?php echo JHTML::_('grid.sort',   JText::_('OS_CATEGORY'), 'category_id', @$lists['order_Dir'], @$lists['order'] ,'amenities_list'); ?>
					</th>
					<th width="10%" style="text-align:center;">
						<?php echo JHTML::_('grid.sort',   JText::_('OS_PUBLISH'), 'published', @$lists['order_Dir'], @$lists['order']  ,'amenities_list'); ?>
					</th>
					<th width="5%">
						<?php echo JHTML::_('grid.sort',   JText::_('ID'), 'id', @$lists['order_Dir'], @$lists['order']  ,'amenities_list'); ?>
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
			$canChange = true;
			for ($i=0, $n=count($rows); $i < $n; $i++) {
				$row = $rows[$i];
				$checked = JHtml::_('grid.id', $i, $row->id);
				$link 		= JRoute::_( 'index.php?option=com_osproperty&task=amenities_edit&cid[]='. $row->id );
				$published 	= JHTML::_('jgrid.published', $row->published, $i, 'amenities_');
				$orderkey   = array_search($row->id, $children[$row->parent_id]);
				?>
				<tr class="<?php echo "row$k"; ?>" sortable-group-id="<?php echo $row->category_id; ?>" item-id="<?php echo $row->id ?>" parents="<?php echo $parentsStr ?>" level="0">
					<td class="order nowrap center hidden-phone" style="text-align:center;">
						<?php
						$iconClass = '';
						if (!$canChange){
							$iconClass = ' inactive';
						}
						elseif (!$saveOrder){
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
					<td align="center">
						<?php echo $checked; ?>
					</td>
					<td align="left">
						<a href="<?php echo $link; ?>">
							<?php echo $row->amenities; ?>
						</a>
					</td>
					<td align="left">
						<?php echo OspropertyAmenities::returnAmenityCategory($row->category_id);?>
					</td>
					<td align="center" style="text-align:center;">
						<?php echo $published?>
					</td>
					<td align="center">
						<?php echo $row->id;?>
					</td>
				</tr>
			<?php
				$k = 1 - $k;	
			}
			?>
			</tbody>
		</table>
		<input type="hidden" name="option" value="com_osproperty">
		<input type="hidden" name="task" value="amenities_list">
		<input type="hidden" name="boxchecked" value="0">
		<input type="hidden" name="filter_order" value="<?php echo $lists['order'];?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir'];?>" />
		<input type="hidden" name="filter_full_ordering" id="filter_full_ordering" value="" />
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
		global $jinput, $mainframe,$languages;
        $jinput->set( 'hidemainmenu', 1 );
		$db = JFactory::getDBO();
		JHtml::_('behavior.tooltip');
		if ($row->id){
			$title = ' ['.JText::_('OS_EDIT').']';
		}else{
			$title = ' ['.JText::_('OS_NEW').']';
		}
		JToolBarHelper::title(JText::_('Convenience').$title);
		JToolBarHelper::save('amenities_save');
		JToolBarHelper::save2new('amenities_new');
		JToolbarHelper::apply('amenities_apply');
		JToolBarHelper::cancel('amenities_cancel');
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
			<table  width="100%" class="admintable" style="background-color:white;">
				<tr>
					<td class="key">
						<?php echo JText::_('OS_CONVENIENCE_NAME'); ?>
					</td>
					<td>
						<input type="text" name="amenities" id="amenities" size="40" value="<?php echo $row->amenities?>">
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo JText::_('OS_CATEGORY'); ?>
					</td>
					<td>
						<?php 
							echo OspropertyAmenities::makeAmenityCategoryDropdown($row->category_id);
						?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo JText::_('OS_PUBLISHED')?>
					</td>
					<td>
						<?php
						echo $lists['state'];
						?>
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
											<?php echo JText::_('OS_CONVENIENCE_NAME'); ?>
										</td>
										<td>
											<input type="text" name="amenities_<?php echo $sef; ?>" id="amenities_<?php echo $sef; ?>" size="40" value="<?php echo $row->{'amenities_'.$sef}?>">
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
		<input type="hidden" name="boxchecked" value="0" />
		</form>
		<script type="text/javascript">
				Joomla.submitbutton = function(pressbutton)
				{
				form = document.adminForm;
				if (pressbutton == 'amenities_cancel'){
					submitform( pressbutton );
					return;
				}else if (form.amenities.value == ''){
					alert('<?php echo JText::_('OS_PLEASE_ENTER_AMENINTY_NAME'); ?>');
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