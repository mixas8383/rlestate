<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of property
 *
 * @author mixas
 */
class Property extends JObject
{

    private $_property = null;
    private $_db = null;
    private $_configClass;

    public function __construct($id = '')
    {
        $this->_db = JFactory::getDbo();
        if (!empty($id))
        {
            if (is_array($id) || is_object($id))
            {
                
            } else
            {
                if (!empty($id))
                {
                    $this->load($id);
                }
            }
        }
    }

    public function load($id)
    {
        global $lang_suffix;
        //#__osrs_properties where id = '$id'"
        $query = $this->_db->getQuery(true);


        $query->select('p.*')
                ->select('ty.type_icon')
                ->select('st.state_name' . $lang_suffix . ' AS state_name')
                ->select('ot.type_name AS type_name')
                ->from($this->_db->quoteName('#__osrs_properties') . ' AS p')
                ->join('INNER', ' #__osrs_types AS ty ON ty.id = p.pro_type')
                ->join('left', ' #__osrs_states AS st ON st.id = p.state')
                ->join('left', ' #__osrs_types AS ot ON ot.id = p.pro_type')
                ->where($this->_db->quoteName('p.id') . ' = ' . $id . '');
        $this->_db->setQuery($query);
        $this->_property = $this->_db->loadObject();


        return $this->_property;
    }

    public function isOwner()
    {
        $user = JFactory::getUser();
        $agent_id = $this->_property->agent_id;
        if (intval($user->id) > 0)
        {
            $this->_db->setQuery("Select count(a.id) from #__osrs_agents as a inner join #__users as b on b.id = a.user_id where a.user_id = '$user->id'");
            $countagent = $this->_db->loadResult();
            if ($countagent > 0)
            {
                $this->_db->setQuery("Select id from #__osrs_agents where user_id = '$user->id'");
                $user_agent_id =  $this->_db->loadResult();
                if ($user_agent_id == $agent_id)
                {
                    $owner = 1;
                }
            }
        }
    }

    public function showMeta($show_meta)
    {

        $document = JFactory::getDocument();
        if ($show_meta == 1)
        {
            $translatable = JLanguageMultilang::isEnabled() && count($languages);

            // set meta keywords
            $keywords = "";
            if ($this->_property->id)
            {
                $query = 'Select a.* from #__osrs_tags as a inner join #__osrs_tag_xref as b on b.tag_id = a.id where b.pid = ' . $this->_property->id . '';
                $this->_db->setQuery($query);
                $tags = $this->_db->loadObjectList();
            }

            if ($translatable)
            {
                $metadesc = $this->_property->{'metadesc' . $lang_suffix};

                if ($metadesc == "")
                {
                    $metadesc = $this->_property->metadesc;
                }
                if (count($tags) > 0)
                {
                    $tagArr = array();
                    foreach ($tags as $tag)
                    {
                        $tagArr[] = $tag->{'keyword' . $lang_suffix};
                    }
                    if (count($tagArr) > 0)
                    {
                        $keywords = implode(", ", $tagArr);
                    }
                }
            } else
            {
                $metadesc = $this->_property->metadesc;

                if (count($tags) > 0)
                {
                    $tagArr = array();
                    foreach ($tags as $tag)
                    {
                        $tagArr[] = $tag->keyword;
                    }
                    if (count($tagArr) > 0)
                    {
                        $keywords = implode(", ", $tagArr);
                    }
                }
            }

            $orig_metakey = $document->getMetaData('keywords');
            if ($keywords != "")
                $document->setMetaData("keywords", $keywords);

            $orig_metadesc = $document->getMetaData('description');
            if ($this->_property->metadesc)
                $document->setMetaData("description", $metadesc);
        }
    }

