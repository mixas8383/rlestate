<?php
/**
 * @version 1.5.0 2011-11-11
 * @package Joomla
 * @subpackage OS-Property
 * @copyright (C)  2011 the Ossolution
 * @license see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$db = JFactory::getDbo();
$states = modOspropertyOspropertyStatesHelper::osGetStates($params);
?>
<div class="modultable<?php echo $moduleclass_sfx?>">
<div class="row-fluid">
	<?php
	$col_width = round(12/$num_cols);
	if(count($states) > 0){
		$j = 0;
		for($i=0;$i<count($states);$i++){
			$state = $states[$i];
			$j++;
			if($list_type == 0){
				$link = JRoute::_("index.php?option=com_osproperty&task=property_listing&state_id=".$state->id);
			}else{
				$link = JRoute::_("index.php?option=com_osproperty&task=property_city&id=".$state->id);
			}
			?>
			<div class="span<?php echo $col_width?>" style="margin-left:0px;">
				<a href="<?php echo $link?>" title="<?php echo Jtext::_('OS_LIST_PROPERTIES_BY');?><?php echo $state->name?>">
					<?php echo $state->name?>
				</a>
				<a href="<?php echo $link?>" title="<?php echo Jtext::_('OS_LIST_PROPERTIES_BY_THIS_PLACE');?>">
				(<?php echo $state->nproperties?>)
				</a>
			</div>
			<?php
			if($j == $num_cols){
				?>
				<div class="clearfix"></div>
				<?php 
				$j = 0;
			}
		}
	}
	?>
</div>
</div>
