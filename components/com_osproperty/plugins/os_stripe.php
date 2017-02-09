<?php
/**
 * @version            2.9.2
 * @package            OS Property
 * @subpackage         Payment Plugins
 * @author             Dang Thuc Dam
 * @copyright          Copyright (C) 2007 - 2015 Ossolution Team
 * @license            GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();

/**
 * Strie payment plugin for OS Property
 *
 * @author Dang Thuc Dam
 *
 */
class os_stripe extends os_payment
{

	/**
	 * Payment plugin param
	 *
	 * @var JRegistry
	 */
	protected $params;

	/**
	 * Constructors function
	 *
	 * @param JRegistry $params
	 */
	function os_stripe($params)
	{
		require_once __DIR__ . '/stripe/Stripe.php';
		parent::setName('os_stripe');
		parent::os_payment();
		parent::setCreditCard(true);
		parent::setCardType(true);
		parent::setCardCvv(true);
		parent::setCardHolderName(true);
		$this->params = $params;
	}

	/**
	 * Set parametter for processing payment
	 *
	 * @param string $key
	 * @param string $value
	 */
	function setParam($key, $value)
	{
		$this->params[$key] = $value;
	}

	/**
	 * Process Payment
	 *
	 * @param array $data
	 */
	function processPayment($row, $data)
	{
		$db = JFactory::getDbo();
		$mainframe				= JFactory::getApplication();
		$direction				= $row->direction;
		$jinput					= JFactory::getApplication()->input;
		$Itemid					= $jinput->getInt('Itemid');
		Stripe::setApiKey($this->params->get('stripe_api_key'));
		$request = array(
			'amount'      => 100 * round($data['amount'], 2),
			'currency'    => $this->params->get('stripe_currency', 'usd'),
			'description' => $data['item_name'],
			'card'        => array(
				'number'    => $data['x_card_num'],
				'exp_month' => $data['exp_month'],
				'exp_year'  => $data['exp_year'],
				'cvc'       => $data['x_card_code'],
				'name'      => $data['card_holder_name']
			)
		);
		try
		{
			$charge              = Stripe_Charge::create($request);
			$configClass         = OSPHelper::loadConfig();
			$transaction_id = $charge->id;

			$db->setQuery("Update #__osrs_orders set payment_made = '1',order_status = 'S',transaction_id = '$transaction_id' where id = '$row->id'");
			$db->query();

			OspropertyPayment::paymentComplete($row->id);
			$msg				= array();
			$msg[]				= JText::_('OS_PAYMENT_COMPLETED');
			if($direction == 0){
				if($configClass['general_approval'] == 1){
					$msg[]		= JText::_('OS_PROPERTY_HAS_BEEN_APPROVED');
				}else{
					$msg[]		= JText::_('OS_WE_WILL_CHECK_AND_PUBLISH_THE_PROPERTY_AS_SOON_AS_POSSIBLE');
				}
			}elseif($direction==1){
				$msg[]			= JText::_('OS_PROPERTIES_HAS_BEEN_UPGRADED_TO_FEATURED');
			}elseif($direction==2){
				$msg[]			= JText::_('OS_PROPERTY_INFORMATION_HAS_BEEN_SAVED');
			}

			if($direction == 0){
				$db->setQuery("Select pid from #__osrs_order_details where order_id = '$row->id'");
				$pid			= $db->loadResult();
				$order_id		= base64_encode($row->id);
				$url			= JRoute::_(JURI::root()."index.php?option=com_osproperty&task=property_thankyou&new=1&&id=$pid&order_id=$order_id&Itemid=".$jinput->getInt('Itemid'), false, false);
				$mainframe->redirect($url);	
			}elseif($direction ==1){
				$needs			= array();
				if(HelperOspropertyCommon::isAgent()){
					$needs[]	= "aeditdetails";
					$needs[]	= "agent_default";
					$needs[]	= "agent_editprofile";
					$itemid		= OSPRoute::getItemid($needs);
					if(count($msg) > 0){
						for($i=0;$i<count($msg);$i++){
							$msg[$i] = "<i class='osicon-ok'></i>&nbsp;".$msg[$i];
						}
						$msg	= implode("<Br />",$msg);
					}
					$url		= JRoute::_("index.php?option=com_osproperty&task=agent_default&Itemid=".$itemid);
				}elseif(HelperOspropertyCommon::isCompanyAdmin()){
					$needs[]	= "ccompanydetails";
					$needs[]	= "company_edit";
					$itemid		= OSPRoute::getItemid($needs);
					if(count($msg) > 0){
						for($i=0;$i<count($msg);$i++){
							$msg[$i] = "<i class='osicon-ok'></i>&nbsp;".$msg[$i];
						}
						$msg	= implode("<Br />",$msg);
					}
					$url = JRoute::_("index.php?option=com_osproperty&task=company_properties&Itemid=".$itemid);
				}
				$mainframe->redirect($url,$msg);
			}elseif($direction ==2){
				$db->setQuery("Select pid from #__osrs_order_details where order_id = '$row->id'");
				$pid = $db->loadResult();
				$order_id		= base64_encode($row->id);
				$url			= JRoute::_(JURI::root()."index.php?option=com_osproperty&task=property_thankyou&new=0&id=$pid&order_id=$order_id&Itemid=".$jinput->getInt('Itemid'), false, false);
				$mainframe->redirect($url);	
			}
		}
		catch (Exception $e)
		{
			$msg				= array();
			$msg[]				= $e->getMessage();

			if($direction == 0){
				$msg[] = JText::_('OS_PROPERTY_HAS_BEEN_STORED_BUT_IT_ISNOT_APPROVED');
				$db->setQuery("Select pid from #__osrs_order_details where order_id = '$row->id'");
				$pid = $db->loadResult();
				$order_id = base64_encode($row->id);
				$url = JRoute::_(JURI::root()."index.php?option=com_osproperty&task=property_thankyou&new=1&&id=$pid&order_id=$order_id&Itemid=".$jinput->getInt('Itemid'), false, false);
				$mainframe->redirect($url);	
			}elseif($direction ==1){
				$needs = array();
				if(HelperOspropertyCommon::isAgent()){
					$needs[] = "aeditdetails";
					$needs[] = "agent_default";
					$needs[] = "agent_editprofile";
					$itemid = OSPRoute::getItemid($needs);
					if(count($msg) > 0){
						for($i=0;$i<count($msg);$i++){
							$msg[$i] = "<i class='osicon-ok'></i>&nbsp;".$msg[$i];
						}
						$msg = implode("<Br />",$msg);
					}
					$url = JRoute::_("index.php?option=com_osproperty&task=agent_default&Itemid=".$itemid);
				}elseif(HelperOspropertyCommon::isCompanyAdmin()){
					$needs[] = "ccompanydetails";
					$needs[] = "company_edit";
					$itemid = OSPRoute::getItemid($needs);
					if(count($msg) > 0){
						for($i=0;$i<count($msg);$i++){
							$msg[$i] = "<i class='osicon-ok'></i>&nbsp;".$msg[$i];
						}
						$msg = implode("<Br />",$msg);
					}
					$url = JRoute::_("index.php?option=com_osproperty&task=company_properties&Itemid=".$itemid);
				}
				$mainframe->redirect($url,$msg);
			}elseif($direction ==2){
				$msg[] = JText::_('OS_PROPERTY_INFORMATION_HAS_BEEN_SAVED');
				$db->setQuery("Select pid from #__osrs_order_details where order_id = '$row->id'");
				$pid = $db->loadResult();
				$order_id = base64_encode($row->id);
				$url = JRoute::_(JURI::root()."index.php?option=com_osproperty&task=property_thankyou&new=0&id=$pid&order_id=$order_id&Itemid=".$jinput->getInt('Itemid'), false, false);
				$mainframe->redirect($url);	
			}

			//$app->redirect(JRoute::_('index.php?option=com_osmembership&view=failure&id='.$row->id.'&Itemid='.$Itemid, false, false));
			return false;
		}
	}
}