    public function getPathway($configClass)
    {
        $pathway = JFactory::getApplication()->getPathway();
        $jinput = JFactory::getApplication()->input;
//add pathway
        $catArr = array();
        $catArr = HelperOspropertyCommon::getCatList($this->_property->category_id, $catArr);


        if ($configClass['include_categories'] == 1)
        {
            if (count($catArr) > 0)
            {
                for ($i = 0; $i < count($catArr); $i++)
                {
                    $pathway->addItem($catArr[$i]->cat_name, JRoute::_('index.php?option=com_osproperty&task=category_details&id=' . $catArr[$i]->id . '&Itemid=' . $jinput->getInt('Itemid', 0)));
                }
            }
        }

        $type_id = $this->_property->pro_type;
        $this->_db->setQuery("Select * from #__osrs_types where id = '$type_id'");
        $type = $this->_db->loadObject();
        $type_name = OSPHelper::getLanguageFieldValue($type, 'type_name');
        $needs = array();
        $needs[] = "ltype";
        $needs[] = "property_type";
        $needs[] = "type_id=" . $type_id;
        $itemid = OSPRoute::getItemid($needs);
        if ($configClass['include_type'] == 1)
        {
            $pathway->addItem($type_name, JRoute::_('index.php?option=com_osproperty&view=ltype&type_id=' . $type_id . '&Itemid=' . $itemid));
        }
        $needs = array();
        $needs[] = "property_type";
        $needs[] = $this->_property->id;
        $itemid = OSPRoute::getItemid($needs);
        if ($configClass['include_categories'] == 1)
        {
            $pathway->addItem(OSPHelper::getLanguageFieldValue($this->_property, 'pro_name'), JRoute::_('index.php?option=com_osproperty&task=property_details&id=' . $this->_property->id . '&Itemid=' . $itemid));
        }
        return $pathway;
    }

    public function hit()
    {
        //increase hits
        $user_data = "";
        $user_data = isset($_COOKIE['osp_user_data' . $this->_property->id]) ? $_COOKIE['osp_user_data' . $this->_property->id] : '';
        if ($user_data == "")
        {
            $user_data = md5(time());
            setcookie('osp_user_data' . $this->_property->id, $user_data, time() + 3600);
            //increase hits
            $hits = $this->_property->hits;
            $hits++;
            $this->_db->setQuery('Update #__osrs_properties set hits = ' . $hits . ' where id = ' . $this->_property->id . '');
            $this->_db->query();
            $hit_time = time();
            setcookie('osp_hit_time' . $this->_property->id, $hit_time, time() + 3600);
        } else
        {
            $hit_time = isset($_COOKIE['osp_hit_time' . $this->_property->id]) ? $_COOKIE['osp_hit_time' . $this->_property->id] : 0;
            if ($hit_time <= time() - 3600)
            {
                $hits = $this->_property->hits;
                $hits++;
                $this->_db->setQuery('Update #__osrs_properties set hits = ' . $hits . ' where id = ' . $this->_property->id . '');
                $this->_db->query();
            }
        }
    }

    public function remakeData($configClass)
    {
        $pro_name = OSPHelper::getLanguageFieldValue($this->_property, 'pro_name');
        $this->_property->pro_name = $pro_name;
        $pro_small_desc = OSPHelper::getLanguageFieldValue($this->_property, 'pro_small_desc');
        $this->_property->pro_small_desc = $pro_small_desc;
        $pro_full_desc = OSPHelper::getLanguageFieldValue($this->_property, 'pro_full_desc');
        $this->_property->pro_full_desc = $pro_full_desc;
        $this->_property->type_name = OSPHelper::getLanguageFieldValue($this->_property, 'type_name');
        ;


        if (($this->_property->published == 0) or ( $this->_property->approved == 0))
        {
            $redirect_link = $configClass['property_not_avaiable'];
            if ($redirect_link != "")
            {
                $mainframe->redirect($redirect_link, JText::_("OS_PROPERTY_IS_NOT_AVAILABLE"));
            } else
            {
                JError::raiseError(404, JText::_('OS_PROPERTY_IS_NOT_AVAILABLE'));
            }
        }
        if ($this->_property->pro_video != "")
        {
            $this->_property->pro_video = "<div class='video-container'>" . $this->_property->pro_video . "</div>";
        }



        $this->_property->country_name = OSPHelper::getCountryName($this->_property->country);

        $this->setStateName();
        $this->setCategoryName();
        $this->setTypeName();
        $this->setOgTitles();
        $this->setAmenities();
        $this->setFieldGroups();
        $this->setAgent();
        $this->setComments();
        $this->getNearlyInSeach();
        $this->getRelatedProperties();
        $this->getRelatedPropertyTypes();
    }

