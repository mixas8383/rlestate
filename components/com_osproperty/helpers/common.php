<?php
/* ------------------------------------------------------------------------
  # common.php - Ossolution Property
  # ------------------------------------------------------------------------
  # author    Dang Thuc Dam
  # copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  # Websites: http://www.joomdonation.com
  # Technical Support:  Forum - http://www.joomdonation.com/forum.html
 */
// No direct access.
defined('_JEXEC') or die;

class HelperOspropertyCommon
{

    /**
     * Load Footer
     *
     * @param unknown_type $option
     */
    static function loadFooter($option)
    {
        global $jinput, $mainframe, $configClass;
        $db = JFactory::getDBO();
        if ($configClass['show_footer'] == 1)
        {
            
        }
    }

    public function getOne($array)
    {
        if (!empty($array))
        {
            usort($array, function($a, $b)
            {
                return true;
            });
            return $array[0];
        }
        return false;
    }

    /**
     * Get the country_id in the filter page or edit item details page
     *
     * @return unknown
     */
    public static function getDefaultCountry()
    {
        global $jinput, $configClass;
        $configClass = OSPHelper::loadConfig();

        if ($configClass['show_country_id'] != "")
        {
            $countryArr = explode(",", $configClass['show_country_id']);
            if (count($countryArr) == 1)
            {
                return $countryArr[0];
            }
        }
        return 0;
    }

