<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$option = $this->option;
$row = $property = $this->property;
$configs = $this->configs;
$owner = $this->owner;

global $mainframe, $jinput, $configClass, $ismobile, $lang_suffix, $languages;
$db = JFactory::getDbo();
$document = JFactory::getDocument();
//$document->addScript(JURI::root()."components/com_osproperty/js/counter.js");
$document->addScript(JURI::root() . "/components/com_osproperty/js/ajax.js");
$themename = OSPHelper::getThemeName();
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
                } else if (temp1 == "request_security_code") {
                    var captcha_str = document.getElementById('captcha_str');
                    captcha_str = captcha_str.value;
                    if (captcha_str != temp2.value) {
                        alert("<?php echo JText::_('OS_SECURITY_CODE_IS_WRONG') ?>");
                        temp2.focus();
                        cansubmit = 0;
                        return false;
                    }
<?php
if ($configClass['request_term_condition'] == 1)
{
    ?>
                        if (document.getElementById('termcondition').checked == false) {
                            alert(" <?php echo JText::_('OS_PLEASE_AGREE_WITH_OUT_TERM_AND_CONDITION') ?>");
                            document.getElementById('termcondition').focus();
                            cansubmit = 0;
                            return false;
                        }
    <?php
}
?>
                } else if (temp1 == "sharing_security_code") {
                    var captcha_str = document.getElementById('captcha_str');
                    captcha_str = captcha_str.value;
                    if (captcha_str != temp2.value) {
                        alert("<?php echo JText::_('OS_SECURITY_CODE_IS_WRONG') ?>");
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
$session = JFactory::getSession();
$url = $session->get('advurl');
?>
<form method="GET" action="<?php echo $url; ?>" id="subform" name="subform">
    <input type="hidden" name="option" value="com_osproperty" />
</form>
<?php
echo HelperOspropertyCommon::buildToolbar('property');
//location
$location = "";
if ($row->show_address == 1)
{
    ob_start();
    ?>
    <table  width="100%">
        <tr>
            <td class="left_details_col" style="">
                <?php echo JText::_('OS_ADDRESS') ?>
            </td>
            <?php
            if ($ismobile)
            {
                echo "</tr><tr>";
            }
            ?>
            <td class="right_details_col" style="">
                <?php
                echo OSPHelper::generateAddress($row);
                ?>
            </td>
        </tr>
    </table>
    <?php
    $location = ob_get_contents();
    ob_end_clean();
}
$row->location = $location;
//end location
//property information
ob_start();
?>
<table  width="100%">
    <?php
    if ($row->ref != "")
    {
        ?>
        <tr>
            <td class="left_details_col" style="">
                <?php echo JText::_('Ref #') ?>
            </td>
            <td class="right_details_col" style="">
                <strong><?php echo $row->ref; ?></strong>
            </td>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td class="left_details_col" style="">
            <?php echo JText::_('OS_TITLE') ?>
        </td>
        <td class="right_details_col" style="">
            <strong><?php echo OSPHelper::getLanguageFieldValue($row, 'pro_name'); ?></strong>
        </td>
    </tr>
    <tr>
        <td class="left_details_col">
            <?php echo JText::_('OS_CATEGORY') ?>
        </td>
        <td class="right_details_col">
            <a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=category_details&id=' . $row->category_id) ?>" title="<?php echo OSPHelper::getLanguageFieldValue($row, 'category_name'); ?>">
                <?php echo OSPHelper::getLanguageFieldValue($row, 'category_name'); ?>
            </a>
        </td>
    </tr>
    <?php
    if ($row->type_name != "")
    {
        ?>
        <tr>
            <td class="left_details_col" style="">
                <?php echo JText::_('OS_PROPERTY_TYPE') ?>
            </td>
            <td class="right_details_col" style="">
                <a href="<?php echo JRoute::_("index.php?option=com_osproperty&task=property_type&type_id=" . $row->pro_type); ?>">
                    <?php echo OSPHelper::getLanguageFieldValue($row, 'type_name'); ?>
                </a>
            </td>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td class="left_details_col">
            <?php echo JText::_('OS_FEATURED') ?>
            <?php
            if (!$ismobile)
            {
                ?>
            </td>
            <td class="right_details_col">
            <?php } ?>
            <span style="font-weight:normal;">
                <?php
                if ($row->isFeatured == 1)
                {
                    echo JText::_('OS_YES');
                } else
                {
                    echo JText::_('OS_NO');
                }
                ?>
            </span>
        </td>
    </tr>
    <?php
    if ($row->rent_time != "")
    {
        ?>
        <tr>
            <td class="left_details_col" style="">
                <?php echo JText::_('OS_RENT_TIME_FRAME') ?>
                <span style="font-weight:normal;">
                    <?php echo JText::_($row->rent_time); ?>
                </span>
            </td>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td class="left_details_col" style="">
            <?php echo JText::_('OS_DESCRIPTION') ?>
        </td>
        <td class="right_details_col" style="">
            <?php echo OSPHelper::getLanguageFieldValue($row, 'pro_small_desc'); ?>
            <BR />
            <?php
            $row->pro_full_desc = JHtml::_('content.prepare', $row->pro_full_desc);
            echo stripslashes(OSPHelper::getLanguageFieldValue($row, 'pro_full_desc'));
            ?>
        </td>
    </tr>
    <?php
    if ($configClass['energy'] == 1)
    {
        if (($row->energy > 0) or ( $row->climate > 0))
        {
            if ($row->energy == "0.00")
            {
                $row->energy = "null";
            }
            if ($row->climate == "0.00")
            {
                $row->climate = "null";
            }
            ?>
            <tr>
                <td class="left_details_col" style="">
                    <?php echo JText::_('OS_DPE') ?>
                </td>
                <td class="right_details_col" style="">
                    <?php
                    echo HelperOspropertyCommon::drawGraph($row->energy, $row->climate);
                    ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    <?php
    if (($row->note != "") and ( HelperOspropertyCommon::isOwner($row->id)))
    {
        ?>
        <tr>
            <td class="left_details_col">
                <?php echo JText::_('OS_NOTE') ?>
            </td>
            <td class="right_details_col">
                <?php echo $row->note; ?>
            </td>
        </tr>
        <?php
    }
    if (($row->pro_pdf != "") or ( $row->pro_pdf_file != ""))
    {
        ?>
        <tr>
            <td class="left_details_col" style="">
                <?php echo JText::_('OS_PROPERTY_DOCUMENT') ?>
            </td>
            <?php
            if ($ismobile)
            {
                echo "</tr><tr>";
            }
            ?>
            <td class="right_details_col" style="">

                <?php
                if ($row->pro_pdf != "")
                {
                    ?>
                    <a href="<?php echo $row->pro_pdf ?>" title="<?php echo JText::_('OS_PROPERTY_DOCUMENT') ?>" alt="<?php echo JText::_('OS_PROPERTY_DOCUMENT') ?>" target="_blank">
                        <img src="<?php echo JURI::root() . "components/com_osproperty/images/assets"; ?>/pdf.png" />
                    </a>
                    &nbsp;&nbsp;
                    <?php
                }
                ?>
                <?php
                if ($row->pro_pdf_file != "")
                {
                    ?>
                    <a href="<?php echo JURI::root() . "components/com_osproperty/document/"; ?><?php echo $row->pro_pdf_file ?>" title="<?php echo JText::_('OS_PROPERTY_DOCUMENT') ?>" alt="<?php echo JText::_('OS_PROPERTY_DOCUMENT') ?>" target="_blank">
                        <img src="<?php echo JURI::root() . "components/com_osproperty/images/assets"; ?>/pdf.png" />
                    </a>
                    <?php
                }
                ?>
            </td>
        </tr>
        <?php
    }
    if ($configClass['listing_show_view'] == 1)
    {
        ?>
        <tr>
            <td class="left_details_col">
                <?php echo JText::_('OS_TOTAL_VIEWING') ?>

            </td>
            <td class="right_details_col">

                <span style="font-weight:normal;"><?php echo $row->hits; ?></span>
            </td>
        </tr>
        <?php
    }
    if ($configClass['listing_show_rating'] == 1)
    {
        ?>
        <tr>
            <td class="left_details_col" style="">
                <?php echo JText::_('OS_RATE') ?>

            </td>
            <td class="right_details_col" style="">
                <?php
                if ($row->number_votes > 0)
                {
                    $points = round($row->total_points / $row->number_votes);
                    ?>
                    <img src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/star-<?php echo $points; ?>.jpg" />
                    <?php
                } else
                {
                    ?>
                    <img src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/star-0.png" />
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
$info = ob_get_contents();
ob_end_clean();
$row->info = $info;
//property information END

ob_start();
if ($row->number_votes > 0)
{
    $points = round($row->total_points / $row->number_votes);
    ?>
    <img src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/stars-<?php echo $points; ?>.png" />	
    <?php
} else
{
    ?>
    <img src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/stars-0.png" />	
    <?php
}
$ratingvalue = ob_get_contents();
ob_end_clean();
$row->ratingvalue = $ratingvalue;
if ($row->number_votes > 0)
{
    $rate = round($row->total_points / $row->number_votes, 2);
    if ($rate <= 1)
    {
        $row->cmd = JText::_('OS_POOR');
    } elseif ($rate <= 2)
    {
        $row->cmd = JText::_('OS_BAD');
    } elseif ($rate <= 3)
    {
        $row->cmd = JText::_('OS_AVERGATE');
    } elseif ($rate <= 4)
    {
        $row->cmd = JText::_('OS_GOOD');
    } elseif ($rate <= 5)
    {
        $row->cmd = JText::_('OS_EXCELLENT');
    }
    $row->rate = $rate;
} else
{
    $row->rate = '';
    $row->cmd = JText::_('OS_NOT_SET');
}
//price

$allCurrencies = HelperOspropertyCommon::loadAllCurrencies();
$currencies = array();
if (!empty($allCurrencies))
{
    foreach ($allCurrencies as $one)
    {
        $t = new stdClass();
        $t->value = $one->id;
        $t->text = $one->currency_code;
        $currencies[] = $t;
    }
}




$currenyArr[] = JHTML::_('select.option', '', JText::_('OS_SELECT'));
$currenyArr = array_merge($currenyArr, $currencies);
if ($themename == "default")
{
    $show_price_text = 1;
} else
{
    $show_price_text = 0;
}
$lists['curr'] = JHTML::_('select.genericlist', $currenyArr, 'curr', 'onChange="javascript:convertCurrency(' . $row->id . ',this.value,' . $show_price_text . ')" class="input-small"', 'value', 'text', $row->curr);
$lists['curr_default'] = JHTML::_('select.genericlist', $currenyArr, 'curr', 'onChange="javascript:convertCurrencyDefault(' . $row->id . ',this.value,' . $show_price_text . ')" class="input-small"', 'value', 'text', $row->curr);


//featured
ob_start();
?>
<table  width="100%">
    <?php
    if ($configClass['use_rooms'] == 1)
    {
        ?>
        <tr>
            <td class="left_details_col" style="width:50%">
                <?php echo JText::_('OS_NUMBER_ROOMS') ?>
            </td>
            <td class="right_details_col" style="width:50%">
                <strong><?php echo $row->rooms; ?></strong>
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
            <td class="left_details_col" style="">
                <?php echo JText::_('OS_BEDROOM') ?>
            </td>
            <td class="right_details_col" style="">
                <?php echo $row->bed_room; ?>
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
            <td class="left_details_col">
                <?php echo JText::_('OS_BATHROOM') ?>
            </td>
            <td class="right_details_col">
                <?php echo OSPHelper::showBath($row->bath_room); ?>
            </td>
        </tr>
        <?php
    }
    ?>
    <?php
    if ($configClass['use_parking'] == 1)
    {
        ?>
        <tr>
            <td class="left_details_col" style="">
                <?php echo JText::_('OS_PARKING') ?>
            </td>
            <td class="right_details_col" style="">
                <?php echo $row->parking; ?>
            </td>
        </tr>
        <?php
    }
    ?>
    <?php
    if ($configClass['use_squarefeet'] == 1)
    {
        ?>
        <tr>
            <td class="left_details_col">
                <?php echo OSPHelper::showSquareLabels(); // JText::_('OS_SQUARE_FEET')   ?>
            </td>
            <td class="right_details_col">
                <?php echo OSPHelper::showSquare($row->square_feet); ?>
            </td>
        </tr>
        <?php
    }
    ?>
    <?php
    if ($configClass['use_nfloors'] == 1)
    {
        ?>
        <tr>
            <td class="left_details_col" style="">
                <?php echo JText::_('OS_NUMBER_OF_FLOORS') ?>
            </td>
            <td class="right_details_col" style="">
                <?php echo $row->number_of_floors; ?>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
<?php
$featured = ob_get_contents();
ob_end_clean();
$row->featured = $featured;
//end featured
//collect agent information
//photo
$allowedExt = array('jpg', 'jpeg', 'gif', 'png');
if ($configClass['show_agent_image'] == 1)
{
    ob_start();
    $agent_photo = $row->agent->photo;
    $agent_photo_array = explode(".", $agent_photo);
    $ext = $agent_photo_array[count($agent_photo_array) - 1];
    if (($agent_photo != "") and ( in_array(strtolower($ext), $allowedExt)))
    {
        ?>
        <img src="<?php echo JURI::root() ?>images/osproperty/agent/<?php echo $row->agent->photo ?>" width="60" />
        <?php
    } else
    {
        ?>

        <img src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/user.jpg" style="border:1px solid #CCC;" width="60" />
        <?php
    }
    $photo = ob_get_contents();
    ob_end_clean();
    $row->agentphoto = $photo;
}

$row->agent_name = $row->agent->name;
$row->agent_phone = $row->agent->phone;
$row->agent_mobile = $row->agent->mobile;

//agent
ob_start();
?>
<div style="float:left;">
    <div class="row-fluid">
        <div class="span12">
            <table width="100%" style="border-collapse:separate;border:0px !important;">
                <?php
                if ($configClass['show_agent_image'] == 1)
                {
                    ?>
                    <tr>
                        <td class="left_details_col" valign="top" style="width:40%">
                            <?php
                            if ($row->agent->agent_type == 0)
                            {
                                echo JText::_('OS_AGENT_PHOTO');
                            } else
                            {
                                echo JText::_('OS_OWNER_PHOTO');
                            }
                            ?>
                        </td>
                        <td class="right_details_col" style="width:60%">
                            <?php
                            $agent_photo = $row->agent->photo;
                            $agent_photo_array = explode(".", $agent_photo);
                            $ext = $agent_photo_array[count($agent_photo_array) - 1];
                            if (($agent_photo != "") and ( in_array(strtolower($ext), $allowedExt)))
                            {
                                ?>
                                <img src="<?php echo JURI::root() ?>images/osproperty/agent/<?php echo $row->agent->photo ?>" width="100" />
                                <?php
                            } else
                            {
                                ?>

                                <img src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/user.jpg" style="border:1px solid #CCC;" width="100" />
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td class="left_details_col" style="">
                        <?php echo JText::_('OS_NAME') ?>
                    </td>
                    <td class="right_details_col" style="">
                        <strong><?php echo $row->agent->name; ?></strong>
                    </td>
                </tr>
                <?php
                if ($configClass['show_agent_address'] == 1)
                {
                    ?>
                    <tr>
                        <td class="left_details_col">
                            <?php echo JText::_('OS_ADDRESS') ?>
                        </td>
                        <td class="right_details_col">
                            <?php echo $row->agent->address; ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="left_details_col" style="">
                            <?php echo JText::_('OS_STATE') ?>
                        </td>
                        <td class="right_details_col" style="">
                            <?php echo $row->agent->state_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="left_details_col">
                            <?php echo JText::_('OS_COUNTRY') ?>
                        </td>
                        <td class="right_details_col">
                            <?php echo $row->agent->country_name; ?>
                        </td>
                    </tr>
                    <?php
                }
                if ($configClass['show_license'] == 1)
                {
                    ?>
                    <tr>
                        <td class="left_details_col" style="">
                            <?php echo JText::_('OS_LICENSE') ?>
                        </td>
                        <td class="right_details_col" style="">
                            <?php echo $row->agent->license; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>
<div style="float:left;">
    <div class="row-fluid">
        <div class="span12">
            <table  width="100%" style="border-collapse:separate;border:0px !important;">
                <?php
                if (($row->agent->phone != "") and ( $configClass['show_agent_phone'] == 1))
                {
                    ?>
                    <tr>
                        <td class="left_details_col" style="">
                            <div class="agent_phone" style="width:100px;">
                                <strong><?php echo JText::_('OS_PHONE') ?>:</strong>
                            </div>
                        </td>
                        <td class="right_details_col" style="">
                            <?php echo $row->agent->phone; ?>
                        </td>
                    </tr>
                    <?php
                }
                if (($row->agent->mobile != "") and ( $configClass['show_agent_mobile'] == 1))
                {
                    ?>
                    <tr>
                        <td class="left_details_col">
                            <div class="agent_mobile" style="width:100px;">
                                <strong><?php echo JText::_('OS_MOBILE') ?>:</strong>
                            </div>
                        </td>
                        <td class="right_details_col">
                            <?php echo $row->agent->mobile; ?>
                        </td>
                    </tr>
                    <?php
                }
                if (($row->agent->fax != "")and ( $configClass['show_agent_fax'] == 1))
                {
                    ?>
                    <tr>
                        <td class="left_details_col" style="">
                            <div class="agent_fax" style="width:100px;">
                                <strong><?php echo JText::_('OS_FAX') ?>:</strong>
                            </div>
                        </td>
                        <td class="right_details_col" style="">
                            <?php echo $row->agent->fax; ?>
                        </td>
                    </tr>
                    <?php
                }
                if (($row->agent->gtalk != "")and ( $configClass['show_agent_gtalk'] == 1))
                {
                    ?>
                    <tr>
                        <td class="left_details_col" style="">
                            <div class="agent_gtalk" style="width:100px;">
                                <strong><?php echo JText::_('OS_GTALK') ?>:</strong>
                            </div>
                        </td>
                        <td class="right_details_col" style="">
                            <?php echo $row->agent->gtalk; ?>
                        </td>
                    </tr>
                    <?php
                }
                if (($row->agent->skype != "")and ( $configClass['show_agent_skype'] == 1))
                {
                    ?>
                    <tr>
                        <td class="left_details_col">
                            <div class="agent_skype" style="width:100px;">
                                <strong><?php echo JText::_('OS_SKYPE') ?>:</strong>
                            </div>
                        </td>
                        <td class="right_details_col">
                            <?php echo $row->agent->skype; ?>
                        </td>
                    </tr>
                    <?php
                }
                if (($row->agent->msn != "")and ( $configClass['show_agent_msn'] == 1))
                {
                    ?>
                    <tr>
                        <td class="left_details_col" style="">
                            <div class="agent_msn" style="width:100px;">
                                <strong><?php echo JText::_('Line') ?>:</strong>
                            </div>
                        </td>
                        <td class="right_details_col" style="">
                            <?php echo $row->agent->msn; ?>
                        </td>
                    </tr>
                    <?php
                }
                if (($row->agent->facebook != "")and ( $configClass['show_agent_facebook'] == 1))
                {
                    ?>
                    <tr>
                        <td class="left_details_col">
                            <div class="agent_facebook" style="width:100px;">
                                <strong><?php echo JText::_('OS_FACEBOOK') ?>:</strong>
                            </div>
                        </td>
                        <td class="right_details_col">
                            <a href="<?php echo $row->agent->facebook; ?>" target="_blank"><?php echo $row->agent->facebook; ?></a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row-fluid">
    <div class="span12">
        <?php
        $link = JRoute::_("index.php?option=com_osproperty&task=agent_info&id=" . $row->agent_id . "&Itemid=" . OSPRoute::getAgentItemid());
        ?>
        <a href="<?php echo $link ?>">
            <?php echo JText::_('OS_LISTING') ?> (<?php echo $row->agent->countlisting ?>)
        </a>

        &nbsp;|&nbsp;
        <a href="<?php echo $link ?>">
            <?php
            if ($row->agent->agent_type == 0)
            {
                ?>
                <?php echo JText::_('OS_AGENT_INFO') ?>
                <?php
            } else
            {
                echo JText::_('OS_OWNER_INFO');
            }
            ?>
        </a>
        <?php
        if ($configClass['show_agent_contact'] == 1)
        {
            ?>
            &nbsp;|&nbsp;
            <a href="<?php echo $link ?>">
                <?php
                if ($row->agent->agent_type == 0)
                {
                    ?>
                    <?php echo JText::_('OS_CONTACT_AGENT'); ?>
                    <?php
                } else
                {
                    echo JText::_('OS_CONTACT_OWNER');
                }
                ?>
            </a>
            <?php
        }
        ?>
    </div>
</div>
<?php
$agent = ob_get_contents();
ob_end_clean();
$row->agenttype = $row->agent->agent_type;
$row->agent = $agent;

//end featured

ob_start();
if (count($row->comments) > 0)
{
    $comments = $row->comments;
    ?>
    <div class="row-fluid">
        <div class="span12">
            <table  width="100%" style="border-collapse:separate;border:0px !important;">
                <tr>
                    <td width="100%" style="padding:0px;">
                        <div class="block_caption">
                            <strong><?php echo JText::_('OS_COMMENTS') ?></strong>
                        </div>
                    </td>
                </tr>
                <?php
                for ($i = 0; $i < count($comments); $i++)
                {
                    $comment = $comments[$i];
                    ?>
                    <tr>
                        <td width="100%" align="left" valign="top" style="padding:0px;padding-bottom:20px;background:url(<?php echo JURI::root() ?>components/com_osproperty/images/assets/bg_content.gif);background-repeat:repeat-x;">
                            <div class="row-fluid">
                                <div class="span12">
                                    <img src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/stars-<?php echo $comment->rate; ?>.png" />
                                    &nbsp;
                                    <strong><?php echo $comment->title ?></strong>
                                    <?php
                                    if ((JFactory::getUser()->id == $comment->user_id) and ( $configClass['allow_edit_comment'] == 1))
                                    {
                                        ?>
                                        <a href="<?php echo JUri::root() ?>index.php?option=com_osproperty&task=property_editcomment&id=<?php echo $comment->id; ?>&tmpl=component" class="osmodal" rel="{handler: 'iframe', size: {x: 500, y: 500}}" title="<?php echo JText::_('OS_EDIT_YOUR_COMMENT'); ?>"><i class="osicon-edit"></i></a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <?php
                                    echo nl2br($comment->content);
                                    ?>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <?php echo JText::_('OS_AUTHOR') ?>: <strong><?php echo $comment->name ?></strong>
                                    <?php
                                    if (file_exists(JPATH_ROOT . '/media/com_osproperty/flags/' . $comment->country . '.png'))
                                    {
                                        ?>
                                        <img src="<?php echo JURI::root() ?>media/com_osproperty/flags/<?php echo $comment->country ?>.png"/>
                                        <?php
                                    }
                                    ?>
                                    &nbsp;|
                                    &nbsp;
                                    <?php echo JText::_("OS_POST_DATE") ?>: <strong><?php echo HelperOspropertyCommon::loadTime($comment->created_on, $configClass['general_date_format']); ?></strong>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
    <?php
} else
{
    ?>
    <div style="text-align:center;padding:5px;">
        <?php echo JText::_('OS_THERE_ARE_NO_COMMENT_THERE'); ?>
    </div>
    <?php
}
$comments = ob_get_contents();
ob_end_clean();
$row->comments = $comments;

$socialUrl = JRoute::_("index.php?option=com_osproperty&task=property_details&id=$row->id");
$firstChar = substr($url, 0, 1);
if ($firstChar == "/")
{
    $socialUrl = substr($socialUrl, 1);
}
$socialUrl = JURI::root() . $socialUrl;

ob_start();
if ($configClass['social_sharing'] == 1)
{
    ?>
    <div id="itp-social-buttons-box">
        <div id="eb_share_button">
            <?php
            $title = "";
            if ($row->ref != "")
            {
                $title = $row->ref . ", ";
            }

            $title.= OSPHelper::getLanguageFieldValue($row, 'pro_name');
            $html = HelperOspropertyCommon::getDeliciousButton($title, $socialUrl);
            $html .= HelperOspropertyCommon::getDiggButton($title, $socialUrl);
            $html .= HelperOspropertyCommon::getFacebookButton($title, $socialUrl);
            $html .= HelperOspropertyCommon::getGoogleButton($title, $socialUrl);
            $html .= HelperOspropertyCommon::getStumbleuponButton($title, $socialUrl);
            $html .= HelperOspropertyCommon::getTechnoratiButton($title, $socialUrl);
            $html .= HelperOspropertyCommon::getTwitterButton($title, $socialUrl);
            echo $html;
            ?>
        </div>
        <div style="clear: both;">&nbsp;</div>
    </div>		
    <div style="clear: both;">&nbsp;</div>
    <!-- End social sharing -->
    <?php
}
$share = ob_get_contents();
ob_end_clean();
$row->share = $share;

$db = JFactory::getDbo();
$query = "Select count(a.id)from #__osrs_neighborhood as a"
        . " inner join #__osrs_neighborhoodname as b on b.id = a.neighbor_id"
        . " where a.pid = '$row->id'";
$db->setQuery($query);
$count_neighborhood = $db->loadResult();
if ($count_neighborhood > 0)
{
    ob_start();
    HelperOspropertyCommon::loadNeighborHood($row->id);
    $neighborhood = ob_get_contents();
    ob_end_clean();
    $row->neighborhood = $neighborhood;

    ob_start();
    HelperOspropertyCommon::loadNeighborHood1($row->id);
    $neighborhood1 = ob_get_contents();
    ob_end_clean();
    $row->neighborhood1 = $neighborhood1;
} else
{
    $row->neighborhood = "";
}
//Google map
ob_start();
$geocode = array();
$geocode[0]->lat = $row->lat_add;
$geocode[0]->long = $row->long_add;
$geocode[0]->text = OSPHelper::getLanguageFieldValue($row, 'pro_name');
HelperOspropertyGoogleMap::loadGoogleMap($geocode, "map", "");
$google_header_js = ob_get_contents();
ob_end_clean();
$row->google_header_js = $google_header_js;

//Random string
$RandomStr = md5(microtime()); // md5 to generate the random string
$ResultStr = substr($RandomStr, 0, 5); //trim 5 digit 
$row->ResultStr = $ResultStr;

$row->relate = "";
jimport('joomla.filesystem.file');

if ((isset($configClass['relate_properties']) && $configClass['relate_properties'] == 1) and ( !empty($row->relate_properties) && count($row->relate_properties) > 0))
{
    ob_start();
    $relates = $row->relate_properties;
    if (JFile::exists(JPATH_ROOT . '/templates/' . $mainframe->getTemplate() . '/html/com_osproperty/layouts/relateproperties.php'))
    {
        $tpl = new OspropertyTemplate(JPATH_ROOT . '/templates/' . $mainframe->getTemplate() . '/html/com_osproperty/layouts/');
    } else
    {
        $tpl = new OspropertyTemplate(JPATH_COMPONENT . '/helpers/layouts/');
    }
    $tpl->set('mainframe', $mainframe);
    $tpl->set('relates', $relates);
    $tpl->set('configClass', $configClass);
    $tpl->set('title', JText::_('OS_RELATE_PROPERTIES'));
    echo $tpl->fetch("relateproperties.php");
    $relate = ob_get_contents();
    ob_end_clean();
    $row->relate = $relate;
}
if (($configClass['relate_property_type'] == 1) and ( count($row->relate_type_properties) > 0))
{
    ob_start();
    $relates = $row->relate_type_properties;
    if (JFile::exists(JPATH_ROOT . '/templates/' . $mainframe->getTemplate() . '/html/com_osproperty/layouts/relateproperties.php'))
    {
        $tpl = new OspropertyTemplate(JPATH_ROOT . '/templates/' . $mainframe->getTemplate() . '/html/com_osproperty/layouts/');
    } else
    {
        $tpl = new OspropertyTemplate(JPATH_COMPONENT . '/helpers/layouts/');
    }
    $tpl->set('mainframe', $mainframe);
    $tpl->set('relates', $relates);
    $tpl->set('configClass', $configClass);
    $tpl->set('title', JText::_('OS_PROPERTIES_SAME_TYPES'));
    echo $tpl->fetch("relateproperties.php");
    $relate = ob_get_contents();
    ob_end_clean();
    $row->relate .= $relate;
}

if ($configClass['show_walkscore'] == 1)
{
    if ($configClass['ws_id'] != "")
    {
        ob_start();

        $address = $row->address;
        $address .= " " . HelperOspropertyCommon::loadCityName($row->city);
        if ($row->postcode != "")
        {
            $address .= " " . $row->postcode;
        }
        $address .= " " . $row->state_name;
        $address .= " " . $row->country_name;

        $latitude = $row->lat_add;
        $longitude = $row->long_add;
        ?>
        <script type='text/javascript'>
            var ws_wsid = '<?php echo $configClass['ws_id']; ?>';
            var ws_address = '<?php echo urlencode($address); ?>';
            var ws_lat = '<?php echo $latitude; ?>';
            var ws_lon = '<?php echo $longitude; ?>';
            var ws_height = '<?php echo $configClass['ws_height']; ?>';
        <?php
        if ($ismobile)
        {
            ?>
                var ws_width = '230';
                var ws_layout = 'vertical';
            <?php
        } else
        {
            ?>
                var ws_width = '<?php echo $configClass['ws_width']; ?>';
                var ws_layout = 'horizontal';
            <?php
        }
        ?>
            var ws_distance_units = '<?php echo $configClass['ws_unit']; ?>';
        </script>
        <style type='text/css'>
            #ws-walkscore-tile{position:relative;text-align:left}
            #ws-walkscore-tile *{float:none;}
            #ws-footer a,#ws-footer a:link{font:11px Verdana,Arial,Helvetica,sans-serif;margin-right:6px;white-space:nowrap;padding:0;color:#000;font-weight:bold;text-decoration:none}
            #ws-footer a:hover{color:#777;text-decoration:none}
            #ws-footer a:active{color:#b14900}
        </style>
        <div id='ws-walkscore-tile'>
            <div id='ws-footer' style='position:absolute;top:268px;left:8px;width:588px'>
                <form id='ws-form'>
                    <a id='ws-a' href='www.walkscore.com/' target='_blank'>Find out your home's Walk Score:</a>
                    <input type='text' id='ws-street' style='position:absolute;top:0px;left:225px;width:331px' />
                    <input type='image' id='ws-go' src='http://www2.walkscore.com/images/tile/go-button.gif' height='15' width='22' border='0' alt='get my Walk Score' style='position:absolute;top:0px;right:0px' />
                </form>
            </div>
        </div>
        <script type='text/javascript' src='http://www.walkscore.com/tile/show-walkscore-tile.php'></script>
        <?php
        $walked_score = ob_get_contents();
        ob_end_clean();
        $row->ws = $walked_score;
    }
}

$db = JFactory::getDbo();
$db->setQuery("Select * from #__osrs_photos where pro_id = '$row->id' and image <> '' order by ordering");
$photos = $db->loadObjectList();

$user = JFactory::getUser();
$can_add_cmt = 0;

if ($configClass['comment_active_comment'] == 1)
{
    $can_add_cmt = 1;
}
if ($configClass['registered_user_write_comment'] == 1)
{
    if ($user->id > 0)
    {
        $db->setQuery("Select count(id) from #__osrs_comments where pro_id = '$row->id' and user_id = '$user->id'");
        $already_add_comment = $db->loadResult();
        if ($already_add_comment > 0)
        {
            if ($configClass['only_one_review'] == 1)
            {
                $can_add_cmt = 0;
            } else
            {
                $can_add_cmt = 1;
            }
        } else
        {
            $can_add_cmt = 1;
        }
    } else
    {
        $can_add_cmt = 0;
    }
}
//add google map
$db->setQuery("Select type_icon from #__osrs_types where id = '$row->pro_type'");
$type_icon = $db->loadResult();
if ($type_icon == "")
{
    $type_icon = "1.png";
}
$map_house_icon = '/components/com_osproperty/images/assets/googlemapicons/' . $type_icon;

if ($configClass['goole_aip_key'] != "")
{
    $key = "&key=" . $configClass['goole_aip_key'];
} else
{
    $key = "";
}

$document = JFactory::getDocument();
$document->addScript('//maps.google.com/maps/api/js?libraries=places&sensor=false' . $key);
$gscript = '
	            var map;
	            window.addEvent("domready", function(){
	            	';
for ($i = 0; $i < count($photos); $i++)
{
    $gscript .= ' 
	            	$$("#thumb' . $i . '").addEvent("click", function(e){
						';
    for ($j = 0; $j < count($photos); $j++)
    {
        if ($j != $i)
        {
            $gscript .= '$$("#img' . $j . '").hide();';
        }
    }
    $gscript .= '$$("#img' . $i . '").show();';
    $gscript .= '
					});';
}
$google_map_overlay = $configClass['goole_map_overlay'];
if ($google_map_overlay == "")
{
    $google_map_overlay = "ROADMAP";
}
$google_map_resolution = $configClass['goole_map_resolution'];
if ($google_map_resolution == 0)
{
    $google_map_resolution = 15;
    $population = 150;
} elseif (($google_map_resolution > 0) and ( $google_map_resolution <= 5))
{
    $population = 400000;
} elseif (($google_map_resolution > 5) and ( $google_map_resolution <= 10))
{
    $population = 2000;
} elseif (($google_map_resolution > 10) and ( $google_map_resolution <= 15))
{
    $population = 150;
} else
{
    $population = 100;
}


$gscript .= ' 
                var zoom = ' . $google_map_resolution . ';
                var ipbaseurl = "' . JURI::root(true) . '";
                var coord = new google.maps.LatLng(' . $row->lat_add . ', ' . $row->long_add . ');
                var citymap = {};
			    citymap["chicago"] = {
			       center: new google.maps.LatLng(' . $row->lat_add . ', ' . $row->long_add . '),population: ' . $population . '
			    };
                var icon_url = ipbaseurl+"' . $map_house_icon . '";
                var streetview = new google.maps.StreetViewService();

                var mapoptions = {
                                    zoom: zoom,
                                    center: coord,
                                    //draggable: false,
                                    mapTypeControl: true,
                                    navigationControl: true,
                                    streetViewControl: false,
                                    mapTypeId: google.maps.MapTypeId.' . $google_map_overlay . ',
                                    maxZoom: 21
                                }

                map = new google.maps.Map($("map_canvas"), mapoptions);
				';
if ($row->show_address == 1)
{
    $gscript .= ' 
	                var marker  = new google.maps.Marker({
	                    position: coord,
	                    visible: true,
	                    flat: true,
	                    clickable: false,
	                    map: map,
	                    icon: icon_url
	                });
	                ';
} else
{
    $gscript .= ' 
	                for (var city in citymap) {
			    	    var populationOptions = {
			    	      strokeColor: "#FF0000",
			    	      strokeOpacity: 0.8,
			    	      strokeWeight: 2,
			    	      fillColor: "#FF0000",
			    	      fillOpacity: 0.35,
			    	      map: map,
			    	      center: citymap[city].center,
			    	      radius: Math.sqrt(citymap[city].population) * 100
			    	    };
			    	    // Add the circle for this city to the map.
			    	    cityCircle = new google.maps.Circle(populationOptions);
			    	  }
        ';
}

$gscript .= '
                $$("#agooglemap").addEvent("click", function(e){
                    setTimeout(function() {
                        google.maps.event.trigger(map, "resize");
                        map.setZoom( map.getZoom() );
                        map.setCenter(coord);
                    }, (10));
                });';
if ($configClass['show_streetview'] == 1)
{
    $gscript .= '
                    var panoramaElement = $("pano");
                        streetview.getPanoramaByLocation(coord, 25, function(data, status){
                            switch(status){
                                case google.maps.StreetViewStatus.OK:
                                    $$("#astreetview").addEvent("click", function(e){
                                        setTimeout(function() {
                                            var panorama = new google.maps.StreetViewPanorama(panoramaElement, {
                                                position: coord
                                            });
                                            google.maps.event.trigger(panorama, "resize");
                                        }, (10));
                                    });
                                    break;
                                case google.maps.StreetViewStatus.ZERO_RESULTS:
                                    $$("#astreetview").setStyle("display", "none");
                                    break;
                                default:
                                    $$("#astreetview").setStyle("display", "none");
                            }
                        }); ';
}
$gscript .= '
            });';

if ($themename == "default")
{
    $document->addScriptDeclaration($gscript);
}

if ($configClass['show_gallery_tab'] == 1)
{
    ob_start();
    ?>
    <?php
    HelperOspropertyCommon::slimboxGallery($row->id, $photos);
    ?>
    <?php
    $gallery = ob_get_contents();
    ob_end_clean();
} else
{
    $gallery = "";
}

$row->gallery = $gallery;


//get subtitle
if ($row->show_address == 1)
{
    $row->subtitle = OSPHelper::generateAddress($row);
} else
{
    $addInfo = array();
    $addInfo1 = array();
    if (($row->price > 0) and ( $row->price_call == 0))
    {
        $addInfo1[] = OSPHelper::generatePrice($row->curr, $row->price);
    }
    if (($row->bed_room > 0) and ( $configClass['use_bedrooms'] == 1))
    {
        $addInfo[] = $row->bed_room . " " . JText::_('OS_BEDROOMS');
    }
    if (($row->bath_room > 0) and ( $configClass['use_bathrooms'] == 1))
    {
        $addInfo[] = OSPHelper::showBath($row->bath_room) . " " . JText::_('OS_BATHROOMS');
    }
    if (($row->rooms > 0) and ( $configClass['use_rooms'] == 1))
    {
        $addInfo[] = $row->rooms . " " . JText::_('OS_ROOMS');
    }
    if (($row->square_feet > 0) and ( $configClass['use_squarefeet'] == 1))
    {
        $addInfo[] = $row->square_feet . " " . OSPHelper::showSquareSymbol();
    }
    $addInfo1[] = implode(", ", $addInfo);
    $row->subtitle = implode(" | ", $addInfo1);
}

ob_start();
if ($row->price_call == 0)
{
    if ($row->price > 0)
    {
        echo OSPHelper::generatePrice($row->curr, $row->price);
        if ($row->rent_time != "")
        {
            echo "/" . JText::_($row->rent_time);
        }
    }
} elseif ($row->price_call == 1)
{
    echo JText::_('OS_CALL_FOR_DETAILS_PRICE');
}
$price = ob_get_contents();
ob_end_clean();
$row->price_raw = $price;

//price pure
ob_start();
if ($row->price_call == 0)
{
    if ($row->price > 0)
    {
        ?>
        <div id="currency_div" style="padding:0px;">
            <?php
            if (file_exists(JPATH_ROOT . DS . "components" . DS . "com_oscalendar" . DS . "oscalendar.php"))
            {
                if ($configClass['integrate_oscalendar'] == 1)
                {
                    echo JText::_('OS_FROM') . " ";
                }
            }
            echo OSPHelper::generatePrice($row->curr, $row->price);
            if ($row->rent_time != "")
            {
                ?>
                / <span id="mthpayment"><?php echo JText::_($row->rent_time); ?></span>
                <?php
            }
            if ($configClass['show_convert_currency'] == 1)
            {
                ?>
                <BR />
                <span style="font-size:11px;">
                    <?php echo JText::_('OS_CONVERT_CURRENCY') ?>: <?php echo $lists['curr'] ?>
                </span>
                <?php
            }
            ?>
        </div>
        <input type="hidden" name="live_site" id="live_site" value="<?php echo JURI::root() ?>" />
        <input type="hidden" name="currency_item" id="currency_item" value="" />
        <?php
    }
} elseif ($row->price_call == 1)
{
    echo " <span style='font-size:16px;'>" . JText::_('OS_CALL_FOR_DETAILS_PRICE') . "</span>";
}
$price = ob_get_contents();
ob_end_clean();
$row->price1 = $price;
//end price
//price
ob_start();
echo "<span style='font-weight:bold;font-size:15px;'>";
if ($row->price_call == 0)
{
    if ($row->price > 0)
    {
        ?>
        <div id="currency_div" style="padding:0px;">
            <?php
            echo OSPHelper::generatePrice($row->curr, $row->price);

            if ($row->rent_time != "")
            {
                echo "/" . JText::_($row->rent_time);
            }
            if ($configClass['show_convert_currency'] == 1)
            {
                echo "&nbsp;" . $lists['curr_default'];
            }
            ?>
        </div>
        <input type="hidden" name="live_site" id="live_site" value="<?php echo JURI::root() ?>" />
        <input type="hidden" name="currency_item" id="currency_item" value="" />
        <?php
    }
} elseif ($row->price_call == 1)
{
    echo " " . JText::_('OS_CALL_FOR_DETAILS_PRICE');
}
echo "</span>";
$price = ob_get_contents();
ob_end_clean();
$row->price = $price;
//end price

$needs = array();
$needs[] = "property_details";
$needs[] = $row->id;


$itemid = OSPRoute::getItemid($needs);

if ($configClass['integrate_education'] == 1)
{
    if (!$row->postcode && (!$row->latitude || !$row->longitude ))
    {
        //do nothing
    } else
    {
        $values = array();

        $values['zip'] = $row->postcode;
        $values['latitude'] = $row->lat_add;
        $values['longitude'] = $row->long_add;
        $values['key'] = 'dad04b84073a265e5244ba6db8892348';
        $values['radius'] = $configClass['education_radius'];
        $values['min'] = $configClass['education_min'];
        $values['city'] = HelperOspropertyCommon::loadCityName($row->city);
        $db->setQuery("Select state_name$lang_suffix as state_name from #__osrs_states where id = '$row->state'");
        $values['state'] = $db->loadResult();
        $max = $configClass['education_max'];
        $debug = 0;

        $i = 1;
        $result = self::_getSchoolData($values);

        if (isset($result[0]['methodResponse']['faultString']) && $debug == 0)
        {
            //do nothing
        } else
        {
            ob_start();
            ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="25%"><?php echo JText::_('OS_SCHOOL_NAME'); ?></th>
                        <th width="25%" class="hidden-phone"><?php echo JText::_('OS_GRADE_LEVEL'); ?></th>
                        <th width="25%"><?php echo JText::_('OS_DISTANCE_FROM_LISTING'); ?></th>
                        <th width="25%" class="hidden-phone"><?php echo JText::_('OS_ENROLLMENT'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($result[0]['methodResponse']['faultString']))
                    {
                        echo '<tr><td colspan="4" align="center"><b>Education.com Error:</b> ' . $result[0]['methodResponse']['faultString'] . '</td></tr>';
                        $no_results = true;
                    } elseif (count($result[0]['methodResponse']) < 1)
                    {
                        echo '<tr><td colspan="4" align="center"><b>' . JText::_('OS_NO_RESULTS_FOUND') . '.</b></td></tr>';
                        $no_results = true;
                    } else
                    {
                        $k = 0;
                        foreach ($result[0]['methodResponse'] as $school)
                        {
                            echo '
		                            <tr>
		                                <td><a href="' . $school['school']['url'] . '" target="_blank">' . $school['school']['schoolname'] . '</a></td>
		                                <td class="hidden-phone">' . $school['school']['gradelevel'] . '</td>
		                                <td>' . round($school['school']['distance'], 2) . ' miles</td>
		                                <td class="hidden-phone">' . $school['school']['enrollment'] . '</td>
		                            </tr>';

                            if ($i >= $max)
                                break;
                            $i++;
                            $k = 1 - $k;
                            $no_results = false;
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="small" style="text-align: center;">
                            Schools provided by: <a href="http://www.education.com/schoolfinder/" target="_blank"><img src ="<?php echo $result[1]['methodResponse']['logosrc']; ?>" alt="" /></a><br />
                            <?php if (!$no_results) echo '<a href="' . $result[1]['methodResponse']['lsc'] . '" target="_blank">See more information on ' . $property->city . ' schools from Education.com</a><br />'; ?>
                            <?php echo $result[1]['methodResponse']['disclaimer']; ?>
                        </td>
                    </tr>  
                </tfoot>
            </table> 
            <?php
            $education = ob_get_contents();
            ob_end_clean();
            $row->education = $education;
        }
    }
}
$db->setQuery("Select * from #__osrs_themes where name like '$themename'");
$themeobj = $db->loadObject();

$params = $themeobj->params;
$params = new JRegistry($params);
$report_image = "";
$translatable = JLanguageMultilang::isEnabled() && count($languages);

if ($translatable)
{
    $language = Jfactory::getLanguage();
    $language = $language->getTag();
    $language = explode("-", $language);
    $langfolder = $language[0];
    if (file_exists(JPATH_ROOT . "/components/com_osproperty/images/assets/" . $langfolder . "/isfeatured.png"))
    {
        $feature_image = JURI::root() . "components/com_osproperty/images/assets/" . $langfolder . "/isfeatured.png";
    } else
    {
        $feature_image = JURI::root() . "components/com_osproperty/images/assets/isfeatured.png";
    }
    if (file_exists(JPATH_ROOT . "/components/com_osproperty/images/assets/" . $langfolder . "/justadd.png"))
    {
        $justadd_image = JURI::root() . "components/com_osproperty/images/assets/" . $langfolder . "/justadd.png";
    } else
    {
        $justadd_image = JURI::root() . "components/com_osproperty/images/assets/justadd.png";
    }
    if (file_exists(JPATH_ROOT . "/components/com_osproperty/images/assets/" . $langfolder . "/justupdate.png"))
    {
        $justupdate_image = JURI::root() . "components/com_osproperty/images/assets/" . $langfolder . "/justupdate.png";
    } else
    {
        $justupdate_image = JURI::root() . "components/com_osproperty/images/assets/justupdate.png";
    }
    if ($configClass['enable_report'] == 1)
    {
        if (file_exists(JPATH_ROOT . "/components/com_osproperty/images/assets/" . $langfolder . "/report.png"))
        {
            $report_image = JURI::root() . "components/com_osproperty/images/assets/" . $langfolder . "/report.png";
        } else
        {
            $report_image = JURI::root() . "components/com_osproperty/images/assets/report.png";
        }
    }
} else
{
    $feature_image = JURI::root() . "components/com_osproperty/images/assets/isfeatured.png";
    $justadd_image = JURI::root() . "components/com_osproperty/images/assets/justadd.png";
    $justupdate_image = JURI::root() . "components/com_osproperty/images/assets/justupdate.png";
    $report_image = JURI::root() . "components/com_osproperty/images/assets/report.png";
}

$fb = "";
$translatable = JLanguageMultilang::isEnabled() && count($languages);
//if($translatable){
$language = JFactory::getLanguage();
$ltag = $language->getTag();
$ltag = str_replace("-", "_", $ltag);
$ltag = "&amp;locale=" . $ltag;
//}else{
//$ltag = "";
//}
$facebook_like = $configClass['show_fb_like'];
$url = JRoute::_("index.php?option=com_osproperty&task=property_details&id=$row->id");
$url = JUri::getInstance()->toString(array('scheme', 'user', 'pass', 'host')) . $url;
$url = urlencode($url);
if ($facebook_like == 1)
{
    $facebook_api = $configClass['facebook_api'];
    $facebook_height = $configClass['facebook_height'];
    if ($facebook_api == "")
    {
        $facebook_height = "10150130831010177";
    }
    if ($facebook_height == "")
    {
        $facebook_height = "80";
    }
    ob_start();
    ?>
    <div id="facebook" style="float:left; padding-left:5px;">
        <iframe src="//www.facebook.com/plugins/like.php?href=<?php echo $url; ?><?php echo $ltag; ?>&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=60&amp;appId=<?php echo $facebook_api; ?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:<?php echo $facebook_height; ?>px;" allowTransparency="true"></iframe></div>
    <?php
    $fb = ob_get_contents();
    ob_end_clean();
}
$document = JFactory::getDocument();
if ($configClass['show_twitter'] == 1)
{
    $tweet_via = $configClass['twitter_via'];
    $tweet_hash = $configClass['twitter_hash'];
    $title = "Tweet";
    $language = JFactory::getLanguage();
    $activate_lang = $language->getTag();
    $activate_lang = explode("-", $activate_lang);
    $activate_lang = $activate_lang[0];
    // make sure the hashtags are trimmed properly
    $tags = array_map('trim', explode(",", $tweet_hash));
    $tags = implode(',', $tags);
    $tweetscript = '!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");';
    $document->addScriptDeclaration($tweetscript);
    $tweet_div = '<div style="position: relative; top: 10px; right: 10px;float:left;">            
			                   <a href="https://twitter.com/share" class="twitter-share-button" data-url="' . $url . '" data-via="' . $tweet_via . '" data-lang="' . $activate_lang . '" data-hashtags="' . $tags . '">' . $title . '</a>
			               </div>';
    $row->tweet_div = $tweet_div;
}

if ($configClass['google_plus'] == 1)
{
    $document->addScript("https://apis.google.com/js/plusone.js");
    $gplus_div = '<div style="position: relative; top: 10px; right: 10px;float:left;">
		                    <g:plusone></g:plusone>
		                </div>';
    $row->gplus_div = $gplus_div;
}

if ($configClass['pinterest'] == 1)
{
    $description = urlencode(OSPHelper::getLanguageFieldValue($row, 'pro_name'));
    // make sure we have good path for image
    $db->setQuery("Select image from #__osrs_photos where pro_id = '$row->id' order by ordering limit 1");
    $default_image = $db->loadResult();
    if ($default_image != "")
    {
        $pin_image = JUri::root() . "images/osproperty/properties/" . $row->id . "/thumb/" . $default_image;
    } else
    {
        $pin_image = JUri::root() . "components/com_osproperty/images/assets/nopropertyphoto.png";
    }
    $pin_image = urlencode($pin_image);
    $pinpath = "http://pinterest.com/pin/create/button/?url=" . $url . "&media=" . $pin_image . "&description=" . $description;
    // create javascript for pinterest request
    $document->addScript("//assets.pinterest.com/js/pinit.js");
    $pinterest = '
                <div style="float:left;position: relative; top: 10px; right: 10px; width: 43px; height: 21px;">
                    <a href="' . $pinpath . '" class="pin-it-button" count-layout="horizontal" target="_blank">
                        <img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" alt="Pin It" />
                    </a>
                </div>';
    $row->pinterest = $pinterest;
}

$db->setQuery("Select count(extension_id) from #__extensions where `type` like 'plugin' and `element` like 'jcomments' and `folder` like 'osproperty' and enabled = '1'");
$countPlugin = $db->loadResult();

jimport('joomla.filesystem.folder');
if ((JFolder::exists(JPATH_ROOT . '/components/com_jcomments')) and ( $countPlugin > 0))
{
    $integrateJComments = 1;
} else
{
    $integrateJComments = 0;
}
//load plugin
JPluginHelper::importPlugin('osproperty');
$dispatcher = JDispatcher::getInstance();
$topPlugin = $dispatcher->trigger('onTopPropertyDetails', array($row));
$middlePlugin = $dispatcher->trigger('onMiddlePropertyDetails', array($row));
$bottomPlugin = $dispatcher->trigger('onBottomPropertyDetails', array($row));

$db->setQuery("Select a.id,a.keyword$lang_suffix as keyword from #__osrs_tags as a inner join #__osrs_tag_xref as b on b.tag_id = a.id where a.published = '1' and b.pid = '$row->id'");
$tags = $db->loadObjectList();

$tagArr = array();
if (count($tags) > 0)
{

    for ($i = 0; $i < count($tags); $i++)
    {
        $tag = $tags[$i];
        $link = JRoute::_('index.php?option=com_osproperty&task=property_tag&tag_id=' . $tag->id . '&Itemid=' . $jinput->getInt('Itemid', 0));
        $tagArr[] = "<a href='$link'><span class='label label-important tagkeyword'>" . $tag->keyword . "</span></a>";
    }
}

if ($configClass['use_property_history'] == 1)
{
    $query = $db->getQuery(true);
    $query->select("*")->from("#__osrs_property_price_history")->where("pid = '$row->id'")->order("`date` desc");
    $db->setQuery($query);
    $prices = $db->loadObjectList();
    $row->price_history = null;
    if (count($prices) > 0)
    {
        ob_start();
        ?>
        <div class="row-fluid">
            <div class="span12" style="margin-left:0px;">
                <h3>
                    <?php echo JText::_('OS_PROPERTY_HISTORY'); ?>
                </h3>
            </div>
            <div class="span12" style="margin-left:0px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <?php echo JText::_('OS_DATE'); ?>
                            </th>
                            <th>
                                <?php echo JText::_('OS_EVENT'); ?>
                            </th>
                            <th>
                                <?php echo JText::_('OS_PRICE'); ?>
                            </th>
                            <th>
                                <?php echo JText::_('OS_SOURCE'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($prices as $price)
                        {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $price->date; ?>
                                </td>
                                <td>
                                    <?php echo $price->event; ?>
                                </td>
                                <td>
                                    <?php echo OSPHelper::generatePrice('', $price->price); ?>
                                </td>
                                <td>
                                    <?php echo $price->source; ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        $price_history = ob_get_contents();
        ob_end_clean();
        $row->price_history = $price_history;
    }

    $query = $db->getQuery(true);
    $query->select("*")->from("#__osrs_property_history_tax")->where("pid = '$row->id'")->order("`tax_year` desc");
    $db->setQuery($query);
    $taxes = $db->loadObjectList();
    if (count($taxes) > 0)
    {
        ob_start();
        ?>
        <div class="row-fluid">
            <div class="span12" style="margin-left:0px;">
                <h3>
        <?php echo JText::_('OS_PROPERTY_TAX'); ?>
                </h3>
            </div>
            <div class="span12" style="margin-left:0px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
        <?php echo JText::_('OS_YEAR'); ?>
                            </th>
                            <th>
        <?php echo JText::_('OS_TAX'); ?>
                            </th>
                            <th>
        <?php echo JText::_('OS_CHANGE'); ?>
                            </th>
                            <th>
        <?php echo JText::_('OS_TAX_ASSESSMENT'); ?>
                            </th>
                            <th>
        <?php echo JText::_('OS_TAX_ASSESSMENT_CHANGE'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
        <?php
        foreach ($taxes as $tax)
        {
            ?>
                            <tr>
                                <td>
            <?php echo $tax->tax_year; ?>
                                </td>
                                <td>
            <?php echo OSPHelper::generatePrice('', $tax->property_tax); ?>
                                </td>
                                <td>
            <?php
            if ($tax->tax_change != "")
            {
                ?>
                                        <?php echo $tax->tax_change; ?> %
                                        <?php
                                    } else
                                    {
                                        ?>
                                        --
                                    <?php } ?>
                                </td>
                                <td>
            <?php echo OSPHelper::generatePrice('', $tax->tax_assessment); ?>
                                </td>
                                <td>
            <?php
            if ($tax->tax_assessment_change != "")
            {
                ?>
                                        <?php echo $tax->tax_assessment_change; ?> %
                                        <?php
                                    } else
                                    {
                                        ?>
                                        --
                                    <?php } ?>
                                </td>
                            </tr>
            <?php
        }
        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        $tax = ob_get_contents();
        ob_end_clean();
    }
    $row->tax = isset($tax) ? $tax : null;
}
if ($configClass['use_open_house'] == 1)
{
    $query = $db->getQuery(true);
    $current_date = date("Y-m-d H:i:s", time());
    $query->select("*")->from("#__osrs_property_open")->where("pid = '$row->id' and start_from >= '$current_date' ")->order("start_from desc");
    $db->setQuery($query);
    $opens = $db->loadObjectList();
    ob_start();
    ?>
    <div class="row-fluid img-polaroid inspectiontimes">
        <strong><?php echo Jtext::_('OS_OPEN_FOR_INSPECTION_TIMES') ?></strong>
        <div class="clearfix"></div>
        <div class="span12" style="margin-left:0px;font-size:x-small;">
    <?php
    if (count($opens) > 0)
    {
        foreach ($opens as $info)
        {
            ?>
                    <?php echo JText::_('OS_FROM') ?>: <?php
                    //echo date($configClass['general_date_format'],strtotime($info->start_from));
                    echo date($configClass['general_date_format'], strtotime($info->start_from));
                    ?>
                    -
                    <?php echo JText::_('OS_TO') ?>: <?php
                    //echo date($configClass['general_date_format'],strtotime($info->end_to));
                    //echo JHTML::_('date', strtotime($info->end_to) , $configClass['general_date_format']);
                    echo date($configClass['general_date_format'], strtotime($info->end_to));
                    ?>
                    <div class="clearfix"></div>
                    <?php
                }
            } else
            {
                echo JText::_('OS_NO_INSPECTIONS_ARE_CURRENTLY_SCHEDULED');
            }
            ?>
        </div>
    </div>
            <?php
            $open_hours = ob_get_contents();
            ob_end_clean();
        }
        $row->open_hours = $open_hours;
        $inFav = 0;
        if ($user->id > 0)
        {
            $db->setQuery("Select count(id) from #__osrs_favorites where user_id = '$user->id' and pro_id = '$row->id'");
            $count = $db->loadResult();
            if ($count > 0)
            {
                $inFav = 1;
            } else
            {
                $inFav = 0;
            }
        }
//echo $themename;
        $db->setQuery("Select * from #__osrs_themes where name like '$themename'");
        $themeobj = $db->loadObject();
        $params = $themeobj->params;
        $params = new JRegistry($params);
        $tpl = new OspropertyTemplate();
        $tpl->set('lists', $lists);
        $tpl->set('integrateJComments', $integrateJComments);
        $tpl->set('facebook_like', $fb);
        $tpl->set('feature_image', $feature_image);
        $tpl->set('justadd_image', $justadd_image);
        $tpl->set('justupdate_image', $justupdate_image);
        $tpl->set('report_image', $report_image);
        $tpl->set('params', $params);
        $tpl->set('row', $row);
        $tpl->set('itemid', $itemid);
        $tpl->set('configs', $configs);
        $tpl->set('socialUrl', $socialUrl);
        $tpl->set('configClass', $configClass);
        $tpl->set('owner', $owner);
        $tpl->set('can_add_cmt', $can_add_cmt);
        $tpl->set('photos', $photos);
        $tpl->set('ismobile', $ismobile);
        $tpl->set('topPlugin', $topPlugin);
        $tpl->set('middlePlugin', $middlePlugin);
        $tpl->set('bottomPlugin', $bottomPlugin);
        $tpl->set('tagArr', $tagArr);
        $tpl->set('themename', $themename);
        $tpl->set('params', $params);
        $tpl->set('inFav', $inFav);
        $tpl->set('jinput', $jinput);
        $tpl->set('temp_path_img', JURI::root() . "components/com_osproperty/templates/$themename/img");
        JHTML::_('behavior.modal', 'a.osmodal');


        $body = $tpl->fetch("details.html.tpl.php");
        echo $body;
        