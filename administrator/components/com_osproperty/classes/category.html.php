<?php
/*------------------------------------------------------------------------
# category.html.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');


class HTML_OspropertyCategories{
	/**
	 * List categories
	 *
	 * @param unknown_type $option
	 * @param unknown_type $rows
	 * @param unknown_type $pageNav
	 * @param unknown_type $lists
	 */
	function listCategories($option,$rows,$pageNav,$lists,$children){
		global $mainframe,$jinput;
		JHTML::_('behavior.modal');
		JHtml::_('behavior.multiselect');
		JToolBarHelper::title(JText::_('OS_MANAGE_CATEGORIES'),"folder");
		JToolBarHelper::addNew('categories_add');
		if (count($rows)){
			JToolBarHelper::editList('categories_edit');
			JToolBarHelper::deleteList(JText::_('OS_ARE_YOU_SURE_TO_REMOVE_ITEM'),'categories_remove');
			JToolBarHelper::publish('categories_publish');
			JToolBarHelper::unpublish('categories_unpublish');
		}
		JToolbarHelper::custom('cpanel_list','featured.png', 'featured_f2.png',JText::_('OS_DASHBOARD'),false);
		
		$listOrder	= $lists['filter_order'];
		$listDirn	= $lists['filter_order_Dir'];

		$saveOrder	= $listOrder == 'ordering';
		$ordering	= ($listOrder == 'ordering');

		if ($saveOrder)
		{
			$saveOrderingUrl = 'index.php?option=com_osproperty&task=categories_saveorderAjax';
			JHtml::_('sortablelist.sortable', 'categoryList', 'adminForm', strtolower($listDirn), $saveOrderingUrl, false, true);
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

		$db = JFactory::getDBO();
		?>
		<form method="POST" action="index.php?option=com_osproperty&task=categories_list" name="adminForm" id="adminForm">
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
		<table class="adminlist table table-striped" width="100%" id="categoryList"> 
			<thead>
				<tr>
					<th width="5%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('searchtools.sort', '', 'ordering', @$lists['filter_order_Dir'], @$lists['filter_order'], null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
					</th>
					<th width="3%" style="text-align:center;">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
					</th>
					<th width="5%" style="text-align:center;">
						<?php echo Jtext::_('OS_PHOTO')?>
					</th>
					<th width="40%">
						<?php echo JHTML::_('searchtools.sort',   JText::_('OS_CATEGORY_NAME'), 'category_name', @$lists['filter_order_Dir'], @$lists['filter_order'] ); ?>
					</th>
					<th width="15%">
						<?php echo JHTML::_('searchtools.sort',   JText::_('OS_ACCESS'), 'access', @$lists['filter_order_Dir'], @$lists['filter_order'] ); ?>
					</th>
					<th width="10%" style="text-align:center;">
						<?php echo JText::_('OS_PROPERTIES');?>
					</th>
					<th width="10%" style="text-align:center;">
						<?php echo JHTML::_('searchtools.sort',  Jtext::_('OS_PUBLISH'), 'published', @$lists['filter_order_Dir'], @$lists['filter_order'] ); ?>
					</th>
					<th width="5%" style="text-align:center;">
						<?php echo JHTML::_('grid.sort',   'ID', 'id', @$lists['filter_order_Dir'], @$lists['filter_order'] ); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td width="100%" colspan="10" style="text-align:center;">
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
				$orderkey   = array_search($row->id, $children[$row->parent_id]);
				$checked    = JHtml::_('grid.id', $i, $row->id);
				$link 		= JRoute::_( 'index.php?option=com_osproperty&task=categories_edit&cid[]='. $row->id );
				$published 	= JHTML::_('jgrid.published', $row->published, $i , 'categories_');
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
					<td align="center" style="text-align:center;">
						<?php
						if($row->category_image == ""){
							?>
							<img src="<?php echo JURI::root()?>components/com_osproperty/images/assets/noimage.png" style="height:50px;">
							<?php
						}else{
							?>
							<a href="<?php echo JURI::root()?>images/osproperty/category/<?php echo $row->category_image?>" class="modal">
								<img src="<?php echo JURI::root()?>images/osproperty/category/thumbnail/<?php echo $row->category_image?>" style="height:50px;" border="0">
							</a>
							<?php
						}
						?>
					</td>
					<td align="left">
						
						<a href="<?php echo $link?>">
							<?php echo $row->treename;?>
						</a>
						<BR />
						(Alias: <?php echo $row->category_alias;?>)
					</td>
					<td align="center" >
						<?php
                        echo OSPHelper::returnAccessLevel($row->access);
						?>
					</td>
					<td align="center" style="text-align:center;">
						<?php
						//$db->setQuery("Select count(id) from #__osrs_properties where category_id = '$row->id'");
						$total = 0;
						echo OspropertyCategories::countProperties($row->id,$total);
						?>
					</td>
					<td align="center" style="text-align:center;">
						<?php echo $published?>
					</td>
					<td align="center" style="text-align:center;">
						<?php echo $row->id?>
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
		<input type="hidden" name="task" value="categories_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order"  id="filter_order" value="<?php echo $lists['filter_order']; ?>" />
		<input type="hidden" name="filter_order_Dir" id="filter_order_Dir" value="<?php echo $lists['filter_order_Dir']; ?>" />
		<input type="hidden" name="filter_full_ordering" id="filter_full_ordering" value="" />
		</form>
		<?php
	}
	
	
	/**
	 * Edit Categories
	 *
	 * @param unknown_type $option
	 * @param unknown_type $row
	 * @param unknown_type $lists
	 */
	function editCategory($option,$row,$lists,$translatable){
		global $mainframe,$languages,$configClass;
		JHTML::_('behavior.modal');
		$db = JFactory::getDBO();
		if($row->id > 0){
			$edit = JText::_('OS_EDIT');
		}else{
			$edit = JText::_('OS_ADD');
		}
		JToolBarHelper::title(JText::_('OS_CATEGORY').JText::_(' ['.$edit.']'));
		JToolBarHelper::save('categories_save');
		JToolBarHelper::save2new('categories_new');
		JToolBarHelper::apply('categories_apply');
		JToolBarHelper::cancel('categories_gotolist');
		$editor = &JFactory::getEditor();
		?>
		<script language="javascript">
		Joomla.submitbutton = function(task) {
			var form = document.adminForm;
			category_name = form.category_name;
			if((task == "categories_save") || (task == "categories_apply")){
				if(category_name.value == ""){
					alert("<?php echo JText::_('OS_PLEASE_ENTER_CATEGORY_NAME')?>");
					category_name.focus();
				}else{
					Joomla.submitform(task);
				}
			}else{
				Joomla.submitform(task);
			}
		}
		</script>
		
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
				<td class="key" width="23%">
					<?php echo JText::_('OS_CATEGORY_NAME')?>
				</td>
				<td width="80%">
					<input type="text" name="category_name" id="category_name" size="40" value="<?php echo $row->category_name?>" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<?php echo JText::_('OS_ALIAS')?>
				</td>
				<td>
					<input type="text" name="category_alias" id="category_alias" size="40" value="<?php echo $row->category_alias?>" />
				</td>
			</tr>
			<tr>
				<td class="key" valign="top">
					<?php echo JText::_('OS_PARENT_CAT')?>
				</td>
				<td>
					<?php echo $lists['parent']?>
				</td>
			</tr>
			<tr>
				<td class="key" valign="top">
					<?php echo JText::_('OS_PHOTO')?>
				</td>
				<td>
					<?php
					if($row->category_image){
						?>
						<a href="<?php echo JURI::root()?>images/osproperty/category/<?php echo $row->category_image?>" class="modal">
						<img src="<?php echo JURI::root()?>images/osproperty/category/thumbnail/<?php echo $row->category_image?>" border="0" />
						</a>
						<BR>
						<input type="checkbox" name="remove_photo" id="remove_photo" value="0" onclick="javascript:changeValue('remove_photo')" /> &nbsp;<b><?php echo JText::_('OS_REMOVE_PHOTO');?></b><BR />
						<?php
					}
					?>
					<input type="file" name="photo" id="photo" size="40" onchange="javascript:checkUploadPhotoFiles('photo')"> (<?php echo Jtext::_('OS_ONLY_SUPPORT_JPG_IMAGES');?>)
				</td>
			</tr>
			<tr>
				<td class="key" valign="top">
					<?php echo JText::_('OS_ACCESS')?>
				</td>
				<td>
					<?php echo $lists['access']?>
				</td>
			</tr>
			<!--
			<tr>
				<td class="key" valign="top">
					<?php echo JText::_('OS_DEFAULT_ORDERING')?>
				</td>
				<td>
					<?php echo $lists['ordering']?>
				</td>
			</tr>
			-->
			<tr>
				<td class="key" valign="top">
					<?php echo JText::_('OS_PUBLISH')?>
				</td>
				<td>
					<?php echo $lists['state']?>
				</td>
			</tr>
			<tr>
				<td class="key" valign="top">
					<?php echo JText::_('OS_META_DESCRIPTION')?>
				</td>
				<td>
					<textarea name="category_meta" id="category_meta" style="width:300px !important;"><?php echo $row->category_meta; ?></textarea>
				</td>
			</tr>
			<tr>
				<td class="key" valign="top">
					<?php echo JText::_('OS_DESCRIPTION')?>
				</td>
				<td>
					<?php echo $editor->display( 'category_description',  stripslashes($row->category_description) , '60%', '200', '55', '20' ) ; ?>
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
										<td class="key"><?php echo JText::_('OS_CATEGORY_NAME'); ?></td>
										<td >
											<input type="text" name="category_name_<?php echo $sef; ?>" id="category_name_<?php echo $sef; ?>" size="40" value="<?php echo $row->{'category_name_'.$sef}?>" />
										</td>
									</tr>
									<tr>
										<td class="key">
											<?php echo JText::_('OS_ALIAS')?>
										</td>
										<td>
											<input type="text" name="category_alias_<?php echo $sef; ?>" id="category_alias_<?php echo $sef; ?>" size="40" value="<?php echo $row->{'category_alias_'.$sef}?>" />
										</td>
									</tr>
									<tr>
										<td class="key" valign="top">
											<?php echo JText::_('OS_DESCRIPTION')?>
										</td>
										<td>
											<?php echo $editor->display( 'category_description_'.$sef,  stripslashes($row->{'category_description_'.$sef}) , '80%', '250', '75', '20' ) ; ?>
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
		<input type="hidden" name="MAX_FILE_SIZE" value="9000000000" />
		</form>
		<?php
	}
}
?>