    public function setStateName()
    {
        return;
        //joined to load function
//        global $lang_suffix;
//        $this->_db->setQuery('select state_name' . $lang_suffix . ' as state_name from #__osrs_states where id = ' . $this->_property->state . '');
//        $this->_property->state_name = $this->_db->loadResult();
    }

    public function setCategoryName()
    {
        $this->_property->category_name = OSPHelper::getCategoryNamesOfPropertyWithLinks($this->_property->id);
    }

    public function setTypeName()
    {
        return;
//joined to load function
//        $this->_db->setQuery('select * from #__osrs_types where id = ' . $this->_property->pro_type . '');
//        $property_type = $this->_db->loadObject();
//        $this->_property->type_name = OSPHelper::getLanguageFieldValue($property_type, 'type_name');
    }

    public function setOgTitles()
    {
        $document = JFactory::getDocument();
        $this->_db->setQuery('Select image from #__osrs_photos where pro_id = ' . $this->_property->id . ' order by ordering');
        $image = $this->_db->loadResult();

        if ($image != "")
        {
            if (file_exists(JPATH_ROOT . DS . "images" . DS . "osproperty" . DS . "properties" . DS . $this->_property->id . DS . "medium" . DS . $image))
            {
                $link = JUri::root() . "images/osproperty/properties/" . $this->_property->id . "/medium/" . $image;
                $document->addCustomTag('<link rel="image_src" href="' . $link . '" />');
                $document->addCustomTag('<meta property="og:image" content="' . $link . '" />');
            }
        }
        $document->addCustomTag('<meta property="og:title" content="' . $this->_property->pro_name . '" />');
        $uri = JURI::getInstance();
        $document->addCustomTag('<meta property="og:url" content="' . htmlspecialchars($uri->toString()) . '" />');
        $document->addCustomTag('<meta property="og:type" content="website" />');
        $document->addCustomTag('<meta property="og:description" content="' . OSPHelper::getLanguageFieldValue($this->_property, 'pro_small_desc') . '" />');
    }

