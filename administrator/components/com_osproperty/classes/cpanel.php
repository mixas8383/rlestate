<?php
/*------------------------------------------------------------------------
# cpanel.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
class OspropertyCpanel{
	function cpanel($option){
		global $mainframe,$configClass,$_jversion,$langArr;
		ini_set('auto_detect_line_endings',true);
		$db = JFactory::getDbo();
		$db->setQuery("Select count(id) from #__osrs_properties where approved = '1' and published = '1'");
		$lists['properties'] = $db->loadResult();
		$db->setQuery("Select count(id) from #__osrs_categories where published = '1'");
		$lists['categories'] = $db->loadResult();
		$db->setQuery("Select count(id) from #__osrs_types where published = '1'");
		$lists['type']		 = $db->loadResult();
		$db->setQuery("Select count(id) from #__osrs_agents where published = '1'");
		$lists['agent']		 = $db->loadResult();
		$db->setQuery("Select count(id) from #__osrs_amenities where published = '1'");
		$lists['amenities']  = $db->loadResult();
		$db->setQuery("Select count(id) from #__osrs_pricegroups where published = '1'");
		$lists['pricegroups']= $db->loadResult();
		
		$db->setQuery("Select count(extension_id) from #__extensions where `element` like 'ospropertyplg' and enabled = '1'");
		$lists['plugin'] = $db->loadResult();
		
		$db->setQuery("Select count(id) from #__osrs_agents where published = '1'");
		$lists['agent_active'] = $db->loadResult();
		$db->setQuery("Select count(id) from #__osrs_agents where published = '0'");
		$lists['agent_unactive'] = $db->loadResult();
		$db->setQuery("Select count(id) from #__osrs_agents where request_to_approval = '1'");
		$lists['agent_request'] = $db->loadResult();
		
		$db->setQuery("Select count(id) from #__osrs_properties where approved = '1'");
		$lists['property_approved'] = $db->loadResult();
		$db->setQuery("Select count(id) from #__osrs_properties where approved = '0'");
		$lists['property_unapproved'] = $db->loadResult();
		$db->setQuery("Select count(id) from #__osrs_properties where request_to_approval = '1'");
		$lists['property_request'] = $db->loadResult();
		$db->setQuery("Select count(id) from #__osrs_properties where isFeatured = '1' and approved = '1'");
		$lists['property_featured'] = $db->loadResult();
		$db->setQuery("Select count(id) from #__osrs_properties where isFeatured = '0' and request_featured <> '0'");
		$lists['property_request_featured'] = $db->loadResult();
		
		$db->setQuery("Select id,pro_name,hits from #__osrs_properties where approved = '1' order by hits desc limit 5");
		$lists['mostviewed'] = $db->loadObjectList();
		$db->setQuery("Select a.pro_id,b.pro_name,b.hits, count(a.id) as sum from #__osrs_favorites as a inner join #__osrs_properties as b on b.id = a.pro_id group by a.pro_id order by count(a.id) desc limit 5");
		$lists['mostfavorites'] = $db->loadObjectList();
		$db->setQuery("Select id,pro_name,hits,(`total_points`/`number_votes`) as rate from #__osrs_properties where number_votes > 0 and approved = '1' order by rate desc limit 5");
		$lists['mostrate'] = $db->loadObjectList();
		$db->setQuery("Select a.pro_id,b.pro_name,b.hits, count(a.id) as sum from #__osrs_comments as a inner join #__osrs_properties as b on b.id = a.pro_id group by a.pro_id order by count(a.id) desc limit 5");
		$lists['mostcomments'] = $db->loadObjectList();
		
		
		$countryArr = array();
		for($i=0;$i<count($langArr);$i++){
			$countryArr[] = $langArr[$i]->country_id;
		}
		$countrySql = implode(",",$countryArr);
		
		$db->setQuery("Select * from #__osrs_countries where id in ($countrySql)");
		$countries = $db->loadObjectList();
		
		if (extension_loaded('gd') && function_exists('gd_info')) {
		     $gd = 1;
		     $gdinfoArr = gd_info();
		     if(($gdinfoArr['JPEG Support'] == 1) or ($gdinfoArr['JPG Support'] == 1))
		     {
		     	$gd_jpg = 1;
		     }
			 $lists['gd'] = 1;
			 $lists['gd_jpg'] = $gd_jpg;
		}else{
			 $gd = 0;
			 $lists['gd'] = 0;
			 $lists['gd_jpg'] = 0;
		}
		
		HTML_OspropertyCpanel::cpanelHTML($option,$lists,$countries);
	}
	
	/**
	 * Creates the buttons view.
	 * @param string $link targeturl
	 * @param string $image path to image
	 * @param string $text image description
	 * @param boolean $modal 1 for loading in modal
	 */
	function quickiconButton($link, $image, $text, $modal = 0)
	{
		//initialise variables
		$lang 		= &JFactory::getLanguage();
		$id_image   = explode(".",$image);
		$id_image   = $id_image[0];
  		?>
		<div id="div_<?php echo $id_image?>" style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
			<div class="icon">
				<?php
				if ($modal == 1) {
					JHTML::_('behavior.modal');
				?>
					<a href="<?php echo $link.'&amp;tmpl=component'; ?>" style="cursor:pointer" class="modal" rel="{handler: 'iframe', size: {x: 650, y: 400}}">
				<?php
				} else {
				?>
					<a href="<?php echo $link; ?>" >
				<?php
				}
				?>
					<img src="<?php echo JUri::root()?>components/com_osproperty/images/assets/<?php echo $image?>" title="<?php echo $text?>" id="img_div_<?php echo $id_image?>" />
					<span><?php echo $text; ?></span>
				</a>
			</div>
		</div>
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
		<?php
	}
}
?>