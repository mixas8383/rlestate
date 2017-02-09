<style>
fieldset label, fieldset span.faux-label {
    clear: right;
}
table.admintable td.key, table.admintable td.paramlist_key {
    background-color: #F6F6F6;
    border-bottom: 1px solid #E9E9E9;
    border-right: 1px solid #E9E9E9;
    color: #666666;
    font-weight: bold;
    text-align: right;
    width: 140px;
    font-size:12px;
    padding-right:10px;
	font-family:"Times New Roman", Times, serif;
}

table.admintable th, table.admintable td {
    font-size: 12px;
	font-family:"Times New Roman", Times, serif;
}

table.admintable td {
    padding: 3px;
    font-size:12px;
    font-family:"Times New Roman", Times, serif;
}

legend {
    color: #146295;
    font-size: 12px;
    font-weight: bold;
}

div.width-20 fieldset, div.width-30 fieldset, div.width-35 fieldset, div.width-40 fieldset, div.width-45 fieldset, div.width-50 fieldset, div.width-55 fieldset, div.width-60 fieldset, div.width-65 fieldset, div.width-70 fieldset, div.width-80 fieldset, div.width-100 fieldset {
    background-color: #FFFFFF;
    padding: 5px 17px 17px;
}
fieldset {
    border: 1px solid #CCCCCC;
    margin-bottom: 10px;
    padding: 5px;
    text-align: left;
	font-family:"Times New Roman", Times, serif;
}
</style>
<page style="font-family: freeserif;">
	<table width="100%">
		<tr>
			<td width="100%" align="center" style="padding:10px;text-align:center;">
				<strong><big>
					<font size="18" style='font-size:22px;font-weight:bold;'>
					
						<?php
						$db = JFactory::getDbo();
						if($row->ref != ""){
							?>
							<?php echo $row->ref?>, 
							<?php 
						}	
						?>
						<?php 
						
						echo strtoupper(OSPHelper::getLanguageFieldValue($row,'pro_name'));?>
						&nbsp;&nbsp;&nbsp;
						<?php 
						if($row->price_call == 1){
							//echo JText::_('OS_CALL_FOR_PRICE');
						}else{
							//echo OSPHelper::generatePrice($row->curr,$row->price);
							echo HelperOspropertyCommon::showPrice($row->price)." ";
							$db->setQuery("Select currency_code from #__osrs_currencies where id = '$row->curr'");
							echo $db->loadResult();
							if($row->rent_time != ""){
								echo " /".JText::_($row->rent_time);
							}
						}
						?>
						
					</font></big>
				</strong>
			</td>
		</tr>
	</table>
	<?php 
	if(count($row->photo) > 0){
	$photos = $row->photo;
	$j = 0;
	?>
	<table width="700">
		<tr>
			<td align="center" width="700" colspan="4">
				<img src="<?php echo JURI::root()?>images/osproperty/properties/<?php echo $row->id;?>/<?php echo $photos[0]->image?>" width="700" style="width:600px; !important;"/>
			</td>
		</tr>
		<tr>
		<?php
		for($i=0;$i<count($photos);$i++){
			$j++;
			$photo = $photos[$i];
			$image = explode(".",$photo->image);
			$extension = $image[count($image)-1];
			$extension = strtolower($extension);
			if(in_array($extension,array('jpg','png','gif','jpeg'))){
				?>
				<td width="175" style="margin:10px;" ALIGN="CENTER">
			
					<?php
					if($photo->image != ""){
						//$photo->image = str_replace(".JPG",".jpg",$photo->image);
						if(file_exists(JPATH_ROOT.DS."images/osproperty/properties/".$row->id."/thumb/".$photo->image)){
							?>
							<img src="<?php echo JURI::root()?>images/osproperty/properties/<?php echo $row->id;?>/thumb/<?php echo $photo->image?>" width="170" />
							<?php
						}
					}
					?>
				</td>
				<?php
				if($j == 4){
					echo '</tr><tr>';
					$j = 0;
				}
			}
		}
		?>
		</tr>
	</table>
	<?php
}
	?>
	
	<table cellpadding="1" cellspacing="1" width="100%" border="0">
		<tr>
			<td colspan="2" width="100%" BGCOLOR="#F9D192">
				<strong>
					<?php echo strtoupper(JText::_('OS_PROPERTY_INFORMATION'));?>:
				</strong>
			</td>
		</tr>
		<?php
			if($row->show_address == 1){
			?>
			<tr>
				<td width="30%">
					<?php echo JText::_('OS_ADDRESS')?>
				</td>
				<td>:&nbsp;<?php echo OSPHelper::generateAddress($row);?></td>
			</tr>
			<?php
			}
		?>
		<tr>
			<td class="key" width="30%" BGCOLOR="#efefef"><?php echo JText::_('OS_CATEGORY')?></td>
			<td BGCOLOR="#efefef" width="70%">:&nbsp;<?php echo OSPHelper::getCategoryNamesOfProperty($row->id); ?></td>
		</tr>
		<tr>
			<td class="key" width="30%"><?php echo JText::_('OS_PROPERTY_TYPE')?></td>
			<td >:&nbsp;<?php echo $lists['type']; ?></td>
		</tr>
		<?php 
		if($row->isFeatured == 1){
		?>
		<tr>
			<td class="key" width="30%" BGCOLOR="#efefef"><?php echo JText::_('OS_IS_FEATURE')?></td>
			<td BGCOLOR="#efefef">:&nbsp;<?php echo $row->isFeatured? JText::_('OS_YES'):JText::_('OS_NO'); ?></td>
		</tr>
		<?php } ?>
		<?php 
		if($row->isSold == 1){
		?>
		<tr>
			<td class="key" width="30%"><?php echo JText::_('OS_SOLD')?></td>
			<td >:&nbsp;<?php echo $row->soldOn;?></td>
		</tr>
		<?php } ?>
	</table>
	
	<BR />
	<?php
	//}
	
	$small_desc = OSPHelper::getLanguageFieldValue($row,'pro_small_desc');
	
	if($small_desc != ""){
	?>
	<table  width="100%" border="0">
		<tr>
			<td width="100%" BGCOLOR="#F9D192">
				<strong>
					<?php echo strtoupper(JText::_('OS_PROPERTY_INFORMATION'));?>:
				</strong>
			</td>
		</tr>
		<tr>
			<td width="100%" BGCOLOR="#B4DAFE">
				<?php echo $small_desc;?>
				<?php if(OSPHelper::getLanguageFieldValue($row,'pro_full_desc') != ""){?>
				<BR />
					<?php echo strip_tags(OSPHelper::getLanguageFieldValue($row,'pro_full_desc')); 
				}
				?>
			</td>
		</tr>
	</table>
	<?php } ?>
	
	
	<?php 
	if(count($groups) > 0){
		for($i=0;$i<count($groups);$i++){
			$group = $groups[$i];
			
			$fields = $group->fields;
			//if(count($fields) > 0){
			if(HelperOspropertyFields::checkFieldData($row->id,$group->id) == 1){
				?>
				<table  width="100%" border="0">
					<tr>
						<td width="100%" BGCOLOR="#F9D192" colspan="2">
							<strong><?php echo strtoupper(OSPHelper::getLanguageFieldValue($group,'group_name'));?></strong>
						</td>
					</tr>
					<?php
					$fields = HelperOspropertyFields::getFieldsData($row->id,$group->id);
					for($j=0;$j<count($fields);$j++){
						$field = $fields[$j];
						if(HelperOspropertyFieldsPrint::showField($field,$row->id) != ""){
							if($j % 2==0){
								$bgcolor = "BGCOLOR='#efefef'";
							}else{
								$bgcolor = "BGCOLOR='#ffffff'";
							}
							?>
							<tr>
								<td width="30%" <?php echo $bgcolor;?>>
									<?php echo $field->field_label?>
								</td>
								<td width="70%" <?php echo $bgcolor;?>>:&nbsp;
									<?php
									echo $field->value;
									?>
								</td>
							</tr>
							<?php
						}
					}
					?>
							
				</table>
				<?php
			}
		}
	}

	if((($configClass['use_rooms'] == 1) and ($row->rooms > 0)) or (($configClass['use_bedrooms'] == 1) and ($row->bed_room > 0)) or (($configClass['use_bathrooms'] == 1) and ($row->bath_room > 0)) or ($row->living_areas != "")){
		echo "<BR />";
		?>
		<table  width="100%" border="0">
			<tr>
				<td width="100%" BGCOLOR="#F9D192" colspan="3">
					<strong><?php echo strtoupper(JText :: _('OS_BASE_INFORMATION')); ?>:</strong>
				</td>
			</tr>
			<?php
            if(($configClass['use_rooms'] == 1) and ($row->rooms > 0)){ ?>
			<tr>
				<td width="30%" BGCOLOR="#FFFFFF">
					<?php echo JText::_('OS_ROOMS');?>
				</td>
				<td width="70%" BGCOLOR="#FFFFFF">:&nbsp;
					<?php echo $row->rooms ;?>
				</td>
			</tr>
			<?php
            }
            ?>
            <?php
            if(($configClass['use_bedrooms'] == 1) and ($row->bed_room > 0)){?>
			<tr>
				<td width="30%" BGCOLOR="#EFEFEF">
					<?php echo JText::_('OS_BED');?>
				</td>
				<td width="70%" BGCOLOR="#EFEFEF">:&nbsp;
					<?php echo $row->bed_room ;?>
				</td>
			</tr>
			<?php
            }
            ?>
            <?php
            if(($configClass['use_bathrooms'] == 1) and ($row->bath_room > 0)){ ?>
			<tr>
				<td width="30%" BGCOLOR="#FFFFFF">
					<?php echo JText::_('OS_BATH');?>
				</td>
				<td width="70%" BGCOLOR="#FFFFFF">:&nbsp;
					<?php echo OSPHelper::showBath($row->bath_room) ;?>
				</td>
			</tr>
			<?php
            }
            ?>
            <?php
            if($row->living_areas != ""){ ?>
			<tr>
				<td width="30%" BGCOLOR="#EFEFEF">
					<?php echo JText::_('OS_LIVING_AREAS');?>
				</td>
				<td width="70%" BGCOLOR="#EFEFEF">:&nbsp;
					<?php echo $row->living_areas ;?>
				</td>
			</tr>
			<?php
            }
            ?>
		</table>
		<?php
	}

	if(($configClass['use_parking'] == 1) and (($row->parking > 0) or ($row->garage_description != ""))){
		echo "<BR />";
		?>
		<table  width="100%" border="0">
			<tr>
				<td width="100%" BGCOLOR="#F9D192" colspan="3">
					<strong><?php echo strtoupper(JText :: _('OS_PARKING_INFORMATION')); ?>:</strong>
				</td>
			</tr>
			<?php
            if($row->parking > 0){ ?>
			<tr>
				<td width="30%" BGCOLOR="#FFFFFF">
					<?php echo JText::_('OS_PARKING');?>
				</td>
				<td width="70%" BGCOLOR="#FFFFFF">:&nbsp;
					<?php echo $row->parking ;?>
				</td>
			</tr>
			<?php
            }
            ?>
            <?php
            if($row->garage_description != ""){?>
			<tr>
				<td width="30%" BGCOLOR="#EFEFEF">
					<?php echo JText::_('OS_GARAGE_DESCRIPTION');?>
				</td>
				<td width="70%" BGCOLOR="#EFEFEF">:&nbsp;
					<?php echo $row->garage_description ;?>
				</td>
			</tr>
			<?php
            }
            ?>
		</table>
		<?php
	}

	if($configClass['use_nfloors'] == 1){
		$textFieldsArr = array('built_on','remodeled_on','house_style','house_construction','exterior_finish','roof','flooring');
		$numberFieldArr = array('number_of_floors','floor_area_lower','floor_area_main_level','floor_area_upper','floor_area_total');
		$show = 0;
		foreach($textFieldsArr as $textfield){
			if($row->{$textfield} != ""){
				$show = 1;
			}
		}
		foreach($numberFieldArr as $numfield){
			if($row->{$numfield} != ""){
				$show = 1;
			}
		}
		if($show == 1) {
			echo "<BR />";
			?>
			<table  width="100%" border="0">
				<tr>
					<td width="100%" BGCOLOR="#F9D192" colspan="3">
						<strong><?php echo strtoupper(JText :: _('OS_BUILDING_INFORMATION')); ?>:</strong>
					</td>
				</tr>
				<?php
				$i = 0;
				foreach($textFieldsArr as $textfield){ 
					if($row->{$textfield} != ""){
						$i++;
						if($i % 2 == 0){
							$bgcolor = "#FFFFFF";
						}else{
							$bgcolor = "#EFEFEF";
						}
						?>
						<tr>
							<td width="30%" BGCOLOR="<?php echo $bgcolor;?>">
								<?php echo JText::_('OS_'.strtoupper($textfield));?>
							</td>
							<td width="70%" BGCOLOR="<?php echo $bgcolor;?>">:&nbsp;
								<?php echo $row->{$textfield};?>
							</td>
						</tr>
						<?php
					}
				}
				$i = 0;
				foreach($numberFieldArr as $numfield){
                    if($row->{$numfield} != ""){
						$i++;
						if($i % 2 == 0){
							$bgcolor = "#FFFFFF";
						}else{
							$bgcolor = "#EFEFEF";
						}
						?>
						<tr>
							<td width="30%" BGCOLOR="<?php echo $bgcolor;?>">
								<?php echo JText::_('OS_'.strtoupper($numfield));?>
							</td>
							<td width="70%" BGCOLOR="<?php echo $bgcolor;?>">:&nbsp;
								<?php echo $row->{$numfield};?>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</table>
			<?php
		}
	}

	if(($configClass['basement_foundation'] == 1) and (($row->basement_size > 0) or ($row->basement_foundation != "") or ($row->percent_finished != ""))){
			echo "<BR />";
			?>
			<table  width="100%" border="0">
				<tr>
					<td width="100%" BGCOLOR="#F9D192" colspan="3">
						<strong><?php echo strtoupper(JText :: _('OS_BASEMENT_FOUNDATION')); ?>:</strong>
					</td>
				</tr>
				<?php
            if($row->basement_foundation != ""){?>
				<tr>
					<td width="30%" BGCOLOR="#FFFFFF">
						<?php echo JText::_('OS_BASEMENT_FOUNDATION');?>
					</td>
					<td width="70%" BGCOLOR="#FFFFFF">:&nbsp;
						<?php echo $row->basement_foundation ;?>
					</td>
				</tr>
			<?php
            }
            ?>
            <?php
            if($row->basement_size > 0){?>
				<tr>
					<td width="30%" BGCOLOR="#EFEFEF">
						<?php echo JText::_('OS_BASEMENT_SIZE');?>
					</td>
					<td width="70%" BGCOLOR="#EFEFEF">:&nbsp;
						<?php echo OSPHelper::showBath($row->basement_size); ;?>
					</td>
				</tr>
			<?php
            }
            ?>
            <?php
            if($row->percent_finished != ""){ ?>
				<tr>
					<td width="30%" BGCOLOR="#FFFFFF">
						<?php echo JText::_('OS_PERCENT_FINISH');?>
					</td>
					<td width="70%" BGCOLOR="#FFFFFF">:&nbsp;
						<?php echo $row->percent_finished ;?>
					</td>
				</tr>
			<?php
            }
            ?>
			</table>
		<?php
	}

	if($configClass['use_squarefeet'] == 1){
		$textFieldsArr = array('subdivision','land_holding_type','lot_dimensions','frontpage','depth');
        $numberFieldArr = array('total_acres','square_feet','lot_size');
		$show = 0;
		foreach($textFieldsArr as $textfield){
			if($row->{$textfield} != ""){
				$show = 1;
			}
		}
		foreach($numberFieldArr as $numfield){
			if($row->{$numfield} != ""){
				$show = 1;
			}
		}
		if($show == 1) {
			echo "<BR />";
			?>
			<table  width="100%" border="0">
				<tr>
					<td width="100%" BGCOLOR="#F9D192" colspan="3">
						<strong><?php echo strtoupper(JText :: _('OS_LAND_INFORMATION')); ?>:</strong>
					</td>
				</tr>
				<?php
				$i = 0;
				foreach($textFieldsArr as $textfield){ 
					if($row->{$textfield} != ""){
						$i++;
						if($i % 2 == 0){
							$bgcolor = "#FFFFFF";
						}else{
							$bgcolor = "#EFEFEF";
						}
						?>
						<tr>
							<td width="30%" BGCOLOR="<?php echo $bgcolor;?>">
								<?php echo JText::_('OS_'.strtoupper($textfield));?>
							</td>
							<td width="70%" BGCOLOR="<?php echo $bgcolor;?>">:&nbsp;
								<?php echo $row->{$textfield};?>
							</td>
						</tr>
						<?php
					}
				}
				$i = 0;
				foreach($numberFieldArr as $numfield){
                    if($row->{$numfield} != ""){
						$i++;
						if($i % 2 == 0){
							$bgcolor = "#FFFFFF";
						}else{
							$bgcolor = "#EFEFEF";
						}
						?>
						<tr>
							<td width="30%" BGCOLOR="<?php echo $bgcolor;?>">
								<?php echo JText::_('OS_'.strtoupper($numfield));?>
							</td>
							<td width="70%" BGCOLOR="<?php echo $bgcolor;?>">:&nbsp;
								<?php echo $row->{$numfield};?>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</table>
			<?php
		}
	}

	if($configClass['use_business'] == 1){
        $textFieldsArr = array('takings','returns','net_profit','business_type','stock','fixtures','fittings','percent_office','percent_warehouse','loading_facilities');
            $show = 0;
            foreach($textFieldsArr as $textfield){
                if($row->{$textfield} != ""){
                    $show = 1;
                }
            }

            if($show == 1) {
			echo "<BR />";
			?>
			<table  width="100%" border="0">
				<tr>
					<td width="100%" BGCOLOR="#F9D192" colspan="3">
						<strong><?php echo strtoupper(JText :: _('OS_BUSINESS_INFORMATION')); ?>:</strong>
					</td>
				</tr>
				<?php
				$i = 0;
				foreach($textFieldsArr as $textfield){ 
					if($row->{$textfield} != ""){
						$i++;
						if($i % 2 == 0){
							$bgcolor = "#FFFFFF";
						}else{
							$bgcolor = "#EFEFEF";
						}
						?>
						<tr>
							<td width="30%" BGCOLOR="<?php echo $bgcolor;?>">
								<?php echo JText::_('OS_'.strtoupper($textfield));?>
							</td>
							<td width="70%" BGCOLOR="<?php echo $bgcolor;?>">:&nbsp;
								<?php echo $row->{$textfield};?>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</table>
			<?php
		}
	}

	if($configClass['use_business'] == 1){
        $textFieldsArr = array('fencing','rainfall','soil_type','grazing','cropping','irrigation','water_resources','carrying_capacity','storage');
            $show = 0;
            foreach($textFieldsArr as $textfield){
                if($row->{$textfield} != ""){
                    $show = 1;
                }
            }

            if($show == 1) {
			echo "<BR />";
			?>
			<table  width="100%" border="0">
				<tr>
					<td width="100%" BGCOLOR="#F9D192" colspan="3">
						<strong><?php echo strtoupper(JText :: _('OS_RURAL_INFORMATION')); ?>:</strong>
					</td>
				</tr>
				<?php
				$i = 0;
				foreach($textFieldsArr as $textfield){ 
					if($row->{$textfield} != ""){
						$i++;
						if($i % 2 == 0){
							$bgcolor = "#FFFFFF";
						}else{
							$bgcolor = "#EFEFEF";
						}
						?>
						<tr>
							<td width="30%" BGCOLOR="<?php echo $bgcolor;?>">
								<?php echo JText::_('OS_'.strtoupper($textfield));?>
							</td>
							<td width="70%" BGCOLOR="<?php echo $bgcolor;?>">:&nbsp;
								<?php echo $row->{$textfield};?>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</table>
			<?php
		}
	}
	?>
		
	<BR />
			
	<?php
	if($configClass['show_amenity_group'] == 1){
		if(count($amenities) > 0){
		?>
			<table  width="100%" border="0">
				<tr>
					<td width="100%" BGCOLOR="#F9D192" colspan="3">
						<strong><?php echo strtoupper(JText :: _('OS_CONVENIENCE')); ?>:</strong>
					</td>
				</tr>
				<?php
				$optionArr = array();
				$optionArr[] = JText::_('OS_GENERAL_AMENITIES');
				$optionArr[] = JText::_('OS_ACCESSIBILITY_AMENITIES');
				$optionArr[] = JText::_('OS_APPLIANCE_AMENITIES');
				$optionArr[] = JText::_('OS_COMMUNITY_AMENITIES');
				$optionArr[] = JText::_('OS_ENERGY_SAVINGS_AMENITIES');
				$optionArr[] = JText::_('OS_EXTERIOR_AMENITIES');
				$optionArr[] = JText::_('OS_INTERIOR_AMENITIES');
				$optionArr[] = JText::_('OS_LANDSCAPE_AMENITIES');
				$optionArr[] = JText::_('OS_SECURITY_AMENITIES');
				
				for($l=0;$l<count($optionArr);$l++){
					$j = 0;
					$db->setQuery("Select a.* from #__osrs_amenities as a left join #__osrs_property_amenities as b on a.id = b.amen_id where a.category_id = '".$l."' and b.pro_id = '$row->id'");
					$amenities = $db->loadObjectList();
					if(count($amenities) > 0){
						$j = 0;
						$k = 0;
						echo "<tr><td colspan='3' BGCOLOR='#FBE1B7'>";
						?>
						<strong><?php echo $optionArr[$l];?>:</strong>
						<?php 
						echo "</td></tr>";
						for($i=0;$i<count($amenities);$i++){
							if(count($amenitylists) > 0){
								if(in_array($amenities[$i]->id,$amenitylists)){
									$j++;
									$k++;
									if($j % 2==0){
										$bgcolor = "BGCOLOR='#efefef'";
									}else{
										$bgcolor = "BGCOLOR='#ffffff'";
									}
									?>
									<tr>
										<td align="left" <?php echo $bgcolor;?>>
											<?php echo OSPHelper::getLanguageFieldValue($amenities[$i],'amenities');?>
										</td>
									</tr>
									<?php
								}
							}
						}
					}
				}
				?>
			</table>
			<?php
		}
	}
	if($configClass['show_neighborhood_group'] == 1){

		$db = JFactory::getDbo();
		$db->setQuery("Select count(id) from #__osrs_neighborhood where pid = '$row->id'");
		$count = $db->loadResult();
		if($count > 0){
			$query = "Select a.*,b.neighborhood from #__osrs_neighborhood as a"
				." inner join #__osrs_neighborhoodname as b on b.id = a.neighbor_id"
				." where a.pid = '$row->id'";
			$db->setQuery($query);
			$neighbors = $db->loadObjectList();
		?>
			<table  width="100%" border="0">
				<tr>
					<td width="100%" BGCOLOR="#F9D192" colspan="2">
						<strong><?php echo strtoupper(JText :: _('OS_NEIGHBORHOOD')); ?>:</strong>
					</td>
				</tr>
				<?php
				for($i=0;$i<count($neighbors);$i++){
					$neighbor = $neighbors[$i];
					
					if($i % 2==0){
						$bgcolor = "BGCOLOR='#efefef'";
					}else{
						$bgcolor = "BGCOLOR='#ffffff'";
					}
					?>
					<tr>
						<td width="30%" <?php echo $bgcolor;?>>
							<?php
							echo JText::_($neighbor->neighborhood);
							?>
						</td>
						<td width="70%" <?php echo $bgcolor;?>>:&nbsp;
							<?php echo $neighbor->mins?> <?php echo JText::_('OS_MINS')?> <?php echo JText::_('OS_BY')?>
							&nbsp;
							<?php
							switch ($neighbor->traffic_type){
								case "1":
									echo JText::_('OS_WALK');
								break;
								case "2":
									echo JText::_('OS_CAR');
								break;
								case "3":
									echo JText::_('OS_TRAIN');
								break;
							}
							?>
							
						</td>
					</tr>
					<?php
				}
				?>
						
			</table>
			<?php
		}
	}


	//end field groups

	//photos

	if($configClass['show_agent_details'] == 1){
	?>
		<table width="700" border="0">
			<tr>
				<td width="100%" BGCOLOR="#F9D192" colspan="2">
					<strong>
						<?php 
						if($row->agent->agent_type == 0){
							echo strtoupper(JText::_('OS_AGENT'));
						}else{
							echo strtoupper(JText::_('OS_OWNER'));
						}
						?>:
					</strong>
				</td>
			</tr>
			<tr>
				<td width="150" VALIGN="TOP">
					<?php
					if($configs[40]->fieldvalue == 1){
						$agent_photo = $row->agent->photo;
						$agent_photo_arr = explode(".",$agent_photo);
						$ext = $agent_photo_arr[count($agent_photo_arr)-1];
						$ext = strtolower($ext);
						if (($row->agent->photo != "") and (in_array($extension,array('jpg','png','gif','jpeg')))){
							?>
							<img src="<?php echo JURI::root()?>images/osproperty/agent/<?php echo $row->agent->photo?>" width="150"/>
							<?php
						}else{
							?>
							<img src="<?php echo JURI::root()?>components/com_osproperty/images/assets/user.jpg" style="border:1px solid #CCC;" width="150" />
							<?php
						}
					}
					?>
				</td>
				<td width="500" VALIGN="TOP">
					<table  width="100%" border="0">
						<tr>
							<td width="30%" bgcolor='#efefef'>
								<?php echo JText::_('OS_NAME')?>
							</td>
							<td bgcolor='#efefef'>
								<strong><?php echo $row->agent->name;?></strong>
							</td>
						</tr>
						<?php
						if($configClass['show_agent_address'] == 1){
						?>
						<tr>
							<td width="30%" >
								<?php echo JText::_('OS_ADDRESS');?>
							</td>
							<td>
								<?php 
								if($row->agent->address != ""){
									echo $row->agent->address;
									if($row->agent->city > 0){
										echo ", ";
									}
								}
								if($row->agent->city > 0){
									echo HelperOspropertyCommon::loadCityName($row->agent->city);
									if($row->agent->state_name != ""){
										echo ", ";
									}
								}
								if($row->agent->state_name != ""){
									echo $row->agent->state_name;
									if(HelperOspropertyCommon::checkCountry()){
										echo ", ";
									}
								}
								if(HelperOspropertyCommon::checkCountry()){
									echo $row->agent->country_name;
								}
								?>
							</td>
						</tr>
						<?php
						}
						
						if(($row->agent->phone != "") and ($configClass['show_agent_phone'] == 1)){
						?>
						<tr>
							<td width="30%" bgcolor='#efefef'>
								<?php echo JText::_('OS_PHONE');?>
							</td>
							<td bgcolor='#efefef'>
								<?php echo $row->agent->phone;?>
							</td>
						</tr>
						<?php
						}
						if(($row->agent->mobile != "")and ($configClass['show_agent_mobile'] == 1)){
						?>
						<tr>
							<td width="30%">
								<?php echo JText::_('OS_MOBILE');?>
							</td>
							<td>
								<?php echo $row->agent->mobile;?>
							</td>
						</tr>
						<?php
						}

						?>
					</table>
				</td>
			</tr>
		</table>
	<?php
	}
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select("*")->from("#__osrs_property_price_history")->where("pid = '$row->id'")->order("`date` desc");
	$db->setQuery($query);
	$prices = $db->loadObjectList();
	if(($configClass['use_property_history'] == 1) and (count($prices) > 0)){ ?>
	<!-- History -->
	<table width="700" border="0">
		<tr>
			<td width="100%" BGCOLOR="#F9D192" colspan="4">
				<strong>
					<?php 
					echo JText::_('OS_PROPERTY_HISTORY');
					?>:
				</strong>
			</td>
		</tr>
		
		<tr>
			<th width="25%" bgcolor="#CCC">
				<?php echo JText::_('OS_DATE');?>
			</th>
			<th width="25%" bgcolor="#CCC">
				<?php echo JText::_('OS_EVENT');?>
			</th>
			<th width="25%" bgcolor="#CCC">
				<?php echo JText::_('OS_PRICE');?>
			</th>
			<th width="25%" bgcolor="#CCC">
				<?php echo JText::_('OS_SOURCE');?>
			</th>
		</tr>

		<?php 
		foreach ($prices as $price){
			?>
			<tr>
				<td width="25%">
					<?php echo $price->date;?>
				</td>
				<td width="25%">
					<?php echo $price->event;?>
				</td>
				<td width="25%">
					<?php echo OSPHelper::generatePrice('',$price->price);?>
				</td>
				<td width="25%">
					<?php echo $price->source;?>
				</td>
			</tr>
			<?php 
		}
		?>
	</table>
	<?php }

							
	$query = $db->getQuery(true);
	$query->select("*")->from("#__osrs_property_history_tax")->where("pid = '$row->id'")->order("`tax_year` desc");
	$db->setQuery($query);
	$taxes = $db->loadObjectList();
	if(($configClass['use_property_history'] == 1) and (count($taxes) > 0)){ ?>
	<!-- tax -->

	<table width="700" border="0">
		<tr>
			<td width="100%" BGCOLOR="#F9D192" colspan="5">
				<strong>
					<?php 
					echo JText::_('OS_PROPERTY_TAX');
					?>:
				</strong>
			</td>
		</tr>
		
		<tr>
			<th width="10%" bgcolor="#CCC">
				<?php echo JText::_('OS_YEAR');?>
			</th>
			<th width="15%" bgcolor="#CCC">
				<?php echo JText::_('OS_TAX');?>
			</th>
			<th width="15%" bgcolor="#CCC">
				<?php echo JText::_('OS_CHANGE');?>
			</th>
			<th width="30%" bgcolor="#CCC">
				<?php echo JText::_('OS_TAX_ASSESSMENT');?>
			</th>
			<th width="30%" bgcolor="#CCC">
				<?php echo JText::_('OS_TAX_ASSESSMENT_CHANGE');?>
			</th>
		</tr>

		<?php 
		foreach ($taxes as $tax){
			?>
			<tr>
				<td>
					<?php echo $tax->tax_year;?>
				</td>
				<td>
					<?php echo OSPHelper::generatePrice('',$tax->property_tax);?>
				</td>
				<td>
					<?php 
					if($tax->tax_change != ""){
					?>
						<?php echo $tax->tax_change;?> %
					<?php }else { ?>
						--
					<?php } ?>
				</td>
				<td>
					<?php echo OSPHelper::generatePrice('',$tax->tax_assessment);?>
				</td>
				<td>
					<?php 
					if($tax->tax_assessment_change != ""){
					?>
						<?php echo $tax->tax_assessment_change;?> %
					<?php }else { ?>
						--
					<?php } ?>
				</td>
			</tr>
			<?php 
		}
		?>
	</table>
<?php }
?>
</page>