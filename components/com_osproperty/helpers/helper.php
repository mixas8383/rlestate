<?php
/* ------------------------------------------------------------------------
  # helper.php - Ossolution Property
  # ------------------------------------------------------------------------
  # author    Dang Thuc Dam
  # copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  # Websites: http://www.joomdonation.com
  # Technical Support:  Forum - http://www.joomdonation.com/forum.html
 */
// No direct access.
defined('_JEXEC') or die;

class OSPHelper
{

    /**
     * This function is used to load Config and return the Configuration Variable
     *
     */
    public static function loadConfig()
    {
        static $configClass;
        if ($configClass == null)
        {
            $db = Jfactory::getDbo();
            $db->setQuery("Select * from #__osrs_configuration");
            $configs = $db->loadObjectList();
            $configClass = array();
            foreach ($configs as $config)
            {
                $configClass[$config->fieldname] = $config->fieldvalue;
            }

            $curr = $configClass['general_currency_default'];
            $arrCode = array();
            $arrSymbol = array();

            $db->setQuery("Select * from #__osrs_currencies where id = '$curr'");
            $currency = $db->loadObject();
            $symbol = $currency->currency_symbol;
            $index = -1;
            if ($symbol == "")
            {
                $symbol = '$';
            }
            $configClass['curr_symbol'] = $symbol;
        }
        return $configClass;
    }

    function getInstalledVersion()
    {
        if (file_exists(JPATH_ROOT . DS . "components" . DS . "com_osproperty" . DS . "version.txt"))
        {
            $fh = fopen(JPATH_ROOT . DS . "components" . DS . "com_osproperty" . DS . "version.txt", "r");
            $version = fread($fh, filesize(JPATH_ROOT . DS . "components" . DS . "com_osproperty" . DS . "version.txt"));
            @fclose($fh);
            return trim($version);
        }
        return '';
    }

