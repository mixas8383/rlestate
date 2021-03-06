<?php 
/** 
 * @package JMAP::METAINFO::administrator::components::com_jmap
 * @subpackage views
 * @subpackage metainfo
 * @subpackage tmpl
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' ); 
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<table class="full headerlist">
		<tr>
			<td id="alert_append" align="left" width="65%">
				<span class="input-group">
				  <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span> <?php echo JText::_('COM_JMAP_FILTER_ONPAGE' ); ?>:</span>
				  <input type="text" name="search" id="search" value="<?php echo $this->searchword;?>" class="text_area"/>
				</span>

				<button class="btn btn-primary btn-xs" onclick="this.form.submit();"><?php echo JText::_('COM_JMAP_GO' ); ?></button>
				<button class="btn btn-primary btn-xs" onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_('COM_JMAP_RESET' ); ?></button>
			</td>
			<td>
				<?php
				echo $this->lists['state'];
				echo $this->pagination->getLimitBox();
				?>
			</td>
		</tr>
		<tr>
			<td colspan="100%">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</table>

	<table class="adminlist table table-striped table-hover">
	<thead>
		<tr>
			<th style="width:1%">
				<?php echo JText::_('COM_JMAP_NUM' ); ?>
			</th>
			<th class="title">
				<?php echo JHTML::_('grid.sort', 'COM_JMAP_METAINFO_LINK', 'link', @$this->orders['order_Dir'], @$this->orders['order'], 'metainfo.display'); ?>
			</th>
			<th style="width:15%">
				<?php echo JText::_('COM_JMAP_METATITLE' ); ?>
			</th>
			<th style="width:15%">
				<?php echo JText::_('COM_JMAP_METADESC' ); ?>
			</th>
			<th style="width:10%">
				<?php echo JText::_('COM_JMAP_METAROBOTS' ); ?>
			</th>
			<th style="width:10%">
				<?php echo JText::_('COM_JMAP_METAIMAGE' ); ?>
			</th>
			<th style="width:15%">
				<?php echo JText::_('COM_JMAP_SAVE_DELETE' ); ?>
			</th>
			<th style="width:5%">
				<?php echo JText::_('COM_JMAP_STATUS' ); ?>
			</th>
		</tr>
		
		<tr class="subtitles">
			<td style="width:1%">
			</td>
			<td class="title">
				<?php echo JText::_('COM_JMAP_SEARCH_ENGINES_LINK_DESC' ); ?>
			</td>
			<td style="width:15%">
				<?php echo JText::_('COM_JMAP_SEARCH_ENGINES_TITLE_DESC' ); ?>
			</td>
			<td style="width:15%">
				<?php echo JText::_('COM_JMAP_SEARCH_ENGINES_DESCRIPTION_DESC' ); ?>
			</td>
			<td style="width:10%">
				<?php echo JText::_('COM_JMAP_SEARCH_ENGINES_ROBOTS_DESC' ); ?>
			</td>
			<td style="width:10%">
				<?php echo JText::_('COM_JMAP_METAIMAGE_DESC' ); ?>
			</td>
			<td style="width:15%">
				<?php echo JText::_('COM_JMAP_SEARCH_ENGINES_SAVE_DELETE_DESC' ); ?>
			</td>
			<td style="width:5%">
			</td>
		</tr>
	</thead>
	<tbody>
	<?php
	$k = 0;
	foreach ( $this->items as $row ) {
		?>
		<tr>
			<td align="center">
				<?php echo $k + 1; ?>
			</td>
			<td class="link_loc">
				<a data-linkidentifier="<?php echo $k + 1;?>" href="<?php echo $row->loc; ?>" alt="sitelink" target="_blank" data-linkidentifier="<?php echo $k + 1;?>">
					<?php echo $row->loc; ?>
					<span class="glyphicon glyphicon-share"></span>
				</a>
			</td>
			<td align="center">
				<textarea class="metainfo metatitle" data-titleidentifier="<?php echo $k + 1;?>"><?php echo isset($row->metainfos->meta_title) ? $row->metainfos->meta_title : null;?></textarea>
			</td>
			<td align="center">
				<textarea class="metainfo metadesc" data-descidentifier="<?php echo $k + 1;?>"><?php echo isset($row->metainfos->meta_desc) ? $row->metainfos->meta_desc : null;?></textarea>
			</td>
			<td align="center">
				<select class="robots_directive" id="jmap_metainfo_robots_<?php echo $k + 1;?>" data-robotsidentifier="<?php echo $k + 1;?>">
					<option value="">
						<?php echo JText::_('COM_JMAP_USE_GLOBAL');?>
					</option>
					<option value="index, follow" <?php echo isset($row->metainfos->robots) && $row->metainfos->robots == 'index, follow' ? 'selected="selected"' : null;?>>
						<?php echo JText::_('COM_JMAP_USE_INDEX_FOLLOW');?>
					</option>
					<option value="noindex, follow" <?php echo isset($row->metainfos->robots) && $row->metainfos->robots == 'noindex, follow' ? 'selected="selected"' : null;?>>
						<?php echo JText::_('COM_JMAP_USE_NOINDEX_FOLLOW');?>
					</option>
					<option value="index, nofollow" <?php echo isset($row->metainfos->robots) && $row->metainfos->robots == 'index, nofollow' ? 'selected="selected"' : null;?>>
						<?php echo JText::_('COM_JMAP_USE_INDEX_NOFOLLOW');?>
					</option>
					<option value="noindex, nofollow" <?php echo isset($row->metainfos->robots) && $row->metainfos->robots == 'noindex, nofollow' ? 'selected="selected"' : null;?>>
						<?php echo JText::_('COM_JMAP_USE_NOINDEX_NOFOLLOW');?>
					</option>
				</select>
			</td>
			<td class="metaimage" align="center">
				<?php
					$this->mediaField->value = null;
					if(isset($row->metainfos)) {
						$this->mediaField->value = $row->metainfos->meta_image;
					}
					$this->mediaField->id = 'jform_media_identifier_' . ($k + 1);
					$this->mediaField->name = 'jform_media_identifier_' . ($k + 1);
					$this->mediaField->dataIdentifier = ($k + 1);
					echo $this->mediaField->renderField();
				?>
			</td>
			<td align="center">
				<button class="btn btn-primary" data-action="savemeta" data-save="<?php echo $k + 1;?>"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo JText::_('COM_JMAP_METAINFO_SAVE');?></button>
				<button class="btn btn-danger" data-action="deletemeta" data-delete="<?php echo $k + 1;?>"><span class="glyphicon glyphicon-remove-circle"></span> <?php echo JText::_('COM_JMAP_METAINFO_DELETE');?></button>
			</td>
			<td align="center">
				<fieldset class="radio btn-group" data-action="statemeta" data-state="<?php echo $k + 1;?>">
					<?php 
						$published = isset($row->metainfos->published) ? $row->metainfos->published : 1;
						echo JHTML::_ ( 'select.booleanlist', 'published' . $k, null, $published);
					?>
				</fieldset>
			</td>
		</tr>
		<?php
		$k++;
	}
	// No links showed
	if($k == 0) {
		$this->app->enqueueMessage ( JText::_('COM_JMAP_METAINFO_NOLINKS_ONTHISPAGE') );
	}
	?>
	</tbody>
	</table>

	<input type="hidden" name="section" value="view" />
	<input type="hidden" name="option" value="<?php echo $this->option;?>" />
	<input type="hidden" name="task" value="metainfo.display" />
	<input type="hidden" name="boxchecked" value="1" />
	<input type="hidden" name="filter_order" value="<?php echo @$this->orders['order'];?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo @$this->orders['order_Dir'];?>" />
</form>