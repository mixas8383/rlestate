<?php
/*------------------------------------------------------------------------
# showcase.php - mod_ospropertyrandom
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');
$db = JFactory::getDbo();
?>
<div class="row-fluid">
<?php
$k = 0;
foreach ($properties as $property) {
    $k++;
    $itemid = modOSpropertyramdomHelper::getItemid($property->id);
	?>	
    <div class="span<?php echo $divstyle;?> element_property">
        <?php
        if($show_photo == 1){
        ?>
        <div class="span12 image_property_showcase" style="margin-left:0px !important;">
            <?php
            if($property->isFeatured == 1){
                ?>
                <div class="randompropertyfeatured"><strong><?php echo JText::_('OS_FEATURED')?></strong></div>
            <?php
            }

            if(OSPHelper::isSoldProperty($property,$configClass)){
                ?>
                <div class="randompropertysold">
                    <strong><?php echo JText::_('OS_SOLD')?></strong>
                </div>
            <?php
            }

			if($show_type == 1){
				?>
				<div class="randompropertytype"><strong><?php echo $property->type_name;?></strong></div>
				<?php
            }

            if ($property->photo != ''){?>
                <a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid)?>"  title="<?php echo $property->pro_name; ?>">
                    <?php
                    OSPHelper::showPropertyPhoto($property->photo,'medium',$property->id,'','','');
                    ?>
                </a>
            <?php }else {?>
                <a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid)?>"  title="<?php echo $property->pro_name; ?>">
                    <img alt="<?php echo $property->pro_name?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/nopropertyphoto.png" />

                </a>
            <?php }?>
			<span class="overlayPhoto overlayFull mls clickable"></span>
			<div class="overlayTransparent overlayBottom typeReversed hpCardText clickable">
				<ul class="mbm property-card-details">
					<li class="man">
						<a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid)?>" title="<?php echo $property->pro_name; ?>">
							<?php
							if($property->ref != ""){
								echo $property->ref.", ";
							}
							?>
							<?php
							$arr_title_word = explode(' ',$property->pro_name);
							if (!$limit_title_word || $limit_title_word > count($arr_title_word)){
								echo $property->pro_name;
							}else {
								$tmp_title = array();
								for ($i=0; $i < $limit_title_word;$i++){
									$tmp_title[] = $arr_title_word[$i];
									if ($i > 2*count($arr_title_word)/3 && stristr($arr_title_word[$i],'.')) break;
								}
								echo implode(' ',$tmp_title);
								echo "...";
							}
							?>
						</a>
					</li>
					<li class="man">
						<?php
                        if ($show_price ) {
							?>
							<span class="property-price-showcase typeEmphasize mvn"><?php echo $property->price_information;?>&nbsp;</span>
							<?php
                        }
                        ?>
						<?php
						$addtionalArr = array();
						if(($show_bedrooms == 1) and ($property->bed_room > 0)){
							$addtionalArr[] = $property->bed_room." bd";
						}
						if(($show_bathrooms == 1) and ($property->bath_room > 0)){
							$addtionalArr[] = OSPHelper::showBath($property->bath_room)." ba";
						}
						if(($show_parking  == 1) and ($property->parking != "")){
							$addtionalArr[] = $property->parking." pa";
						}
						if(($show_square  == 1) and ($property->square_feet > 0)){
							$addtionalArr[] = $property->square_feet." ".OSPHelper::showSquareSymbol();
						}
						if(count($addtionalArr) > 0){
							?>
							<span class="man noWrap showcase_address">
								<?php echo implode(" &nbsp; ",$addtionalArr);?>
							</span>
							<?php
						}
						?>
					</li>
					<?php
					if ($show_address ) {
						if($property->show_address == 1){
							echo "<li class='man showcase_address'>";
							echo $property->address;
							echo "</li>";
							?>
							<li class="man showcase_address">
								<span class="man noWrap"> <?php echo OSPHelper::loadCityName($property->city);?>
								<?php
								if(!OSPHelper::userOneState()){
									echo ", ".OSPHelper::loadSateName($property->state);
								}

								?>
								</span>
							</li>
							<?php
						}
					}
					?>
				</ul>
			</div>
        </div>
        <?php
        }
        ?>
    </div>
    <?php
    if($k == $properties_per_row){
        $k = 0;
        ?>
        </div><div class="row-fluid">
        <?php
    }
} ?>
</div>