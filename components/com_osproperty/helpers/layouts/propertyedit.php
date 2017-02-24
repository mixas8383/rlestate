<form method="POST" action="<?php echo JRoute::_('index.php?option=com_osproperty&Itemid=' . $itemid) ?>" name="ftForm1" id="ftForm1" enctype="multipart/form-data" class="form-horizontal">
    <input type="hidden" name="live_site" id="live_site" value="<?php echo JURI::root() ?>" />
    <?php
    $require_field = "";
    $require_label = "";
    $db = JFactory::getDbo();
    JHTML::_('behavior.modal', 'a.osmodal');
    if (JFactory::getUser()->authorise('frontendmanage', 'com_osproperty'))
    {
        $tab1 = "active";
        $tab2 = "";
    } else
    {
        if ($extend == 1)
        {
            $tab2 = "active";
            $tab1 = "";
        } else
        {
            $tab1 = "active";
            $tab2 = "";
        }
    }
    ?>
    <link rel="stylesheet" href="<?php echo JURI::root() ?>components/com_osproperty/js/tag/css/textext.core.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo JURI::root() ?>components/com_osproperty/js/tag/css/textext.plugin.tags.css" type="text/css" />
    <script src="<?php echo JURI::root() ?>components/com_osproperty/js/tag/js/textext.core.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo JURI::root() ?>components/com_osproperty/js/tag/js/textext.plugin.tags.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo JURI::root() ?>components/com_osproperty/js/paymentmethods.js" type="text/javascript"></script>
    <div class="row-fluid">
        <div class="span12">
            <div class="componentheading">
                <?php
                echo JText::_('OS_PROPERTY') . " <small>[" . $edit . "]</small>";
                ?>
            </div>
            <div class="clearfix"></div>
            <div class="btn-toolbar">
                <div class="btn-group pull-right">
                    <button type="button" class="btn hasTooltip btn-success" title="<?php echo JText::_('OS_SAVE'); ?>" onclick="javascript:submitftForm(1);">
                        <i class="osicon-save"></i> <?php echo JText::_('OS_SAVE'); ?>
                    </button>
                    <?php if (($configClass['active_payment'] == 0) or ( $extend == 0) or ( JFactory::getUser()->authorise('frontendmanage', 'com_osproperty')))
                    {
                        ?>
                        <button type="button" class="btn hasTooltip btn-info" title="<?php echo JText::_('OS_APPLY'); ?>" onclick="javascript:submitftForm(0);">
                            <i class="osicon-apply"></i> <?php echo JText::_('OS_APPLY'); ?>
                        </button>
<?php } ?>
                    <button type="button" class="btn hasTooltip btn-warning" title="<?php echo JText::_('OS_CANCEL'); ?>" onclick="javascript:gotoDefaultPage();">
                        <i class="osicon-unpublish"></i> <?php echo JText::_('OS_CANCEL'); ?>
                    </button>
                </div>
            </div>
            <div class="clearfix"></div>

            <?php
            if ($configClass['integrate_membership'] == 1)
            {//use membership integration
                $agentAcc = $lists['agentAcc'];
                ?>
                <div class="span12" style="margin-left:0px !important;">
                    <?php
                    HelperOspropertyCommon::generateMembershipForm($agentAcc, 'property', $row->id);
                    ?>
                </div>
                <div class="clearfix"></div>
                <?php
            }
            ?>
            <!-- General tab-->
            <!-- OS_ADDRESS panel2-->
            <!-- OS_GENERAL_INFORMATION panel1-->
            <!-- OS_OTHER_INFORMATION panel7-->
            <!-- OS_PHOTOS panel3-->
            <div class="row-fluid">
                <?php
                if ($translatable)
                {
                    ?>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#general-page" data-toggle="tab"><?php echo JText::_('OS_GENERAL'); ?></a></li>
                        <li><a href="#translation-page" data-toggle="tab"><?php echo JText::_('OS_TRANSLATION'); ?></a></li>									
                    </ul>		
                    <div class="tab-content" style="margin-top:10px;">
                        <div class="tab-pane active" id="general-page" >			
                            <?php
                        }
                        ?>
                        <ul class="nav nav-tabs">
                            <li class="<?php echo $tab1; ?>"><a href="#addpropertypanel1" data-toggle="tab"><?php echo Jtext::_('OS_ADDRESS'); ?></a></li>
                            <li><a href="#addpropertypanel2" data-toggle="tab"><?php echo Jtext::_('OS_GENERAL_INFORMATION'); ?></a></li>
                            <li><a href="#addpropertypanel0" data-toggle="tab"><?php echo Jtext::_('OS_TYPE'); ?> & <?php echo Jtext::_('OS_EXTRA_FIELDS'); ?></a></li>
                            <li><a href="#addpropertypanel3" data-toggle="tab"><?php echo Jtext::_('OS_OTHER_INFORMATION'); ?></a></li>
                            <?php if ($configClass['use_property_history'] == 1)
                            {
                                ?>
                                <li><a href="#addpropertypanel5" data-toggle="tab"><?php echo Jtext::_('OS_HISTORY_TAX'); ?></a></li>
                            <?php } ?>
                            <li><a href="#addpropertypanel4" data-toggle="tab"><?php echo Jtext::_('OS_PHOTOS'); ?></a></li>
                            <?php
                            $show_payment_tab = 0;
                            if (JFactory::getUser()->authorise('frontendmanage', 'com_osproperty'))
                            {
                                $show_payment_tab = 0;
                            } else
                            {
                                if (($isNew == 0) and ( $extend == 1))
                                {
                                    $show_payment_tab = 1;
                                } elseif ($isNew == 1)
                                {
                                    $show_payment_tab = 1;
                                }
                            }
                            if (($configClass['active_payment'] == 1) and ( $configClass['integrate_membership'] == 0) and ( $show_payment_tab == 1))
                            {
                                ?>
                                <li class="<?php echo $tab2; ?>"><a href="#addpropertypanel6" data-toggle="tab"><?php echo Jtext::_('OS_LIVE_TIME'); ?> & <?php echo Jtext::_('OS_PAYMENT'); ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <div class="tab-content">	
                            <div class="tab-pane <?php echo $tab1; ?>" id="addpropertypanel1">
                                <!-- End General tab-->
                                <div class="col width-100">
                                    <fieldset class="fieldsetpropertydetails"> 
                                        <legend><strong><?php echo JText::_('OS_ADDRESS'); ?></strong></legend>
                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_ADDRESS'); ?>::<?php echo JText::_('OS_ADDRESS_EXPLAIN'); ?>">
<?php echo JText::_('OS_ADDRESS'); ?> *
                                                </span>
                                            </label>
                                            <div class="controls">
                                                <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($row->address); ?>" size="50" class="input-large" placeholder="<?php echo JText::_('OS_ADDRESS'); ?>" />
                                                <?php
                                                $require_field .= "address,";
                                                $require_label .= JText::_('OS_ADDRESS') . ",";
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_POSTCODE'); ?>">
                                                    <?php echo JText::_('OS_POSTCODE'); ?> 
                                                    <?php
                                                    if ($configClass['require_postcode'] == 1)
                                                    {
                                                        echo "*";
                                                    }
                                                    ?>
                                                </span>
                                            </label>
                                            <div class="controls">
                                                <input type="text" name="postcode" id="postcode" value="<?php echo htmlspecialchars($row->postcode); ?>" class="input-small" placeholder="<?php echo JText::_('OS_POSTCODE'); ?>" />
                                                <?php
                                                if ($configClass['require_postcode'] == 1)
                                                {
                                                    $require_field .= "postcode,";
                                                    $require_label .= JText::_('OS_POSTCODE') . ",";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        if (HelperOspropertyCommon::checkCountry())
                                        {
                                            ?>
                                            <div class="control-group">
                                                <label class="control-label">
                                                    <span class="hasTip" title="<?php echo JText::_('OS_COUNTRY'); ?>::<?php echo JText::_('OS_COUNTRY_EXPLAIN'); ?>">
    <?php echo JText::_('OS_COUNTRY'); ?> *
                                                    </span>
                                                </label>
                                                <div class="controls">
                                                    <?php
                                                    echo $lists['country'];
                                                    ?>
                                                    <?php
                                                    $require_field .= "country,";
                                                    $require_label .= JText::_('OS_COUNTRY') . ",";
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        } else
                                        {
                                            echo $lists['country'];
                                        }
                                        if (OSPHelper::userOneState())
                                        {
                                            echo $lists['state'];
                                        } else
                                        {
                                            ?>
                                            <div class="control-group">
                                                <label class="control-label">
                                                    <span class="hasTip" title="<?php echo JText::_('OS_STATE'); ?>::<?php echo JText::_('OS_STATE_EXPLAIN'); ?>">
    <?php echo JText::_('OS_STATE'); ?> *
                                                    </span>
                                                </label>
                                                <div class="controls">
                                                    <div id="country_state">
                                                        <?php
                                                        echo $lists['state'];
                                                        $configClass['require_state'] = 1;
                                                        if ($configClass['require_state'] == 1)
                                                        {
                                                            $require_field .= "state,";
                                                            $require_label .= JText::_('OS_STATE') . ",";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
<?php } ?>
                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_CITY'); ?>::<?php echo JText::_('OS_CITY_EXPLAIN'); ?>">
<?php echo JText::_('OS_CITY'); ?> *
                                                </span>
                                            </label>
                                            <div class="controls">
                                                <div id="city_div">
                                                    <?php
                                                    echo $lists['city'];
                                                    ?>
                                                </div>
                                                <?php
                                                if ($configClass['require_city'] == 1)
                                                {
                                                    ?>
                                                    <?php
                                                    $require_field .= "city,";
                                                    $require_label .= JText::_('OS_CITY') . ",";
                                                }
                                                ?>
                                            </div>
                                        </div>	
                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_REGION'); ?>">
<?php echo JText::_('OS_REGION'); ?>
                                                </span>
                                            </label>
                                            <div class="controls">
                                                <input  type="text" name="region" id="region" value="<?php echo htmlspecialchars($row->region); ?>" class="input-large" placeholder="<?php echo JText::_('OS_REGION'); ?>" />

                                            </div>
                                        </div>	
                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_SHOW_ADDRESS'); ?>::<?php echo JText::_('OS_SHOW_ADDRESS_EXPLAIN'); ?>">
<?php echo JText::_('OS_SHOW_ADDRESS'); ?>
                                                </span>
                                            </label>
                                            <div class="controls">
                                                <?php
                                                echo $lists['show_address'];
                                                ?>
                                            </div>
                                        </div>	
                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_LATTITUDE_EXPLAIN'); ?>">
<?php echo JText::_('OS_LATTITUDE'); ?>
                                                </span>
                                            </label>
                                            <div class="controls">

                                                <input class="input-medium" type="text" name="lat_add" id="lat_add" value="<?php echo htmlspecialchars($row->lat_add); ?>" size="30" placeholder="<?php echo JText::_('OS_LATTITUDE'); ?>" />
                                            </div>
                                        </div>	
                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_LONGTITUDE_EXPLAIN'); ?>">
<?php echo JText::_('OS_LONGTITUDE'); ?>
                                                </span>
                                            </label>
                                            <div class="controls">
                                                <input class="input-medium" type="text" name="long_add" id="long_add" value="<?php echo htmlspecialchars($row->long_add); ?>" size="30" placeholder="<?php echo JText::_('OS_LONGTITUDE'); ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">
                                                <?php echo JText::_('OS_GRAD_AND_DROP_THE_MAP_FOR_COORDINATES'); ?>
                                            </label>
                                            <div class="controls">
                                                <?php
                                                if (($row->lat_add == "")or ( intval($row->id) == 0))
                                                {
                                                    $row->lat_add = $configClass['goole_default_lat'];
                                                }
                                                if (($row->long_add == "")or ( intval($row->id) == 0))
                                                {
                                                    $row->long_add = $configClass['goole_default_long'];
                                                }
                                                $geocode = array();
                                                $geocode[0]->lat = $row->lat_add;
                                                $geocode[0]->long = $row->long_add;
                                                HelperOspropertyGoogleMap::loadGMapinEditProperty($geocode, "map", "lat_add", "long_add");
                                                ?>

                                                <div id="map" style="width:100%; height: <?php echo $configClass['property_map_height'] ?>px;border:1px solid #CCC;"></div>	
                                                <BR />
                                                <div>
                                                    <strong><?php echo JText::_('OS_ENTER_ADDRESS_TO_CHECK_LATTITUDE_AND_LONGTITUDE') ?></strong>
                                                    <BR />
                                                    <input type="text" name="add" id="add" value="" size="20" class="inputbox"><input type="button" class="btn" value="<?php echo JText::_("OS_SEARCH") ?>" onclick="javascript:showAddress(document.ftForm1.add.value);" />
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                </div>	
                                <!-- End Address -->
                            </div>
                            <?php
                            //echo $panetab->startPanel(JText::_( 'OS_GENERAL_INFORMATION' ), 'panel1');
                            ?>
                            <div class="tab-pane" id="addpropertypanel2">
                                <div class="col width-100">
                                    <fieldset class="fieldsetpropertydetails">
                                        <legend><strong><?php echo JText::_('OS_GENERAL_INFORMATION'); ?></strong></legend>
                                        <?php
                                        if ($configClass['ref_field'] == 0)
                                        {
                                            ?>
                                            <div class="control-group">
                                                <label class="control-label">
                                                    <span class="hasTip" title="<?php echo JText::_('Ref #'); ?>">
    <?php echo JText::_('Ref #'); ?>
                                                    </span>
                                                </label>
                                                <div class="controls">
                                                    <input class="input-small" type="text" name="ref" id="ref" value="<?php echo htmlspecialchars($row->ref); ?>" placeholder="<?php echo JText::_('Ref #'); ?>" />
                                                </div>
                                            </div>
<?php } ?>
                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_PROPERTY_TITLE'); ?>::<?php echo JText::_('OS_PROPERTY_TITLE_EXPLAIN'); ?>">
<?php echo JText::_('OS_PROPERTY_TITLE') ?> *
                                                </span>
                                            </label>
                                            <div class="controls">
                                                <input placeholder="<?php echo JText::_('OS_PROPERTY_TITLE'); ?>" class="input-large" type="text" name="pro_name" id="pro_name" value="<?php echo htmlspecialchars($row->pro_name); ?>" />
                                                <input type="hidden" name="pro_alias" id="pro_alias" value="<?php echo htmlspecialchars($row->pro_alias); ?>" />
                                            </div>
                                        </div>
                                        <?php
                                        //$require_field = "";
                                        $require_field .= "pro_name,";
                                        //$require_label = "";
                                        $require_label .= JText::_('OS_PROPERTY_TITLE') . ",";

                                        if (HelperOspropertyCommon::isCompanyAdmin())
                                        {
                                            ?>
                                            <div class="control-group">
                                                <label class="control-label">
                                                    <span class="hasTip" title="<?php echo JText::_('OS_SELECT_AGENT'); ?>">
    <?php echo JText::_('OS_SELECT_AGENT') ?> *
                                                    </span>
                                                </label>
                                                <div class="controls">
                                                    <?php
                                                    echo $lists['agent'];
                                                    if ($lists['agentname'] != "")
                                                    {
                                                        echo $lists['agentname'];
                                                    }
                                                    $require_field .= "agent_id,";
                                                    $require_label .= JText::_('OS_AGENT') . ",";
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        if (JFactory::getUser()->authorise('frontendmanage', 'com_osproperty'))
                                        {
                                            if ((HelperOspropertyCommon::isRegisteredAgent()) and ( $row->id == 0))
                                            {
                                                $agent_id = HelperOspropertyCommon::getAgentID();
                                            } else
                                            {
                                                $agent_id = $row->agent_id;
                                            }
                                            ?>
                                            <input type="hidden" id="agent_id" name="agent_id" value="<?php echo $agent_id; ?>" />
                                            <?php
                                        }

                                        $require_field .= "category_id,";
                                        $require_label .= JText::_('OS_CATEGORY') . ",";
                                        ?>
                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_CATEGORY'); ?>::<?php echo JText::_('OS_CATEGORY_EXPLAIN'); ?>">
<?php echo JText::_('OS_CATEGORY') ?> *
                                                </span>
                                            </label>
                                            <div class="controls">
<?php echo $lists['category']; ?>
                                            </div>
                                        </div>

                                        <?php
                                        if ($row->id == 0)
                                        {
                                            $row->access = $configClass['default_access_level'];
                                        }
                                        ?>
                                        <input type="hidden" name="access" id="access" value="<?php echo $row->access; ?>" />

                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_PRICE_INFO'); ?>">
<?php echo JText::_("OS_PRICE_INFO") ?>
                                                </span>
                                            </label>
                                            <div class="controls">
                                                <div class="control-group">
                                                    <label class="control-label"><?php echo JText::_("OS_CALL_FOR_PRICE") ?></label>
                                                    <div class="controls">
                                                        <?php
                                                        echo $lists['price_call'];
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <?php
                                                if ($row->price_call == 0)
                                                {
                                                    $display = "block";
                                                } else
                                                {
                                                    $display = "none";
                                                }
                                                ?>
                                                <div id="pricediv" style="display:<?php echo $display; ?>;">
                                                    <div class="control-group">
                                                        <label class="control-label">
<?php echo JText::_("OS_PRICE") ?>
                                                        </label>
                                                        <div class="controls">
                                                            <input type="text" name="price" id="price" value="<?php echo $row->price ?>" class="input-small" style="display:inline !important;" placeholder="0.00" />
                                                            <?php
                                                            HelperOspropertyCommon::showCurrencySelectList($row->curr);
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_PRICE_FOR'); ?>">
<?php echo JText::_('OS_PRICE_FOR') ?>
                                                </span>
                                            </label>
                                            <div class="controls">
<?php echo $lists['time']; ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">
<?php echo JText::_('OS_SMALL_DESCRIPTION') ?> *
                                            </label>
                                            <div class="controls">
                                                <textarea style="min-height:150px;" name="pro_small_desc" id="pro_small_desc" cols="50" rows="5" class="inputbox"><?php echo $row->pro_small_desc ?></textarea>
                                                <?php
                                                $require_field .= "pro_small_desc,";
                                                $require_label .= JText::_('OS_SMALL_DESCRIPTION') . ",";
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        $editor = &JFactory::getEditor();
                                        ?>
                                        <div class="control-group">
                                            <label class="control-label">
                                                <?php echo JText::_('OS_FULL_DESCRIPTION') ?>
                                            </label>
                                            <div class="controls">
                                                <?php
                                                echo $editor->display('pro_full_desc', stripslashes($row->pro_full_desc), '95%', '250', '75', '20', false);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">
<?php echo JText::_('OS_AGENT_NOTE') ?>
                                            </label>
                                            <div class="controls">
                                                <textarea style="min-height:100px;width:300px !important;" class="input-large" name="note" id="note" cols="50" rows="5"><?php echo stripslashes($row->note); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">
<?php echo JText::_('OS_TAGS') ?>
                                            </label>
                                            <div class="controls">
                                                <table  width="100%" class="admintable">
                                                    <tr>
                                                        <td>
                                                            <table width="100%" id="property_tag_table">
                                                                <tr>
                                                                    <th>
                                                                    <?php echo JText::_('OS_KEYWORD') ?>
                                                                    </th>
                                                                    <?php
                                                                    if ($translatable)
                                                                    {
                                                                        foreach ($languages as $language)
                                                                        {
                                                                            $sef = $language->sef;
                                                                            ?>
                                                                            <th>
                                                                            <?php echo JText::_('OS_KEYWORD') ?>
                                                                                <img src="<?php echo JURI::root(); ?>media/com_osproperty/flags/<?php echo $sef . '.png'; ?>" />
                                                                            </th>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <th>
                                                                        &nbsp;
                                                                    </th>
                                                                </tr>
                                                                <?php
                                                                if (count($lists['tags']) > 0)
                                                                {
                                                                    foreach ($lists['tags'] as $tag)
                                                                    {
                                                                        ?>
                                                                        <tr id="tag_table_tr">
                                                                            <td>
                                                                                <input type="text" name="keyword[]" value="<?php echo $tag->keyword ?>" class="input-small" />
                                                                            </td>
                                                                            <?php
                                                                            if ($translatable)
                                                                            {
                                                                                foreach ($languages as $language)
                                                                                {
                                                                                    $sef = $language->sef;
                                                                                    ?>
                                                                                    <td>
                                                                                        <input type="text" name="keyword_<?php echo $sef; ?>[]" value="<?php echo $tag->{'keyword_' . $sef} ?>" class="input-small" />
                                                                                    </td>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <td>
                                                                                <input type="button" class="btn removetag" value="<?php echo JText::_('OS_DELETE'); ?>" />
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <tr id="tag_table_tr">
                                                                    <td>
                                                                        <input type="text" name="keyword[]" value="" class="input-small" />
                                                                    </td>
                                                                    <?php
                                                                    if ($translatable)
                                                                    {
                                                                        foreach ($languages as $language)
                                                                        {
                                                                            $sef = $language->sef;
                                                                            ?>
                                                                            <td>
                                                                                <input type="text" name="keyword_<?php echo $sef; ?>[]" value="" class="input-small" />
                                                                            </td>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <td>
                                                                        <input type="button" class="btn addtag" value="<?php echo JText::_('OS_ADD'); ?>" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <script type="text/javascript">
                                                    jQuery(document).ready(function () {
                                                        jQuery('.removetag').live('click', function () {
                                                            jQuery(this).parent().parent().remove();
                                                        });

                                                        jQuery('.addtag').live('click', function () {
                                                            jQuery(this).val('<?php echo JText::_('OS_DELETE'); ?>');
                                                            jQuery(this).attr('class', 'btn removetag');
<?php
$value = '<tr id="tag_table_tr"><td><input type="text" name="keyword[]" value="" class="input-small" /></td>';
if ($translatable)
{
    foreach ($languages as $language)
    {
        $sef = $language->sef;
        $value .= '<td><input type="text" name="keyword_' . $sef . '[]" value="" class="input-small" /></td>';
    }
}
$value .= '<td><input type="button" class="btn addtag" value="' . JText::_('OS_ADD') . '" /></td></tr>';
?>
                                                            var appendTxt = '<?php echo $value; ?>';
                                                            jQuery("#property_tag_table>tbody>tr:last").after(appendTxt);
                                                        });
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <?php
                                            echo JHtml::_('sliders.start', 'menu-pane3');
                                            echo JHtml::_('sliders.panel', JText::_('OS_BASE_PROPERTY_FIELDS'), 'base_fields');
                                            ?>
                                            <table  width="100%" class="admintable">
                                                <?php
                                                if ($configClass['use_rooms'] == 1)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td class="key">
                                                            # <?php echo JText::_('OS_NUMBER_ROOMS') ?>
                                                        </td>
                                                        <td width="80%">
                                                    <?php echo $lists['nrooms']; ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if ($configClass['use_bathrooms'] == 1)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td class="key">
                                                            # <?php echo JText::_('OS_NUMBER_BATHROOMS') ?>
                                                        </td>
                                                        <td>
                                                    <?php echo $lists['nbath']; ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if ($configClass['use_bedrooms'] == 1)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td class="key">
                                                            # <?php echo JText::_('OS_NUMBER_BEDROOMS') ?>
                                                        </td>
                                                        <td>
                                                    <?php echo $lists['nbed']; ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td class="key" style="height:200px; vertical-align:top;padding-top:10px;">
<?php echo JText::_('OS_LIVING_AREAS') ?>
                                                    </td>
                                                    <td style="vertical-align:top;padding-top:5px;">
                                                        <input type="text" name="living_areas" id="living_areas" class="input-large" value="<?php echo $row->living_areas; ?>" />
                                                    </td>
                                                </tr>
                                            </table>

                                            <?php
                                            if ($configClass['use_parking'] == 1)
                                            {
                                                echo JHtml::_('sliders.panel', JText::_('OS_PARKING'), 'parking_fields');
                                                ?>
                                                <table  width="100%" class="admintable">
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_GARAGE_DESCRIPTION') ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="garage_description" id="garage_description" size="20" class="input-large" value="<?php echo $row->garage_description; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            # <?php echo JText::_('OS_PARKING') ?>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="parking" id="parking" size="20" class="input-small" value="<?php echo $row->parking; ?>" />
                                                        </td>
                                                    </tr>
                                                </table>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($configClass['use_nfloors'] == 1)
                                            {
                                                echo JHtml::_('sliders.panel', JText::_('OS_BUILDING_INFORMATION'), 'building_info');
                                                ?>
                                                <table  width="100%" class="admintable">
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_YEAR_BUILT') ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="built_on" id="built_on" size="20" class="input-small" value="<?php echo $row->built_on; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_YEAR_REMODELED') ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="remodeled_on" id="remodeled_on" size="20" class="input-small" value="<?php echo $row->remodeled_on; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_HOUSE_STYLE') ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="house_style" id="house_style" size="20" class="input-large" value="<?php echo $row->house_style; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_HOUSE_CONSTRUCTION') ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="house_construction" id="house_construction" size="20" class="input-large" value="<?php echo $row->house_construction; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_EXTERIOR_FINISH') ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="exterior_finish" id="exterior_finish" size="20" class="input-large" value="<?php echo $row->exterior_finish; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_ROOF') ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="roof" id="roof" size="20" class="input-large" value="<?php echo $row->roof; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            # <?php echo JText::_('OS_NUMBER_OF_FLOORS') ?>
                                                        </td>
                                                        <td>
    <?php echo $lists['nfloors']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_FLOORING') ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="flooring" id="flooring" size="20" class="input-large" value="<?php echo $row->flooring; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_FLOOR_AREA') ?> <?php echo JText::_('OS_LOWER'); ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="floor_area_lower" id="floor_area_lower" size="20" class="input-large" value="<?php echo $row->floor_area_lower; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_FLOOR_AREA') ?> <?php echo JText::_('OS_MAIN_LEVEL'); ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="floor_area_main_level" id="floor_area_main_level" size="20" class="input-large" value="<?php echo $row->floor_area_main_level; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_FLOOR_AREA') ?> <?php echo JText::_('OS_UPPER'); ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="floor_area_upper" id="floor_area_upper" size="20" class="input-large" value="<?php echo $row->floor_area_upper; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_FLOOR_AREA') ?> <?php echo JText::_('OS_TOTAL'); ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="floor_area_total" id="floor_area_total" size="20" class="input-large" value="<?php echo $row->floor_area_total; ?>" />
                                                        </td>
                                                    </tr>
                                                </table>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($configClass['basement_foundation'] == 1)
                                            {
                                                echo JHtml::_('sliders.panel', JText::_('OS_BASEMENT_FOUNDATION'), 'basement_foundation');
                                                ?>
                                                <table  width="100%" class="admintable">
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_BASEMENT_FOUNDATION') ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="basement_foundation" id="basement_foundation" size="20" class="input-large" value="<?php echo $row->basement_foundation; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            # <?php echo JText::_('OS_BASEMENT_SIZE') ?>(<?php echo OSPHelper::showSquareSymbol(); ?>)
                                                        </td>
                                                        <td>
                                                            <input type="text" name="basement_size" id="basement_size" size="20" class="input-small" value="<?php echo $row->basement_size; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_PERCENT_FINISH') ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="percent_finished" id="percent_finished" size="20" class="input-large" value="<?php echo $row->percent_finished; ?>" />
                                                        </td>
                                                    </tr>
                                                </table>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($configClass['use_squarefeet'] == 1)
                                            {
                                                echo JHtml::_('sliders.panel', JText::_('OS_LAND_INFORMATION'), 'land_info');
                                                ?>
                                                <table  width="100%" class="admintable">
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_SUBDIVISION') ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="subdivision" id="subdivision" size="20" class="input-large" value="<?php echo $row->subdivision; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_LAND_HOLDING_TYPE') ?>
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="land_holding_type" id="land_holding_type" size="20" class="input-large" value="<?php echo $row->land_holding_type; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            # <?php echo OSPHelper::showSquareLabels(); ?>(<?php echo OSPHelper::showSquareSymbol(); ?>)
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="square_feet" id="square_feet" size="10" class="input-small" value="<?php echo $row->square_feet ?>"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            # <?php echo JText::_('OS_LOT_SIZE'); ?>(<?php echo OSPHelper::showSquareSymbol(); ?>)
                                                        </td>
                                                        <td width="80%">
                                                            <input type="text" name="lot_size" id="lot_size" size="10" class="input-small" value="<?php echo $row->lot_size; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            # <?php echo JText::_('OS_TOTAL_ACRES'); ?>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="total_acres" id="total_acres" size="10" class="input-small" value="<?php echo $row->total_acres ?>"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_LOT_DIMENSIONS'); ?>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="lot_dimensions" id="lot_dimensions" size="10" class="input-medium" value="<?php echo $row->lot_dimensions ?>"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_FRONTPAGE'); ?>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="frontpage" id="frontpage" size="10" class="input-medium" value="<?php echo $row->frontpage; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_DEPTH'); ?>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="depth" id="depth" size="10" class="input-medium" value="<?php echo $row->depth; ?>" />
                                                        </td>
                                                    </tr>
                                                </table>
                                                <?php
                                            }

                                            if ($configClass['use_business'] == 1)
                                            {
                                                echo JHtml::_('sliders.panel', JText::_('OS_BUSINESS_INFORMATION'), 'business_info');
                                                ?>
                                                <table  width="100%" class="admintable">
                                                    <?php
                                                    $businessArr = array('takings', 'returns', 'net_profit', 'business_type', 'stock', 'fixtures', 'fittings', 'percent_office', 'percent_warehouse', 'loading_facilities');
                                                    foreach ($businessArr as $business)
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td class="key" >
        <?php echo JText::_("OS_" . strtoupper($business)) ?>
                                                            </td>
                                                            <td width="80%">
                                                                <input type="text" class="input-large" name="<?php echo $business; ?>" id="<?php echo $business; ?>" value="<?php echo $row->{$business}; ?>">
                                                            </td>
                                                        </tr>
                                                <?php } ?>
                                                </table>
                                                <?php
                                            }

                                            if ($configClass['use_rural'] == 1)
                                            {
                                                echo JHtml::_('sliders.panel', JText::_('OS_RURAL_INFORMATION'), 'rural_info');
                                                ?>
                                                <table  width="100%" class="admintable">
                                                    <?php
                                                    $businessArr = array('fencing', 'rainfall', 'soil_type', 'grazing', 'cropping', 'irrigation', 'water_resources', 'carrying_capacity', 'storage');
                                                    foreach ($businessArr as $business)
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td class="key" >
        <?php echo JText::_("OS_" . strtoupper($business)) ?>
                                                            </td>
                                                            <td width="80%">
                                                                <input type="text" class="input-large" name="<?php echo $business; ?>" id="<?php echo $business; ?>" value="<?php echo $row->{$business}; ?>">
                                                            </td>
                                                        </tr>
                                                <?php } ?>
                                                </table>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($configClass['energy'] == 1)
                                            {
                                                echo JHtml::_('sliders.panel', JText::_('OS_ENERGY_AND_CLIMATE'), 'energy_and_climate');
                                                ?>
                                                <table  width="100%" class="admintable">
                                                    <tr>
                                                        <td class="key" >
    <?php echo JText::_('OS_ENERGY') ?>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="input-mini" name="energy" id="energy" size="5" value="<?php echo $row->energy; ?>"> kWH/m
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key" >
    <?php echo JText::_('OS_CLIMATE') ?>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="input-mini" name="climate" id="climate" size="5" value="<?php echo $row->climate; ?>"> kg/m
                                                        </td>
                                                    </tr>
                                                </table>
                                                <?php
                                            }
                                            echo JHtml::_('sliders.end');
                                            ?>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="tab-pane" id="addpropertypanel0">
                                <div class="col width-100">
                                    <fieldset class="fieldsetpropertydetails">
                                        <legend><strong><?php echo Jtext::_('OS_TYPE'); ?> & <?php echo Jtext::_('OS_EXTRA_FIELDS'); ?></strong></legend>
                                        <div class="control-group">
                                            <?php
                                            $require_field .= "pro_type,";
                                            $require_label .= JText::_('OS_PROPERTY_TYPE') . ",";
                                            ?>
                                            <div class="control-group">
                                                <label class="control-label">
                                                    <span class="hasTip" title="<?php echo JText::_('OS_PROPERTY_TYPE'); ?>::<?php echo JText::_('OS_PROPERTY_TYPE'); ?>">
<?php echo JText::_('OS_PROPERTY_TYPE') ?> *
                                                    </span>
                                                </label>
                                                <div class="controls">
<?php echo $lists['type']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $sold_property_types = explode("|", $configClass['sold_property_types']);
                                        if (($configClass['use_sold'] == 1) and ( $configClass['sold_property_types'] != ""))
                                        {

                                            if (in_array($row->pro_type, $sold_property_types))
                                            {
                                                $display = "block";
                                            } else
                                            {
                                                $display = "none";
                                            }
                                            ?>
                                            <div class="control-group" style="display:<?php echo $display; ?>;" id="sold_information">
                                                <label class="control-label">
                                                    <?php echo JText::_("OS_SOLD_STATUS") ?>
                                                </label>
                                                <div class="controls">
                                                    <?php echo $lists['property_sold']; ?>
                                                    &nbsp;
    <?php echo JText::_('OS_SOLD_ON') ?>											
                                            <?php echo JHTML::calendar($row->soldOn, 'soldOn', 'soldOn', "%Y-%m-%d"); ?>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php
                                        $fieldLists = array();
                                        if (count($groups) > 0)
                                        {
                                            if ($row->id > 0)
                                            {
                                                $cssclass = "display:block;";
                                            } else
                                            {
                                                $cssclass = "display:none;";
                                            }
                                            ?>
                                            <div class="row-fluid" id="fieldgroups_div" style="<?php echo $cssclass; ?>">
                                                <div class="span12">
                                                    <?php
                                                    $translatable = JLanguageMultilang::isEnabled() && count($languages);
                                                    if ($translatable)
                                                    {
                                                        $lang_suffix = OSPHelper::getFieldSuffix();
                                                    }
                                                    for ($i = 0; $i < count($groups); $i++)
                                                    {
                                                        $group = $groups[$i];
                                                        $fields = $group->fields;
                                                        echo "<strong><h4>" . OSPHelper::getLanguageFieldValue($group, 'group_name') . "</h4></strong>";
                                                        ?>
                                                        <div class="clearfix"></div>
                                                        <?php
                                                        for ($j = 0; $j < count($fields); $j++)
                                                        {
                                                            $field = $fields[$j];
                                                            $fieldLists[] = $field->id;
                                                            if ($field->required == 1)
                                                            {
                                                                //$require_field .= $field->field_name.",";
                                                                //$require_label .= $field->{'field_label'.$lang_suffix}.",";
                                                            }
                                                            if (intval($row->id) == 0)
                                                            {
                                                                $display = "display:none;";
                                                            } else
                                                            {
                                                                $db->setQuery("Select count(fid) from #__osrs_extra_field_types where type_id = '$row->pro_type' and fid = '$field->id'");
                                                                $count = $db->loadResult();
                                                                if ($count > 0)
                                                                {
                                                                    $display = "";
                                                                } else
                                                                {
                                                                    $display = "display:none;";
                                                                }
                                                            }
                                                            ?>
                                                            <div class="row-fluid">
                                                                <div class="span12" id="extrafield_<?php echo $field->id ?>" style="<?php echo $display; ?>">
                                                                    <div class="control-group">
                                                                        <label class="control-label">
                                                                            <span class="hasTip" title="<?php echo $field->field_label ?>::<?php echo $field->field_description ?>">
            <?php echo $field->{'field_label' . $lang_suffix} ?>
                                                                            </span>
                                                                        </label>
                                                                        <div class="controls">
                                                                            <?php
                                                                            HelperOspropertyFields::showField($field, $row->id);
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="tab-pane" id="addpropertypanel3">	
                                <div class="col width-100">
                                    <fieldset id="otherinformation" class="fieldsetpropertydetails">
                                        <legend><strong><?php echo JText::_('OS_OTHER_INFORMATION'); ?></strong></legend>
                                        <?php
                                        echo JHtml::_('sliders.start', 'menu-pane2');
                                        if ($configClass['use_open_house'] == 1)
                                        {

                                            echo JHtml::_('sliders.panel', JText::_('OS_PROPERTY_OPEN_HOUSE'), 'setup');
                                            ?>
                                            <table  width="100%" class="admintable">
                                                <tr>
                                                    <td>
                                                        <table width="100%" id="property_open_table">
                                                            <tr>
                                                                <th>
                                                                    <?php echo JText::_('OS_FROM') ?>
                                                                </th>
                                                                <th>
                                                            <?php echo JText::_('OS_TO') ?>
                                                                </th>
                                                            </tr>
                                                            <?php
                                                            $j = 0;
                                                            if (count($lists['open']) > 0)
                                                            {
                                                                foreach ($lists['open'] as $cal)
                                                                {
                                                                    $j++;
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo JHTML::calendar($cal->start_from, 'start_from[]', 'start_from' . $j, "%Y-%m-%d %H:%M:%S"); ?>
                                                                        </td>
                                                                        <td>
                                                                    <?php echo JHTML::calendar($cal->end_to, 'end_to[]', 'end_to' . $j, "%Y-%m-%d %H:%M:%S"); ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            if ($j < 5)
                                                            {
                                                                for ($i = $j + 1; $i <= 5; $i++)
                                                                {
                                                                    ?>
                                                                    <tr id="history_table_tr">
                                                                        <td>
                                                                            <?php echo JHTML::calendar('', 'start_from[]', 'start_from' . $i, "%Y-%m-%d %H:%M:%S"); ?>
                                                                        </td>
                                                                        <td>
                                                                    <?php echo JHTML::calendar('', 'end_to[]', 'end_to' . $i, "%Y-%m-%d %H:%M:%S"); ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        <?php } ?>
                                        <?php
                                        echo JHtml::_('sliders.panel', JText::_('OS_OTHER_INFORMATION'), 'setup');
                                        ?>
<?php if ($configClass['show_metatag'] == 1)
{
    ?>

                                            <div class="control-group">
                                                <label class="control-label">
                                                    <span class="hasTip" title="<?php echo JText::_('OS_META_DESCRIPTION'); ?>::<?php echo JText::_('OS_META_EXPLAIN'); ?>">
                                                    <?php echo JText::_('OS_META_DESCRIPTION') ?>
                                                    </span>
                                                </label>
                                                <div class="controls">
                                                    <?php
                                                    if ($translatable)
                                                    {
                                                        ?>
                                                        <ul class="nav nav-tabs">
                                                            <li class="active"><a href="#meta-general-page" data-toggle="tab"><?php echo JText::_('OS_GENERAL'); ?></a></li>
                                                            <li><a href="#meta-translation-page" data-toggle="tab"><?php echo JText::_('OS_TRANSLATION'); ?></a></li>									
                                                        </ul>		
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="meta-general-page">			
        <?php
    }
    ?>
                                                            <table  width="100%" class="admintable" style="padding:5px;">
                                                                <tr>
                                                                    <td class="key" valign="top">
    <?php echo JText::_('OS_META_DESCRIPTION') ?>
                                                                    </td>
                                                                    <td>
                                                                        <textarea style="min-height:150px;" name="metadesc" id="metadesc" cols="40" rows="4"><?php echo $row->metadesc ?></textarea>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <?php
                                                            if ($translatable)
                                                            {
                                                                ?>
                                                            </div>
                                                            <div class="tab-pane" id="meta-translation-page">
                                                                <ul class="nav nav-tabs">
                                                                    <?php
                                                                    $i = 0;
                                                                    foreach ($languages as $language)
                                                                    {
                                                                        $sef = $language->sef;
                                                                        ?>
                                                                        <li <?php echo $i == 0 ? 'class="active"' : ''; ?>><a href="#meta-translation-page-<?php echo $sef; ?>" data-toggle="tab"><?php echo $language->title; ?>
                                                                                <img src="<?php echo JURI::root(); ?>media/com_osproperty/flags/<?php echo $sef . '.png'; ?>" /></a></li>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                    ?>			
                                                                </ul>		
                                                                <div class="tab-content">			
                                                                    <?php
                                                                    $i = 0;
                                                                    foreach ($languages as $language)
                                                                    {
                                                                        $sef = $language->sef;
                                                                        ?>
                                                                        <div class="tab-pane<?php echo $i == 0 ? ' active' : ''; ?>" id="meta-translation-page-<?php echo $sef; ?>">
                                                                            <table  width="100%" class="admintable" style="padding:5px;">
                                                                                <tr>
                                                                                    <td class="key" valign="top">
            <?php echo JText::_('OS_META_DESCRIPTION') ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <textarea style="min-height:150px;" name="metadesc_<?php echo $sef; ?>" id="metadesc_<?php echo $sef; ?>" cols="40" rows="4"><?php echo $row->{'metadesc_' . $sef} ?></textarea>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
        <?php
    }
    ?>
                                                </div>
                                            </div>
<?php } ?>

                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_VIDEO_EMBED_CODE'); ?>::<?php echo JText::_('OS_VIDEO_EMBED_CODE_EXPLAIN'); ?>">
<?php echo JText::_('OS_VIDEO_EMBED_CODE') ?>
                                                </span>
                                            </label>
                                            <div class="controls">
                                                <textarea class="inputbox" name="pro_video" id="pro_video" cols="50" rows="3" class="inputbox"><?php echo $row->pro_video ?></textarea>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_DOCUMENT_LINK'); ?>::<?php echo JText::_('OS_DOCUMENT_LINK_EXPLAIN'); ?>">
<?php echo JText::_('OS_DOCUMENT_LINK') ?>
                                                </span>
                                            </label>
                                            <div class="controls">
                                                <input class="input-large" type="text" name="pro_pdf" id="pro_pdf" class="input-xlarge" value="<?php echo $row->pro_pdf; ?>" />
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">
                                                <span class="hasTip" title="<?php echo JText::_('OS_UPLOAD_DOCUMENT'); ?>::<?php echo JText::_('OS_UPLOAD_DOCUMENT_EXPLAIN'); ?>">
                                                <?php echo JText::_('OS_UPLOAD_DOCUMENT') ?>
                                                </span>
                                            </label>
                                            <div class="controls">
                                                <?php
                                                if ($row->pro_pdf_file != "")
                                                {
                                                    ?>
                                                    <a href="<?php echo JURI::root() ?>components/com_osproperty/document/<?php echo $row->pro_pdf_file ?>" target="_blank" title="<?php echo JText::_('OS_VIEW_DOCUMENT') ?>"><?php echo $row->pro_pdf_file ?></a>
                                                    <BR />
                                                    <input type="checkbox" name="remove_pdf" id="remove_pdf" onclick="javascript:changeValue('remove_pdf')" value="0" /> <strong><?php echo JText::_('OS_REMOVE'); ?></strong>
                                                    <BR />
    <?php
}
?>
                                                <span id="pro_pdf_filediv">
                                                    <input type="file" name="pro_pdf_file" id="pro_pdf_file" size="40" class="input-large" onchange="javascript:checkUploadDocumentFiles('pro_pdf_file')" /> 
                                                    <div class="clearfix"></div>
                                                    (Only allow: *.pdf, *.doc,*.docx)
                                                </span>
                                            </div>
                                        </div>
                                        <?php
                                        //echo $pane->endPanel();
                                        if (count($amenities) > 0)
                                        {
                                            echo JHtml::_('sliders.panel', JText::_('OS_CONVENIENCE'), 'convenience');
                                            ?>
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
                                                    ?>

                                                    <?php
                                                    $j = 0;
                                                    for ($k = 0; $k < count($optionArr); $k++)
                                                    {

                                                        $db->setQuery("Select * from #__osrs_amenities where category_id = '" . $k . "' and published = '1'");
                                                        $tmpamenities = $db->loadObjectList();
                                                        if (count($tmpamenities) > 0)
                                                        {
                                                            $j++;
                                                            ?>
                                                            <div class="span6" style='padding:10px;'>
                                                                <table width="100%" class="property_history_table">
                                                                    <tr>
                                                                        <td width="100%" style="height:30px;background-color:orange;color:white;text-align:center;font-weight:bold;font-size:16px;">
            <?php echo $optionArr[$k]; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="100%">
                                                                            <?php
                                                                            for ($i = 0; $i < count($tmpamenities); $i++)
                                                                            {
                                                                                if (count($amenitylists) > 0)
                                                                                {
                                                                                    if (in_array($tmpamenities[$i]->id, $amenitylists))
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
                                                                                <label for="amenities<?php echo $tmpamenities[$i]->id; ?>">
                                                                                    <input type="checkbox" name="amenities[]" <?php echo $checked ?> value="<?php echo $tmpamenities[$i]->id ?>" id="amenities<?php echo $tmpamenities[$i]->id; ?>" /> &nbsp; 
                                                                                <?php echo OSPHelper::getLanguageFieldValue($tmpamenities[$i], 'amenities'); //$tmpamenities[$i]->amenities; ?>
                                                                                </label>
                                                                                <div class="clearfix"></div>
                <?php
            }
            ?>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <?php
                                                            if ($j % 2 == 0)
                                                            {
                                                                echo "</div></div><div class='row-fluid'><div class='span12'>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        }

                                        if ($configClass['show_neighborhood_group'] == 1)
                                        {
                                            if (count($neighborhoods) > 0)
                                            {
                                                //echo $pane->startPanel(JText :: _('OS_NEIGHBORHOOD'), "neighborhood");
                                                echo JHtml::_('sliders.panel', JText::_('OS_NEIGHBORHOOD'), 'neighborhood');
                                                ?>
                                                <table  width="100%" class="admintable">
                                                    <?php
                                                    for ($i = 0; $i < count($neighborhoods); $i++)
                                                    {
                                                        $neighborhood = $neighborhoods[$i];
                                                        $db->setQuery("Select * from #__osrs_neighborhood where pid = '$row->id' and neighbor_id = '$neighborhood->id'");
                                                        $neighbor_value = $db->loadObjectList();
                                                        if (count($neighbor_value) > 0)
                                                        {
                                                            $checked = "checked";
                                                            $value = 1;
                                                            $display = "block";

                                                            $neighbor_value = $neighbor_value[0];
                                                            $mins = $neighbor_value->mins;
                                                            $traffic_type = $neighbor_value->traffic_type;
                                                            $walk = "";
                                                            $car = "";
                                                            $train = "";
                                                            switch ($traffic_type)
                                                            {
                                                                case "1":
                                                                    $walk = "checked";
                                                                    break;
                                                                case "2":
                                                                    $car = "checked";
                                                                    break;
                                                                case "3":
                                                                    $train = "checked";
                                                                    break;
                                                            }
                                                        } else
                                                        {
                                                            $checked = "0";
                                                            $value = 0;
                                                            $display = "none";
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td class="key" width="20%" style="text-align:right;">
                                                                <label for="nei_<?php echo $neighborhood->id ?>"><?php echo JText::_($neighborhood->neighborhood) ?></label>
                                                            </td>
                                                            <td width="5%">
                                                                <input type="checkbox" value="<?php echo $value ?>" name="nei_<?php echo $neighborhood->id ?>" id="nei_<?php echo $neighborhood->id ?>" <?php echo $checked ?> onclick="javascript:showNeighborhood('<?php echo $neighborhood->id ?>')" />
                                                            </td>
                                                            <td width="75%">
                                                                <div id="div_nei_<?php echo $neighborhood->id ?>" style="display:<?php echo $display ?>;">
                                                                    <input type="text" name="mins_nei_<?php echo $neighborhood->id ?>" style="width:40px;" value="<?php echo htmlspecialchars($neighbor_value->mins); ?>" /> <?php echo JText::_('OS_MINS') ?> <?php echo JText::_('OS_BY') ?>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <input type="radio" name="traffic_type_<?php echo $neighborhood->id ?>" id="traffic_type_<?php echo $neighborhood->id ?>" value="1" <?php echo $walk ?> /> <?php echo JText::_('OS_WALK') ?>
                                                                    <input type="radio" name="traffic_type_<?php echo $neighborhood->id ?>" id="traffic_type_<?php echo $neighborhood->id ?>" value="2" <?php echo $car ?> /> <?php echo JText::_('OS_CAR') ?>
                                                                    <input type="radio" name="traffic_type_<?php echo $neighborhood->id ?>" id="traffic_type_<?php echo $neighborhood->id ?>" value="3" <?php echo $train ?> /> <?php echo JText::_('OS_TRAIN') ?>
                                                                </div>
                                                            </td>
                                                        </tr>
            <?php
        }
        ?>
                                                </table>
                                                <script type="text/javascript">
                                                    function showNeighborhood(nid) {
                                                        var temp = document.getElementById('nei_' + nid);
                                                        var div = document.getElementById('div_nei_' + nid);
                                                        if (temp.value == 0) {
                                                            div.style.display = "block";
                                                            temp.value = 1;
                                                        } else {
                                                            div.style.display = "none";
                                                            temp.value = 0;
                                                        }
                                                    }
                                                </script>
                                                <?php
                                                //echo $pane->endPanel();
                                            }
                                        }
//echo $pane->endPane();
                                        echo JHtml::_('sliders.end');
                                        ?>
                                    </fieldset>
                                </div>
                            </div>
<?php if ($configClass['use_property_history'] == 1)
{
    ?>
                                <div class="tab-pane" id="addpropertypanel5">
                                    <div class="col width-100">
                                        <fieldset id="history_tax" class="fieldsetpropertydetails">
                                            <legend><strong><?php echo JText::_('OS_HISTORY_TAX'); ?></strong></legend>
                                            <div class="control-group">
                                                <label class="control-label">
    <?php echo JText::_('OS_PROPERTY_HISTORY'); ?>
                                                </label>
                                                <div class="controls">
                                                    <table width="100%" id="property_history_table">
                                                        <tr>
                                                            <th>
    <?php echo JText::_('OS_DATE') ?>
                                                            </th>
                                                            <th>
    <?php echo JText::_('OS_EVENT') ?>
                                                            </th>
                                                            <th>
    <?php echo JText::_('OS_PRICE') ?>
                                                            </th>
                                                            <th>
    <?php echo JText::_('OS_SOURCE') ?>
                                                            </th>
                                                            <th>
                                                                &nbsp;
                                                            </th>
                                                        </tr>
                                                        <?php
                                                        if (count($lists['history']) > 0)
                                                        {
                                                            foreach ($lists['history'] as $his)
                                                            {
                                                                ?>
                                                                <tr id="history_table_tr">
                                                                    <td>
                                                                        <input type="text" name="history_date[]" value="<?php echo $his->date ?>" class="input-small" placeholder="0000-00-00" />
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="history_event[]" value="<?php echo $his->event ?>" class="input-medium" />
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="history_price[]" value="<?php echo $his->price ?>" class="input-small" />
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="history_source[]" value="<?php echo $his->source ?>" class="input-medium" />
                                                                    </td>
                                                                    <td>
                                                                        <input type="button" class="btn removehistory" value="<?php echo JText::_('OS_DELETE'); ?>" />
                                                                    </td>
                                                                </tr>
            <?php
        }
    }
    ?>
                                                        <tr id="history_table_tr">
                                                            <td>
                                                                <input type="text" name="history_date[]" value="" class="input-small" placeholder="0000-00-00" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="history_event[]" value="" class="input-medium" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="history_price[]" value="" class="input-small" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="history_source[]" value="" class="input-medium" />
                                                            </td>
                                                            <td>
                                                                <input type="button" class="btn addhistory" value="<?php echo JText::_('OS_ADD'); ?>" />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">
    <?php echo JText::_('OS_PROPERTY_TAX'); ?>
                                                </label>
                                                <div class="controls">
                                                    <table width="100%" id="property_tax_table">
                                                        <tr>
                                                            <th>
    <?php echo JText::_('OS_YEAR') ?>
                                                            </th>
                                                            <th>
    <?php echo JText::_('OS_TAX') ?>
                                                            </th>
                                                            <th>
    <?php echo JText::_('OS_TAX_CHANGE') ?>
                                                            </th>
                                                            <th>
    <?php echo JText::_('OS_TAX_ASSESSMENT') ?>
                                                            </th>
                                                            <th>
    <?php echo JText::_('OS_TAX_ASSESSMENT_CHANGE') ?>
                                                            </th>
                                                            <th>
                                                                &nbsp;
                                                            </th>
                                                        </tr>
                                                        <?php
                                                        if (count($lists['tax']) > 0)
                                                        {
                                                            foreach ($lists['tax'] as $tax)
                                                            {
                                                                ?>
                                                                <tr id="tax_table_tr">
                                                                    <td>
                                                                        <input type="text" name="tax_year[]" value="<?php echo $tax->tax_year ?>" class="input-small" />
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="tax_value[]" value="<?php echo $tax->property_tax ?>" class="input-small" />
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="tax_change[]" value="<?php echo $tax->tax_change ?>" class="input-small" />
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="tax_assessment[]" value="<?php echo $tax->tax_assessment ?>" class="input-small" />
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="tax_assessment_change[]" value="<?php echo $tax->tax_assessment_change ?>" class="input-small" />
                                                                    </td>
                                                                    <td>
                                                                        <input type="button" class="btn removetax" value="<?php echo JText::_('OS_DELETE'); ?>" />
                                                                    </td>
                                                                </tr>
            <?php
        }
    }
    ?>
                                                        <tr id="tax_table_tr">
                                                            <td>
                                                                <input type="text" name="tax_year[]" value="" class="input-small" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="tax_value[]" value="" class="input-small" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="tax_change[]" value="" class="input-small" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="tax_assessment[]" value="" class="input-small" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="tax_assessment_change[]" value="" class="input-small" />
                                                            </td>
                                                            <td>
                                                                <input type="button" class="btn addtax" value="<?php echo JText::_('OS_ADD'); ?>" />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                    <?php } ?>
                            <div class="tab-pane" id="addpropertypanel4">
                                <div class="col width-100">
<?php
if (count($row->photo) < $configClass['limit_upload_photos'])
{
    ?>
                                        <fieldset id="photos<?php echo $row->id; ?>" class="fieldsetpropertydetails">
                                            <legend><strong><?php echo JText::_('OS_QUICK_UPLOAD'); ?></strong></legend>
                                            <?php
                                            if ($row->id > 0)
                                            {
                                                $link = JURI::root() . "index.php?option=com_osproperty&task=upload_ajaxupload&tmpl=component&id=$row->id";
                                                ?>
                                                <a href="<?php echo $link; ?>" class="osmodal" rel="{handler:'iframe', size: {x:850, y: 550},onClose:function(){var js =window.location.reload();}}">
                                                <?php echo JText::_('OS_CLICK_HERE_TO_USE_DRAG_AND_DROP_FEATURE'); ?>
                                                </a>
                                                <?php
                                            } else
                                            {
                                                echo JText::_('OS_AFTER_SAVING_PROPERTY_YOU_WILL_BE_ABLE_TO_USE_THIS_FEATURE');
                                            }
                                            ?>
                                        </fieldset>
                                        <?php } ?>
                                    <fieldset id="photos<?php echo $row->id; ?>" class="fieldsetpropertydetails">
                                        <legend><strong><?php echo JText::_('OS_MANUAL_UPLOAD'); ?></strong></legend>
                                        <?php
                                        $total = ($configClass['limit_upload_photos'] > 0) ? $configClass['limit_upload_photos'] : 24;
                                        echo sprintf(JText::_('OS_PROPERTY_WILL_HAVE_PHOTOS'), $total);
                                        ?>
                                        <BR />
                                        <?php echo sprintf(JText::_('OS_ACCORDING_CONFIG_PHOTO_WILL_BE_RESIZED'), $configClass['images_thumbnail_width'], $configClass['images_thumbnail_height']); ?>
                                        <BR />
                                        <small><i>(<?php echo JText::_('OS_ONLY_SUPPORT_JPG_IMAGES'); ?>)</i></small>
                                        <BR /><BR />
                                        <?php
                                        $i = 0;
                                        if (count($row->photo) > 0)
                                        {
                                            $photos = $row->photo;
                                            for ($i = 0; $i < count($photos); $i++)
                                            {
                                                $photo = $photos[$i];
                                                ?>
                                                <div style="display:block;padding:3px;border:1px dotted #efefef;" id="div_<?php echo $i ?>">
                                                    <table class="admintable">
                                                        <tr>
                                                            <td class="key">
                                                                <?php echo JText::_('OS_PHOTO') ?> <?php echo $i + 1 ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($photo->image != "")
                                                                {
                                                                    OSPHelper::showPropertyPhoto($photo->image, 'thumb', $row->id, 'width:150px;', 'img-polaroid', '');
                                                                }
                                                                ?>
                                                                <div style="clear:both;"></div>
                                                                <span id="photo_<?php echo $i + 1 ?>div">
                                                                    <input type="file" name="photo_<?php echo $i + 1 ?>" id="photo_<?php echo $i + 1 ?>" size="30" onchange="javascript:check_file('photo_<?php echo $i + 1 ?>')" />
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="key">
        <?php echo JText::_('OS_PHOTO_DESCRIPTION') ?>
                                                            </td>
                                                            <td>
                                                                <textarea class="inputbox" name="photodesc_<?php echo $i + 1 ?>" id="photodesc_<?php echo $i + 1 ?>" class="inputbox" cols="40" rows="3"><?php echo $photo->image_desc ?></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="key">
        <?php echo JText::_('OS_ORDERING') ?>
                                                            </td>
                                                            <td>
                                                                <input class="input-mini" type="text" name="ordering_<?php echo $i + 1 ?>" id="ordering_<?php echo $i + 1 ?>" size="3" value="<?php echo $photo->ordering ?>" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="key">
        <?php echo JText::_('OS_REMOVE') ?>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" name="remove_<?php echo $photo->id ?>" id="remove_<?php echo $photo->id ?>" value="0" onclick="javascript:changeValue('remove_<?php echo $photo->id ?>')" />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                        if (intval($row->id) > 0)
                                        {
                                            $j = $i;
                                        } else
                                        {
                                            $j = 0;
                                        }

                                        for ($i = $j; $i < $total; $i++)
                                        {
                                            ?>
                                            <div style="display:none;padding:3px;border:1px dotted #efefef;" id="div_<?php echo $i ?>">
                                                <table class="admintable">
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_REMOVE') ?> <?php echo $i + 1 ?>
                                                        </td>
                                                        <td>
                                                            <span id="photo_<?php echo $i + 1 ?>div">
                                                                <input type="file" name="photo_<?php echo $i + 1 ?>" id="photo_<?php echo $i + 1 ?>" size="30" onchange="javascript:check_file('photo_<?php echo $i + 1 ?>')" />
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_PHOTO_DESCRIPTION') ?>
                                                        </td>
                                                        <td>
                                                            <textarea class="inputbox" name="photodesc_<?php echo $i + 1 ?>" id="photodesc_<?php echo $i + 1 ?>" class="inputbox" cols="40" rows="3"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
    <?php echo JText::_('OS_ORDERING') ?>
                                                        </td>
                                                        <td>
    <?php echo JText::_('OS_ORDERING_WILL_BE_INCREASED') ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

    <?php
}
?>
                                        <BR />
                                        <div id="newphoto<?php echo $id; ?>" class="button2-left" style="display:block;">
                                            <div class="image">
                                                <a href="javascript:addPhoto()" class="btn btn-success"><i class="osicon-new"></i>&nbsp;<?php echo JText::_('OS_ADD_PHOTO'); ?></a>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
<?php
if (($configClass['active_payment'] == 1) and ( $configClass['integrate_membership'] == 0) and ( $show_payment_tab == 1))
{
    ?>
                                <div class="tab-pane <?php echo $tab2; ?>" id="addpropertypanel6">
                                    <div class="col width-100">
                                        <?php
                                        if (($configClass['general_use_expiration_management'] == 1) and ( $isNew == 0))
                                        {
                                            $expiration = $row->expiration;
                                            ?>
                                            <table class="addproperty-membership-table" width="100%">
                                                <tr>
                                                    <th width="50%" style="text-align:left !important;padding-left:15px;">
        <?php echo Jtext::_('OS_EXPIRATION_INFORMATION'); ?>
                                                    </th>
                                                    <th width="50%" style="text-align:left !important;padding-left:15px;">
                                                <?php echo Jtext::_('OS_PROPERTY_TYPE'); ?>
                                                    </th>
                                                </tr>
        <?php
        if ($row->isFeatured == 1)
        {
            ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo JText::_('OS_FEATURED_UNTIL'); ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $expiration_featured = strtotime($expiration->expired_feature_time);
                                                            if ($expiration_featured < time())
                                                            {
                                                                $style = "extend_alert";
                                                            } else
                                                            {
                                                                $style = "";
                                                            }
                                                            echo "<span class='$style'>" . date($configClass['general_date_format'], $expiration_featured) . "</a>";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                if ($expiration->expired_time != "0000-00-00 00:00:00")
                                                {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo JText::_('OS_UNPUBLISHED_ON'); ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $expiration_time = strtotime($expiration->expired_time);
                                                            if ($expiration_time < time())
                                                            {
                                                                $style = "extend_alert";
                                                            } else
                                                            {
                                                                $style = "";
                                                            }
                                                            echo "<span class='$style'>" . date($configClass['general_date_format'], $expiration_time) . "</a>";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                if ($expiration->remove_from_database != "0000-00-00 00:00:00")
                                                {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo JText::_('OS_REMOVED_ON'); ?>
                                                        </td>
                                                        <td>
            <?php
            $expiration_remove = strtotime($expiration->remove_from_database);
            echo "<span>" . date($configClass['general_date_format'], $expiration_remove) . "</a>";
            ?>
                                                        </td>
                                                    </tr>
        <?php } ?>
                                            </table>
    <?php } ?>
                                        <BR />
                                        <table class="addproperty-membership-table" width="100%">
                                            <tr>
                                                <th width="15%">
                                                    #
                                                </th>
                                                <th width="85%">
    <?php echo Jtext::_('OS_PROPERTY_TYPE'); ?>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="radio" name="isFeatured" id="isFeatured1" value="0" onClick="javascript:showPaymentForm(0);" checked /> &nbsp;<label for="isFeatured1"><?php echo JText::_('OS_STANDARD'); ?></label>
                                                </td>
                                                <td>
                                                    <span><?php echo JText::_('OS_STANDARD_EXPLANATION'); ?></span>
                                                    <div class="clearfix"></div>
                                                    <table class="addproperty-membership-subtable">
                                                        <tr>
                                                            <?php if ($configClass['general_use_expiration_management'] == 1)
                                                            {
                                                                ?>
                                                                <th width="50%">
        <?php echo Jtext::_('OS_LIFE_TIME'); ?>
                                                                </th>
                                                            <?php } ?>
                                                            <th width="50%">
                                                            <?php echo Jtext::_('OS_PRICE'); ?>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                                <?php if ($configClass['general_use_expiration_management'] == 1)
                                                                {
                                                                    ?>
                                                                <td>
                                                                    <?php
                                                                    echo $configClass['general_time_in_days'];
                                                                    echo " " . JText::_('OS_DAYS');
                                                                    ?>
                                                                </td>
                                                                <?php } ?>
                                                            <td width="50%">
                                                                <?php
                                                                if ($configClass['normal_cost'] == "0")
                                                                {
                                                                    echo Jtext::_('OS_FREE');
                                                                } else
                                                                {
                                                                    echo OSPHelper::generatePrice(HelperOspropertyCommon::loadCurrency(), $configClass['normal_cost']);
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="radio" name="isFeatured" id="isFeatured2" onClick="javascript:showPaymentForm(1);" value="1" /> &nbsp;<label for="isFeatured2"><?php echo JText::_('OS_FEATURED'); ?></label>
                                                </td>
                                                <td>
                                                    <span><?php echo JText::_('OS_FEATURED_EXPLANATION'); ?></span>
                                                    <div class="clearfix"></div>
                                                    <table class="addproperty-membership-subtable">
                                                        <tr>
                                                                <?php if ($configClass['general_use_expiration_management'] == 1)
                                                                {
                                                                    ?>
                                                                <th width="50%">
                                                                <?php echo Jtext::_('OS_LIFE_TIME'); ?>
                                                                </th>
                                                            <?php } ?>
                                                            <th width="50%">
                                                                <?php echo Jtext::_('OS_PRICE'); ?>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <?php if ($configClass['general_use_expiration_management'] == 1)
                                                            {
                                                                ?>
                                                                <td>
                                                                    <?php
                                                                    echo $configClass['general_time_in_days_featured'];
                                                                    echo " " . JText::_('OS_DAYS');
                                                                    ?>
                                                                </td>
                                                                <?php } ?>
                                                            <td width="50%">
                                                                <?php
                                                                if ($configClass['general_featured_upgrade_amount'] == "0")
                                                                {
                                                                    echo Jtext::_('OS_FREE');
                                                                } else
                                                                {
                                                                    echo OSPHelper::generatePrice(HelperOspropertyCommon::loadCurrency(), $configClass['general_featured_upgrade_amount']);
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <?php
                                        if (floatVal($configClass['normal_cost']) > 0)
                                        {
                                            $display = "block";
                                        } else
                                        {
                                            $display = "none";
                                        }
                                        ?>
                                        <div id="payment_list" style="display:<?php echo $display; ?>;">
    <?php
    $methods = $lists['methods'];
    if (count($methods) > 0)
    {
        ?>
                                                <input type="hidden" name="nmethods" id="nmethods" value="<?php echo count($methods) ?>" />
                                                <table class="addproperty-membership-payments-table" width="100%">
                                                    <tr>
                                                        <th width="5%">
                                                            #
                                                        </th>
                                                        <th width="20%">
                                                    <?php echo Jtext::_('OS_PAYMENT_NAME'); ?>
                                                        </th>
                                                        <th width="55%">
                                                    <?php echo Jtext::_('OS_PAYMENT_DESC'); ?>
                                                        </th>
                                                        <th width="20%" class="hidden-phone">
                                                        </th>
                                                    </tr>
                                                    <?php
                                                    $method = null;
                                                    for ($i = 0, $n = count($methods); $i < $n; $i++)
                                                    {
                                                        $paymentMethod = $methods[$i];
                                                        if ($paymentMethod->getName() == $lists['paymentMethod'])
                                                        {
                                                            $checked = ' checked="checked" ';
                                                            $method = $paymentMethod;
                                                        } else
                                                            $checked = '';
                                                        ?>
                                                        <tr>
                                                            <td style="text-align:center;">
                                                                <input onclick="javascript:changePaymentMethod();" type="radio" name="payment_method" id="pmt<?php echo $i ?>" value="<?php echo $paymentMethod->getName(); ?>" <?php echo $checked; ?> />
                                                            </td>
                                                            <td>
                                                                <label for="pmt<?php echo $i ?>"><?php echo JText::_($paymentMethod->title); ?></label>
                                                            </td>
                                                            <td>
                                                                <?php echo $paymentMethod->description; ?>
                                                            </td>
                                                            <td style="text-align:center;" class="hidden-phone">
            <?php
            if (file_exists(JPATH_ROOT . '/images/osproperty/plugins/' . $paymentMethod->pure_name . '.png'))
            {
                ?>
                                                                    <img src="<?php echo JUri::root() . 'images/osproperty/plugins/' . $paymentMethod->pure_name . '.png' ?>"  width="110" />
                                                            <?php
                                                        }
                                                        ?>
                                                            </td>
                                                        </tr>

                                                    <?php
                                                }
                                                ?>
                                                </table>
                                                <?php
                                            } else
                                            {
                                                $method = $methods[0];
                                            }

                                            if ($method->getCreditCard())
                                            {
                                                $style = '';
                                            } else
                                            {
                                                $style = 'style = "display:none"';
                                            }
                                            ?>
                                            <table class="addproperty-membership-credit-table">
                                                <tr id="tr_card_head">
                                                    <th colspan=2>
    <?php echo JText::_('OS_CREDIT_CARD_INFORMATION'); ?>
                                                    </th>
                                                </tr>
                                                <tr id="tr_card_number" <?php echo $style; ?>>
                                                    <td class="infor_left_col"><?php echo JText::_('OS_AUTH_CARD_NUMBER'); ?><span class="required">*</span></td>
                                                    <td class="infor_right_col">
                                                        <input type="text" name="x_card_num" id="x_card_num" class="input-medium" onkeyup="checkNumber(this, '<?php echo JText::_('OS_ONLY_NUMBER'); ?>')" value="<?php echo $x_card_num; ?>" size="20" />
                                                    </td>					
                                                </tr>
                                                <tr id="tr_exp_date" <?php echo $style; ?>>
                                                    <td class="infor_left_col">
                                                        <?php echo JText::_('OS_AUTH_CARD_EXPIRY_DATE'); ?><span class="required">*</span>
                                                    </td>
                                                    <td class="infor_right_col">	
    <?php echo $lists['exp_month'] . '  /  ' . $lists['exp_year']; ?>
                                                    </td>					
                                                </tr>
                                                <tr id="tr_cvv_code" <?php echo $style; ?>>
                                                    <td class="infor_left_col">
                                                <?php echo JText::_('OS_AUTH_CVV_CODE'); ?><span class="required">*</span>
                                                    </td>
                                                    <td class="infor_right_col">
                                                        <input type="text" name="x_card_code" id="x_card_code" class="input-medium" onKeyUp="checkNumber(this, '<?php echo JText::_('OS_ONLY_NUMBER'); ?>')" value="<?php echo $x_card_code; ?>" size="20" />
                                                    </td>					
                                                </tr>
                                                <?php
                                                if ($method->getCardType())
                                                {
                                                    $style = '';
                                                } else
                                                {
                                                    $style = ' style = "display:none;" ';
                                                }
                                                ?>
                                                <tr id="tr_card_type" <?php echo $style; ?>>
                                                    <td class="infor_left_col">
                                                <?php echo JText::_('OS_CARD_TYPE'); ?><span class="required">*</span>
                                                    </td>
                                                    <td class="infor_right_col">
                                                <?php echo $lists['card_type']; ?>
                                                    </td>						
                                                </tr>					
                                                <?php
                                                if ($method->getCardHolderName())
                                                {
                                                    $style = '';
                                                } else
                                                {
                                                    $style = ' style = "display:none;" ';
                                                }
                                                ?>
                                                <tr id="tr_card_holder_name" <?php echo $style; ?>>
                                                    <td class="infor_left_col">
                                                <?php echo JText::_('OS_CARD_HOLDER_NAME'); ?><span class="required">*</span>
                                                    </td>
                                                    <td class="infor_right_col">
                                                        <input type="text" name="card_holder_name" id="card_holder_name" class="input-medium"  value="<?php echo $cardHolderName; ?>" size="40" />
                                                    </td>						
                                                </tr>
                                                <?php
                                                if ($method->getName() == 'os_echeck')
                                                {
                                                    $style = '';
                                                } else
                                                {
                                                    $style = ' style = "display:none;" ';
                                                }
                                                ?>

                                                <tr id="tr_bank_rounting_number" <?php echo $style; ?>>
                                                    <td class="infor_left_col"  class="infor_left_col"><?php echo JText::_('OSM_BANK_ROUTING_NUMBER'); ?><span class="required">*</span></td>
                                                    <td class="infor_right_col"><input type="text" name="x_bank_aba_code" class="input-medium"  value="<?php echo $x_bank_aba_code; ?>" size="40" onKeyUp="checkNumber(this, '<?php echo JText::_('OS_ONLY_NUMBER'); ?>');" /></td>
                                                </tr>
                                                <tr id="tr_bank_account_number" <?php echo $style; ?>>
                                                    <td class="infor_left_col" class="infor_left_col"><?php echo JText::_('OSM_BANK_ACCOUNT_NUMBER'); ?><span class="required">*</span></td>
                                                    <td class="infor_right_col"><input type="text" name="x_bank_acct_num" class="input-medium"  value="<?php echo $x_bank_acct_num; ?>" size="40" onKeyUp="checkNumber(this, '<?php echo JText::_('OS_ONLY_NUMBER'); ?>');" /></td>
                                                </tr>
                                                <tr id="tr_bank_account_type" <?php echo $style; ?>>
                                                    <td class="infor_left_col"  class="infor_left_col"><?php echo JText::_('OSM_BANK_ACCOUNT_TYPE'); ?><span class="required">*</span></td>
                                                    <td class="infor_right_col"><?php echo $lists['x_bank_acct_type']; ?></td>
                                                </tr>
                                                <tr id="tr_bank_name" <?php echo $style; ?>>
                                                    <td class="infor_left_col" class="infor_left_col"><?php echo JText::_('OSM_BANK_NAME'); ?><span class="required">*</span></td>
                                                    <td class="infor_right_col"><input type="text" name="x_bank_name" class="input-medium"  value="<?php echo $x_bank_name; ?>" size="40" /></td>
                                                </tr>
                                                <tr id="tr_bank_account_holder" <?php echo $style; ?>>
                                                    <td class="infor_left_col" class="infor_left_col"><?php echo JText::_('OSM_ACCOUNT_HOLDER_NAME'); ?><span class="required">*</span></td>
                                                    <td class="infor_right_col"><input type="text" name="x_bank_acct_name" class="input-medium"  value="<?php echo $x_bank_acct_name; ?>" size="40" /></td>
                                                </tr>	

                                            </table>
                                        </div>
                                    </div>
                                </div>
<?php } ?>
                        </div>
                        <script type="text/javascript">
<?php
os_payments::writeJavascriptObjects();
?>
                            function showPaymentForm(value) {
                                if (value == 0) {
<?php
if (floatVal($configClass['normal_cost']) > 0)
{
    ?>
                                        document.getElementById('payment_list').style.display = "block";
<?php } else
{
    ?>
                                        document.getElementById('payment_list').style.display = "none";
<?php } ?>
                                } else if (value == 1) {
<?php
if (floatVal($configClass['general_featured_upgrade_amount']) > 0)
{
    ?>
                                        document.getElementById('payment_list').style.display = "block";
<?php } else
{
    ?>
                                        document.getElementById('payment_list').style.display = "none";
<?php } ?>
                                }
                            }

                            jQuery(document).ready(function () {
                                jQuery('.removehistory').live('click', function () {
                                    jQuery(this).parent().parent().remove();
                                });

                                jQuery('.addhistory').live('click', function () {
                                    jQuery(this).val('<?php echo JText::_('OS_DELETE'); ?>');
                                    jQuery(this).attr('class', 'btn removehistory');
                                    var appendTxt = '<tr id="history_table_tr"><td><input type="text" name="history_date[]" value="" placeholder="0000-00-00" class="input-small" /></td><td><input type="text" name="history_event[]" value="" class="input-medium" /></td><td><input type="text" name="history_price[]" value="" class="input-small" /></td><td><input type="text" name="history_source[]" value="" class="input-medium" /></td><td><input type="button" class="btn addhistory" value="<?php echo JText::_('OS_ADD'); ?>" /></td></tr>';
                                    jQuery("#property_history_table>tbody>tr:last").after(appendTxt);
                                });

                                jQuery('.removetax').live('click', function () {
                                    jQuery(this).parent().parent().remove();
                                });

                                jQuery('.addtax').live('click', function () {
                                    jQuery(this).val('<?php echo JText::_('OS_DELETE'); ?>');
                                    jQuery(this).attr('class', 'btn removetax');
                                    var appendTxt = '<tr id="tax_table_tr"><td><input type="text" name="tax_year[]" value="" class="input-small" /></td><td><input type="text" name="tax_value[]" value="" class="input-small" /></td><td><input type="text" name="tax_change[]" value="" class="input-small" /></td><td><input type="text" name="tax_assessment[]" value="" class="input-small" /></td><td><input type="text" name="tax_assessment_change[]" value="" class="input-small" /></td><td><input type="button" class="btn addtax" value="<?php echo JText::_('OS_ADD'); ?>" /></td></tr>';
                                    jQuery("#property_tax_table>tbody>tr:last").after(appendTxt);
                                });
                            });


                        </script>
                            <?php
                            if ($translatable)
                            {
                                ?>
                        </div>
                        <div class="tab-pane" id="translation-page">
                            <ul class="nav nav-tabs">
                                <?php
                                $i = 0;
                                foreach ($languages as $language)
                                {
                                    $sef = $language->sef;
                                    ?>
                                    <li <?php echo $i == 0 ? 'class="active"' : ''; ?>><a href="#translation-page-<?php echo $sef; ?>" data-toggle="tab"><?php echo $language->title; ?>
                                            <img src="<?php echo JURI::root(); ?>media/com_osproperty/flags/<?php echo $sef . '.png'; ?>" /></a></li>
                                    <?php
                                    $i++;
                                }
                                ?>			
                            </ul>		
                            <div class="tab-content">			
                                                <?php
                                                $i = 0;
                                                foreach ($languages as $language)
                                                {
                                                    $sef = $language->sef;
                                                    ?>
                                    <div class="tab-pane<?php echo $i == 0 ? ' active' : ''; ?>" id="translation-page-<?php echo $sef; ?>">													
                                        <table width="100%" class="admintable" style="background-color:white;">
                                            <tr>
                                                <td class="key">
        <?php echo JText::_('OS_PROPERTY_TITLE') ?>
                                                </td>
                                                <td>
                                                    <input type="text" name="pro_name_<?php echo $sef; ?>" id="pro_name_<?php echo $sef; ?>" value="<?php echo $row->{'pro_name_' . $sef} ?>" size="50" class="input-large" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="key">
        <?php echo JText::_('OS_ALIAS') ?>
                                                </td>
                                                <td>
                                                    <input type="text" name="pro_alias_<?php echo $sef; ?>" id="pro_alias_<?php echo $sef; ?>" value="<?php echo $row->{'pro_alias_' . $sef} ?>" size="50" class="input-large" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="key" valign="top">
                                                    <?php echo JText::_('OS_SMALL_DESCRIPTION') ?>
                                                </td>
                                                <td>
                                                    <textarea style="min-height:150px;" name="pro_small_desc_<?php echo $sef; ?>" id="pro_small_desc_<?php echo $sef; ?>" cols="50" rows="5" class="input-large"><?php echo stripslashes($row->{'pro_small_desc_' . $sef}) ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="key" valign="top">
                                    <?php echo JText::_('OS_FULL_DESCRIPTION') ?>
                                                </td>
                                                <td>
                                    <?php
                                    echo $editor->display('pro_full_desc_' . $sef, stripslashes($row->{'pro_full_desc_' . $sef}), '95%', '250', '75', '20', false);
                                    ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>										
        <?php
        $i++;
    }
    ?>
                            </div>	
                        </div>
                    </div>
        <?php
    }
    ?>
            </div>
        </div>
    </div>
<?php
if (intval($row->id) == 0)
{
    $j = -1;
} else
{
    $j = count($row->photo) - 1;
}
?>
    <input type="hidden" name="current_number_photo" id="current_number_photo" value="<?php echo $j ?>" />
    <input type="hidden" name="newphoto" id="newphoto" value="<?php echo count($row->photo) ?>" />
    <input type="hidden" name="option" value="com_osproperty" />
    <input type="hidden" name="task" value="property_save" />
    <input type="hidden" name="id" value="<?php echo $row->id ?>" />
    <input type="hidden" name="MAX_FILE_SIZE" value="9000000000" />
    <input type="hidden" name="require_field" id="require_field" value="<?php echo substr($require_field, 0, strlen($require_field) - 1) ?>" />
    <input type="hidden" name="require_label" id="require_label" value="<?php echo substr($require_label, 0, strlen($require_label) - 1) ?>" />
    <input type="hidden" name="Itemid" value="<?php echo $itemid; ?>" />
    <input type="hidden" name="extend" id="extend" value="<?php echo $extend; ?>" />
    <?php
    if ($row->id > 0)
    {
        ?>
        <input type="hidden" name="company_id" value="<?php echo $row->company_id; ?>" />
    <?php
}


if (count($lists['types']) > 0)
{
    foreach ($lists['types'] as $type)
    {
        ?>
            <input type="hidden" name="type_id_<?php echo $type->id ?>" id="type_id_<?php echo $type->id ?>" value="<?php echo implode(",", $type->fields); ?>"/>
            <input type="hidden" name="type_id_<?php echo $type->id ?>_required" id="type_id_<?php echo $type->id ?>_required" value="<?php echo implode(",", $type->required_fields); ?>"/>
            <input type="hidden" name="type_id_<?php echo $type->id ?>_required_name" id="type_id_<?php echo $type->id ?>_required_name" value="<?php echo implode(",", $type->required_fields_name); ?>"/>
            <input type="hidden" name="type_id_<?php echo $type->id ?>_required_title" id="type_id_<?php echo $type->id ?>_required_title" value="<?php echo implode(",", $type->required_fields_label); ?>"/>
            <?php
        }
    }
    ?>
    <input type="hidden" name="field_ids" id="field_ids" value="<?php echo implode(",", $fieldLists) ?>" />
<?php
if ($configClass['use_sold'] == 1)
{
    ?>
        <input type="hidden" name="sold_property_types" id="sold_property_types" value="<?php echo $configClass['sold_property_types'] ?>" />
    <?php
}
?>
</form>
<script type="text/javascript">
    jQuery(document).ready(function () {
        initialize();
    });
    jQuery("#pro_type").change(function () {
        var fields = jQuery("#field_ids").val();
        var fieldArr = fields.split(",");
        if (fieldArr.length > 0) {
            for (i = 0; i < fieldArr.length; i++) {
                jQuery("#extrafield_" + fieldArr[i]).hide("fast");
            }
        }
        var selected_value = jQuery("#pro_type").val();
        if (parseInt(selected_value) > 0) {
            jQuery("#fieldgroups_div").css("display", "block");
        } else {
            jQuery("#fieldgroups_div").css("display", "none");
        }
        var selected_fields = jQuery("#type_id_" + selected_value).val();
        var fieldArr = selected_fields.split(",");
        if (fieldArr.length > 0) {
            for (i = 0; i < fieldArr.length; i++) {
                jQuery("#extrafield_" + fieldArr[i]).show("slow");
            }
        }
<?php
if ($configClass['use_sold'] == 1)
{
    ?>
            var selected_fields = jQuery("#sold_property_types").val();
            if (selected_fields != null) {
                var fieldArr = selected_fields.split("|");
                if (fieldArr.length > 0) {
                    var show = 0;
                    for (i = 0; i < fieldArr.length; i++) {
                        if (fieldArr[i] == selected_value)
                        {
                            show = 1;
                        }
                    }
                    if (show == 1) {
                        jQuery("#sold_information").show("slow");
                    } else {
                        jQuery("#sold_information").hide("slow");
                    }
                }
            }
    <?php
}
?>
    });
</script>