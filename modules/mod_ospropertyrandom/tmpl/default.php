<?php
/*------------------------------------------------------------------------
# default.php - mod_ospropertyrandom
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');
//}else{
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
        <div class="span12 image_property" style="margin-left:0px !important;">
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
                <a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid)?>" title="<?php echo JText::_('OSPROPERTY_MOREDETAILS');?>">
                    <?php
					OSPHelper::showPropertyPhoto($property->photo,'medium',$property->id,'','','');
                    ?>
                </a>
            <?php }else {?>
                <a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid)?>" title="<?php echo JText::_('OSPROPERTY_MOREDETAILS');?>">
                    <img alt="<?php echo $property->pro_name?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/nopropertyphoto.png" >

                </a>
            <?php }?>
        </div>
        <?php
        }
        ?>
        <div class="span12" style="margin-left:0px !important;">
            <div class="row-fluid">
                <div class="span12 element_title">
                    <h4>
                        <a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid)?>" title="<?php echo JText::_('OSPROPERTY_MOREDETAILS');?>">
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
                        <?php
                        if ($show_price ) {
                            //echo "| ".$property->price_information;
							?>
							<span class="property_price"> <?php echo $property->price_information;?></span>
							<?php
                        }
                        ?>
                    </h4>
                </div>
            </div>
        </div>
        <div class="span12" style="margin-left:0px !important;">
            <?php
            $arr_desc = array();
            if($show_category == 1){
                $link = JRoute::_('index.php?option=com_osproperty&task=category_details&id='.$property->catid.'&Itemid='.$itemid);
                echo "<font class='category_label'>".JText::_('OSPROPERTY_CATEGORY').": </font>";
                echo "<a href='$link'>";
                echo $property->category_name;
                echo "</a>";
                echo '<div class="clearfix"></div>';
            }
            if ($show_address ) {
                if($property->show_address == 1){
                    echo "<span class='address_value'>";
                    echo OSPHelper::generateAddress($property);
                    echo "</span>";
                    echo '<div class="clearfix"></div>';
                }
            }
            if (($show_small_desc == 1) and ($property->pro_small_desc != "")){
                $small_desc = $property->pro_small_desc;
                $small_descArr = explode(" ",$small_desc);
                $count_small_desc = count($small_descArr);
                echo "<span class='desc_module".$bstyle."'>";
                if(($count_small_desc > $limit_word) and ($limit_word > 0)){
                    for($i=0;$i<$limit_word;$i++){
                        echo $small_descArr[$i]." ";
                    }
                    echo "...";
                }else{
                    echo $small_desc;
                }
                echo "</span>";
                echo '<div class="clearfix"></div>';
            }
            $addtionalArr = array();
            if(($show_bedrooms == 1) and ($property->bed_room > 0)){
                $addtionalArr[] = "<span class='bedroom_label'><i class='ospico-bed ".$font_height."'></i> ".$property->bed_room."</span>";
            }
            if(($show_bathrooms == 1) and ($property->bath_room > 0)){
                $addtionalArr[] = "<span class='bedroom_label'><i class='ospico-bath ".$font_height."'></i> ".OSPHelper::showBath($property->bath_room)."</span>";
            }
            if(($show_parking  == 1) and ($property->parking != "")){
                $addtionalArr[] = "<span class='bedroom_label'><i class='ospico-parking ".$font_height."'></i> ".$property->parking."</span>";
            }
			if(($show_square  == 1) and ($property->square_feet > 0)){
                $addtionalArr[] = "<span class='square_label'><i class='ospico-square ".$font_height."'></i> ".$property->square_feet."</span>";
            }
            if(count($addtionalArr) > 0){
                ?>
                <span class="additional_information">
                    <?php echo implode(" &nbsp; ",$addtionalArr);?>
                </span>
                <?php
            }
            ?>
        </div>
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