    public function setAmenities()
    {
        $configClass = $this->getConfigClass();
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
        $l = 0;
        if ($configClass['show_unselected_amenities'] == 1)
        {
            ob_start();



            $this->_db->setQuery(''
                    . 'Select a.*,b.id as rel_id from #__osrs_amenities as a'
                    . ' LEFT join #__osrs_property_amenities as b on b.amen_id = a.id'
                    . ' where a.published = "1" and b.pro_id = ' . $this->_property->id . ' '
                    . ' and a.category_id in (0,1,2,3,4,5,6,7,8) order by a.ordering'
                    . ''
                    . ''
                    . ''
                    . '');
            $rows = $this->_db->loadObjectList();
            $amens = array();

            foreach ($rows as $one)
            {
                if (empty($amens[$one->category_id]))
                {
                    $amens[$one->category_id] = new stdClass();
                    $amens[$one->category_id]->items = array();
                    $amens[$one->category_id]->id = $one->id;
                    $amens[$one->category_id]->category_id = $one->category_id;
                    $amens[$one->category_id]->amenities = $one->amenities;
                }
                $amens[$one->category_id]->items[] = $one;
            }



            foreach ($optionArr as $amen_cat)
            {
//                $query = 'Select * from #__osrs_amenities where published = "1" and category_id = ' . $l . ' order by ordering';
//                $this->_db->setQuery($query);
//                $amenities = $this->_db->loadObjectList();

                $amenities = array();
                $property_amenities = array();
                foreach ($amens as $one)
                {
                    if ($one->category_id == $l)
                    {
                        foreach ($one->items as $two)
                        {
                            $amenities[] = $two;
                            if (!empty($two->rel_id))
                            {
                                $property_amenities[] = $two->id;
                            }
                        }
                    }
                }

//                $query = 'Select a.id from #__osrs_amenities as a'
//                        . ' inner join #__osrs_property_amenities as b on b.amen_id = a.id'
//                        . ' where a.published = "1" and b.pro_id = ' . $this->_property->id . ' and a.category_id = ' . $l . ' order by a.ordering';
//                $this->_db->setQuery($query);
                //  $property_amenities = $this->_db->loadColumn(0);


                $amens_str1 = "";
                if (count($amenities) > 0)
                {
                    $amens_str = "";
                    $j = 0;
                    $k = 0;
                    if ($configClass['amenities_layout'] == 1)
                    {
                        $span = "span6";
                        $jump = 2;
                    } else
                    {
                        $span = "span4";
                        $jump = 3;
                    }
                    ?>
                    <div class="row-fluid">
                        <h5><strong><?php echo $amen_cat ?></strong></h5>
                    </div>
                    <div class="row-fluid">
                        <?php
                        for ($i = 0; $i < count($amenities); $i++)
                        {
                            $k++;
                            $amen = $amenities[$i];
                            if (in_array($amen->id, $property_amenities))
                            {
                                $style = "color:#99103A;";
                                $style1 = "";
                            } else
                            {
                                $style = "color:#CCC;";
                                $style1 = $style;
                            }
                            ?>
                            <div class="<?php echo $span; ?>" style="<?php echo $style1; ?>">
                                <i class='osicon-ok'
                                   style="<?php echo $style; ?>"></i> <?php echo OSPHelper::getLanguageFieldValue($amen, 'amenities'); ?>
                            </div>
                            <?php
                            if ($k % $jump == 0)
                            {
                                $k = 0;
                                echo "</div><div class='row-fluid'>";
                            }
                        }
                        ?>
                    </div>
                    <?php
                }
                $l++;
            }
            $amens_str = ob_get_contents();
            ob_end_clean();
        } else
        {
            ob_start();
            
             $this->_db->setQuery(''
                    . 'Select a.*,b.id as rel_id from #__osrs_amenities as a'
                    . ' inner join #__osrs_property_amenities as b on b.amen_id = a.id'
                    . ' where a.published = "1" and b.pro_id = ' . $this->_property->id . ' '
                    . ''
                     . ' order by a.ordering'
                    . ''
                    . ''
                    . ''
                    . '');
            $rows = $this->_db->loadObjectList();
            $amenss = array();

            foreach ($rows as $one)
            {
                if (empty($amenss[$one->category_id]))
                {
                    $amenss[$one->category_id] = new stdClass();
                    $amenss[$one->category_id]->items = array();
                    $amenss[$one->category_id]->id = $one->id;
                    $amenss[$one->category_id]->category_id = $one->category_id;
                    $amenss[$one->category_id]->amenities = $one->amenities;
                }
                $amenss[$one->category_id]->items[] = $one;
            }
             
            foreach ($optionArr as $amen_cat)
            {
//                $query = "Select a.* from #__osrs_amenities as a"
//                        . " inner join #__osrs_property_amenities as b on b.amen_id = a.id"
//                        . ' where a.published = "1" and b.pro_id = ' . $this->_property->id . ' and a.category_id = ' . $l . ' order by a.ordering';
//                $this->_db->setQuery($query);
//                
//                
//                $amens = $this->_db->loadObjectList();
               
                $amens = array();
                 
                foreach ($amenss as $one)
                {
                    if ($one->category_id == $l)
                    {
                        foreach ($one->items as $two)
                        {
                            $amenities[] = $two;
                            if (!empty($two->rel_id))
                            {
                                $amens[] = $two;
                            }
                        }
                    }
                }
                
                
                
                $amens_str1 = "";
                if (count($amens) > 0)
                {
                    $amens_str = "";
                    $j = 0;
                    $k = 0;
                    if ($configClass['amenities_layout'] == 1)
                    {
                        $span = "span6";
                        $jump = 2;
                    } else
                    {
                        $span = "span4";
                        $jump = 3;
                    }
                    ?>
                    <div class="row-fluid">
                        <h5><strong><?php echo $amen_cat ?></strong></h5>
                        <div class="span12">
                            <?php
                            for ($i = 0; $i < count($amens); $i++)
                            {
                                $k++;
                                $amen = $amens[$i];
                                ?>
                                <div class="<?php echo $span; ?>">
                                    <i class='osicon-ok'></i> <?php echo OSPHelper::getLanguageFieldValue($amen, 'amenities'); ?>
                                </div>
                                <?php
                                if ($k % $jump == 0)
                                {
                                    $k = 0;
                                    echo "</div><div class='span12' style='min-height:0px !important;'>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                $l++;
            }
            $amens_str = ob_get_contents();
            ob_end_clean();
        }
        $this->_property->amens_str = $amens_str;
        $this->_property->amens_str1 = $amens_str;
    }

    public function setFieldGroups()
    {
        $access_sql = ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';

        $extra_field_groups = array();
//        $this->_db->setQuery("Select * from #__osrs_fieldgroups where published = '1' $access_sql order by ordering");
//        $fieldgroups = $this->_db->loadObjectList();
        $j = 0;




//        if (count($fieldgroups) > 0)
//        {

        $this->_db->setQuery('SELECT fg.*,b.field_type,b.field_label,v.value,v.value_integer,v.value_decimal,v.value_date '
                . ', GROUP_CONCAT(fo.field_option) as foption'
                . ',b.displaytitle'
                . ',b.field_description'
                . ',b.value_type'
                . ''
                . ''
                . ' FROM #__osrs_fieldgroups AS fg'
                . ' INNER JOIN #__osrs_extra_fields as b on b.group_id=fg.id AND b.published = 1'
                . ' INNER JOIN #__osrs_extra_field_types as t on t.fid = b.id and t.type_id=' . $this->_property->pro_type // cheking if file tipe is linked 
                . ' LEFT JOIN #__osrs_property_field_value as v on v.field_id=b.id and v.pro_id =' . $this->_property->id
                . ' left JOIN #__osrs_property_field_opt_value as ov on ov.fid=b.id and ov.pid =' . $this->_property->id
                . ' left join #__osrs_extra_field_options AS fo ON fo.id=ov.oid'
                . ' WHERE fg.published = 1 '
                . ' AND((v.field_id=b.id AND  v.pro_id =' . $this->_property->id . ')OR(ov.fid=b.id AND ov.pid =' . $this->_property->id . '))'
                . ' AND fg.`access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')'
                . ''
                . ''
                . ''
                . ''
                . ''
                . ' GROUP BY b.id '
                . ' ORDER BY fg.ordering');

        $ext = $this->_db->loadObjectList();
        $extfields = array();
        if (!empty($ext))
        {
            $i = 0;
            foreach ($ext as $one)
            {
                $tmp = new stdClass;
                $tmp->field_label = $one->field_label;
                $tmp->displaytitle = $one->displaytitle;
                $tmp->field_type = $one->field_type;
                $tmp->field_description = $one->field_description;

                if ($one->field_type == 'text' || $one->field_type == 'textarea')
                {


                    if ($one->value_type == 0)
                    {
                        if (empty($one->value))
                        {
                            continue;
                        } else
                        {
                            $tmp->value = $one->value;
                        }
                    } elseif ($one->value_type == 1)
                    {
                        if ($one->value_integer > 0)
                        {
                            $tmp->value = $one->value_integer;
                        } else
                        {
                            continue;
                        }
                    } elseif ($one->value_type == 2)
                    {
                        if ($one->value_decimal > 0)
                        {
                            $tmp->value = $one->value_decimal;
                        } else
                        {
                            continue;
                        }
                    }
                } elseif ($one->field_type == 'date')
                {
                    if (empty(trim($one->value_date)))
                    {
                        continue;
                    } else
                    {
                        $tmp->value = $one->value_date;
                    }
                } elseif (trim($one->field_type) == 'radio' || trim($one->field_type) == 'singleselect' || trim($one->field_type) == 'checkbox' || trim($one->field_type) == 'multipleselect')
                {

                    if (empty($one->foption))
                    {
                        continue;
                    } else
                    {
                        $tmp->value = $one->foption;
                    }
                } else
                {
                    continue;
                }

                if (isset($extfields[$one->id]))
                {
                    $extfields[$one->id]->fields[] = $tmp;
                } else
                {
                    $tt = new stdClass();
                    $tt->group_name = $one->group_name;
                    $tt->fields = array($tmp);
                    $extfields[$one->id] = $tt;
                }
            }
        }


//            for ($i = 0; $i < count($fieldgroups); $i++)
//            {
//                $fieldgroup = $fieldgroups[$i];
//
//                $checkgroup = HelperOspropertyFields::checkFieldData($this->_property, $fieldgroup->id);
//
//                if ($checkgroup == 1)
//                {
//                    $extra_field_groups[$j] = new stdClass;
//                    $extra_field_groups[$j]->group_name = OSPHelper::getLanguageFieldValue($fieldgroup, 'group_name');
//                    $extra_field_groups[$j]->fields = HelperOspropertyFields::getFieldsData($this->_property, $fieldgroup->id);
//                    $j++;
//                }
//            }
        //}
        usort($extfields, function($a, $b)
        {
            return true;
        });
        $this->_property->extra_field_groups = $extfields;
    }

    public function getPropertyObject()
    {
        return $this->_property;
    }

    public function setConfigClass($configClass)
    {
        $this->_configClass = $configClass;
    }

    public function getConfigClass()
    {
        return $this->_configClass;
    }

    /*

     * 
     * get information about agent seller     */

    public function setAgent()
    {

        global $lang_suffix;
        //agent information
        $this->_db->setQuery('Select * from #__osrs_agents where id = ' . $this->_property->agent_id . '');
        $agent = $this->_db->loadObject();

        //agent country;
        //$db->setQuery("select country_name from #__osrs_countries where id = '$agent->country'");
        $agent->country_name = OSPHelper::getCountryName($agent->country);

        //agent state;
        $this->_db->setQuery('select state_name' . $lang_suffix . ' as state_name from #__osrs_states where id = ' . $agent->state . '');
        $agent->state_name = $this->_db->loadResult();

        $this->_db->setQuery('Select count(id) from #__osrs_properties where published = "1" and approved = "1" and agent_id = ' . $this->_property->agent_id . '');
        $agent->countlisting = $this->_db->loadResult();
        $this->_property->agent = $agent;
    }

    public function setComments()
    {
        $this->_db->setQuery('Select * from #__osrs_comments where pro_id = ' . $this->_property->id . ' and published = "1" order by created_on desc');
        $comments = $this->_db->loadObjectList();
        $this->_property->comments = $comments;
    }

    /*
     * naxodit sosednie rezultati esli zashli cherez poisk
     */

    public function getNearlyInSeach()
    {
        global $lang_suffix;
        //it in search result
        $session = JFactory::getSession();
        $advsearchresult = $session->get('advsearchresult', array());

        if (count($advsearchresult) > 0)
        {
            $this->_property->pagination = 1;
            $key = array_search($id, $advsearchresult);
            //echo $key;
            //echo $id;
            if ($key == 0)
            {
                $prev = $advsearchresult[count($advsearchresult) - 1];
                $next = $advsearchresult[1];
            } elseif ($key == count($advsearchresult) - 1)
            {
                $prev = $advsearchresult[$key - 1];
                $next = $advsearchresult[0];
            } else
            {
                $prev = $advsearchresult[$key - 1];
                $next = $advsearchresult[$key + 1];
            }
            $this->_property->next = $next;
            $this->_property->prev = $prev;
            $itemid = OSPRoute::getPropertyItemid($this->_property->next);
            $this->_property->next_link = JRoute::_('index.php?option=com_osproperty&task=property_details&id=' . $this->_property->next . '&Itemid=' . $itemid);
            $this->_db->setQuery("Select pro_type,pro_name,pro_name" . $lang_suffix . ' from #__osrs_properties where id = ' . $this->_property->next . '');
            $nextObj = $this->_db->loadObject();
            $this->_property->next_property = OSPHelper::getLanguageFieldValue($nextObj, "pro_name");
            $this->_db->setQuery("Select type_name,type_name" . $lang_suffix . ' from #__osrs_types where id = ' . $nextObj->pro_type . '');
            $this->_property->next_type = OSPHelper::getLanguageFieldValue($this->_db->loadObject(), "type_name");

            $itemid = OSPRoute::getPropertyItemid($this->_property->prev);
            $this->_property->prev_link = JRoute::_('index.php?option=com_osproperty&task=property_details&id=' . $this->_property->prev . '&Itemid=' . $itemid);
            $this->_db->setQuery("Select pro_type,pro_name,pro_name" . $lang_suffix . ' from #__osrs_properties where id = ' . $this->_property->prev . '');
            $prevObj = $this->_db->loadObject();
            $this->_property->prev_property = OSPHelper::getLanguageFieldValue($prevObj, "pro_name");
            $this->_db->setQuery("Select type_name,type_name" . $lang_suffix . ' from #__osrs_types where id = ' . $prevObj->pro_type . '');
            $this->_property->prev_type = OSPHelper::getLanguageFieldValue($this->_db->loadObject(), "type_name");
        } else
        {
            $this->_property->pagination = 0;
        }
    }

    public function getRelatedProperties()
    {
        global $lang_suffix;
        $configClass = $this->getConfigClass();

        if ($configClass['relate_properties'] == 1 || true)
        {
            $radius_search = $configClass['relate_distance'];
            if (intval($radius_search) == 0)
            {
                $radius_search = 5;
            }
            $multiFactor = 3959;
            // Search the rows in the table
            $select = sprintf(", ( %s * acos( cos( radians('%s') ) * 
								cos( radians( pr.lat_add ) ) * cos( radians( pr.long_add ) - radians('%s') ) + 
								sin( radians('%s') ) * sin( radians( pr.lat_add ) ) ) ) 
								AS distance", $multiFactor, doubleval($this->_property->lat_add), doubleval($this->_property->long_add), doubleval($this->_property->lat_add)
            );
            $where = sprintf("	HAVING distance < '%s'", doubleval($radius_search));

            $Order_by = " ORDER BY distance ASC, pr.isFeatured desc ";
            $sql = " SELECT pr.* "
                    . "\n, ci.city AS city_name"
                    . "\n, st.state_name"
                    . "\n, co.country_name"
                    .', (select image from #__osrs_photos as ph where ph.pro_id = pr.id order by ordering  limit 1) as photo'
                    . ' , ty.type_name' . $lang_suffix . ' , ty.id as type_id'
                    . $select
                    . "\n FROM #__osrs_properties pr"
                    . "\n LEFT JOIN #__osrs_cities AS ci ON ci.id = pr.city "
                    . "\n LEFT JOIN #__osrs_states AS st ON st.id = pr.state"
                    . "\n LEFT JOIN #__osrs_countries AS co ON co.id = pr.country"
                    . "\n INNER JOIN #__osrs_types AS ty ON ty.id = pr.pro_type"
                    . "\n WHERE 	pr.approved  = '1' and pr.published = '1'"
                    . "\n AND pr.access IN (" . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ")"
                    . ' AND	pr.id 	   	<> ' . $this->_property->id . ' AND 	pr.state 	 = ' . $this->_property->state . ' ';


            //if($configClass['relate_property_type'] == 1){
            //$sql .= "\n AND 	pr.pro_type  = '$property->pro_type'";
            //}
            if ($configClass['relate_city'] == 1)
            {
                $sql .= ' AND 	pr.city		 = ' . $this->_property->city . '';
            }
            if ($configClass['relate_category'] == 1)
            {
                //$sql .= "\n AND 	pr.category_id		 = '$property->category_id'";
            }
            $sql .= $where . $Order_by;
            if ($configClass['max_relate'] > 0)
            {
                $sql .= " LIMIT " . $configClass['max_relate'];
            }
            $this->_db->setQuery($sql);
            $relates = $this->_db->loadObjectList();
            if (count($relates))
            {
                for ($i = 0; $i < count($relates); $i++)
                {//for
                    $relate = $relates[$i];
                    $type_name = OSPHelper::getLanguageFieldValue($relate, 'type_name');
                    $relate->type_name = $type_name;
//                    $this->_db->setQuery('select image from #__osrs_photos where pro_id = ' . $relate->id . ' order by ordering');
//                    $relate->photo = $this->_db->loadResult();
                    if ($relate->photo == '')
                    {
                        $relate->photo = JURI::root() . "components/com_osproperty/images/assets/nopropertyphoto.png";
                    } else
                    {
                        if (file_exists(JPATH_ROOT . '/images/osproperty/properties/' . $relate->id . '/thumb/' . $relate->photo))
                        {
                            $relate->photo = JURI::root() . "images/osproperty/properties/" . $relate->id . "/thumb/" . $relate->photo;
                        } else
                        {
                            $relate->photo = JURI::root() . "components/com_osproperty/images/assets/nopropertyphoto.png";
                        }
                    }

                    if ($configClass['load_lazy'])
                    {
                        $relate->photosrc = JUri::root() . "components/com_osproperty/images/assets/loader.gif";
                    } else
                    {
                        $relate->photosrc = $relate->photo;
                    }

                    $needs = array();
                    $needs[] = "property_details";
                    $needs[] = $relate->id;
                    $item_id = OSPRoute::getItemid($needs);
                    $relate->itemid = $item_id;
                }//for


                $this->_property->relate_properties = $relates;
            }// if count($relate) > 0
        }
    }

