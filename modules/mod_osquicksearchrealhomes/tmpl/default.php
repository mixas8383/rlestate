<?php
/**
 * @subpackage  mod_osquicksearchrealhomes
 * @author      Dang Thuc Dam
 * @copyright   Copyright (C) 2007 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$db = JFactory::getDbo();

?>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
jQuery( function() {
    jQuery( "#address" ).autocomplete({
      source: "<?php echo JUri::root(); ?>index.php?option=com_osproperty&task=default_suggestion",
      minLength: 6
    });
} );
</script>
<style>
.search_properties{
	max-width: <?php echo $widthsize; ?>px;
}
</style>
<div class="search_properties">
	<span class="block strapline-intro hidden-phone"><?php echo JText::_('OS_FIND_YOUR_HAPPY');?></span>
	<h1 class="hero-strapline hidden-phone"><?php echo JText::_('OS_SEARCH_PROPERTIES_INSTRODUCTION');?></h1>
	<form method="get" action="<?php echo Jroute::_('index.php?option=com_osproperty&task=property_advsearch&Itemid='.$itemid);?>" id="initialSearch">
		<fieldset class="hero-fieldset">
			<div class="main-form">
				<input type="text" autocomplete="off" value="<?php echo JRequest::getVar('address');?>" placeholder="<?php echo JText::_('OS_PLACEHOLDERTEXT'); ?>" class="search-location js-typeahead-ready" name="address" id="address" />
				<?php
				if(count($osp_type) > 0){
					foreach($osp_type as $type){
						$db->setQuery("Select * from #__osrs_types where id = '$type'");
						$property_type = $db->loadObject();
						$type_name = OSPHelper::getLanguageFieldValue($property_type,'type_name');
						?>
						<button value="<?php echo $type_name; ?>" class="btn btn btn-primary hero-btn" type="submit" id="ostype<?php echo $property_type->id;?>"><?php echo $type_name; ?></button>
						<script type="text/javascript">
							jQuery( "#ostype<?php echo $property_type->id;?>" ).click(function() {
								jQuery( "#property_type" ).val('<?php echo $property_type->id;?>');
								document.initialSearch.submit();
							});
						</script>
						<?php
					}
				}
				?>
			</div>
		</fieldset>
		<input type="hidden" name="property_type" id="property_type" value="" />
	</form>
</div>