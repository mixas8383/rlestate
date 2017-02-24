<div class="statistic-page">
    <div class="property-info" >
        <?php
        if ($row->photo != "")
        {
            if (JFile::exists(JPATH_ROOT . '/images/osproperty/properties/' . $row->id . '/medium/' . $row->photo->image))
            {
                $src = JURI::root() . 'images/osproperty/properties/' . $row->id . '/medium/' . $row->photo->image;
            } else
            {
                $src = JURI::root() . 'components/com_osproperty/images/assets/nopropertyphoto.png';
            }
        } else
        {
            $src = JURI::root() . 'components/com_osproperty/images/assets/nopropertyphoto.png';
        }
        ?>
        <div class="statistic-header" style="background-image: url('<?php echo $src; ?>')">
            <div class="property-data">
                <div class="pro-name">
                    <?php
                    if ($row->pro_name != "")
                    {
                        ?>
                        <?php echo $row->pro_name ?>
                        <?php
                    }
                    ?>
                    <?php
                    if ($row->ref != "")
                    {
                        ?>
                        #<?php echo $row->ref ?>,&nbsp;
                        <?php
                    }
                    ?>
                    <?php if ($row->show_address == 1)
                    {
                        ?>
                        <div class="address_details">
                        <?php echo OSPHelper::generateAddress($row); ?>
                        </div>
<?php } ?>
                </div>
                <div class="clearfix" style="height: 25px;"></div>
                <div class="information-pro">
                    <div class="row-fluid ">
                        <div class="span4 price-property border">
                            <?php
                            if ($row->price_call == 0)
                            {
                                if ($row->price > 0)
                                {
                                    echo OSPHelper::generatePrice($row->curr, $row->price);
                                    if ($row->rent_time != "")
                                    {
                                        ?>
                                        / <span id="mthpayment"><?php echo JText::_($row->rent_time); ?></span>
                                        <?php
                                    }
                                }
                            } elseif ($row->price_call == 0)
                            {
                                ?>
                                <span style='font-size:16px;'><?php echo JText::_('OS_CALL_FOR_DETAILS_PRICE') ?></span>
                            <?php }
                            ?>
                            <p class="property-type">
                                <img src="<?php echo $row->type_icon; ?>" />&nbsp;&nbsp;<?php echo $row->pro_type ?>
                            </p>
                        </div>
                        <?php
                        if ($configClass['use_bedrooms'] == 1)
                        {
                            ?>
                            <div class="span2 border">
                                <div class="pro-numberbed">
                                    <p>
    <?php echo $row->bed_room; ?>
                                    </p>
                                    <p>
    <?php echo JText::_("OS_BED"); ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        if ($configClass['use_bathrooms'] == 1)
                        {
                            ?>
                            <div class="span2 border">
                                <div class="pro-numberbed">
                                    <p>
    <?php echo OSPHelper::showBath($row->bath_room); ?>
                                    </p>
                                    <p>
    <?php echo JText::_("OS_BATH"); ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        if ($configClass['use_squarefeet'] == 1)
                        {
                            ?>
                            <div class="span3">
                                <div class="pro-numberbed">
                                    <p>
    <?php echo OSPHelper::showSquare($row->square_feet); ?>
                                    </p>
                                    <p>
    <?php echo OSPHelper::showSquareSymbol(); // JText::_('OS_SQUARE_FEET') ?>
                                    </p>
                                </div>
                            </div>
<?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix" style="height: 20px"></div>
        <div class="row-fluid editbuttons">
            <div class="span12">
                <ul>
                    <li>
                        <?php
                        $link = JRoute::_('index.php?option=com_osproperty&task=property_edit&id=' . $row->id);
                        ?>
                        <a href="<?php echo $link ?>" alt="<?php echo $row->pro_name; ?>" title="<?php echo JText::_("OS_EDIT_LISTING"); ?>: <?php echo $row->pro_name ?>">
                            <img src="<?php echo JUri::root(); ?>components/com_osproperty/images/assets/edit24.png" alt="<?php echo JText::_("OS_EDIT_LISTING"); ?>: <?php echo $row->pro_name ?>"/>
                            <BR />
                            <p><?php echo JText::_("OS_EDIT_LISTING"); ?></p>
                        </a>
                    </li>
                    <?php
                    if (HelperOspropertyCommon::isAgent())
                    {
                        ?>
                        <li>
                            <?php
                            $needs[] = "aeditdetails";
                            $needs[] = "agent_default";
                            $needs[] = "agent_editprofile";
                            $itemid = OSPRoute::getItemid($needs);
                            $link = JRoute::_('index.php?option=com_osproperty&task=agent_default&Itemid=' . $itemid);
                            ?>
                            <a href="<?php echo $link ?>" alt="<?php echo JText::_("OS_MANAGE_PROPERTIES"); ?>" title="<?php echo JText::_("OS_MANAGE_PROPERTIES"); ?>">
                                <img src="<?php echo JUri::root(); ?>components/com_osproperty/images/assets/agentico.png" alt="<?php echo JText::_("OS_MANAGE_PROPERTIES"); ?>"/>
                                <BR />
                                <p><?php echo JText::_("OS_MANAGE_PROPERTIES"); ?></p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php
                    if (HelperOspropertyCommon::isCompanyAdmin())
                    {
                        ?>
                        <li>
                            <?php
                            $needs = array();
                            $needs[] = "ccompanydetails";
                            $needs[] = "company_edit";
                            $itemid = OSPRoute::getItemid($needs);
                            $link = JRoute::_('index.php?option=com_osproperty&task=company_edit&Itemid=' . $itemid);
                            ?>
                            <a href="<?php echo $link ?>" alt="<?php echo JText::_("OS_MANAGE_PROFILE"); ?>" title="<?php echo JText::_("OS_MANAGE_PROFILE"); ?>">
                                <img src="<?php echo JUri::root(); ?>components/com_osproperty/images/assets/agentico.png" alt="<?php echo JText::_("OS_MANAGE_PROFILE"); ?>"/>
                                <BR />
                                <p><?php echo JText::_("OS_MANAGE_PROFILE"); ?></p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php
                    if (JFactory::getUser()->authorise('frontendmanage', 'com_osproperty'))
                    {
                        ?>
                        <li>
                            <?php
                            $needs = array();
                            $needs[] = "lmanageallproperties";
                            $needs[] = "property_manageallproperties";
                            $itemid = OSPRoute::getItemid($needs);
                            $link = JRoute::_('index.php?option=com_osproperty&view=lmanageallproperties&Itemid=' . $itemid);
                            ?>
                            <a href="<?php echo $link ?>" alt="<?php echo JText::_("OS_MANAGE_PROPERTIES"); ?>" title="<?php echo JText::_("OS_MANAGE_PROPERTIES"); ?>">
                                <img src="<?php echo JUri::root(); ?>components/com_osproperty/images/assets/agentico.png" alt="<?php echo JText::_("OS_MANAGE_PROFILE"); ?>"/>
                                <BR />
                                <p><?php echo JText::_("OS_MANAGE_PROPERTIES"); ?></p>
                            </a>
                        </li>
<?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="pro-graphical">
        <h2>
<?php echo JText::_("OS_LATEST_ACTIVITY"); ?>
        </h2>
        <div class="pro-canvas">
            <canvas class="canvas" id="canvas" height="250"></canvas>
        </div>
        <div class="row-fluid">
            <div class="span6 hit">
                    <?php echo JText::_('OS_HITS') ?>
                <p>
                    <?php
                    if ($row->hits == "")
                    {
                        echo 0;
                    } else
                    {
                        echo $row->hits;
                    }
                    ?>
                </p>
            </div>
            <div class="span6 view">
                    <?php echo JText::_('OS_SAVED') ?>
                <p>
                    <?php
                    if ($row->hits == "")
                    {
                        echo 0;
                    } else
                    {
                        echo $row->saved;
                    }
                    ?>
                </p>

            </div>
        </div>
    </div>
    <div class="clearfix" style="height: 25px;"></div>
    <div class="ranking-property">
        <div class="ranking-top">
            <h2>
<?php echo JText::_('OS_TOP_HITS_LISTING'); ?>
            </h2>
        </div>
        <?php
        echo $row->relate_properties;
        ?>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            var data = {
                labels: ["", "<?php echo strtoupper(JText::_('OS_HITS')); ?>", "<?php echo strtoupper(JText::_('OS_SAVED')); ?>", ""],
                datasets: [
                    {
                        backgroundColor: [
                            'rgb(250, 250, 250)',
                            'rgb(192, 224, 251)',
                            'rgb(79, 202, 0)',
                            'rgb(250, 250, 250)',
                        ],
                        borderWidth: 0,
                        data: [0, <?php echo $row->hits; ?>, <?php echo $row->saved; ?>, 0],
                    }
                ]
            };
            var options = {
                responsive: true,
                scaleBeginAtZero: false,
                barBeginAtOrigin: true
            };
            var myPieChart = new Chart(document.getElementById("canvas").getContext("2d")).Bar(data, options);
        });
    </script>
</div>