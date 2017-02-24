<?php
/* ------------------------------------------------------------------------
  # upgrade_step1.php - Ossolution Property
  # ------------------------------------------------------------------------
  # author    Dang Thuc Dam
  # copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  # Websites: http://www.joomdonation.com
  # Technical Support:  Forum - http://www.joomdonation.com/forum.html
 */
?>
<script src="<?php echo JURI::root() ?>components/com_osproperty/js/paymentmethods.js" type="text/javascript"></script>
<div class="componentheading">
    <?php echo JText::_('OS_UPGRADE_PROPERTIES_TO_FEATURE'); ?>
</div>
<form method="POST" action="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_paymentprocess&Itemid=' . $itemid); ?>" name="ftForm1" id="ftForm1">
    <table class="upgradeproperty-table">
        <tr>
            <td width="80%" class="header_td" style="text-align:left;padding-left:20px;">
                <?php
                echo JText::_('OS_PROPERTY');
                ?>
            </td>
            <td width="10%" class="header_td hidden-phone">
                <?php
                echo JText::_('OS_REMOVE');
                ?>
            </td>
            <?php
            if (($configClass['general_featured_upgrade_amount'] > 0) and ( $configClass['active_payment'] == 1))
            {
                ?>
                <td width="10%" class="header_td" style="text-align:right;">
                    <?php
                    echo JText::_('OS_TOTAL');
                    ?>
                    (<?php echo HelperOspropertyCommon::loadDefaultCurrency(1) ?>)
                </td>
                <?php
            }
            ?>
        </tr>
        <?php
        $total = 0;
        for ($i = 0; $i < count($rows); $i++)
        {
            $row = $rows[$i];
            $total = $total + $configClass['general_featured_upgrade_amount'];
            $link = JURI::root() . "index.php?option=com_osproperty&task=property_details&id=" . $row->id;
            ?>
            <input type="hidden" name="cid[]" value="<?php echo $row->id ?>" />
            <tr>
                <td class="data_td" width="80%">
                    <table  width="100%" style="border:0px !important;">
                        <tr>
                            <td width="70">
                                <?php
                                if ($row->image != "")
                                {
                                    ?>
                                    <a href="<?php echo $link ?>" class="osmodal" rel="{handler: 'iframe', size: {x: 980, y: 500}, onClose: function() {}}">
                                        <?php
                                        OSPHelper::showPropertyPhoto($row->image, 'thumb', $row->id, 'width:70px;', 'img-polaroid', '');
                                        ?>
                                    </a>
                                    <?php
                                } else
                                {
                                    OSPHelper::showPropertyPhoto($row->image, 'thumb', $row->id, 'width:70px;', 'img-polaroid', '');
                                }
                                ?>
                            </td>
                            <td align="left" style="padding-left:20px;">
                                <a href="<?php echo $link ?>" class="osmodal" rel="{handler: 'iframe', size: {x: 980, y: 500}, onClose: function() {}}">
                                    <strong>
                                        <?php
                                        if ($row->ref != "")
                                        {
                                            echo $row->ref . ", ";
                                        }
                                        echo $row->pro_name;
                                        ?>
                                    </strong>
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="data_td hidden-phone" style="text-align:center;">
                    <a href="javascript:removeItem('<?php echo $row->id ?>')">
                        <i class='osicon-remove'></i>
                    </a>
                </td>
                <?php
                if (($configClass['general_featured_upgrade_amount'] > 0) and ( $configClass['active_payment'] == 1))
                {
                    ?>
                    <td class="data_td" style="text-align:right;">
                        <?php echo OSPHelper::generatePrice(HelperOspropertyCommon::loadCurrency(), $configClass['general_featured_upgrade_amount']); ?>
                    </td>
                <?php } ?>
            </tr>
            <?php
        }
        ?>
        <?php
        if (($configClass['general_featured_upgrade_amount'] > 0) and ( $configClass['active_payment'] == 1))
        {
            ?>
            <tr>
                <td class="data_td hidden-phone" style="text-align:right;font-weight:bold;background-color:#efefef;">

                </td>
                <td class="data_td" style="text-align:right;font-weight:bold;background-color:#efefef;">
                    <?php echo JText::_('OS_TOTAL') ?>
                </td>
                <td class="data_td" style="text-align:right;background-color:#efefef;">
                    <?php echo OSPHelper::generatePrice(HelperOspropertyCommon::loadCurrency(), $total); //HelperOspropertyCommon::showPrice($total)?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <BR />
    <?php
    $number_check = "";
    $number_check = $_COOKIE['u' . $user->id];
    if ($coupon->id > 0)
    { // there are available coupon
        //check to see whether if user is already use the coupon
        if (!HelperOspropertyCommon::isAlreadyUsed($coupon->id))
        {
            //show the form
            ?>
            <table  width="100%"  style="border:0px !important;">
                <tr>
                    <td width="100%" style="border:1px solid #CCC;padding:10px;">
                        <!-- Coupon -->
                        <div id="coupon_code_div">
                            <?php
                            if ($_COOKIE['coupon_code_awarded'] == $coupon->id)
                            {
                                ?>
                                <span style="font-size:15px;font-weight:bold;color:#0E8247;">
                                    <?php echo JText::_('Congratulation, you got ' . $coupon->discount . '% discount of the coupon [' . $coupon->coupon_name . ']') ?>
                                </span>
                                <?php
                            } else
                            {
                                if ($number_check < 4)
                                {
                                    echo JText::_('OS_PLEASE_ENTER_COPON_CODE_INTO_UNPUTBOX');
                                    ?>
                                    <BR /><BR />
                                    <input type="text" name="coupon_code" id="coupon_code" class="input-mini" size="10" />  
                                    <input type="button" class="btn btn-info" value="<?php echo JText::_('OS_CHECK_COUPON_CODE') ?>" onclick="javascript:checkCouponCode(<?php echo $coupon->id ?>)" />
                                    <?php
                                } else
                                {
                                    ?>
                                    <span style="font-size:15px;font-weight:bold;color:#C53535;">
                                        <?php
                                        echo JText::_('OS_WRONG_COUPON_CODE_YOU_HAVE_ENTERED4_TIMES');
                                        ?>
                                    </span>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php
        }
    }

    if ($configClass['active_payment'] == 1)
    {
        if (floatVal($configClass['general_featured_upgrade_amount']) > 0)
        {
            ?>
            <div class="clearfix"></div>
            <div id="payment_list">
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
                            <th width="20%">
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
                                <td style="text-align:center;">
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
            <?php
        }
    }
    ?>
    <div class="clearfix"></div>

    <table  width="100%" style="border-collapse:separate;border:0px !important;">
        <tr>
            <td width="100%" style="text-align:right;border:0px;">
                <input type="button" value="<?php echo JText::_('OS_BACK') ?>" class="btn btn-warning" onclick="javascript:history.go(-1);"/>
                <input type="button" value="<?php echo JText::_('OS_CONFIRM') ?>" class="btn btn-info" onclick="javascript:confirmUpgradeForm();" />
            </td>
        </tr>
    </table>

    <input type="hidden" name="option" value="com_osproperty" />
    <input type="hidden" name="task" value="property_paymentprocess" />
    <input type="hidden" name="Itemid" value="<?php echo $itemid; ?>" />
    <input type="hidden" name="remove_value" id="remove_value" value="" />
    <input type="hidden" name="live_site" value="<?php echo JURI::root() ?>" />
</form>
<script type="text/javascript">
<?php
os_payments::writeJavascriptObjects();
?>

    function confirmUpgradeForm() {
<?php
if (($configClass['active_payment'] == 1) and ( floatVal($configClass['general_featured_upgrade_amount'] > 0)))
{
    ?>
            var methodpass = 1;
            var paymentMethod = "";
            var x_card_num = "";
            var x_card_code = "";
            var card_holder_name = "";
            var exp_month = "";
            var exp_year = "";
            var card_type = "";
            cansubmit = checkPaymentMethod();
    <?php
} else
{
    ?>
            cansubmit = 1;
    <?php
}
?>
        if (cansubmit == 1) {
            document.ftForm1.submit();
        }
    }

    function checkPaymentMethod() {
        var methodpass = 1;
        var paymentMethod = "";
        var x_card_num = "";
        var x_card_code = "";
        var card_holder_name = "";
        var exp_month = "";
        var exp_year = "";
        var card_type = "";
        var check = 1;
<?php
$methods = $lists['methods'];
if (count($methods) > 0)
{
    if (count($methods) > 1)
    {
        ?>
                var paymentValid = false;
                var nmethods = document.getElementById('nmethods');
                var methodtemp;
                for (var i = 0; i < nmethods.value; i++) {
                    methodtemp = document.getElementById('pmt' + i);
                    if (methodtemp.checked == true) {
                        paymentValid = true;
                        paymentMethod = methodtemp.value;
                        break;
                    }
                }

                if (!paymentValid) {
                    alert("<?php echo JText::_('OS_REQUIRE_PAYMENT_OPTION'); ?>");
                    methodpass = 0;
                }
        <?php
    } else
    {
        ?>
                paymentMethod = "<?php echo $methods[0]->getName(); ?>";
        <?php
    }
    ?>
            //var discount_100 = document.getElementById('discount_100');
            method = methods.Find(paymentMethod);
            if ((method.getCreditCard()) && (check == 1)) {
                var x_card_nume = document.getElementById('x_card_num');
                if (x_card_nume.value == "") {
                    alert("<?php echo JText::_('OS_ENTER_CARD_NUMBER'); ?>");
                    x_card_nume.focus();
                    methodpass = 0;
                    return 0;
                } else {
                    x_card_num = x_card_nume.value;
                }

                var x_card_codee = document.getElementById('x_card_code');
                if (x_card_codee.value == "") {
                    alert("<?php echo JText::_('OS_ENTER_CARD_CODE'); ?>");
                    x_card_codee.focus();
                    methodpass = 0;
                    return 0;
                } else {
                    x_card_code = x_card_codee.value;
                }
            }

            if (method.getCardHolderName()) {
                card_holder_namee = document.getElementById('card_holder_name');
                if (card_holder_namee.value == '') {
                    alert("<?php echo JText::_('OS_ENTER_CARD_HOLDER_NAME'); ?>");
                    card_holder_namee.focus();
                    methodpass = 0;
                    return 0;
                } else {
                    card_holder_name = card_holder_namee.value;
                }
            }

            var exp_yeare = document.getElementById('exp_year');
            exp_year = exp_yeare.value;
            var exp_monthe = document.getElementById('exp_month');
            exp_month = exp_monthe.value;
            var card_typee = document.getElementById('card_type');
            card_type = card_typee.value;

            return 1;
    <?php
}
?>
    }
</script>