    /**
     * Check default country
     * 
     *
     * @return boolean
     * false : Use for one country
     * true  : use for multiple countries
     * 
     */
    public static function checkCountry()
    {
        global $jinput, $configClass;
        if ($configClass['show_country_id'] != "")
        {
            $countryArr = explode(",", $configClass['show_country_id']);
            if (count($countryArr) == 1)
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Make the country list
     *
     * @param unknown_type $req_country_id
     * @param unknown_type $name
     * @param unknown_type $onChange
     */
    public static function makeCountryList($req_country_id, $name, $onChange, $firstOption, $style, $class = "input-medium")
    {
        global $jinput, $configClass;
        $db = JFactory::getDbo();
        $languages = OSPHelper::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($languages);
        if ($translatable)
        {
            $lang_suffix = OSPHelper::getFieldSuffix();
        } else
        {
            $lang_suffix = "";
        }
        if ($configClass['show_country_id'] != "")
        {
            if (HelperOspropertyCommon::checkCountry())
            {

                $db->setQuery("Select id as value, country_name" . $lang_suffix . " as text from #__osrs_countries where 1=1 and id in (" . $configClass['show_country_id'] . ") order by country_name");
                $countries = $db->loadObjectList();
                if ($firstOption != "")
                {
                    $countryArr[] = JHTML::_('select.option', '', $firstOption);
                    $countryArr = array_merge($countryArr, $countries);
                } else
                {
                    $countryArr = $countries;
                }

                return JHTML::_('select.genericlist', $countryArr, $name, 'class="' . $class . '" ' . $onChange . ' ' . $style, 'value', 'text', $req_country_id);
            } else
            {
                return "<input type='hidden' name='$name' value='" . $configClass['show_country_id'] . "' id='$name'>";
            }
        } else
        {
            $db->setQuery("Select id as value, country_name" . $lang_suffix . " as text from #__osrs_countries where 1=1 order by country_name");
            $countries = $db->loadObjectList();
            if ($firstOption != "")
            {
                $countryArr[] = JHTML::_('select.option', '', $firstOption);
                $countryArr = array_merge($countryArr, $countries);
            } else
            {
                $countryArr = $countries;
            }
            return JHTML::_('select.genericlist', $countryArr, $name, 'class="' . $class . '" ' . $onChange . ' ' . $style, 'value', 'text', $req_country_id);
        }
    }

    /**
     * Make the state list
     *
     * @param unknown_type $req_country_id
     * @param unknown_type $req_state_id
     * @param unknown_type $name
     * @param unknown_type $onChange
     * @param unknown_type $firstOption
     * @return unknown
     */
    public static function makeStateList($req_country_id, $req_state_id, $name, $onChange, $firstOption, $style, $class = "input-medium")
    {
        global $jinput, $configClass, $languages;
        $db = JFactory::getDbo();
        $stateArr = array();
        $show_available_states_cities = $configClass['show_available_states_cities'];

        $lgs = OSPHelper::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        $suffix = "";
        if ($translatable)
        {
            $suffix = OSPHelper::getFieldSuffix();
        }

        if ((!HelperOspropertyCommon::checkCountry()) or ( $req_country_id > 0))
        {

            $query = "Select id as value,state_name" . $suffix . " as text from #__osrs_states where published = 1 ";
            if ($req_country_id > 0)
            {
                $query .= " and country_id = '$req_country_id'";
            } else
            {
                $query .= " and country_id = '" . $configClass['show_country_id'] . "'";
            }
            if ($show_available_states_cities == 1)
            {
                $query .= " and id in (Select state from #__osrs_properties where approved = '1' and published = '1')";
            }
            $query .= " order by state_name" . $suffix;
            $db->setQuery($query);
            $states = $db->loadObjectList();
            if ($firstOption != "")
            {
                $stateArr[] = JHTML::_('select.option', '', $firstOption);
                $stateArr = array_merge($stateArr, $states);
            } else
            {
                $stateArr = $states;
            }
            return JHTML::_('select.genericlist', $stateArr, $name, 'class="' . $class . '" ' . $onChange . ' ' . $style, 'value', 'text', $req_state_id);
        } else
        {
            $stateArr[] = JHTML::_('select.option', '', $firstOption);
            return JHTML::_('select.genericlist', $stateArr, $name, 'class="' . $class . '" disabled', 'value', 'text');
        }
    }

    /**
     * Load City
     *
     * @param unknown_type $option
     * @param unknown_type $state_id
     * @param unknown_type $city_id
     * @return unknown
     */
    public static function loadCity($option, $state_id, $city_id, $class = "input-medium")
    {
        global $jinput, $mainframe, $configClass, $languages;
        $db = JFactory::getDBO();

        $lgs = OSPHelper::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        $suffix = "";
        if ($translatable)
        {
            $suffix = OSPHelper::getFieldSuffix();
        }

        $availSql = "";
        $show_available_states_cities = $configClass['show_available_states_cities'];
        $cityArr = array();
        $cityArr[] = JHTML::_('select.option', '', JText::_('OS_ALL_CITIES'));
        if ($state_id > 0)
        {
            if ($show_available_states_cities == 1)
            {
                $availSql = " and id in (Select city from #__osrs_properties where approved = '1' and published = '1')";
            }
            $db->setQuery("Select id as value, city" . $suffix . " as text from #__osrs_cities where  published = '1' $availSql and state_id = '$state_id' order by city");

            $cities = $db->loadObjectList();
            $cityArr = array_merge($cityArr, $cities);
            $disabled = "";
        } else
        {
            $disabled = "disabled";
        }
        return JHTML::_('select.genericlist', $cityArr, 'city', 'class="' . $class . '" ' . $disabled, 'value', 'text', $city_id);
    }

    /**
     * Make the state list
     *
     * @param unknown_type $req_country_id
     * @param unknown_type $req_state_id
     * @param unknown_type $name
     * @param unknown_type $onChange
     * @param unknown_type $firstOption
     * @return unknown
     */
    static function makeStateListAddProperty($req_country_id, $req_state_id, $name, $onChange, $firstOption, $style)
    {
        global $jinput, $configClass, $languages;
        $db = JFactory::getDbo();

        $lgs = OSPHelper::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        $suffix = "";
        if ($translatable)
        {
            $suffix = OSPHelper::getFieldSuffix();
        }

        $stateArr = array();
        if ((!HelperOspropertyCommon::checkCountry()) or ( $req_country_id > 0))
        {

            $query = "Select id as value,state_name" . $suffix . " as text from #__osrs_states where published = 1 ";
            if ($req_country_id > 0)
            {
                $query .= " and country_id = '$req_country_id'";
            } else
            {
                $query .= " and country_id = '" . $configClass['show_country_id'] . "'";
            }
            $query .= " order by state_name";
            $db->setQuery($query);
            $states = $db->loadObjectList();
            if ($firstOption != "")
            {
                $stateArr[] = JHTML::_('select.option', '', $firstOption);
                $stateArr = array_merge($stateArr, $states);
            } else
            {
                $stateArr = $states;
            }
            return JHTML::_('select.genericlist', $stateArr, $name, 'class="input-medium" ' . $onChange . ' ' . $style, 'value', 'text', $req_state_id);
        } else
        {
            $stateArr[] = JHTML::_('select.option', '', $firstOption);
            return JHTML::_('select.genericlist', $stateArr, $name, 'class="input-medium" disabled', 'value', 'text');
        }
    }

    /**
     * Load City
     *
     * @param unknown_type $option
     * @param unknown_type $state_id
     * @param unknown_type $city_id
     * @return unknown
     */
    static function loadCityAddProperty($option, $state_id, $city_id)
    {
        global $jinput, $mainframe, $languages;
        $db = JFactory::getDBO();

        $lgs = OSPHelper::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        $suffix = "";
        if ($translatable)
        {
            $suffix = OSPHelper::getFieldSuffix();
        }

        $cityArr = array();
        $cityArr[] = JHTML::_('select.option', '', JText::_('OS_ALL_CITIES'));
        if ($state_id > 0)
        {
            $db->setQuery("Select id as value, city" . $suffix . " as text from #__osrs_cities where  published = '1' and state_id = '$state_id' order by city");
            $cities = $db->loadObjectList();
            //$cityArr[] = JHTML::_('select.option','',JText::_('OS_ALL_CITIES'));
            $cityArr = array_merge($cityArr, $cities);
            $disabled = "";
        } else
        {
            $disabled = "disabled";
        }
        return JHTML::_('select.genericlist', $cityArr, 'city', 'class="input-medium" ' . $disabled, 'value', 'text', $city_id);
    }

    static function getAllCyties()
    {
        static $cities;
        if (!$cities)
        {
            $db = JFactory::getDBO();
            $db->setQuery("Select * from #__osrs_cities ");
            $cities = $db->loadObjectList();
        }
        return $cities;
    }

    static function loadCityName($city)
    {
        global $jinput, $mainframe, $languages;
        $db = JFactory::getDBO();
        $lgs = OSPHelper::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        $cities = self::getAllCyties();
        if ($translatable)
        {
            $suffix = OSPHelper::getFieldSuffix();
            $key1 = new stdClass;
            $key1->key = 'id';
            $key1->value = $city;
            $key1->condition = '=';
            $city = HelperOspropertyFields::filterArray($cities, array($key1));
            usort($city, function()
            {
                return true;
            });
            $city_name = $city[0]->{'city' . $suffix};
        } else
        {
            $key1 = new stdClass;
            $key1->key = 'id';
            $key1->value = $city;
            $key1->condition = '=';
            $city = HelperOspropertyFields::filterArray($cities, array($key1));
            usort($city, function()
            {
                return true;
            });
            $city_name = $city[0]->city;
        }
        return $city_name;
    }

    /**
     * Check access permission
     *
     * @param unknown_type $access
     */
    static function checkAccessPersmission($access)
    {
        global $jinput, $mainframe, $_jversion;
        $db = JFactory::getDBO();
        $user = JFactory::getUser();
        if ($access == 0)
        { //public
            return true;
        } elseif ($access == 1)
        { //registered
            if (intval($user->id) == 0)
            {
                return false;
            } else
            {
                return true;
            }
        } elseif ($access == 2)
        { //special
            if (intval($user->id) == 0)
            {
                return false;
            } else
            {
                $db->setQuery("Select group_id from #__user_usergroup_map where user_id = '$user->id'");
                $group_id = $db->loadResult();
                if (($group_id >= 3) and ( $group_id <= 8))
                {
                    return true;
                } else
                {
                    return false;
                }
            }
        }
    }

    /**
     * Check to see if user is Agent
     *
     * @param unknown_type $option
     * @return unknown
     */
    static function isAgent($agent_id = 0)
    {
        global $jinput, $mainframe;
        $user = JFactory::getUser();
        $db = JFactory::getDBO();
        if ($agent_id == 0)
        {
            $agent_id = $user->id;
        }
        if (intval($agent_id) == 0)
        {
            return false;
        } else
        {
            $db->setQuery("Select count(id) from #__osrs_agents where user_id = '$agent_id' and published = '1'");
            $count = $db->loadResult();
            if ($count > 0)
            {
                return true;
            } else
            {
                return false;
            }
        }
    }

    /**
     * Check to see if user is Agent
     *
     * @param unknown_type $option
     * @return unknown
     */
    static function isRegisteredAgent($agent_id = 0)
    {
        global $jinput, $mainframe;
        $user = JFactory::getUser();
        $db = JFactory::getDBO();
        if ($agent_id == 0)
        {
            $agent_id = $user->id;
        }
        if (intval($agent_id) == 0)
        {
            return false;
        } else
        {
            $db->setQuery("Select count(id) from #__osrs_agents where user_id = '$agent_id'");
            $count = $db->loadResult();
            if ($count > 0)
            {
                return true;
            } else
            {
                return false;
            }
        }
    }

    /**
     * Get Agent ID
     *
     * @return unknown
     */
    static function getAgentID()
    {
        global $jinput, $mainframe;
        $user = JFactory::getUser();
        $db = JFactory::getDBO();
        $db->setQuery("Select id from #__osrs_agents where user_id = '$user->id'");
        $agent_id = $db->loadResult();
        return $agent_id;
    }

    /**
     * Check to see if user is admin of current company
     *
     */
    static function isCompanyAdmin($company_id = 0)
    {
        global $jinput, $mainframe;
        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        if ($company_id == 0)
        {
            $company_id = $user->id;
        }
        if (intval($company_id) == 0)
        {
            return false;
        } else
        {
            $db->setQuery("Select count(id) from #__osrs_companies where user_id = '$company_id' and published = '1'");
            $count = $db->loadResult();
            if ($count == 0)
            {
                return false;
            } else
            {
                return true;
            }
        }
    }

    /**
     * Check to see if user is admin of current company
     *
     */
    static function isRegisteredCompanyAdmin($company_id = 0)
    {
        global $jinput, $mainframe;
        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        if ($company_id == 0)
        {
            $company_id = $user->id;
        }
        if (intval($company_id) == 0)
        {
            return false;
        } else
        {
            $db->setQuery("Select count(id) from #__osrs_companies where user_id = '$company_id'");
            $count = $db->loadResult();
            if ($count == 0)
            {
                return false;
            } else
            {
                return true;
            }
        }
    }

    static public function getCompanyId()
    {
        global $jinput, $mainframe;
        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        if (intval($user->id) == 0)
        {
            return 0;
        } else
        {
            $db->setQuery("Select id from #__osrs_companies where user_id = '$user->id' and published = '1'");
            $count = $db->loadResult();
            //echo $count;
            //die();
            if ($count == 0)
            {
                return 0;
            } else
            {
                return $count;
            }
        }
    }

    /**
     * remove white space in begin and end of the option in one array
     *
     * @param unknown_type $a
     */
    function stripSpaceArrayOptions($a)
    {
        global $jinput, $mainframe;
        if (count($a) > 0)
        {
            for ($i = 0; $i < count($a); $i++)
            {
                $a[$i] = trim($a[$i]);
            }
        }
        return $a;
    }

    /**
     * Check to see if this agent is already use the coupon id
     *
     * @param unknown_type $coupon_id
     */
    static function isAlreadyUsed($coupon_id)
    {
        global $jinput, $mainframe;
        $db = JFactory::getDBO();
        $user = JFactory::getUser();
        if (!HelperOspropertyCommon::isAgent())
        {
            return true;
        } else
        {
            $db->setQuery("Select id from #__osrs_agents where user_id = '$user->id' and published = '1'");
            $agent_id = $db->loadResult();
            $db->setQuery("Select count(id) from #__osrs_user_coupons where agent_id = '$agent_id' and coupon_id = '$coupon_id'");
            $count = $db->loadResult();
            if ($count == 0)
            {
                return false;
            } else
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Check to see whether if this is user
     *
     * @param unknown_type $option
     */
    static function isUser()
    {
        global $jinput, $mainframe;
        $user = JFactory::getUser();
        if (intval($user->id) == 0)
        {
            return false;
        } else
        {
            return true;
        }
    }

    /**
     * Load Time depend on configuration 
     *
     * @param unknown_type $time
     * @param unknown_type $input_format
     * @return unknown
     */
    static function loadTime($time, $input_format)
    {
        $db = JFactory::getDbo();
        $db->setQuery("#loadTime
            Select fieldvalue from #__osrs_configuration where id = '37'");
        $time_format = $db->loadResult();
        $time_format = str_replace("%", "", $time_format);
        if ($input_format == 1)
        {
            return date($time_format, $time);
        } else
        {
            $time = strtotime($time);
            return date($time_format, $time);
        }
    }

    /**
     * Show price 
     * get value of record 21 from #__osrs_configuration
     *
     * @param unknown_type $price
     * @return unknown
     */
    public static function showPrice($price)
    {
        global $jinput, $configClass;
        static $money_format;
        $db = JFactory::getDBO();
        if ($money_format == null)
        {
            $db->setQuery("#showPrice
                Select fieldvalue from #__osrs_configuration where fieldname like 'general_currency_money_format'");
            $money_format = $db->loadResult();
        }
        switch ($money_format)
        {
            case "1":
                return number_format($price, 2, ',', '.');
                break;
            case "2":
                return number_format($price, 2, ',', ' ');
                break;
            case "3":
                return number_format($price, 2, '.', ',');
                break;
            case "4":
                return number_format($price, 0, ',', '.');
                break;
            case "5":
                return number_format($price, 0, ',', ' ');
                break;
            case "6":
                return number_format($price, 0, '.', ',');
                break;
        }
    }

    /**
     * Remove photo
     * photo_type = 1 : Property
     * photo_type = 2 : Agent
     *
     */
    static function removePhoto($id, $photo_type)
    {
        global $jinput, $mainframe;
        $db = JFactory::getDbo();
        switch ($photo_type)
        {
            case "1":
                $db->setQuery("Select image from #__osrs_photos where id = '$id'");
                $image = $db->loadResult();
                $db->setQuery("Select pro_id from #__osrs_photos where id = '$id'");
                $pro_id = $db->loadResult();
                @unlink(JPATH_ROOT . DS . "images" . DS . "osproperty" . DS . "properties" . DS . $pro_id . DS . $image);
                @unlink(JPATH_ROOT . DS . "images" . DS . "osproperty" . DS . "properties" . DS . $pro_id . DS . "thumb" . DS . $image);
                @unlink(JPATH_ROOT . DS . "images" . DS . "osproperty" . DS . "properties" . DS . $pro_id . DS . "medium" . DS . $image);
                $db->setQuery("Delete from #__osrs_photos where id = '$id'");
                $db->query();
                break;
            case "2":
                $db->setQuery("Select photo from #__osrs_agents where id = '$id'");
                $image = $db->loadResult();
                @unlink(JPATH_ROOT . DS . "images" . DS . "osproperty" . DS . "agent" . DS . $image);
                @unlink(JPATH_ROOT . DS . "images" . DS . "osproperty" . DS . "agent" . DS . "thumbnail" . DS . $image);
                break;
        }
    }

    /**
     * alphabet List
     *
     * @param unknown_type $option
     * @param unknown_type $formname
     */
    public static function alphabetList($option, $alphabet, $formname)
    {
        global $jinput, $mainframe;
        ?>
        <script type="text/javascript">
            function submitAlphabetForm(a) {
                var form = document.getElementById("<?php echo $formname ?>");
                if (form != null) {
                    form.alphabet.value = a;
                    form.submit();
                }
            }
        </script>
        <div id="characters_line" style="margin: 10px 0;">
            <?php
            $class1 = "character";
            $class2 = "character";
            $class3 = "character";
            $class4 = "character";
            $class5 = "character";
            $class6 = "character";
            $class7 = "character";
            $class8 = "character";
            $class9 = "character";
            $class10 = "character";
            $class11 = "character";
            $class12 = "character";
            $class13 = "character";
            $class14 = "character";
            $class15 = "character";
            $class16 = "character";
            $class17 = "character";
            $class18 = "character";
            $class19 = "character";
            $class20 = "character";
            $class21 = "character";
            $class22 = "character";
            $class23 = "character";
            $class24 = "character";
            $class25 = "character";
            $class26 = "character";
            $class27 = "character";

            switch ($alphabet)
            {
                case "0-9":
                    $class1 = "character_selected";
                    break;
                case "A":
                    $class2 = "character_selected";
                    break;
                case "B":
                    $class3 = "character_selected";
                    break;
                case "C":
                    $class4 = "character_selected";
                    break;
                case "D":
                    $class5 = "character_selected";
                    break;
                case "E":
                    $class6 = "character_selected";
                    break;
                case "F":
                    $class7 = "character_selected";
                    break;
                case "G":
                    $class8 = "character_selected";
                    break;
                case "H":
                    $class9 = "character_selected";
                    break;
                case "I":
                    $class10 = "character_selected";
                    break;
                case "J":
                    $class11 = "character_selected";
                    break;
                case "K":
                    $class12 = "character_selected";
                    break;
                case "L":
                    $class13 = "character_selected";
                    break;
                case "M":
                    $class14 = "character_selected";
                    break;
                case "N":
                    $class15 = "character_selected";
                    break;
                case "O":
                    $class16 = "character_selected";
                    break;
                case "P":
                    $class17 = "character_selected";
                    break;
                case "Q":
                    $class18 = "character_selected";
                    break;
                case "R":
                    $class19 = "character_selected";
                    break;
                case "S":
                    $class20 = "character_selected";
                    break;
                case "T":
                    $class21 = "character_selected";
                    break;
                case "U":
                    $class22 = "character_selected";
                    break;
                case "V":
                    $class23 = "character_selected";
                    break;
                case "W":
                    $class24 = "character_selected";
                    break;
                case "X":
                    $class25 = "character_selected";
                    break;
                case "Y":
                    $class26 = "character_selected";
                    break;
                case "Z":
                    $class27 = "character_selected";
                    break;
            }
            ?>
            <a href="javascript:submitAlphabetForm('0-9')" class="<?php echo $class1 ?>">0-9</a>
            <a href="javascript:submitAlphabetForm('A')" class="<?php echo $class2 ?>">A</a>
            <a href="javascript:submitAlphabetForm('B')" class="<?php echo $class3 ?>">B</a>
            <a href="javascript:submitAlphabetForm('C')" class="<?php echo $class4 ?>">C</a>
            <a href="javascript:submitAlphabetForm('D')" class="<?php echo $class5 ?>">D</a>
            <a href="javascript:submitAlphabetForm('E')" class="<?php echo $class6 ?>">E</a>

            <a href="javascript:submitAlphabetForm('F')" class="<?php echo $class7 ?>">F</a>
            <a href="javascript:submitAlphabetForm('G')" class="<?php echo $class8 ?>">G</a>
            <a href="javascript:submitAlphabetForm('H')" class="<?php echo $class9 ?>">H</a>
            <a href="javascript:submitAlphabetForm('I')" class="<?php echo $class10 ?>">I</a>
            <a href="javascript:submitAlphabetForm('J')" class="<?php echo $class11 ?>">J</a>
            <a href="javascript:submitAlphabetForm('K')" class="<?php echo $class12 ?>">K</a>

            <a href="javascript:submitAlphabetForm('L')" class="<?php echo $class13 ?>">L</a>
            <a href="javascript:submitAlphabetForm('M')" class="<?php echo $class14 ?>">M</a>
            <a href="javascript:submitAlphabetForm('N')" class="<?php echo $class15 ?>">N</a>
            <a href="javascript:submitAlphabetForm('O')" class="<?php echo $class16 ?>">O</a>
            <a href="javascript:submitAlphabetForm('P')" class="<?php echo $class17 ?>">P</a>
            <a href="javascript:submitAlphabetForm('Q')" class="<?php echo $class18 ?>">Q</a>

            <a href="javascript:submitAlphabetForm('R')" class="<?php echo $class19 ?>">R</a>
            <a href="javascript:submitAlphabetForm('S')" class="<?php echo $class20 ?>">S</a>
            <a href="javascript:submitAlphabetForm('T')" class="<?php echo $class21 ?>">T</a>
            <a href="javascript:submitAlphabetForm('U')" class="<?php echo $class22 ?>">U</a>
            <a href="javascript:submitAlphabetForm('V')" class="<?php echo $class23 ?>">V</a>
            <a href="javascript:submitAlphabetForm('W')" class="<?php echo $class24 ?>">W</a>

            <a href="javascript:submitAlphabetForm('X')" class="<?php echo $class25 ?>">X</a>
            <a href="javascript:submitAlphabetForm('Y')" class="<?php echo $class26 ?>">Y</a>
            <a href="javascript:submitAlphabetForm('Z')" class="<?php echo $class27 ?>">Z</a>
        </div>

        <!-- dealers list -->
        <!-- dealers list end -->
        <?php
    }

    /**
     * Contact & Comment form
     *
     * @param unknown_type $option
     */
    static function contactForm($formname)
    {
        global $jinput, $mainframe, $ismobile;
        $user = JFactory::getUser();
        //Random string
        $randomStr = md5(microtime()); // md5 to generate the random string
        $resultStr = substr($randomStr, 0, 5); //trim 5 digit
        ?>
        <script type="text/javascript">
            function submitForm(form_id) {
                var form = document.getElementById(form_id);
                var temp1, temp2;
                var cansubmit = 1;
                var require_field = form.require_field;
                require_field = require_field.value;
                var require_label = form.require_label;
                require_label = require_label.value;
                var require_fieldArr = require_field.split(",");
                var require_labelArr = require_label.split(",");
                for (i = 0; i < require_fieldArr.length; i++) {
                    temp1 = require_fieldArr[i];
                    temp2 = document.getElementById(temp1);
                    if (temp2 != null) {
                        if (temp2.value == "") {
                            alert(require_labelArr[i] + " <?php echo JText::_('OS_IS_MANDATORY_FIELD') ?>");
                            temp2.focus();
                            cansubmit = 0;
                            return false;
                        } else if (temp1 == "comment_security_code") {
                            var captcha_str = document.getElementById('captcha_str');
                            captcha_str = captcha_str.value;
                            if (captcha_str != temp2.value) {
                                alert(" <?php echo JText::_('OS_SECURITY_CODE_IS_WRONG') ?>");
                                temp2.focus();
                                cansubmit = 0;
                                return false;
                            }
                        }
                    }
                }
                if (cansubmit == 1) {
                    form.submit();
                }
            }
        </script>
        <?php
        //Random string
        $RandomStr = md5(microtime()); // md5 to generate the random string
        $ResultStr = substr($RandomStr, 0, 5); //trim 5 digit
        ?>
        <div style="margin: 0px">
            <div class="blue_middle"><?php echo JText::_('OS_FIELD_MARK'); ?> <span class="red">*</span> <?php echo JText::_('OS_ARE_REQUIRE'); ?></div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="clearfix"></div>
                    <div class="span3">
                        <?php echo JText::_('OS_AUTHOR'); ?> <span class="red">*</span>
                    </div><div class="span5">
                        <input type="text" id="comment_author" name="comment_author<?php echo date("j", time()); ?>" maxlength="50" class="input-large" value="<?php echo $user->name; ?>" />
                    </div>
                    <div class="clearfix"></div>
                    <div class="span3">
                        <?php echo JText::_('OS_AUTHOR_EMAIL'); ?> <span class="red">*</span>
                    </div><div class="span5">
                        <input type="text" id="comment_email" name="comment_email<?php echo date("j", time()); ?>" maxlength="50" class="input-large" value="<?php echo $user->email; ?>" />
                    </div>
                    <div class="clearfix"></div>
                    <div class="span3">
                        <?php echo JText::_('OS_TITLE'); ?> <span class="red">*</span>
                    </div><div class="span5">
                        <input type="text" id="comment_title"  name="comment_title" size="40" class="input-large" />
                    </div>
                    <div class="clearfix"></div>
                    <div class="span3">
                        <?php echo JText::_('OS_MESSAGE'); ?> <span class="red">*</span>
                    </div><div class="span5">
                        <textarea class="text" id="message" style="height:150px !important;" rows="6" cols="50" class="input-large" name="message"></textarea>
                        <div class="clearfix"></div>
                        <input id="message_counter" class="input-mini" type="text" readonly="" size="3" maxlength="3" style="font-weight: bold;text-align: center;width: 90px;"/>
                        <span style="font-size:11px;color:gray;"><?php echo JText::_('OS_CHARACTER_LEFT') ?></span>
                    </div>
                    <div class="clearfix"></div>
                    <div class="span3">
                        <?php echo JText::_('OS_SECURITY_CODE') ?> <span class="red">*</span>
                    </div><div class="span5">
                        <span class="grey_small" style="line-height:16px;"><?php echo JText::_('OS_PLEASE_INSERT_THE_SYMBOL_FROM_THE_INAGE_TO_FIELD_BELOW') ?></span>
                        <div class="clearfix"></div>
                        <img src="<?php echo JURI::root() ?>index.php?option=com_osproperty&no_html=1&task=property_captcha&ResultStr=<?php echo $ResultStr ?>">
                        <input type="text" class="input-mini" id="comment_security_code" name="comment_security_code" maxlength="5" style="width: 50px; margin: 0;" />

                    </div>
                    <div class="clearfix"></div>
                    <div class="span6">
                        <input onclick="javascript:submitForm('<?php echo $formname ?>')" style="margin: 0; width: 100px;" class="btn btn-info" type="button" name="finish" value="<?php echo JText::_("OS_SUBMIT") ?>" />
                        <span id="comment_loading" class="reg_loading">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="captcha_str" id="captcha_str" value="<?php echo $ResultStr ?>">
        <input type="hidden" name="require_field" id="require_field" value="comment_author,comment_email,comment_title,comment_message,comment_security_code">
        <input type="hidden" name="require_label" id="require_label" value="<?php echo JText::_('OS_AUTHOR'); ?>,<?php echo JText::_('OS_AUTHOR_EMAIL') ?>,<?php echo JText::_('OS_TITLE'); ?>,<?php echo JText::_('Message'); ?>,<?php echo JText::_('OS_MESSAGE'); ?>">
        <script type="text/javascript">
            var comment_textcounter = new textcounter({
                textarea: 'message',
                min: 0,
                max: 300
            });
            comment_textcounter.init();
        </script>
        <?php
    }

    function getDeliciousButton($title, $link)
    {
        $img_url = JURI::base() . "/components/com_osproperty/images/assets/socials/delicious.png";
        return '<a href="http://del.icio.us/post?url=' . rawurlencode($link) . '&amp;title=' . rawurlencode($title) . '" title="Submit ' . $title . ' in Delicious" target="blank" >
		<img src="' . $img_url . '" alt="Submit ' . $title . ' in Delicious" />
		</a>';
    }

    function getDiggButton($title, $link)
    {
        $img_url = JURI::base() . "/components/com_osproperty/images/assets/socials/digg.png";
        return '<a href="http://digg.com/submit?url=' . rawurlencode($link) . '&amp;title=' . rawurlencode($title) . '" title="Submit ' . $title . ' in Digg" target="blank" >
        <img src="' . $img_url . '" alt="Submit ' . $title . ' in Digg" />
        </a>';
    }

    function getFacebookButton($title, $link)
    {
        $img_url = JURI::base() . "/components/com_osproperty/images/assets/socials/facebook.png";
        return '<a href="http://www.facebook.com/sharer.php?u=' . rawurlencode($link) . '" title="Submit ' . $title . ' in FaceBook" target="blank" >
        <img src="' . $img_url . '" alt="Submit ' . $title . ' in FaceBook" />
        </a>';
    }

    function getGoogleButton($title, $link)
    {
        $img_url = JURI::base() . "/components/com_osproperty/images/assets/socials/google.png";
        return '<a href="http://www.google.com/bookmarks/mark?op=edit&bkmk=' . rawurlencode($link) . '" title="Submit ' . $title . ' in Google Bookmarks" target="blank" >
        <img src="' . $img_url . '" alt="Submit ' . $title . ' in Google Bookmarks" />
        </a>';
    }

    function getStumbleuponButton($title, $link)
    {
        $img_url = JURI::base() . "/components/com_osproperty/images/assets/socials/stumbleupon.png";
        return '<a href="http://www.stumbleupon.com/submit?url=' . rawurlencode($link) . '&amp;title=' . rawurlencode($title) . '" title="Submit ' . $title . ' in Stumbleupon" target="blank" >
        <img src="' . $img_url . '" alt="Submit ' . $title . ' in Stumbleupon" />
        </a>';
    }

    function getTechnoratiButton($title, $link)
    {
        $img_url = JURI::base() . "/components/com_osproperty/images/assets/socials/technorati.png";
        return '<a href="http://technorati.com/faves?add=' . rawurlencode($link) . '" title="Submit ' . $title . ' in Technorati" target="blank" >
        <img src="' . $img_url . '" alt="Submit ' . $title . ' in Technorati" />
        </a>';
    }

    function getTwitterButton($title, $link)
    {
        $img_url = JURI::base() . "/components/com_osproperty/images/assets/socials/twitter.png";
        return '<a href="http://twitter.com/?status=' . rawurlencode($title . " " . $link) . '" title="Submit ' . $title . ' in Twitter" target="blank" >
        <img src="' . $img_url . '" alt="Submit ' . $title . ' in Twitter" />
        </a>';
    }

    /**
     * Download pdf file
     *
     * @param unknown_type $filelink
     */
    static function downloadfile($filelink)
    {
        while (@ob_end_clean());
        define('ALLOWED_REFERRER', '');
        // MUST end with slash (i.e. "/" )
        define('BASE_DIR', JPATH_ROOT . DS . "tmp");

        // log downloads? true/false
        define('LOG_DOWNLOADS', false);

        // log file name
        define('LOG_FILE', 'downloads.log');

        // Allowed extensions list in format 'extension' => 'mime type'
        // If myme type is set to empty string then script will try to detect mime type
        // itself, which would only work if you have Mimetype or Fileinfo extensions
        // installed on server.
        $allowed_ext = array(
            // archives
            'zip' => 'application/zip',
            // documents
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            // executables
            'exe' => 'application/octet-stream',
            // images
            'gif' => 'image/gif',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            // audio
            'mp3' => 'audio/mpeg',
            'wav' => 'audio/x-wav',
            // video
            'mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg',
            'mpe' => 'video/mpeg',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo'
        );

        ################################################## ##################
        ### DO NOT CHANGE BELOW
        ################################################## ##################
        // If hotlinking not allowed then make hackers think there are some server problems
        if (ALLOWED_REFERRER !== '' && (!isset($_SERVER['HTTP_REFERER']) || strpos(strtoupper($_SERVER['HTTP_REFERER']), strtoupper(ALLOWED_REFERRER)) === false)
        )
        {
            die(JText::_("Internal server error. Please contact system administrator."));
        }

        // Make sure program execution doesn't time out
        // Set maximum script execution time in seconds (0 means no limit)
        //set_time_limit(0);

        if (!isset($filelink))
        {
            die(JText::_("Please specify file name for download."));
        }

        // Get real file name.
        // Remove any path info to avoid hacking by adding relative path, etc.
        $fname = basename($filelink);

        // Check if the file exists
        // Check in subfolders too
        function find_file($dirname, $fname, &$file_path)
        {
            $dir = opendir($dirname);
            while ($file = readdir($dir))
            {
                if (empty($file_path) && $file != '.' && $file != '..')
                {
                    if (is_dir($dirname . '/' . $file))
                    {
                        find_file($dirname . '/' . $file, $fname, $file_path);
                    } else
                    {
                        if (file_exists($dirname . '/' . $fname))
                        {
                            $file_path = $dirname . '/' . $fname;
                            return;
                        }
                    }
                }
            }//end while
        }

// find_file
        // get full file path (including subfolders)
        $file_path = '';
        find_file(BASE_DIR, $fname, $file_path);

        if (!is_file($file_path))
        {
            die(JText::_("File does not exist. Make sure you specified correct file name."));
        }

        // file size in bytes
        $fsize = filesize($file_path);

        // file extension
        $fext = strtolower(substr(strrchr($fname, "."), 1));

        // check if allowed extension
        if (!array_key_exists($fext, $allowed_ext))
        {
            die(JText::_("Not allowed file type."));
        }

        // get mime type
        if ($allowed_ext[$fext] == '')
        {
            $mtype = '';
            // mime type is not set, get from server settings
            if (function_exists('mime_content_type'))
            {
                $mtype = mime_content_type($file_path);
            } else if (function_exists('finfo_file'))
            {
                $finfo = finfo_open(FILEINFO_MIME); // return mime type
                $mtype = finfo_file($finfo, $file_path);
                finfo_close($finfo);
            }
            if ($mtype == '')
            {
                $mtype = "application/force-download";
            }
        } else
        {
            // get mime type defined by admin
            $mtype = $allowed_ext[$fext];
        }

        // Browser will try to save file with this filename, regardless original filename.
        // You can override it if needed.


        $asfname = $fname;

        // set headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: $mtype");
        header("Content-Disposition: attachment; filename=\"$asfname\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $fsize);


        if (!ini_get('safe_mode'))
        { // set_time_limit doesn't work in safe mode
            @set_time_limit(0);
        }

        HelperOspropertyCommon::readfile_chunked($file_path);
        exit();
    }

    function downloadfile1($file_path, $id)
    {
        while (@ob_end_clean());
        $len = @ filesize($file_path);
        $cont_dis = 'attachment';

        // required for IE, otherwise Content-disposition is ignored
        if (ini_get('zlib.output_compression'))
        {
            ini_set('zlib.output_compression', 'Off');
        }

        header("Pragma: public");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Expires: 0");

        header("Content-Transfer-Encoding: binary");
        header('Content-Disposition:' . $cont_dis . ';'
                . ' filename="property' . $id . '.pdf";'
                . ' size=' . $len . ';'
        ); //RFC2183
        header("Content-Type: application/pdf");   // MIME type
        header("Content-Length: " . $len);

        if (!ini_get('safe_mode'))
        { // set_time_limit doesn't work in safe mode
            @set_time_limit(0);
        }
        HelperOspropertyCommon::readfile_chunked($file_path);
        exit();
    }

    function downloadfile2($file_path, $id)
    {
        while (@ob_end_clean());
        $len = @ filesize($file_path);
        $cont_dis = 'attachment';

        // required for IE, otherwise Content-disposition is ignored
        if (ini_get('zlib.output_compression'))
        {
            ini_set('zlib.output_compression', 'Off');
        }

        header("Pragma: public");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Expires: 0");

        header("Content-Transfer-Encoding: binary");
        header('Content-Disposition:' . $cont_dis . ';'
                . ' filename="csv' . $id . '.csv";'
                . ' size=' . $len . ';'
        ); //RFC2183
        header("Content-Length: " . $len);

        if (!ini_get('safe_mode'))
        { // set_time_limit doesn't work in safe mode
            @set_time_limit(0);
        }
        HelperOspropertyCommon::readfile_chunked($file_path);
        exit();
    }

    function readfile_chunked($filename, $retbytes = true)
    {
        $chunksize = 1 * (1024 * 1024); // how many bytes per chunk
        $buffer = '';
        $cnt = 0;
        $handle = fopen($filename, 'rb');
        if ($handle === false)
        {
            return false;
        }
        while (!feof($handle))
        {
            $buffer = fread($handle, $chunksize);
            echo $buffer;
            @ob_flush();
            flush();
            if ($retbytes)
            {
                $cnt += strlen($buffer);
            }
        }
        $status = fclose($handle);
        if ($retbytes && $status)
        {
            return $cnt; // return num. bytes delivered like readfile() does.
        }
        return $status;
    }

    /**
     * Load Approval information
     *
     * @param unknown_type $id
     * @return unknown
     */
    function loadApprovalInfo($id)
    {
        global $jinput, $mainframe, $configClass;
        $db = JFactory::getDbo();
        $db->setQuery("Select * from #__osrs_properties where id = '$id'");
        $property = $db->loadObject();
        $db->setQuery("Select * from #__osrs_expired where pid = '$id'");
        $expired = $db->loadObject();
        $current_time = self::getRealTime();
        $expired_time = strtotime($expired->expired_time);
        $html = "" . JText::_('OS_STATUS') . ": <strong>";
        if ($configClass['general_use_expiration_management'] == 1)
        { //allow to update expired ?
            if ($expired_time < $current_time)
            {
                OspropertyListing::unApproved($id);
            }
        }
        if (($expired_time < $current_time) or ( $property->approved == 0))
        {

            $html .= "<span color='red'>" . JText::_('Unapproved') . "</span>";
            if ($property->request_to_approval == 1)
            {
                $html .= "<BR><span color='blue' style='font-size:11px;'><i>(";
                $html .= JText::_('OS_REQUEST_APPROVAL');
                $html .= ")</i></span>";
            }
            $html .= "</strong>";
        } else
        {
            $html .= "<span color='green'>" . JText::_('OS_APPROVED') . "</span>";
            $html .= "</strong>";
            if ($configClass['general_use_expiration_management'] == 1)
            { //allow to update expired ?
                $html .= "<BR>";
                $html .= JText::_('OS_EXPIRED_ON') . ": ";
                $html .= HelperOspropertyCommon::loadTime($expired->expired_time, 2);
            }
        }

        return $html;
    }

    function loadFeatureInfo($id)
    {
        global $jinput, $mainframe, $configClass;
        $db = JFactory::getDbo();
        $db->setQuery("Select * from #__osrs_properties where id = '$id'");
        $property = $db->loadObject();
        $db->setQuery("Select * from #__osrs_expired where pid = '$id'");
        $expired = $db->loadObject();
        $current_time = self::getRealTime();
        $expired_time = strtotime($expired->expired_feature_time);
        $html = "" . JText::_('OS_STATUS') . ": <strong>";
        if ($configClass['general_use_expiration_management'] == 1)
        { //allow to update expired ?
            if ($expired_time < $current_time)
            {
                OspropertyListing::unFeatured($id);
            }
        }
        if (($expired_time < $current_time) or ( $property->isFeatured == 0))
        {

            $html .= "<span color='red'>" . JText::_('OS_IS_NOT_FEATURED') . "</span>";
            $html .= "</strong>";
        } else
        {
            $html .= "<span color='green'>" . JText::_('OS_FEATURED') . "</span>";
            $html .= "</strong>";
            if ($configClass['general_use_expiration_management'] == 1)
            { //allow to update expired ?
                $html .= "<BR>";
                $html .= JText::_('OS_EXPIRED_ON') . ": ";
                $html .= HelperOspropertyCommon::loadTime($expired->expired_feature_time, 2);
            }
        }
        return $html;
    }

    /**
     * Build toolbar
     *
     * @param unknown_type $view
     * @param unknown_type $extras
     * @return unknown
     */
    public static function buildToolbar($view = '')
    {
        global $jinput, $mainframe, $configClass, $ismobile;
    }

    public static function getNeiborHood($id)
    {
        static $ar;
        if (!$ar)
        {
            $ar = array();
            $db = JFactory::getDbo();
            $query = "Select a.*,b.neighborhood from #__osrs_neighborhood as a"
                    . " inner join #__osrs_neighborhoodname as b on b.id = a.neighbor_id"
                    . ' where a.pid = ' . $id . '';
            $db->setQuery($query);
            $ar[$id] = $db->loadObjectList();
            return $ar[$id];
        } else
        {
            if (is_array($ar))
            {
                if (isset($ar[$id]))
                {
                    return $ar[$id];
                } else
                {
                    $db = JFactory::getDbo();
                    $query = "Select a.*,b.neighborhood from #__osrs_neighborhood as a"
                            . " inner join #__osrs_neighborhoodname as b on b.id = a.neighbor_id"
                            . ' where a.pid = ' . $id . '';
                    $db->setQuery($query);
                    $ar[$id] = $db->loadObjectList();
                    return $ar[$id];
                }
            }
        }
    }

    static function loadNeighborHood1($pid)
    {
        $rows = self::getNeiborHood($pid);

        if (count($rows) > 0)
        {
            ?>
            <div class="row-fluid">
                <div class="span12">
                    <?php
                    for ($i = 0; $i < count($rows); $i++)
                    {
                        $row = $rows[$i];
                        ?>
                        <strong><?php echo JText::_($row->neighborhood) ?></strong>&nbsp; <?php echo $row->mins > 0 ? $row->mins . " " . JText::_('OS_MINS') . " " : " "; ?> <?php echo JText::_('OS_BY') ?> &nbsp;
                        <?php
                        switch ($row->traffic_type)
                        {
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
                        echo ",  ";
                        ?>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    }

    static function loadNeighborHood($pid)
    {
        $rows = self::getNeiborHood($pid);
        $k = 0;
        if (count($rows) > 0)
        {
            for ($i = 0; $i < count($rows); $i++)
            {
                $k++;
                $row = $rows[$i];
                echo "<div class='span6'><i class='osicon-ok'></i> " . JText::_($row->neighborhood) . " ";
                echo $row->mins > 0 ? $row->mins . " " . JText::_('OS_MINS') . " " : " ";
                echo JText::_('OS_BY') . " ";
                switch ($row->traffic_type)
                {
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
                echo "</div>";
                if ($k == 2)
                {
                    $k = 0;
                    echo "</div><div class='row-fluid'>";
                }
            }
        }
    }

    static function checkSpecial()
    {
        global $jinput, $mainframe;
        ;
        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        $specialArr = array("Super Users", "Super Administrator", "Administrator", "Manager");
        if ($_jversion == "1.5")
        {
            if (in_array($user->usertype, $specialArr))
            {
                return true;
            } else
            {
                return false;
            }
        } else
        {
            $db->setQuery("Select b.title from #__user_usergroup_map as a inner join #__usergroups as b on b.id = a.group_id where a.user_id = '$user->id'");
            $usertype = $db->loadResult();
            if (in_array($usertype, $specialArr))
            {
                return true;
            } else
            {
                return false;
            }
        }
    }

    /**
     * Show the currency Select list
     *
     * @param unknown_type $curr
     */
    static function showCurrencySelectList($curr)
    {
        global $jinput, $mainframe, $configClass;
        $db = JFactory::getDbo();
        $db->setQuery("Select id as value, concat(currency_name,' - ',currency_code,' - ',currency_symbol) as text from #__osrs_currencies where published = '1' order by currency_name");
        $currencies = $db->loadObjectList();
        if (intval($curr) == 0)
        {
            $curr = $configClass['general_currency_default'];
        }
        echo JHtml::_('select.genericlist', $currencies, 'curr', 'class="input-large chosen"', 'value', 'text', $curr);
    }

    /**
     * Load currency
     *
     * @param unknown_type $curr
     */
    

    public static function loadCurrency($curr)
    {
        global $jinput, $mainframe, $configClass;
        $configClass = OSPHelper::loadConfig();

        $currensies = OSPHelper::loadAllCurrencies();
        $db = Jfactory::getDBO();
        if (intval($curr) == 0)
        {
            $curr = $configClass['general_currency_default'];
            //$db->setQuery("Select fieldvalue from #__osrs_configuration where fieldname like 'general_currency_default'");
            //$curr = $db->loadResult();
        }
        $db = JFactory::getDbo();

//        $db->setQuery("Select currency_symbol from #__osrs_currencies where id = '$curr'");
//
//                  
//        $curr = $db->loadResult();
        $key1 = new stdClass;
        $key1->key = 'id';
        $key1->value = $curr;
        $key1->condition = '=';
        $city = HelperOspropertyFields::filterArray($currensies, array($key1));

        usort($city, function()
        {
            return true;
        });
        $city_name = $city[0]->{'currency_symbol'};
        $curr = str_replace("\r", "", $city_name);
        $curr = str_replace("\n", "", $curr);


        return $curr;
    }

    public static function loadDefaultCurrency($symbol)
    {
        global $jinput, $configClass;
        static $default_currency;
        $configClass = OSPHelper::loadConfig();
        $db = JFactory::getDbo();
        $curr = $configClass['general_currency_default'];

        if ($default_currency == "")
        {
            $db->setQuery("Select currency_code from #__osrs_currencies where id = '$curr'");
            $default_currency = $db->loadResult();
        }

        return $default_currency;
    }

    static function checkMembershipIsAvailable()
    {
        global $jinput, $configClass;
        $user = JFactory::getUser();
        $db = JFactory::getDbo();
        include_once(JPATH_ROOT . "/components/com_osmembership/helper/helper.php");
        $available_plan_of_agent = OSMembershipHelper::getActiveMembershipPlans($user->id);
        if (count($available_plan_of_agent) == 1)
        {
            return false;
        } else
        {
            if (self::isAgent())
            {
                $db->setQuery("Select id from #__osrs_agents where user_id = '$user->id' ");
                $agent_id = $db->loadResult();
                $db->setQuery("Select count(id) from #__osrs_agent_account where agent_id ='$agent_id' and `status` = '1' and nproperties > 0");
            } elseif (self::isCompanyAdmin())
            {
                $db->setQuery("Select id from #__osrs_companies where user_id = '$user->id' ");
                $company_id = $db->loadResult();
                $db->setQuery("Select count(id) from #__osrs_agent_account where company_id ='$company_id' and `status` = '1' and nproperties > 0");
            }
            $count = $db->loadResult();
            if ($count == 0)
            {
                return false;
            } else
            {
                return true;
            }
        }
    }

    static function returnAccountValue()
    {
        global $jinput, $configClass;
        $user = JFactory::getUser();
        $db = JFactory::getDbo();

        include_once(JPATH_ROOT . "/components/com_osmembership/helper/helper.php");
        $available_plan_of_agent = OSMembershipHelper::getActiveMembershipPlans($user->id);
        $rows = array();
        if (count($available_plan_of_agent) > 1)
        {
            $available_plan_of_agent = implode(",", $available_plan_of_agent);
            //get from account table
            if (self::isAgent())
            {
                $db->setQuery("Select id from #__osrs_agents where user_id = '$user->id'");
                $agent_id = $db->loadResult();
                $query = "SELECT a.*,c.title,b.from_date,b.to_date FROM #__osrs_agent_account AS a INNER JOIN #__osmembership_subscribers AS b ON b.id = a.sub_id INNER JOIN #__osmembership_plans AS c ON c.id = b.plan_id WHERE a.agent_id = '$agent_id' AND a.status = '1' AND b.plan_id IN ($available_plan_of_agent) AND a.nproperties > 0";
            } elseif (self::isCompanyAdmin())
            {
                $db->setQuery("Select id from #__osrs_companies where user_id = '$user->id'");
                $company_id = $db->loadResult();
                $query = "SELECT a.*,c.title,b.from_date,b.to_date FROM #__osrs_agent_account AS a INNER JOIN #__osmembership_subscribers AS b ON b.id = a.sub_id INNER JOIN #__osmembership_plans AS c ON c.id = b.plan_id WHERE a.company_id = '$company_id' AND a.status = '1' AND b.plan_id IN ($available_plan_of_agent) AND a.nproperties > 0";
            }
            //if(!$loadnormalproperties){
            //	$query .= " AND a.type = '1'";
            //}
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (count($rows) > 0)
            {
                for ($i = 0; $i < count($rows); $i++)
                {
                    $row = $rows[$i];
                    if ($row->type == 0)
                    { //normal properties
                        $start_time = self::getRealTime();
                        //$row->expired = self::getExpiredNormal($start_time,1);
                    } elseif ($row->type == 1)
                    {
                        $start_time = self::getRealTime();
                        //$row->expired = self::getExpiredFeature($start_time,1);
                    }
                }
            }
        }
        return $rows;
    }

    //return type 0 -> date
    //return type 1 -> int
    public static function getExpiredNormal($start_time, $return_type)
    {
        global $jinput, $mainframe, $configClass;
        $number_days = $configClass['general_time_in_days'];
        $stop_time = $start_time + $number_days * 24 * 3600;
        if ($return_type == 0)
        {
            return date("Y-m-d H:i:s", $stop_time);
        } else
        {
            return $stop_time;
        }
    }

    //return type 0 -> date
    //return type 1 -> int
    function getExpiredFeature($start_time, $return_type)
    {
        global $jinput, $mainframe, $configClass;
        $number_days = $configClass['general_time_in_days_featured'];
        $stop_time = $start_time + $number_days * 24 * 3600;
        if ($return_type == 0)
        {
            return date("Y-m-d H:i:s", $stop_time);
        } else
        {
            return $stop_time;
        }
    }

    /**
     * Set approval and isFeature from jos_osrs_properties table
     *
     * @param unknown_type $type
     * @param unknown_type $id
     */
    function setApproval($type, $id)
    {
        global $jinput, $mainframe;
        $db = JFactory::getDbo();
        if ($type == "f")
        {
            $db->setQuery("UPDATE #__osrs_properties SET isFeatured = '1',approved = '1',published = '1' WHERE id = '$id'");
            $db->query();
        } else
        {
            $db->setQuery("UPDATE #__osrs_properties SET approved = '1',published = '1' WHERE id = '$id'");
            $db->query();
        }
    }

    public static function getRealTime()
    {
        $config = new JConfig();
        $offset = $config->offset;
        return strtotime(JFactory::getDate('now', $offset));
    }

    /**
     * Set Expired
     *
     * @param unknown_type $id
     * @param unknown_type $type
     * @param unknown_type $isNew
     */
    function setExpiredTime($id, $type, $isNew)
    {
        global $jinput, $mainframe, $configs, $configClass;
        $db = JFactory::getDbo();
        $current_time = self::getRealTime();
        $db->setQuery("Select count(id) from #__osrs_expired where pid = '$id'");
        $count = $db->loadResult();
        if ($count == 0)
        {
            //check and calculate the expired and clean db time
            $unpublish_time = intval($configClass['general_time_in_days']);
            $remove_time = intval($configClass['general_unpublished_days']);
            $feature_time = intval($configClass['general_time_in_days_featured']);
            if ($type == "f")
            {
                $unpublish_time = $feature_time;
                //calculate the unfeature time
                $feature_time = $current_time + $feature_time * 24 * 3600;
            }
            $send_appro = $configClass['send_approximates'];
            $appro_days = $configClass['approximates_days'];

            $unpublish_time = $current_time + $unpublish_time * 24 * 3600;
            //calculate remove time
            $remove_time = $unpublish_time + $remove_time * 24 * 3600;

            //allow to send the approximates expired day
            if ($send_appro == 1)
            {
                $inform_time = $unpublish_time - $appro_days * 24 * 3600;
                $inform_time = date("Y-m-d H:i:s", $inform_time);
            } else
            {
                $inform_time = "";
            }
            //change to time stamp
            $unpublish_time = date("Y-m-d H:i:s", $unpublish_time);
            $remove_time = date("Y-m-d H:i:s", $remove_time);
            $feature_time = date("Y-m-d H:i:s", $feature_time);
            //insert into #__osrs_expired
            $db->setQuery("Insert into #__osrs_expired (id,pid,inform_time,expired_time,expired_feature_time,remove_from_database) values (NULL,$id,'$inform_time','$unpublish_time','$feature_time','$remove_time')");
            $db->query();
            //update start publishing today
            OspropertyListing::updateStartPublishing($id);
        } else
        {
            //in the case this property is already in the expired table
            //check and calculate the expired and clean db time
            $unpublish_time = intval($configClass['general_time_in_days']);
            $remove_time = intval($configClass['general_unpublished_days']);
            $feature_time = intval($configClass['general_time_in_days_featured']);
            $send_appro = $configClass['send_approximates'];
            $appro_days = $configClass['approximates_days'];

            $db->setQuery("Select * from #__osrs_expired where pid = '$id'");
            $expired = $db->loadObject();
            $expired_time = $expired->expired_time;
            $expired_feature_time = $expired->expired_feature_time;
            $expired_time_int = strtotime($expired_time);
            $expired_feature_int = strtotime($expired_feature_time);

            if ($type == "f")
            {
                if ($expired_feature_int > $current_time)
                {
                    $current_time = $expired_feature_int;
                }
                $unpublish_time = $feature_time;
                //calculate the unfeature time
                $feature_time = $current_time + $feature_time * 24 * 3600;
            }

            if ($type == "n")
            {
                if ($expired_time_int > $current_time)
                {
                    $current_time = $expired_time_int;
                }
            }

            $unpublish_time = $current_time + $unpublish_time * 24 * 3600;
            if ($unpublish_time < $expired_time_int)
            {
                $unpublish_time = $expired_time_int;
            }
            //calculate remove time
            $remove_time = $unpublish_time + $remove_time * 24 * 3600;
            //allow to send the approximates expired day
            if ($send_appro == 1)
            {
                $inform_time = $unpublish_time - $appro_days * 24 * 3600;
                $inform_time = date("Y-m-d H:i:s", $inform_time);
            } else
            {
                $inform_time = "";
            }
            //change to time stamp
            $unpublish_time = date("Y-m-d H:i:s", $unpublish_time);
            $remove_time = date("Y-m-d H:i:s", $remove_time);
            $feature_time = date("Y-m-d H:i:s", $feature_time);
            //insert into #__osrs_expired
            $db->setQuery("UPDATE #__osrs_expired SET inform_time = '$inform_time',expired_time='$unpublish_time',expired_feature_time = '$feature_time',remove_from_database='$remove_time' WHERE pid = '$id'");
            $db->query();
            //update start publishing today
            OspropertyListing::updateStartPublishing($id);
        }
    }

    /**
     * Discount subscription
     *
     * @param unknown_type $type
     */
    function discountSubscription($sub_id)
    {
        global $jinput, $mainframe;
        $user = JFactory::getUser();
        $db = JFactory::getDbo();
        if (self::isAgent())
        {
            $db->setQuery("Select id from #__osrs_agents where user_id = '$user->id'");
            $agent_id = $db->loadResult();
            $db->setQuery("Select count(id) from #__osrs_agent_account where agent_id = '$agent_id'");
            $count = $db->loadResult();
            if ($count > 0)
            {
                $db->setQuery("UPDATE #__osrs_agent_account SET nproperties = nproperties - 1 WHERE agent_id = '$agent_id' and sub_id = '$sub_id'");
                $db->query();
            }
        } elseif (self::isCompanyAdmin())
        {
            $db->setQuery("Select id from #__osrs_companies where user_id = '$user->id'");
            $company_id = $db->loadResult();
            $db->setQuery("Select count(id) from #__osrs_agent_account where company_id = '$company_id'");
            $count = $db->loadResult();
            if ($count > 0)
            {
                $db->setQuery("UPDATE #__osrs_agent_account SET nproperties = nproperties - 1 WHERE company_id = '$company_id' and sub_id = '$sub_id'");
                $db->query();
            }
        }
    }

    /**
     * Slimbox Gallery
     *
     * @param unknown_type $pid
     * @param unknown_type $photos
     */
    static function slimboxGallery($pid, $photos)
    {
        global $jinput, $mainframe, $configClass;
        $property_photo_link = JURI::root() . "images/osproperty/properties/" . $pid . "/";
        ?>
        <script type="text/javascript" src="<?php echo JUri::root() ?>components/com_osproperty/js/colorbox/jquery.colorbox.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery(".propertyphotogroupgallery").colorbox({rel: 'colorboxgallery', maxWidth: '95%', maxHeight: '95%'});
            });
        </script>
        <div class="row-fluid">
            <?php
            $k = 0;
            for ($i = 0; $i < count($photos); $i++)
            {

                $photo = $photos[$i];
                $title = $photo->image_desc;
                $title = str_replace("\n", "", $title);
                $title = str_replace("\r", "", $title);
                $title = str_replace("'", "\'", $title);

                if (file_exists(JPATH_ROOT . "/images/osproperty/properties/" . $pid . "/thumb/" . $photos[$i]->image))
                {

                    $k++;
                    ?>
                    <div class="span3">
                        <a href="<?php echo $property_photo_link ?><?php echo $photos[$i]->image ?>" class="propertyphotogroupgallery" title="<?php echo $title; ?>" >
                            <img src="<?php echo $property_photo_link ?>thumb/<?php echo $photos[$i]->image ?>" style="border:1px solid #CCC!important;padding:3px !important;" />
                        </a>
                    </div>
                    <?php
                }

                if ($k == 4)
                {
                    ?>
                </div>
                <div class="row-fluid">
                    <?php
                    $k = 0;
                }
            }
            ?>
        </div>
        <?php
    }

    /**
     * Show photo gallery of properties
     *
     * @param unknown_type $pid
     * @param unknown_type $photos
     */
    static function propertyGallery($property, $photos)
    {
        global $jinput, $mainframe, $configClass, $ismobile;
        JHTML::_('behavior.modal', 'a.osmodal');
        $document = JFactory::getDocument();
        $pid = $property->id;
        $property_photo_link = JURI::root() . "images/osproperty/properties/" . $pid . "/";
        ?>
        <script type="text/javascript" src="<?php echo JUri::root() ?>components/com_osproperty/js/colorbox/jquery.colorbox.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery(".propertyphotogroup1").colorbox({rel: 'colorbox', maxWidth: '95%', maxHeight: '95%'});
            });
        </script>
        <div class="row-fluid">
            <?php
            if (count($photos) > 0)
            {
                ?>
                <div class="span12">
                    <div style="display:block;position: relative; width: 100%;" id="img0">
                        <a href="<?php echo $property_photo_link ?><?php echo $photos[0]->image ?>" class="propertyphotogroup1" title="<?php echo $photos[0]->image_desc; ?>">
                            <img src="<?php echo $property_photo_link ?><?php echo $photos[0]->image ?>" class="img-polaroid">
                            <?php
                            if ($photos[0]->image_desc != "")
                            {
                                ?>
                                <h2 style="color:white;font-size:12px;position: absolute; top: 0px; left: 5px;opacity:0.4;filter:alpha(opacity=40); background-color:#000;font-weight:normal;padding:10px;">
                                    <?php
                                    echo $photos[0]->image_desc;
                                    ?>
                                </h2>
                            <?php } ?>
                        </a>
                    </div>
                    <?php
                    for ($i = 1; $i < count($photos); $i++)
                    {
                        $photo = $photos[$i];
                        ?>
                        <div style="display:none;position: relative; width: 100%;" id="img<?php echo $i ?>">
                            <a href="<?php echo $property_photo_link ?><?php echo $photos[$i]->image ?>" class="propertyphotogroup1">
                                <img src="<?php echo $property_photo_link ?><?php echo $photos[$i]->image ?>" class="img-polaroid" title="<?php echo $photos[$i]->image_desc; ?>">
                                <?php
                                if ($photos[$i]->image_desc != "")
                                {
                                    ?>
                                    <h2 style="color:white;font-size:12px;position: absolute; top: 0px; left: 5px;opacity:0.4;filter:alpha(opacity=40); background-color:#000;font-weight:normal;padding:10px;">
                                        <?php
                                        echo $photos[$i]->image_desc;
                                        ?>
                                    </h2>
                                <?php } ?>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="clearfix"></div>
                <div class="span12" id="thumbPhotos_wrap" style="margin-left:0px;">
                    <div id="thumbPhotos" style="white-space: nowrap;width: 100%;height: auto;overflow:auto;">
                        <?php
                        for ($i = 0; $i < count($photos); $i++)
                        {
                            $photo = $photos[$i];
                            if ($photo->image != "")
                            {
                                if (file_exists(JPATH_ROOT . DS . "images" . DS . "osproperty" . DS . "properties" . DS . $pid . DS . "thumb" . DS . $photos[$i]->image))
                                {
                                    ?>
                                    <div style="border:1px solid #efefef;padding:1px;margin:1px;width:45px; display: inline-block;cursor:pointer;white-space: nowrap;">
                                        <img src="<?php echo $property_photo_link ?>thumb/<?php echo $photos[$i]->image ?>" width="45" id="thumb<?php echo $i ?>">
                                    </div>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function () {
                                            jQuery("#thumb<?php echo $i ?>").hover(function () {
                                                jQuery(this).stop().animate({opacity: "0.5"}, 'fast');
                                            },
                                                    function () {
                                                        jQuery(this).stop().animate({opacity: "1"}, 'fast');
                                                    });
                                        });
                                    </script>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php
            } else
            {
                ?>
                <img src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/nopropertyphoto.png" />
                <?php
            }
            ?>
        </div>
        <script type="text/javascript">
            function showImage(id) {
                var current_image = document.getElementById('current_image');
                cimage = current_image.value;
                var img = document.getElementById('img' + cimage);
                img.style.display = "none";
                current_image.value = id;
                var img = document.getElementById('img' + id);
                img.style.display = "block";
            }
        </script>
        <?php
    }

    /**
     * Get conversion
     *
     * @param unknown_type $cur_from
     * @param unknown_type $cur_to
     * @return unknown
     */
    function get_conversion($cur_from, $cur_to)
    {
        if (strlen($cur_from) == 0)
        {
            $cur_from = "USD";
        }
        if (strlen($cur_to) == 0)
        {
            $cur_from = "PHP";
        }
        $host = "download.finance.yahoo.com";
        $fp = @fsockopen($host, 80, $errno, $errstr, 30);
        if (!$fp)
        {
            $errorstr = "$errstr ($errno)<br />\n";
            return false;
        } else
        {
            $file = "/d/quotes.csv";
            $str = "?s=" . $cur_from . $cur_to . "=X&f=sl1d1t1ba&e=.csv";
            $out = "GET " . $file . $str . " HTTP/1.0\r\n";
            $out .= "Host: download.finance.yahoo.com\r\n";
            $out .= "Connection: Close\r\n\r\n";
            @fputs($fp, $out);
            while (!@feof($fp))
            {
                $data .= @fgets($fp, 128);
            }
            @fclose($fp);
            @preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $data, $match);
            $data = $match[2];
            $search = array("'<script[^>]*?>.*?</script>'si", "'<[\/\!]*?[^<>]*?>'si", "'([\r\n])[\s]+'", "'&(quot|#34);'i", "'&(amp|#38);'i", "'&(lt|#60);'i", "'&(gt|#62);'i", "'&(nbsp|#160);'i", "'&(iexcl|#161);'i", "'&(cent|#162);'i", "'&(pound|#163);'i", "'&(copy|#169);'i", "'&#(\d+);'e");
            $replace = array("", "", "\\1", "\"", "&", "<", ">", " ", chr(161), chr(162), chr(163), chr(169), "chr(\\1)");
            $data = @preg_replace($search, $replace, $data);
            $result = explode(",", $data);
            return $result[1];
        }//else
    }

//end get_conversion

    /**
     * Get Categories list
     *
     * @param unknown_type $catid
     */
    static function getCategoryParent($catid, & $categoryArr)
    {
        global $jinput, $mainframe;
        $categoryArr[count($categoryArr)] = $catid;
        $db = JFactory::getDbo();
        $db->setQuery("Select parent_id from #__osrs_categories where id = '$catid' and published = '1'");
        $parent_id = $db->loadResult();
        if ($parent_id > 0)
        {
            $categoryArr = HelperOspropertyCommon::getCategoryParent($parent_id, $categoryArr);
        }
        return $categoryArr;
    }

    /**
     * Get the list of categories
     *
     * @param unknown_type $catid
     * @param unknown_type $categoryArr
     */
    static function getSubCategories($catid, & $categoryArr)
    {
        global $jinput, $mainframe;
        $categoryArr[count($categoryArr)] = $catid;
        $db = JFactory::getDbo();
        $db->setQuery("Select id from #__osrs_categories where parent_id = '$catid' and published = '1'");
        $catIds = $db->loadObjectList();
        if (count($catIds) > 0)
        {
            for ($i = 0; $i < count($catIds); $i++)
            {
                $categoryArr = HelperOspropertyCommon::getSubCategories($catIds[$i]->id, $categoryArr);
            }
        }
        return $categoryArr;
    }

    /**
     * Check is Photo file
     * Return false : if it is not the JPEG photo
     * Return true  : if it is JPEG photo
     */
    static function checkIsPhotoFileUploaded($element_name)
    {
        $file = $_FILES[$element_name];
        $fname = $file['name'];
        $ftype = end(explode('.', strtolower($fname)));
        $ftype = strtolower($ftype);
        $allowtype = array('jpg', 'jpeg', 'gif', 'png');
        if (!in_array($ftype, $allowtype))
        {
            return false;
        } else
        {
            //return true;
            $imageinfo = getimagesize($_FILES[$element_name]['tmp_name']);
            if (strtolower($imageinfo['mime']) != 'image/jpeg' && strtolower($imageinfo['mime']) != 'image/jpg' && strtolower($imageinfo['mime']) != 'image/png' && strtolower($imageinfo['mime']) != 'image/gif')
            {
                return false;
            } else
            {
                return true;
            }
        }
    }

    /**
     * Check is Document file
     * Return false : if it is not Doc or PDF file
     * Return true  : if it is Doc or PDF file
     */
    static function checkIsDocumentFileUploaded($element_name)
    {
        $file = $_FILES[$element_name];
        $fname = $file['name'];
        $ftype = end(explode('.', strtolower($fname)));
        $ftype = strtolower($ftype);
        $allowtype = array('pdf', 'doc', 'docx');
        if (!in_array($ftype, $allowtype))
        {
            return false;
        } else
        {
            $type = strtolower($_FILES[$element_name]['type']);
            if (($type == "application/msword") || ($type == "application/pdf"))
            {
                return true;
            } else
            {
                return false;
            }
        }
    }

    /**
     * Get the category list
     *
     * @param unknown_type $parent_id
     */
    static function getCatList($parent_id, & $catArr)
    {
        global $jinput, $mainframe, $lang_suffix;
        $db = JFactory::getDbo();
        $db->setQuery("Select id, parent_id,category_name$lang_suffix as category_name from #__osrs_categories where id = '$parent_id'");
        $category = $db->loadObjectList();
        if (count($category) > 0)
        {
            $category = $category[0];
            $count = count($catArr);
            $catArr[$count] = new stdClass;
            $catArr[$count]->id = $category->id;
            $catArr[$count]->cat_name = $category->category_name;
            $parent_id = $category->parent_id;
            $catArr = HelperOspropertyCommon::getCatList($parent_id, $catArr);
        }
        return $catArr;
    }

    /**
     * Drawn DPE Chart
     *
     * @param unknown_type $energy
     * @param unknown_type $climate
     * @return unknown
     */
    static function drawGraph($energy, $climate)
    {
        global $jinput, $ismobile, $configClass;
        $dstyle = 'padding: 0 3px; line-height: 20px; margin-bottom: 2px; height: 20px;';
        $cwidth = (($energy && $energy != 'null') && ($climate && $climate != 'null')) ? '50%' : '100%';

        $e_measurement = "kWH/m";
        $c_measurement = "kg/m";

        $dpe_display = '';

        $dpe_display .= '<div class="row-fluid"><div class="span12"><div class="span6">';
        if (isset($energy) && $energy != 'null')
        {
            $dpe_display .= '<div class="os_dpe_header"><strong>' . JText::_('OS_ENERGY_HEADER') . ' (' . $e_measurement . ')</strong></div>';
            //if(isset($energy) && $energy != 'null'){
            $r_energy = round($energy);
            if ($r_energy <= intval($configClass['running_costs_A']))
            {
                $e_height = 0;
            } elseif (in_array($r_energy, range(intval($configClass['running_costs_A']) + 1, intval($configClass['running_costs_B']))))
            {
                $e_height = 22;
            } elseif (in_array($r_energy, range(intval($configClass['running_costs_B']) + 1, intval($configClass['running_costs_C']))))
            {
                $e_height = 44;
            } elseif (in_array($r_energy, range(intval($configClass['running_costs_C']) + 1, intval($configClass['running_costs_D']))))
            {
                $e_height = 66;
            } elseif (in_array($r_energy, range(intval($configClass['running_costs_D']) + 1, intval($configClass['running_costs_E']))))
            {
                $e_height = 88;
            } elseif (in_array($r_energy, range(intval($configClass['running_costs_E']) + 1, intval($configClass['running_costs_F']))))
            {
                $e_height = 110;
            } elseif ($r_energy >= intval($configClass['running_costs_F']) + 1)
            {
                $e_height = 132;
            }

            $running_costA = intval($configClass['running_costs_A']);
            $running_costA1 = $running_costA + 1;

            $running_costB = intval($configClass['running_costs_B']);
            $running_costB1 = $running_costB + 1;

            $running_costC = intval($configClass['running_costs_C']);
            $running_costC1 = $running_costC + 1;

            $running_costD = intval($configClass['running_costs_D']);
            $running_costD1 = $running_costD + 1;

            $running_costE = intval($configClass['running_costs_E']);
            $running_costE1 = $running_costE + 1;

            $running_costF = intval($configClass['running_costs_F']);
            $running_costF1 = $running_costF + 1;
            $dpe_display .= '<div class="clearfix"></div>
                        <div style="position: relative;" class="os_dpe_energy_container">
                            <div style="' . $dstyle . ' background: #00833d; position: relative; width: 20%;" class="os_dpe_item e_a">(<' . $running_costA . ') <span style="float: right;">A</span></div>
                            <div style="' . $dstyle . ' background: #1bb053; position: relative; width: 30%;" class="os_dpe_item e_b">(' . $running_costA1 . ' ' . Jtext::_('OS_TO') . ' ' . $running_costB . ') <span style="float: right;">B</span></div>
                            <div style="' . $dstyle . ' background: #8cc540; position: relative; width: 40%;" class="os_dpe_item e_c">(' . $running_costB1 . ' ' . Jtext::_('OS_TO') . ' ' . $running_costC . ') <span style="float: right;">C</span></div>
                            <div style="' . $dstyle . ' background: #ffc909; position: relative; width: 50%;" class="os_dpe_item e_d">(' . $running_costC1 . ' ' . Jtext::_('OS_TO') . ' ' . $running_costD . ') <span style="float: right;">D</span></div>
                            <div style="' . $dstyle . ' background: #faad67; position: relative; width: 60%;" class="os_dpe_item e_e">(' . $running_costD1 . ' ' . Jtext::_('OS_TO') . ' ' . $running_costE . ') <span style="float: right;">E</span></div>
                            <div style="' . $dstyle . ' background: #f48221; position: relative; width: 70%;" class="os_dpe_item e_f">(' . $running_costE1 . ' ' . Jtext::_('OS_TO') . ' ' . $running_costF . ') <span style="float: right;">F</span></div>
                            <div style="' . $dstyle . ' background: #ed1b24; position: relative; width: 80%;" class="os_dpe_item e_g">(>' . $running_costF1 . ') <span style="float: right;">G</span></div>
                            <div style="' . $dstyle . ' position: absolute; top: ' . $e_height . 'px; right: 0px; width: 10%; background: #ccc; text-align: center;" class="os_dpe_marker m_energy">' . $energy . '</div>
                        </div>';
            $dpe_display .= '<div class="clearfix"></div><div class="os_dpe_footer" style="font-size: 10px;">' . JText::_('OS_ENERGY_FOOTER') . '</div>';
        }


        $dpe_display .= '</div>';
        $dpe_display .= '<div class="span6">';

        $co2_emissionsA = intval($configClass['co2_emissions_A']);
        $co2_emissionsA1 = $co2_emissionsA + 1;

        $co2_emissionsB = intval($configClass['co2_emissions_B']);
        $co2_emissionsB1 = $co2_emissionsB + 1;

        $co2_emissionsC = intval($configClass['co2_emissions_C']);
        $co2_emissionsC1 = $co2_emissionsC + 1;

        $co2_emissionsD = intval($configClass['co2_emissions_D']);
        $co2_emissionsD1 = $co2_emissionsD + 1;

        $co2_emissionsE = intval($configClass['co2_emissions_E']);
        $co2_emissionsE1 = $co2_emissionsE + 1;

        $co2_emissionsF = intval($configClass['co2_emissions_F']);
        $co2_emissionsF1 = $co2_emissionsF;

        if (isset($climate) && $climate != 'null')
        {
            $dpe_display .= '<div class="os_dpe_header"><strong>' . JText::_('OS_CLIMATE_HEADER') . ' (' . $c_measurement . ')</strong></div>';

            $r_climate = round($climate);
            if ($r_climate <= intval($configClass['co2_emissions_A']))
            {
                $c_height = 0;
            } elseif (in_array($r_climate, range(intval($configClass['co2_emissions_A']) + 1, intval($configClass['co2_emissions_B']))))
            {
                $c_height = 22;
            } elseif (in_array($r_climate, range(intval($configClass['co2_emissions_B']) + 1, intval($configClass['co2_emissions_C']))))
            {
                $c_height = 44;
            } elseif (in_array($r_climate, range(intval($configClass['co2_emissions_C']) + 1, intval($configClass['co2_emissions_D']))))
            {
                $c_height = 66;
            } elseif (in_array($r_climate, range(intval($configClass['co2_emissions_D']) + 1, intval($configClass['co2_emissions_E']))))
            {
                $c_height = 88;
            } elseif (in_array($r_climate, range(intval($configClass['co2_emissions_E']) + 1, intval($configClass['co2_emissions_F']))))
            {
                $c_height = 110;
            } elseif ($r_climate >= intval($configClass['co2_emissions_F']))
            {
                $c_height = 132;
            }

            $dpe_display .= '<div class="clearfix"></div>
                            <div style="position: relative;" class="os_dpe_climate_container">
                                <div style="' . $dstyle . ' background: #75ccf7; position: relative; width: 20%;" class="os_dpe_item c_a">(<' . $co2_emissionsA . ') <span style="float: right;">A</span></div>
                                <div style="' . $dstyle . ' background: #22b5eb; position: relative; width: 30%;" class="os_dpe_item c_b">(' . $co2_emissionsA1 . ' ' . Jtext::_('OS_TO') . ' ' . $co2_emissionsB . ') <span style="float: right;">B</span></div>
                                <div style="' . $dstyle . ' background: #099ad7; position: relative; width: 40%;" class="os_dpe_item c_c">(' . $co2_emissionsB1 . ' ' . Jtext::_('OS_TO') . ' ' . $co2_emissionsC . ') <span style="float: right;">C</span></div>
                                <div style="' . $dstyle . ' background: #0079c2; position: relative; width: 50%;" class="os_dpe_item c_d">(' . $co2_emissionsC1 . ' ' . Jtext::_('OS_TO') . ' ' . $co2_emissionsD . ') <span style="float: right;">D</span></div>
                                <div style="' . $dstyle . ' background: #bbbcbe; position: relative; width: 60%;" class="os_dpe_item c_e">(' . $co2_emissionsD1 . ' ' . Jtext::_('OS_TO') . ' ' . $co2_emissionsE . ') <span style="float: right;">E</span></div>
                                <div style="' . $dstyle . ' background: #a1a0a5; position: relative; width: 70%;" class="os_dpe_item c_f">(' . $co2_emissionsE1 . ' ' . Jtext::_('OS_TO') . ' ' . $co2_emissionsF . ') <span style="float: right;">F</span></div>
                                <div style="' . $dstyle . ' background: #818086; position: relative; width: 80%;" class="os_dpe_item c_g">(>' . $co2_emissionsF1 . ') <span style="float: right;">G</span></div>
                                <div style="' . $dstyle . ' position: absolute; top: ' . $c_height . 'px; right: 0px; width: 10%; background: #ccc; text-align: center;" class="os_dpe_marker m_climate">' . $climate . '</div>
                            </div>';
            $dpe_display .= '<div class="clearfix"></div><div class="os_dpe_footer" style="font-size: 10px;">' . JText::_('OS_CLIMATE_FOOTER') . '</div>';
        }

        $dpe_display .= '</div></div></div>';

        return $dpe_display;
    }

    /**
     * Drawn DPE Chart
     *
     * @param unknown_type $energy
     * @param unknown_type $climate
     * @return unknown
     */
    function drawGraphMobile($energy, $climate)
    {
        global $jinput, $ismobile, $configClass;
        $dstyle = 'padding: 0 3px; line-height: 20px; margin-bottom: 2px; height: 20px;';
        $cwidth = (($energy && $energy != 'null') && ($climate && $climate != 'null')) ? '50%' : '100%';

        $e_measurement = "kWH/m";
        $c_measurement = "kg/m";

        $dpe_display = '';

        $dpe_display .= '<div class="row-fluid"><div class="span12"><div class="span6">';
        if (isset($energy) && $energy != 'null')
        {
            $dpe_display .= '<div class="os_dpe_header"><strong>' . JText::_('OS_ENERGY_HEADER') . ' (' . $e_measurement . ')</strong></div>';
            //if(isset($energy) && $energy != 'null'){
            $r_energy = round($energy);
            if ($r_energy <= intval($configClass['running_costs_A']))
            {
                $e_height = 0;
            } elseif (in_array($r_energy, range(intval($configClass['running_costs_A']) + 1, intval($configClass['running_costs_B']))))
            {
                $e_height = 22;
            } elseif (in_array($r_energy, range(intval($configClass['running_costs_B']) + 1, intval($configClass['running_costs_C']))))
            {
                $e_height = 44;
            } elseif (in_array($r_energy, range(intval($configClass['running_costs_C']) + 1, intval($configClass['running_costs_D']))))
            {
                $e_height = 66;
            } elseif (in_array($r_energy, range(intval($configClass['running_costs_D']) + 1, intval($configClass['running_costs_E']))))
            {
                $e_height = 88;
            } elseif (in_array($r_energy, range(intval($configClass['running_costs_E']) + 1, intval($configClass['running_costs_F']))))
            {
                $e_height = 110;
            } elseif ($r_energy >= intval($configClass['running_costs_F']) + 1)
            {
                $e_height = 132;
            }

            $running_costA = intval($configClass['running_costs_A']);
            $running_costA1 = $running_costA + 1;

            $running_costB = intval($configClass['running_costs_B']);
            $running_costB1 = $running_costB + 1;

            $running_costC = intval($configClass['running_costs_C']);
            $running_costC1 = $running_costC + 1;

            $running_costD = intval($configClass['running_costs_D']);
            $running_costD1 = $running_costD + 1;

            $running_costE = intval($configClass['running_costs_E']);
            $running_costE1 = $running_costE + 1;

            $running_costF = intval($configClass['running_costs_F']);
            $running_costF1 = $running_costE + 1;

            $dpe_display .= '<div class="clearfix"></div>
                        <div style="position: relative;" class="os_dpe_energy_container">
                            <div style="' . $dstyle . ' background: #00833d; position: relative; width: 20%;" class="os_dpe_item e_a">(<' . $running_costA . ') <span style="float: right;">A</span></div>
                            <div style="' . $dstyle . ' background: #1bb053; position: relative; width: 30%;" class="os_dpe_item e_b">(' . $running_costA1 . ' ' . Jtext::_('OS_TO') . ' ' . $running_costB . ') <span style="float: right;">B</span></div>
                            <div style="' . $dstyle . ' background: #8cc540; position: relative; width: 40%;" class="os_dpe_item e_c">(' . $running_costB1 . ' ' . Jtext::_('OS_TO') . ' ' . $running_costC . ') <span style="float: right;">C</span></div>
                            <div style="' . $dstyle . ' background: #ffc909; position: relative; width: 50%;" class="os_dpe_item e_d">(' . $running_costC1 . ' ' . Jtext::_('OS_TO') . ' ' . $running_costD . ') <span style="float: right;">D</span></div>
                            <div style="' . $dstyle . ' background: #faad67; position: relative; width: 60%;" class="os_dpe_item e_e">(' . $running_costD1 . ' ' . Jtext::_('OS_TO') . ' ' . $running_costE . ') <span style="float: right;">E</span></div>
                            <div style="' . $dstyle . ' background: #f48221; position: relative; width: 70%;" class="os_dpe_item e_f">(' . $running_costE1 . ' ' . Jtext::_('OS_TO') . ' ' . $running_costF . ') <span style="float: right;">F</span></div>
                            <div style="' . $dstyle . ' background: #ed1b24; position: relative; width: 80%;" class="os_dpe_item e_g">(>' . $running_costF1 . ') <span style="float: right;">G</span></div>
                            <div style="' . $dstyle . ' position: absolute; top: ' . $e_height . 'px; right: 0px; width: 10%; background: #ccc; text-align: center;" class="os_dpe_marker m_energy">' . $energy . '</div>
                        </div>';
            $dpe_display .= '<div class="clearfix"></div><div class="os_dpe_footer" style="font-size: 10px;">' . JText::_('OS_ENERGY_FOOTER') . '</div>';
        }


        $dpe_display .= '</div>';
        $dpe_display .= '<div class="span6">';

        $co2_emissionsA = intval($configClass['co2_emissions_A']);
        $co2_emissionsA1 = $co2_emissionsA + 1;

        $co2_emissionsB = intval($configClass['co2_emissions_B']);
        $co2_emissionsB1 = $co2_emissionsB + 1;

        $co2_emissionsC = intval($configClass['co2_emissions_C']);
        $co2_emissionsC1 = $co2_emissionsC + 1;

        $co2_emissionsD = intval($configClass['co2_emissions_D']);
        $co2_emissionsD1 = $co2_emissionsD + 1;

        $co2_emissionsE = intval($configClass['co2_emissions_E']);
        $co2_emissionsE1 = $co2_emissionsE + 1;

        $co2_emissionsF = intval($configClass['co2_emissions_F']);
        $co2_emissionsF1 = $co2_emissionsF;

        if (isset($climate) && $climate != 'null')
        {
            $dpe_display .= '<div class="os_dpe_header"><strong>' . JText::_('OS_CLIMATE_HEADER') . ' (' . $c_measurement . ')</strong></div>';

            $r_climate = round($climate);
            if ($r_climate <= intval($configClass['co2_emissions_A']))
            {
                $c_height = 0;
            } elseif (in_array($r_climate, range(intval($configClass['co2_emissions_A']) + 1, intval($configClass['co2_emissions_B']))))
            {
                $c_height = 22;
            } elseif (in_array($r_climate, range(intval($configClass['co2_emissions_B']) + 1, intval($configClass['co2_emissions_C']))))
            {
                $c_height = 44;
            } elseif (in_array($r_climate, range(intval($configClass['co2_emissions_C']) + 1, intval($configClass['co2_emissions_D']))))
            {
                $c_height = 66;
            } elseif (in_array($r_climate, range(intval($configClass['co2_emissions_D']) + 1, intval($configClass['co2_emissions_E']))))
            {
                $c_height = 88;
            } elseif (in_array($r_climate, range(intval($configClass['co2_emissions_E']) + 1, intval($configClass['co2_emissions_F']))))
            {
                $c_height = 110;
            } elseif ($r_climate >= intval($configClass['co2_emissions_F']))
            {
                $c_height = 132;
            }

            $dpe_display .= '<div class="clearfix"></div>
                            <div style="position: relative;" class="os_dpe_climate_container">
                                <div style="' . $dstyle . ' background: #75ccf7; position: relative; width: 20%;" class="os_dpe_item c_a">(<' . $co2_emissionsA . ') <span style="float: right;">A</span></div>
                                <div style="' . $dstyle . ' background: #22b5eb; position: relative; width: 30%;" class="os_dpe_item c_b">(' . $co2_emissionsA1 . ' ' . Jtext::_('OS_TO') . ' ' . $co2_emissionsB . ') <span style="float: right;">B</span></div>
                                <div style="' . $dstyle . ' background: #099ad7; position: relative; width: 40%;" class="os_dpe_item c_c">(' . $co2_emissionsB1 . ' ' . Jtext::_('OS_TO') . ' ' . $co2_emissionsC . ') <span style="float: right;">C</span></div>
                                <div style="' . $dstyle . ' background: #0079c2; position: relative; width: 50%;" class="os_dpe_item c_d">(' . $co2_emissionsC1 . ' ' . Jtext::_('OS_TO') . ' ' . $co2_emissionsD . ') <span style="float: right;">D</span></div>
                                <div style="' . $dstyle . ' background: #bbbcbe; position: relative; width: 60%;" class="os_dpe_item c_e">(' . $co2_emissionsD1 . ' ' . Jtext::_('OS_TO') . ' ' . $co2_emissionsE . ') <span style="float: right;">E</span></div>
                                <div style="' . $dstyle . ' background: #a1a0a5; position: relative; width: 70%;" class="os_dpe_item c_f">(' . $co2_emissionsE1 . ' ' . Jtext::_('OS_TO') . ' ' . $co2_emissionsF . ') <span style="float: right;">F</span></div>
                                <div style="' . $dstyle . ' background: #818086; position: relative; width: 80%;" class="os_dpe_item c_g">(>' . $co2_emissionsF1 . ') <span style="float: right;">G</span></div>
                                <div style="' . $dstyle . ' position: absolute; top: ' . $c_height . 'px; right: 0px; width: 10%; background: #ccc; text-align: center;" class="os_dpe_marker m_climate">' . $climate . '</div>
                            </div>';
            $dpe_display .= '<div class="clearfix"></div><div class="os_dpe_footer" style="font-size: 10px;">' . JText::_('OS_CLIMATE_FOOTER') . '</div>';
        }

        $dpe_display .= '</div></div></div>';

        return $dpe_display;
    }

    /**
     * Create the photo from main photo
     *
     * @param unknown_type $t
     * @param unknown_type $l
     * @param unknown_type $h
     * @param unknown_type $w
     * @param unknown_type $wall_image
     */
    static function create_photo($t, $l, $h, $w, $photo_name, $type, $pid)
    {
        global $jinput, $configClass;
        $configClass = OSPHelper::loadConfig();
        $ext = $ext[count($ext) - 1];
        $path = JPATH_ROOT . DS . "images" . DS . "osproperty" . DS . "properties" . DS . $pid;
        $srcImg = imagecreatefromjpeg($path . DS . $photo_name);
        $newImg = imagecreatetruecolor($w, $h);
        imagecopyresampled($newImg, $srcImg, 0, 0, $l, $t, $w, $h, $w, $h);
        if ($type == 0)
        {
            imagejpeg($newImg, $path . DS . "thumb" . DS . $photo_name);
            //resize if the photo has big size
            $images_thumbnail_width = $configClass['images_thumbnail_width'];
            $images_thumbnail_height = $configClass['images_thumbnail_height'];
            $info = getimagesize($path . DS . "thumb" . DS . $photo_name);
            $width = $info[0];
            $height = $info[1];
            if ($width > $images_thumbnail_width)
            {
                //resize image to the original thumb width
                $image = new SimpleImage();
                $image->load($path . DS . "thumb" . DS . $photo_name);
                $image->resize($images_thumbnail_width, $images_thumbnail_height);
                $image->save($path . DS . "thumb" . DS . $photo_name, $configClass['images_quality']);
            }
        } else
        {
            imagejpeg($newImg, $path . DS . "medium" . DS . $photo_name);
            //resize if the photo has big size
            $images_large_width = $configClass['images_large_width'];
            $images_large_height = $configClass['images_large_height'];
            $info = getimagesize($path . DS . "medium" . DS . $photo_name);
            $width = $info[0];
            $height = $info[1];
            if ($width > $images_large_width)
            {
                //resize image to the original thumb width
                $image = new SimpleImage();
                $image->load($path . DS . "medium" . DS . $photo_name);
                $image->resize($images_large_width, $images_large_height);
                $image->save($path . DS . "medium" . DS . $photo_name, $configClass['images_quality']);
            }
        }
    }

    /**
     * Check max size of the image
     *
     * @param unknown_type $image_path
     */
    static function returnMaxsize($image_path)
    {
        global $jinput, $mainframe, $configClass;
        $info = getimagesize($image_path);
        $width = $info[0];
        $height = $info[1];
        $max_width_allowed = $configClass['max_width_size'];
        $max_height_allowed = $configClass['max_height_size'];

        if (($height > $max_height_allowed) and ( $width > $max_width_allowed))
        {
            $resize = 1;
            //resize to both
            /*
              $return = HelperOspropertyCommon::calResizePhoto($width,$height,$max_width_allowed,$max_height_allowed,$resize);
              //resize image
              $image = new SimpleImage();
              $image->load($image_path);
              $image->resize($return[0],$return[1]);
              $image->save($image_path,100);
             */
            OSPHelper::resizePhoto($image_path, $max_width_allowed, $max_height_allowed);
        } elseif (($height > $max_height_allowed) and ( $width <= $max_width_allowed))
        {
            $resize = 2;
            //resize to height
            /*
              $return = HelperOspropertyCommon::calResizePhoto($width,$height,$max_width_allowed,$max_height_allowed,$resize);
              //resize image
              $image = new SimpleImage();
              $image->load($image_path);
              $image->resize($return[0],$return[1]);
              $image->save($image_path,100);
             */
            OSPHelper::resizePhoto($image_path, $width, $max_height_allowed);
        } elseif (($height <= $max_height_allowed) and ( $width > $max_width_allowed))
        {
            $resize = 3;
            //resize to width
            /*
              $return = HelperOspropertyCommon::calResizePhoto($width,$height,$max_width_allowed,$max_height_allowed,$resize);
              //resize image
              $image = new SimpleImage();
              $image->load($image_path);
              $image->resize($return[0],$return[1]);
              $image->save($image_path,100);
             */
            OSPHelper::resizePhoto($image_path, $max_width_allowed, $height);
        } else
        {
            //do nothing
        }
    }

    static function calResizePhoto($width, $height, $maxwidth, $maxheight, $resize)
    {
        global $jinput, $mainframe;
        switch ($resize)
        {
            case "1":
                $return = HelperOspropertyCommon::calResizeWidth($width, $height, $maxwidth, $maxheight);
                $newwidth = $return[0];
                $newheight = $return[1];
                if ($newheight > $maxheight)
                {
                    $return = HelperOspropertyCommon::calResizeHeight($width, $height, $maxwidth, $maxheight);
                }
                break;
            case "2":
                $return = HelperOspropertyCommon::calResizeHeight($width, $height, $maxwidth, $maxheight);
                break;
            case "3":
                $return = HelperOspropertyCommon::calResizeWidth($width, $height, $maxwidth, $maxheight);
                break;
        }
        return $return;
    }

    static function calResizeWidth($width, $height, $maxwidth, $maxheight)
    {
        $return = array();
        if ($width > $maxwidth)
        {
            $newwidth = $maxwidth;
            $newheight = round($height * $maxwidth / $width);
            $return[0] = $newwidth;
            $return[1] = $newheight;
        } else
        {
            $return[0] = $width;
            $return[1] = $height;
        }
        return $return;
    }

    function calResizeHeight($width, $height, $maxwidth, $maxheight)
    {
        $return = array();
        if ($height > $maxheight)
        {
            $newheight = $maxheight;
            $newwidth = round($width * $maxheight / $height);
            $return[0] = $newwidth;
            $return[1] = $newheight;
        } else
        {
            $return[0] = $width;
            $return[1] = $height;
        }
        return $return;
    }

    /**
     * Check to see if this user is the owner of the property
     *
     * @param unknown_type $pid
     * @return unknown
     */
    static function isOwner($pid)
    {
        $user = JFactory::getUser();
        if (intval($user->id) > 0)
        {
            $db = JFactory::getDbo();
            //check to see if this user is agent
            $db->setQuery("Select count(id) from #__osrs_agents where user_id = '$user->id' and published = '1'");
            $count = $db->loadResult();
            if ($count > 0)
            {
                $db->setQuery("Select id from #__osrs_agents where user_id = '$user->id' and published = '1'");
                $agent_id = $db->loadResult();
                $db->setQuery("Select count(id) from #__osrs_properties where agent_id = '$agent_id' and id = '$pid'");
                $count = $db->loadResult();
                if ($count > 0)
                {
                    return true;
                } else
                {
                    return false;
                }
            } else
            {
                return false;
            }
        } else
        {
            return false;
        }
    }

    static function isCompanyOwner($pid)
    {
        global $jinput, $mainframe;
        $user = Jfactory::getUser();
        if (intval($user->id) > 0)
        {
            $db = JFactory::getDbo();
            //check to see if this user is agent
            $db->setQuery("Select count(id) from #__osrs_companies where user_id = '$user->id' and published = '1'");
            $count = $db->loadResult();
            if ($count > 0)
            {
                $db->setQuery("Select id from #__osrs_companies where user_id = '$user->id' and published = '1'");
                $company_id = $db->loadResult();

                $db->setQuery("Select count(id) from #__osrs_properties where agent_id in (Select id from #__osrs_agents where published = '1' and company_id = '$company_id') and id = '$pid'");
                $count = $db->loadResult();
                if ($count > 0)
                {
                    return true;
                } else
                {
                    return false;
                }
            } else
            {
                return false;
            }
        } else
        {
            return false;
        }
    }

    static function isAgentOfCompany($agent_id)
    {
        global $jinput, $mainframe;
        $user = Jfactory::getUser();
        if (intval($user->id) > 0)
        {
            $db = JFactory::getDbo();
            //check to see if this user is agent
            $db->setQuery("Select count(id) from #__osrs_companies where user_id = '$user->id' and published = '1'");
            $count = $db->loadResult();
            if ($count > 0)
            {
                $db->setQuery("Select id from #__osrs_companies where user_id = '$user->id' and published = '1'");
                $company_id = $db->loadResult();

                $db->setQuery("Select count(id) from #__osrs_agents where id = '$agent_id' and company_id = '$company_id'");
                $count = $db->loadResult();
                if ($count > 0)
                {
                    return true;
                } else
                {
                    return false;
                }
            } else
            {
                return false;
            }
        } else
        {
            return false;
        }
    }

    /**
     * Export data in XML Google Earth KML format
     *
     * @param unknown_type $rows
     */
    static function generateGoogleEarthKML($rows)
    {
        global $jinput, $mainframe, $configClass;
        $db = JFactory::getDbo();
        while (ob_end_clean());
        $document = JFactory::getDocument();
        $document->setMimeEncoding('application/vnd.google-earth.kml+xml');
        $app = JFactory::getApplication();

        $config = JFactory::getConfig();

        ################################################################################
        # WRITTEN FOR GOOGLE KML 2.2 SPECS (US VERSION)
        # http://code.google.com/apis/kml/documentation/kmlreference.html
        ################################################################################
        $temp_name = time() . ".xml";
        $xml = new XMLWriter();
        $xml->openURI(JPATH_ROOT . DS . "tmp" . DS . time() . $temp_name);
        $xml->startDocument('1.0');
        $xml->setIndent(true);

        $xml->startElement('kml');
        $xml->writeAttribute('xmlns', 'http://www.opengis.net/kml/2.2');
        $xml->writeAttribute('xmlns:gx', 'http://www.google.com/kml/ext/2.2');
        $xml->writeAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom');

        $xml->startElement('Document');
        $xml->startElement('atom:author');
        $xml->writeElement('atom:name', $configClass['business_name']);
        $xml->endElement();

        $xml->writeElement('name', $configClass['business_name']);

        $xml->startElement('Style');
        $xml->startElement('IconStyle');
        $xml->writeElement('href', 'http://maps.google.com/mapfiles/kml/pal4/icon46.png');
        $xml->endElement();
        $xml->writeElement('BalloonStyle', '');
        $xml->endElement();

        if (count($rows) > 0)
        {
            // start listings
            for ($i = 0; $i < count($rows); $i++)
            {
                $row = $rows[$i];
                $db->setQuery("Select * from #__osrs_photos where pro_id = '$row->id'");
                $images = $db->loadObjectList();
                //$features	= ipropertyModelFeed::getFeatures($property['id']);
                $query = "Select a.id, a.amenities from #__osrs_amenities as a"
                        . " inner join #__osrs_property_amenities as b on b.amen_id = a.id"
                        . " where a.published = '1' and b.pro_id = '$row->id'";
                $db->setQuery($query);
                $features = $db->loadObjectList();

                // create photo link
                if ($images)
                {
                    $photo = JUri::root() . "images/osproperty/properties/" . $row->id . "/" . $images[0]->image;
                } else
                {
                    $photo = '';
                }
                $address = '';
                if ($row->show_address == 1)
                {
                    $address .= $row->address;
                    if ($row->postcode != "")
                    {
                        $address .= ", " . $row->postcode;
                    }
                    if ($row->city > 0)
                    {
                        $address .= ", " . HelperOspropertyCommon::loadCityName($row->city);
                    }
                    if ($row->region != "")
                    {
                        $address .= ", " . $row->region;
                    }
                    $address .= ", " . $row->start_name;
                    $address .= ", " . $row->country_name;
                }

                $title = $row->pro_name;

                if ($row->agent_photo != "")
                {

                    // define vars
                    $agent_image = JURI::ROOT() . "images/osproperty/agent/thumbnail/" . $row->agent_photo;
                }

                // build the balloon_text object here.
                $balloon_text = '<div style="width: 670px;">
								<table width="100%" cellspacing="0" cellpadding="5">
								<tr>
								<td valign="top" style="width: 180px; border-right: solid 1px #ccc;">
								<div style="padding-bottom: 5px;"><img src="' . JURI::root() . 'media/com_osproperty/agents/' . $property['agent_photo'] . '" alt="' . $row->agent_name . '" width="78" style="border: solid 1px #666; margin-bottom: 5px;" />
								</div>
								<div style="font-size: 11px; padding-top: 5px; border-top: solid 1px #ccc;">
								<a href="' . JURI::root() . 'index.php?option=com_osproperty&task=agent_info&id=' . $row->agent_id . '" style="color: #ff0000; text-decoration: none; font-size: 12px; font-weight: bold;">' . $row->agent_name . '</a><br />';

                if ($row->agent_email)
                    $balloon_text .= '<img src="' . JURI::root() . 'components/com_osproperty/assets/images/icon-email.gif" />' . $row->agent_email . '<br />';

                $balloon_text .= '</div>
								</td>
								<td valign="top" style="width: 470px;">
								<div style="border-bottom: solid 1px #ccc; padding: 0 10px 5px 10px; margin-bottom: 5px; font-size: 16px; font-weight: bold; text-transform: uppercase;">
								<a href="' . JURI::root() . 'index.php?option=com_osproperty&task=property_details&id=' . $row->id . '">' . $address . '</a>
								</div>
								<div>';
                if ($row->bed_room != "")
                    $balloon_text .= '<strong>Bedrooms:</strong> ' . $row->bed_room . '<br />';
                if ($row->bath_room)
                    $balloon_text .= '<strong>Bathrooms:</strong> ' . $row->bath_room . '<br />';
                if ($row->square_feet)
                    $balloon_text .= '<strong>Square FT:</strong> ' . $row->square_feet . '<br />';
                if ($row->rooms)
                    $balloon_text .= '<strong>Rooms:</strong> ' . $row->rooms . '<br />';
                if ($property['price'])
                    $balloon_text .= '<br /><span style="font-size: 14px; font-weight: bold;">Listing Price:</span><br /><span style="font-size: 24px; font-weight: bold; color: #ff0000;"> ' . HelperOspropertyCommon::loadCurrency($row->curr) . " " . HelperOspropertyCommon::showPrice($row->price);
                if ($row->rent_time != "")
                {
                    $balloon_text .= "/" . $row->rent_time;
                }
                $balloon_text .= '</span>';

                $balloon_text .= '</div>
								<div style="padding-top: 10px; clear: both;">
								<strong>Property Description:</strong><br /> ' . $row->pro_small_desc . '<br />
								</div>
								</td>
								</tr>
								</table>
								</div>';


                ####################################################################
                # THIS IS WHERE THE ACTUAL PLACEMARK STARTS GETTING BUILT
                ####################################################################

                $xml->startElement('Placemark');
                $xml->writeAttribute('id', $row->id);
                // location section
                $xml->writeElement("name", $title);

                $xml->startElement("description");
                $xml->writeCData($row->pro_small_desc);
                $xml->endElement();

                $xml->startElement("Point");
                $xml->writeElement("coordinates", $row->lat_add . "," . $row->lat_add . ",0");
                $xml->endElement();

                $xml->startElement("Style");
                $xml->startElement("IconStyle");
                $xml->startElement("Icon");
                $xml->writeElement("href", $photo);
                $xml->endElement();
                $xml->endElement();
                $xml->startElement("BalloonStyle");
                $xml->startElement("text");
                $xml->writeCData($balloon_text);
                $xml->endElement();
                $xml->endElement();
                $xml->endElement();

                // end listing data
                $xml->endElement(); // item
            }
        }
        $xml->endElement(); // rss
        $xml->endDocument();
        $xml->flush();

        self::processDownload(JPATH_ROOT . DS . "tmp" . DS . time() . $temp_name, $temp_name);
    }

    /**
     * Process download a file
     *
     * @param string $file : Full path to the file which will be downloaded
     */
    public static function processDownload($filePath, $filename, $detectFilename = false)
    {
        jimport('joomla.filesystem.file');
        $fsize = @filesize($filePath);
        $mod_date = date('r', filemtime($filePath));
        $cont_dis = 'attachment';
        if ($detectFilename)
        {
            $pos = strpos($filename, '_');
            $filename = substr($filename, $pos + 1);
        }
        $ext = JFile::getExt($filename);
        $mime = self::getMimeType($ext);
        // required for IE, otherwise Content-disposition is ignored
        if (ini_get('zlib.output_compression'))
        {
            ini_set('zlib.output_compression', 'Off');
        }
        header("Pragma: public");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Expires: 0");
        header("Content-Transfer-Encoding: binary");
        header('Content-Disposition:' . $cont_dis . ';' . ' filename="' . $filename . '";' . ' modification-date="' . $mod_date . '";' . ' size=' . $fsize . ';'); //RFC2183
        header("Content-Type: " . $mime); // MIME type
        header("Content-Length: " . $fsize);

        if (!ini_get('safe_mode'))
        { // set_time_limit doesn't work in safe mode
            @set_time_limit(0);
        }
        self::readfile_chunked($filePath);
    }

    /**
     * Get mimetype of a file
     *
     * @return string
     */
    public static function getMimeType($ext)
    {
        require_once JPATH_ROOT . "/components/com_osproperty/helpers/mime.mapping.php";
        foreach ($mime_extension_map as $key => $value)
        {
            if ($key == $ext)
            {
                return $value;
            }
        }

        return "";
    }

    /**
     * Filter Form
     *
     * @param unknown_type $lists
     */
    static function filterForm($lists)
    {
        global $jinput, $mainframe, $languages, $configClass;
        if (($configClass['show_searchform'] == 1) and ( $lists['show_filterform'] == 1))
        {
            $show_location_div = 0;
            $point = 0;
            if (OSPHelper::checkOwnerExisting() and ( $lists['show_agenttypefilter'] == 1))
            {
                $point++;
            }
            if ($lists['show_locationfilter'] == 1)
            {
                $show_location_div = 1;
                $point++;
            }
            if ($lists['show_pricefilter'] == 1)
            {
                $point++;
            }
            if ($lists['show_propertytypefilter'] == 1)
            {
                $point++;
            }
            if ($lists['show_categoryfilter'] == 1)
            {
                $point++;
            }
            if ($point > 0)
            {
                $show_filter_button = 1;
            } else
            {
                $show_filter_button = 0;
            }
            if ($point > 2)
            {
                $show_submit = 1;
            } else
            {
                $show_submit = 0;
            }
            if (HelperOspropertyCommon::checkCountry())
            {
                $show_country_dropdown = 1;
            } else
            {
                $show_country_dropdown = 0;
            }

            if (!OSPHelper::checkOwnerExisting() and ( $lists['show_agenttypefilter'] == 0) and ( $show_country_dropdown == 0))
            {
                $location_in_same_line = 0;
            } else
            {
                $location_in_same_line = 1;
            }
            ?>
            <div class="row-fluid">
                <div class="span12">
                    <div id="filter-bar" class="btn-toolbar">
                        <?php
                        if ($lists['show_keywordfilter'] == 1)
                        {
                            ?>
                            <div class="filter-search btn-group pull-left">
                                <input type="text" class="input-large search-query" name="keyword" id="keyword" value="<?php echo htmlspecialchars($lists['keyword']); ?>" />
                            </div>
                            <div class="btn-group pull-left">
                                <input type="submit" class="btn btn-info" value="<?php echo JText::_('OS_FILTER') ?>" />
                                <input type="reset" class="btn btn-warning" value="<?php echo JText::_('OS_RESET') ?>" />
                                <?php
                                if ($show_filter_button == 1)
                                {
                                    ?>
                                    <button class="btn hasTooltip js-stools-btn-filters" id="btn_search_tool" type="button" data-original-title="Filter the list items">
                                        <?php echo JText::_('OS_SEARCH_TOOL'); ?>
                                        <i class="caret"></i>
                                    </button>
                                <?php } ?>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                        if ($lists['show_keywordfilter'] == 0)
                        {
                            ?>
                            <div class="btn-group pull-right">
                                <input type="submit" class="btn btn-info" value="<?php echo JText::_('OS_FILTER') ?>" />
                                <input type="reset" class="btn btn-warning" value="<?php echo JText::_('OS_RESET') ?>" />
                                <?php
                                if ($show_filter_button == 1)
                                {
                                    ?>
                                    <button class="btn hasTooltip js-stools-btn-filters" id="btn_search_tool" type="button" data-original-title="Filter the list items">
                                        <?php echo JText::_('OS_SEARCH_TOOL'); ?>
                                        <i class="caret"></i>
                                    </button>
                                <?php } ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="btn-group pull-right">
                            <?php echo $lists['ordertype']; ?>
                        </div>
                        <div class="btn-group pull-right">
                            <?php echo $lists['sortby']; ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"> </div>
                <div class="row-fluid" id="filter_tool_div" style="display:none;">
                    <div class="span12">
                        <div id="filter-bar" class="btn-toolbar">
                            <?php
                            if ($lists['show_pricefilter'] == 1)
                            {
                                if ($configClass['price_filter_type'] == 1)
                                {
                                    $style = "min-width:250px;";
                                } else
                                {
                                    $style = "";
                                }
                                ?>
                                <div class="btn-group pull-right" style="<?php echo $style; ?>" id="price_filter"><label>
                                        <?php
                                        if ($configClass['price_filter_type'] == 0)
                                        {
                                            $element_id = "id='pricefilter'";
                                        } else
                                        {
                                            $element_id = "";
                                        }
                                        OSPHelper::showPriceFilter($lists['price_value'], $lists['min_price'], $lists['max_price'], $lists['property_type'], '', 'list');
                                        ?></label>
                                </div>
                                <?php
                                if ($configClass['price_filter_type'] == 1)
                                {
                                    ?>
                                    <div class="btn-group pull-right" style="margin-right:15px;margin-right:15px;"><label class="control-label"><strong><?php echo Jtext::_('OS_PRICE'); ?></strong></label></div>
                                    <?php
                                }
                            }
                            if ($lists['show_propertytypefilter'] == 1)
                            {
                                ?>
                                <div class="btn-group pull-right">
                                    <?php echo $lists['type']; ?>
                                </div>
                                <?php
                                if ($lists['show_pricefilter'] == 1)
                                {
                                    OSPHelper::showPriceTypesConfig();
                                    ?>
                                    <script type="text/javascript">
                                        //filter form with property type and price
                                        jQuery("#property_type").change(function () {
                                            updateLocatorPrice(jQuery("#property_type").val(), "<?php echo JUri::root(); ?>");
                                        });
                                        function updateLocatorPrice(type_id, live_site) {
                                            xmlHttp = GetXmlHttpObject();
                                            url = live_site + "index.php?option=com_osproperty&no_html=1&tmpl=component&task=ajax_updatePrice&type_id=" + type_id + "&option_id=<?php echo $lists['price_value']; ?>&min_price=<?php echo $lists['min_price']; ?>&max_price=<?php echo $lists['max_price']; ?>&module_id=list";
                                            xmlHttp.onreadystatechange = ajax_updateLocatorSearch;
                                            xmlHttp.open("GET", url, true)
                                            xmlHttp.send(null)
                                        }

                                        function ajax_updateLocatorSearch() {
                                            if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
                                                var mod_osservice_price = document.getElementById("price_filter");
                                                if (mod_osservice_price != null) {
                                                    mod_osservice_price.innerHTML = xmlHttp.responseText;
                                                    var ptype = jQuery("#property_type").val();
                                                    jQuery.ui.slider.prototype.widgetEventPrefix = 'slider';
                                                    jQuery(function () {
                                                        var min_value = jQuery("#min" + ptype).val();
                                                        min_value = parseFloat(min_value);
                                                        var step_value = jQuery("#step" + ptype).val();
                                                        step_value = parseFloat(step_value);
                                                        var max_value = jQuery("#max" + ptype).val();
                                                        max_value = parseFloat(max_value);
                                                        jQuery("#listsliderange")[0].slide = null;
                                                        jQuery("#listsliderange").slider({
                                                            range: true,
                                                            min: min_value,
                                                            step: step_value,
                                                            max: max_value,
                                                            values: [min_value, max_value],
                                                            slide: function (event, ui) {
                                                                var price_from = ui.values[0];
                                                                var price_to = ui.values[1];
                                                                jQuery("#listprice_from_input1").val(price_from);
                                                                jQuery("#listprice_to_input1").val(price_to);

                                                                price_from = price_from.formatMoney(0, ',', '.');
                                                                price_to = price_to.formatMoney(0, ',', '.');

                                                                jQuery("#listprice_from_input").text(price_from);
                                                                jQuery("#listprice_to_input").text(price_to);
                                                            }
                                                        });
                                                    });
                                                    Number.prototype.formatMoney = function (decPlaces, thouSeparator, decSeparator) {
                                                        var n = this,
                                                                decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
                                                                decSeparator = decSeparator == undefined ? "." : decSeparator,
                                                                thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
                                                                sign = n < 0 ? "-" : "",
                                                                i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
                                                                j = (j = i.length) > 3 ? j % 3 : 0;
                                                        return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
                                                    };
                                                }
                                            }
                                        }
                                    </script>
                                    <?php
                                }
                            }
                            ?>
                            <?php
                            if (OSPHelper::checkOwnerExisting() and ( $lists['show_agenttypefilter'] == 1))
                            {
                                ?>
                                <div class="btn-group pull-right">
                                    <?php
                                    OSPHelper::loadAgentTypeDropdownFilter($lists['agenttype'], 'input-medium selectpicker', '');
                                    ?>
                                </div>

                                <?php
                            }
                            ?>
                            <?php
                            if (($show_country_dropdown == 1) and ( $show_location_div == 1))
                            {
                                ?>
                            </div>
                            <div id="filter-bar" class="btn-toolbar">
                                <?php
                            }
                            ?>
                            <?php
                            if ($show_location_div == 1)
                            {
                                if ($location_in_same_line == 0)
                                {
                                    ?>
                                    <div class="clearfix"></div>
                                <?php } ?>
                                <div class="btn-group pull-right" id="city_div">
                                    <?php echo $lists['city']; ?>
                                </div>
                                <?php
                                if (OSPHelper::userOneState())
                                {
                                    ?>
                                    <input type="hidden" name="state_id" id="state_id" value="<?php echo OSPHelper::returnDefaultState(); ?>" />
                                    <?php
                                } else
                                {
                                    ?>
                                    <div class="btn-group pull-right" id="div_state">
                                        <?php echo $lists['state']; ?>
                                    </div>
                                    <?php
                                }
                                if ($show_country_dropdown == 1)
                                {
                                    ?>
                                    <div class="btn-group pull-right">
                                        <?php echo $lists['country']; ?>
                                    </div>
                                    <?php
                                } else
                                {
                                    echo $lists['country'];
                                }
                            }
                            ?>
                        </div>
                        <?php
                        if ($lists['show_categoryfilter'] == 1)
                        {
                            ?>
                            <div class="clearfix"></div>
                            <div id="filter-bar" class="btn-toolbar">
                                <label class="control-label"><strong><?php echo JText::_('OS_CATEGORY') ?></strong></label>

                                <div class="row-fluid">
                                    <div class="span12">
                                        <?php
                                        $k = 0;
                                        foreach ($lists['category'] as $cat)
                                        {
                                            $k++;
                                            ?>
                                            <div class="span3"><label class="checkbox"><?php echo $cat; ?></label></div>
                                            <?php
                                            if ($k == 4)
                                            {
                                                $k = 0;
                                                ?>
                                            </div></div><div class="row-fluid"><div class="span12">
                                                <?php
                                            }
                                        }
                                        ?>
                                        <input type="hidden" name="submitCategory" id="submitCategory" value="1"/>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        if ($show_submit == 1)
                        {
                            ?>
                            <div id="filter-bar" class="btn-toolbar">
                                <div class="btn-group pull-right">
                                    <input type="submit" class="btn btn-info" value="<?php echo JText::_('OS_FILTER') ?>" />
                                    <input type="reset" class="btn btn-warning" value="<?php echo JText::_('OS_RESET') ?>" />
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                jQuery("#btn_search_tool").click(function () {
                    jQuery("#filter_tool_div").slideToggle("slow");
                });
            </script>
            <?php
        }
    }

    /**
     * Show advanced search form
     *
     * @param unknown_type $groups
     * @param unknown_type $lists
     * @param unknown_type $type_id_search
     */
    static function advsearchForm($groups, $lists, $type_id_search)
    {
        global $jinput, $configClass, $ismobile;
        ?>
        <div class="row-fluid">
            <div class="span12" style="margin-left:0px;">
                <div class="span4">
                    <fieldset>
                        <h3>
                            <?php echo JText::_('OS_GENERAL_INFORMATION'); ?>
                        </h3>
                        <?php
                        if (OSPHelper::checkOwnerExisting())
                        {
                            ?>
                            <div class="span12">
                                <strong>
                                    <?php echo JText::_('OS_PROPERTIES_POSTED_BY') ?>:
                                </strong>
                                <div class="clearfix"></div>
                                <?php echo $lists['agenttype']; ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="span12">
                            <strong>
                                <?php echo JText::_('OS_CATEGORY') ?>:
                            </strong>
                            <div class="clearfix"></div>
                            <?php echo $lists['category']; ?>
                        </div>
                        <?php
                        if (($configClass['adv_type_ids'] == "0") or ( $configClass['adv_type_ids'] == ""))
                        {
                            ?>
                            <div class="span12">
                                <strong>
                                    <?php echo JText::_('OS_PROPERTY_TYPE') ?>:
                                </strong>
                                <div class="clearfix"></div>
                                <?php echo $lists['type']; ?>
                            </div>
                            <?php
                        } else
                        {
                            ?>
                            <input type="hidden" name="property_type" id="property_type" value="<?php echo $type_id_search ?>" />
                        <?php }
                        ?>

                        <div class="span12">
                            <strong>
                                <?php echo JText::_('OS_KEYWORD'); ?>
                            </strong>
                            <div class="clearfix"></div>
                            <input type="text" class="input-large" value="<?php echo htmlspecialchars($lists['keyword_value']) ?>" name="keyword" style="width:180px !important;" />
                        </div>
                        <div class="span12">

                            <?php
                            $isFeatured = $jinput->getInt('isFeatured', 0);
                            if ($isFeatured == 1)
                            {
                                $checked = "checked";
                            } else
                            {
                                $checked = "";
                            }
                            ?>
                            <input type="checkbox" name="isFeatured" id="isFeatured" value="<?php echo $isFeatured; ?>" <?php echo $checked; ?> onclick="javascript:changeValue('isFeatured')" />
                            &nbsp;
                            <strong>
                                <?php echo JText::_('OS_FEATURED'); ?> 
                            </strong>
                        </div>
                        <div class="span12">
                            <?php
                            $isSold = $jinput->getInt('isSold', 0);
                            if ($isSold == 1)
                            {
                                $checked = "checked";
                            } else
                            {
                                $checked = "";
                            }
                            ?>
                            <input type="checkbox" name="isSold" id="isSold" value="<?php echo $isSold; ?>" <?php echo $checked; ?> onclick="javascript:changeValue('isSold')" />
                            &nbsp;
                            <strong>
                                <?php echo JText::_('OS_SOLD'); ?> 
                            </strong>
                        </div>
                        <div class="span12">
                            <strong>
                                <?php echo JText::_('OS_PRICE_RANGE') ?>
                            </strong>
                            <BR />
                            <?php
                            //echo $lists['price']; 
                            OSPHelper::showPriceFilter($lists['price_value'], $lists['min_price'], $lists['max_price'], $lists['adv_type'], '', 'adv');
                            ?>
                        </div>
                    </fieldset>
                </div>
                <div class="span4">
                    <fieldset>
                        <h3>
                            <?php echo JText::_('OS_LOCATION'); ?>
                        </h3>
                        <div class="span12">
                            <strong>
                                <?php echo JText::_('OS_PLEASE_ENTER_LOCATION'); ?>
                            </strong>
                            <div class="clearfix"></div>
                            <input type="text" class="input-large" value="<?php echo htmlspecialchars($lists['address_value']); ?>" name="address" style="width:180px !important;" />
                        </div>
                        <?php
                        if (HelperOspropertyCommon::checkCountry())
                        {
                            ?>
                            <div class="span12">
                                <strong>
                                    <?php echo JText::_('OS_COUNTRY') ?>
                                </strong>
                                <div class="clearfix"></div>
                                <?php echo $lists['country'] ?>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                        if (OSPHelper::userOneState())
                        {
                            echo $lists['state'];
                        } else
                        {
                            ?>
                            <div class="span12">
                                <strong>
                                    <?php echo JText::_('OS_STATE') ?>
                                </strong>
                                <div class="clearfix"></div>
                                <div id="country_state">
                                    <?php echo $lists['state'] ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="span12">
                            <strong>
                                <?php echo JText::_('OS_CITY') ?>
                            </strong>
                            <div class="clearfix"></div>
                            <div id="city_div">
                                <?php echo $lists['city'] ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <h3>
                            <?php echo JText::_('OS_ORDERING'); ?>
                        </h3>
                        <div class="span12">
                            <div class="span6" style="margin-left:0px">
                                <strong>
                                    <?php echo JText::_('OS_SORTBY') ?>:
                                </strong>
                            </div>
                            <div class="span6" style="margin-left:0px">
                                <?php echo $lists['sortby']; ?>
                            </div>
                        </div>
                        <div class="span12">
                            <div class="span6" style="margin-left:0px">
                                <strong>
                                    <?php echo JText::_('OS_ORDERBY') ?>:
                                </strong>
                            </div>
                            <div class="span6" style="margin-left:0px">
                                <?php echo $lists['orderby']; ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="span4">
                    <fieldset>
                        <?php
                        if (($configClass['use_bathrooms'] == 1) or ( $configClass['use_bedrooms'] == 1) or ( $configClass['use_nfloors'] == 1) or ( $configClass['use_rooms'] == 1) or ( $configClass['use_squarefeet'] == 1))
                        {
                            ?>
                            <h3>
                                <?php echo JText::_('OS_OTHER_INFORMATION'); ?>
                            </h3>
                            <?php
                            if ($configClass['use_bathrooms'] == 1)
                            {
                                ?>
                                <div class="span12">
                                    <div class="span6" style="margin-left:0px">
                                        <strong>
                                            <?php echo JText::_('OS_BATHROOMS') ?>:
                                        </strong>
                                    </div>
                                    <div class="span6" style="margin-left:0px">
                                        <?php echo $lists['nbath']; ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if ($configClass['use_bedrooms'] == 1)
                            {
                                ?>
                                <div class="span12">
                                    <div class="span6" style="margin-left:0px">
                                        <strong>
                                            <?php echo JText::_('OS_BEDROOMS') ?>:
                                        </strong>
                                    </div>
                                    <div class="span6" style="margin-left:0px">
                                        <?php echo $lists['nbed']; ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if ($configClass['use_nfloors'] == 1)
                            {
                                ?>
                                <div class="span12">
                                    <div class="span6" style="margin-left:0px">
                                        <strong>
                                            <?php echo JText::_('OS_FLOORS') ?>:
                                        </strong>
                                    </div>
                                    <div class="span6" style="margin-left:0px">
                                        <?php echo $lists['nfloor']; ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if ($configClass['use_rooms'] == 1)
                            {
                                ?>
                                <div class="span12">
                                    <div class="span6" style="margin-left:0px">
                                        <strong>
                                            <?php echo JText::_('OS_ROOMS') ?>:
                                        </strong>
                                    </div>
                                    <div class="span6" style="margin-left:0px">
                                        <?php echo $lists['nroom']; ?>
                                    </div>
                                </div>
                                <?php
                            }
                            if ($configClass['use_squarefeet'] == 1)
                            {
                                ?>
                                <div class="span12">
                                    <strong>
                                        <?php
                                        if ($configClass['use_square'] == 0)
                                        {
                                            echo JText::_('OS_SQUARE_FEET');
                                        } else
                                        {
                                            echo JText::_('OS_SQUARE_METER');
                                        }
                                        ?>
                                        <?php
                                        echo "(";
                                        if ($configClass['use_square'] == 0)
                                        {
                                            echo "ft";
                                        } else
                                        {
                                            echo "m2";
                                        }
                                        echo ")";
                                        ?>
                                        :
                                    </strong>
                                    <div class="clearfix"></div>
                                    <input type="text" class="input-mini" name="sqft_min" id="sqft_min" placeholder="<?php echo JText::_('OS_MIN') ?>" value="<?php echo isset($lists['sqft_min']) ? $lists['sqft_min'] : ""; ?>" />
                                    &nbsp;-&nbsp;
                                    <input type="text" class="input-mini" name="sqft_max" id="sqft_max" placeholder="<?php echo JText::_('OS_MAX') ?>" value="<?php echo isset($lists['sqft_max']) ? $lists['sqft_max'] : ""; ?>"/>
                                </div>
                                <div class="span12">
                                    <strong>
                                        <?php
                                        echo JText::_('OS_LOT_SIZE');
                                        ?>
                                        (<?php echo OSPHelper::showSquareSymbol(); ?>)
                                        :
                                    </strong>
                                    <div class="clearfix"></div>
                                    <input type="text" class="input-mini" name="lotsize_min" id="lotsize_min" placeholder="<?php echo JText::_('OS_MIN') ?>" value="<?php echo isset($lists['lotsize_min']) ? $lists['lotsize_min'] : ""; ?>" />
                                    &nbsp;-&nbsp;
                                    <input type="text" class="input-mini" name="lotsize_max" id="lotsize_max" placeholder="<?php echo JText::_('OS_MAX') ?>" value="<?php echo isset($lists['lotsize_max']) ? $lists['lotsize_max'] : ""; ?>"/>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </fieldset>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php
            $db = JFactory::getDbo();
            $db->setQuery("Select count(id) from #__osrs_amenities where  published = '1'");
            $amenities = $db->loadResult();
            $db->setQuery("Select count(id) from #__osrs_extra_fields where published = '1' and searchable = '1'");
            $countfields = $db->loadResult();
            if ((($countfields > 0) or ( $amenities > 0)) and ( $configClass['show_more']))
            {
                ?>
                <span class="more_option" id="more_option_span"><?php echo JText::_('OS_MORE_OPTION') ?>&nbsp; <i class="osicon-chevron-down"></i></span>

                <div id="more_option_div" style="display:none;">
                    <?php
                    if ($amenities > 0)
                    {
                        ?>
                        <div class="block_caption">
                            <?php echo JText::_('OS_AMENITIES') ?>
                        </div>
                        <div class="row-fluid">
                            <div class="span12">
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

                                $amenities_post = $jinput->get('amenities', array(), 'ARRAY');
                                $j = 0;
                                for ($k = 0; $k < count($optionArr); $k++)
                                {
                                    $j++;
                                    $db->setQuery("Select * from #__osrs_amenities where category_id = '" . $k . "' and published = '1'");
                                    $amenities = $db->loadObjectList();
                                    if (count($amenities) > 0)
                                    {
                                        ?>
                                        <div class="span4" style="float:left;padding-right:5px;margin-left:0px;">
                                            <strong>
                                                <?php echo $optionArr[$k]; ?>
                                            </strong>
                                            <BR />
                                            <?php
                                            for ($i = 0; $i < count($amenities); $i++)
                                            {
                                                if (isset($amenities_post))
                                                {
                                                    if (in_array($amenities[$i]->id, $amenities_post))
                                                    {
                                                        $checked = "checked";
                                                    } else
                                                    {
                                                        $checked = "";
                                                    }
                                                } else
                                                {
                                                    $checked = "";
                                                }
                                                ?>
                                                <input type="checkbox" name="amenities[]" <?php echo $checked ?> value="<?php echo $amenities[$i]->id; ?>" /> <?php echo OSPHelper::getLanguageFieldValue($amenities[$i], 'amenities'); ?>
                                                <BR />
                                            <?php }
                                            ?>
                                        </div>
                                        <?php
                                        if ($j == 3)
                                        {
                                            $j = 0;
                                            echo "</div></div><div style='height:15px'></div><div class='row-fluid'><div class='span12'>";
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <?php
                    }
                    $fieldLists = array();
                    for ($i = 0; $i < count($groups); $i++)
                    {
                        $group = $groups[$i];
                        if (count($group->fields) > 0)
                        {
                            ?>
                            <div class="span12" style="margin-left:0px;">
                                <div class="block_caption">
                                    <?php echo OSPHelper::getLanguageFieldValue($group, 'group_name'); ?>
                                </div>
                                <?php
                                $fields = $group->fields;
                                for ($j = 0; $j < count($fields); $j++)
                                {
                                    $field = $fields[$j];
                                    $fieldLists[] = $field->id;
                                    ?>
                                    <div class="row-fluid" style="" id="advextrafield_<?php echo $field->id; ?>">
                                        <?php
                                        HelperOspropertyFields::showFieldinAdvSearch($field, 1);
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <?php
                                }
                                ?>
                            </div>		
                            <div class="clearfix"></div>
                            <?php
                        }
                    }
                    ?>
                </div>
            <?php } ?>
            <input type="hidden" name="advfieldLists" id="advfieldLists" value="<?php echo implode(",", $fieldLists) ?>" />
            <div class="clearfix"></div>
            <div class="span12" style="text-align:right;margin-left:0px;">
                <input type="submit" class="btn btn-info" value="<?php echo JText::_('OS_SEARCH') ?>" />
                <input type="button" onclick="javascript:document.ftForm.reset();" class="btn btn-warning" value="<?php echo JText::_('OS_RESET') ?>" />
                <?php
                if (!$ismobile)
                {
                    $user = JFactory::getUser();
                    if (intval($user->id) > 0)
                    {
                        ?>
                        <input type="button" class="btn btn-warning" value="<?php echo JText::_('OS_SAVE_TO_SEARCH_LIST_ADDNEW') ?>" onclick="javascript:saveSearchList();" />
                        <?php
                    }

                    if ($jinput->getInt('list_id', 0) > 0)
                    {
                        ?>
                        <input type="button" class="btn btn-success" value="<?php echo JText::_('OS_SAVE_TO_SEARCH_LIST_UPDATE') ?>" onclick="javascript:updateSearchList();" />
                        <?php
                    }
                }
                //}
                ?>
            </div>
        </div>
        <script type="text/javascript">
            jQuery("#property_types").change(function () {
                var fields = jQuery("#advfieldLists").val();
                var fieldArr = fields.split(",");
                if (fieldArr.length > 0) {
                    for (i = 0; i < fieldArr.length; i++) {
                        jQuery("#advextrafield_" + fieldArr[i]).hide("fast");
                    }
                }
                //var selected_value = jQuery("#propserty_types").val();
                var selected_value = [];
                var property_types = document.getElementById('property_types');
                var j = 0;
                for (i = 0; i < property_types.length; i++) {
                    if (property_types.options[i].selected == true) {
                        selected_value[j] = property_types.options[i].value;
                        j++;
                    }
                }
                //alert(selected_value);
                //var selected_value = []; 
                //jQuery('#propserty_types :selected').each(function(i, selectedoption){ 
                //selected_value[i] = jQuery(selectedoption).val(); 

                //});
                //alert(selected_value);
                if (selected_value.length > 0) {

                    for (j = 0; j < selected_value.length; j++) {
                        var selected_fields = jQuery("#advtype_id_" + selected_value[j]).val();
                        //alert(selected_fields);
                        var fieldArr = selected_fields.split(",");
                        if (fieldArr.length > 0) {
                            for (i = 0; i < fieldArr.length; i++) {
                                jQuery("#advextrafield_" + fieldArr[i]).show("slow");
                            }
                        }
                    }
                }
            });
        </script>
        <?php
    }

    /**
     * Generate price dropdown select list
     *
     * @param unknown_type $type_id
     * @param unknown_type $price_id
     * @return unknown
     */
    public static function generatePriceList($type_id, $price_id, $classname = 'input-large')
    {
        global $jinput, $configClass;
        $db = JFactory::getDbo();
        $prices = array();
        if ($type_id > 0)
        {
            $db->setQuery("Select * from #__osrs_pricegroups where type_id = '$type_id' and published = '1' order by ordering");
            $prices = $db->loadObjectList();
        }
        if (count($prices) == 0)
        {
            $db->setQuery("Select * from #__osrs_pricegroups where type_id = '0' and published = '1' order by ordering");
            $prices = $db->loadObjectList();
        }
        $priceArr = array();
        $priceArr[] = JHTML::_('select.option', '', JText::_('OS_PRICE_FILTER'));
        for ($i = 0; $i < count($prices); $i++)
        {
            $price = $prices[$i];
            $text = "";
            if ($price->price_from == "0.00")
            {
                $text .= " < ";
                $text .= $configClass['curr_symbol'] . " " . HelperOspropertyCommon::showPrice($price->price_to);
            } else
            {
                if ($price->price_to != "0.00")
                {
                    $text .= $configClass['curr_symbol'] . " " . HelperOspropertyCommon::showPrice($price->price_from);
                    $text .= " - ";
                    $text .= $configClass['curr_symbol'] . " " . HelperOspropertyCommon::showPrice($price->price_to);
                } else
                {
                    $text .= " > ";
                    $text .= $configClass['curr_symbol'] . " " . HelperOspropertyCommon::showPrice($price->price_from);
                }
            }

            $priceArr[] = JHTML::_('select.option', $price->id, $text);
        }
        return JHTML::_('select.genericlist', $priceArr, 'price', 'class="' . $classname . '"', 'value', 'text', $price_id);
    }

    /**
     * Locator search form
     *
     * @param unknown_type $lists
     * @param unknown_type $type_id
     * @param unknown_type $configs
     */
    static function generateLocatorForm($lists, $type_id)
    {
        global $jinput, $configClass, $ismobile;
        $search_Arr = array();
        if ($type_id > 0)
        {
            echo '<input type="hidden"  name="property_type" value="' . $type_id . '" />';
        }
        ?>
        <input type="hidden" name="orderby" id="orderby" value="<?php echo $lists['orderby'] ?>"/>
        <input type="hidden" name="sortby" id="sortby" value="<?php echo $lists['sortby'] ?>"/>

        <div class="row-fluid locatorpage" style="margin-top:10px;">
            <div class="span12">
                <div class="navbar">
                    <div class="navbar-inner">
                        <ul class="nav">
                            <li class="active">
                                <input type="text" name="location" id="location" class="input-large" value="<?php echo stripslashes($lists['location']); ?>" placeholder="<?php echo JText::_('OS_SEARCH_ADDRESS_EXPLAIN') ?>" />
                            </li>
                            <li class="active"><?php echo $lists['radius']; ?></li>
                            <?php
                            if ($configClass['locator_show_category'] == 1)
                            {
                                ?>
                                <li class="divider-vertical  hidden-phone"></li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown">
                                        <?php echo JText::_('OS_CATEGORIES'); ?><b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php
                                        echo $lists['category'];
                                        ?>
                                    </ul>
                                </li>
                                <?php
                                $locator_type_idArrs = $lists['locator_type_idArrs'];
                                if (($locator_type_idArrs[0] == 0) and ( $configClass['locator_show_type'] == 1))
                                {
                                    ?>
                                    <li class="divider-vertical  hidden-phone"></li>
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown">
                                            <?php echo JText::_('OS_TYPE'); ?><b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php
                                            echo $lists['type'];
                                            ?>
                                        </ul>
                                    </li>
                                    <?php
                                }
                                ?>
                            <?php } ?>
                            <li class="divider-vertical hidden-phone"></li>
                            <li class="dropdown hidden-phone">
                                <a class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo JText::_('OS_MORE_OPTION'); ?><b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <div class="control-group">
                                        <label class="control-label"><?php echo JText::_('OS_PRICE') ?>:</label>
                                        <div class="controls">
                                            <?php
                                            OSPHelper::showPriceFilter($lists['price_value'], $lists['min_price'], $lists['max_price'], $lists['locator_type'], '', 'adv');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"><?php echo JText::_('OS_KEYWORD') ?>:</label>
                                        <div class="controls">
                                            <input type="text" class="input-medium" name="keyword" id="keyword" value="<?php echo htmlspecialchars($lists['keyword']) ?>" placeholder="e.g: pool,fireplace" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"><?php echo JText::_('OS_SORTBY') ?>:</label>
                                        <div class="controls">
                                            <?php echo $lists['sort']; ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"><?php echo JText::_('OS_ORDERBY') ?>:</label>
                                        <div class="controls">
                                            <?php echo $lists['order']; ?>
                                        </div>
                                    </div>
                                    <?php
                                    if (($configClass['use_bedrooms'] == 1) and ( $configClass['locator_showbedrooms'] == 1))
                                    {
                                        ?>
                                        <div class="control-group">
                                            <label class="control-label"><?php echo JText::_('OS_BEDS') ?>:</label>
                                            <div class="controls">
                                                <?php echo $lists['nbed']; ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if (($configClass['use_bedrooms'] == 1) and ( $configClass['locator_showbathrooms'] == 1))
                                    {
                                        ?>
                                        <div class="control-group">
                                            <label class="control-label"><?php echo JText::_('OS_BATHS') ?>:</label>
                                            <div class="controls">
                                                <?php echo $lists['nbath']; ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if (($configClass['use_rooms'] == 1) and ( $configClass['locator_showrooms'] == 1))
                                    {
                                        ?>
                                        <div class="control-group">
                                            <label class="control-label"><?php echo JText::_('OS_ROOMS') ?>:</label>
                                            <div class="controls">
                                                <?php echo $lists['nroom']; ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if (($configClass['use_squarefeet'] == 1) and ( $configClass['locator_showsquarefeet'] == 1))
                                    {
                                        ?>
                                        <div class="control-group">
                                            <label class="control-label">
                                                <?php
                                                if ($configClass['use_square'] == 0)
                                                {
                                                    echo JText::_('OS_SQUARE_FEET');
                                                } else
                                                {
                                                    echo JText::_('OS_SQUARE_METER');
                                                }
                                                ?>
                                                <?php
                                                echo "(";
                                                if ($configClass['use_square'] == 0)
                                                {
                                                    echo "ft";
                                                } else
                                                {
                                                    echo "m2";
                                                }
                                                echo ")";
                                                ?>
                                                :
                                            </label>
                                            <div class="controls">
                                                <input type="text" class="input-mini" name="sqft_min" id="sqft_min" placeholder="<?php echo JText::_('OS_MIN') ?>" value="<?php echo $lists['sqft_min']; ?>" />
                                                &nbsp;-&nbsp;
                                                <input type="text" class="input-mini" name="sqft_max" id="sqft_max" placeholder="<?php echo JText::_('OS_MAX') ?>" value="<?php echo $lists['sqft_max']; ?>"/>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li class="divider-vertical  hidden-phone"></li>
                            <li>
                                <a href="javascript:updateMyLocation();" title="<?php echo JText::_('OS_SEARCH_AROUND_MY_LOCATION'); ?>">
                                    <?php echo JText::_('OS_MY_LOCATION'); ?>
                                </a>
                            </li>
                            <li class="divider-vertical  hidden-phone"></li>
                            <li class="active"><button type="button" onclick="javascript:checkingLocatorForm();" id="applylocatorform" class="btn btn-info"><i class="osicon-search"></i></button></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    static function generateMembershipForm($agentAcc, $area, $pid)
    {
        global $jinput, $mainframe, $configClass;
        $db = JFactory::getDbo();
        $expired_time = self::getRealTime();
        $expired_feature_time = self::getRealTime();
        if ($area == "property")
        {
            if ($pid == 0)
            {
                ?>
                <span class="label label-warning"><?php echo JText::_('OS_PLEASE_SELECT_SUB_PLAN_FOR_THIS_PROPERTY'); ?></span>
                <?php
            } else
            {
                $db->setQuery("Select * from #__osrs_properties where id = '$pid'");
                $property = $db->loadObject();
                ?>
                <strong>
                    <?php echo JText::_('OS_PROPERTY_NOW_IS'); ?>
                    <?php
                    if ($property->approved == 1)
                    {
                        $db->setQuery("Select expired_time from #__osrs_expired where pid = '$pid'");
                        $expired_time = $db->loadResult();
                        $expired_time = strtotime($expired_time);
                    }
                    if ($property->isFeatured == 1)
                    {
                        $db->setQuery("Select expired_feature_time from #__osrs_expired where pid = '$pid'");
                        $expired_feature_time = $db->loadResult();
                        $expired_feature_time = strtotime($expired_feature_time);
                    }
                    if ($property->approved == 1)
                    {
                        echo JText::_('OS_APPROVED');
                        if ($configClass['general_use_expiration_management'] == 1)
                        {
                            echo '<span style="font-size:11px;font-weight:normal;"> (' . JText::_('OS_EXPIRED_ON') . ': ' . OSPHelper::returnDateformat($expired_time) . ')</span>';
                        }
                    } else
                    {
                        echo JText::_('OS_UNAPPROVED');
                    }

                    if ($property->isFeatured == 1)
                    {
                        echo ' ' . JText::_('OS_AND') . ' ' . JText::_('OS_FEATURED') . ' ';
                        if ($configClass['general_use_expiration_management'] == 1)
                        {
                            echo '<span style="font-size:11px;font-weight:normal;"> (' . JText::_('OS_EXPIRED_ON') . ': ' . OSPHelper::returnDateformat($expired_feature_time) . ')</span>';
                        }
                    }
                    ?>
                    <BR/>
                    <?php
                    if (count($agentAcc) > 0)
                    {
                        echo JText::_('OS_YOU_CAN_USE_BELLOW_SUBSCRIPTION_PLAN_TO');
                        $arr = array();
                        if ($property->approved == 0)
                        {
                            $arr[] = JText::_('OS_APPROVAL_THE_PROPERTY');
                        } else
                        {
                            $arr[] = JText::_('OS_EXTEND_APPROVAL_TIME_THE_PROPERTY');
                        }
                        if ($property->isFeatured == 0)
                        {
                            $arr[] = JText::_('OS_MAKE_PROPERTY_FEATURED');
                        } else
                        {
                            $arr[] = JText::_('OS_EXTEND_THE_FEATURE_TIME_THE_PROPERTY');
                        }
                        echo implode(" " . JText::_('OS_OR') . " ", $arr);
                    } else
                    {
                        $redirect_link = JRoute::_("index.php?option=com_osmembership");
                        echo "<a href='" . $redirect_link . "'>" . JText::_('OS_PLEASE_CLICK_HERE_TO_PURCHASE_MEMBERSHIP') . "</a>";
                    }
                    ?>
                </strong>
                <?php
            }
        }
        ?>
        <table width="100%" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="35%" style="text-align:left;padding-left:10px;background-color:#444;color:white;" class="nowrap">
                        <?php echo JText::_('OS_PLAN'); ?>
                    </th>
                    <th width="20%" style="text-align:left;padding-left:10px;background-color:#444;color:white;" class="nowrap">
                        <span class="hasTip" title="<?php echo JText::_('OS_ACCOUNT_REMAINING'); ?>::<?php echo JText::_('OS_ACCOUNT_REMAINING_EXPLAIN'); ?>">
                            <?php echo JText::_('OS_ACCOUNT_REMAINING'); ?>
                        </span>
                    </th>
                    <?php
                    if ($configClass['general_use_expiration_management'] == 1)
                    {
                        ?>
                        <th width="45%" style="text-align:left;padding-left:10px;background-color:#444;color:white;" class="nowrap hidden-phone">
                            <span class="hasTip" title="<?php echo JText::_('OS_PROPERTY_WILL_EXPIRED_ON'); ?>::<?php echo JText::_('OS_PROPERTY_WILL_EXPIRED_ON_EXPLAIN'); ?>">
                                <?php echo JText::_('OS_PROPERTY_WILL_EXPIRED_ON'); ?>
                            </span>
                        </th>
                    <?php } ?>
                </tr>
            </thead>
            <?php
            if (count($agentAcc) > 0)
            {
                $k = 0;
                for ($i = 0; $i < count($agentAcc); $i++)
                {
                    $acc = $agentAcc[$i];
                    if ($pid == 0)
                    {
                        if ($i == 0)
                        {
                            $checked = "checked";
                        } else
                        {
                            $checked = "";
                        }
                    } else
                    {
                        if (($property->approved == 0) and ( $property->isFeatured == 0))
                        {
                            //if($i==0){
                            //	$checked = "checked";
                            //}else{
                            //	$checked = "";
                            //}
                        }
                    }
                    ?>
                    <tr class="row<?php echo $k; ?>">
                        <td width="35%" style="text-align:left;padding-left:10px;">
                            <input type="radio" name="membership_sub_id" id="membership_sub_id" value="<?php echo $acc->sub_id ?>" <?php echo $checked ?> />
                            <?php echo $acc->title ?>
                        </td>
                        <td width="20%" style="text-align:left;padding-left:10px;">
                            <?php echo $acc->nproperties ?> 
                            <span style="font-size:11px;font-weight:normal;">
                                (<?php echo OSPHelper::returnDateformat(strtotime($acc->from_date)); ?> 
                                <?php echo JText::_('OS_TO') ?> 
                                <?php echo OSPHelper::returnDateformat(strtotime($acc->to_date)); ?>)
                            </span>
                        </td>
                        <?php
                        if ($configClass['general_use_expiration_management'] == 1)
                        {
                            ?>
                            <td width="45%" style="text-align:left;padding-left:10px;">
                                <?php
                                //echo OSPHelper::returnDateformat($acc->expired);
                                if ($acc->type == 0)
                                {
                                    echo OSPHelper::returnDateformat(self::getExpiredNormal($expired_time, 1));
                                } else
                                {
                                    echo OSPHelper::returnDateformat(self::getExpiredFeature($expired_feature_time, 1));
                                }
                                ?>
                            </td>
                        <?php } ?>
                    </tr>
                    <?php
                    $k = 1 - $k;
                }
            }
            ?>
        </table>
        <?php
    }

    static function generateMembershipFormUpgradeProperties($agentAcc, $area, $pid)
    {
        global $jinput, $mainframe, $configClass;
        $db = JFactory::getDbo();
        $expired_time = self::getRealTime();
        $expired_feature_time = self::getRealTime();
        if ($area == "property")
        {
            if ($pid == 0)
            {
                ?>
                <span class="label label-warning"><?php echo JText::_('OS_PLEASE_SELECT_SUB_PLAN_FOR_THIS_PROPERTY'); ?></span>
                <?php
            } else
            {

                $db->setQuery("Select * from #__osrs_properties where id = '$pid'");
                $property = $db->loadObject();

                if (count($agentAcc) > 0)
                {
                    
                } else
                {
                    $redirect_link = JRoute::_("index.php?option=com_osmembership");
                    echo "<a href='" . $redirect_link . "'>" . JText::_('OS_PLEASE_CLICK_HERE_TO_PURCHASE_MEMBERSHIP') . "</a>";
                }
            }
        }
        ?>
        <table width="100%">
            <tr>
                <td width="20%" style="text-align:left;padding-left:20px;border-bottom:1px solid #FFFFFF !important;">
                    <?php echo JText::_('OS_PLAN'); ?>
                </td>
                <td width="40%" style="text-align:left;padding-left:20px;border-bottom:1px solid #FFFFFF !important;">
                    <span class="hasTip" title="<?php echo JText::_('OS_ACCOUNT_REMAINING'); ?>::<?php echo JText::_('OS_ACCOUNT_REMAINING_EXPLAIN'); ?>">
                        <?php echo JText::_('OS_ACCOUNT_REMAINING'); ?>
                    </span>
                </td>
                <?php
                if ($configClass['general_use_expiration_management'] == 1)
                {
                    ?>
                    <td width="40%" style="text-align:left;padding-left:20px;border-bottom:1px solid #FFFFFF !important;">
                        <span class="hasTip" title="<?php echo JText::_('OS_PROPERTY_WILL_EXPIRED_ON'); ?>::<?php echo JText::_('OS_PROPERTY_WILL_EXPIRED_ON_EXPLAIN'); ?>">
                            <?php echo JText::_('OS_PROPERTY_WILL_EXPIRED_ON'); ?>
                        </span>
                    </td>
                    <?php
                }
                ?>
            </tr>

            <?php
            if (count($agentAcc) > 0)
            {
                for ($i = 0; $i < count($agentAcc); $i++)
                {
                    $acc = $agentAcc[$i];
                    if ($i % 2 == 0)
                    {
                        $background = "#549EDE";
                    } else
                    {
                        $background = "#F95A9A";
                    }
                    if ($pid == 0)
                    {
                        if ($i == 0)
                        {
                            $checked = "checked";
                        } else
                        {
                            $checked = "";
                        }
                    } else
                    {
                        if (($property->approved == 0) and ( $property->isFeatured == 0))
                        {
                            //if($i==0){
                            //	$checked = "checked";
                            //}else{
                            //	$checked = "";
                            //}
                        }
                    }
                    ?>
                    <tr>
                        <td width="20%" style="text-align:left;padding-left:20px;background-color:<?php echo $background ?>;">
                            <input type="radio" name="membership_sub_id" id="membership_sub_id" value="<?php echo $acc->sub_id ?>" <?php echo $checked ?> />
                            <?php echo $acc->title ?>
                        </td>
                        <td width="40%" style="text-align:left;padding-left:20px;background-color:<?php echo $background ?>;">
                            <?php echo $acc->nproperties ?> <span style="font-size:11px;font-weight:normal;">(<?php echo OSPHelper::returnDateformat(strtotime($acc->from_date)); ?> <?php echo JText::_('OS_TO') ?> <?php echo OSPHelper::returnDateformat(strtotime($acc->to_date)); ?>)</span>
                        </td>
                        <?php
                        if ($configClass['general_use_expiration_management'] == 1)
                        {
                            ?>
                            <td width="40%" style="text-align:left;padding-left:20px;background-color:<?php echo $background ?>;">
                                <?php
                                //echo OSPHelper::returnDateformat($acc->expired);
                                if ($acc->type == 0)
                                {
                                    echo OSPHelper::returnDateformat(self::getExpiredNormal($expired_time, 1));
                                } else
                                {
                                    echo OSPHelper::returnDateformat(self::getExpiredFeature($expired_feature_time, 1));
                                }
                                ?>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
        <?php
    }

    /**
     * Compare expired time and feature expired time, if the feature expired time is longer than expired time
     * Update expired time = feature expired time
     *
     * @param unknown_type $pid
     */
    function adjustExpiredTime($pid)
    {
        global $jinput, $mainframe;
        $db = JFactory::getDbo();
        $db->setQuery("Select isFeatured from #__osrs_properties where id = '$pid'");
        $isFeatured = $db->loadResult();
        if ($isFeatured == 1)
        {
            $db->setQuery("Select * from #__osrs_expired where pid = '$pid'");
            $expired = $db->loadObject();
            $expired_time = intval(strtotime($expired->send_expired));
            $expired_feature_time = intval(strtotime($expired->expired_feature_time));
            if ($expired_feature_time > $expired_time)
            {
                $expired_time = $expired_feature_time;
            }

            $unpublish_time = $expired_time;
            $remove_time = intval($configClass['general_unpublished_days']);
            $send_appro = $configClass['send_approximates'];
            $appro_days = intval($configClass['approximates_days']);

            $send_appro = $configClass['send_approximates'];
            $appro_days = $configClass['approximates_days'];
            //allow to send the approximates expired day
            if ($send_appro == 1)
            {
                $inform_time = $unpublish_time - $appro_days * 24 * 3600;
                $inform_time = date("Y-m-d H:i:s", $inform_time);
            } else
            {
                $inform_time = "";
            }
            $remove_time = $unpublish_time + $remove_time * 24 * 3600;
            $remove_time = date("Y-m-d H:i:s", $remove_time);
            $unpublish_time = date("Y-m-d H:i:s", $unpublish_time);
            //insert into #__osrs_expired
            $db->setQuery("UPDATE #__osrs_expired SET inform_time = '$inform_time',expired_time='$unpublish_time',remove_from_database='$remove_time' WHERE pid = '$pid'");
            $db->query();
        }
    }

    /**
     * List of extra fields
     *
     */
    static function getExtrafieldInList()
    {
        global $jinput, $mainframe, $configClass;
        $db = Jfactory::getDBO();
        $user = JFactory::getUser();
        $query = "";
        $query .= ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
        $db->setQuery("Select * from #__osrs_extra_fields where published = '1' $query and show_on_list = '1' order by ordering");
        $rows = $db->loadObjectList();
        return $rows;
    }

    /**
     * Sharing form
     */
    public static function sharingForm($row, $itemid)
    {
        $configClass = OSPHelper::loadConfig();
        $user = JFactory::getUser();
        ?>
        <div class="leadFormWrap">
            <form method="POST" action="<?php echo JURI::root() ?>index.php?option=com_osproperty&task=property_submittellfriend&Itemid=<?php echo $itemid ?>" name="tellfriend_form" id="tellfriend_form" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('OS_FRIEND_NAME'); ?></label>
                    <div class="controls">
                        <input class="input-large" type="text" id="friend_name" name="friend_name" maxlength="50" placeholder="<?php echo JText::_('OS_FRIEND_NAME'); ?>"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('OS_FRIEND_EMAIL'); ?></label>
                    <div class="controls">
                        <input class="input-large" type="text" id="friend_email" name="friend_email" maxlength="50" placeholder="<?php echo JText::_('OS_FRIEND_EMAIL'); ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('OS_YOUR_NAME'); ?></label>
                    <div class="controls">
                        <input class="input-large" type="text" id="your_name" name="your_name" maxlength="50" placeholder="<?php echo JText::_('OS_YOUR_NAME'); ?>" value="<?php echo $user->name; ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('OS_YOUR_EMAIL'); ?></label>
                    <div class="controls">
                        <input type="text" id="your_email" name="your_email" maxlength="50" class="input-large" placeholder="<?php echo JText::_('OS_YOUR_EMAIL'); ?>" value="<?php echo $user->email; ?>"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('OS_MESSAGE'); ?></label>
                    <div class="controls">
                        <textarea id="message" name="message" rows="3" cols="50" class="input-large" style="height:150px !important;"></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('OS_SECURITY_CODE'); ?></label>
                    <div class="controls">
                        <span class="grey_small" style="line-height:16px;"><?php echo JText::_('OS_PLEASE_INSERT_THE_SYMBOL_FROM_THE_INAGE_TO_FIELD_BELOW') ?></span>
                        <div class="clear"></div>
                        <img src="<?php echo JURI::root() ?>index.php?option=com_osproperty&no_html=1&task=property_captcha&ResultStr=<?php echo $row->ResultStr ?>" />
                        <input type="text" class="input-mini" id="sharing_security_code" name="sharing_security_code" maxlength="5" style="width: 50px; margin: 0;" />
                    </div>
                </div>

                <div class="clear"></div>

                <input class="btn btn-primary" type="button" name="finish" value="<?php echo JText::_('OS_SEND'); ?>" onclick="javascript:submitForm('tellfriend_form');"/>
                <span class="reg_loading" id="tf_loading">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <input type="hidden" name="captcha_str" id="captcha_str" value="<?php echo $row->ResultStr ?>" />
                <input type="hidden" name="option" value="com_osproperty" />
                <input type="hidden" name="task" value="property_submittellfriend" />
                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                <input type="hidden" name="Itemid" value="<?php echo $itemid; ?>" />
                <input type="hidden" name="require_field" id="require_field" value="friend_name,friend_email,sharing_security_code" />
                <input type="hidden" name="require_label" id="require_label" value="<?php echo JText::_('OS_FRIEND_NAME'); ?>,<?php echo JText::_('OS_FRIEND_EMAIL'); ?>,<?php echo JText::_('OS_SECURITY_CODE') ?>" />
            </form>
        </div>
        <?php
    }

    /**
     * Show request More details form
     * @param $row
     * @param $item
     */
    public static function requestMoreDetails($row, $itemid)
    {
        $configClass = OSPHelper::loadConfig();
        $user = JFactory::getUser();
        ?>
        <div class="leadFormWrap">
            <form method="POST" action="<?php echo JURI::root() ?>index.php?option=com_osproperty&task=property_requestmoredetails&Itemid=<?php echo $itemid ?>" name="requestdetails_form" id="requestdetails_form" class="form-horizontal">
                <div class="_leadError ajax-error"></div>
                <div class="control-group">
                    <label class="control-label">
                        <?php echo JText::_('OS_SUBJECT'); ?>
                    </label>
                    <div class="controls">
                        <select name='subject' id='subject' class='input-large' onchange="javascript:updateRequestForm(this.value)">
                            <option value='1'><?php echo JText::_('OS_REQUEST_1') ?></option>
                            <option value='2'><?php echo JText::_('OS_REQUEST_2') ?></option>
                            <option value='3'><?php echo JText::_('OS_REQUEST_3') ?></option>
                            <option value='4'><?php echo JText::_('OS_REQUEST_4') ?></option>
                            <option value='5'><?php echo JText::_('OS_REQUEST_5') ?></option>
                            <option value='6'><?php echo JText::_('OS_REQUEST_6') ?></option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">
                        <?php echo JText::_('OS_YOUR_NAME'); ?>
                    </label>
                    <div class="controls">
                        <input class="input-large" type="text" id="requestyour_name" name="requestyour_name" size="30" maxlength="50"  value="<?php echo $user->name ?>" placeholder="<?php echo JText::_('OS_YOUR_NAME') ?>"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">
                        <?php echo JText::_('OS_PHONE'); ?>
                    </label>
                    <div class="controls">
                        <input class="input-large" type="text" id="your_phone" name="your_phone" maxlength="50" placeholder="<?php echo JText::_('OS_PHONE') ?>"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">
                        <?php echo JText::_('OS_YOUR_EMAIL'); ?>
                    </label>
                    <div class="controls">
                        <input class="input-large" type="text" id="requestyour_email" name="requestyour_email" size="30" maxlength="50"  value="<?php echo $user->email; ?>" placeholder="<?php echo JText::_('OS_YOUR_EMAIL') ?>"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">
                        <?php echo JText::_('OS_MESSAGE'); ?>
                    </label>
                    <div class="controls">
                        <textarea class="input-large" id="requestmessage" name="requestmessage" rows="3" cols="60" style="width:250px !important;height:150px !important;"><?php echo JText::_('OS_REQUEST_MSG1') ?> <?php echo ($row->ref != "") ? $row->ref . ", " : "" ?><?php echo $row->pro_name ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">
                        <?php echo JText::_('OS_SECURITY_CODE'); ?>
                    </label>
                    <div class="controls">
                        <span class="grey_small" style="line-height:16px;"><?php echo JText::_('OS_PLEASE_INSERT_THE_SYMBOL_FROM_THE_INAGE_TO_FIELD_BELOW') ?></span>
                        <div class="clearfix"></div>
                        <img src="<?php echo JURI::root() ?>index.php?option=com_osproperty&no_html=1&task=property_captcha&ResultStr=<?php echo $row->ResultStr ?>" />
                        <input type="text" class="input-mini" id="request_security_code" name="request_security_code" maxlength="5" style="width: 50px; margin: 0;" />
                    </div>
                </div>
                <?php
                if ($configClass['request_term_condition'] == 1)
                {
                    JHTML::_("behavior.modal", "a.osmodal");
                    ?>
                    <div class="control-group" style="text-align:center;">
                        <input type="checkbox" name="termcondition" id="termcondition" value="1" />
                        &nbsp;
                        <?php echo JText::_('OS_READ_TERM'); ?> 
                        <a href="<?php echo JURI::root() ?>index.php?option=com_content&view=article&id=<?php echo $configClass['request_article_id']; ?>&tmpl=component" class="osmodal" rel="{handler: 'iframe', size: {x: 600, y: 450}}" title="<?php echo JText::_('OS_TERM_AND_CONDITION'); ?>"><?php echo JText::_('OS_TERM_AND_CONDITION'); ?></a>
                    </div>
                    <?php
                }
                ?>
                <div class="clearfix"></div>
                <div class="control-group">
                    <input class="btn btn-info" type="button" id="requestbutton" name="requestbutton" value="<?php echo JText::_("OS_REQUEST_BUTTON1") ?>" onclick="javascript:submitForm('requestdetails_form');"/>
                    <input type="hidden" name="csrqt<?php echo intval(date("m", time())) ?>" id="csrqt<?php echo intval(date("m", time())) ?>" value="<?php echo $row->ResultStr ?>" />
                    <input type="hidden" name="captcha_str" id="captcha_str" value="<?php echo $row->ResultStr ?>" />
                </div>
                <input type="hidden" name="option" value="com_osproperty" />
                <input type="hidden" name="task" value="property_requestmoredetails" />
                <input type="hidden" name="id" value="<?php echo $row->id ?>" />
                <input type="hidden" name="Itemid" value="<?php echo $itemid; ?>" />
                <input type="hidden" name="require_field" id="require_field" value="requestmessage,requestyour_name,requestyour_email,request_security_code" />
                <input type="hidden" name="require_label" id="require_label" value="<?php echo JText::_('OS_REQUEST_DETAILS'); ?>,<?php echo JText::_('OS_YOUR_NAME'); ?>,<?php echo JText::_('OS_YOUR_EMAIL'); ?>,<?php echo JText::_('OS_SECURITY_CODE') ?>" />
            </form>
            <?php
            $property_name = "";
            if ($row->ref != "")
            {
                $property_name = $row->ref . ", " . $row->pro_name;
            } else
            {
                $property_name = $row->pro_name;
            }
            ?>
            <script type="text/javascript">
                function updateRequestForm(subject) {
                    var message = document.getElementById('requestmessage');
                    var requestbutton = document.getElementById('requestbutton');
                    if (subject == 1) {
                        message.value = "<?php echo JText::_('OS_REQUEST_MSG1') ?> <?php echo $property_name; ?>";
                                    requestbutton.value = "<?php echo JText::_('OS_REQUEST_BUTTON1') ?>";
                                } else if (subject == 2) {
                                    message.value = "<?php printf(JText::_('OS_REQUEST_MSG2'), $property_name); ?>";
                                    requestbutton.value = "<?php echo JText::_('OS_REQUEST_BUTTON2') ?>";
                                } else if (subject == 3) {
                                    message.value = "<?php echo JText::_('OS_REQUEST_MSG3') ?> <?php echo $property_name; ?>";
                                                requestbutton.value = "<?php echo JText::_('OS_REQUEST_BUTTON3') ?>";
                                            } else if (subject == 4) {
                                                message.value = "<?php echo JText::_('OS_REQUEST_MSG4') ?> <?php echo $property_name; ?>";
                                                            requestbutton.value = "<?php echo JText::_('OS_REQUEST_BUTTON4') ?>";
                                                        } else if (subject == 5) {
                                                            message.value = "<?php echo JText::_('OS_REQUEST_MSG5') ?> <?php echo $property_name; ?>";
                                                                        requestbutton.value = "<?php echo JText::_('OS_REQUEST_BUTTON5') ?>";
                                                                    } else if (subject == 6) {
                                                                        message.value = "<?php echo JText::_('OS_REQUEST_MSG6') ?> <?php echo $property_name; ?>";
                                                                                    requestbutton.value = "<?php echo JText::_('OS_REQUEST_BUTTON6') ?>";
                                                                                }
                                                                            }
            </script>
        </div>
        <?php
    }

    /**
     * Show request More details form
     * @param $row
     * @param $item
     */
    public static function requestMoreDetailsTop($row, $itemid, $classname = 'input-medium')
    {
        $configClass = OSPHelper::loadConfig();
        $user = JFactory::getUser();
        ?>
        <div class="leadFormWrap">
            <form method="POST" action="<?php echo JURI::root() ?>index.php?option=com_osproperty&task=property_requestmoredetails&Itemid=<?php echo $itemid ?>" name="requestdetails_form" id="requestdetails_form">
                <div class="_leadError ajax-error"></div>
                <select name='subject' id='subject' class='<?php echo $classname; ?>' onchange="javascript:updateRequestForm(this.value)">
                    <option value='1'><?php echo JText::_('OS_REQUEST_1') ?></option>
                    <option value='2'><?php echo JText::_('OS_REQUEST_2') ?></option>
                    <option value='3'><?php echo JText::_('OS_REQUEST_3') ?></option>
                    <option value='4'><?php echo JText::_('OS_REQUEST_4') ?></option>
                    <option value='5'><?php echo JText::_('OS_REQUEST_5') ?></option>
                    <option value='6'><?php echo JText::_('OS_REQUEST_6') ?></option>
                </select>

                <input class="<?php echo $classname; ?>" type="text" id="requestyour_name" name="requestyour_name" size="30" maxlength="50"  value="<?php echo $user->name ?>" placeholder="<?php echo JText::_('OS_YOUR_NAME') ?>"/>
                <input class="<?php echo $classname; ?>" type="text" id="your_phone" name="your_phone" maxlength="50" placeholder="<?php echo JText::_('OS_PHONE') ?>"/>
                <input class="<?php echo $classname; ?>" type="text" id="requestyour_email" name="requestyour_email" size="30" maxlength="50"  value="<?php echo $user->email; ?>" placeholder="<?php echo JText::_('OS_YOUR_EMAIL') ?>"/>


                <textarea style="height:100px !important;" class="<?php echo $classname; ?>" id="requestmessage" name="requestmessage" rows="3" cols="60"><?php echo JText::_('OS_REQUEST_MSG1') ?> <?php echo ($row->ref != "") ? $row->ref . ", " : "" ?><?php echo $row->pro_name ?></textarea>
                <div class="clearfix"></div>
                <span class="grey_small" style="line-height:16px;"><?php echo JText::_('OS_PLEASE_INSERT_THE_SYMBOL_FROM_THE_INAGE_TO_FIELD_BELOW') ?></span>
                <div class="clearfix"></div>
                <img src="<?php echo JURI::root() ?>index.php?option=com_osproperty&no_html=1&task=property_captcha&ResultStr=<?php echo $row->ResultStr ?>" />
                <input type="text" class="input-mini" id="request_security_code" name="request_security_code" maxlength="5" style="width: 50px; margin: 0;" />
                <?php
                if ($configClass['request_term_condition'] == 1)
                {
                    JHTML::_("behavior.modal", "a.osmodal");
                    ?>
                    <div class="control-group" style="text-align:left;">
                        <input type="checkbox" name="termcondition" id="termcondition" value="1" />
                        &nbsp;
                        <?php echo JText::_('OS_READ_TERM'); ?> 
                        <a href="<?php echo JURI::root() ?>index.php?option=com_content&view=article&id=<?php echo $configClass['request_article_id']; ?>&tmpl=component" class="osmodal" rel="{handler: 'iframe', size: {x: 600, y: 450}}" title="<?php echo JText::_('OS_TERM_AND_CONDITION'); ?>"><?php echo JText::_('OS_TERM_AND_CONDITION'); ?></a>
                    </div>
                    <?php
                }
                ?>
                <div class="clearfix"></div>
                <input class="btn btn-info" type="button" id="requestbutton" name="requestbutton" value="<?php echo JText::_("OS_REQUEST_BUTTON1") ?>" onclick="javascript:submitForm('requestdetails_form');"/>
                <input type="hidden" name="csrqt<?php echo intval(date("m", time())) ?>" id="csrqt<?php echo intval(date("m", time())) ?>" value="<?php echo $row->ResultStr ?>" />
                <input type="hidden" name="captcha_str" id="captcha_str" value="<?php echo $row->ResultStr ?>" />
                <input type="hidden" name="option" value="com_osproperty" />
                <input type="hidden" name="task" value="property_requestmoredetails" />
                <input type="hidden" name="id" value="<?php echo $row->id ?>" />
                <input type="hidden" name="Itemid" value="<?php echo $itemid; ?>" />
                <input type="hidden" name="require_field" id="require_field" value="requestmessage,requestyour_name,requestyour_email,request_security_code" />
                <input type="hidden" name="require_label" id="require_label" value="<?php echo JText::_('OS_REQUEST_DETAILS'); ?>,<?php echo JText::_('OS_YOUR_NAME'); ?>,<?php echo JText::_('OS_YOUR_EMAIL'); ?>,<?php echo JText::_(OS_SECURITY_CODE) ?>" />
            </form>
            <?php
            $property_name = "";
            if ($row->ref != "")
            {
                $property_name = $row->ref . ", " . $row->pro_name;
            } else
            {
                $property_name = $row->pro_name;
            }
            ?>
            <script type="text/javascript">
                function updateRequestForm(subject) {
                    var message = document.getElementById('requestmessage');
                    var requestbutton = document.getElementById('requestbutton');
                    if (subject == 1) {
                        message.value = "<?php echo JText::_('OS_REQUEST_MSG1') ?> <?php echo $property_name; ?>";
                                    requestbutton.value = "<?php echo JText::_('OS_REQUEST_BUTTON1') ?>";
                                } else if (subject == 2) {
                                    message.value = "<?php printf(JText::_('OS_REQUEST_MSG2'), $property_name); ?>";
                                    requestbutton.value = "<?php echo JText::_('OS_REQUEST_BUTTON2') ?>";
                                } else if (subject == 3) {
                                    message.value = "<?php echo JText::_('OS_REQUEST_MSG3') ?> <?php echo $property_name; ?>";
                                                requestbutton.value = "<?php echo JText::_('OS_REQUEST_BUTTON3') ?>";
                                            } else if (subject == 4) {
                                                message.value = "<?php echo JText::_('OS_REQUEST_MSG4') ?> <?php echo $property_name; ?>";
                                                            requestbutton.value = "<?php echo JText::_('OS_REQUEST_BUTTON4') ?>";
                                                        } else if (subject == 5) {
                                                            message.value = "<?php echo JText::_('OS_REQUEST_MSG5') ?> <?php echo $property_name; ?>";
                                                                        requestbutton.value = "<?php echo JText::_('OS_REQUEST_BUTTON5') ?>";
                                                                    } else if (subject == 6) {
                                                                        message.value = "<?php echo JText::_('OS_REQUEST_MSG6') ?> <?php echo $property_name; ?>";
                                                                                    requestbutton.value = "<?php echo JText::_('OS_REQUEST_BUTTON6') ?>";
                                                                                }
                                                                            }
            </script>
        </div>
        <?php
    }

    /**
     * Review form
     */
    public static function reviewForm($row, $itemid, $configClass)
    {
        $user = JFactory::getUser();
        ?>
        <div class="row-fluid">
            <div class="block_caption" id="comment_form_caption">
                <strong><?php echo JText::_('OS_ADD_COMMENT') ?></strong>
            </div>

            <div class="span12">
                <form method="POST" action="<?php echo JURI::root() ?>index.php?option=com_osproperty&task=property_submitcomment&Itemid=<?php echo $itemid; ?>" name="commentForm" id="commentForm" class="form-horizontal">
                    <?php
                    if ($configClass['show_rating'] == 1)
                    {
                        ?>
                        <div class="control-group">
                            <label class="control-label">
                                <?php echo JText::_('OS_RATING'); ?>
                            </label>
                            <div class="controls">
                                <i><?php echo JText::_('OS_WORST'); ?>
                                    &nbsp;
                                    <?php
                                    for ($i = 1; $i <= 5; $i++)
                                    {
                                        if ($i == 3)
                                        {
                                            $checked = "checked";
                                        } else
                                        {
                                            $checked = "";
                                        }
                                        ?>
                                        <input type="radio" name="rating" id="rating<?php echo $i ?>" value="<?php echo $i ?>" <?php echo $checked ?> />
                                        <?php
                                    }
                                    ?>
                                    &nbsp;&nbsp;<?php echo JText::_('OS_BEST'); ?></i>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="control-group">
                        <label class="control-label">
                            <?php echo JText::_('OS_AUTHOR'); ?>
                        </label>
                        <div class="controls">
                            <input class="input-large" type="text" id="comment_author" name="comment_author" maxlength="50" value="<?php echo $user->name; ?>" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">
                            <?php echo JText::_('OS_TITLE'); ?>
                        </label>
                        <div class="controls">
                            <input class="input-large" type="text" id="comment_title" name="comment_title" size="40" placeholder="<?php echo JText::_('OS_TITLE'); ?>" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">
                            <?php echo JText::_('OS_MESSAGE'); ?>
                        </label>
                        <div class="controls">
                            <textarea id="comment_message" name="comment_message" rows="6" cols="50" class="input-large" style="height:150px !important"></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">
                            <?php echo JText::_('OS_SECURITY_CODE'); ?>
                        </label>
                        <div class="controls">
                            <span class="grey_small" style="line-height:16px;"><?php echo JText::_('OS_PLEASE_INSERT_THE_SYMBOL_FROM_THE_INAGE_TO_FIELD_BELOW') ?></span>
                            <div class="clearfix"></div>
                            <img src="<?php echo JURI::root() ?>index.php?option=com_osproperty&no_html=1&task=property_captcha&ResultStr=<?php echo $row->ResultStr ?>" />
                            <input type="text" class="input-mini" id="comment_security_code" name="comment_security_code" maxlength="5" style="width: 50px; margin: 0;" />
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="span12">
                        <input onclick="javascript:submitForm('commentForm')" style="margin: 0; width: 100px;" class="btn btn-warning" type="button" name="finish" value="<?php echo JText::_('OS_SUBMIT') ?>" />
                        <span id="comment_loading" class="reg_loading">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </div>

                    <input type="hidden" name="captcha_str" id="captcha_str" value="<?php echo $row->ResultStr ?>" />
                    <input type="hidden" name="option" value="com_osproperty" />
                    <input type="hidden" name="task" value="property_submitcomment" />
                    <input type="hidden" name="id" value="<?php echo $row->id ?>" />
                    <input type="hidden" name="Itemid" value="<?php echo $itemid ?>" />
                    <input type="hidden" name="require_field" id="require_field" value="comment_author,comment_title,comment_message,comment_security_code" />
                    <input type="hidden" name="require_label" id="require_label" value="<?php echo JText::_('OS_AUTHOR'); ?>,<?php echo JText::_('OS_TITLE'); ?>,<?php echo JText::_('OS_MESSAGE'); ?>,<?php echo JText::_('OS_SECURITY_CODE') ?>" />
                </form>
            </div>
        </div>
        <?php
    }

}
?>