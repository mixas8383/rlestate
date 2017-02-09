<?php 
/*------------------------------------------------------------------------
# property.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die;
?>
<table width="100%">
    <tr>
        <td width="50%" valign="top">
            <fieldset>
                <legend><?php echo JText::_('OS_FEATURED_FIELDS')?></legend>
                <table  width="100%" class="admintable">
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Auto approval' );?>::<?php echo JTextOs::_('Do new and updated listings require admin approval before publishing?'); ?>">
                                 <label for="checkbox_general_approval">
                                     <?php echo JTextOs::_( 'Auto approval' ).':'; ?>
                                 </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('general_approval',$configs['general_approval']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_DEFAULT_ACCESS_LEVEL' );?>::<?php echo JText::_('OS_DEFAULT_ACCESS_LEVEL_EXPLAIN'); ?>">
                                 <label for="checkbox_general_approval">
                                     <?php echo JText::_( 'OS_DEFAULT_ACCESS_LEVEL' ).':'; ?>
                                 </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            if($configs['default_access_level'] == ""){
                                $configs['default_access_level'] = 1;
                            }
                            echo OSPHelper::accessDropdown('configuration[default_access_level]',$configs['default_access_level']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Not available link' );?>::<?php echo JTextOs::_('Not available link explain.'); ?>">
                                <label for="configuration[bussiness_name]">
                                    <?php echo JText::_( 'Unavailable link' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class = "input-xxlarge" name="configuration[property_not_avaiable]" value="<?php echo isset($configs['property_not_avaiable'])? $configs['property_not_avaiable']:''; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap" valign="top">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Address format' );?>::<?php echo JTextOs::_('Address format explain'); ?>">
                                <label for="gallery_type">
                                    <?php echo JTextOs::_( 'Address format' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            $addressArr = array();
                            $addressArr[0] =  JText::_('OS_ADDRESS');
                            $addressArr[1] =  JText::_('OS_CITY');
                            $addressArr[2] =  JText::_('OS_STATE');
                            $addressArr[3] =  JText::_('OS_REGION');
                            $addressArr[4] =  JText::_('OS_POSTCODE');

                            $optionArr = array();
                            $optionArr[0] = "0,1,2,3,4";
                            $optionArr[1] = "0,1,4,2,3";
                            $optionArr[2] = "0,1,4,3,2";
                            $optionArr[3] = "0,1,3,4,2";
                            $optionArr[4] = "0,1,3,2,4";
                            $optionArr[5] = "0,1,2,4,3";

                            $nColArr = array();
                            for($i=0;$i<count($optionArr);$i++){
                                $item = $optionArr[$i];
                                $itemArr = explode(",",$item);
                                $value = "";
                                if(count($itemArr) > 0){
                                    for($j=0;$j<count($itemArr);$j++){
                                        $value .= $addressArr[$itemArr[$j]].", ";
                                    }
                                    $value = substr($value,0,strlen($value)-2);
                                }
                                $nColArr[$i] = JHTML::_('select.option',$item,$value);
                            }
                            if (!isset($configs['address_format'])) $configs['address_format'] = '1';
                            echo JHtml::_('select.genericlist',$nColArr,'configuration[address_format]','class="chosen input-xxlarge"','value','text',$configs['address_format']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Max photos can uploaded' );?>::<?php echo JTextOs::_('Max photos can uploaded explain'); ?>">
                                <label for="configuration[bussiness_name]">
                                    <?php echo JTextOs::_( 'Max photos can uploaded' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class="input-mini" size="5" name="configuration[limit_upload_photos]" value="<?php echo isset($configs['limit_upload_photos'])? $configs['limit_upload_photos']:''; ?>"> <?php echo JText::_("OS_PHOTOS")?>

                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_REF_FIELD' );?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_REF_FIELD' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            $option_ref_field = array();
                            $option_ref_field[] = JHtml::_('select.option',0,JText::_('OS_MANUAL_ENTER'));
                            $option_ref_field[] = JHtml::_('select.option',1,JText::_('OS_AUTO_GENERATE'));
                            echo JHtml::_('select.genericlist',$option_ref_field,'configuration[ref_field]','class="chosen input-large"','value','text',isset($configs['ref_field'])? $configs['ref_field']:0);
                            ?>
                        </td>
                    </tr>

					<tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_REF_PREFIX_EXPLAIN' );?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_REF_PREFIX' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class="input-small" name="configuration[ref_prefix]" value="<?php echo isset($configs['ref_prefix'])? $configs['ref_prefix']:'PREFIX'; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Show meta tag' );?>::<?php echo JTextOs::_('Show meta tag explain'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JTextOs::_( 'Show meta tag' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('show_metatag',$configs['show_metatag']);
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Show just added icon' );?>::<?php echo JTextOs::_('Show just added icon explain'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JTextOs::_( 'Show just added icon' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('show_just_add_icon',$configs['show_just_add_icon']);
                            ?>

                        </td>
                    </tr>

                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Show just updated icon' );?>::<?php echo JTextOs::_('Show just updated icon explain'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JTextOs::_( 'Show just updated icon' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('show_just_update_icon',$configs['show_just_update_icon']);
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Use energy and elimate' );?>::<?php echo JTextOs::_('Use energy and elimate explain'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JTextOs::_( 'Use energy and elimate' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('energy',$configs['energy']);
                            ?>

                        </td>
                    </tr>

                    <tr>
                        <td class="key" nowrap="nowrap" valign="top">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Energy Measurement steps' );?>::<?php echo JTextOs::_('Energy Measurement steps explain'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JTextOs::_( 'Energy Measurement steps' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            $alphabet_array = array('a','b','c','d','e','f');
                            ?>
                            <table class="table table-striped" style="width:400px;">
                                <thead>
                                <tr class="success">
                                    <td width="50%">
                                        <?php echo JText::_('OS_STEPS')?>
                                    </td>
                                    <td width="50%">
                                        <?php echo JText::_('OS_VALUE')?>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                for($i=0;$i<count($alphabet_array);$i++){
                                    ?>
                                    <tr>
                                        <td width="50%">
                                            <?php
                                            echo JText::_('OS_STEP').' '.strtoupper($alphabet_array[$i]);
                                            ?>
                                        </td>
                                        <td width="50%">
                                            <input type="text" class="input-mini" name="configuration[running_costs_<?php echo strtoupper($alphabet_array[$i]); ?>]" value="<?php echo $configs['running_costs_'.strtoupper($alphabet_array[$i])]?>" />
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td class="key" nowrap="nowrap" valign="top">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Climate Measurement steps' );?>::<?php echo JTextOs::_('Climate Measurement steps explain'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JTextOs::_( 'Climate Measurement steps' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            $alphabet_array = array('a','b','c','d','e','f');
                            ?>
                            <table class="table table-striped" style="width:400px;">
                                <thead>
                                <tr class="success">
                                    <td width="50%">
                                        <?php echo JText::_('OS_STEPS')?>
                                    </td>
                                    <td width="50%">
                                        <?php echo JText::_('OS_VALUE')?>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                for($i=0;$i<count($alphabet_array);$i++){
                                    ?>
                                    <tr>
                                        <td width="50%">
                                            <?php
                                            echo JText::_('OS_STEP').' '.strtoupper($alphabet_array[$i]);
                                            ?>
                                        </td>
                                        <td width="50%">
                                            <input type="text" class="input-mini" name="configuration[co2_emissions_<?php echo strtoupper($alphabet_array[$i]); ?>]" value="<?php echo $configs['co2_emissions_'.strtoupper($alphabet_array[$i])]?>" />
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap" colspan="2" style="text-align:center !important;">
							<strong>
								<?php echo JText::_( 'OS_USE_BASE_PROPERTY_FIELDS' ); ?>
							</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Use number rooms field' );?>::<?php echo JTextOs::_('Use number rooms field explain'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JTextOs::_( 'Use number rooms field' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('use_rooms',$configs['use_rooms']);
                            ?>

                        </td>
                    </tr>

                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Use number bedrooms field' );?>::<?php echo JTextOs::_('Use number bedrooms field explain'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JTextOs::_( 'Use number bedrooms field' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('use_bedrooms',$configs['use_bedrooms']);
                            ?>

                        </td>
                    </tr>

                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Use number bathrooms field' );?>::<?php echo JTextOs::_('Use number bathrooms field explain'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JTextOs::_( 'Use number bathrooms field' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('use_bathrooms',$configs['use_bathrooms']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_FRACTIONAL_BATHS' );?>::<?php echo JText::_('OS_FRACTIONAL_BATHS_EXPLAIN'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_FRACTIONAL_BATHS' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('fractional_bath',$configs['fractional_bath']);
                            ?>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap" colspan="2" style="text-align:center !important;">
							<strong>
								<?php echo JText::_( 'OS_BUILDING_INFORMATION' ); ?>
							</strong>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_BUILDING_INFORMATION' );?>::<?php echo JText::_('OS_BUILDING_INFORMATION_EXPLAIN'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_BUILDING_INFORMATION' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('use_nfloors',$configs['use_nfloors']);
                            ?>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap" colspan="2" style="text-align:center !important;">
							<strong>
								<?php echo JTextOs::_( 'Use parking field' ); ?>
							</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Use parking field' );?>::<?php echo JTextOs::_('Use parking field explain'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JTextOs::_( 'Use parking field' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('use_parking',$configs['use_parking']);
                            ?>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap" colspan="2" style="text-align:center !important;">
							<strong>
								<?php echo JText::_( 'OS_BASEMENT_FOUNDATION' ); ?>
							</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_BASEMENT_FOUNDATION' );?>::<?php echo JText::_('OS_BASEMENT_FOUNDATION_EXPLAIN'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_BASEMENT_FOUNDATION' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('basement_foundation',$configs['basement_foundation']);
                            ?>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap" colspan="2" style="text-align:center !important;">
							<strong>
								<?php echo JText::_( 'OS_LAND_INFORMATION' ); ?>
							</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_LAND_INFORMATION' );?>::<?php echo JText::_('OS_LAND_INFORMATION_EXPLAIN'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_LAND_INFORMATION' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('use_squarefeet',$configs['use_squarefeet']);
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_LAND_AREA_UNIT_OF_MEASUREMENT' );?>::<?php echo JText::_('OS_LAND_AREA_UNIT_OF_MEASUREMENT_EXPLAIN'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_LAND_AREA_UNIT_OF_MEASUREMENT' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('use_square',$configs['use_square'],JText::_('OS_METER'),JText::_('OS_FEET'));
                            ?>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_ACREAGE_UNIT_OF_MEASUREMENT' );?>::<?php echo JText::_('OS_ACREAGE_UNIT_OF_MEASUREMENT_EXPLAIN'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_ACREAGE_UNIT_OF_MEASUREMENT' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('acreage',$configs['acreage'],JText::_('OS_ACRES'),JText::_('OS_HECTARES'));
                            ?>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap" colspan="2" style="text-align:center !important;">
							<strong>
								<?php echo JText::_( 'Show Property History & Tax' ); ?>
							</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Show Property History & Tax' );?>::<?php echo JText::_('Do you want to show Property Sold History & Tax'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'Show Property History & Tax' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('use_property_history',$configs['use_property_history']);
                            ?>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap" colspan="2" style="text-align:center !important;">
							<strong>
								<?php echo JText::_( 'OS_BUSINESS_INFORMATION' ); ?>
							</strong>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_BUSINESS_INFORMATION' );?>::<?php echo JText::_('OS_BUSINESS_INFORMATION_EXPLAIN'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_BUSINESS_INFORMATION' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('use_business',$configs['use_business']);
                            ?>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap" colspan="2" style="text-align:center !important;">
							<strong>
								<?php echo JText::_( 'OS_RURAL_INFORMATION' ); ?>
							</strong>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_RURAL_INFORMATION' );?>::<?php echo JText::_('OS_RURAL_INFORMATION_EXPLAIN'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_RURAL_INFORMATION' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('use_rural',$configs['use_rural']);
                            ?>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap" colspan="2" style="text-align:center !important;">
							<strong>
								<?php echo JText::_( 'Show Open House' ); ?>
							</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Show Open House' );?>::<?php echo JText::_('Do you want to show Open House information'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'Show Open House' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('use_open_house',$configs['use_open_house']);
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <legend><?php echo JText::_('OS_SOCIAL_SHARING')?></legend>
                <table  width="100%" class="admintable">
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_ALLOW_SOCIAL_SHARING' );?>::<?php echo JTextOs::_('ALLOW_SOCIAL_SHARING_EXPLAIN'); ?>">
                                <label for="checkbox_property_save_to_favories">
                                    <?php echo JText::_( 'OS_ALLOW_SOCIAL_SHARING' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('social_sharing',$configs['social_sharing']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_SHOW_FACEBOOK_LIKE' );?>::<?php echo JTextOs::_('SHOW_FACEBOOK_LIKE_EXPLAIN'); ?>">
                                <label for="checkbox_property_save_to_favories">
                                    <?php echo JText::_( 'OS_SHOW_FACEBOOK_LIKE' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('show_fb_like',$configs['show_fb_like']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_FACEBOOK_LIKE_HEIGHT' );?>::<?php echo JText::_('OS_FACEBOOK_LIKE_HEIGHT_EXPLAIN'); ?>">
                                <label for="checkbox_property_save_to_favories">
                                    <?php echo JText::_( 'OS_FACEBOOK_LIKE_HEIGHT' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class="input-mini" name="configuration[facebook_height]" value="<?php echo isset($configs['facebook_height'])? $configs['facebook_height']:''; ?>">&nbsp;px
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_FACEBOOK_API' );?>::<?php echo JText::_('OS_FACEBOOK_API_EXPLAIN'); ?>">
                                <label for="checkbox_property_save_to_favories">
                                    <?php echo JText::_( 'OS_FACEBOOK_API' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" size="70" name="configuration[facebook_api]" value="<?php echo isset($configs['facebook_api'])? $configs['facebook_api']:''; ?>">
                            <BR />
                            Register your OS Property website as an Application to obtain your OAuth keys. You can register the site and obtain keys here: <a href="https://developers.facebook.com" target="_blank">https://developers.facebook.com</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Show Twitter in Property Details' );?>">
                                <label for="checkbox_property_save_to_favories">
                                    <?php echo JText::_( 'Show Twitter in Property Details' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('show_twitter',$configs['show_twitter']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Add a VIA tag to the tweet -- normally OS Property will use your current username' );?>">
                                <label for="checkbox_property_save_to_favories">
                                    <?php echo JText::_( 'Tweet Via (@)' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class="input-medium" name="configuration[twitter_via]" value="<?php echo isset($configs['twitter_via'])? $configs['twitter_via']:''; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Comman-separated list of hashtags to use in the tweet' );?>">
                                <label for="checkbox_property_save_to_favories">
                                    <?php echo JText::_( 'Tweet Hash tags (#)' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class="input-medium" name="configuration[twitter_hash]" value="<?php echo isset($configs['twitter_hash'])? $configs['twitter_hash']:''; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Show Google Plus in Property Details' );?>">
                                <label for="checkbox_property_save_to_favories">
                                    <?php echo JText::_( 'Show Google Plus in Property Details' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('google_plus',$configs['google_plus']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Show Pinterest in Property Details' );?>">
                                <label for="checkbox_property_save_to_favories">
                                    <?php echo JText::_( 'Show Pinterest in Property Details' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('pinterest',$configs['pinterest']);
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <legend><?php echo JText::_('OS_SEF')?></legend>
                <table  width="100%" class="admintable">
                	<tr>
                        <td class="key" nowrap="nowrap" valign="top">
                            <span class="editlinktip hasTip" title="<?php echo JText::_('OS_SEF_LINK_CONTAIN_EXPLAIN'); ?>">
                                <label for="gallery_type">
                                    <?php echo JText::_( 'OS_SEF_LINK_CONTAIN' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            $sefArr[] = JHTML::_('select.option','0',JText::_('OS_ALIAS_ONLY'));
                            $sefArr[] = JHTML::_('select.option','1',JText::_('OS_REF_ALIAS'));
                            $sefArr[] = JHTML::_('select.option','2',JText::_('OS_REF_ALIAS_ID'));
                            echo JHtml::_('select.genericlist',$sefArr,'configuration[sef_configure]','class="chosen input-medium"','value','text',$configs['sef_configure']);
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <legend><?php echo JText::_('OS_BREADCRUMBS')?></legend>
                <table  width="100%" class="admintable">
                    <tr>
                        <td class="key" nowrap="nowrap" valign="top">
                            <span class="editlinktip hasTip" title="<?php echo JText::_('OS_INCLUDE_CATEGORIES'); ?>">
                                <label for="gallery_type">
                                    <?php echo JText::_( 'OS_INCLUDE_CATEGORIES' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('include_categories',$configs['include_categories']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap" valign="top">
                            <span class="editlinktip hasTip" title="<?php echo JText::_('OS_INCLUDE_PROPERTY_TYPE'); ?>">
                                <label for="gallery_type">
                                    <?php echo JText::_( 'OS_INCLUDE_PROPERTY_TYPE' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('include_type',$configs['include_type']);
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </td>
        <td width="50%" valign="top">
            <fieldset>
                <legend><?php echo JText::_('OS_ALERT_EMAIL_SETTING')?></legend>
                <table width="100%" class="admintable">
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_ACTIVATE_ALERT_EMAIL_FEATURE' );?>::<?php echo JText::_('OS_ACTIVATE_ALERT_EMAIL_FEATURE_EXPLAIN'); ?>">
                                <label for="checkbox_categories_show_sub_categories">
                                    <?php echo JText::_( 'OS_ACTIVATE_ALERT_EMAIL_FEATURE' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('active_alertemail',$configs['active_alertemail']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_CRONJOB_FILE' );?>">
                                <label for="checkbox_categories_show_sub_categories">
                                    <?php echo JText::_( 'OS_CRONJOB_FILE' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            Live URL: <strong style="color:green;"><?php echo JUri::root(); ?>components/com_osproperty/cron.php</strong>
                            <BR />
                            Real Path: <strong style="color:red;"><?php echo JPATH_ROOT; ?>/components/com_osproperty/cron.php</strong>
                            <BR />
                            <i>You need to set up a cron job using your hosting account control panel which should execute every hours. Depending on your web server you should use either the live url or real path.</i>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap" valign="top">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'NUMBER_LISTING_TO_CHECK_PER_CRONTASK_RUNNING' );?>
                                <label for="checkbox_number_email_by_hour">
                                    <?php echo JTextOs::_( 'NUMBER_LISTING_TO_CHECK_PER_CRONTASK_RUNNING' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class="text-area-order input-mini" size="5" name="configuration[max_properties_per_time]" value="<?php echo isset($configs['max_properties_per_time'])?$configs['max_properties_per_time']:'100' ?>" />
                            <BR />
                            <i><?php echo JTextOs::_( 'NUMBER_LISTING_TO_CHECK_PER_CRONTASK_RUNNING_EXPLAIN' ); ?></i>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap" valign="top">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'NUMBER_SAVED_LIST_TO_CHECK_PER_CRONTASK_RUNNING' );?>
                                <label for="checkbox_number_email_by_hour">
                            <?php echo JTextOs::_( 'NUMBER_SAVED_LIST_TO_CHECK_PER_CRONTASK_RUNNING' ).':'; ?>
                            </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class="text-area-order input-mini" size="5" name="configuration[max_lists_per_time]" value="<?php echo isset($configs['max_lists_per_time'])?$configs['max_lists_per_time']:'50' ?>" />
                            <BR />
                            <i><?php echo JTextOs::_( 'NUMBER_SAVED_LIST_TO_CHECK_PER_CRONTASK_RUNNING_EXPLAIN' ); ?></i>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap" valign="top">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'NUMBER_EMAIL_CRONTASK_RUNNING' );?>
                                <label for="checkbox_number_email_by_hour">
                            <?php echo JTextOs::_( 'NUMBER_EMAIL_CRONTASK_RUNNING' ).':'; ?>
                            </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class="text-area-order input-mini" size="5" name="configuration[max_email_per_time]" value="<?php echo isset($configs['max_email_per_time'])?$configs['max_email_per_time']:'50' ?>" />
                            <BR />
                            <i><?php echo JTextOs::_( 'NUMBER_EMAIL_CRONTASK_RUNNING_EXPLAIN' ); ?></i>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <legend><?php echo JTextOs::_('Comment Settings')?></legend>
                <table width="100%" class="admintable">
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_ACTIVATE_COMMENT_AND_RATING' );?>::<?php echo JTextOs::_(''); ?>">
                                <label for="checkbox_categories_show_sub_categories">
                                    <?php echo JText::_( 'OS_ACTIVATE_COMMENT_AND_RATING' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('comment_active_comment',$configs['comment_active_comment']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Auto approved Comment' );?>::<?php echo JTextOs::_(''); ?>">
                                <label for="checkbox_categories_show_sub_categories">
                                    <?php echo JTextOs::_( 'Auto approved Comment' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('comment_auto_approved',$configs['comment_auto_approved']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Show rating icon' );?>::<?php echo JTextOs::_('Show rating icon explain'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JTextOs::_( 'Show rating icon' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('show_rating',$configs['show_rating']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_('OS_ONLY_REGISTERED_USER_CAN_SUBMIT_REVIEW_EXPLAIN'); ?>">
                                <label for="checkbox_categories_show_sub_categories">
                                    <?php echo JText::_( 'OS_ONLY_REGISTERED_USER_CAN_SUBMIT_REVIEW' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('registered_user_write_comment',$configs['registered_user_write_comment']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_('OS_ONE_USER_CAN_WRITE_ONE_REVIEW_EXPLAIN'); ?>">
                                <label for="checkbox_categories_show_sub_categories">
                                    <?php echo JText::_( 'OS_ONE_USER_CAN_WRITE_ONE_REVIEW' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('only_one_review',$configs['only_one_review']);
                            ?>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_('Allow user to edit comment'); ?>">
                                <label for="checkbox_categories_show_sub_categories">
                                    <?php echo JText::_( 'Allow user to edit comment' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('allow_edit_comment',$configs['allow_edit_comment']);
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <?php require_once (JPATH_COMPONENT_ADMINISTRATOR.DS.'classes'.DS.'configuration'.DS.'general'.DS.'csv.php');?>
            <?php require_once (JPATH_COMPONENT_ADMINISTRATOR.DS.'classes'.DS.'configuration'.DS.'properties'.DS.'sold.php');?>
            <fieldset>
                <legend><?php echo JTextOs::_('Walking score setting')?></legend>
                <table  width="100%" class="admintable">
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Show walked score tab' );?>::<?php echo JTextOs::_('Show walked score tab explain'); ?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JTextOs::_( 'Show walked score tab' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('show_walkscore',$configs['show_walkscore']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Walked score ID' );?>::<?php echo JTextOs::_('Walked score ID explain.'); ?>">
                                <label for="configuration[bussiness_name]">
                                    <?php echo JTextOs::_( 'Walked score ID' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" size="50" name="configuration[ws_id]" value="<?php echo isset($configs['ws_id'])? $configs['ws_id']:''; ?>">
                            <div class="clr"></div>
                            <?php echo JText::_('Click here to request new API Walked Score key');?>
                            <a href="http://www.walkscore.com/professional/api-sign-up.php" target="_blank">http://www.walkscore.com/professional/api-sign-up.php</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Width size of Walked score div' );?>::<?php echo JTextOs::_('Width size of Walked score div explain.'); ?>">
                                <label for="configuration[bussiness_name]">
                                    <?php echo JTextOs::_( 'Width size of Walked score div' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class="input-mini" size="5" name="configuration[ws_width]" value="<?php echo isset($configs['ws_width'])? $configs['ws_width']:''; ?>"> px

                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Height size of Walked score div' );?>::<?php echo JTextOs::_('Height size of Walked score div explain.'); ?>">
                                <label for="configuration[bussiness_name]">
                                    <?php echo JTextOs::_( 'Height size of Walked score div' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class="input-mini" size="5" name="configuration[ws_height]" value="<?php echo isset($configs['ws_height'])? $configs['ws_height']:''; ?>"> px
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap" valign="top">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Unit' );?>">
                                <label for="gallery_type">
                                    <?php echo JTextOs::_( 'Unit' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            $nColArr = array();
                            $nColArr[] = JHTML::_('select.option','mi','Miles');
                            $nColArr[] = JHTML::_('select.option','km','Kilometers');
                            echo JHtml::_('select.genericlist',$nColArr,'configuration[ws_unit]','class="chosen input-small"','value','text',$configs['ws_unit']);
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
			<!--
            <fieldset>
                <legend><?php echo JText::_('OS_EDUCATION_INTEGRATION')?></legend>
                <table  width="100%" class="admintable">
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Show Education tab' );?>::<?php echo JText::_('Do you want to show Education tab. Note: Education.com data is only available in some areas and may not work for your location'); ?>">
                                <label for="checkbox_property_mail_to_friends">
                                    <?php echo JText::_( 'Show Education tab' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('integrate_education',$configs['integrate_education']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Show Education in Radius' );?>::<?php echo JText::_('Distance in miles from listing to return results (ex: 1.5)'); ?>">
                                <label for="configuration[bussiness_name]">
                                    <?php echo JText::_( 'Show Education in Radius' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class = "input-mini" name="configuration[education_radius]" value="<?php echo isset($configs['education_radius'])? $configs['education_radius']:''; ?>"> Miles
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Minimum Education Results' );?>::<?php echo JText::_('Minimum number of results to return-- will increase radius until this is met'); ?>">
                                <label for="configuration[bussiness_name]">
                                    <?php echo JText::_( 'Minimum Education Results' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class = "input-mini" name="configuration[education_min]" value="<?php echo isset($configs['education_min'])? $configs['education_min']:''; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Maximum Education Results' );?>::<?php echo JText::_('Maximum number of results to return-- will increase radius until this is met'); ?>">
                                <label for="configuration[bussiness_name]">
                                    <?php echo JText::_( 'Maximum Education Results' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class = "input-mini" name="configuration[education_max]" value="<?php echo isset($configs['education_max'])? $configs['education_max']:''; ?>">
                        </td>
                    </tr>
                </table>
            </fieldset>
			-->
            <fieldset>
                <legend><?php echo JText::_('OS_PDF_EXPORT')?></legend>
                <table  width="100%" class="admintable">
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_PDF_EXPORT_FEATURE' );?>::<?php echo JTextOs::_('PDF_LAYOUT_EXPLAIN'); ?>">
                                <label for="checkbox_property_pdf_layout">
                                    <?php echo JText::_( 'OS_PDF_EXPORT_FEATURE' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('property_pdf_layout',$configs['property_pdf_layout']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap" valign="top">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Select pdf export library' );?>">
                                <label for="gallery_type">
                                    <?php echo JTextOs::_( 'Select pdf export library' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            $pdfArr[] = JHTML::_('select.option','1','FPDF');
                            $pdfArr[] = JHTML::_('select.option','2','TCPDF');
                            if (!isset($configs['pdf_lib'])) $configs['pdf_lib'] = '1';
                            echo JHtml::_('select.genericlist',$pdfArr,'configuration[pdf_lib]','class="chosen input-small"','value','text',$configs['pdf_lib']);
                            ?>
                            <div class="clr"></div>
                            <?php echo JTextOs::_( 'Select pdf export library explain' );?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <legend><?php echo JText::_('OS_RELATED_PROPERTIES')?></legend>
                <table  width="100%" class="admintable">
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_SHOW_RELATED_PROPERTIES' );?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_SHOW_RELATED_PROPERTIES' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('relate_properties',$configs['relate_properties']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Max relate properties' );?>::<?php echo JTextOs::_('Max relate properties explain'); ?>">
                                <label for="configuration[bussiness_name]">
                                    <?php echo JTextOs::_( 'Max relate properties' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" class="input-mini" size="5" name="configuration[max_relate]" value="<?php echo isset($configs['max_relate'])? $configs['max_relate']:''; ?>"> <?php echo JText::_('OS_PROPERTIES');?>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap" valign="top">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_RELATED_PROPERTIES_IN_COLUMNS' );?>">
                                <label for="gallery_type">
                                    <?php echo JText::_( 'OS_RELATED_PROPERTIES_IN_COLUMNS' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            $columns = array();
                            $columns[] = JHTML::_('select.option','2','2');
                            $columns[] = JHTML::_('select.option','3','3');
                            $columns[] = JHTML::_('select.option','4','4');
                            if (!isset($configs['relate_columns'])) $configs['relate_columns'] = '2';
                            echo JHtml::_('select.genericlist',$columns,'configuration[relate_columns]','class="chosen input-small"','value','text',$configs['relate_columns']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Select relate properties in the same city' );?>::<?php echo JTextOs::_('Select relate properties in the same city explain'); ?>">
                                <label for="checkbox_property_save_to_favories">
                                    <?php echo JTextOs::_( 'Select relate properties in the same city' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('relate_city',$configs['relate_city']);
                            ?>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap" valign="top">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Relate properties distance' );?>::<?php echo JTextOs::_('Relate properties distance explain'); ?>">
                                <label for="gallery_type">
                                    <?php echo JTextOs::_( 'Relate properties distance' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            $distanceArr[] = JHTML::_('select.option','5','5 Miles');
                            $distanceArr[] = JHTML::_('select.option','10','10 Miles');
                            $distanceArr[] = JHTML::_('select.option','20','20 Miles');
                            $distanceArr[] = JHTML::_('select.option','50','50 Miles');
							$distanceArr[] = JHTML::_('select.option','100','100 Miles');
                            if (!isset($configs['relate_distance'])) $configs['relate_distance'] = '0';
                            echo JHtml::_('select.genericlist',$distanceArr,'configuration[relate_distance]','class="chosen input-small"','value','text',$configs['relate_distance']);
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Select relate properties in the same property type' );?>::<?php echo JTextOs::_('Select relate properties in the same property type explain'); ?>">
                                <label for="checkbox_property_save_to_favories">
                                    <?php echo JTextOs::_( 'Select relate properties in the same property type' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('relate_property_type',$configs['relate_property_type']);
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
			<?php
			if (version_compare(phpversion(), '5.4.0', 'ge')) {
			?>
            <fieldset>
                <legend><?php echo JText::_('OS_FACEBOOK_AUTO_POSTING')?></legend>
				This feature is used to post property details into Facebook. 
				<BR />
				<strong>Note: </strong>
				<BR />
				1. You need to enter App ID and App Secret and get Access Token
				<BR />
				2. This feature will update Published and Approved properties
				<BR /><BR />
                <script src="<?php echo JUri::root()?>components/com_osproperty/js/all.js" type="text/javascript"></script>
                <table  width="100%" class="admintable">
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_FACEBOOK_AUTO_POSTING' );?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_ENABLE_FACEBOOK_AUTO_POSTING' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('facebook_autoposting',$configs['facebook_autoposting']);
                            ?>
                        </td>
                    </tr>
					<tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_POSTING_PROPERTIES' );?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_POSTING_PROPERTIES' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            $optionArr = array();
							$optionArr[] = JHTML::_('select.option',0,JText::_('OS_BOTH_NEW_AND_UPDATED_PROPERTIES'));
							$optionArr[] = JHTML::_('select.option',1,JText::_('OS_ONLY_NEW_PROPERTIES'));
							$optionArr[] = JHTML::_('select.option',2,JText::_('OS_ONLY_UPDATED_PROPERTIES'));
							echo JHTML::_('select.genericlist',$optionArr,'configuration[posting_properties]','class="chosen input-large"','value','text',$configs['posting_properties']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_FACEBOOK_APP_ID' );?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_FACEBOOK_APP_ID' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" id="fb_app_id" data-bind="value: app_id" class="input-medium" name="configuration[fb_app_id]" value="<?php echo isset($configs['fb_app_id'])? $configs['fb_app_id']:''; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_FACEBOOK_APP_SECRET' );?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_FACEBOOK_APP_SECRET' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" id="fb_app_secret" data-bind="value: app_secret" class="input-large" name="configuration[fb_app_secret]" value="<?php echo isset($configs['fb_app_secret'])? $configs['fb_app_secret']:''; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap"></td>
                        <td>
                            <button class="btn btn-primary" type="button" onClick="javascript:getFbToken()"><?php echo JText::_('Get Access Token')?></button>
							<div id="location_div"></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap"><?php echo JText::_( 'OS_FACEBOOK_ACCESS_TOKEN' ).':'; ?></td>
                        <td>
                            <input data-bind="value: app_secret" class="input-large" id="access_token" type="text" name="configuration[access_token]" readonly="true" aria-invalid="true" value="<?php echo isset($configs['access_token'])? $configs['access_token']:''; ?>" />
                        </td>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap"><?php echo JText::_( 'OS_TARGET' ).':'; ?></td>
                        <td>
							<?php
							$fb_params = $configs['fb_params'];
							$fb_params = explode("||",$fb_params);
							
							$fb_target = $configs['fb_target'];
							?>
							<select name="configuration[fb_target]" id="fb_target" class="input-large">
								<?php
								if(count($fb_params) > 0){
									foreach($fb_params as $param){
										$param = explode("@@",$param);
										$label = $param[0];
										if($label != ""){
											?>
											<optgroup label="<?php echo $label;?>">
											<?php
										}
										$content = $param[1];
										$content = explode("{+}",$content);
										if(count($content) > 0){
											foreach($content as $optionValue){
												$optionValue = explode(":",$optionValue);
												
												if($fb_target == $optionValue[0]){
													$selected = "selected";
												}else{
													$selected = "";
												}
												?>
												<option value="<?php echo $optionValue[0]?>" <?php echo $selected; ?>><?php echo $optionValue[1]; ?></option>
												<?php
											}
										}
										
										if($label != ""){
											?>
											</optgroup>
											<?php
										}
									}
								}
								?>
							</select>
                        </td>
                    </tr>
                </table>
				<textarea name="configuration[fb_params]" id="fb_params" style="display:none;"><?php echo $configs['fb_params'];?></textarea>
                <script language="JavaScript">
                    function getFbToken(){
                        var fb_app_id = document.getElementById('fb_app_id');
                        var fb_app_secret = document.getElementById('fb_app_secret');
                        if(fb_app_id.value == ""){
                            alert("Please enter Application ID");
                            return false;
                        }
                        if(fb_app_secret.value == ""){
                            alert("Please enter Application Secret");
                            return false;
                        }
                        xmlHttp=GetXmlHttpObject();
                        if (xmlHttp==null){
                            alert ("Browser does not support HTTP Request")
                            return
                        }

                        url = "https://graph.facebook.com/" + fb_app_id.value;
                        xmlHttp.onreadystatechange=ajaxfb;
                        xmlHttp.open("GET",url,true)
                        xmlHttp.send(null)
                    }

                    function ajaxfb(){
                        if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
                            res = xmlHttp.responseText;
                            data = JSON.parse(res);

                            var fb_app_id = document.getElementById('fb_app_id');
                            var fb_app_secret = document.getElementById('fb_app_secret');
                            if(typeof(data.icon_url) != 'undefined'){
                                var w = 550;
                                var h = 450;
                                var left = (screen.width/2)-(w/2);
                                var top = (screen.height/2)-(h/2);
                                window.open('index.php?option=com_osproperty&task=configuration_connectfb&tmpl=component&app_id='+fb_app_id.value+'&app_secret='+fb_app_secret.value, 'Get Access Token', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left).focus();
                            }else{
                                alert("Invalid App ID");
                            }
                        }
                    }
                </script>
            </fieldset>
			<?php 
			}
			?>
			<fieldset>
                <legend><?php echo JText::_('OS_TWEET_AUTO_POSTING')?></legend>
                This feature is used to post property details into Twitter.com.
                <BR />
                <strong>Note: </strong>
                <BR />
                1. You need to enter Consumer Key, Consumer Secret, Access Token and Access Token Secret
                <BR />
                2. This feature will update Published and Approved properties
                <BR /><BR />
                <table  width="100%" class="admintable">
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_TWEET_AUTO_POSTING' );?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_ENABLE_TWEET_AUTO_POSTING' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            OspropertyConfiguration::showCheckboxfield('tweet_autoposting',$configs['tweet_autoposting']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_POSTING_PROPERTIES' );?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_POSTING_PROPERTIES' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <?php
                            $optionArr = array();
                            $optionArr[] = JHTML::_('select.option',0,JText::_('OS_BOTH_NEW_AND_UPDATED_PROPERTIES'));
                            $optionArr[] = JHTML::_('select.option',1,JText::_('OS_ONLY_NEW_PROPERTIES'));
                            $optionArr[] = JHTML::_('select.option',2,JText::_('OS_ONLY_UPDATED_PROPERTIES'));
                            echo JHTML::_('select.genericlist',$optionArr,'configuration[tw_posting_properties]','class="chosen input-large"','value','text',$configs['tw_posting_properties']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_CONSUMER_KEY' );?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_CONSUMER_KEY' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" id="consumer_key"  class="input-large" name="configuration[consumer_key]" value="<?php echo isset($configs['consumer_key'])? $configs['consumer_key']:''; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_CONSUMER_SECRET' );?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_CONSUMER_SECRET' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" id="consumer_secret" class="input-large" name="configuration[consumer_secret]" value="<?php echo isset($configs['consumer_secret'])? $configs['consumer_secret']:''; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_ACCESS_TOKEN' );?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_ACCESS_TOKEN' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" id="tw_access_token" class="input-large" name="configuration[tw_access_token]" value="<?php echo isset($configs['tw_access_token'])? $configs['tw_access_token']:''; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="key" nowrap="nowrap">
                            <span class="editlinktip hasTip" title="<?php echo JText::_( 'OS_ACCESS_TOKEN_SECRET' );?>">
                                <label for="checkbox_property_show_rating">
                                    <?php echo JText::_( 'OS_ACCESS_TOKEN_SECRET' ).':'; ?>
                                </label>
                            </span>
                        </td>
                        <td>
                            <input type="text" id="tw_access_token_secret" class="input-large" name="configuration[tw_access_token_secret]" value="<?php echo isset($configs['tw_access_token_secret'])? $configs['tw_access_token_secret']:''; ?>" />
                        </td>
                    </tr>
                </table>
            </fieldset>
        </td>
    </tr>
</table>

