<?php
global $mainframe, $jinput, $configClass;
$option = $this->option;
$cat = $this->cat;
$subcats = $this->subcats;
?>
<form method="POST" action="<?php echo JRoute::_('index.php?option=com_osproperty&task=category_details&id=' . $cat->id . '&Itemid=' . $jinput->getInt('Itemid', 0)) ?>" name="ftForm">
    <div class="componentheading">
        <?php echo OSPHelper::getLanguageFieldValue($cat, 'category_name'); ?>
    </div>

    <?php
    if ($configClass['categories_show_description'] == 1)
    {
        ?>
        <div class="row-fluid">
            <div class="span12">
                <?php
                if ($cat->category_image != "")
                {
                    ?>
                    <div class="span3">
                        <img src="<?php echo JURI::root() ?>images/osproperty/category/<?php echo $cat->category_image ?>" class="img-polaroid"/>
                    </div>	
                    <?php
                }
                ?>
                <div class="span9">
                    <?php
                    echo JHtml::_('content.prepare', stripslashes(OSPHelper::getLanguageFieldValue($cat, 'category_description')));
                    ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <?php
    }
    if (($configClass['categories_show_description'] == 1) and ( count($subcats) > 0))
    {
        ?>
        <BR /><BR />
        <div class="block_caption">
            <strong><?php echo JText::_('OS_SUB_CATEGORIES') ?></strong>
        </div>
        <?php
        $number_column = $configClass['category_layout'];
        $widthcount = round(100 / $number_column);
        $j = 0;
        ?>
        <table width="100%" style="border:0px !important;">
            <tr>
                <?php
                for ($i = 0; $i < count($subcats); $i++)
                {
                    $j++;
                    $row = $subcats[$i];
                    $link = JRoute::_('index.php?option=com_osproperty&task=category_details&id=' . $row->id . '&Itemid=' . $jinput->getInt('Itemid', 0));
                    ?>
                    <td width="<?php echo $widthcount ?>%" align="left" style="padding:0px;" valign="top">
                        <strong>
                            <a href="<?php echo $link ?>" title="<?php echo JText::_(OS_CATEGORY_DETAILS) ?>">
                                <?php echo OSPHelper::getLanguageFieldValue($row, 'category_name'); ?> (<?php echo $row->nlisting ?>)
                            </a>
                        </strong>
                        <?php
                        if ($configClass['categories_show_description'] == 1)
                        {
                            //show description
                            echo "<BR />";
                            $desc = strip_tags(stripslashes(OSPHelper::getLanguageFieldValue($row, 'category_description')));
                            $descArr = explode(" ", $desc);
                            if (count($descArr) > 50)
                            {
                                for ($k = 0; $k < 50; $k++)
                                {
                                    echo $descArr[$k] . " ";
                                }
                                echo "...";
                            } else
                            {
                                echo $desc;
                            }
                        }
                        ?>
                    </td>
                    <?php
                    if ($j == $number_column)
                    {
                        echo "</tr><tr>";
                        $j = 0;
                    }
                }
                ?>
            </tr>
        </table>
        <?php
    }
    ?>

    <BR />
    <div class="block_caption">
        <strong><?php echo JText::_('OS_CATEGORY_PROPERTIES') ?></strong>
    </div>
    <?php
    $filterParams = array();
    //show cat
    $filterParams[0] = 0;
    //agent
    $filterParams[1] = 0;
    //keyword
    $filterParams[2] = 1;
    //bed
    $filterParams[3] = 1;
    //bath
    $filterParams[4] = 1;
    //rooms
    $filterParams[5] = 1;
    //price
    $filterParams[6] = 1;
    $category_id = array();
    $category_id[] = $cat->id;
    $property_type = $jinput->getInt('property_type', 0);
    $keyword = OSPHelper::getStringRequest('keyword', '', '');
    $nbed = $jinput->getInt('nbed', '');
    $nbath = $jinput->getString('nbath', '');
    $isfeatured = $jinput->getInt('isfeatured', 0);
    $nrooms = $jinput->getInt('nrooms', '');
    $default_ordering = $configClass['default_sort_properties_by'];
    if ($default_ordering == "")
    {
        $default_ordering = "a.id";
    }
    $default_sorting = $configClass['default_sort_properties_type'];
    if ($default_sorting == "")
    {
        $default_sorting = "desc";
    }
    $orderby = $jinput->getString('orderby', $default_ordering);
    $ordertype = $jinput->getString('ordertype', $default_sorting);
    $limitstart = $jinput->getInt('limitstart', 0);
    $limit = $jinput->getInt('limit', $configClass['general_number_properties_per_page']);
    $favorites = $jinput->getInt('favorites', 0);
    $price = $jinput->getInt('price', 0);
    $country_id = $jinput->getString('country_id', HelperOspropertyCommon::getDefaultCountry());
    $state_id = $jinput->getInt('state_id', 0);
    $city_id = $jinput->getInt('city', 0);
    OspropertyListing::listProperties($option, '', $category_id, '', $property_type, $keyword, $nbed, $nbath, '', 0, $nrooms, $orderby, $ordertype, $limitstart, $limit, '', $price, $filterParams, $city_id, $state_id, $country_id, 0, 0, -1, 0);
    ?>
    <input type="hidden" name="option" value="com_osproperty" /> 
    <input type="hidden" name="task" value="category_details" />
    <input type="hidden" name="Itemid" value="<?php echo $jinput->getInt('Itemid', 0) ?>" />
    <input type="hidden" name="id" value="<?php echo $cat->id ?>" />
</form>