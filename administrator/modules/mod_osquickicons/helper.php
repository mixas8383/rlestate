<?php
;/**
; * @version	$Id: helper.php $
; * @package	OS Property
; * @author		Dang Thuc Dam http://www.joomdonation.com
; * @copyright	Copyright (c) 2007 - 2015 Joomdonation. All rights reserved.
; * @license	GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
; */

defined('_JEXEC') or die;

/**
 * Helper for mod_logged
 *
 * @since  1.5
 */
class ModOsquickiconsHelper
{
    /**
     * @param $link
     * @param $image
     * @param $text
     * @param int $modal
     */
    public static function quickiconButton($link, $image, $text, $modal = 0)
    {
        //initialise variables
        $lang 		= &JFactory::getLanguage();
        $id_image   = explode(".",$image);
        $id_image   = $id_image[0];
        ?>
        <div class="icon-wrapper">
            <div class="icon">
                <a href="<?php echo $link; ?>" >
                    <img src="<?php echo JUri::root()?>components/com_osproperty/images/assets/<?php echo $image?>" title="<?php echo $text?>" id="img_div_<?php echo $id_image?>" />
                    <span><?php echo $text; ?></span>
                </a>
                <?php
                $image_hover = str_replace(".png","-hover.png",$image);
                ?>
                <script language="javascript">
                    jQuery("#div_<?php echo $id_image?>").mouseover(function() {
                        jQuery( "#img_div_<?php echo $id_image?>" ).attr("src","<?php echo JUri::root()?>components/com_osproperty/images/assets/<?php echo $image_hover;?>");
                    });
                    jQuery("#div_<?php echo $id_image?>").mouseout(function() {
                        jQuery( "#img_div_<?php echo $id_image?>" ).attr("src","<?php echo JUri::root()?>components/com_osproperty/images/assets/<?php echo $image;?>");
                    });
                </script>
            </div>
        </div>
    <?php
    }
}