    /**
     * This function is used to check to see whether we need to update the database to support multilingual or not
     *
     * @return boolean
     */
    public static function isSyncronized()
    {
        $db = JFactory::getDbo();
        //#__osrs_tags
        $fields = array_keys($db->getTableColumns('#__osrs_tags'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('keyword_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }

        //osrs_emails
        $fields = array_keys($db->getTableColumns('#__osrs_emails'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('email_title_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }

        //osrs_categories
        $fields = array_keys($db->getTableColumns('#__osrs_categories'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('category_name_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }

        //osrs_amenities
        $fields = array_keys($db->getTableColumns('#__osrs_amenities'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('amenities_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }

        //osrs_fieldgroups
        $fields = array_keys($db->getTableColumns('#__osrs_fieldgroups'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('group_name_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }


        //osrs_osrs_extra_fields
        $fields = array_keys($db->getTableColumns('#__osrs_extra_fields'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('field_label_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }

        //osrs_extra_field_options
        $fields = array_keys($db->getTableColumns('#__osrs_extra_field_options'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('field_option_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }

        //osrs_property_field_value
        $fields = array_keys($db->getTableColumns('#__osrs_property_field_value'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('value_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }


        //osrs_types
        $fields = array_keys($db->getTableColumns('#__osrs_types'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('type_name_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }

        //osrs_properties
        $fields = array_keys($db->getTableColumns('#__osrs_properties'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('pro_name_' . $prefix, $fields))
                {
                    return false;
                }
                if (!in_array('address_' . $prefix, $fields))
                {
                    return false;
                }
                if (!in_array('metadesc_' . $prefix, $fields))
                {
                    return false;
                }
                if (!in_array('metakey_' . $prefix, $fields))
                {
                    return false;
                }
                if (!in_array('pro_browser_title_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }

        //osrs_agents
        $fields = array_keys($db->getTableColumns('#__osrs_agents'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('bio_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }

        //osrs_companies
        $fields = array_keys($db->getTableColumns('#__osrs_companies'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('company_description_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }

        //osrs_states
        $fields = array_keys($db->getTableColumns('#__osrs_states'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('state_name_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }


        //osrs_cities
        $fields = array_keys($db->getTableColumns('#__osrs_cities'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('city_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }

        //osrs_cities
        $fields = array_keys($db->getTableColumns('#__osrs_countries'));
        $extraLanguages = self::getLanguages();
        if (count($extraLanguages))
        {
            foreach ($extraLanguages as $extraLanguage)
            {
                $prefix = $extraLanguage->sef;
                if (!in_array('country_name_' . $prefix, $fields))
                {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get field suffix used in sql query
     *
     * @return string
     */
    public static function getFieldSuffix($activeLanguage = null)
    {
        static $prefix;
        if ($prefix == null)
        {
            if (JLanguageMultilang::isEnabled())
            {
                if (!$activeLanguage)
                    $activeLanguage = JFactory::getLanguage()->getTag();
                if ($activeLanguage != self::getDefaultLanguage())
                {
                    $prefix = '_' . substr($activeLanguage, 0, 2);
                }
            }
        }
        return $prefix;
    }

    /**
     *
     * Function to get all available languages except the default language
     * @return languages object list
     */
    public static function getAllLanguages()
    {
        static $languages;
        if ($languages == null)
        {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $default = self::getDefaultLanguage();
            $query->select('lang_id, lang_code, title, `sef`')
                    ->from('#__languages')
                    ->where('published = 1')
                    ->order('ordering');
            $db->setQuery($query);
            $languages = $db->loadObjectList();
        }
        return $languages;
    }

    /**
     *
     * Function to get all available languages except the default language
     * @return languages object list
     */
    public static function getLanguages()
    {
        static $languages;
        if ($languages == null)
        {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $default = self::getDefaultLanguage();
            $query->select('lang_id, lang_code, title, `sef`')
                    ->from('#__languages')
                    ->where('published = 1')
                    ->where('lang_code != "' . $default . '"')
                    ->order('ordering');
            $db->setQuery($query);
            $languages = $db->loadObjectList();
        }
        return $languages;
    }

    /**
     * Get front-end default language
     * @return string
     */
    public static function getDefaultLanguage()
    {
        $params = JComponentHelper::getParams('com_languages');
        return $params->get('site', 'en-GB');
    }

    /**
     * Get default language of user
     *
     */
    public static function getUserLanguage($user_id)
    {
        $default_language = self::getDefaultLanguage();
        if ($user_id > 0)
        {
            $user = JFactory::getUser($user_id);
            $default_language = $user->getParam('language', $default_language);
        } else
        {
            return $default_language;
        }
        return $default_language;
    }

    public static function getLanguageFieldValue($obj, $fieldname)
    {
        global $languages;
        $lgs = self::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        if ($translatable)
        {
            $suffix = self::getFieldSuffix();
            $returnValue = $obj->{$fieldname . $suffix};
            if ($returnValue == "")
            {
                $returnValue = $obj->{$fieldname};
            }
        } else
        {
            $returnValue = $obj->{$fieldname};
        }
        return $returnValue;
    }

    public static function getLanguageFieldValueBackend($obj, $fieldname, $suffix)
    {
        global $languages;
        $lgs = self::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        if ($translatable)
        {
            $returnValue = $obj->{$fieldname . $suffix};
            if ($returnValue == "")
            {
                $returnValue = $obj->{$fieldname};
            }
        } else
        {
            $returnValue = $obj->{$fieldname};
        }
        return $returnValue;
    }

    /**
     * Syncronize Membership Pro database to support multilingual
     */
    public static function setupMultilingual()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $languages = self::getLanguages();
        if (count($languages))
        {
            //states table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_states");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_states table
                $prefix = $language->sef;
                if (!in_array('state_name_' . $prefix, $fieldArr))
                {
                    $fieldName = 'state_name_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_states` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();
                }
            }

            //cities table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_cities");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_cities table
                $prefix = $language->sef;
                if (!in_array('city_' . $prefix, $fieldArr))
                {
                    $fieldName = 'city_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_cities` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();
                }
            }


            //cities table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_countries");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_countries table
                $prefix = $language->sef;
                if (!in_array('country_name_' . $prefix, $fieldArr))
                {
                    $fieldName = 'country_name_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_countries` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();
                }
            }

            //tags table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_tags");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_emails table
                $prefix = $language->sef;
                //$fields = array_keys($db->getTableColumns('#__osrs_emails'));
                if (!in_array('keyword_' . $prefix, $fieldArr))
                {
                    $fieldName = 'keyword_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_tags` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();
                }
            }


            //emails table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_emails");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_emails table
                $prefix = $language->sef;
                //$fields = array_keys($db->getTableColumns('#__osrs_emails'));
                if (!in_array('email_title_' . $prefix, $fieldArr))
                {
                    $fieldName = 'email_title_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_emails` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();

                    $fieldName = 'email_content_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_emails` ADD  `$fieldName` TEXT NULL;";
                    $db->setQuery($sql);
                    $db->query();
                }
            }

            //categories table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_categories");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_categories table
                $prefix = $language->sef;
                if (!in_array('category_name_' . $prefix, $fieldArr))
                {
                    $fieldName = 'category_name_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_categories` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();

                    $fieldName = 'category_alias_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_categories` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();

                    $fieldName = 'category_description_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_categories` ADD  `$fieldName` TEXT NULL;";
                    $db->setQuery($sql);
                    $db->query();
                }
            }


            //amenities table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_amenities");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_amenities table
                $prefix = $language->sef;
                if (!in_array('amenities_' . $prefix, $fieldArr))
                {
                    $fieldName = 'amenities_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_amenities` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();
                }
            }

            //field group table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_fieldgroups");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_amenities table
                $prefix = $language->sef;
                if (!in_array('group_name_' . $prefix, $fieldArr))
                {
                    $fieldName = 'group_name_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_fieldgroups` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();
                }
            }

            //extra field table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_extra_fields");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_amenities table
                $prefix = $language->sef;
                if (!in_array('field_label_' . $prefix, $fieldArr))
                {
                    $fieldName = 'field_label_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_extra_fields` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();

                    $fieldName = 'field_description_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_extra_fields` ADD  `$fieldName` TEXT NULL;";
                    $db->setQuery($sql);
                    $db->query();
                }
            }


            //field group table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_extra_field_options");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_amenities table
                $prefix = $language->sef;
                if (!in_array('field_option_' . $prefix, $fieldArr))
                {
                    $fieldName = 'field_option_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_extra_field_options` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();
                }
            }

            //osrs_property_field_value table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_property_field_value");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_amenities table
                $prefix = $language->sef;
                if (!in_array('value_' . $prefix, $fieldArr))
                {
                    $fieldName = 'value_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_property_field_value` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();
                }
            }

            //types table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_types");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_amenities table
                $prefix = $language->sef;
                if (!in_array('type_name_' . $prefix, $fieldArr))
                {
                    $fieldName = 'type_name_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_types` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();

                    $fieldName = 'type_alias_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_types` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();
                }
            }


            //properties table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_properties");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_properties table
                $prefix = $language->sef;
                if (!in_array('pro_name_' . $prefix, $fieldArr))
                {
                    $fieldName = 'pro_name_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_properties` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();

                    $fieldName = 'pro_alias_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_properties` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();
                }
                if (!in_array('address_' . $prefix, $fieldArr))
                {
                    $fieldName = 'address_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_properties` ADD  `$fieldName` VARCHAR( 255 );";
                    $db->setQuery($sql);
                    $db->query();
                }
                if (!in_array('pro_small_desc_' . $prefix, $fieldArr))
                {
                    $fieldName = 'pro_small_desc_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_properties` ADD  `$fieldName` TEXT NULL;";
                    $db->setQuery($sql);
                    $db->query();

                    $fieldName = 'pro_full_desc_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_properties` ADD  `$fieldName` TEXT NULL;";
                    $db->setQuery($sql);
                    $db->query();
                }
                if (!in_array('metadesc_' . $prefix, $fieldArr))
                {
                    $fieldName = 'metadesc_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_properties` ADD  `$fieldName` VARCHAR (255) DEFAULT '' NOT NULL;";
                    $db->setQuery($sql);
                    $db->query();

                    $fieldName = 'metakey_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_properties` ADD  `$fieldName` VARCHAR (255) DEFAULT '' NOT NULL;";
                    $db->setQuery($sql);
                    $db->query();
                }
                if (!in_array('pro_browser_title_' . $prefix, $fieldArr))
                {
                    $fieldName = 'pro_browser_title_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_properties` ADD  `$fieldName` VARCHAR( 255 ) DEFAULT '' NOT NULL;";
                    $db->setQuery($sql);
                    $db->query();
                }
            }

            //types table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_agents");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_amenities table
                $prefix = $language->sef;
                if (!in_array('bio_' . $prefix, $fieldArr))
                {
                    $fieldName = 'bio_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_agents` ADD  `$fieldName` TEXT NULL;";
                    $db->setQuery($sql);
                    $db->query();
                }
            }


            //companies table
            $db->setQuery("SHOW COLUMNS FROM #__osrs_companies");
            $fields = $db->loadObjectList();
            if (count($fields) > 0)
            {
                $fieldArr = array();
                for ($i = 0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    $fieldname = $field->Field;
                    $fieldArr[$i] = $fieldname;
                }
            }
            foreach ($languages as $language)
            {
                #Process for #__osrs_amenities table
                $prefix = $language->sef;
                if (!in_array('company_description_' . $prefix, $fieldArr))
                {
                    $fieldName = 'company_description_' . $prefix;
                    $sql = "ALTER TABLE  `#__osrs_companies` ADD  `$fieldName` TEXT NULL;";
                    $db->setQuery($sql);
                    $db->query();
                }
            }
        }
    }

    /**
     * Check the email message
     *
     */
    public static function isEmptyMailContent($subject, $content)
    {
        if (($subject == "") or ( strlen(strip_tags($content)) == 0))
        {
            return false;
        } else
        {
            return true;
        }
    }

    /**
     * Load language from main component
     *
     */
    public static function loadLanguage()
    {
        static $loaded;
        if (!$loaded)
        {
            $lang = JFactory::getLanguage();
            $tag = $lang->getTag();
            if (!$tag)
                $tag = 'en-GB';
            $lang->load('com_osproperty', JPATH_ROOT, $tag);
            $loaded = true;
        }
    }

    /**
     * Load current language
     *
     */
    public static function getCurrentLanguage()
    {
        $lang = JFactory::getLanguage();
        $tag = $lang->getTag();
        if (!$tag)
        {
            $tag = 'en-GB';
        }
        $prefix_language = substr($tag, 0, 2);
        return $prefix_language;
    }

    /**
     * Init data
     *
     */
    public static function initSetup()
    {
        $db = JFactory::getDbo();
        $db->setQuery("Select count(id) from #__osrs_init where `name` like 'import_city'");
        $count = $db->loadResult();
        if ($count == 0)
        {
            $db->setQuery("Select count(id) froM #__osrs_cities where country_id = '194'");
            $count = $db->loadResult();
            if ($count == 0)
            {
                $configSql = JPATH_ADMINISTRATOR . '/components/com_osproperty/sql/cities.osproperty.sql';
                $sql = JFile::read($configSql);
                $queries = $db->splitSql($sql);
                if (count($queries))
                {
                    foreach ($queries as $query)
                    {
                        $query = trim($query);
                        if ($query != '' && $query{0} != '#')
                        {
                            $db->setQuery($query);
                            $db->query();
                        }
                    }
                }
                $db->setQuery("Insert into #__osrs_init (id,`name`,`value`) values (NULL,'import_city','1')");
                $db->query();
            } else
            {
                $db->setQuery("Insert into #__osrs_init (id,`name`,`value`) values (NULL,'import_city','1')");
                $db->query();
            }
        }
    }

    public static function checkBrowers()
    {
        $browser = new OsBrowser();
        $checkismobile = $browser->returnisMobile();
        if (!$checkismobile)
        {
            $checkismobile = $browser->isMobile();
        }
        return $checkismobile;
    }

    public static function loadMedia()
    {
        global $configClass;
        $app = JFactory::getApplication();
        $rootUrl = JURI::root(true);
        $document = JFactory::getDocument();
        if (file_exists(JPATH_ROOT . $current_template . 'html/com_osproperty/css/frontend_style.css'))
        {
            $document->addStyleSheet($rootUrl . '/' . $current_template . '/html/com_osproperty/css/frontend_style.css');
        } else
        {
            $document->addStyleSheet($rootUrl . "/components/com_osproperty/style/frontend_style.css");
        }
        if (file_exists(JPATH_ROOT . '/media/com_osproperty/assets/css/custom.css') && filesize(JPATH_ROOT . '/media/com_osproperty/assets/css/custom.css') > 0)
        {
            $document->addStylesheet($rootUrl . '/media/com_osproperty/assets/css/custom.css');
        }
        $document->addScript($rootUrl . "/components/com_osproperty/js/ajax.js");
    }

    public static function loadBootstrap($loadJs = true)
    {
        global $configClass;
        $app = JFactory::getApplication();
        $current_template = $app->getTemplate();
        $language = JFactory::getLanguage();
        $configClass = self::loadConfig();
        $rootUrl = JURI::root(true);
        $document = JFactory::getDocument();
        if (($configClass['load_bootstrap'] == 1) or ( version_compare(JVERSION, '3.0', 'lt')))
        {
            if ($loadJs)
            {
                $document->addScript($rootUrl . '/components/com_osproperty/js/bootstrap/js/jquery.min.js');
                $document->addScript($rootUrl . '/components/com_osproperty/js/bootstrap/js/jquery-noconflict.js');
                $document->addScript($rootUrl . '/components/com_osproperty/js/bootstrap/js/bootstrap.min.js');
            }
        }
        $document->addStyleSheet($rootUrl . '/components/com_osproperty/js/bootstrap/css/bootstrap.css');
        if ($configClass['load_bootstrap_adv'] == 1)
        {
            if (file_exists(JPATH_ROOT . '/templates/' . $current_template . '/html/com_osproperty/css/bootstrap_adv.css'))
            {
                $document->addStyleSheet($rootUrl . '/templates/' . $current_template . '/html/com_osproperty/css/bootstrap_adv.css');
            } else
            {
                $document->addStyleSheet($rootUrl . '/components/com_osproperty/js/bootstrap/css/bootstrap_adv.css');
            }
        }
        if ($language->isRTL())
        {
            $document->addStyleSheet($rootUrl . '/components/com_osproperty/js/bootstrap/css/bootstrap_rtl.css');
        }
    }

    public static function loadBootstrapStylesheet()
    {
        global $configClass;
        $app = JFactory::getApplication();
        $rootUrl = JURI::root(true);
        $language = JFactory::getLanguage();
        $current_template = $app->getTemplate();
        $configClass = self::loadConfig();
        $document = JFactory::getDocument();
        $document->addStyleSheet($rootUrl . 'components/com_osproperty/js/bootstrap/css/bootstrap.css');
        if ($configClass['load_bootstrap_adv'] == 1)
        {
            if (file_exists(JPATH_ROOT . $current_template . '/html/com_osproperty/css/bootstrap_adv.css'))
            {
                $document->addStyleSheet($rootUrl . '/templates/' . $current_template . '/html/com_osproperty/css/bootstrap_adv.css');
            } else
            {
                $document->addStyleSheet($rootUrl . '/components/com_osproperty/js/bootstrap/css/bootstrap_adv.css');
            }
        }
        if ($language->isRTL())
        {
            $document->addStyleSheet($rootUrl . '/components/com_osproperty/js/bootstrap/css/bootstrap_rtl.css');
        }
    }

    /**
     *
     * Function to load jQuery chosen plugin
     */
    public static function chosen()
    {
        $configClass = self::loadConfig();
        if ($configClass['load_chosen'] == 1)
        {
            $document = JFactory::getDocument();
            if (version_compare(JVERSION, '3.0', 'ge'))
            {
                JHtml::_('formbehavior.chosen', '.chosen');
            } else
            {
                $document->addStyleSheet(JURI::root() . 'components/com_osproperty/js/chosen/chosen.css');
                ?>
                <script src="<?php echo JURI::root() . "components/com_osproperty/js/chosen/chosen.jquery.js"; ?>"
                type="text/javascript"></script>
                <?php
            }
            $document->addScriptDeclaration(
                    "jQuery(document).ready(function(){
	                    jQuery(\".chosen\").chosen();
	                });");
            $chosenLoaded = true;
        }
    }

    /**
     * Load Google JS API file
     */
    public static function loadGoogleJS()
    {
        global $configClass;
        static $loadGoogleJs;
        if ($loadGoogleJs == false)
        {
            $configClass = self::loadConfig();
            if ($configClass['goole_aip_key'] != "")
            {
                $key = "&key=" . $configClass['goole_aip_key'];
            } else
            {
                $key = "";
            }
            if ($suffix != "")
            {
                $suffix = "&" . $suffix;
            }
            $document = JFactory::getDocument();
            $document->addScript("//maps.googleapis.com/maps/api/js?sensor=false" . $key);
            $loadGoogleJs = true;
        }
    }

    public static function generateWaterMark($id)
    {
        global $mainframe, $configClass;
        $db = JFactory::getDbo();
        $use_watermark = $configClass['images_use_image_watermarks'];
        $watermark_all = $configClass['watermark_all'];
        if ($use_watermark == 1)
        {
            //get the first image
            $db->setQuery("Select * from #__osrs_photos where pro_id = '$id' order by ordering");
            $rows = $db->loadObjectList();
            if (count($rows) > 0)
            {
                if ($watermark_all == 1)
                {
                    for ($i = 0; $i < count($rows); $i++)
                    {
                        $row = $rows[$i];
                        $db->setQuery("Select count(id) from #__osrs_watermark where pid = '$id' and image like '$row->image'");
                        $count = $db->loadResult();
                        if ($count == 0)
                        {
                            //do watermark
                            self::generateWaterMarkForPhoto($id, $row->id);
                        }
                    }
                } else
                {
                    $row = $rows[0];
                    $db->setQuery("Select count(id) from #__osrs_watermark where pid = '$id' and image like '$row->image'");
                    $count = $db->loadResult();
                    if ($count == 0)
                    {
                        //do watermark
                        self::generateWaterMarkForPhoto($id, $row->id);
                    }
                }
            }
        }//end checking
    }

//end function 

    public static function generateWaterMarkForPhoto($pid, $photoid)
    {
        global $mainframe, $configClass;
        $db = JFactory::getDbo();
        $db->setQuery("Select * from #__osrs_properties where id = '$pid'");
        $property = $db->loadObject();
        $wtype = $configClass['watermark_type'];
        switch ($wtype)
        {
            case "1":
                $watermark_text = $configClass['watermark_text'];
                switch ($watermark_text)
                {
                    case "1":
                        $db->setQuery("Select category_name from #__osrs_categories where id = '$property->category_id'");
                        $text = $db->loadResult();
                        break;
                    case "2":
                        $db->setQuery("Select type_name from #__osrs_types where id = '$property->pro_type'");
                        $text = $db->loadResult();
                        break;
                    case "3":
                        $text = $configClass['general_bussiness_name'];
                        break;
                    case "4":
                        $text = $configClass['custom_text'];
                        break;
                }
                self::waterMarkText($pid, $photoid, $text);
                break;
            case "2":
                $watermark_photo = $configClass['watermark_photo'];
                if ($watermark_photo == "")
                {
                    self::waterMarkText($pid, $photoid, $configClass['general_bussiness_name']);
                } elseif (!file_exists(JPATH_ROOT . DS . "images" . DS . $watermark_photo))
                {
                    self::waterMarkText($pid, $photoid, $configClass['general_bussiness_name']);
                } else
                {
                    self::waterMarkPhoto($pid, $photoid, $watermark_photo);
                }
                break;
        }
        //update into watermark table
        $db->setQuery("SELECT image FROM #__osrs_photos WHERE id = '$photoid'");
        $photo = $db->loadResult();
        $db->setQuery("INSERT INTO #__osrs_watermark (id,pid,image) VALUES (NULL,'$pid','$photo')");
        $db->query();
    }

    public static function waterMarkText($pid, $photoid, $text)
    {
        $db = JFactory::getDbo();
        $db->setQuery("SELECT image FROM #__osrs_photos WHERE id = '$photoid'");
        $photo = $db->loadResult();
        $image_path = JPATH_ROOT . DS . "images" . DS . "osproperty" . DS . "properties" . DS . $pid . DS . "medium" . DS . $photo;
        self::processTextWatermark($image_path, $text, $image_path);
    }

    public static function waterMarkPhoto($pid, $photoid, $watermarkPhoto)
    {
        $db = JFactory::getDbo();
        $db->setQuery("SELECT image FROM #__osrs_photos WHERE id = '$photoid'");
        $photo = $db->loadResult();
        $image_path = JPATH_ROOT . DS . "images" . DS . "osproperty" . DS . "properties" . DS . $pid . DS . "medium" . DS . $photo;
        self::processPhotoWatermark($image_path, $watermarkPhoto, $image_path);
    }

    function processPhotoWatermark($SourceFile, $tempPhoto, $DestinationFile)
    {
        global $mainframe, $configClass;
        //check the extension of the photo
        list($sw, $sh) = getimagesize(JPATH_ROOT . DS . "images" . DS . $tempPhoto);
        $tempPhotoArr = explode(".", $tempPhoto);
        $SourceFileArr = explode(".", $SourceFile);
        $source_ext = strtolower($SourceFileArr[count($SourceFileArr) - 1]);
        $ext = strtolower($tempPhotoArr[count($tempPhotoArr) - 1]);
        switch ($ext)
        {
            case "jpg":
                $p = imagecreatefromjpeg(JPATH_ROOT . DS . "images" . DS . $tempPhoto);
                break;
            case "png":
                $p = imagecreatefrompng(JPATH_ROOT . DS . "images" . DS . $tempPhoto);
                break;
            case "gif":
                $p = imagecreatefromgif(JPATH_ROOT . DS . "images" . DS . $tempPhoto);
                break;
        }

        list($width, $height) = getimagesize($SourceFile);
        $image = imagecreatetruecolor($sw, $sh);
        imagealphablending($image, false);

        switch ($source_ext)
        {
            case "jpg":
                $image = imagecreatefromjpeg($SourceFile);
                break;
            case "png":
                $image = imagecreatefrompng($SourceFile);
                break;
            case "gif":
                $image = imagecreatefromgif($SourceFile);
                break;
        }

        $image_p = imagecreatetruecolor($width, $height);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);

        $watermark_position = $configClass['watermark_position'];

        $matrix_width3 = round($width / 3);
        $matrix_height3 = round($height / 3);

        $matrix_width2 = round($width / 2);
        $matrix_height2 = round($height / 2);
        switch ($watermark_position)
        {
            case "1":
                $w = 20;
                $h = 20;
                break;
            case "2":
                $w = $matrix_width2 - $sw / 2;
                $h = 20;
                break;
            case "3":
                $w = $matrix_width3 * 3 - 20 - $sw;
                $h = 20;
                break;
            case "4":
                $w = $matrix_width3 * 3 - 20 - $sw;
                $h = $matrix_height2 - $sh / 2;
                break;
            case "5":
                $w = $matrix_width2 - $sw / 2;
                $h = $matrix_height2 - $sh / 2;
                break;
            case "6":
                $w = 20;
                $h = $matrix_height2 - $sh / 2;
                break;
            case "7":
                $w = $matrix_width3 * 3 - 20 - $sw;
                $h = $matrix_height3 * 3 - 20 - $sh;
                break;
            case "8":
                $w = $matrix_width2 - $sw / 2;
                $h = $matrix_height3 * 3 - 20 - $sh;
                break;
            case "9":
                $w = 20;
                $h = $matrix_height3 * 3 - 20 - $sh;
                break;
        }

        imagecopy($image_p, $p, $w, $h, 0, 0, $sw, $sh);
        imagesavealpha($image_p, true);
        switch ($source_ext)
        {
            case "jpg":
                if ($DestinationFile != "")
                {
                    imagejpeg($image_p, $DestinationFile, 100);
                } else
                {
                    header('Content-Type: image/jpeg');
                    imagejpeg($image_p, null, 100);
                };
                break;
            case "png":
                if ($DestinationFile != "")
                {
                    imagejpeg($image_p, $DestinationFile, 100);
                } else
                {
                    header('Content-Type: image/jpeg');
                    imagejpeg($image_p, null, 100);
                };
                break;
            case "gif":
                if ($DestinationFile != "")
                {
                    imagejpeg($image_p, $DestinationFile);
                } else
                {
                    header('Content-Type: image/gif');
                    imagegif($image_p, null, 100);
                };
                break;
        }

        imagedestroy($image);
        imagedestroy($image_p);
    }

    /**
     * Watermaking
     *
     * @param unknown_type $SourceFile
     * @param unknown_type $WaterMarkText
     * @param unknown_type $DestinationFile
     */
    public static function processTextWatermark($SourceFile, $WaterMarkText, $DestinationFile)
    {
        global $mainframe, $configClass;
        list($width, $height) = getimagesize($SourceFile);
        $image_p = imagecreatetruecolor($width, $height);
        $SourceFileArr = explode(".", $SourceFile);
        $source_ext = strtolower($SourceFileArr[count($SourceFileArr) - 1]);

        //$image = imagecreatefromjpeg($SourceFile);
        switch ($source_ext)
        {
            case "jpg":
                $image = imagecreatefromjpeg($SourceFile);
                break;
            case "png":
                $image = imagecreatefrompng($SourceFile);
                break;
            case "gif":
                $image = imagecreatefromgif($SourceFile);
                break;
        }
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
        $watermark_color = $configClass['watermark_color'];
        $watermarkArr = explode(",", $watermark_color);
        $text_color = imagecolorallocate($image_p, $watermarkArr[0], $watermarkArr[1], $watermarkArr[2]);
        $font_family = $configClass['watermark_font'];
        if ($font_family == "")
        {
            $font_family = "arial.ttf";
        }
        $font = JPATH_ROOT . DS . 'components' . DS . 'com_osproperty' . DS . 'helpers' . DS . 'pdf' . DS . 'font' . DS . $font_family;
        $font_size = $configClass['watermark_fontsize'];

        $matrix_width3 = round($width / 3);
        $matrix_height3 = round($height / 3);

        $matrix_width2 = round($width / 2);
        $matrix_height2 = round($height / 2);

        $watermark_position = $configClass['watermark_position'];

        switch ($watermark_position)
        {
            case "1":
                $w = 20;
                $h = 20 + $font_size;
                break;
            case "2":
                $w = $matrix_width2;
                $h = 20 + $font_size;
                break;
            case "3":
                $w = $matrix_width3 * 2 - 20;
                $h = 20 + $font_size;
                break;
            case "4":
                $w = $matrix_width3 * 2 - 20;
                $h = $matrix_height2;
                break;
            case "5":
                //$lenText = imagefontwidth($font_size)*STRLEN($WaterMarkText);
                $p = imagettfbbox($font_size, 0, $font, $WaterMarkText);

                $txt_width = $p[2] - $p[0];
                $w = $matrix_width2;
                $w = $matrix_width2 - round($txt_width / 2);
                $h = $matrix_height2;
                break;
            case "6":
                $w = 20;
                $h = $matrix_height2;
                break;
            case "7":
                $w = $matrix_width3 * 2 - 20;
                $h = $matrix_height3 * 3 - 10 - $font_size;
                break;
            case "8":
                $w = $matrix_width2;
                $h = $matrix_height3 * 3 - 10 - $font_size;
                break;
            case "9":
                $w = 20;
                $h = $matrix_height3 * 3 - 10 - $font_size;
                break;
        }
        imagettftext($image_p, $font_size, 0, $w, $h, $text_color, $font, $WaterMarkText);
        if ($DestinationFile != "")
        {
            imagejpeg($image_p, $DestinationFile, $configClass['images_quality']);
        } else
        {
            header('Content-Type: image/jpeg');
            imagejpeg($image_p, null, $configClass['images_quality']);
        };
        imagedestroy($image);
        imagedestroy($image_p);
    }

    /**
     * Load address in format
     *
     * @param unknown_type $property
     * @return unknown
     */
    public static function generateAddress($property)
    {
        global $mainframe, $configClass;
        $configClass = OSPHelper::loadConfig();
        $address = array();
        $languages = self::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($languages);
        if ($translatable)
        {
            $property_address = self::getLanguageFieldValue($property, 'address');
        } else
        {
            $property_address = $property->address;
        }

        if ((trim($property_address) != "") and ( $property_address != "&nbsp;"))
        {
            $address[0] = trim($property_address);
        } else
        {
            $address[0] = "";
        }
        $address[1] = HelperOspropertyCommon::loadCityName($property->city);
        $address[2] = self::loadSateName($property->state);
        $address[3] = $property->region;
        $address[4] = $property->postcode;

        $address_format = $configClass['address_format'];
        if ($address_format == "")
        { //default value
            $address_format = "0,1,2,3,4";
        }
        //echo $address_format;
        //echo $address_format;
        $returnAddress = array();
        $address_formatArr = explode(",", $address_format);
        for ($i = 0; $i < count($address_formatArr); $i++)
        {
            $item = $address_formatArr[$i];
            if ($address[$item] != "")
            {
                $returnAddress[] = $address[$item];
            }
        }
        if (HelperOspropertyCommon::checkCountry())
        {
            $returnAddress[] = self::loadCountryName($property->country);
        }
        if (count($returnAddress) > 0)
        {
            return implode(", ", $returnAddress);
        } else
        {
            return "";
        }
    }

    public static function loadCityName($city_id)
    {
        global $languages;
        $db = JFactory::getDBO();
        $lgs = self::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        $app = JFactory::getApplication();
        if (($translatable) and ( !$app->isAdmin()))
        {
            $suffix = self::getFieldSuffix();
            $db->setQuery("Select city" . $suffix . " from #__osrs_cities where id = '$city_id'");
        } else
        {
            $db->setQuery("Select city from #__osrs_cities where id = '$city_id'");
        }
        return $db->loadResult();
    }

    public static function loadSateName($state_id)
    {
        global $languages;
        $db = JFactory::getDBO();
        $lgs = self::getLanguages();
        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        $app = JFactory::getApplication();
        if (($translatable) and ( !$app->isAdmin()))
        {
            $suffix = self::getFieldSuffix();
            $db->setQuery("Select state_name" . $suffix . " from #__osrs_states where id = '$state_id'");
        } else
        {
            $db->setQuery("Select state_name from #__osrs_states where id = '$state_id'");
        }
        return $db->loadResult();
    }

    public static function loadCountryName($country_id)
    {
        $languages = self::getLanguages();
        $db = JFactory::getDbo();
        $db->setQuery("Select * from #__osrs_countries where id = '$country_id'");
        $country = $db->loadObject();
        $translatable = JLanguageMultilang::isEnabled() && count($languages);
        if ($translatable)
        {
            $country_name = self::getLanguageFieldValue($country, 'country_name');
        } else
        {
            $country_name = $country->country_name;
        }
        return $country_name;
    }

    public static function returnDateformat($date)
    {
        return date("D, jS M Y H:i", $date);
    }

    public static function resizePhoto($dest, $width, $height)
    {
        global $configClass;
        $custom_thumbnail_photo = $configClass['custom_thumbnail_photo'];
        list($width_orig, $height_orig) = getimagesize($dest);
        if ($width_orig != $width || $height_orig != $height)
        {
            switch ($custom_thumbnail_photo)
            {
                case "0":
                    $thumbimage = new Image($dest);
                    $thumbimage->resize($width, $height);
                    $thumbimage->save($dest, $configClass['images_quality']);
                    break;
                case "2":
                    OsImageHelper::createImage($dest, $dest, $width, $height, true, $configClass['images_quality']);
                    break;
                case "1":
                    $thumbimage = new Image($dest);
                    $thumbimage->resize($width, $height);
                    $thumbimage->save($dest, $configClass['images_quality']);
                    break;
            }
        }
    }

    public static function useBootstrapSlide()
    {
        global $configClass;
        $configClass = self::loadConfig();
        $load_bootstrap = $configClass['load_bootstrap'];
        if ((version_compare(JVERSION, '3.0', 'ge')) and ( intval($load_bootstrap) == 0))
        {
            return true;
        } else if ((version_compare(JVERSION, '3.0', 'ge')) and ( intval($load_bootstrap) == 1))
        {
            return false;
        } else if (version_compare(JVERSION, '3.0', 'lt'))
        {
            return false;
        } else
        {
            return false;
        }
    }

    public static function generateHeading($type, $title, $hardcode = 0)
    {
        global $jinput;
        $org_title = $title;
        $document = JFactory::getDocument();
        $app = JFactory::getApplication();
        $menus = $app->getMenu('site');
        $menu = $menus->getActive();
        if ($hardcode == 1)
        {
            if ($type == 1)
            {
                if ($title != "")
                {
                    $document->setTitle($title);
                }
            } else
            {
                if ($title != "")
                {
                    ?>
                    <div class="componentheading">
                        <?php
                        echo $title;
                        ?>
                    </div>
                    <?php
                }
            }
        } elseif (is_object($menu))
        {
            $params = new JRegistry();
            $params->loadString($menu->params);

            if ($params->get('menu-meta_description'))
            {
                $document->setDescription($params->get('menu-meta_description'));
            }

            if ($params->get('menu-meta_keywords'))
            {
                $document->setMetadata('keywords', $params->get('menu-meta_keywords'));
            }

            if ($params->get('robots'))
            {
                $document->setMetadata('robots', $params->get('robots'));
            }

            if ($type == 1)
            {
                $page_title = $params->get('page_title', '');
                if ($page_title != "")
                {
                    $title = $page_title;
                } elseif ($menu->title != "")
                {
                    $title = $menu->title;
                }

                $task = $jinput->getString('task', '');
                if ($task == "property_details")
                {
                    $title = $org_title;
                }

                if ($app->getCfg('sitename_pagetitles', 0) == 1)
                {
                    $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
                } elseif ($app->getCfg('sitename_pagetitles', 0) == 2)
                {
                    $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
                }

                $document->setTitle($title);
            } else
            {
                $show_page_heading = $params->get('show_page_heading', 1);
                $page_heading = $params->get('page_heading', '');
                if ($show_page_heading == 1)
                {
                    if ($page_heading != "")
                    {
                        ?>
                        <div class="componentheading">
                            <?php
                            echo $page_heading;
                            ?>
                        </div>
                        <?php
                    } elseif ($menu->title != "")
                    {
                        ?>
                        <div class="componentheading">
                            <?php
                            echo $menu->title;
                            ?>
                        </div>
                        <?php
                    } else
                    {
                        ?>
                        <div class="componentheading">
                            <?php
                            echo $title;
                            ?>
                        </div>
                        <?php
                    }
                }
            }
        } else
        {
            if ($type == 1)
            {
                if ($app->getCfg('sitename_pagetitles', 0) == 1)
                {
                    $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
                } elseif ($app->getCfg('sitename_pagetitles', 0) == 2)
                {
                    $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
                }
                $document->setTitle($title);
            } else
            {
                ?>
                <div class="componentheading">
                    <?php
                    echo $title;
                    ?>
                </div>
                <?php
            }
        }
    }

    /**
     * This function is used to create the folder to save property's photo
     *
     * @param unknown_type $pid
     */
    public static function createPhotoDirectory($pid)
    {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');
        if (!JFolder::exists(JPATH_ROOT . '/images/osproperty/properties/' . $pid))
        {
            JFolder::create(JPATH_ROOT . '/images/osproperty/properties/' . $pid);
            //copy index.html to this folder
            JFile::copy(JPATH_COMPONENT . DS . 'index.html', JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/index.html');
        }
        if (!JFolder::exists(JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/medium'))
        {
            JFolder::create(JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/medium');
            JFile::copy(JPATH_COMPONENT . DS . 'index.html', JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/medium/index.html');
        }
        if (!JFolder::exists(JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/thumb'))
        {
            JFolder::create(JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/thumb');
            JFile::copy(JPATH_COMPONENT . DS . 'index.html', JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/thumb/index.html');
        }
    }

    /**
     * Moving photo from general directory to sub directory
     *
     * @param unknown_type $pid
     */
    public static function movingPhoto($pid)
    {
        jimport('joomla.filesystem.file');
        $db = JFactory::getDbo();
        $db->setQuery("Select image from #__osrs_photos where pro_id = '$pid'");
        $rows = $db->loadObjectList();
        if (count($rows) > 0)
        {
            for ($i = 0; $i < count($rows); $i++)
            {
                $row = $rows[$i];
                if ((JFile::exists(JPATH_ROOT . '/images/osproperty/properties/' . $row->image)) and ( !JFile::exists(JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/' . $row->image)))
                {
                    JFile::copy(JPATH_ROOT . '/images/osproperty/properties/' . $row->image, JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/' . $row->image);
                }
                if ((JFile::exists(JPATH_ROOT . '/images/osproperty/properties/medium/' . $row->image)) and ( !JFile::exists(JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/medium/' . $row->image)))
                {
                    JFile::copy(JPATH_ROOT . '/images/osproperty/properties/medium/' . $row->image, JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/medium/' . $row->image);
                }
                if ((JFile::exists(JPATH_ROOT . '/images/osproperty/properties/thumb/' . $row->image)) and ( !JFile::exists(JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/thumb/' . $row->image)))
                {
                    JFile::copy(JPATH_ROOT . '/images/osproperty/properties/thumb/' . $row->image, JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/thumb/' . $row->image);
                }
            }
        }
    }

    /**
     * Moving photo from general directory to sub directory in Sample Data installation
     *
     * @param unknown_type $pid
     */
    public static function movingPhotoSampleData($pid)
    {
        jimport('joomla.filesystem.file');
        $db = JFactory::getDbo();
        $db->setQuery("Select image from #__osrs_photos where pro_id = '$pid'");
        $rows = $db->loadObjectList();
        if (count($rows) > 0)
        {
            for ($i = 0; $i < count($rows); $i++)
            {
                $row = $rows[$i];
                if (JFile::exists(JPATH_ROOT . '/images/osproperty/properties/' . $row->image))
                {
                    JFile::copy(JPATH_ROOT . '/images/osproperty/properties/' . $row->image, JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/' . $row->image);
                }
                if (JFile::exists(JPATH_ROOT . '/images/osproperty/properties/medium/' . $row->image))
                {
                    JFile::copy(JPATH_ROOT . '/images/osproperty/properties/medium/' . $row->image, JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/medium/' . $row->image);
                }
                if (JFile::exists(JPATH_ROOT . '/images/osproperty/properties/thumb/' . $row->image))
                {
                    JFile::copy(JPATH_ROOT . '/images/osproperty/properties/thumb/' . $row->image, JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/thumb/' . $row->image);
                }
            }
        }
    }

    /**
     * Show Property photo
     *
     * @param unknown_type $image
     * @param unknown_type $image_folder
     * @param unknown_type $pid
     * @param unknown_type $style
     * @param unknown_type $class
     * @param unknown_type $js
     */
    public static function showPropertyPhoto($image, $image_folder, $pid, $style, $class, $js)
    {
        $configClass = self::loadConfig();
        if ($image_folder != "")
        {
            $image_folder = $image_folder . '/';
        }
        if ($configClass['load_lazy'])
        {
            $photourl = JUri::root() . "components/com_osproperty/images/assets/loader.gif";
        } else
        {
            $photourl = Juri::root() . 'images/osproperty/properties/' . $pid . '/' . $image_folder . $image;
        }
        if ($image != "")
        {
            if (file_exists(JPATH_ROOT . '/images/osproperty/properties/' . $pid . '/' . $image_folder . $image))
            {
                ?>
                <img
                    src="<?php echo $photourl; ?>" data-original="<?php echo JURI::root() ?>images/osproperty/properties/<?php echo $pid . '/' . $image_folder . $image; ?>"
                    class="<?php echo $class ?> oslazy" style="<?php echo $style ?>" <?php echo $js ?> />
                    <?php
                } else
                {
                    ?>
                <img src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/nopropertyphoto.png"
                     class="<?php echo $class ?>" style="<?php echo $style ?>"/>
                     <?php
                 }
             } else
             {
                 ?>
            <img src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/nopropertyphoto.png"
                 class="<?php echo $class ?>" style="<?php echo $style ?>"/>
                 <?php
             }
         }

         public static function checkImage($image)
         {
             //checks if the file is a browser compatible image
             jimport('joomla.filesystem.file');
             jimport('joomla.filesystem.folder');
             $mimes = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
             //get mime type
             $mime = getimagesize($image);
             $mime = $mime ['mime'];

             $extensions = array('jpg', 'jpeg', 'png', 'gif');
             $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

             if (in_array($extension, $extensions) and in_array($mime, $mimes))
                 return TRUE;
             else
                 JFile::delete($image);
             return 'application/octet-stream';
         }

         public static function getImages($folder)
         {
             $files = array();
             $images = array();

             // check if directory exists
             if (is_dir($folder))
             {
                 if ($handle = opendir($folder))
                 {
                     while (false !== ($file = readdir($handle)))
                     {
                         if ($file != '.' && $file != '..' && $file != 'CVS' && $file != 'index.html')
                         {
                             $files [] = $file;
                         }
                     }
                 }
                 closedir($handle);
                 $i = 0;
                 foreach ($files as $img)
                 {
                     if (!is_dir($folder . DS . $img))
                     {
//					self::checkImage($folder . DS . $img);
                         $images [$i]->name = $img;
                         $images [$i]->folder = $folder;
                         ++$i;
                     }
                 }
             }
             return $images;
         }

         /**
          * Generate alias
          *
          * @param unknown_type $type
          * @param unknown_type $id
          * @param unknown_type $alias
          */
         static function generateAlias($type, $id, $alias = '')
         {
             global $mainframe;
             $db = JFactory::getDbo();
             if ($alias != "")
             {
                 //$alias = JString::increment($alias, 'dash');
                 $alias = JApplication::stringURLSafe($alias);
             }
             switch ($type)
             {
                 case "property":
                     if ($alias != "")
                     {
                         $db->setQuery("Select count(id) from #__osrs_properties where pro_alias like '$alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $pro_alias = $alias . " " . $id;
                         } else
                         {
                             $pro_alias = $alias;
                         }
                     } else
                     {
                         $db->setQuery("Select pro_name from #__osrs_properties where id = '$id'");
                         $pro_name = $db->loadResult();
                         //$pro_alias   = JApplication::stringURLSafe($pro_name);
                         $pro_alias = JApplication::stringURLSafe($pro_name);
                         //$pro_alias = JString::increment($pro_name, 'dash');
                         if ($pro_alias == "")
                         {
                             $pro_alias = JText::_('OS_PROPERTY') . "-" . date("Y-m-d H:i:s", time());
                             $pro_alias = JApplication::stringURLSafe($pro_alias);
                         }
                         $db->setQuery("Select count(id) from #__osrs_properties where pro_alias like '$pro_alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $pro_alias = $pro_alias . " " . $id;
                         }
                     }
                     $pro_alias = JApplication::stringURLSafe($pro_alias);
                     return $pro_alias;
                     break;
                 case "agent":
                     if ($alias != "")
                     {
                         $db->setQuery("Select count(id) from #__osrs_agents where alias like '$alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $agent_alias = $alias . " " . $id;
                         } else
                         {
                             $agent_alias = $alias;
                         }
                     } else
                     {
                         $db->setQuery("Select name from #__osrs_agents where id = '$id'");
                         $agent_name = $db->loadResult();
                         $agent_alias = JApplication::stringURLSafe($agent_name);
                         if ($agent_alias == "")
                         {
                             $agent_alias = JText::_('OS_AGENT') . "-" . date("Y-m-d H:i:s", time());
                             $agent_alias = JApplication::stringURLSafe($agent_alias);
                         }
                         $db->setQuery("Select count(id) from #__osrs_agents where alias like '$agent_alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $agent_alias = $agent_alias . " " . $id;
                         }
                     }
                     //$agent_alias = mb_strtolower(str_replace(" ", "-", $agent_alias));
                     $agent_alias = JApplication::stringURLSafe($agent_alias);
                     return $agent_alias;
                     break;
                 case "company":
                     if ($alias != "")
                     {
                         $db->setQuery("Select count(id) from #__osrs_companies where company_alias like '$alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $company_alias = $alias . " " . $id;
                         } else
                         {
                             $company_alias = $alias;
                         }
                     } else
                     {
                         $db->setQuery("Select company_name from #__osrs_companies where id = '$id'");
                         $company_name = $db->loadResult();
                         $company_alias = JApplication::stringURLSafe($company_name);
                         if ($company_alias == "")
                         {
                             $company_alias = JText::_('OS_COMPANY') . "-" . date("Y-m-d H:i:s", time());
                             $company_alias = JApplication::stringURLSafe($company_alias);
                         }
                         $db->setQuery("Select count(id) from #__osrs_companies where company_alias like '$company_alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $company_alias = $company_alias . " " . $id;
                         }
                     }
                     // $company_alias = mb_strtolower(str_replace(" ", "-", $company_alias));
                     $company_alias = JApplication::stringURLSafe($company_alias);
                     return $company_alias;
                     break;
                 case "category":
                     if ($alias != "")
                     {
                         $db->setQuery("Select count(id) from #__osrs_categories where category_alias like '$alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $category_alias = $alias . " " . $id;
                         } else
                         {
                             $category_alias = $alias;
                         }
                     } else
                     {
                         $db->setQuery("Select category_name from #__osrs_categories where id = '$id'");
                         $category_name = $db->loadResult();
                         $category_alias = JApplication::stringURLSafe($category_name);
                         if ($category_alias == "")
                         {
                             $category_alias = JText::_('OS_CATEGORY') . "-" . date("Y-m-d H:i:s", time());
                             $category_alias = JApplication::stringURLSafe($category_alias);
                         }
                         $db->setQuery("Select count(id) from #__osrs_categories where category_alias like '$category_alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $category_alias = $category_alias . " " . $id;
                         }
                     }
                     //$category_alias = mb_strtolower(str_replace(" ", "-", $category_alias));
                     $category_alias = JApplication::stringURLSafe($category_alias);
                     return $category_alias;
                     break;
                 case "type":
                     if ($alias != "")
                     {
                         $db->setQuery("Select count(id) from #__osrs_types where type_alias like '$alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $type_alias = $alias . " " . $id;
                         } else
                         {
                             $type_alias = $alias;
                         }
                     } else
                     {
                         $db->setQuery("Select type_name from #__osrs_types where id = '$id'");
                         $type_name = $db->loadResult();
                         $type_alias = JApplication::stringURLSafe($type_name);
                         if ($type_alias == "")
                         {
                             $type_alias = JText::_('OS_TYPE') . "-" . date("Y-m-d H:i:s", time());
                             $type_alias = JApplication::stringURLSafe($type_alias);
                         }
                         $db->setQuery("Select count(id) from #__osrs_types where type_alias like '$type_alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $type_alias = $type_alias . " " . $id;
                         }
                     }
                     $type_alias = JApplication::stringURLSafe($type_alias);
                     return $type_alias;
                     break;
             }
         }

         /**
          * Generate alias
          *
          * @param unknown_type $type
          * @param unknown_type $id
          * @param unknown_type $alias
          */
         static function generateAliasMultipleLanguages($type, $id, $alias, $langCode)
         {
             global $mainframe;
             $db = JFactory::getDbo();
             if ($alias != "")
             {
                 $alias = JApplication::stringURLSafe($alias);
             }
             switch ($type)
             {
                 case "property":
                     $alias_field_name = "pro_alias_" . $langCode;
                     if ($alias != "")
                     {
                         $db->setQuery("Select count(id) from #__osrs_properties where `$alias_field_name` like '$alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $pro_alias = $alias . " " . $id;
                         } else
                         {
                             $pro_alias = $alias;
                         }
                     } else
                     {
                         $db->setQuery("Select pro_name_$langCode from #__osrs_properties where id = '$id'");
                         $pro_name = $db->loadResult();
                         $pro_alias = JApplication::stringURLSafe($pro_name);
                         if ($pro_alias == "")
                         {
                             $pro_alias = JText::_('OS_PROPERTY') . "-" . date("Y-m-d H:i:s", time());
                             $pro_alias = JApplication::stringURLSafe($pro_alias);
                         }
                         $db->setQuery("Select count(id) from #__osrs_properties where `$alias_field_name` like '$pro_alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $pro_alias = $pro_alias . " " . $id;
                         }
                     }
                     $pro_alias = JApplication::stringURLSafe($pro_alias);
                     return $pro_alias;
                     break;
                 case "agent":
                     if ($alias != "")
                     {
                         $db->setQuery("Select count(id) from #__osrs_agents where alias like '$alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $agent_alias = $alias . " " . $id;
                         } else
                         {
                             $agent_alias = $alias;
                         }
                     } else
                     {
                         $db->setQuery("Select name from #__osrs_agents where id = '$id'");
                         $agent_name = $db->loadResult();
                         $agent_alias = JApplication::stringURLSafe($agent_name);
                         if ($agent_alias == "")
                         {
                             $agent_alias = JText::_('OS_AGENT') . "-" . date("Y-m-d H:i:s", time());
                             $agent_alias = JApplication::stringURLSafe($agent_alias);
                         }
                         $db->setQuery("Select count(id) from #__osrs_agents where alias like '$agent_alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $agent_alias = $agent_alias . " " . $id;
                         }
                     }
                     $agent_alias = JApplication::stringURLSafe($agent_alias);
                     return $agent_alias;
                     break;
                 case "company":
                     if ($alias != "")
                     {
                         $db->setQuery("Select count(id) from #__osrs_companies where company_alias like '$alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $company_alias = $alias . " " . $id;
                         } else
                         {
                             $company_alias = $alias;
                         }
                     } else
                     {
                         $db->setQuery("Select company_name from #__osrs_companies where id = '$id'");
                         $company_name = $db->loadResult();
                         $company_alias = JApplication::stringURLSafe($company_name);
                         if ($company_alias == "")
                         {
                             $company_alias = JText::_('OS_COMPANY') . "-" . date("Y-m-d H:i:s", time());
                             $company_alias = JApplication::stringURLSafe($company_alias);
                         }
                         $db->setQuery("Select count(id) from #__osrs_companies where company_alias like '$company_alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $company_alias = $company_alias . " " . $id;
                         }
                     }
                     $company_alias = JApplication::stringURLSafe($company_alias);
                     return $company_alias;
                     break;
                 case "category":
                     $alias_field_name = "category_alias_" . $langCode;
                     if ($alias != "")
                     {
                         $db->setQuery("Select count(id) from #__osrs_categories where `$alias_field_name` like '$alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $category_alias = $alias . " " . $id;
                         } else
                         {
                             $category_alias = $alias;
                         }
                     } else
                     {
                         $db->setQuery("Select category_name_" . $langCode . " from #__osrs_categories where id = '$id'");
                         $category_name = $db->loadResult();
                         $category_alias = JApplication::stringURLSafe($category_name);
                         if ($category_alias == "")
                         {
                             $category_alias = JText::_('OS_CATEGORY') . "-" . date("Y-m-d H:i:s", time());
                             $category_alias = JApplication::stringURLSafe($category_alias);
                         }
                         $db->setQuery("Select count(id) from #__osrs_categories where `$alias_field_name` like '$category_alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $category_alias = $category_alias . " " . $id;
                         }
                     }
                     $category_alias = JApplication::stringURLSafe($category_alias);
                     return $category_alias;
                     break;
                 case "type":
                     $alias_field_name = "type_alias_" . $langCode;
                     if ($alias != "")
                     {
                         $db->setQuery("Select count(id) from #__osrs_types where `$alias_field_name` like '$alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $type_alias = $alias . " " . $id;
                         } else
                         {
                             $type_alias = $alias;
                         }
                     } else
                     {
                         $db->setQuery("Select type_name_" . $langCode . " from #__osrs_types where id = '$id'");
                         $type_name = $db->loadResult();
                         $type_alias = JApplication::stringURLSafe($type_name);
                         if ($type_alias == "")
                         {
                             $type_alias = JText::_('OS_TYPE') . "-" . date("Y-m-d H:i:s", time());
                             $type_alias = JApplication::stringURLSafe($type_alias);
                         }
                         $db->setQuery("Select count(id) from #__osrs_types where `$alias_field_name` like '$type_alias' and id <> '$id'");
                         $count = $db->loadResult();
                         if ($count > 0)
                         {
                             $type_alias = $type_alias . " " . $id;
                         }
                     }
                     $type_alias = JApplication::stringURLSafe($type_alias);
                     return $type_alias;
                     break;
             }
         }

         /**
          * Get IP address of customers
          *
          * @return unknown
          */
         public static function get_ip_address()
         {
             foreach (array(
         'HTTP_CLIENT_IP',
         'HTTP_X_FORWARDED_FOR',
         'HTTP_X_FORWARDED',
         'HTTP_X_CLUSTER_CLIENT_IP',
         'HTTP_FORWARDED_FOR',
         'HTTP_FORWARDED',
         'REMOTE_ADDR') as $key)
             {
                 if (array_key_exists($key, $_SERVER) === true)
                 {
                     foreach (explode(',', $_SERVER[$key]) as $ip)
                     {
                         if (filter_var($ip, FILTER_VALIDATE_IP) !== false)
                         {
                             return $ip;
                         }
                     }
                 }
             }
         }

         /**
          * Get data by using curl
          *
          * @param unknown_type $path
          * @return unknown
          */
         public static function get_data($path)
         {
             $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL, $path);
             curl_setopt($ch, CURLOPT_FAILONERROR, 1);
             curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch, CURLOPT_TIMEOUT, 15);
             $retValue = curl_exec($ch);
             curl_close($ch);
             return $retValue;
         }

         /**
          * Spam deteach
          */
         public static function spamChecking()
         {
             global $jinput;
             $botscoutUrl = 'http://www.stopforumspam.com/api?ip=';
             $accFrequency = 0;
             $access = 'yes';
             $option = $jinput->getString('option');
             // Check we are manipulating a valid form and if we are in admin.
             $ip = self::get_ip_address();
             $url = $botscoutUrl . $ip;
             $xmlDatas = simplexml_load_string(self::get_data($url));
             if ($xmlDatas->appears == $access && $xmlDatas->frequency >= $accFrequency)
             {
                 return true;
             } else
             {
                 return false;
             }
         }

         /**
          * Build the select list for parent menu item
          */
         public static function listCategoriesInMultiple($category_ids, $onChangeScript)
         {
             global $mainframe;
             $parentArr = array();
             $parentArr = self::loadCategoryOptions($category_ids, $onChangeScript, 0);
             $output = JHTML::_('select.genericlist', $parentArr, 'category_ids[]', 'style="min-height:100px;" multiple class="input-large chosen" ' . $onChangeScript, 'value', 'text', $category_ids);
             return $output;
         }

         /**
          * Build the select list for parent menu item
          */
         public static function listCategories($category_id, $onChangeScript)
         {
             global $mainframe;
             $parentArr = array();
             $parentArr = self::loadCategoryOptions($category_id, $onChangeScript, 1);
             $output = JHTML::_('select.genericlist', $parentArr, 'category_id', 'class="input-medium" ' . $onChangeScript, 'value', 'text', $category_id);
             return $output;
         }

         public static function loadCategoryOptions($category_id, $onChangeScript, $hasFirstOption = 0)
         {
             global $mainframe, $lang_suffix;
             $user = JFactory::getUser();
             $app = JFactory::getApplication();
             if ($app->isAdmin())
             {
                 $lang_suffix = "";
             } else
             {
                 $lang_suffix = OSPHelper::getFieldSuffix();
             }
             $db = JFactory::getDBO();

             $query = 'SELECT *,id as value,category_name' . $lang_suffix . ' AS text,category_name' . $lang_suffix . ' AS treename,category_name' . $lang_suffix . ' as category_name,category_name' . $lang_suffix . ' as title,parent_id as parent ' .
                     ' FROM #__osrs_categories ' .
                     ' WHERE published = 1';

             $query .= ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
             $query .= ' ORDER BY parent_id, ordering';
             $db->setQuery($query);
             $mitems = $db->loadObjectList();
             // establish the hierarchy of the menu
             $children = array();
             if ($mitems)
             {
                 // first pass - collect children
                 foreach ($mitems as $v)
                 {
                     $pt = $v->parent_id;
                     if ($v->treename == "")
                     {
                         $v->treename = $v->category_name;
                     }
                     if ($v->title == "")
                     {
                         $v->title = $v->category_name;
                     }
                     $list = @$children[$pt] ? $children[$pt] : array();
                     array_push($list, $v);
                     $children[$pt] = $list;
                 }
             }

             // second pass - get an indent list of the items
             $list = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0);
             // assemble menu items to the array
             $parentArr = array();
             if ($hasFirstOption == 1)
             {
                 $parentArr[] = JHTML::_('select.option', '', JText::_('OS_ALL_CATEGORIES'));
             }

             foreach ($list as $item)
             {
                 //if($item->treename != ""){
                 //$item->treename = str_replace("&nbsp;","*",$item->treename);
                 //}
                 $var = explode("*", $item->treename);

                 if (count($var) > 0)
                 {
                     $treename = "";
                     for ($i = 0; $i < count($var) - 1; $i++)
                     {
                         $treename .= " _ ";
                     }
                 }
                 $text = $item->treename;
                 $parentArr[] = JHTML::_('select.option', $item->id, $text);
             }
             return $parentArr;
         }

         /**
          * Build the multiple select list for parent menu item
          */
         public static function listCategoriesCheckboxes($categoryArr)
         {
             global $mainframe;
             $db = JFactory::getDbo();
             $db->setQuery("Select count(id) from #__osrs_categories where published = '1'");
             $count_categories = $db->loadResult();
             $parentArr = self::loadCategoryBoxes($categoryArr);
             ob_start();
             ?>
        <input type="checkbox" name="check_all_cats" id="check_all_cats" value="1" checked
               onclick="javascript:checkCats()"/>&nbsp;&nbsp;<strong><?php echo JText::_('OS_CATEGORIES') ?></strong>
        <input type="hidden" name="count_categories" id="count_categories" value="<?php echo $count_categories ?>"/>
        <BR/>
        <?php
        for ($i = 0; $i < count($parentArr); $i++)
        {
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $parentArr[$i];
            echo "<BR />";
        }
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public static function loadCategoryBoxes($categoryArr)
    {
        global $mainframe, $lang_suffix;
        $db = JFactory::getDBO();
        $lang_suffix = OSPHelper::getFieldSuffix();
        // get a list of the menu items
        // excluding the current cat item and its child elements
//		$query = 'SELECT *' .
        $query = 'SELECT *, id as value,category_name' . $lang_suffix . ' AS title,category_name' . $lang_suffix . ' AS category_name,parent_id as parent ' .
                ' FROM #__osrs_categories ' .
                ' WHERE published = 1';
        $user = JFactory::getUser();

        $query .= ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
        $query .= ' ORDER BY parent_id, ordering';
        $db->setQuery($query);
        $mitems = $db->loadObjectList();

        // establish the hierarchy of the menu
        $children = array();

        if ($mitems)
        {
            // first pass - collect children
            foreach ($mitems as $v)
            {
                $pt = $v->parent_id;
                $list = @$children[$pt] ? $children[$pt] : array();
                array_push($list, $v);
                $children[$pt] = $list;
            }
        }

        // second pass - get an indent list of the items
        $list = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0);
        // assemble menu items to the array
        $parentArr = array();

        foreach ($list as $item)
        {
            $checked = "";
            if ($item->treename != "")
            {
                $item->treename = str_replace("&nbsp;", "", $item->treename);
            }
            $var = explode("-", $item->treename);
            $treename = "";
            for ($i = 0; $i < count($var) - 1; $i++)
            {
                $treename .= "- -";
            }
            $text = $treename . $item->category_name;
            if (isset($categoryArr))
            {
                if (in_array($item->value, $categoryArr))
                {
                    $checked = "checked";
                } elseif (count($categoryArr) == 0)
                {
                    $checked = "checked";
                }
            }
            $parentArr[] = '<input type="checkbox" id="all_categories' . $item->value . '" name="categoryArr[]" ' . $checked . ' value="' . $item->value . '" />&nbsp;&nbsp;' . $text . '';
        }
        return $parentArr;
    }

    public static function loadAgentType($agent_id)
    {
        global $mainframe;
        $db = JFactory::getDbo();
        $db->setQuery("Select agent_type from #__osrs_agents where id = '$agent_id'");
        $agent_type = $db->loadResult();
        switch ($agent_type)
        {
            case "0":
            default:
                return JText::_('OS_AGENT');
                break;
            case "1":
                return JText::_('OS_OWNER');
                break;
            case "2":
                return JText::_('OS_REALTOR');
                break;
            case "3":
                return JText::_('OS_BROKER');
                break;
            case "4":
                return JText::_('OS_BUILDER');
                break;
            case "5":
                return JText::_('OS_LANDLORD');
                break;
            case "6":
                return JText::_('OS_SELLER');
                break;
        }
    }

    public static function loadAgentTypeDropdown($agent_type, $class_name, $onChange)
    {
        global $mainframe;
        $configClass = self::loadConfig();
        $user_types = $configClass['user_types'];
        $user_types = explode(",", $user_types);

        $optionArr = array();
        if (in_array(0, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '0', JText::_('OS_AGENT'));
        }
        if (in_array(1, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '1', JText::_('OS_OWNER'));
        }
        if (in_array(2, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '2', JText::_('OS_REALTOR'));
        }
        if (in_array(3, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '3', JText::_('OS_BROKER'));
        }
        if (in_array(4, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '4', JText::_('OS_BUILDER'));
        }
        if (in_array(5, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '5', JText::_('OS_LANDLORD'));
        }
        if (in_array(6, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '6', JText::_('OS_SELLER'));
        }

        echo JHTML::_('select.genericlist', $optionArr, 'agent_type', 'class="' . $class_name . '" ' . $onChange, 'value', 'text', $agent_type);
    }

    public static function loadAgentTypeDropdownFilter($agent_type, $class_name, $onChange)
    {
        global $mainframe;
        $configClass = self::loadConfig();
        $user_types = $configClass['user_types'];
        $user_types = explode(",", $user_types);

        $optionArr = array();
        $optionArr[] = JHTML::_('select.option', '-1', JText::_('OS_SELECT_USER_TYPE'));
        if (in_array(0, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '0', JText::_('OS_AGENT'));
        }
        if (in_array(1, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '1', JText::_('OS_OWNER'));
        }
        if (in_array(2, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '2', JText::_('OS_REALTOR'));
        }
        if (in_array(3, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '3', JText::_('OS_BROKER'));
        }
        if (in_array(4, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '4', JText::_('OS_BUILDER'));
        }
        if (in_array(5, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '5', JText::_('OS_LANDLORD'));
        }
        if (in_array(6, $user_types))
        {
            $optionArr[] = JHTML::_('select.option', '6', JText::_('OS_SELLER'));
        }
        echo JHTML::_('select.genericlist', $optionArr, 'agent_type', 'class="' . $class_name . '" ' . $onChange, 'value', 'text', $agent_type);
    }

    public static function getStringRequest($name, $defaultvalue = '', $method = 'post')
    {
        $jinput = JFactory::getApplication()->input;
        $temp = $jinput->get($name, $defaultvalue, 'string');
        $badchars = array('#', '>', '<', '\\');
        $temp = trim(str_replace($badchars, '', $temp));
        $temp = htmlspecialchars($temp);
        return $temp;
    }

    static function showSquareLabels()
    {
        global $mainframe, $configClass;
        $configClass = self::loadConfig();
        if ($configClass['use_square'] == 0)
        {
            return JText::_('OS_SQUARE_FEET');
        } else
        {
            return JText::_('OS_SQUARE_METER');
        }
    }

    static function showSquareSymbol()
    {
        global $mainframe, $configClass;
        $configClass = self::loadConfig();
        if ($configClass['use_square'] == 0)
        {
            return JText::_('OS_SQFT');
        } else
        {
            return JText::_('OS_SQMT');
        }
    }

    static function showAcresSymbol()
    {
        global $mainframe, $configClass;
        $configClass = self::loadConfig();
        if ($configClass['acreage'] == 1)
        {
            return JText::_('OS_ACRES');
        } else
        {
            return JText::_('OS_HECTARES');
        }
    }

    /**
     * Converts a given size with units e.g. read from php.ini to bytes.
     *
     * @param   string $val Value with units (e.g. 8M)
     * @return  int     Value in bytes
     * @since   3.0
     */
    public static function iniToBytes($val)
    {
        $val = trim($val);

        switch (strtolower(substr($val, -1)))
        {
            case 'm':
                $val = (int) substr($val, 0, -1) * 1048576;
                break;
            case 'k':
                $val = (int) substr($val, 0, -1) * 1024;
                break;
            case 'g':
                $val = (int) substr($val, 0, -1) * 1073741824;
                break;
            case 'b':
                switch (strtolower(substr($val, -2, 1)))
                {
                    case 'm':
                        $val = (int) substr($val, 0, -2) * 1048576;
                        break;
                    case 'k':
                        $val = (int) substr($val, 0, -2) * 1024;
                        break;
                    case 'g':
                        $val = (int) substr($val, 0, -2) * 1073741824;
                        break;
                    default:
                        break;
                }
                break;
            default:
                break;
        }

        return $val;
    }

    /**
     * Generate price value
     *
     * @param unknown_type $curr
     * @param unknown_type $price
     */
    public static function generatePrice($curr, $price)
    {
        global $configClass;
        $configClass = self::loadConfig();
        if ($configClass['currency_position'] == 0)
        {
            return HelperOspropertyCommon::loadCurrency($curr) . " " . HelperOspropertyCommon::showPrice($price);
        } else
        {
            return HelperOspropertyCommon::showPrice($price) . " " . HelperOspropertyCommon::loadCurrency($curr);
        }
    }

    /**
     * Show Price Filter
     *
     * @param unknown_type $option_id
     * @param unknown_type $max_price
     * @param unknown_type $min_price
     * @param unknown_type $property_type
     * @param unknown_type $style
     */
    public static function showPriceFilter($option_id, $min_price, $max_price, $property_type, $style, $prefix)
    {
        global $configClass;
        $configClass = self::loadConfig();
        $document = JFactory::getDocument();
        $db = JFactory::getDbo();
        $min_price_slider = $configClass['min_price_slider'];
        $max_price_slider = $configClass['max_price_slider'];
        $price_step_amount = $configClass['price_step_amount'];
        if ($price_step_amount == "")
        {
            $price_step_amount = 1000;
        }

        if ($property_type > 0)
        {
            if ($configClass['type' . $property_type] != "1")
            {
                $value = $configClass['type' . $property_type];
                $valueArr = explode("|", $value);
                $min_price_slider = $valueArr[1];
                $max_price_slider = $valueArr[2];
                $price_step_amount = $valueArr[3];
            }
        }

        if ($max_price_slider != "")
        {
            $max_price_value = $max_price_slider;
        } else
        {
            $db->setQuery("Select price from #__osrs_properties order by price desc limit 1");
            $max_price_value = $db->loadResult();
        }
        if ($min_price_slider != "")
        {
            $min_price_value = $min_price_slider;
        } else
        {
            $db->setQuery("Select price from #__osrs_properties where price_call = 0 order by price limit 1");
            $min_price_value = $db->loadResult();
        }


        if (intval($max_price) == 0)
        {
            $max_price = $max_price_value;
        }
        if ($min_price_value == $max_price_value)
        {
            if ($min_price_slider != "")
            {
                $max_price = $min_price_slider;
            } else
            {
                $max_price = 0;
            }
        }
        if ($configClass['price_filter_type'] == 1)
        {
            $document->addStyleSheet("//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css");
            //$document->addStyleSheet("//code.jquery.com/ui/1.10.4/themes/smoothness/jquery.ui.slider-rtl.css");
            ?>
            <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js" type="text/javascript"></script>
                  <!--<script src="<?php echo JUri::root() ?>components/com_osproperty/js/jquery.ui.slider-rtl.js" type="text/javascript"></script>-->
            <script src="<?php echo JUri::root() ?>components/com_osproperty/js/jquery.ui.touch-punch.js" type="text/javascript"></script>
            <script src="<?php echo JUri::root() ?>components/com_osproperty/js/autoNumeric.js" type="text/javascript"></script>
            <div id="<?php echo $prefix; ?>sliderange"></div>
            <div class="clearfix"></div>
            <script>
                       jQuery.ui.slider.prototype.widgetEventPrefix = 'slider';
                       jQuery(function () {
                           jQuery("#<?php echo $prefix; ?>sliderange")[0].slide = null;
                           jQuery("#<?php echo $prefix; ?>sliderange").slider({
                               //isRTL: true,
                               range: true,
                               min: <?php echo intval($min_price_value); ?>,
                               step: <?php echo $price_step_amount; ?>,
                               max: <?php echo intval($max_price_value); ?>,
                               values: [<?php echo intval($min_price); ?>, <?php echo intval($max_price); ?>],
                               slide: function (event, ui) {
                                   var price_from = ui.values[0];
                                   var price_to = ui.values[1];
                                   jQuery("#<?php echo $prefix; ?>price_from_input1").val(price_from);
                                   jQuery("#<?php echo $prefix; ?>price_to_input1").val(price_to);

                                   price_from = price_from.formatMoney(0, ',', '.');
                                   price_to = price_to.formatMoney(0, ',', '.');

                                   jQuery("#<?php echo $prefix; ?>price_from_input").text(price_from);
                                   jQuery("#<?php echo $prefix; ?>price_to_input").text(price_to);
                               }
                           });

                           jQuery("#<?php echo $prefix; ?>price_from_input1").change(function () {
                               var value1 = jQuery("#<?php echo $prefix; ?>price_from_input1").val();
                               var value2 = jQuery("#<?php echo $prefix; ?>price_to_input1").val();
                               if (parseInt(value1) > parseInt(value2)) {
                                   value1 = value2;
                                   jQuery(".#<?php echo $prefix; ?>price_from_input1").val(value1);
                               }
                               jQuery("#<?php echo $prefix; ?>sliderange").slider("values", 0, value1);
                           });

                           jQuery("#<?php echo $prefix; ?>price_to_input1").change(function () {
                               var value1 = jQuery("#<?php echo $prefix; ?>price_from_input1").val();
                               var value2 = jQuery("#<?php echo $prefix; ?>price_to_input1").val();
                               if (parseInt(value1) > parseInt(value2)) {
                                   value2 = value1;
                                   jQuery("#<?php echo $prefix; ?>price_to_input1").val(value2);
                               }
                               jQuery("#<?php echo $prefix; ?>sliderange").slider("values", 1, value2);
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
            </script>

            <?php
            if ((strpos($prefix, "adv") === FALSE) and ( strpos($prefix, "list") === FALSE))
            {
                $span = "span6";
                $style = "margin-top:10px;margin-left:0px;";
                $style1 = "font-size:11px;text-align:left; width: 48.93617021276595%;*width: 48.88297872340425%;float:left;";
                $style2 = "font-size:11px;text-align:right; width: 48.93617021276595%;*width: 48.88297872340425%;float:left;";
                $input_class_name = "input-mini";
            } else
            {
                $span = "span6";
                $style = "";
                $style1 = "margin-top:10px;margin-left:0px;text-align:left;width: 48.93617021276595%; *width: 48.88297872340425%;float:left;";
                $style2 = "margin-top:10px;margin-left:0px;text-align:right;width: 48.93617021276595%; *width: 48.88297872340425%;float:left;";
                $input_class_name = "input-small";
            }
            ?>
            <div class="row-fluid">
                <div class="<?php echo $span ?>" style="<?php echo $style; ?><?php echo $style1 ?>">
                    <?php if ((strpos($prefix, "adv") !== FALSE) or ( strpos($prefix, "list") !== FALSE))
                    {
                        ?>
                        <?php echo JText::_('OS_MIN') ?>
            <?php } ?>
                    (<?php echo HelperOspropertyCommon::loadCurrency(0); ?>).
                    <span
                        id="<?php echo $prefix; ?>price_from_input"><?php echo number_format((float)$min_price, 0, '', ','); ?></span>
                    <input type="hidden" name="min_price" id="<?php echo $prefix; ?>price_from_input1"
                           value="<?php echo $min_price; ?>"/>
                </div>
                <div class="<?php echo $span ?>" style="<?php echo $style; ?><?php echo $style2 ?>">
                    <?php if ((strpos($prefix, "adv") !== FALSE) or ( strpos($prefix, "list") !== FALSE))
                    {
                        ?>
                <?php echo JText::_('OS_MAX') ?>
            <?php } ?>
                    (<?php echo HelperOspropertyCommon::loadCurrency(0); ?>).
                    <span
                        id="<?php echo $prefix; ?>price_to_input"><?php echo number_format($max_price, 0, '', ','); ?></span>
                    <input type="hidden" name="max_price" id="<?php echo $prefix; ?>price_to_input1"
                           value="<?php echo $max_price; ?>"/>
                </div>
            </div>
            <?php
        } else
        {
            echo HelperOspropertyCommon::generatePriceList($property_type, $option_id, $style);
        }
    }

    public static function showPriceTypesConfig()
    {
        static $property_types;
        $configClass = self::loadConfig();
        $db = JFactory::getDbo();
        if ($property_types == null)
        {
            $db->setQuery("Select * from #__osrs_types order by ordering");
            $property_types = $db->loadObjectList();
        }
        ?>
        <input type="hidden" name="min" id="min" value="<?php echo $configClass['min_price_slider']; ?>" />
        <input type="hidden" name="max" id="max" value="<?php echo $configClass['max_price_slider']; ?>" />
        <input type="hidden" name="step" id="step" value="<?php echo $configClass['price_step_amount']; ?>" />
        <?php
        for ($i = 0; $i < count($property_types); $i++)
        {
            $property_type = $property_types[$i];
            $type = $configClass['type' . $property_type->id];
            if ($type == "1")
            {
                ?>
                <input type="hidden" name="min<?php echo $property_type->id; ?>" id="min<?php echo $property_type->id; ?>" value="<?php echo $configClass['min_price_slider']; ?>" />
                <input type="hidden" name="max<?php echo $property_type->id; ?>" id="max<?php echo $property_type->id; ?>" value="<?php echo $configClass['max_price_slider']; ?>" />
                <input type="hidden" name="step<?php echo $property_type->id; ?>" id="step<?php echo $property_type->id; ?>" value="<?php echo $configClass['price_step_amount']; ?>" />
                <?php
            } else
            {
                $valueArr = array();
                $valueArr = explode("|", $type);
                $min_price_slider = $valueArr[1];
                $max_price_slider = $valueArr[2];
                $price_step_amount = $valueArr[3];
                ?>
                <input type="hidden" name="min<?php echo $property_type->id; ?>" id="min<?php echo $property_type->id; ?>" value="<?php echo $min_price_slider; ?>" />
                <input type="hidden" name="max<?php echo $property_type->id; ?>" id="max<?php echo $property_type->id; ?>" value="<?php echo $max_price_slider; ?>" />
                <input type="hidden" name="step<?php echo $property_type->id; ?>" id="step<?php echo $property_type->id; ?>" value="<?php echo $price_step_amount; ?>" />
                <?php
            }
        }
    }

    /**
     * check Owner is existing or not
     *
     */
    public static function checkOwnerExisting()
    {
        global $mainframe;
        $db = JFactory::getDbo();
        $db->setQuery("Select count(id) from #__osrs_agents where agent_type <> '0' and published = '1'");
        $count = $db->loadResult();
        if ($count > 0)
        {
            return true;
        } else
        {
            return false;
        }
    }

    /**
     * Check if user use one state in the system
     */
    public static function userOneState()
    {
        static $count_state;
        $configClass = self::getConfig();
        if (!HelperOspropertyCommon::checkCountry())
        {
            $defaultcounty = $configClass['show_country_id'];
            if ($count_state == null)
            {
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);
                $query->select('count(id)')->from('#__osrs_states')->where('country_id = "' . $defaultcounty . '" and published = "1"');
                $db->setQuery($query);
                $count_state = $db->loadResult();
            }
            if ($count_state == 1)
            {
                return true;
            }
        }
        return false;
    }

    public static function returnDefaultState()
    {
        $configClass = self::getConfig();
        if (self::userOneState())
        {
            $defaultcounty = $configClass['show_country_id'];
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('id')->from('#__osrs_states')->where('country_id = "' . $defaultcounty . '" and published = "1"');
            $db->setQuery($query);
            return $db->loadResult();
        }
        return 0;
    }

    public static function returnDefaultStateName()
    {
        $db = JFactory::getDbo();
        $lgs = self::getLanguages();

        $translatable = JLanguageMultilang::isEnabled() && count($lgs);
        $suffix = "";
        $app = JFactory::getApplication();

        if (($translatable) and ( !$app->isAdmin()))
        {
            $suffix = OSPHelper::getFieldSuffix();
        }
        if (self::returnDefaultState() > 0)
        {
            $query = $db->getQuery(true);
            $query->select('state_name' . $suffix . ' as state_name')->from('#__osrs_states')->where('id="' . self::returnDefaultState() . '"');
            $db->setQuery($query);
            return $db->loadResult();
        }
        return '';
    }

    public static function getConfig()
    {
        static $configClass;
        if ($configClass == null)
        {
            $db = JFactory::getDbo();
            /*
              $db->setQuery("Select * from #__osrs_configuration");
              $configs = $db->loadObjectList();
              $configClass = array();
              foreach ($configs as $config) {
              $configClass[$config->fieldname] = $config->fieldvalue;
              }
             */
            $configClass = self::loadConfig();

            $curr = $configClass['general_currency_default'];
            $arrCode = array();
            $arrSymbol = array();

            $db->setQuery("Select * from #__osrs_currencies where id = '$curr'");
            $currency = $db->loadObject();
            $symbol = $currency->currency_symbol;
            $index = -1;
            if ($symbol == "")
            {
                $symbol = '$';
            }

            $configClass['curr_symbol'] = $symbol;
        }
        return $configClass;
    }

    public static function dropdropBath($name, $bath, $class, $jsScript, $firstOption)
    {
        $configClass = self::loadConfig();
        $bathArr = array();
        $bathArr[] = JHTML::_('select.option', '', JText::_($firstOption));
        for ($i = 1; $i <= 10; $i++)
        {
            $bathArr[] = JHTML::_('select.option', $i, $i);
            if ($configClass['fractional_bath'] == 1)
            {
                $bathArr[] = JHTML::_('select.option', $i . '.25', $i . '.25');
                $bathArr[] = JHTML::_('select.option', $i . '.50', $i . '.50');
                $bathArr[] = JHTML::_('select.option', $i . '.75', $i . '.75');
            }
        }
        return JHTML::_('select.genericlist', $bathArr, $name, 'class="' . $class . '" ' . $jsScript, 'value', 'text', $bath);
    }

    public static function dropdropBed($name, $bed, $class, $jsScript, $firstOption)
    {
        $bedArr = array();
        $bedArr[] = JHTML::_('select.option', '', JText::_($firstOption));
        for ($i = 1; $i <= 20; $i++)
        {
            $bedArr[] = JHTML::_('select.option', $i, $i);
        }
        return JHTML::_('select.genericlist', $bedArr, $name, 'class="' . $class . '" ' . $jsScript, 'value', 'text', $bed);
    }

    public static function dropdropRoom($name, $room, $class, $jsScript, $firstOption)
    {
        $roomArr = array();
        $roomArr[] = JHTML::_('select.option', '', JText::_($firstOption));
        for ($i = 1; $i <= 20; $i++)
        {
            $roomArr[] = JHTML::_('select.option', $i, $i);
        }
        return JHTML::_('select.genericlist', $roomArr, $name, 'class="' . $class . '" ' . $jsScript, 'value', 'text', $room);
    }

    public static function dropdropFloor($name, $room, $class, $jsScript, $firstOption)
    {
        $roomArr = array();
        $roomArr[] = JHTML::_('select.option', '', JText::_($firstOption));
        for ($i = 1; $i <= 20; $i++)
        {
            $roomArr[] = JHTML::_('select.option', $i, $i);
        }
        return JHTML::_('select.genericlist', $roomArr, $name, 'class="' . $class . '" ' . $jsScript, 'value', 'text', $room);
    }

    public static function checkboxesCategory($name, $catArr)
    {
        $db = JFactory::getDbo();
        $db->setQuery("Select * from #__osrs_categories where published = '1' order by ordering");
        $rows = $db->loadObjectList();
        $tempArr = array();
        if (count($rows) > 0)
        {
            foreach ($rows as $row)
            {
                if (in_array($row->id, $catArr))
                {
                    $checked = "checked";
                } else
                {
                    $checked = "";
                }

                $tempArr[] = "<input type='checkbox' name='$name' value='$row->id' $checked> " . self::getLanguageFieldValue($row, 'category_name');
            }
        }
        return $tempArr;
    }

    public static function dropdownCategory($name, $catArr, $class)
    {
        $onChangeScript = "";
        $parentArr = self::loadCategoryOptions($catArr, $onChangeScript);
        return JHTML::_('select.genericlist', $parentArr, $name, 'multiple class="' . $class . '" ' . $onChangeScript, 'value', 'text', $catArr);
    }

    //Load Categories Options of Multiple Dropdown Select List: Category
    public static function loadCategoriesOptions($onChangeScript)
    {
        global $mainframe, $lang_suffix;
        $db = JFactory::getDBO();
        $app = JFactory::getApplication();
        if ($app->isAdmin())
        {
            $lang_suffix = "";
        } else
        {
            $lang_suffix = OSPHelper::getFieldSuffix();
        }
        $query = 'SELECT *,id as value,category_name' . $lang_suffix . ' AS text,category_name' . $lang_suffix . ' AS treename,category_name' . $lang_suffix . ' as category_name,parent_id as parent ' .
                ' FROM #__osrs_categories ' .
                ' WHERE published = 1';
        $user = JFactory::getUser();
        $query .= ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
        $query .= ' ORDER BY parent_id, ordering';
        $db->setQuery($query);
        $mitems = $db->loadObjectList();
        // establish the hierarchy of the menu
        $children = array();
        if ($mitems)
        {
            // first pass - collect children
            foreach ($mitems as $v)
            {
                $pt = $v->parent_id;
                if ($v->treename == "")
                {
                    $v->treename = $v->category_name;
                }
                if ($v->title == "")
                {
                    $v->title = $v->category_name;
                }
                $list = @$children[$pt] ? $children[$pt] : array();
                array_push($list, $v);
                $children[$pt] = $list;
            }
        }

        // second pass - get an indent list of the items
        $list = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0);
        // assemble menu items to the array
        $parentArr = array();
        foreach ($list as $item)
        {
            //if($item->treename != ""){
            //$item->treename = str_replace("&nbsp;","*",$item->treename);
            //}
            $var = explode("*", $item->treename);

            if (count($var) > 0)
            {
                $treename = "";
                for ($i = 0; $i < count($var) - 1; $i++)
                {
                    $treename .= " _ ";
                }
            }
            $text = $item->treename;
            $parentArr[] = JHTML::_('select.option', $item->id, $text);
        }
        return $parentArr;
    }

    public static function getCategoryIdsOfProperty($pid)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('category_id')->from('#__osrs_property_categories')->where('pid="' . $pid . '"');
        $db->setQuery($query);
        $categoryIds = $db->loadColumn(0);
        return $categoryIds;
    }

    public static function getCategoryNamesOfProperty($pid)
    {
        global $lang_suffix, $mainframe;
        $mainframe = JFactory::getApplication();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        if ($mainframe->isAdmin())
        {
            $lang_suffix = "";
        } else
        {
            $lang_suffix = OSPHelper::getFieldSuffix();
        }
        $user = JFactory::getUser();
        $permission = "";
        $permission .= ' 1 = 1 and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
        $query = $db->getQuery(true);
        $query->select('category_name' . $lang_suffix)->from('#__osrs_categories')->where($permission . ' and id in (Select category_id from #__osrs_property_categories where pid ="' . $pid . '")');
        $db->setQuery($query);
        $categoryNames = $db->loadColumn(0);
        return implode(", ", $categoryNames);
    }

    public static function getCategoryNamesOfPropertyWithLinks($pid)
    {
        global $lang_suffix, $mainframe;
        $mainframe = JFactory::getApplication();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $app = JFactory::getApplication();
        if ($app->isAdmin())
        {
            $lang_suffix = "";
        } else
        {
            $lang_suffix = OSPHelper::getFieldSuffix();
        }
        $user = JFactory::getUser();
        $permission = "";
        $permission .= ' 1 = 1 and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
        $query = $db->getQuery(true);
        $query->select('id, category_name' . $lang_suffix . ' as category_name')->from('#__osrs_categories')->where($permission . ' and id in (Select category_id from #__osrs_property_categories where pid ="' . $pid . '")');
        $db->setQuery($query);
        $categories = $db->loadObjectList();
        $categoryArr = array();
        if (count($categories) > 0)
        {
            $needs = array();
            $needs[] = "category_listing";
            $needs[] = "lcategory";
            $itemid = OSPRoute::getItemid($needs);
            foreach ($categories as $category)
            {
                $id = $category->id;
                $category_name = $category->category_name;
                $link = JRoute::_('index.php?option=com_osproperty&task=category_details&id=' . $id . '&Itemid=' . $itemid);
                $categoryArr[] = "<a href='" . $link . "'>" . $category_name . "</a>";
            }
        }
        return implode(", ", $categoryArr);
    }

    public static function array_equal($a, $b)
    {
        return (is_array($a) && is_array($b) && array_diff($a, $b) === array_diff($b, $a));
    }

    public static function showBath($value)
    {
        return rtrim(rtrim($value, '0'), '.');
        //return $value;
    }

    public static function showLotsize($value)
    {
        return rtrim(rtrim($value, '0'), '.');
        //return $value;
    }

    public static function showSquare($value)
    {

        return rtrim(rtrim($value, '0'), '.');
    }

    public static function checkView($taskArr, $menu_id)
    {
        //print_r($taskArr);
        //die();
        //$return = 0;
        //die();
        if ($menu_id > 0)
        {
            $db = JFactory::getDbo();
            $db->setQuery("Select * from #__menu where id = '$menu_id'");
            $menu = $db->loadObject();
            $menu_link = $menu->link;

            if (count($taskArr) > 0)
            {
                foreach ($taskArr as $task)
                {
                    if (strpos($menu_link, $task) !== false)
                    {
                        $return = 1;
                    }
                }
            }
        }

        if ($return == 1)
        {
            return true;
        } else
        {
            return false;
        }
    }

    public function checkPermissionOfCategories($catArr)
    {
        $returnArr = array();
        $user = JFactory::getUser();
        $permission = "";
        $permission .= ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
        $db = JFactory::getDbo();
        if (count($catArr) > 0)
        {
            foreach ($catArr as $category_id)
            {
                if ($category_id > 0)
                {
                    $db->setQuery("Select count(id) from #__osrs_categories where id = '$category_id' $permission");
                    $count = $db->loadResult();
                    if ($count > 0)
                    {
                        $returnArr[] = $category_id;
                    }
                }
            }
        }
        return $returnArr;
    }

    /**
     * Add property to Facebook when it is added/updated
     *
     * @param unknown_type $property
     */
    public function postPropertyToFacebook($property, $isNew)
    {
        $configClass = self::loadConfig();
        if (($configClass['add_fb'] == 1) and ( $configClass['facebook_api'] != "") and ( $configClass['application_secret'] != ""))
        {
            require JPATH_ROOT . '/components/com_osproperty/helpers/fb/facebook.php';
            $facebook = new Facebook(array('appId' => $configClass['facebook_api'], 'secret' => $configClass['application_secret'], 'cookie' => true));

            $url = JRoute::_("index.php?option=com_osproperty&task=property_details&id=$property->id");
            $url = JUri::getInstance()->toString(array('scheme', 'user', 'pass', 'host')) . $url;

            switch ($isNew)
            {
                case 1:
                    $message = JText::_('OS_FBLISTING_FB_NEW_TEXT');
                    break;
                default:
                    $message = JText::_('OS_FBLISTING_FB_UPDATE_TEXT');
                    break;
            }
            $message .= '@ ' . $url;

            //find thumb
            $db = JFactory::getDbo();
            $db->setQuery("Select * from #__osrs_photos where pro_id = '$property->id'");
            $photos = $db->loadObjectList();
            if (count($photos) > 0)
            {
                $photo = $photos[0];
                $image = $photo->image;
                if (file_exists(JPATH_ROOT . 'images/osproperty/properties/' . $property->id . '/thumb/' . $image))
                {
                    $picture = JURI::root() . 'images/osproperty/properties/' . $property->id . '/thumb/' . $image;
                } else
                {
                    $picture = JUri::root() . 'components/com_osproperty/images/assets/nopropertyphoto.png';
                }
            } else
            {
                $picture = JUri::root() . 'components/com_osproperty/images/assets/nopropertyphoto.png';
            }
            $fbpost = array(
                'message' => $message,
                'name' => $property->sef . ", " . self::getLanguageFieldValue($property, 'pro_name'),
                'caption' => JText::_('OS_FBLISTING_LINK_CAPTION'),
                'link' => $url,
                'picture' => $picture
            );

            $result = $facebook->api('/me/feed/', 'post', $fbpost);

            return true;
        }
    }

    public static function addPropertyToQueue($id)
    {
        $db = JFactory::getDbo();
        $db->setQuery("Select count(id) from #__osrs_new_properties where pid = '$id'");
        $count = $db->loadResult();
        if ($count == 0)
        {
            $db->setQuery("Insert into #__osrs_new_properties (id,pid) values (NULL,'$id')");
            $db->query();
        }
    }

    /**
     * This function is used to show the location links above the Google map
     * @param $address
     * @return array|string
     */
    public static function showLocationAboveGoogle($address)
    {
        $language = JFactory::getLanguage();
        $activate_language = $language->getTag();
        $activate_language = explode("-", $activate_language);
        $activate_language = $activate_language[0];
        ?>
        <div class="row-fluid" style="margin-top:10px;">
            <div class="span3" style="margin-left:10px;">
                <i class="osicon-search"></i> <a href="http://local.google.com/local?f=l&amp;hl=<?php echo $activate_language; ?>&amp;q=category:+<?php echo JText::_('OS_SCHOOLS'); ?>&amp;om=1&amp;near=<?php echo $address; ?>" class="category" rel="nofollow"><?php echo JText::_('OS_SCHOOLS'); ?> </a>		</div>
            <div class="span3" style="margin-left:10px;">
                <i class="osicon-search"></i> <a href="http://local.google.com/local?f=l&amp;hl=<?php echo $activate_language; ?>&amp;q=category:+<?php echo JText::_('OS_RESTAURANTS'); ?>&amp;om=1&amp;near=<?php echo $address; ?>" class="category" rel="nofollow"><?php echo JText::_('OS_RESTAURANTS'); ?> </a>		</div>
            <div class="span3" style="margin-left:10px;">
                <i class="osicon-search"></i> <a href="http://local.google.com/local?f=l&amp;hl=<?php echo $activate_language; ?>&amp;q=category:+<?php echo JText::_('OS_DOCTORS'); ?>&amp;om=1&amp;near=<?php echo $address; ?>" class="category" rel="nofollow"><?php echo JText::_('OS_DOCTORS'); ?> </a>		</div>
            <div class="span3" style="margin-left:10px;">
                <i class="osicon-search"></i> <a href="http://local.google.com/local?f=l&amp;hl=<?php echo $activate_language; ?>&amp;q=category:+<?php echo JText::_('OS_HOSPITALS'); ?>&amp;om=1&amp;near=<?php echo $address; ?>" class="category" rel="nofollow"><?php echo JText::_('OS_HOSPITALS'); ?> </a>		</div>
        </div>
        <div class="row-fluid">
            <div class="span3" style="margin-left:10px;">
                <i class="osicon-search"></i> <a href="http://local.google.com/local?f=l&amp;hl=<?php echo $activate_language; ?>&amp;q=category:+<?php echo JText::_('OS_RAILWAY'); ?>&amp;om=1&amp;near=<?php echo $address; ?>" class="category" rel="nofollow"><?php echo JText::_('OS_RAILWAY'); ?> </a>
            </div>
            <div class="span3" style="margin-left:10px;">
                <i class="osicon-search"></i> <a href="http://local.google.com/local?f=l&amp;hl=<?php echo $activate_language; ?>&amp;q=category:+<?php echo JText::_('OS_AIRPORTS'); ?>&amp;om=1&amp;near=<?php echo $address; ?>" class="category" rel="nofollow"><?php echo JText::_('OS_AIRPORTS'); ?> </a>
            </div>
            <div class="span3" style="margin-left:10px;">
                <i class="osicon-search"></i> <a href="http://local.google.com/local?f=l&amp;hl=<?php echo $activate_language; ?>&amp;q=category:+<?php echo JText::_('OS_SUPER_MARKET'); ?>&amp;om=1&amp;near=<?php echo $address; ?>" class="category" rel="nofollow"><?php echo JText::_('OS_SUPER_MARKET'); ?> </a>
            </div>
            <div class="span3" style="margin-left:10px;">
                <i class="osicon-search"></i> <a href="http://local.google.com/local?f=l&amp;hl=<?php echo $activate_language; ?>&amp;q=category:+<?php echo JText::_('OS_THEATRE'); ?>&amp;om=1&amp;near=<?php echo $address; ?>" class="category" rel="nofollow"><?php echo JText::_('OS_THEATRE'); ?> </a>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3" style="margin-left:10px;">
                <i class="osicon-search"></i> <a href="http://local.google.com/local?f=l&amp;hl=<?php echo $activate_language; ?>&amp;q=category:+<?php echo JText::_('OS_UNIVERSITIES'); ?>&amp;om=1&amp;near=<?php echo $address; ?>" class="category" rel="nofollow"><?php echo JText::_('OS_UNIVERSITIES'); ?> </a>
            </div>
            <div class="span3" style="margin-left:10px;">
                <i class="osicon-search"></i> <a href="http://local.google.com/local?f=l&amp;hl=<?php echo $activate_language; ?>&amp;q=category:+<?php echo JText::_('OS_PARKS'); ?>&amp;om=1&amp;near=<?php echo $address; ?>" class="category" rel="nofollow"><?php echo JText::_('OS_PARKS'); ?> </a>
            </div>
            <div class="span3" style="margin-left:10px;">
                <i class="osicon-search"></i> <a href="http://local.google.com/local?f=l&amp;hl=<?php echo $activate_language; ?>&amp;q=category:+<?php echo JText::_('OS_KINDERGARTEN'); ?>&amp;om=1&amp;near=<?php echo $address; ?>" class="category" rel="nofollow"><?php echo JText::_('OS_KINDERGARTEN'); ?> </a>
            </div>
            <div class="span3" style="margin-left:10px;">
                <i class="osicon-search"></i> <a href="http://local.google.com/local?f=l&amp;hl=<?php echo $activate_language; ?>&amp;q=category:+<?php echo JText::_('OS_SHOPPING_MALL'); ?>&amp;om=1&amp;near=<?php echo $address; ?>" class="category" rel="nofollow"><?php echo JText::_('OS_SHOPPING_MALL'); ?> </a>
            </div>
        </div>
        <?php
    }

    public static function isSoldProperty($row, $configClass)
    {
        $sold_property_types = $configClass['sold_property_types'];
        if ($sold_property_types != "")
        {
            $sold_property_types = explode("|", $sold_property_types);
            if ((in_array($row->pro_type, $sold_property_types)) and ( $row->isSold == 1) and ( $configClass['use_sold'] == 1))
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Check to see if property is in the Compared list
     * @param $pid
     * @return bool
     */
    public static function isInCompareList($pid)
    {
        $session = JFactory::getSession();
        $comparelist_ids = $session->get('comparelist');
        $comparelist = explode(",", trim($comparelist_ids));
        if (in_array($pid, $comparelist))
        {
            return true;
        } else
        {
            return false;
        }
    }

    /**
     * Update property to Facebook
     * @param $property
     * @param $isNew
     */
    public function updateFacebook($property, $isNew)
    {
        $configClass = self::loadConfig();
        if (version_compare(phpversion(), '5.4.0', 'ge'))
        {
            if (($configClass['facebook_autoposting'] == 1) and ( $configClass['fb_app_id'] != "") and ( $configClass['fb_app_secret'] != "") and ( $configClass['access_token'] != ""))
            {
                $posting_properties = $configClass['posting_properties'];
                if ($isNew == 1)
                {
                    if (($posting_properties == 0) or ( $posting_properties == 1))
                    {
                        self::updatePropertyToFacebook($property, $isNew);
                    }
                } else
                {
                    if (($posting_properties == 0) or ( $posting_properties == 2))
                    {
                        self::updatePropertyToFacebook($property, $isNew);
                    }
                }
            }
        }
    }

    /**
     * Update Property to Facebook
     * @param $property
     * @param $isNew
     * @return bool|mixed
     */
    public function updatePropertyToFacebook($property, $isNew)
    {
        require JPATH_ROOT . '/components/com_osproperty/helpers/inc/facebook.php';
        require_once JPATH_ROOT . '/components/com_osproperty/helpers/route.php';
        $configClass = self::loadConfig();
        $needs = array();
        $needs[] = "property_details";
        $needs[] = $property->id;
        $itemid = OSPRoute::getItemid($needs);
        $url = JURI::root() . "index.php?option=com_osproperty&task=property_details&id=$property->id&Itemid=" . $itemid;
        $url = self::get_tiny_url($url);
        switch ($isNew)
        {
            case "1":
                $message = JText::_('OS_NEW_PROPERTY_POSTED');
                break;
            default:
                $message = JText::_('OS_PROPERTY_UPDATED');
                break;
        }
        $appid = $configClass['fb_app_id'];
        $appkey = $configClass['fb_app_secret'];

        if (!$facebook = new Facebook(array('appId' => $appid, 'secret' => $appkey, 'cookie' => true)))
            return false;

        $access_token = $configClass['access_token'];
        if ($access_token == "")
        {
            return false;
        }
        $facebook->setAccessToken($access_token);

        $message .= '@ ' . $url;

        $db = JFactory::getDbo();
        $db->setQuery("Select image from #__osrs_photos where pro_id = '$property->id'");
        $image = $db->loadResult();
        $thumb = "";
        if (($image != "") and ( file_exists(JPATH_ROOT . '/images/osproperty/properties/' . $property->id . '/medium/' . $image)))
        {
            $thumb = JUri::root() . 'images/osproperty/properties/' . $property->id . '/medium/' . $image;
        }
        if (($property->price_call == 0) and ( $property->price > 0))
        {
            $message .= " - " . HelperOspropertyCommon::showPrice($property->price) . " " . self::loadCurrencyCode($property->curr);
            if ($property->rent_time != "")
            {
                $message .= " " . JText::_($property->rent_time);
            }
        }
        $fbpost = array(
            'message' => $message,
            'name' => $property->pro_name,
            'caption' => $property->pro_name,
            'link' => $url,
            'picture' => $thumb
        );
        $fb_target = $configClass['fb_target'];
        if ($fb_target == "")
        {
            $post_url = "/me/feed/";
        } else
        {
            $post_url = "/" . $fb_target . "/feed/";
        }
        $result = $facebook->api($post_url, 'post', $fbpost);
        return $result;
    }

    /**
     * Update property to Twitter
     * @param $property
     * @param $isNew
     */
    public function updateTweet($property, $isNew)
    {
        $configClass = self::loadConfig();
        if (($configClass['tweet_autoposting'] == 1) and ( $configClass['consumer_key'] != "") and ( $configClass['consumer_secret'] != "") and ( $configClass['tw_access_token'] != "") and ( $configClass['tw_access_token_secret'] != ""))
        {
            $posting_properties = $configClass['tw_posting_properties'];
            if ($isNew == 1)
            {
                if (($posting_properties == 0) or ( $posting_properties == 1))
                {
                    self::updatePropertyToTwitter($property, $isNew);
                }
            } else
            {
                if (($posting_properties == 0) or ( $posting_properties == 2))
                {
                    self::updatePropertyToTwitter($property, $isNew);
                }
            }
        }
    }

    /**
     * Update Property to Twitter
     * @param $property
     * @param $isNew
     * @return bool|mixed
     */
    public function updatePropertyToTwitter($property, $isNew)
    {
        require JPATH_ROOT . '/components/com_osproperty/helpers/tw/TwitterAPIExchange.php';
        require_once JPATH_ROOT . '/components/com_osproperty/helpers/route.php';
        $configClass = self::loadConfig();
        $needs = array();
        $needs[] = "property_details";
        $needs[] = $property->id;
        $itemid = OSPRoute::getItemid($needs);
        $url = JURI::root() . "index.php?option=com_osproperty&task=property_details&id=$property->id&Itemid=" . $itemid;
        $url = self::get_tiny_url($url);
        switch ($isNew)
        {
            case "1":
                $message = JText::_('OS_NEW_PROPERTY_POSTED');
                break;
            default:
                $message = JText::_('OS_PROPERTY_UPDATED');
                break;
        }
        $consumer_key = $configClass['consumer_key'];
        $consumer_secret = $configClass['consumer_secret'];
        $tw_access_token = $configClass['tw_access_token'];
        $tw_access_token_secret = $configClass['tw_access_token_secret'];

        /* Create a TwitterOauth object with consumer/user tokens. */
        $settings = array(
            'consumer_key' => $consumer_key,
            'consumer_secret' => $consumer_secret,
            'oauth_access_token' => $tw_access_token,
            'oauth_access_token_secret' => $tw_access_token_secret
        );
        $twitter = new TwitterAPIExchange($settings);

        if (($property->price_call == 0) and ( $property->price > 0))
        {
            $message .= " - " . HelperOspropertyCommon::showPrice($property->price) . " " . self::loadCurrencyCode($property->curr);
            if ($property->rent_time != "")
            {
                $message .= " " . JText::_($property->rent_time);
            }
        }

        $postFields = array(
            'status' => $message . ' ' . $url
        );
        $rs = json_decode($twitter->buildOauth('https://api.twitter.com/1.1/statuses/update.json', 'POST')->setPostfields($postFields)->performRequest());

        return $rs;
    }

    /**
     * Get tiny url
     * @param $url
     * @return mixed
     */
    public function get_tiny_url($url)
    {
        $ch = curl_init();
        $timeout = 30;
        curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . urlencode($url));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * Register Joomla User
     * @param $data
     */
    public static function registration($data, $usertype = 0)
    {
        $mainframe = JFactory::getApplication();
        $msg = array();
        $language = JFactory::getLanguage();
        $current_language = $language->getTag();
        $extension = 'com_users';
        $base_dir = JPATH_SITE;
        $language->load($extension, $base_dir, $current_language);
        $params = JComponentHelper::getParams('com_users');
        // Initialise the table with JUser.
        $user = new JUser;
        $new_usertype = $params->get('new_usertype', '2');
        $groups = array();
        $groups[0] = $new_usertype;
        $data['groups'] = $groups;
        $useractivation = $params->get('useractivation');
        $sendpassword = $params->get('sendpassword', 1);
        // Check if the user needs to activate their account.
        if (($useractivation == 1) || ($useractivation == 2))
        {
            jimport('joomla.user.helper');
            if (version_compare(JVERSION, '3.0', 'lt'))
            {
                $data['activation'] = JApplication::getHash(JUserHelper::genRandomPassword());
            } else
            {
                $data['activation'] = JApplication::getHash(JUserHelper::genRandomPassword());
            }
            $data['block'] = 1;
        }
        // Bind the data.
        if (!$user->bind($data))
        {
            if ($usertype == 0)
            {
                $needs = array();
                $needs[] = "agent_register";
                $needs[] = "aagentregistration";
                $itemid = OSPRoute::getItemid($needs);
                $mainframe->redirect(JRoute::_('index.php?option=com_osproperty&task=agent_register&Itemid=' . $itemid), JText::sprintf('OS_COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));
            } else
            {
                $needs = array();
                $needs[] = "company_register";
                $needs[] = "ccompanyregistration";
                $itemid = OSPRoute::getItemid($needs);
                $mainframe->redirect(JRoute::_('index.php?option=com_osproperty&task=company_register&Itemid=' . $itemid), JText::sprintf('OS_COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));
            }
            return false;
        }
        // Load the users plugin group.
        JPluginHelper::importPlugin('user');
        // Store the data.
        if (!$user->save())
        {
            if ($usertype == 0)
            {
                $needs = array();
                $needs[] = "agent_register";
                $needs[] = "aagentregistration";
                $itemid = OSPRoute::getItemid($needs);
                $mainframe->redirect(JRoute::_('index.php?option=com_osproperty&task=agent_register&Itemid=' . $itemid), JText::sprintf('OS_COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));
            } else
            {
                $needs = array();
                $needs[] = "company_register";
                $needs[] = "ccompanyregistration";
                $itemid = OSPRoute::getItemid($needs);
                $mainframe->redirect(JRoute::_('index.php?option=com_osproperty&task=company_register&Itemid=' . $itemid), JText::sprintf('OS_COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));
            }
            return false;
        }

        $config = JFactory::getConfig();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Compile the notification mail values.
        $data = $user->getProperties();
        $data['fromname'] = $config->get('fromname');
        $data['mailfrom'] = $config->get('mailfrom');
        $data['sitename'] = $config->get('sitename');
        $data['siteurl'] = JUri::base();

        // Handle account activation/confirmation emails.
        if ($useractivation == 2)
        {
            // Set the link to confirm the user email.
            $uri = JUri::getInstance();
            $base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
            $data['activate'] = $base . JRoute::_('index.php?option=com_users&task=registration.activate&token=' . $data['activation'], false);

            $emailSubject = JText::sprintf(
                            'COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']
            );

            if ($sendpassword)
            {
                $emailBody = JText::sprintf(
                                'COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username'], $data['password_clear']
                );
            } else
            {
                $emailBody = JText::sprintf(
                                'COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY_NOPW', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username']
                );
            }
        } elseif ($useractivation == 1)
        {
            // Set the link to activate the user account.
            $uri = JUri::getInstance();
            $base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
            $data['activate'] = $base . JRoute::_('index.php?option=com_users&task=registration.activate&token=' . $data['activation'], false);

            $emailSubject = JText::sprintf(
                            'COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']
            );

            if ($sendpassword)
            {
                $emailBody = JText::sprintf(
                                'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username'], $data['password_clear']
                );
            } else
            {
                $emailBody = JText::sprintf(
                                'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY_NOPW', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username']
                );
            }
        } else
        {

            $emailSubject = JText::sprintf(
                            'COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']
            );

            if ($sendpassword)
            {
                $emailBody = JText::sprintf(
                                'COM_USERS_EMAIL_REGISTERED_BODY', $data['name'], $data['sitename'], $data['siteurl'], $data['username'], $data['password_clear']
                );
            } else
            {
                $emailBody = JText::sprintf(
                                'COM_USERS_EMAIL_REGISTERED_BODY_NOPW', $data['name'], $data['sitename'], $data['siteurl']
                );
            }
        }

        // Send the registration email.
        $return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);

        // Send Notification mail to administrators
        if (($params->get('useractivation') < 2) && ($params->get('mail_to_admin') == 1))
        {
            $emailSubject = JText::sprintf(
                            'COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']
            );

            $emailBodyAdmin = JText::sprintf(
                            'COM_USERS_EMAIL_REGISTERED_NOTIFICATION_TO_ADMIN_BODY', $data['name'], $data['username'], $data['siteurl']
            );

            // Get all admin users
            $query->clear()
                    ->select($db->quoteName(array('name', 'email', 'sendEmail')))
                    ->from($db->quoteName('#__users'))
                    ->where($db->quoteName('sendEmail') . ' = ' . 1);

            $db->setQuery($query);

            try
            {
                $rows = $db->loadObjectList();
            } catch (RuntimeException $e)
            {
                JError::raiseError(500, JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()));
                return false;
            }

            // Send mail to all superadministrators id
            foreach ($rows as $row)
            {
                $return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $row->email, $emailSubject, $emailBodyAdmin);

                // Check for an error.
                if ($return !== true)
                {
                    $msg[] = JText::_('COM_USERS_REGISTRATION_ACTIVATION_NOTIFY_SEND_MAIL_FAILED');
                    return false;
                }
            }

            // Check for an error.
            if ($return !== true)
            {
                $msg[] = JText::_('COM_USERS_REGISTRATION_SEND_MAIL_FAILED');

                // Send a system message to administrators receiving system mails
                $db = JFactory::getDbo();
                $query->clear()
                        ->select($db->quoteName(array('name', 'email', 'sendEmail', 'id')))
                        ->from($db->quoteName('#__users'))
                        ->where($db->quoteName('block') . ' = ' . (int) 0)
                        ->where($db->quoteName('sendEmail') . ' = ' . (int) 1);
                $db->setQuery($query);

                try
                {
                    $sendEmail = $db->loadColumn();
                } catch (RuntimeException $e)
                {
                    JError::raiseError(500, JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()));
                    //$this->setError(JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()), 500);
                    return false;
                }

                if (count($sendEmail) > 0)
                {
                    $jdate = new JDate;
                    // Build the query to add the messages
                    foreach ($sendEmail as $userid)
                    {
                        $values = array($db->quote($userid), $db->quote($userid), $db->quote($jdate->toSql()), $db->quote(JText::_('COM_USERS_MAIL_SEND_FAILURE_SUBJECT')), $db->quote(JText::sprintf('COM_USERS_MAIL_SEND_FAILURE_BODY', $return, $data['username'])));
                        $query->clear()
                                ->insert($db->quoteName('#__messages'))
                                ->columns($db->quoteName(array('user_id_from', 'user_id_to', 'date_time', 'subject', 'message')))
                                ->values(implode(',', $values));
                        $db->setQuery($query);

                        try
                        {
                            $db->execute();
                        } catch (RuntimeException $e)
                        {
                            JError::raiseError(500, JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()));
                            //$this->setError(JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()), 500);
                            return false;
                        }
                    }
                }
                return false;
            }
        }

        // Redirect to the login screen.
        if ($useractivation == 2)
        {
            $msg[] = JText::_('COM_USERS_REGISTRATION_COMPLETE_VERIFY');
        } elseif ($useractivation == 1)
        {
            $msg[] = JText::_('COM_USERS_REGISTRATION_COMPLETE_ACTIVATE');
        } else
        {
            $msg[] = JText::_('COM_USERS_REGISTRATION_SAVE_SUCCESS');
        }
        $return = array();
        $return[0]->user = $user;
        $return[0]->message = $msg;
        return $return;
    }

    static function newJoomlaUser($data)
    {
        $language = JFactory::getLanguage();
        $current_language = $language->getTag();
        $extension = 'com_users';
        $base_dir = JPATH_SITE;
        $language->load($extension, $base_dir, $current_language);
        $params = JComponentHelper::getParams('com_users');
        // Initialise the table with JUser.
        $user = new JUser;
        $new_usertype = $params->get('new_usertype', '2');
        $groups = array();
        $groups[0] = $new_usertype;
        $data['groups'] = $groups;
        $useractivation = $params->get('useractivation');
        $sendpassword = $params->get('sendpassword', 1);
        // Check if the user needs to activate their account.
        if (($useractivation == 1) || ($useractivation == 2))
        {
            jimport('joomla.user.helper');
            if (version_compare(JVERSION, '3.0', 'lt'))
            {
                $data['activation'] = JApplication::getHash(JUserHelper::genRandomPassword());
            } else
            {
                $data['activation'] = JApplication::getHash(JUserHelper::genRandomPassword());
            }
            $data['block'] = 1;
        }
        if (!$user->bind($data))
        {
            return false;
        }
        // Load the users plugin group.
        JPluginHelper::importPlugin('user');
        // Store the data.
        if (!$user->save())
        {
            return false;
        }
        $config = JFactory::getConfig();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Compile the notification mail values.
        $data = $user->getProperties();
        $data['fromname'] = $config->get('fromname');
        $data['mailfrom'] = $config->get('mailfrom');
        $data['sitename'] = $config->get('sitename');
        $data['siteurl'] = JUri::base();

        // Handle account activation/confirmation emails.
        if ($useractivation == 2)
        {
            // Set the link to confirm the user email.
            $uri = JUri::getInstance();
            $base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
            $data['activate'] = $base . JRoute::_('index.php?option=com_users&task=registration.activate&token=' . $data['activation'], false);

            $emailSubject = JText::sprintf(
                            'COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']
            );

            if ($sendpassword)
            {
                $emailBody = JText::sprintf(
                                'COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username'], $data['password_clear']
                );
            } else
            {
                $emailBody = JText::sprintf(
                                'COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY_NOPW', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username']
                );
            }
        } elseif ($useractivation == 1)
        {
            // Set the link to activate the user account.
            $uri = JUri::getInstance();
            $base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
            $data['activate'] = $base . JRoute::_('index.php?option=com_users&task=registration.activate&token=' . $data['activation'], false);

            $emailSubject = JText::sprintf(
                            'COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']
            );

            if ($sendpassword)
            {
                $emailBody = JText::sprintf(
                                'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username'], $data['password_clear']
                );
            } else
            {
                $emailBody = JText::sprintf(
                                'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY_NOPW', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username']
                );
            }
        } else
        {

            $emailSubject = JText::sprintf(
                            'COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']
            );

            if ($sendpassword)
            {
                $emailBody = JText::sprintf(
                                'COM_USERS_EMAIL_REGISTERED_BODY', $data['name'], $data['sitename'], $data['siteurl'], $data['username'], $data['password_clear']
                );
            } else
            {
                $emailBody = JText::sprintf(
                                'COM_USERS_EMAIL_REGISTERED_BODY_NOPW', $data['name'], $data['sitename'], $data['siteurl']
                );
            }
        }

        // Send the registration email.
        $return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);

        // Send Notification mail to administrators
        if (($params->get('useractivation') < 2) && ($params->get('mail_to_admin') == 1))
        {
            $emailSubject = JText::sprintf(
                            'COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']
            );

            $emailBodyAdmin = JText::sprintf(
                            'COM_USERS_EMAIL_REGISTERED_NOTIFICATION_TO_ADMIN_BODY', $data['name'], $data['username'], $data['siteurl']
            );

            // Get all admin users
            $query->clear()
                    ->select($db->quoteName(array('name', 'email', 'sendEmail')))
                    ->from($db->quoteName('#__users'))
                    ->where($db->quoteName('sendEmail') . ' = ' . 1);

            $db->setQuery($query);

            try
            {
                $rows = $db->loadObjectList();
            } catch (RuntimeException $e)
            {
                JError::raiseError(500, JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()));
                return false;
            }

            // Send mail to all superadministrators id
            foreach ($rows as $row)
            {
                $return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $row->email, $emailSubject, $emailBodyAdmin);

                // Check for an error.
                if ($return !== true)
                {
                    $msg[] = JText::_('COM_USERS_REGISTRATION_ACTIVATION_NOTIFY_SEND_MAIL_FAILED');
                    return false;
                }
            }

            // Check for an error.
            if ($return !== true)
            {
                $msg[] = JText::_('COM_USERS_REGISTRATION_SEND_MAIL_FAILED');

                // Send a system message to administrators receiving system mails
                $db = JFactory::getDbo();
                $query->clear()
                        ->select($db->quoteName(array('name', 'email', 'sendEmail', 'id')))
                        ->from($db->quoteName('#__users'))
                        ->where($db->quoteName('block') . ' = ' . (int) 0)
                        ->where($db->quoteName('sendEmail') . ' = ' . (int) 1);
                $db->setQuery($query);

                try
                {
                    $sendEmail = $db->loadColumn();
                } catch (RuntimeException $e)
                {
                    JError::raiseError(500, JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()));
                    //$this->setError(JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()), 500);
                    return false;
                }

                if (count($sendEmail) > 0)
                {
                    $jdate = new JDate;
                    // Build the query to add the messages
                    foreach ($sendEmail as $userid)
                    {
                        $values = array($db->quote($userid), $db->quote($userid), $db->quote($jdate->toSql()), $db->quote(JText::_('COM_USERS_MAIL_SEND_FAILURE_SUBJECT')), $db->quote(JText::sprintf('COM_USERS_MAIL_SEND_FAILURE_BODY', $return, $data['username'])));
                        $query->clear()
                                ->insert($db->quoteName('#__messages'))
                                ->columns($db->quoteName(array('user_id_from', 'user_id_to', 'date_time', 'subject', 'message')))
                                ->values(implode(',', $values));
                        $db->setQuery($query);

                        try
                        {
                            $db->execute();
                        } catch (RuntimeException $e)
                        {
                            JError::raiseError(500, JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()));
                            //$this->setError(JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()), 500);
                            return false;
                        }
                    }
                }
                return false;
            }
        }
        return true;
    }

    /**
     * Login
     */
    public static function login($data)
    {
        $mainframe = JFactory::getApplication();
        $params = JComponentHelper::getParams('com_users');
        // Initialise the table with JUser.
        $useractivation = $params->get('useractivation');
        if ($useractivation == 0)
        {
            $data['return'] = base64_decode($data['return_url']);
            // Get the log in options.
            $options = array();
            $options['remember'] = 0;
            $options['return'] = $data['return'];
            // Get the log in credentials.
            $credentials = array();
            $credentials['username'] = $data['username'];
            $credentials['password'] = $data['password'];
            // Perform the log in.
            $error = $mainframe->login($credentials, $options);
        }
    }

    /**
     * Upload picture and resize pictures
     */
    public static function uploadAndResizePicture($file, $type, $oldpicture)
    {
        global $configClass;
        $configClass = self::loadConfig();
        jimport('joomla.filesystem.file');
        $picture_name = $file['name'];
        $picture_name = self::processImageName($picture_name);
        switch ($type)
        {
            case "agent":
                define('OSPATH_UPLOAD_PHOTO', JPATH_ROOT . '/images/osproperty/agent');
                //$picture_name = "agent".uniqid().".jpg";
                break;
            case "company":
                define('OSPATH_UPLOAD_PHOTO', JPATH_ROOT . '/images/osproperty/company');
                //$picture_name = "company".uniqid().".jpg";
                break;
        }
        if (move_uploaded_file($file['tmp_name'], OSPATH_UPLOAD_PHOTO . "/" . $picture_name))
        {
            // copy image before resize
            JFIle::copy(OSPATH_UPLOAD_PHOTO . "/" . $picture_name, OSPATH_UPLOAD_PHOTO . "/thumbnail/" . $picture_name);
            // resize image just copy and replace it self
            $thumb_width = $configClass['images_thumbnail_width'];
            $thumb_height = $configClass['images_thumbnail_height'];
            OSPHelper::resizePhoto(OSPATH_UPLOAD_PHOTO . "/thumbnail/" . $picture_name, $thumb_width, $thumb_height);
            // remove old image
            if ($oldpicture != "")
            {
                if (is_file(OSPATH_UPLOAD_PHOTO . "/" . $oldpicture))
                    unlink(OSPATH_UPLOAD_PHOTO . "/" . $oldpicture);
                if (is_file(OSPATH_UPLOAD_PHOTO . "/thumbnail/" . $oldpicture))
                    unlink(OSPATH_UPLOAD_PHOTO . "/thumbnail/" . $oldpicture);
            }
            // keep file name
            return $picture_name;
        }
    }

    /**
     * Return the correct image name
     *
     * @param unknown_type $image_name
     * @return unknown
     */
    public static function processImageName($image_name)
    {
        $image_name = str_replace(" ", "", $image_name);
        $image_name = str_replace("'", "", $image_name);
        $image_name = str_replace("\n", "", $image_name);
        $image_name = str_replace("\r", "", $image_name);
        $image_name = str_replace("\x00", "", $image_name);
        $image_name = str_replace("\x1a", "", $image_name);
        return $image_name;
    }

    /**
     * Load Currency code
     * @param $currency_code
     */
    public static function loadCurrencyCode($currency_id = '')
    {
        $configClass = self::loadConfig();
        $db = JFactory::getDbo();
        if ($currency_id == "")
        {
            $currency_id = $configClass['general_currency_default'];
        }
        $db->setQuery("Select currency_code from #__osrs_currencies where id = '$currency_id'");
        $currency_code = $db->loadResult();
        return $currency_code;
    }

    /**
     * Access Dropdown
     * @param $access
     */
    public static function accessDropdown($name, $selected, $attribs = '', $params = true, $id = false)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
                ->select('a.id AS value, a.title AS text')
                ->from('#__viewlevels AS a')
                ->group('a.id, a.title, a.ordering')
                ->order('a.ordering ASC')
                ->order($db->quoteName('title') . ' ASC');

        // Get the options.
        $db->setQuery($query);
        $options = $db->loadObjectList();

        // If params is an array, push these options to the array
        if (is_array($params))
        {
            $options = array_merge($params, $options);
        }
        // If all levels is allowed, push it into the array.
        elseif ($params)
        {
            array_unshift($options, JHtml::_('select.option', '', JText::_('JOPTION_ACCESS_SHOW_ALL_LEVELS')));
        }

        return JHtml::_(
                        'select.genericlist', $options, $name, array(
                    'list.attr' => $attribs,
                    'list.select' => $selected,
                    'id' => $id
                        )
        );
    }

    public static function returnAccessLevel($access)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
                ->select('title')
                ->from('#__viewlevels')
                ->where('id = ' . $access);
        // Get the options.
        $db->setQuery($query);
        $accesslevel = $db->loadResult();
        return $accesslevel;
    }

    static function getLimitStart()
    {
        $request = $_REQUEST;
        if (!isset($request['limitstart']))
        {
            $limitstart = 0;
        }
        if (isset($request['start']) && !isset($request['limitstart']))
        {
            $limitstart = $request['start'];
        }
        if (isset($request['limitstart']))
        {
            $limitstart = $request['limitstart'];
        }
        return $limitstart;
    }

    public static function registerNewAgent($user, $user_type)
    {
        global $mainframe, $jinput;
        if ($user->id == 0)
        {
            $user = JFactory::getUser();
        }
        if ($user->id == 0)
        {
            JError::raiseError(500, JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
        }
        if (HelperOspropertyCommon::isCompanyAdmin($user->id))
        {
            JError::raiseError(500, JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
        }
        $db = JFactory::getDbo();
        if (HelperOspropertyCommon::isAgent($user->id))
        {
            $db->setQuery("Select id from #__osrs_agents where user_id = '$user->id'");
            $agent_id = $db->loadResult();
            return $agent_id;
        }
        $configClass = self::loadConfig();
        $languages = OSPHelper::getLanguages();
        $agent = &JTable::getInstance('Agent', 'OspropertyTable');
        $post = $jinput->post->getArray();
        $agent->bind($post);
        if ($configClass['show_agent_image'] == 1)
        {
            if (is_uploaded_file($_FILES['photo']['tmp_name']))
            {
                if (!HelperOspropertyCommon::checkIsPhotoFileUploaded('photo'))
                {
                    //do nothing
                } else
                {
                    $agent->photo = OSPHelper::uploadAndResizePicture($_FILES['photo'], "agent", "");
                }
            }
        }
        if ($user_type == -1)
        {
            $user_type = $configClass['default_user_type'];
        }
        $agent->agent_type = $user_type;
        $agent->user_id = $user->id;
        $agent->name = $user->name;
        $agent->alias = strtolower(str_replace(" ", "", $agent->name));
        $agent->email = $user->email;
        if ($configClass['auto_approval_agent_registration'] == 1)
        {
            $agent->request_to_approval = 0;
            $agent->published = 1;
        } else
        {
            $agent->request_to_approval = 1;
            $agent->published = 0;
        }
        $db->setQuery("Select ordering from #__osrs_agents order by ordering desc");
        $ordering = $db->loadResult();
        $ordering++;
        $agent->ordering = $ordering;
        $agent->store();
        $agent_id = $db->insertid();


        //update for other languages
        $translatable = JLanguageMultilang::isEnabled() && count($languages);
        if ($translatable)
        {
            foreach ($languages as $language)
            {
                $sef = $language->sef;
                $bio_language = $agent->bio;
                if ($bio_language != "")
                {
                    $newagent = &JTable::getInstance('Agent', 'OspropertyTable');
                    $newagent->id = $agent_id;
                    $newagent->{'bio_' . $sef} = $bio_language;
                    $newagent->store();
                }
            }
        }

        $alias = OSPHelper::getStringRequest('alias', '', 'post');
        $agent_alias = OSPHelper::generateAlias('agent', $agent_id, $alias);
        $db->setQuery("Update #__osrs_agents set alias = '$agent_alias' where id = '$agent_id'");
        $db->query();

        if (intval($configClass['agent_joomla_group_id']) > 0)
        {
            $user_id = $user->id;
            $db->setQuery("Select count(user_id) from #__user_usergroup_map where user_id = '$user_id' and group_id = '" . $configClass['agent_joomla_group_id'] . "'");
            $count = $db->loadResult();
            if ($count == 0)
            {
                $db->setQuery("Insert into #__user_usergroup_map (user_id,group_id) values ('$user_id','" . $configClass['agent_joomla_group_id'] . "')");
                $db->query();
            }
        }

        return $agent_id;
    }

    /**
     * Load Theme Style
     */
    public static function loadThemeStyle($task)
    {
        global $jinput;
        $document = JFactory::getDocument();
        $db = JFactory::getDbo();
        if ($task != "")
        {
            $taskArr = explode("_", $task);
            $maintask = $taskArr[0];
        } else
        {
            //cpanel
            $maintask = "";
        }
        $itemid = $jinput->getInt('Itemid', 0);
        if (($task != "property_new") and ( $task != "property_edit") and ( $maintask != "ajax"))
        {

            $theme_id = 0;
            if ($itemid > 0)
            {
                $menus = JFactory::getApplication()->getMenu();
                $menu = $menus->getActive();
                if (is_object($menu))
                {
                    if ($itemid == $menu->id)
                    {
                        $menuParams = new JRegistry();
                        $menuParams->loadString($menu->params);
                        $theme_id = $menuParams->get('theme_id', '0');
                    }
                }
            }

            $db->setQuery("Select * from #__osrs_themes where published = '1'");
            $default_theme = $db->loadObject();
            $default_themename = ($default_theme->name != "") ? $default_theme->name : "default";

            if ($theme_id > 0)
            {
                $db->setQuery("Select * from #__osrs_themes where id = '$theme_id'");
                $theme = $db->loadObject();
                $themename = ($theme->name != "") ? $theme->name : $default_themename;
            } else
            {
                $themename = $default_themename;
            }

            if (file_exists(JPATH_ROOT . "/components/com_osproperty/templates/" . $themename . "/style/style.css"))
            {
                $document->addStyleSheet(JURI::root() . "components/com_osproperty/templates/" . $themename . "/style/style.css");
            }
            if (file_exists(JPATH_ROOT . '/media/com_osproperty/style/custom.css'))
            {
                if (filesize(JPATH_ROOT . '/media/com_osproperty/style/custom.css') > 0)
                {
                    $document->addStyleSheet(JUri::root() . "media/com_osproperty/style/custom.css");
                }
            }
        }
    }

    /**
     * Get Using Theme
     */
    public static function getThemeName()
    {
        static $default_theme, $jinput;
        $jinput = JFactory::getApplication()->input;
        $db = JFactory::getDbo();
        $itemid = $jinput->getInt('Itemid', 0);
        $theme_id = 0;
        if ($itemid > 0)
        {
            $menus = JSite::getMenu();
            $menu = $menus->getActive();
            if (is_object($menu))
            {
                if ($itemid == $menu->id)
                {
                    $menuParams = new JRegistry();
                    $menuParams->loadString($menu->params);
                    $theme_id = $menuParams->get('theme_id', '0');
                }
            }
        }
        if ($default_theme == "")
        {
            $db->setQuery("Select * from #__osrs_themes where published = '1'");
            $default_theme = $db->loadObject();
        }
        $default_themename = ($default_theme->name != "") ? $default_theme->name : "default";

        if ($theme_id > 0)
        {
            $db->setQuery("Select * from #__osrs_themes where id = '$theme_id'");
            $theme = $db->loadObject();
            $themename = ($theme->name != "") ? $theme->name : $default_themename;
        } else
        {
            $themename = $default_themename;
        }

        return $themename;
    }

    /**
     * Show base fields in Property details page
     * @param $row
     */
    public static function showBaseFields($row)
    {
        $configClass = self::loadConfig();
        if ((($configClass['use_rooms'] == 1) and ( $row->rooms > 0)) or ( ($configClass['use_bedrooms'] == 1) and ( $row->bed_room > 0)) or ( ($configClass['use_bathrooms'] == 1) and ( $row->bath_room > 0)) or ( $row->living_areas != ""))
        {
            ob_start();
            ?>
            <div class="clearfix"></div>
            <div class="row-fluid">
                <div class="span12">
                    <h4>
            <?php echo JText::_('OS_BASE_INFORMATION'); ?>
                    </h4>
                </div>
            </div>
            <?php if (($configClass['use_rooms'] == 1) and ( $row->rooms > 0))
            {
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <i class="osicon-ok"></i> <?php echo JText::_('OS_ROOMS') . ": " . $row->rooms; ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php if (($configClass['use_bedrooms'] == 1) and ( $row->bed_room > 0))
            {
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <i class="osicon-ok"></i> <?php echo JText::_('OS_BED') . ": " . $row->bed_room; ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php if (($configClass['use_bathrooms'] == 1) and ( $row->bath_room > 0))
            {
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <i class="osicon-ok"></i> <?php echo JText::_('OS_BATH') . ": " . self::showBath($row->bath_room); ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php if ($row->living_areas != "")
            {
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <i class="osicon-ok"></i> <?php echo JText::_('OS_LIVING_AREAS') . ": " . $row->living_areas; ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php
            $body = ob_get_contents();
            ob_end_clean();
        }
        return $body;
    }

    /**
     * @param $row
     * @return string
     */
    public static function showGarage($row)
    {
        $configClass = self::loadConfig();
        if (($configClass['use_parking'] == 1) and ( ($row->parking > 0) or ( $row->garage_description != "")))
        {
            ob_start();
            ?>
            <div class="clearfix"></div>
            <div class="row-fluid">
                <div class="span12">
                    <h4>
            <?php echo JText::_('OS_PARKING_INFORMATION'); ?>
                    </h4>
                </div>
            </div>
            <?php if ($row->parking > 0)
            {
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <i class="osicon-ok"></i> <?php echo JText::_('OS_PARKING') . ": " . $row->parking; ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php if ($row->garage_description != "")
            {
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <i class="osicon-ok"></i> <?php echo JText::_('OS_GARAGE_DESCRIPTION') . ": " . $row->garage_description; ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php
            $body = ob_get_contents();
            ob_end_clean();
        }
        return $body;
    }

    /**
     * @param $row
     * @return string
     */
    public static function buildingInfo($row)
    {
        $body = "";
        $configClass = self::loadConfig();
        if ($configClass['use_nfloors'] == 1)
        {
            $textFieldsArr = array('house_style', 'house_construction', 'exterior_finish', 'roof', 'flooring');
            $numberFieldArr = array('number_of_floors', 'floor_area_lower', 'floor_area_main_level', 'floor_area_upper', 'floor_area_total');
            $intFieldArr = array('built_on', 'remodeled_on');
            $show = 0;
            foreach ($textFieldsArr as $textfield)
            {
                if ($row->{$textfield} != "")
                {
                    $show = 1;
                }
            }
            foreach ($numberFieldArr as $numfield)
            {
                if ($row->{$numfield} > 0)
                {
                    $show = 1;
                }
            }
            foreach ($intFieldArr as $numfield)
            {
                if ($row->{$numfield} > 0)
                {
                    $show = 1;
                }
            }
            if ($show == 1)
            {
                ob_start();
                ?>
                <div class="clearfix"></div>
                <div class="row-fluid">
                    <div class="span12">
                        <h4>
                <?php echo JText::_('OS_BUILDING_INFORMATION'); ?>
                        </h4>
                    </div>
                </div>
                <?php
                foreach ($textFieldsArr as $textfield)
                {
                    if ($row->{$textfield} != "")
                    {
                        ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <i class="osicon-ok"></i> <?php echo JText::_('OS_' . strtoupper($textfield)) . ": " . $row->{$textfield}; ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                foreach ($intFieldArr as $numfield)
                {
                    if ($row->{$numfield} > 0)
                    {
                        ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <i class="osicon-ok"></i> <?php echo JText::_('OS_' . strtoupper($numfield)) . ": " . $row->{$numfield}; ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                foreach ($numberFieldArr as $numfield)
                {
                    if ($row->{$numfield} > 0)
                    {
                        ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <i class="osicon-ok"></i> <?php echo JText::_('OS_' . strtoupper($numfield)) . ": " . self::showBath($row->{$numfield}); ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                $body = ob_get_contents();
                ob_end_clean();
            }
        }
        return $body;
    }

    /**
     * @param $row
     * @return string
     */
    public static function basementFoundation($row)
    {
        $body = "";
        $configClass = self::loadConfig();
        if (($configClass['basement_foundation'] == 1) and ( ($row->basement_size > 0) or ( $row->basement_foundation != "") or ( $row->percent_finished != "")))
        {
            ob_start();
            ?>
            <div class="clearfix"></div>
            <div class="row-fluid">
                <div class="span12">
                    <h4>
            <?php echo JText::_('OS_BASEMENT_FOUNDATION'); ?>
                    </h4>
                </div>
            </div>
            <?php if ($row->basement_foundation != "")
            {
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <i class="osicon-ok"></i> <?php echo JText::_('OS_BASEMENT_FOUNDATION') . ": " . $row->basement_foundation; ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php if ($row->basement_size > 0)
            {
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <i class="osicon-ok"></i> <?php echo JText::_('OS_BASEMENT_SIZE') . ": " . self::showBath($row->basement_size); ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php if ($row->percent_finished != "")
            {
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <i class="osicon-ok"></i> <?php echo JText::_('OS_PERCENT_FINISH') . ": " . $row->percent_finished; ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php
            $body = ob_get_contents();
            ob_end_clean();
        }
        return $body;
    }

    /**
     * @param $row
     * @return string
     */
    public static function landInformation($row)
    {
        $configClass = self::loadConfig();
        $body = "";
        if ($configClass['use_squarefeet'] == 1)
        {
            $textFieldsArr = array('subdivision', 'land_holding_type', 'lot_dimensions', 'frontpage', 'depth');
            $numberFieldArr = array('total_acres', 'square_feet', 'lot_size');
            $show = 0;
            foreach ($textFieldsArr as $textfield)
            {
                if ($row->{$textfield} != "")
                {
                    $show = 1;
                }
            }
            foreach ($numberFieldArr as $numfield)
            {
                if ($row->{$numfield} > 0)
                {
                    $show = 1;
                }
            }
            if ($show == 1)
            {
                ob_start();
                ?>
                <div class="clearfix"></div>
                <div class="row-fluid">
                    <div class="span12">
                        <h4>
                <?php echo JText::_('OS_LAND_INFORMATION'); ?>
                        </h4>
                    </div>
                </div>
                <?php
                foreach ($textFieldsArr as $textfield)
                {
                    if ($row->{$textfield} != "")
                    {
                        ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <i class="osicon-ok"></i> <?php echo JText::_('OS_' . strtoupper($textfield)) . ": " . $row->{$textfield}; ?>

                            </div>
                        </div>
                                <?php
                            }
                        }
                        foreach ($numberFieldArr as $numfield)
                        {
                            if ($row->{$numfield} > 0)
                            {
                                ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <i class="osicon-ok"></i> <?php echo JText::_('OS_' . strtoupper($numfield)) . ": " . self::showBath($row->{$numfield}); ?>
                                <?php
                                switch ($numfield)
                                {
                                    case "square_feet":
                                    case "lot_size":
                                        echo " " . self::showSquareSymbol();
                                        break;
                                    default:
                                        echo " " . self::showAcresSymbol();
                                        break;
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                $body = ob_get_contents();
                ob_end_clean();
            }
        }
        return $body;
    }

    /**
     * @param $row
     * @return string
     */
    public static function businessInformation($row)
    {
        $body = "";
        $configClass = self::loadConfig();
        if ($configClass['use_business'] == 1)
        {
            $textFieldsArr = array('takings', 'returns', 'net_profit', 'business_type', 'stock', 'fixtures', 'fittings', 'percent_office', 'percent_warehouse', 'loading_facilities');
            $show = 0;
            foreach ($textFieldsArr as $textfield)
            {
                if ($row->{$textfield} != "")
                {
                    $show = 1;
                }
            }

            if ($show == 1)
            {
                ob_start();
                ?>
                <div class="clearfix"></div>
                <div class="row-fluid">
                    <div class="span12">
                        <h4>
                <?php echo JText::_('OS_BUSINESS_INFORMATION'); ?>
                        </h4>
                    </div>
                </div>
                <?php
                foreach ($textFieldsArr as $textfield)
                {
                    if ($row->{$textfield} != "")
                    {
                        ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <i class="osicon-ok"></i> <?php echo JText::_('OS_' . strtoupper($textfield)) . ": " . $row->{$textfield}; ?>

                            </div>
                        </div>
                        <?php
                    }
                }
                $body = ob_get_contents();
                ob_end_clean();
            }
        }
        return $body;
    }

    /**
     * @param $row
     * @return string
     */
    public static function ruralInformation($row)
    {
        $configClass = self::loadConfig();
        $body = "";
        if ($configClass['use_rural'] == 1)
        {
            $textFieldsArr = array('fencing', 'rainfall', 'soil_type', 'grazing', 'cropping', 'irrigation', 'water_resources', 'carrying_capacity', 'storage');
            $show = 0;
            foreach ($textFieldsArr as $textfield)
            {
                if ($row->{$textfield} != "")
                {
                    $show = 1;
                }
            }

            if ($show == 1)
            {
                ob_start();
                ?>
                <div class="clearfix"></div>
                <div class="row-fluid">
                    <div class="span12">
                        <h4>
                <?php echo JText::_('OS_RURAL_INFORMATION'); ?>
                        </h4>
                    </div>
                </div>
                <?php
                foreach ($textFieldsArr as $textfield)
                {
                    if ($row->{$textfield} != "")
                    {
                        ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <i class="osicon-ok"></i> <?php echo JText::_('OS_' . strtoupper($textfield)) . ": " . $row->{$textfield}; ?>

                            </div>
                        </div>
                        <?php
                    }
                }
                $body = ob_get_contents();
                ob_end_clean();
            }
        }
        return $body;
    }

    public static function showCoreFields($property)
    {
        $tmpArray = array();
        $tmpArray[] = OSPHelper::showBaseFields($property);
        $tmpArray[] = OSPHelper::showGarage($property);
        $tmpArray[] = OSPHelper::buildingInfo($property);
        $tmpArray[] = OSPHelper::basementFoundation($property);
        $tmpArray[] = OSPHelper::landInformation($property);
        $tmpArray[] = OSPHelper::businessInformation($property);
        $tmpArray[] = OSPHelper::ruralInformation($property);
        ob_start();
        ?>
        <div class="row-fluid">
            <?php
            $i = 0;
            foreach ($tmpArray as $tmp)
            {
                if ($tmp != "")
                {
                    $i++;
                    ?>
                    <div class="span6">
                <?php echo $tmp; ?>
                    </div>
                <?php
                if ($i == 2)
                {
                    $i = 0;
                    echo "</div><div class='row-fluid'>";
                }
            }
        }
        ?>
        </div>
        <?php
        $body = ob_get_contents();
        ob_end_clean();
        return $body;
    }

    public static function checkFieldWithPropertType($fid, $pid)
    {
        $db = JFactory::getDbo();
        $db->setQuery("Select pro_type from #__osrs_properties where id = '$pid'");
        $pro_type = $db->loadResult();

        $db->setQuery("Select count(id) from #__osrs_extra_field_types where fid = '$fid' and type_id = '$pro_type'");
        $count = $db->loadResult();
        if ($count == 0)
        {
            return false;
        } else
        {
            return true;
        }
    }

    public static function getCountryName($country_id)
    {
        static $country_name;
        $db = JFactory::getDbo();
        if (!HelperOspropertyCommon::checkCountry())
        {
            $default_country_id = HelperOspropertyCommon::getDefaultCountry();
            if ($country_id == $default_country_id)
            {
                if ($country_name == null)
                {
                    $country_name_value = self::loadCountryName($country_id);
                    $country_name = $country_name_value;
                } else
                {
                    $country_name_value = $country_name;
                }
            } else
            {
                $country_name_value = self::loadCountryName($country_id);
            }
        } else
        {
            $country_name_value = self::loadCountryName($country_id);
        }
        return $country_name_value;
    }

    public static function showRatingOverPicture($rate, $color)
    {
        $rate = round($rate);
        for ($i = 0; $i < $rate; $i++)
        {
            ?>
            <i class="osicon-star" style="color:<?php echo $color; ?>;"></i>
            <?php
        }
        $i = $rate;
        if ($i < 5)
        {
            for ($j = $i; $j < 5; $j++)
            {
                ?>
                <i class="osicon-star" style="color:#E9F0F4;"></i>
                <?php
            }
        }
    }

    //get Association article for Term and Condition
    public static function getAssocArticleId($articleId)
    {
        if (JLanguageMultilang::isEnabled())
        {
            $associations = JLanguageAssociations::getAssociations('com_content', '#__content', 'com_content.item', $articleId);
            $langCode = JFactory::getLanguage()->getTag();
            if (isset($associations[$langCode]))
            {
                $article = $associations[$langCode];
            }
        }
        if (!isset($article))
        {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('id, catid')
                    ->from('#__content')
                    ->where('id = ' . (int) $articleId);
            $db->setQuery($query);
            $article = $db->loadObject();
        }
        require_once JPATH_ROOT . '/components/com_content/helpers/route.php';
        $termLink = ContentHelperRoute::getArticleRoute($article->id, $article->catid) . '&tmpl=component&format=html';
        return $termLink;
    }

    static function in_array_field($needle, $needle_field, $haystack, $strict = false)
    {
        if ($strict)
        {
            foreach ($haystack as $item)
                if (isset($item->$needle_field) && $item->$needle_field === $needle)
                    return true;
        }
        else
        {
            foreach ($haystack as $item)
                if (isset($item->$needle_field) && $item->$needle_field == $needle)
                    return true;
        }
        return false;
    }

    static function in_array_sub($needle, $haystack)
    {
        foreach ($haystack as $item)
        {
            $value = $item->value;
            if (in_array($needle, $value))
            {
                return true;
            }
        }
        return false;
    }

    static function find_key($needle, $haystack)
    {
        $find = 0;
        $key = '';
        foreach ($haystack as $dup)
        {
            if ($dup->id == $needle)
            {
                $key = $find;
            }
            $find++;
        }
        return $key;
    }

    static function findGoogleDuplication($rows)
    {
        //process data
        $tempArr = array();
        $i = 0;
        foreach ($rows as $row)
        {
            if (($row->show_address == 1) and ( $row->lat_add != "") and ( $row->long_add != ""))
            {
                $tempArr[$i]->id = $row->id;
                $tempArr[$i]->lat_add = $row->lat_add;
                $tempArr[$i]->long_add = $row->long_add;
                $i++;
            }
        }

        $duplicate = array();
        for ($i = 0; $i < count($tempArr) - 1; $i++)
        {
            for ($j = 1; $j < count($tempArr); $j++)
            {
                if (($tempArr[$i]->id != $tempArr[$j]->id) and ( $tempArr[$i]->lat_add == $tempArr[$j]->lat_add) and ( $tempArr[$i]->long_add == $tempArr[$j]->long_add))
                {
                    $count = count($duplicate);
                    if ((!self::in_array_field($tempArr[$i]->id, 'id', $duplicate)) and ( !self::in_array_sub($tempArr[$i]->id, $duplicate)))
                    {
                        $duplicate[$count]->id = $tempArr[$i]->id;
                        $duplicate[$count]->value[0] = $tempArr[$j]->id;
                    } elseif (self::in_array_field($tempArr[$i]->id, 'id', $duplicate))
                    {
                        $key = self::find_key($tempArr[$i]->id, $duplicate);
                        $duplicate[$key]->value[count($duplicate[$key]->value)] = $tempArr[$j]->id;
                    }
                }
            }
        }
        for ($i = 0; $i < count($tempArr); $i++)
        {
            $count = count($duplicate);
            if ((!self::in_array_field($tempArr[$i]->id, 'id', $duplicate)) and ( !self::in_array_sub($tempArr[$i]->id, $duplicate)))
            {
                $duplicate[$count]->id = $tempArr[$i]->id;
            }
        }

        return $duplicate;
    }

}
?>