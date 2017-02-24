<?php

/**
 * @version		1.1.1
 * @package		Joomla
 * @subpackage	OS Property
 * @author		Dang Thuc Dam
 * @copyright	Copyright (C) 2011 Ossolution Team
 * @license		GNU/GPL, see LICENSE.php
 */
// no direct access
defined('_JEXEC') or die;

class os_offline extends os_payment
{

    /**
     * Order Status
     *
     * @var unknown_type
     */
    var $order_status = 0;

    /**
     * Constructor functions, init some parameter
     *
     * @param object $params
     */
    function os_offline($params)
    {
        parent::setName('os_offline');
        parent::os_payment();
        parent::setCreditCard(false);
        parent::setCardType(false);
        parent::setCardCvv(false);
        parent::setCardHolderName(false);
        $this->order_status = $params->get('order_status');
    }

    /**
     * Process payment 
     *
     */
    function processPayment($row, $data)
    {
        $mainframe = & JFactory::getApplication();
        $configClass = OSPHelper::loadConfig();
        $jinput = JFactory::getApplication()->input;
        $itemid = $jinput->getint('Itemid');
        $db = JFactory::getDbo();
        $db->setQuery("Select * from #__osrs_orders where id = '$row->id'");
        $order = $db->loadObject();
        $direction = $order->direction;

        if ($this->order_status == 0)
        {
            //do nothing
            $msg = array();
            $db->setQuery("Update #__osrs_orders set payment_made = '0',order_status = 'P' where id = '$row->id'");
            $db->query();
            $msg[] = JText::_('OS_ORDER_HAS_BEEN_STORED');
            if ($direction == 0)
            {
                $msg[] = JText::_('OS_PROPERTY_WILL_BE_APPROVED_AFTER_YOU_MAKE_PAYMENT');
            } elseif ($direction == 1)
            {
                $msg[] = JText::_('OS_PROPERTIES_WILL_BE_UPGRADED_AFTER_YOU_MAKE_PAYMENT');
            } elseif ($direction == 2)
            {
                $msg[] = JText::_('OS_PROPERTY_INFORMATION_HAS_BEEN_SAVED');
            }
        } else
        {
            //do nothing
            $msg = array();
            $db->setQuery("Update #__osrs_orders set payment_made = '1',order_status = 'S' where id = '$row->id'");
            $db->query();
            OspropertyPayment::paymentComplete($row->id);
            $msg[] = JText::_('OS_PAYMENT_COMPLETED');
            if ($direction == 0)
            {
                if ($configClass['general_approval'] == 1)
                {
                    $msg[] = JText::_('OS_PROPERTY_HAS_BEEN_APPROVED');
                } else
                {
                    $msg[] = JText::_('OS_WE_WILL_CHECK_AND_PUBLISH_THE_PROPERTY_AS_SOON_AS_POSSIBLE');
                }
            } elseif ($direction == 1)
            {
                $msg[] = JText::_('OS_PROPERTIES_HAS_BEEN_UPGRADED_TO_FEATURED');
            } elseif ($direction == 2)
            {
                $msg[] = JText::_('OS_PROPERTY_INFORMATION_HAS_BEEN_SAVED');
            }
        }

        if ($direction == 0)
        {
            $db->setQuery("Select pid from #__osrs_order_details where order_id = '$row->id'");
            $pid = $db->loadResult();
            $order_id = base64_encode($row->id);
            $url = JRoute::_(JURI::root() . "index.php?option=com_osproperty&task=property_thankyou&new=1&&id=$pid&order_id=$order_id&Itemid=" . $itemid, false, false);
            $mainframe->redirect($url);
        } elseif ($direction == 1)
        {
            $needs = array();
            if (HelperOspropertyCommon::isAgent())
            {
                $needs[] = "aeditdetails";
                $needs[] = "agent_default";
                $needs[] = "agent_editprofile";
                $itemid = OSPRoute::getItemid($needs);
                if (count($msg) > 0)
                {
                    for ($i = 0; $i < count($msg); $i++)
                    {
                        $msg[$i] = "<i class='osicon-ok'></i>&nbsp;" . $msg[$i];
                    }
                    $msg = implode("<Br />", $msg);
                }
                $url = JRoute::_("index.php?option=com_osproperty&task=agent_default&Itemid=" . $itemid);
            } elseif (HelperOspropertyCommon::isCompanyAdmin())
            {
                $needs[] = "ccompanydetails";
                $needs[] = "company_edit";
                $itemid = OSPRoute::getItemid($needs);
                if (count($msg) > 0)
                {
                    for ($i = 0; $i < count($msg); $i++)
                    {
                        $msg[$i] = "<i class='osicon-ok'></i>&nbsp;" . $msg[$i];
                    }
                    $msg = implode("<Br />", $msg);
                }
                $url = JRoute::_("index.php?option=com_osproperty&task=company_properties&Itemid=" . $itemid);
            }
            $mainframe->redirect($url, $msg);
        } elseif ($direction == 2)
        {
            $db->setQuery("Select pid from #__osrs_order_details where order_id = '$row->id'");
            $pid = $db->loadResult();
            $order_id = base64_encode($row->id);
            $url = JRoute::_(JURI::root() . "index.php?option=com_osproperty&task=property_thankyou&new=0&id=$pid&order_id=$order_id&Itemid=" . $jinput->getInt('Itemid', 0), false, false);
            $mainframe->redirect($url);
        }
    }

}
