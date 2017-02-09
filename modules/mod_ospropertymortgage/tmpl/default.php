<?php
/*------------------------------------------------------------------------
# default.php - mod_oscategorymortgage
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2010 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<script type="text/javascript">

<!--

function docalculate()
{
f = document.borrow;
income = Math.floor(f.income.value) *12*4;
yourdebt = income;
f.loan.value = currency(yourdebt);
}

function currency(num)
{
var dollars = Math.floor(num);
for (var i = 0; i < num.length; i++)
{
  if (num.charAt(i) == ".")
break;
}
var cents = "" + Math.round(num * 100);
cents = cents.substring(cents.length-2, cents.length);
return (dollars + "." + cents);
}
//-->

</script>


<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
	<div><?php echo JText::_( 'OS_MORTGAGE_INTRO' ); ?></div>
		<form method="post" name="borrow" action="">
			<div>
				<?php echo JText::_( 'OS_MORTGAGE_AMOUNT' ); ?>:<br />
				<?php echo JText::_( 'OS_MORTGAGE_CURRENCY' ); ?> 
				<input class="input-small" type="text" name="income" size="15" maxlength="15" />
			</div>
			<div>
				<input class="btn btn-info" type="button" onclick="docalculate()" name="<?php echo JText::_( 'OS_MORTGAGE_CALC' ); ?>" value="<?php echo JText::_( 'OS_MORTGAGE_CALC' ); ?>" />
				<input class="btn btn-warning" type="reset" name="<?php echo JText::_( 'OS_MORTGAGE_CLEAR' ); ?>" value="<?php echo JText::_( 'OS_MORTGAGE_CLEAR' ); ?>" />
			</div>
			<div>
				<br /><?php echo JText::_( 'OS_MORTGAGE_REPAY' ); ?>:<br />
				<?php echo JText::_( 'OS_MORTGAGE_CURRENCY' ); ?> 
				<input class="input-small" type="text" size="15" maxlength="15" name="loan" />
			</div>
	</form>
</div>
