<?php
/*------------------------------------------------------------------------
# fieldgroup.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

class HTML_OspropertyFieldgroup{
	function listfieldgroup($option,$rows,$pageNav,$lists){
		global $mainframe,$_jversion,$jinput;
		
		JHtml::_('behavior.multiselect');
		JToolBarHelper::title(JText::_('OS_MANAGE_FIELD_GROUPS'),"list");
		JToolBarHelper::addNew('fieldgroup_add');
		if (count($rows)){
			JToolBarHelper::editList('fieldgroup_edit');
			JToolBarHelper::deleteList('Are you sure you want to remove item(s)?','fieldgroup_remove');
			JToolBarHelper::publish('fieldgroup_publish');
			JToolBarHelper::unpublish('fieldgroup_unpublish');
		}
		JToolbarHelper::custom('cpanel_list','featured.png', 'featured_f2.png',JText::_('OS_DASHBOARD'),false);

		$listOrder	= $lists['filter_order'];
		$listDirn	= $lists['filter_order_Dir'];

		$saveOrder	= $listOrder == 'ordering';
		$ordering	= ($listOrder == 'ordering');

		if ($saveOrder)
		{
			$saveOrderingUrl = 'index.php?option=com_osproperty&task=fieldgroup_saveorderAjax';
			JHtml::_('sortablelist.sortable', 'groupList', 'adminForm', strtolower($listDirn), $saveOrderingUrl, false, true);
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
		
		<form method="POST" action="index.php?option=com_osproperty&task=fieldgroup_list" name="adminForm" id="adminForm">
		<table  width="100%">
			<tr>
				<td width="100%">
                    <DIV class="btn-wrapper input-append">
                        <input type="text" name="keyword" placeholder="<?php echo JText::_('OS_SEARCH');?>" value="<?php echo $jinput->getString('keyword','')?>" class="input-medium" />
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
		<table class="adminlist table table-striped" id="groupList">
			<thead>
				<tr>
					<th width="3%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('searchtools.sort', '', 'ordering', @$lists['filter_order_Dir'], @$lists['filter_order'], null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
					</th>
					<th width="2%" style="text-align:center;">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
					</th>
					<th width="30%">
						<?php echo JHTML::_('searchtools.sort',   'Group name', 'group_name', @$lists['filter_order_Dir'], @$lists['filter_order'] ,'fieldgroup_list'); ?>
					</th>
					<th width="10%">
						<?php echo JHTML::_('searchtools.sort',   JText::_('OS_ACCESS') , 'access', @$lists['filter_order_Dir'], @$lists['filter_order'] ,'fieldgroup_list'); ?>
					</th>
					<th width="10%" style="text-align:center;">
						<?php echo JText::_('OS_ENTRIES')?>
					</th>
					<!--
					<th width="15%" style="text-align:center;">
						<?php echo JHTML::_('grid.sort',   'Ordering', 'ordering', @$lists['filter_order_Dir'], @$lists['filter_order'] ,'fieldgroup_list'); ?>
						<?php echo JHTML::_('grid.order',  $rows ,"filesave.png","fieldgroup_saveorder"); ?>
					</th>
					-->
					<th width="5%" style="text-align:center;">
						<?php echo JText::_('OS_PUBLISH')?>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$db = JFactory::getDBO();
			$k = 0;
			$canChange = true;
			for ($i=0, $n=count($rows); $i < $n; $i++) {
				$row = $rows[$i];
				$orderkey = array_search($row->id, $children[$row->parent_id]);
				$checked = JHtml::_('grid.id', $i, $row->id);
				$link 		= JRoute::_( 'index.php?option=com_osproperty&task=fieldgroup_edit&cid[]='. $row->id );
				$published 	= JHTML::_('jgrid.published', $row->published, $i, 'fieldgroup_');
				$orderkey   = array_search($row->id, $ordering[$row->parent_id]);
				?>
				<tr class="<?php echo "row$k"; ?>" sortable-group-id="<?php echo $row->parent_id; ?>" item-id="<?php echo $row->id ?>" parents="<?php echo $parentsStr ?>" level="0">
					<td class="order nowrap center hidden-phone" style="text-align:center;">
						<?php
						$iconClass = '';
						if (!$canChange)
						{
							$iconClass = ' inactive';
						}
						elseif (!$saveOrder)
						{
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
					<td align="center" style="text-align:center;">
						<?php echo $checked; ?>
					</td>
					<td align="left">
						<a href="<?php echo $link?>">
							<?php echo $row->group_name; ?>
						</a>
					</td>
					<TD align="left">
						<?php
                        echo OSPHelper::returnAccessLevel($row->access);
						?>
					</TD>
					<td align="center" style="text-align:center;">
						<?php
						$db->setQuery("Select count(id) from #__osrs_extra_fields where group_id = '$row->id'");
						echo $db->loadResult();
						?>
					</td>
					<td align="center" style="text-align:center;">
						<?php echo $published?>
					</td>
				</tr>
			<?php
				$k = 1 - $k;	
			}
			?>
			</tbody>
			<tfoot>
				<tr>
					<td width="100%" colspan="7" style="text-align:center;">
						<?php
							echo $pageNav->getListFooter();
						?>
					</td>
				</tr>
			</tfoot>
		</table>
        <?php
        }else{
            ?>
            <div class="alert alert-no-items"><?php echo Jtext::_('OS_NO_MATCHING_RESULTS');?></div>
        <?php
        }
        ?>
		<input type="hidden" name="option" value="com_osproperty">
		<input type="hidden" name="task" value="fieldgroup_list">
		<input type="hidden" name="boxchecked" value="0">
		<input type="hidden" name="filter_order"  id="filter_order" value="<?php echo $lists['filter_order']; ?>" />
		<input type="hidden" name="filter_order_Dir" id="filter_order_Dir" value="<?php echo $lists['filter_order_Dir']; ?>" />
		<input type="hidden" name="filter_full_ordering" id="filter_full_ordering" value="" />
		</form>
		<?php
	}
	
	
	/**
	 * Edit Group
	 *
	 * @param unknown_type $option
	 * @param unknown_type $row
	 * @param unknown_type $lists
	 */
	function editGroup($option,$row,$lists,$translatable){
		global $mainframe,$languages;
		if($row->id > 0){
			$edit = "Edit";
		}else{
			$edit = "Add new";
		}
		JToolBarHelper::title(JText::_('Field group ['.$edit.']'));
		JToolBarHelper::save('fieldgroup_save');
		JToolBarHelper::save2new('fieldgroup_new');
		JToolBarHelper::apply('fieldgroup_apply');
		JToolBarHelper::cancel('fieldgroup_gotolist');
		?>
		<script language="javascript">
		Joomla.submitbutton = function(task) {
			var form = document.adminForm;
			group_name = form.group_name;
			if((task == "fieldgroup_save") || (task == "fieldgroup_apply")){
				if(group_name.value == ""){
					alert("<?php echo JText::_('OS_PLEASE_ENTER_FIELD_GROUP_TITLE')?>");
					group_name.focus();
				}else{
					Joomla.submitform(task);
				}
			}else{
				Joomla.submitform(task);
			}
		}
		</script>
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
						<?php echo JText::_('OS_FIELDGROUP_TITLE')?>
					</td>
					<td>
						<input type="text" name="group_name" size="50" value="<?php echo $row->group_name?>">
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo JText::_('OS_ACCESS')?>
					</td>
					<td>
						<?php echo $lists['access']?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo JText::_('OS_PUBLISHED')?>
					</td>
					<td>
						<?php echo $lists['state']?>
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
											<?php echo JText::_('OS_FIELDGROUP_TITLE')?>
										</td>
										<td>
											<input type="text" name="group_name_<?php echo $sef; ?>" size="50" value="<?php echo $row->{'group_name_'.$sef}?>">
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
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		</form>
		<?php
	}
	
	
}
?>