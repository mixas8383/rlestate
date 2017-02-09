<?php
/*------------------------------------------------------------------------
# ajax.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/

defined('_JEXEC') or die('Restricted access');

class OspropertyAjax
{
    /**
     * Ajax default function
     *
     * @param unknown_type $option
     * @param unknown_type $task
     */
    static function display($option, $task)
    {
        global $jinput, $mainframe;
		$jinput = JFactory::getApplication()->input;
        $db = JFactory::getDBO();
        $id = $jinput->getInt('id', 0);
        $user = JFactory::getUser();
        switch ($task) {
            case "ajax_addFavorites":
                self::addFavorites($id);
				exit();
                break;
            case "ajax_removeFavorites":
                self::removeFavorites($id);
				exit();
                break;
            case "ajax_removeCompare":
                self::removeCompare($id);
				exit();
            break;
            case "ajax_addCompare":
                self::addCompare($id);
				exit();
                break;
            case "ajax_checkcouponcode":
                OspropertyAjax::checkcouponcode($option);
                break;
            case "ajax_loadStateInListPage":
                OspropertyAjax::loadStateInListPage($option);
                break;
            case "ajax_loadStateBackend":
                OspropertyAjax::loadStateBackend($option);
                break;
            case "ajax_loadCityBackend":
                OspropertyAjax::loadCityBackend($option);
                break;
            case "ajax_agentsearch":
                OspropertyAjax::agentSearch($option);
                break;
            case "ajax_searchagentforaddtocompany":
                OspropertyAjax::searchAgentforaddtocompany($option);
                break;
            case "ajax_loadstatecity":
                $country_name = OSPHelper::getStringRequest('country_name','','get');
                $country_id = $jinput->getInt('country_id', '0');
                $state_name = OSPHelper::getStringRequest('state_name','','get');
                $state_id = $jinput->getInt('state_id', '0');
                $city_id = $jinput->getInt('city_id');
                OspropertyAjax::loadStateCity($option, $country_name, $country_id, $state_id, $city_id, $state_name);
                break;
            case "ajax_loadstatecityBackend":
                $country_name = OSPHelper::getStringRequest('country_name','','get');
                $country_id = $jinput->getInt('country_id', '0');
                $state_name = OSPHelper::getStringRequest('state_name','','get');
                $state_id = $jinput->getInt('state_id', '0');
                $city_id = $jinput->getInt('city_id');
                OspropertyAjax::loadStateCityBackend($option, $country_name, $country_id, $state_id, $city_id, $state_name);
                break;
            case "ajax_loadstatecityArr":
                $country_name = OSPHelper::getStringRequest('country_name','','get');
                $country_id = $jinput->getInt('country_id', '0');
                $state_name = OSPHelper::getStringRequest('state_name','','get');
                $state_id = $jinput->getInt('state_id', '0');
                $city_id = $jinput->getInt('city_id');
                OspropertyAjax::loadStateCity($option, $country_name, $country_id, $state_id, $city_id, $state_name);
                break;
            case "ajax_loadstatecitylocatorModule":
                $country_name = OSPHelper::getStringRequest('country_name','','get');
                $country_id = $jinput->getInt('country_id', '0');
                $state_name = OSPHelper::getStringRequest('state_name','','get');
                $state_id = $jinput->getInt('state_id', '0');
                $city_id = $jinput->getInt('city_id');
                $random_id = $jinput->getInt('random_id', '0');
                OspropertyAjax::loadStateCityLocatorModule($option, $country_name, $country_id, $state_id, $city_id, $state_name, $random_id);
                break;
            case "ajax_loadstatecitylocator":
                $country_name = OSPHelper::getStringRequest('country_name','','get');
                $country_id = $jinput->getInt('country_id', '0');
                $state_name = OSPHelper::getStringRequest('state_name','','get');
                $state_id = $jinput->getInt('state_id', '0');
                $city_id = $jinput->getInt('city_id');
                $class = OSPHelper::getStringRequest('class', 'input-medium');
                OspropertyAjax::loadStateCityLocator($option, $country_name, $country_id, $state_id, $city_id, $state_name, $class);
                break;
            case "ajax_loadcityModule":
                $state_name = OSPHelper::getStringRequest('state_name','','get');
                $state_id = $jinput->getInt('state_id', '0');
                $city_id = $jinput->getInt('city_id');
                $random_id = OSPHelper::getStringRequest('random_id', '','get');
                OspropertyAjax::loadCityModule($option, $state_id, $city_id, $state_name, $random_id);
                break;
            case "ajax_loadcity":
                $state_name = OSPHelper::getStringRequest('state_name','','get');
                $state_id = $jinput->getInt('state_id', '0');
                $city_id = $jinput->getInt('city_id');
                $useConfig = $jinput->getInt('useConfig', 1);
                $class = OSPHelper::getStringRequest('class', 'input-medium','get');
                $city_name = OSPHelper::getStringRequest('city_name', 'city','get');
                OspropertyAjax::loadCity($option, $state_id, $city_id, $state_name, $useConfig, $class, $city_name);
                break;
            case "ajax_loadcityAddProperty":
                $state_name = OSPHelper::getStringRequest('state_name','','get');
                $state_id = $jinput->getInt('state_id', '0');
                $city_id = $jinput->getInt('city_id');
                OspropertyAjax::loadCity($option, $state_id, $city_id, $state_name, 0);
                break;
            case "ajax_convertCurrency":
                OspropertyAjax::convertCurrency($option);
                break;
            case "ajax_loadPriceListOption":
                $property_type = $jinput->getInt('property_type', 0);
                echo HelperOspropertyCommon::generatePriceList($property_type, $price);
                exit();
                break;
            case "ajax_updatePrice":
                $type_id = $jinput->getInt('type_id',0);
                $option_id = $jinput->getInt('option_id',0);
                $min_price = $jinput->getFloat('min_price','');
                $max_price = $jinput->getFloat('max_price','');
                $module_id = $jinput->get('module_id','');
                OSPHelper::showPriceFilter($option_id,$min_price,$max_price,$type_id,'input-medium',$module_id);
				$mainframe->close();
                break;
            case "ajax_availabilitysearch":
                OspropertyAjax::ajaxsearch();
                break;
            case "ajax_loadLocationInformation":
                OspropertyAjax::loadLocationInformation();
                break;
            case "ajax_updateSendEmailStatus":
                OspropertyAjax::updateSendEmailStatus();
                break;
			case "ajax_checkingVersion":
				OspropertyAjax::checkingVersion();
				break;
			case "ajax_fbconnect":
				OspropertyAjax::fbConnect();
				break;
        }
    }

    public static function removeCompare($id){
        global $jinput;
        $session = JFactory::getSession();
        $comparelist = $session->get('comparelist');
        $comparelistArr = explode(",", $comparelist);
        $post = array_search($id,$comparelistArr);
        unset($comparelistArr,$post);
        $comparelist = implode(",",$comparelistArr);
        $session->set('comparelist', $comparelist);
        ?>
        <table jos_ class="nTable">
            <tbody>
            <tr>
                <td class="n_corner_top_left"></td>
                <td class="n_corner_top_center"></td>
                <td class="n_corner_top_right"></td>
            </tr>
            <tr>
                <td class="n_middle_left"></td>
                <td class="n_middle_center">
                    <div
                        id="notice_message"><?php echo JText::_('OS_LISTING_HAS_BEEN_REMOVED_FROM_COMPARE_LIST')?>
                        <b><a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=compare_list')?>"
                              class="static"><?php echo JText::_('OS_HERE')?></a></b> <?php echo JText::_('OS_TO_VIEW_THE_COMPARISON')?>
                    </div>
                </td>
                <td class="n_middle_right"></td>
            </tr>
            <tr>
                <td class="n_corner_bottom_left"></td>
                <td class="n_corner_bottom_center"></td>
                <td class="n_corner_bottom_right"></td>
            </tr>
            </tbody>
        </table>
        <?php
        echo "@@@";
        $theme = $jinput->getString('theme','');
        $layout = $jinput->getString('layout','');
        if($theme != ""){
            $msg = JText::_('OS_DO_YOU_WANT_TO_ADD_PROPERTY_TO_YOUR_COMPARE_LIST');
            $msg = str_replace("'", "\'", $msg);
            switch($theme){
                case "default":
                    switch($layout) {
                        case "details":
                            ?>
                                <a onclick="javascript:osConfirmExtend('<?php echo $msg;
                                ?>','ajax_addCompare','<?php echo $id?>','<?php echo JURI::root()?>','compare<?php echo $id?>','theme1','details')"
                                   href="javascript:void(0)">
                                    <?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>
                                </a>
                            <?php
                        break;
                        case "listing_list":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>','ajax_addCompare','<?php echo $id ?>','<?php echo JURI::root() ?>','compare<?php echo $id;?>','default','listing_list')" href="javascript:void(0)" title="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST');?>">
                                <img class="png" title="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>" alt="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/compare24_gray.png" />
                            </a>
                            <?php
                        break;
                        case "listing_grid":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>','ajax_addCompare','<?php echo $id ?>','<?php echo JURI::root() ?>','compare<?php echo $id;?>','default','listing_grid')" href="javascript:void(0)" class="btn btn-small" title="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST');?>">
                                <img title="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>" alt="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/compare24_gray.png" width="16"/>
                            </a>
                            <?php
                            break;
                    }
                break;
                case "theme1":
                    switch($layout) {
                        case "details":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;
                            ?>','ajax_addCompare','<?php echo $id?>','<?php echo JURI::root()?>','compare<?php echo $id?>','theme1','details')"
                               href="javascript:void(0)">
                                <?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>
                            </a>
                            <?php
                            break;
                        case "listing":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>','ajax_addCompare','<?php echo $id ?>','<?php echo JURI::root() ?>','compare<?php echo $id;?>','theme1','listing')"
                               href="javascript:void(0)"
                               class="btn btn-warning btn-small">
                                <i class="osicon-bookmark osicon-white"></i> <?php echo JText::_('OS_ADD_TO_COMPARE_LIST'); ?>
                            </a>
                            <?php
                            break;
                    }
                    break;
				case "theme2":
                    switch($layout) {
                        case "details":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>','ajax_addCompare','<?php echo $id ?>','<?php echo JURI::root() ?>','compare<?php echo $id;?>','theme2','details')" href="javascript:void(0)" class="compare has icon s_16">
							<?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>
							</a>
                            <?php
                            break;
                    }
                    break;
				case "theme3":
                    switch($layout) {
                        case "listing":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>','ajax_addCompare','<?php echo $id ?>','<?php echo JURI::root() ?>','compare<?php echo $id;?>','theme3','listing')" href="javascript:void(0)" title="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST');?>">
								<img title="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>" alt="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/compare24_gray.png" width="16"/>
							</a>
                            <?php
                            break;
                    }
                    break;
            }
        }
    }
    public static function addCompare($id){
        global $jinput;
        $session = JFactory::getSession();
        $comparelist = $session->get('comparelist');
        $comparelistArr = explode(",", $comparelist);

        if (in_array($id, $comparelistArr)) {
            ?>
            <table jos_ class="nTable">
                <tbody>
                <tr>
                    <td class="n_corner_top_left"></td>
                    <td class="n_corner_top_center"></td>
                    <td class="n_corner_top_right"></td>
                </tr>
                <tr>
                    <td class="n_middle_left"></td>
                    <td class="n_middle_center">
                        <div
                            id="notice_message"><?php echo JText::_('OS_THE_PROPERTY_HAS_BEEN_ADDED_TO_COMPARE')?>
                            <b><a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=compare_list')?>"
                                  class="static"><?php echo JText::_('OS_HERE')?></a></b> <?php echo JText::_('OS_TO_VIEW_THE_COMPARISON')?>
                        </div>
                    </td>
                    <td class="n_middle_right"></td>
                </tr>
                <tr>
                    <td class="n_corner_bottom_left"></td>
                    <td class="n_corner_bottom_center"></td>
                    <td class="n_corner_bottom_right"></td>
                </tr>
                </tbody>
            </table>
        <?php
        } else {
            if ($comparelist == "") {
                $comparelist = $id;
            } else {
                $comparelist .= "," . $id;
            }
            $session->set('comparelist', $comparelist);
            ?>
            <table jos_ class="nTable">
                <tbody>
                <tr>
                    <td class="n_corner_top_left"></td>
                    <td class="n_corner_top_center"></td>
                    <td class="n_corner_top_right"></td>
                </tr>
                <tr>
                    <td class="n_middle_left"></td>
                    <td class="n_middle_center">
                        <div
                            id="notice_message"><?php echo JText::_('OS_LISTING_HAS_BEEN_ADDED_TO_COMPARE_LIST') ?>
                            <b><a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=compare_list') ?>"
                                  class="static"><?php echo JText::_('OS_HERE') ?></a></b> <?php echo JText::_('OS_TO_VIEW_THE_COMPARISON') ?>
                        </div>
                    </td>
                    <td class="n_middle_right"></td>
                </tr>
                <tr>
                    <td class="n_corner_bottom_left"></td>
                    <td class="n_corner_bottom_center"></td>
                    <td class="n_corner_bottom_right"></td>
                </tr>
                </tbody>
            </table>
        <?php
        }

        echo "@@@";
        $theme = $jinput->getString('theme','');
        $layout = $jinput->getString('layout','');
        if($theme != ""){
            $msg = JText::_('OS_DO_YOU_WANT_TO_REMOVE_PROPERTY_OUT_OF_COMPARE_LIST');
            $msg = str_replace("'", "\'", $msg);
            switch($theme){
                case "default":
                    switch($layout) {
                        case "details":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;
                            ?>','ajax_addCompare','<?php echo $id?>','<?php echo JURI::root()?>','compare<?php echo $id?>','theme1','details')"
                               href="javascript:void(0)">
                                <?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>
                            </a>
                            <?php
                            break;
                        case "listing_list":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>','ajax_removeCompare','<?php echo $id ?>','<?php echo JURI::root() ?>','compare<?php echo $id;?>','default','listing_list')" href="javascript:void(0)" title="<?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST');?>">
                                <img class="png" title="<?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST')?>" alt="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/compare24.png" />
                            </a>
                            <?php
                            break;
                        case "listing_grid":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>','ajax_removeCompare','<?php echo $id ?>','<?php echo JURI::root() ?>','compare<?php echo $id;?>','default','listing_grid')" href="javascript:void(0)" class="btn btn-small" title="<?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST');?>">
                                <img title="<?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST')?>" alt="<?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST')?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/compare24.png" width="16" style="width:16px;"/>
                            </a>
                            <?php
                            break;
                    }
                    break;
                case "theme1":
                    switch($layout) {
                        case "details":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_removeCompare','<?php echo $id?>','<?php echo JURI::root()?>','compare<?php echo $id?>','theme1','details')"
                               href="javascript:void(0)">
                                <?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST')?>
                            </a>
                            <?php
                        break;
                        case "listing":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>','ajax_removeCompare','<?php echo $id ?>','<?php echo JURI::root() ?>','compare<?php echo $id;?>','theme1','listing')"
                               href="javascript:void(0)"
                               class="btn btn-warning btn-small">
                                <i class="osicon-bookmark osicon-white"></i> <?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST'); ?>
                            </a>
                            <?php
                        break;
                    }
                break;
				case "theme2":
                    switch($layout) {
                        case "details":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>','ajax_removeCompare','<?php echo $id ?>','<?php echo JURI::root() ?>','compare<?php echo $id;?>','theme2','details')" href="javascript:void(0)" class="compare has icon s_16">
							<?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST')?>
							</a>
                            <?php
                            break;
                    }
                    break;
				case "theme3":
                    switch($layout) {
                        case "listing":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>','ajax_removeCompare','<?php echo $id ?>','<?php echo JURI::root() ?>','compare<?php echo $id;?>','theme3','listing')" href="javascript:void(0)" title="<?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST');?>">
								<img title="<?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST')?>" alt="<?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST')?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/compare24.png" width="16"/>
							</a>
                            <?php
                            break;
                    }
                    break;
            }
        }
    }

    /**
     * Add Favorite
     */
    public static function addFavorites($id){
        global $jinput, $mainframe;
        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        $db->setQuery("Select count(id) from #__osrs_favorites where user_id = '$user->id' and pro_id = '$id'");
        $count = $db->loadResult();
        if ($count > 0) {
            ?>
            <table jos_ class="nTable">
                <tbody>
                <tr>
                    <td class="n_corner_top_left"></td>
                    <td class="n_corner_top_center"></td>
                    <td class="n_corner_top_right"></td>
                </tr>
                <tr>
                    <td class="n_middle_left"></td>
                    <td class="n_middle_center">
                        <div id="notice_message"><?php echo JText::_('OS_ALREADY_ADD_FAVORITES_CLICK')?> <b><a
                                    href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_favorites')?>"
                                    class="static"><?php echo JText::_('OS_HERE')?></a></b> <?php echo JText::_('OS_TO_VIEW_FAVORITES_RESULTS')?>
                        </div>
                    </td>
                    <td class="n_middle_right"></td>
                </tr>
                <tr>
                    <td class="n_corner_bottom_left"></td>
                    <td class="n_corner_bottom_center"></td>
                    <td class="n_corner_bottom_right"></td>
                </tr>
                </tbody>
            </table>
        <?php
        } else {
            $db->setQuery("INSERT INTO #__osrs_favorites (id,user_id,pro_id) VALUES (NULL,'$user->id','$id')");
            $db->query();
            ?>
            <table jos_ class="nTable">
                <tbody>
                <tr>
                    <td class="n_corner_top_left"></td>
                    <td class="n_corner_top_center"></td>
                    <td class="n_corner_top_right"></td>
                </tr>
                <tr>
                    <td class="n_middle_left"></td>
                    <td class="n_middle_center">
                        <div id="notice_message"><?php echo JText::_('OS_ALREADY_ADD_FAVORITES_CLICK')?> <strong><a
                                    href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_favorites')?>"
                                    class="static"><?php echo JText::_('OS_HERE')?></a></strong> <?php echo JText::_('OS_TO_VIEW_FAVORITES_RESULTS')?>
                        </div>
                    </td>
                    <td class="n_middle_right"></td>
                </tr>
                <tr>
                    <td class="n_corner_bottom_left"></td>
                    <td class="n_corner_bottom_center"></td>
                    <td class="n_corner_bottom_right"></td>
                </tr>
                </tbody>
            </table>
        <?php
        }

        echo "@@@";
        $theme = $jinput->getString('theme','');
        $layout = $jinput->getString('layout','');
        if($theme != ""){
            $msg = JText::_('OS_DO_YOU_WANT_TO_REMOVE_PROPERTY_OUT_OF_YOUR_FAVORITE_LISTS');
            $msg = str_replace("'", "\'", $msg);
            switch($theme){
                case "default":
                    switch($layout) {
                        case "details":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;
                            ?>','ajax_addCompare','<?php echo $id?>','<?php echo JURI::root()?>','compare<?php echo $id?>','theme1','details')"
                               href="javascript:void(0)">
                                <?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>
                            </a>
                            <?php
                            break;
                        case "listing_list":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_removeFavorites','<?php echo $id?>','<?php echo JURI::root()?>','fav<?php echo $id; ?>','theme1','listing_list')" href="javascript:void(0)" title="<?php echo JText::_('OS_REMOVE_FAVORITES');?>">
                                <img title="<?php echo JText::_('OS_REMOVE_PROPERTY_OUT_OF_FAVORITES_LIST')?>" alt="<?php echo JText::_('OS_REMOVE_PROPERTY_OUT_OF_FAVORITES_LIST')?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/save24.png" />
                            </a>
                            <?php
                            break;
                        case "listing_grid":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_removeFavorites','<?php echo $id?>','<?php echo JURI::root()?>','fav<?php echo $id; ?>','default','listing_grid')" href="javascript:void(0)" class="btn btn-small" title="<?php echo JText::_('OS_REMOVE_PROPERTY_OUT_OF_FAVORITES_LIST');?>">
                                <img title="<?php echo JText::_('OS_REMOVE_PROPERTY_OUT_OF_FAVORITES_LIST')?>" alt="<?php echo JText::_('OS_REMOVE_PROPERTY_OUT_OF_FAVORITES_LIST')?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/save24.png" width="16" style="width:16px;"/>
                            </a>
                            <?php
                            break;
                    }
                    break;
                case "theme1":
                    switch($layout) {
                        case "details":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_removeFavorites','<?php echo $id?>','<?php echo JURI::root()?>','fav<?php echo $id; ?>','theme1','details')"
                               href="javascript:void(0)" class="_saveListingLink save has icon s_16">
                                <?php echo JText::_('OS_REMOVE_FAVORITES');?>
                            </a>
                            <?php
                        break;
                        case "listing":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_removeFavorites','<?php echo $id?>','<?php echo JURI::root()?>','fav<?php echo $id; ?>','theme1','listing')" href="javascript:void(0)" class="btn btn-success btn-small">
                                <i class="osicon-remove osicon-white"></i> <?php echo JText::_('OS_REMOVE_FAVORITES');?>
                            </a>
                            <?php
                        break;
                    }
                break;
				case "theme2":
                    switch($layout) {
                        case "details":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_removeFavorites','<?php echo $id?>','<?php echo JURI::root()?>','fav<?php echo $id; ?>','theme2','details')" href="javascript:void(0)" class="_saveListingLink save has icon s_16">
								<?php echo JText::_('OS_REMOVE_FAVORITES');?>
							</a>
                            <?php
                            break;
                    }
                    break;
				case "theme3":
                    switch($layout) {
                        case "listing":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_removeFavorites','<?php echo $id?>','<?php echo JURI::root()?>','fav<?php echo $id; ?>','theme3','listing')" href="javascript:void(0)" title="<?php echo JText::_('OS_REMOVE_PROPERTY_OUT_OF_FAVORITES_LIST');?>">
								<img title="<?php echo JText::_('OS_REMOVE_PROPERTY_OUT_OF_FAVORITES_LIST')?>" alt="<?php echo JText::_('OS_REMOVE_PROPERTY_OUT_OF_FAVORITES_LIST')?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/save24.png" width="16"/>
							</a>
                            <?php
                            break;
                    }
                    break;
            }
        }
    }

    /**
     * Remove Favorites
     * @param $id
     */
    public static function removeFavorites($id){
        global $jinput;
        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        $db->setQuery("Delete from #__osrs_favorites where user_id = '$user->id' and pro_id = '$id'");
        $db->query();
        ?>
        <table jos_ class="nTable">
            <tbody>
            <tr>
                <td class="n_corner_top_left"></td>
                <td class="n_corner_top_center"></td>
                <td class="n_corner_top_right"></td>
            </tr>
            <tr>
                <td class="n_middle_left"></td>
                <td class="n_middle_center">
                    <div id="notice_message"><?php echo JText::_('OS_ADDED_TO_FAVORITES')?></div>
                </td>
                <td class="n_middle_right"></td>
            </tr>
            <tr>
                <td class="n_corner_bottom_left"></td>
                <td class="n_corner_bottom_center"></td>
                <td class="n_corner_bottom_right"></td>
            </tr>
            </tbody>
        </table>
        <?php

        echo "@@@";
        $theme = $jinput->getString('theme','');
        $layout = $jinput->getString('layout','');
        if($theme != ""){
            $msg = JText::_('OS_DO_YOU_WANT_TO_REMOVE_PROPERTY_OUT_OF_YOUR_FAVORITE_LISTS');
            $msg = str_replace("'", "\'", $msg);
            switch($theme){
                case "default":
                    switch($layout) {
                        case "details":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;
                            ?>','ajax_addCompare','<?php echo $id?>','<?php echo JURI::root()?>','compare<?php echo $id?>','theme1','details')"
                               href="javascript:void(0)">
                                <?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>
                            </a>
                            <?php
                            break;
                        case "listing_list":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_addFavorites','<?php echo $id?>','<?php echo JURI::root()?>','fav<?php echo $id; ?>','theme1','listing_list')" href="javascript:void(0)" title="<?php echo JText::_('OS_REMOVE_FAVORITES');?>">
                                <img title="<?php echo JText::_('OS_ADD_TO_FAVORITES')?>" alt="<?php echo JText::_('OS_ADD_TO_FAVORITES')?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/save24_gray.png" />
                            </a>
                            <?php
                            break;
                        case "listing_grid":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_addFavorites','<?php echo $id?>','<?php echo JURI::root()?>','fav<?php echo $id; ?>','default','listing_grid')" href="javascript:void(0)" class="btn btn-small" title="<?php echo JText::_('OS_ADD_TO_FAVORITES');?>">
                                <img title="<?php echo JText::_('OS_ADD_TO_FAVORITES')?>" alt="<?php echo JText::_('OS_ADD_TO_FAVORITES')?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/save24_gray.png" width="16"/>
                            </a>
                            <?php
                            break;
                    }
                    break;
                case "theme1":

                    switch($layout) {
                        case "details": ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_addFavorites','<?php echo $id?>','<?php echo JURI::root()?>','fav<?php echo $id; ?>','theme1','details')"
                               href="javascript:void(0)" class="_saveListingLink save has icon s_16">
                                <?php echo JText::_('OS_ADD_TO_FAVORITES');?>
                            </a>
                            <?php
                        break;
                        case "listing":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_addFavorites','<?php echo $id?>','<?php echo JURI::root()?>','fav<?php echo $id; ?>','theme1','listing')" href="javascript:void(0)" class="btn btn-success btn-small">
                                <i class="osicon-ok osicon-white"></i> <?php echo JText::_('OS_ADD_TO_FAVORITES');?>
                            </a>
                            <?php
                        break;
                    }
                break;
				case "theme2":
                    switch($layout) {
                        case "details":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_addFavorites','<?php echo $id?>','<?php echo JURI::root()?>','fav<?php echo $id; ?>','theme2','details')" class="_saveListingLink save has icon s_16">
								<?php echo JText::_('OS_ADD_TO_FAVORITES');?>
							</a>
                            <?php
                            break;
                    }
                    break;
				case "theme3":
                    switch($layout) {
                        case "listing":
                            ?>
                            <a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_addFavorites','<?php echo $id?>','<?php echo JURI::root()?>','fav<?php echo $id; ?>','theme3','listing')" href="javascript:void(0)" title="<?php echo JText::_('OS_ADD_TO_FAVORITES');?>">
								<img title="<?php echo JText::_('OS_ADD_TO_FAVORITES')?>" alt="<?php echo JText::_('OS_ADD_TO_FAVORITES')?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/save24_gray.png" width="16"/>
							</a>
                            <?php
                            break;
                    }
                    break;
            }
        }
    }

    static function loadLocationInformation()
    {
        $langArr = array();
        $db = JFactory::getDbo();
        $langArr[0]->country_id = 12;
        $langArr[0]->file_name = "au_australia.txt";

        $langArr[1]->country_id = 28;
        $langArr[1]->file_name = "br_brazil.txt";

        $langArr[2]->country_id = 35;
        $langArr[2]->file_name = "ca_canada.txt";

        $langArr[3]->country_id = 169;
        $langArr[3]->file_name = "es_spain.txt";

        $langArr[4]->country_id = 66;
        $langArr[4]->file_name = "fr_france.txt";

        $langArr[5]->country_id = 193;
        $langArr[5]->file_name = "gb_united.txt";

        $langArr[6]->country_id = 86;
        $langArr[6]->file_name = "in_india.txt";

        $langArr[7]->country_id = 92;
        $langArr[7]->file_name = "it_italy.txt";

        $langArr[8]->country_id = 130;
        $langArr[8]->file_name = "nl_netherlands.txt";

        $langArr[9]->country_id = 147;
        $langArr[9]->file_name = "pt_portugal.txt";

        $langArr[10]->country_id = 187;
        $langArr[10]->file_name = "tr_turkey.txt";

        $langArr[11]->country_id = 152;
        $langArr[11]->file_name = "ru_russia.txt";

        $langArr[12]->country_id = 162;
        $langArr[12]->file_name = "sg_singapore.txt";

        $langArr[13]->country_id = 175;
        $langArr[13]->file_name = "se_sweden.txt";

        $langArr[14]->country_id = 71;
        $langArr[14]->file_name = "de_germany.txt";

        $langArr[15]->country_id = 9;
        $langArr[15]->file_name = "ar_argentina.txt";

        $langArr[16]->country_id = 13;
        $langArr[16]->file_name = "at_austria.txt";

        $langArr[17]->country_id = 18;
        $langArr[17]->file_name = "bb_barbados.txt";

        $langArr[18]->country_id = 20;
        $langArr[18]->file_name = "be_belgium.txt";

        $langArr[19]->country_id = 15;
        $langArr[19]->file_name = "bs_bahamas.txt";

        $langArr[20]->country_id = 51;
        $langArr[20]->file_name = "dk_denmark.txt";

        $langArr[21]->country_id = 65;
        $langArr[21]->file_name = "fi_finland.txt";

        $langArr[22]->country_id = 73;
        $langArr[22]->file_name = "gr_greece.txt";

        $langArr[23]->country_id = 90;
        $langArr[23]->file_name = "ie_ireland.txt";

        $langArr[24]->country_id = 120;
        $langArr[24]->file_name = "mx_mexico.txt";

        $langArr[25]->country_id = 136;
        $langArr[25]->file_name = "no_norway.txt";

        $langArr[26]->country_id = 167;
        $langArr[26]->file_name = "za_southafrica.txt";

        $langArr[27]->country_id = 87;
        $langArr[27]->file_name = "id_indonesia.txt";

        $langArr[28]->country_id = 39;
        $langArr[28]->file_name = "cl_chile.txt";

        $langArr[29]->country_id = 47;
        $langArr[29]->file_name = "hr_croatia.txt";

        $langArr[30]->country_id = 55;
        $langArr[30]->file_name = "ec_ecuador.txt";

        $langArr[31]->country_id = 114;
        $langArr[31]->file_name = "my_malaysia.txt";

        $langArr[32]->country_id = 138;
        $langArr[32]->file_name = "pk_pakistan.txt";

        $langArr[33]->country_id = 144;
        $langArr[33]->file_name = "pe_peru.txt";

        $langArr[34]->country_id = 176;
        $langArr[34]->file_name = "ch_switzerland.txt";

        $langArr[35]->country_id = 181;
        $langArr[35]->file_name = "th_thailand.txt";

        $langArr[36]->country_id = 195;
        $langArr[36]->file_name = "uy_uruguay.txt";


        $langArr[37]->country_id = 91;
        $langArr[37]->file_name = "il_israel.txt";

        $langArr[38]->country_id = 149;
        $langArr[38]->file_name = "qa_qatar.txt";


        $langArr[39]->country_id = 151;
        $langArr[39]->file_name = "ro_romania.txt";

        $langArr[40]->country_id = 110;
        $langArr[40]->file_name = "lu_luxembourg.txt";

        $langArr[41]->country_id = 41;
        $langArr[41]->file_name = "co_colombia.txt";

        $langArr[42]->country_id = 145;
        $langArr[42]->file_name = "ph_philippines.txt";

        $langArr[43]->country_id = 3;
        $langArr[43]->file_name = "al_albania.txt";

        $langArr[44]->country_id = 5;
        $langArr[44]->file_name = "ad_andorra.txt";

        $langArr[45]->country_id = 77;
        $langArr[45]->file_name = "gt_guatemala.txt";

        $langArr[46]->country_id = 45;
        $langArr[46]->file_name = "cr_costarica.txt";

        $langArr[47]->country_id = 82;
        $langArr[47]->file_name = "hn_honduras.txt";

        $langArr[48]->country_id = 93;
        $langArr[48]->file_name = "jm_jamaica.txt";

        $langArr[49]->country_id = 25;
        $langArr[49]->file_name = "bo_bolivia.txt";

        $langArr[50]->country_id = 135;
        $langArr[50]->file_name = "ng_nigeria.txt";

        $langArr[51]->country_id = 146;
        $langArr[51]->file_name = "pl_poland.txt";

        $langArr[52]->country_id = 50;
        $langArr[52]->file_name = "cz_czech.txt";

        $langArr[53]->country_id = 206;
        $langArr[53]->file_name = "mv_maldives.txt";

        $langArr[54]->country_id = 163;
        $langArr[54]->file_name = "sk_slovakia.txt";

        $langArr[55]->country_id = 170;
        $langArr[55]->file_name = "sk_srilanka.txt";

        $langArr[56]->country_id = 192;
        $langArr[56]->file_name = "ae_uae.txt";

        $langArr[57]->country_id = 125;
        $langArr[57]->file_name = "mo_morocco.txt";

        $langArr[58]->country_id = 132;
        $langArr[58]->file_name = "nz_newzealand.txt";

        $langArr[59]->country_id = 198;
        $langArr[59]->file_name = "ve_venezuela.txt";

        $langArr[60]->country_id = 84;
        $langArr[60]->file_name = "hu_hungary.txt";

		$langArr[61]->country_id = 54;
		$langArr[61]->file_name = "do_dominican.txt";

		$langArr[62]->country_id = 185;
		$langArr[62]->file_name = "tt_trinidad.txt";

		$langArr[63]->country_id = 97;
		$langArr[63]->file_name = "ke_kenya.txt";

		$langArr[64]->country_id = 56;
		$langArr[64]->file_name = "eg_egypt.txt";

        $langArr[65]->country_id = 191;
        $langArr[65]->file_name = "uk_ukraine.txt";

		$langArr[66]->country_id = 207;
		$langArr[66]->file_name = "sl_scotland.txt";

		$langArr[67]->country_id = 208;
		$langArr[67]->file_name = "nr_northern_ireland.txt";

		$langArr[68]->country_id = 209;
		$langArr[68]->file_name = "wa_wales.txt";

		$langArr[69]->country_id = 116;
		$langArr[69]->file_name = "mt_malta.txt";

		$langArr[70]->country_id = 4;
		$langArr[70]->file_name = "dz_algeria.txt";

		$langArr[71]->country_id = 30;
		$langArr[71]->file_name = "bg_bulgaria.txt";

		$langArr[72]->country_id = 49;
		$langArr[72]->file_name = "cy_cyprus.txt";

        $countryArr = array();
        for ($i = 0; $i < count($langArr); $i++) {
            $countryArr[] = $langArr[$i]->country_id;
        }
        $countrySql = implode(",", $countryArr);

        $db->setQuery("Select * from #__osrs_countries where id in ($countrySql)");
        $countries = $db->loadObjectList();

        ?>
        <table width="100%" class="table table-striped">
            <thead>
            <tr>
                <th width="5%" style="text-align:center;">
                    <?php echo JText::_('OS_COUNTRY')?>
                </th>
                <th width="20%" style="text-align:center;">
                    <?php echo JText::_('OS_COUNTRY')?>
                </th>
                <th width="15%" style="text-align:center;">
                    <?php echo JText::_('OS_STATE')?>
                </th>
                <th width="20%" style="text-align:center;">
                    <?php echo JText::_('OS_CITY')?>
                </th>
                <th width="20%" style="text-align:center;">
                    <?php echo JText::_('OS_UPDATE_LOCATION')?>
                </th>
                <th width="10%" style="text-align:center;">
                    Enable
                </th>
                <th width="10%" style="text-align:center;">
                    Disable
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            for ($i = 0; $i < count($countries); $i++) {
                $country = $countries[$i];
                $db->setQuery("Select count(id) from #__osrs_states where country_id = '$country->id'");
                $nStates = $db->loadResult();

                $db->setQuery("Select count(id) from #__osrs_states where country_id = '$country->id' and published = '1'");
                $pStates = $db->loadResult();

                $db->setQuery("Select count(id) from #__osrs_states where country_id = '$country->id' and published = '0'");
                $uStates = $db->loadResult();

                $db->setQuery("Select count(id) from #__osrs_cities where country_id = '$country->id'");
                $nCities = $db->loadResult();

                $db->setQuery("Select count(id) from #__osrs_cities where country_id = '$country->id' and published = '1'");
                $pCities = $db->loadResult();

                $db->setQuery("Select count(id) from #__osrs_cities where country_id = '$country->id' and published = '0'");
                $uCities = $db->loadResult();
                ?>
                <tr>
                    <td align="center" style="padding:1px;">
                        <?php
                        for ($j = 0; $j < count($langArr); $j++) {
                            if ($langArr[$j]->country_id == $country->id) {
                                $flag_name = $langArr[$j]->file_name;
                                $flag_name = str_replace(".txt", "", $flag_name);
                                $flag_name = explode("_", $flag_name);
                                $flag_code = $flag_name[0];
                                $flag_name = $flag_name[1];
                                $flag_name = "flag_" . $flag_name . ".png";
                                if (file_exists(JPATH_COMPONENT_ADMINISTRATOR . '/images/flag/' . $flag_name)) {
                                    ?>
                                    <img
                                        src="<?php echo JURI::base()?>administrator/components/com_osproperty/images/flag/<?php echo $flag_name?>"
                                        width="28">
                                <?php
                                } else {
                                    ?>
                                    <img
                                        src="<?php echo JURI::root()?>media/com_osproperty/flags/<?php echo $flag_code?>.png"
                                        width="28">
                                <?php
                                }
                            }
                        }
                        ?>
                    </td>
                    <td align="left" style="padding:5px;">
                        <?php echo $country->country_name;?>
                    </td>
                    <td align="center" style="padding:5px;">
                        <b><?php echo $nStates;?></b>
                        (<font color='Green'><?php echo $pStates?></font>/<font color='Red'><?php echo $uStates?></font>)
                    </td>
                    <td align="center" style="padding:5px;">
                        <b><?php echo $nCities;?></b>
                        (<font color='Green'><?php echo $pCities?></font>/<font color='Red'><?php echo $uCities?></font>)
                    </td>
                    <td align="center" style="padding:5px;">
                        <a href="index.php?option=com_osproperty&task=properties_updatelocation&country_id=<?php echo $country->id?>"
                           title="<?php echo JText::_('OS_INSERT_LOCATION_DATABASE_FOR')?> <?php echo $country->country_name?>">
                            <?php echo JText::_('OS_UPDATE_LOCATION')?>
                        </a>
                    </td>
                    <td align="center" style="padding:5px;">
                        <a href="index.php?option=com_osproperty&task=properties_changeLocation&s=1&country_id=<?php echo $country->id?>"
                           title="Enable location for <?php echo $country->country_name;?>">
                            <img src="<?php echo JURI::root()?>components/com_osproperty/images/assets/tick.png"
                                 border="0">
                        </a>
                    </td>
                    <td align="center" style="padding:5px;">
                        <a href="index.php?option=com_osproperty&task=properties_changeLocation&s=0&country_id=<?php echo $country->id?>"
                           title="Disable location for <?php echo $country->country_name;?>">
                            <img src="<?php echo JURI::root()?>components/com_osproperty/images/assets/publish_x.png"
                                 border="0">
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        <?php
		echo "@@@";
		self::checkingVersion();
        exit();
    }

    static function loadStateCityLocatorModule($option, $country_name, $country_id, $state_id, $city_id, $state_name, $random_id)
    {
        global $jinput, $mainframe, $configClass;

        @header('Content-Type: text/html; charset=utf-8');
        $db = JFactory::getDbo();
        $availSql = "";
        $show_available_states_cities = $configClass['show_available_states_cities'];
        $option_state = array();
        $option_state[] = JHTML::_('select.option', 0, JText::_('OS_ALL_STATES'));
        if ($country_id > 0) {
            if ($show_available_states_cities == 1) {
                $availSql = " and id in (Select state from #__osrs_properties where approved = '1' and published = '1')";
            }
            $db->setQuery("SELECT id AS value, state_name AS text FROM #__osrs_states WHERE published = '1' $availSql and `country_id` = '$country_id' ORDER BY state_name");
            $states = $db->loadObjectList();
            if (count($states)) {
                $option_state = array_merge($option_state, $states);
            }
            $disable = '';
        } else {
            $disable = 'disabled="disabled"';
        }
        $random_id = ($random_id > 0 ? $random_id : '');
        echo JHTML::_('select.genericlist', $option_state, 'mstate_id' . $random_id, 'onChange="javascript:change_stateModule' . $random_id . '(this.value,' . $city_id . ',\'' . $random_id . '\')" class="input-medium" ' . $disable, 'value', 'text', $state_id);
        echo "@@@";
        $availSql = "";
        if ($show_available_states_cities == 1) {
            $availSql = " and id in (Select state from #__osrs_properties where approved = '1' and published = '1')";
        }
        //check to see if the state is belong to this country
        $db->setQuery("Select count(id) from #__osrs_states where published = '1' and country_id = '$country_id' $availSql and id = '$state_id'");
        $count = $db->loadResult();
        $availSql = "";
        if ($count > 0) {
            $cityArr = array();
            $cityArr[] = JHTML::_('select.option', '', ' - ' . JText::_('OS_ALL_CITIES') . ' - ');
            if ($show_available_states_cities == 1) {
                $availSql = " and id in (Select city from #__osrs_properties where approved = '1' and published = '1')";
            }
            $db->setQuery("Select id as value, city as text from #__osrs_cities where published = '1' $availSql and state_id = '$state_id' order by city");
            $cities = $db->loadObjectList();
            $cityArr = array_merge($cityArr, $cities);
            echo JHTML::_('select.genericlist', $cityArr, 'city' . $random_id, 'class="input-medium" ', 'value', 'text', $city_id);
        } else {
            $option_state = array();
            $option_state[] = JHTML::_('select.option', '', JText::_('OS_ALL_CITIES'));
            echo JHTML::_('select.genericlist', $option_state, 'city' . $random_id, 'class="input-medium" disabled', 'value', 'text');
        }

        if ($random_id != "") {
            ?>
            |*|<?php echo $random_id?>
        <?php
        }
        exit;
    }

    static function loadStateCityLocator($option, $country_name, $country_id, $state_id, $city_id, $state_name, $class = "input-medium")
    {
        global $jinput, $mainframe, $configClass;
        @header('Content-Type: text/html; charset=utf-8');
        $db = JFactory::getDBO();
        $availSql = "";
        $show_available_states_cities = $configClass['show_available_states_cities'];
        $option_state = array();
        $option_state[] = JHTML::_('select.option', 0, ' - ' . JText::_('OS_ALL_STATES') . ' - ');
        if ($country_id > 0) {
            if ($show_available_states_cities == 1) {
                $availSql = " and id in (Select state from #__osrs_properties where approved = '1' and published = '1')";
            }
            $db->setQuery("SELECT id AS value, state_name AS text FROM #__osrs_states WHERE published = '1' and `country_id` = '$country_id' $availSql ORDER BY state_name");
            $states = $db->loadObjectList();
            if (count($states)) {
                $option_state = array_merge($option_state, $states);
            }
            $disable = '';
        } else {
            $disable = 'disabled="disabled"';
        }

        echo JHTML::_('select.genericlist', $option_state, $state_name, 'onChange="javascript:change_state(this.value,\'' . $city_id . '\')" class="' . $class . '" ' . $disable, 'value', 'text', $state_id);
        echo "@@@";
        $availSql = "";
        if ($show_available_states_cities == 1) {
            $availSql = " and id in (Select state from #__osrs_properties where approved = '1' and published = '1')";
        }
        //check to see if the state is belong to this country
        $db->setQuery("Select count(id) from #__osrs_states where published = '1' and country_id = '$country_id' and id = '$state_id' $availSql");
        $count = $db->loadResult();
        if ($count > 0) {
            $availSql = "";
            if ($show_available_states_cities == 1) {
                $availSql = " and id in (Select city from #__osrs_properties where approved = '1' and published = '1')";
            }
            $cityArr = array();
            $cityArr[] = JHTML::_('select.option', 0, JText::_('OS_ALL_CITIES'));
            $db->setQuery("Select id as value, city as text from #__osrs_cities where published = '1' and state_id = '$state_id' $availSql order by city");
            $cities = $db->loadObjectList();
            $cityArr = array_merge($cityArr, $cities);
            echo JHTML::_('select.genericlist', $cityArr, 'city', 'class="' . $class . '" ' , 'value', 'text', $city_id);
        } else {
            $option_state = array();
            $option_state[] = JHTML::_('select.option', 0, JText::_('OS_ALL_CITIES'));
            echo JHTML::_('select.genericlist', $option_state, 'city', 'class="' . $class . '" disabled', 'value', 'text');
        }
        exit;
    }


    /**
     * Load State and City
     *
     * @param unknown_type $option
     */
    static function loadStateCityBackend($option, $country_name, $country_id, $state_id, $city_id, $state_name)
    {
        global $jinput, $mainframe;
        @header('Content-Type: text/html; charset=utf-8');
        $db = JFactory::getDBO();

        $lgs = OSPHelper::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        $suffix = "";
        if ($translatable) {
            $suffix = OSPHelper::getFieldSuffix();
        }

        $option_state = array();
        $option_state[] = JHTML::_('select.option', 0, ' - ' . JText::_('OS_SELECT_STATE') . ' - ');
        if ($country_id) {
            $db->setQuery("SELECT id AS value, state_name" . $suffix . " AS text FROM #__osrs_states WHERE published = '1' and  `country_id` = '$country_id' ORDER BY state_name");
            $states = $db->loadObjectList();
            if (count($states)) {
                $option_state = array_merge($option_state, $states);
            }
            $disable = '';
        } else {
            $disable = 'disabled="disabled"';
        }

        echo JHTML::_('select.genericlist', $option_state, $state_name, 'onChange="javascript:loadCityBackend(this.value,\'' . $city_id . '\')" class="input-medium chosen" ' . $disable, 'value', 'text', $state_id);
        echo "@@@";

        //check to see if the state is belong to this country
        $db->setQuery("Select count(id) from #__osrs_states where published = '1' and  country_id = '$country_id' and id = '$state_id'");
        $count = $db->loadResult();
        if ($count > 0) {
            $cityArr = array();
            $cityArr[] = JHTML::_('select.option', '', JText::_('OS_ALL_CITIES'));
            $db->setQuery("Select id as value, city" . $suffix . " as text from #__osrs_cities where published = '1' and state_id = '$state_id' order by city");
            $cities = $db->loadObjectList();
            $cityArr = array_merge($cityArr, $cities);
            echo JHTML::_('select.genericlist', $cityArr, 'city' , 'class="input-medium chosen" ', 'value', 'text', $city_id);
        } else {
            $option_state = array();
            $option_state[] = JHTML::_('select.option', '', JText::_('OS_ALL_CITIES'));
            echo JHTML::_('select.genericlist', $option_state, 'city' , 'class="input-medium chosen" disabled', 'value', 'text');
        }
        exit;
    }
    /**
     * Load State and City
     *
     * @param unknown_type $option
     */
    static function loadStateCity($option, $country_name, $country_id, $state_id, $city_id, $state_name)
    {
        global $jinput, $mainframe;
        @header('Content-Type: text/html; charset=utf-8');
        $db = JFactory::getDBO();

        $lgs = OSPHelper::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        $suffix = "";
        if ($translatable) {
            $suffix = OSPHelper::getFieldSuffix();
        }

        $option_state = array();
        $option_state[] = JHTML::_('select.option', 0, ' - ' . JText::_('OS_SELECT_STATE') . ' - ');
        if ($country_id) {
            $db->setQuery("SELECT id AS value, state_name" . $suffix . " AS text FROM #__osrs_states WHERE published = '1' and  `country_id` = '$country_id' ORDER BY state_name");
            $states = $db->loadObjectList();
            if (count($states)) {
                $option_state = array_merge($option_state, $states);
            }
            $disable = '';
        } else {
            $disable = 'disabled="disabled"';
        }

        echo JHTML::_('select.genericlist', $option_state, $state_name, 'onChange="javascript:loadCity(this.value,\'' . $city_id . '\')" class="input-medium" ' . $disable, 'value', 'text', $state_id);
        echo "@@@";

        //check to see if the state is belong to this country
        $db->setQuery("Select count(id) from #__osrs_states where published = '1' and  country_id = '$country_id' and id = '$state_id'");
        $count = $db->loadResult();
        if ($count > 0) {
            $cityArr = array();
            $cityArr[] = JHTML::_('select.option', '', JText::_('OS_ALL_CITIES'));
            $db->setQuery("Select id as value, city" . $suffix . " as text from #__osrs_cities where published = '1' and state_id = '$state_id' order by city");
            $cities = $db->loadObjectList();
            $cityArr = array_merge($cityArr, $cities);
            echo JHTML::_('select.genericlist', $cityArr, 'city' , 'class="input-medium" ' , 'value', 'text', $city_id);
        } else {
            $option_state = array();
            $option_state[] = JHTML::_('select.option', '', JText::_('OS_ALL_CITIES'));
            echo JHTML::_('select.genericlist', $option_state, 'city', 'class="input-medium" disabled', 'value', 'text');
        }
        exit;
    }

    /**
     * Load City
     *
     * @param unknown_type $option
     * @param unknown_type $state_id
     * @param unknown_type $city_id
     * @param unknown_type $state_name
     */
    public static function loadCity($option, $state_id, $city_id, $state_name, $useConfig, $class = "input-medium", $city_name = "city")
    {
        global $jinput, $mainframe, $configClass;
        $db = JFactory::getDBO();

        $lgs = OSPHelper::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        $suffix = "";
        if ($translatable) {
            $suffix = OSPHelper::getFieldSuffix();
        }

        @header('Content-Type: text/html; charset=utf-8');
        $availSql = "";
        $show_available_states_cities = $configClass['show_available_states_cities'];
        if ($state_id > 0) {
            $availSql = "";
            if (($show_available_states_cities == 1) and ($useConfig == 1)) {
                $availSql = " and id in (Select city from #__osrs_properties where approved = '1' and published = '1')";
            }
            $cityArr = array();
            $cityArr[] = JHTML::_('select.option', '', JText::_('OS_ALL_CITIES'));
            $db->setQuery("Select id as value, city" . $suffix . " as text from #__osrs_cities where published = '1' and state_id = '$state_id' $availSql order by city");
            $cities = $db->loadObjectList();
            $cityArr = array_merge($cityArr, $cities);
            echo JHTML::_('select.genericlist', $cityArr, $city_name, 'class="' . $class . '" ' . $disabled, 'value', 'text', $city_id);
        } else {
            $cityArr = array();
            $cityArr[] = JHTML::_('select.option', '', JText::_('OS_ALL_CITIES'));
            echo JHTML::_('select.genericlist', $cityArr, $city_name, 'class="' . $class . '" disabled', 'value', 'text');
        }
        exit;
    }

    static function loadCityModule($option, $state_id, $city_id, $state_name, $random_id)
    {
        global $jinput, $mainframe, $configClass;
        @header('Content-Type: text/html; charset=utf-8');
        $random_id = ($random_id > 0 ? $random_id : '');
        $show_available_states_cities = $configClass['show_available_states_cities'];
        $db = JFactory::getDBO();

        $lgs = OSPHelper::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        $suffix = "";
        if ($translatable) {
            $suffix = OSPHelper::getFieldSuffix();
        }

        if ($state_id > 0) {
            $cityArr = array();
            $availSql = "";
            if ($show_available_states_cities == 1) {
                $availSql = " and id in (Select city from #__osrs_properties where approved = '1' and published = '1')";
            }
            $cityArr[] = JHTML::_('select.option', '', JText::_('OS_ALL_CITIES'));
            $db->setQuery("Select id as value, city" . $suffix . " as text from #__osrs_cities where published = '1' and state_id = '$state_id' $availSql order by city" . $suffix );
            $cities = $db->loadObjectList();
            $cityArr = array_merge($cityArr, $cities);
            echo JHTML::_('select.genericlist', $cityArr, 'city' . $random_id, 'class="input-medium" ' , 'value', 'text', $city_id);
        } else {
            $cityArr = array();
            $cityArr[] = JHTML::_('select.option', '', JText::_('OS_ALL_CITIES'));
            echo JHTML::_('select.genericlist', $cityArr, 'city' . $random_id, 'class="input-medium" disabled', 'value', 'text');
        }
        if ($random_id != "") {
            ?>
            |*|<?php echo $random_id?>
        <?php
        }
        exit;
    }

    /**
     * Search agent, add agent to the company
     *
     * @param unknown_type $option
     */
    static function searchAgentforaddtocompany($option)
    {
        global $jinput, $mainframe;
        @header('Content-Type: text/html; charset=utf-8');
        $db = JFactory::getDbo();
        $queryString = OSPHelper::getStringRequest('queryString', '');
        if ($queryString != "") {
            $query = "Select a.id, a.name, a.user_id, a.email, a.address, a.state,a.photo from #__osrs_agents as a"
                . " inner join #__users as b on b.id = a.user_id"
                . " where a.published = '1' and b.block = '0'"
                . " and a.id not in (Select agent_id from #__osrs_company_agents) and a.id in (Select id from #__osrs_agents where a.name like '%$queryString%' or a.address like '%$queryString%' or a.email like '%$queryString%')"
                . " order by a.name";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (count($rows) > 0) {
                for ($i = 0; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    $agent_id = $row->id;
                    $photo = $row->photo;

                    if ($photo != "") {
                        $photo_link = JURI::root() . "components/com_osproperty/images/agent/thumbnail/" . $photo;
                        $photo_real_link = JPATH_COMPONENT . DS . "images" . DS . "agent" . DS . "thumbnail" . DS . $photo;
                        if (file_exists($photo_real_link)) {
                            $photo_value = "<img src='$photo_link' width='60' style='border:0px;' />";
                        } else {
                            $photo_value = "";
                        }
                    }

                    $db->setQuery("select state_name from #__osrs_states where id = '$row->state'");
                    $state_name = $db->loadResult();
                    ?>
                    <li onClick="fill(<?php echo $row->id?>,'<?php echo $row->name?>')">
                        <div style="width:300px;">
                            <div style="float:left;width:70px;">
                                <?php
                                if ($photo_value != "") {
                                    echo $photo_value;
                                }
                                ?>
                            </div>
                            <b>
                                <?php echo $row->name?>
                            </b>
                            <BR>
                            <?php echo $row->email?>
                            <BR>
                            <?php echo $row->address?>, <?php echo $state_name;?>
                        </div>
                    </li>
                <?php
                }
            } else {
                ?>
                <li><?php echo JText::_('OS_NO_DATA_MATCH')?></li>
            <?php
            }
        }
        exit;
    }

    static function agentSearch($option)
    {
        global $jinput, $mainframe;
        $db = JFactory::getDbo();
        @header('Content-Type: text/html; charset=utf-8');
        $queryString = OSPHelper::getStringRequest('queryString', '');
        if ($queryString != "") {
            $queryStringArr = explode(",", $queryString);
            //$address = trim($queryStringArr[0]);
            //$city = trim($queryString[1]);
            //$state = trim($queryString[2]);

            $returnArr = array();
            for ($i = 0; $i < count($queryStringArr); $i++) {
                $item = $queryStringArr[$i];

                $db->setQuery("Select a.id from #__osrs_agents as a inner join #__users as b on b.id = a.user_id where a.address like '%$item%' and a.published = '1'");
                $addressArr = $db->loadObjectList();
                if (count($addressArr) > 0) {
                    for ($j = 0; $j < count($addressArr); $j++) {
                        if (!in_array($addressArr[$j]->id, $returnArr)) {
                            $returnArr[count($returnArr)] = $addressArr[$j]->id;
                        }
                    }
                }

                $db->setQuery("Select a.id from #__osrs_agents as a inner join #__users as b on b.id = a.user_id where a.city like '%$item%' and a.published = '1'");
                $cityArr = $db->loadObjectList();
                if (count($cityArr) > 0) {
                    for ($j = 0; $j < count($cityArr); $j++) {
                        if (!in_array($cityArr[$j]->id, $returnArr)) {
                            $returnArr[count($returnArr)] = $cityArr[$j]->id;
                        }
                    }
                }

                $db->setQuery("Select id from #__osrs_states where (state_name like '%$item%' or state_code like '$item') and published = '1'");
                $states = $db->loadObjectList();
                if (count($states) > 0) {
                    $state_ids = "";
                    for ($i = 0; $i < count($states); $i++) {
                        $state_ids .= $states[$i]->id . ",";
                    }
                    $state_ids = substr($state_ids, 0, strlen($state_ids) - 1);
                    $db->setQuery("Select a.id from #__osrs_agents as a inner join #__users as b on b.id = a.user_id where a.state in ($state_ids) and a.published = '1'");
                    $stateArr = $db->loadObjectList();
                    if (count($stateArr) > 0) {
                        for ($j = 0; $j < count($stateArr); $j++) {
                            if (!in_array($stateArr[$j]->id, $returnArr)) {
                                $returnArr[count($returnArr)] = $stateArr[$j]->id;
                            }
                        }
                    }
                }
            }

            if (count($returnArr) > 0) {
                for ($i = 0; $i < count($returnArr); $i++) {
                    $id = $returnArr[$i];
                    $db->setQuery("Select * from #__osrs_agents where id = '$id' and published = '1'");
                    $row = $db->loadObject();
                    $db->setQuery("Select state_name from #__osrs_states where id = '$row->state'");
                    $state = $db->loadResult();
                    $value = $row->name;
                    $value .= " - " . $row->address;
                    if ($row->city != "") {
                        $value .= ", " . $row->city;
                    }
                    $value .= ", " . $state;
                    ?>
                    <li onClick="fill(<?php echo $id?>,'<?php echo $value?>')">
                        <?php echo $value?>
                    </li>
                <?php
                }
            } else {
                ?>
                <li><?php echo JText::_('OS_NO_DATA_MATCH')?></li>
            <?php
            }
        }
        exit;
    }


    static function loadStateBackend($option)
    {
        global $jinput, $mainframe;
        $db = JFactory::getDbo();
        @header('Content-Type: text/html; charset=utf-8');
        $country = $jinput->getInt('country',0);
        $pid = $jinput->getInt('pid', 0);
        $db->setQuery("Select id as value, state_name as text from #__osrs_states where published = '1' and country_id = '$country'");
        $states = $db->loadObjectList();
        $stateArr = array();
        $stateArr[] = JHTML::_('select.option', '', JText::_('OS_SELECT_STATE'));
        $stateArr = array_merge($stateArr, $states);
        echo JHTML::_('select.genericlist', $stateArr, 'state' . $pid, 'onChange="javascript:changeStateValue(' . $pid . ');" class="input-medium"', 'value', 'text');
        exit;
    }

    static function loadCityBackend($option)
    {
        global $jinput, $mainframe;
        @header('Content-Type: text/html; charset=utf-8');
        $db = JFactory::getDbo();
        $state = $jinput->getInt('state');
        $pid = $jinput->getInt('pid', 0);
        $db->setQuery("Select id as value, city as text from #__osrs_cities where published = '1' and state_id = '$state' order by city");
        $cities = $db->loadObjectList();
        $cityArr = array();
        $cityArr[] = JHTML::_('select.option', '', JText::_('OS_SELECT_CITY'));
        $cityArr = array_merge($cityArr, $cities);
        echo JHTML::_('select.genericlist', $cityArr, 'city' . $pid, ' class="input-medium"', 'value', 'text');
        exit;
    }


    static function loadStateInListPage($option)
    {
        global $jinput, $mainframe, $configClass;
        @header('Content-Type: text/html; charset=utf-8');
        $show_available_states_cities = $configClass['show_available_states_cities'];

        $db = JFactory::getDbo();

        $lgs = OSPHelper::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        $suffix = "";
        if ($translatable) {
            $suffix = OSPHelper::getFieldSuffix();
        }

        $country_id = $jinput->getInt('country_id', 0);
        $availSql = "";
        if (($country_id > 0) and ($show_available_states_cities == 1)) {
            $availSql = " and id in (Select state from #__osrs_properties where approved = '1' and published = '1')";
        }
        $db->setQuery("Select id as value, state_name" . $suffix . " as text from #__osrs_states where published = '1' and country_id = '$country_id' $availSql");
        $states = $db->loadObjectList();

        $stateArr = array();
        $stateArr[] = JHTML::_('select.option', '', JText::_('OS_ALL_STATES'));
        $stateArr = array_merge($stateArr, $states);
        $lists['states'] = JHTML::_('select.genericlist', $stateArr, 'state_id', 'onChange="javascript:changeCity(this.value,0);" class="input-medium" disable', 'value', 'text', '');
        echo $lists['states'];
        echo "@@@@";
        self::loadCity($option, '', '', 'state_id');
        exit;
    }


    /**
     * Check coupon code
     *
     * @param unknown_type $option
     */
    static function checkcouponcode($option)
    {
        global $jinput, $mainframe;
        $db = JFactory::getDBO();
        $id = $jinput->getInt('id');
        $db->setQuery("Select * from #__osrs_coupon where id = '$id'");
        $coupon = $db->loadObject();
        $coupon_code = OSPHelper::getStringRequest('coupon_code', '');
        $user = JFactory::getUser();
        $number_check = "";
        $number_check = $_COOKIE['u' . $user->id];
        if ($number_check == "") {
            $number_check = 0;
            setcookie('u' . $user->id, 1, time() + 3600);
        } else {
            $number_check++;
            setcookie('u' . $user->id, $number_check, time() + 3600);
        }
        $db->setQuery("Select count(id) from #__osrs_coupon where id = '$id' and coupon_code = '$coupon_code'");
        $count = $db->loadResult();
        if ($count > 0) {
            ?>
            <span style="font-size:15px;font-weight:bold;color:#0E8247;">
                <?php
                printf('OS_CORRECT_COUPON_CODE', $coupon->discount . '%', $coupon->coupon_name);
                ?>
            </span>
            <?php
            @setcookie('coupon_code_awarded', $id, time() + 3600);
        } elseif ($number_check <= 4) {
            ?>
            <span style="font-size:15px;font-weight:bold;color:#C53535;">
                <?php
                echo JText::_('Wrong coupon code, please try again !!!');
                ?>
            </span>
            <BR>
            <?php
            echo JText::_('OS_IF_YOU_HAVE_COUPON_CODE');
            ?>
            <BR><BR>
            <input type="text" name="coupon_code" id="coupon_code" class="input-small" size="10">
            <input type="button" class="button" value="<?php echo JText::_('OS_CHECK_COUPON_CODE')?>"
                   onclick="javascript:checkCouponCode(<?php echo $coupon->id?>)">
        <?php
        } else {
            ?>
            <span style="font-size:15px;font-weight:bold;color:#C53535;">
                <?php
                echo JText::_('OS_WRONG_CODE');
                ?>
            </span>
        <?php
        }
        exit;
    }

    /**
     * Convert Currency
     *
     * @param unknown_type $option
     */
    static function convertCurrency($option)
    {
        global $jinput, $mainframe;
        @header('Content-Type: text/html; charset=utf-8');
        $db = JFactory::getDbo();
        $pid = $jinput->getInt('pid',0);
        $show_label = $jinput->getInt('show_label', 0);
		$theme = $jinput->getString('theme','');
        $db->setQuery("Select price,curr from #__osrs_properties where id = '$pid'");
        $property = $db->loadObject();
        $price = $property->price;
        $ocurr = $property->curr;

        $ncurr = $jinput->getInt('curr', '');

        $db->setQuery("Select currency_code from #__osrs_currencies where id = '$ocurr'");
        $ocurr_code = $db->loadResult();

        $db->setQuery("Select currency_code from #__osrs_currencies where id = '$ncurr'");
        $ncurr_code = $db->loadResult();
        $exchange = HelperOspropertyCommon::get_conversion($ocurr_code, $ncurr_code);
        $newprice = $price * $exchange;

        //prepare the list
        $db->setQuery("Select id as value, currency_code as text from #__osrs_currencies where id <> '$ocurr' and published = '1' order by currency_code");
        $currencies = $db->loadObjectList();
        $currenyArr[] = JHTML::_('select.option', '', 'Select');
        $currenyArr = array_merge($currenyArr, $currencies);
		if($theme != "default"){
	        $lists['curr'] = JHTML::_('select.genericlist', $currenyArr, 'curr', 'onChange="javascript:convertCurrency(' . $pid . ',this.value,' . $show_label . ')" class="input-small"', 'value', 'text', $ncurr);
		}else{
			$lists['curr'] = JHTML::_('select.genericlist', $currenyArr, 'curr', 'onChange="javascript:convertCurrencyDefault(' . $pid . ',this.value,' . $show_label . ')" class="input-small"', 'value', 'text', $ncurr);
		}

        if ($show_label == 1) {
            echo JText::_('OS_PRICE');
            echo ": ";
        }
        if ($ncurr == "") {
            echo OSPHelper::generatePrice($ocurr, $price);
        } else {
            echo OSPHelper::generatePrice($ncurr, $newprice);
        }

        $db->setQuery("Select rent_time from #__osrs_properties where id = '$pid'");
        $rent_time = $db->loadResult();
        if ($rent_time != "") {
            echo " /" . Jtext::_($rent_time);
        }
		if($theme != "default"){
        ?>

        <BR/>
        <span style="font-size:11px;">
		<?php echo JText::_('OS_CONVERT_CURRENCY')?>: 
		<?php } ?>
		<?php echo $lists['curr']?>
		<?php if($theme != "default"){ ?>
		</span>
        <?php
		}
        exit();
    }

    /**
     * Ajax search
     *
     */
    static function ajaxsearch()
    {
        global $jinput, $mainframe, $configClass, $lang_suffix;
        $keyword = OSPHelper::getStringRequest('input', '');
        $db = JFactory::getDbo();

        $answer = array();

        $db->setQuery("Select id, pro_name$lang_suffix as pro_name,address from #__osrs_properties where published = '1' and approved = '1' and pro_name$lang_suffix like '%$keyword%'");
        $rows = $db->loadObjectList();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $count = count($answer);
                $answer[$count]->id = $row->id;
                $answer[$count]->value = $row->pro_name;
                $answer[$count]->info = OSPHelper::generateAddress($row);
            }
        }

        $db->setQuery("Select a.id, a.pro_name$lang_suffix as pro_name,a.address,a.state,a.city from #__osrs_properties as a inner join #__osrs_states as b on b.id = a.state inner join #__osrs_cities as c on c.id = a.city inner join #__osrs_countries as d on d.id = a.country where a.published = '1' and a.approved = '1' and a.show_address = '1' and (a.ref like '%$keyword%' or a.pro_name$lang_suffix like '%$keyword%' or a.address like '%$keyword%' or b.state_name like '%$keyword%' or c.city like '%$keyword%' or d.country_name like '%$keyword%') group by a.id");
        $rows = $db->loadObjectList();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $count = count($answer);
                $answer[$count]->id = $row->id;
                $answer[$count]->value = OSPHelper::generateAddress($row);
                $answer[$count]->info = $row->pro_name;
            }
        }
        //print_r($answer);
        header("Expires: Mon, 26 Jul 2010 05:00:00 GMT"); // Date in the past
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Pragma: no-cache"); // HTTP/1.0

        sleep(2);

        if (isset($_REQUEST['json'])) {
            header("Content-Type: application/json");

            echo "{\"results\": [";
            $arr = array();
            if (count($answer) > 0) {
                foreach ($answer as $as) {
                    $arr[] = "{\"id\": \"1\", \"value\": \"" . $as->value . "\", \"info\":\"" . $as->info . "\"}";
                }
            }

            echo implode(", ", $arr);
            echo "]}";
        }
        exit();
    }

    static function updateSendEmailStatus(){
        global $jinput, $mainframe;
        $db = JFactory::getDbo();
        $list_id = $jinput->getInt('list_id',0);
        $send_status = $jinput->getInt('send_status',0);
        $user = JFactory::getUser();
        $db->setQuery("Select user_id from #__osrs_user_list where id = '$list_id'");
        $list_user_id = $db->loadResult();
        if($user->id == $list_user_id){
            $db->setQuery("Update #__osrs_user_list set receive_email = '$send_status' where id = '$list_id'");
            $db->query();
        }
        $db->setQuery("Select receive_email from #__osrs_user_list where id = '$list_id'");
        $receive_email = $db->loadResult();
        if($receive_email == 0){
            ?>
            <a href="javascript:updateSendEmailStatus(<?php echo $list_id?>,1);" title="<?php echo JText::_('OS_CLICK_HERE_TO_RECEIVE_ALERT_EMAIL_WHEN_NEW_PROPERTIES_ARE_ADDED');?>">
                <img src="<?php echo JUri::root()?>components/com_osproperty/images/assets/publish_x.png"/>
            </a>
        <?php
        }else{
            ?>
            <a href="javascript:updateSendEmailStatus(<?php echo $list_id;?>,0);" title="<?php echo JText::_('OS_IF_YOU_DONT_WANT_TO_RECEIVE_ALERT_EMAIL_PLEASE_CLICK_HERE');?>">
                <img src="<?php echo JUri::root()?>components/com_osproperty/images/assets/tick.png"/>
            </a>
        <?php
        }
        exit();
    }

	public static function checkingVersion(){
		global $jinput, $mainframe;
		if(file_exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."version.txt")){														
			$fh = fopen(JPATH_ROOT.DS."components".DS."com_osproperty".DS."version.txt","r");
			$current_version = fread($fh,filesize(JPATH_ROOT.DS."components".DS."com_osproperty".DS."version.txt"));
			@fclose($fh);
		}

		/*
		$result = array();
		$result['status'] = 0;
		if (function_exists('curl_init'))
		{
			$url = 'http://joomdonation.com/images/osproperty/version.txt';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$latestVersion = curl_exec($ch);
			curl_close($ch);
			$latestVersion = trim($latestVersion);
			if ($latestVersion)
			{
				if (version_compare($latestVersion, $current_version, 'gt'))
				{
					?>
					<img src="<?php echo JUri::root();?>components/com_osproperty/images/assets/noupdated.png" />
				
					<?php
					echo '<span class="version-checking-alert">'.JText::sprintf('OS_UPDATE_CHECKING_UPDATE_FOUND', $latestVersion).'</span>';
				}
				else
				{
					?>
					<img src="<?php echo JUri::root();?>components/com_osproperty/images/assets/updated.png" />
					<?php
					echo '<span class="version-checking-noalert">'.JText::_('OS_UPDATE_CHECKING_UP_TO_DATE').'</span>';
				}
			}
		}
		exit();
		*/
		// Get the caching duration.
		$component     = JComponentHelper::getComponent('com_installer');
		$params        = $component->params;
		$cache_timeout = $params->get('cachetimeout', 6, 'int');
		$cache_timeout = 3600 * $cache_timeout;
		// Get the minimum stability.
		$minimum_stability = $params->get('minimum_stability', JUpdater::STABILITY_STABLE, 'int');
		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_installer/models');
		/** @var InstallerModelUpdate $model */
		$model = JModelLegacy::getInstance('Update', 'InstallerModel');
		$model->purge();
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('extension_id')
			->from('#__extensions')
			->where('`type` = "package"')
			->where('`element` = "pkg_osproperty"');
		$db->setQuery($query);
		$eid = (int) $db->loadResult();
		$result['status'] = 0;
		if ($eid)
		{
			$ret = JUpdater::getInstance()->findUpdates($eid, $cache_timeout, $minimum_stability);
			if ($ret)
			{
				$model->setState('list.start', 0);
				$model->setState('list.limit', 0);
				$model->setState('filter.extension_id', $eid);
				$updates          = $model->getItems();
				$result['status'] = 2;
				if (count($updates))
				{
					?>
					<img src="<?php echo JUri::root();?>components/com_osproperty/images/assets/noupdated.png" />
				
					<?php
					echo '<span class="version-checking-alert">'.JText::sprintf('OS_UPDATE_CHECKING_UPDATE_FOUND', $updates[0]->version).'</span>';
				}
				else
				{
					?>
					<img src="<?php echo JUri::root();?>components/com_osproperty/images/assets/noupdated.png" />
					<?php
					echo '<span class="version-checking-alert">'.JText::sprintf('OS_UPDATE_CHECKING_UPDATE_FOUND', null).'</span>';
				}
			}
			else
			{
				?>
				<img src="<?php echo JUri::root();?>components/com_osproperty/images/assets/updated.png" />
				<?php
				echo '<span class="version-checking-noalert">'.JText::_('OS_UPDATE_CHECKING_UP_TO_DATE').'</span>';
			}
		}
		JFactory::getApplication()->close();
	}
}
?>