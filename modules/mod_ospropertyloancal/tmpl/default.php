<?php
/*------------------------------------------------------------------------
# default.php - mod_oscategoryloancal
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

function calculateit()
{
f = document.repayment
amt = f.amt.value
annual_int = f.interest.value/100
term = f.term.value
monthly = annual_int/12
monthly_pay = Math.floor((amt*monthly)/(1-Math.pow((1+monthly),(-1*term*12)))*100)/100
f.monthly.value = currency(monthly_pay) 
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
return (dollars + "." + cents)
}

//-->

</script>


<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
	<div><?php echo JText::_( 'OS_LOANCAL_INTRO' ); ?></div>
		<form method="post" action="" name="repayment">
			<div>
				<?php echo JText::_( 'OS_LOANCAL_AMOUNT' ); ?>:<br />
				<?php echo JText::_( 'OS_LOANCAL_CURRENCY' ); ?> 
				<input type="text" name="amt" id="amt" size="15" maxlength="15" class="input-mini" />
			</div>
			<div>
				<?php echo JText::_( 'OS_LOANCAL_RATE' ); ?>:<br />
				&nbsp;&nbsp; 
				<input type="text" name="interest" size="15" maxlength="15" class="input-mini" />
				<?php echo JText::_( 'OS_LOANCAL_PERCENT' ); ?>
			</div>
			<div>
				<?php echo JText::_( 'OS_LOANCAL_TERM' ); ?>:<br />
				&nbsp;&nbsp; 
				<input type="text" name="term" size="15" maxlength="15" class="input-mini" />
				<?php echo JText::_( 'OS_LOANCAL_YRS' ); ?>
			</div>
			<div>
				<br />
				<input type="button" onclick="calculateit()" name="<?php echo JText::_( 'OS_LOANCAL_CALC' ); ?>" value="<?php echo JText::_( 'OS_LOANCAL_CALC' ); ?>" class="btn btn-info" />
				<input type="reset" name="<?php echo JText::_( 'OS_LOANCAL_CLEAR' ); ?>" value="<?php echo JText::_( 'OS_LOANCAL_CLEAR' ); ?>"  class="btn btn-warning" />
			</div>
			<div>
				<br /><?php echo JText::_( 'OS_LOANCAL_REPAY' ); ?>:<br />
				<?php echo JText::_( 'OS_LOANCAL_CURRENCY' ); ?> 
				<input type="text" name="monthly" size="15" maxlength="15" class="input-mini" />
			</div>
	</form>
</div>