    public function getRelatedPropertyTypes()
    {
        global $lang_suffix;
        $configClass = $this->getConfigClass();


        if (true || $configClass['relate_property_type'] == 1)
        {
            // Search the rows in the table
            $Order_by = " ORDER BY pr.isFeatured desc ";
            $sql = " SELECT pr.* "
                    . "\n, ci.city AS city_name"
                    . "\n, st.state_name"
                    . "\n, co.country_name"
                    .', (select image from #__osrs_photos as ph where ph.pro_id = pr.id order by ordering limit 1) as photo'
                    . ' , ty.type_name' . $lang_suffix . ', ty.id as type_id'
                    . "\n FROM #__osrs_properties pr"
                    . "\n LEFT JOIN #__osrs_cities AS ci ON ci.id = pr.city "
                    . "\n LEFT JOIN #__osrs_states AS st ON st.id = pr.state"
                    . "\n LEFT JOIN #__osrs_countries AS co ON co.id = pr.country"
                    . "\n INNER JOIN #__osrs_types AS ty ON ty.id = pr.pro_type"
                    . "\n WHERE 	pr.approved  = '1' and pr.published = '1'"
                    . ' AND pr.id <> ' . $this->_property->id . ' '
                    . "\n AND pr.access IN (" . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ")";
            if ($configClass['relate_property_type'] == 1)
            {
                $sql .= ' AND 	pr.pro_type  = ' . $this->_property->pro_type . '';
            }
            $sql .= $Order_by;
            if ($configClass['max_relate'] > 0)
            {
                $sql .= " LIMIT " . $configClass['max_relate'];
            }
            $this->_db->setQuery($sql);
            //secho $db->getQuery();
            $relates = $this->_db->loadObjectList();

            if (count($relates))
            {
                for ($i = 0; $i < count($relates); $i++)
                {//for
                    $relate = $relates[$i];
                    $type_name = OSPHelper::getLanguageFieldValue($relate, 'type_name');
                    $relate->type_name = $type_name;
//                    $this->_db->setQuery('select image from #__osrs_photos where pro_id = ' . $relate->id . ' order by ordering');
//                    $relate->photo = $this->_db->loadResult();
                    if ($relate->photo == '')
                    {
                        $relate->photo = JURI::root() . "components/com_osproperty/images/assets/nopropertyphoto.png";
                    } else
                    {
                        if (file_exists(JPATH_ROOT . '/images/osproperty/properties/' . $relate->id . '/thumb/' . $relate->photo))
                        {
                            $relate->photo = JURI::root() . "images/osproperty/properties/" . $relate->id . "/thumb/" . $relate->photo;
                        } else
                        {
                            $relate->photo = JURI::root() . "components/com_osproperty/images/assets/nopropertyphoto.png";
                        }
                    }

                    if ($configClass['load_lazy'])
                    {
                        $relate->photosrc = JUri::root() . "components/com_osproperty/images/assets/loader.gif";
                    } else
                    {
                        $relate->photosrc = $relate->photo;
                    }

                    $needs = array();
                    $needs[] = "property_details";
                    $needs[] = $relate->id;
                    $item_id = OSPRoute::getItemid($needs);
                    $relate->itemid = $item_id;
                }//for
                $this->_property->relate_type_properties = $relates;
            }// if count($relate) > 0
        }
    }

}
