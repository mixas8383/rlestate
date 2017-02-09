<?php
/*------------------------------------------------------------------------
# transaction.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2015 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

class OspropertyTransaction{
	/**
	 * Default transaction page
	 *
	 * @param unknown_type $option
	 * @param unknown_type $task
	 */
	function display($option,$task){
		global $jinput, $mainframe;
		$db = JFactory::getDbo();
		$cid = $jinput->get('cid',array(),'ARRAY');
		switch ($task){
			case "transaction_list":
				OspropertyTransaction::listTransaction($option);
			break;
			case "transaction_details":
				OspropertyTransaction::transactionDetails($option,$cid[0]);
			break;
			case "transaction_save":
				OspropertyTransaction::saveTransaction($option,1);
			break;
			case "transaction_apply":
				OspropertyTransaction::saveTransaction($option,0);
			break;
			case "transaction_back":
				$mainframe->redirect("index.php?option=com_osproperty&task=transaction_list");
			break;
			case "transaction_remove":
				OspropertyTransaction::removeTransaction($option,$cid);
			break;
		}
	}

	/**
	 * List Transaction
	 *
	 * @param unknown_type $option
	 */
	function listTransaction($option){
		global $jinput, $mainframe;
		$db = JFactory::getDbo();
		$limit = $jinput->getInt('limit',20);
		$limitstart = $jinput->getInt('limitstart',0);
		
		$start_date = $jinput->getString('start_date','');
		$end_date   = $jinput->getString('end_date','');

        $order_status = $jinput->getString('order_status','');
        $action =$jinput->getInt('action',-1);

		$filter_order 	  = $jinput->getString('filter_order','created_on');
		$filter_order_Dir = $jinput->getString('filter_order_Dir','desc');
		$lists['order'] = $filter_order;
		$lists['order_Dir'] = $filter_order_Dir;
		
		$query = "select count(id) from #__osrs_orders where 1=1";
		if($start_date != ""){
			$query .= " and created_on >= '$start_date'";
		}
		if($end_date != ""){
			$query .= " and created_on <= '$end_date'";
		}
        if($order_status != ""){
            $query .= " and order_status  = '$order_status'";
        }
        if($action >= 0){
            $query .= " and direction  = '$action'";
        }
		$db->setQuery($query);
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		
		$pageNav = new JPagination($total,$limitstart,$limit);
		
		$query = "Select a.* from #__osrs_orders as a"
				//." inner join #__osrs_agents as b on b.id = a.agent_id"
				." where 1=1";
		if($start_date != ""){
			$query .= " and a.created_on >= '$start_date'";
		}
		if($end_date != ""){
			$query .= " and a.created_on <= '$end_date'";
		}
        if($order_status != ""){
            $query .= " and a.order_status  = '$order_status'";
        }
        if($action >= 0){
            $query .= " and a.direction  = '$action'";
        }
		$query .= " order by $filter_order $filter_order_Dir ";
		$db->setQuery($query,$pageNav->limitstart,$pageNav->limit);
		$rows = $db->loadObjectList();
		
		if(count($rows) > 0){
			for($i=0;$i<count($rows);$i++){
				$row = $rows[$i];
				$query = "Select a.pro_name,a.id as pid from #__osrs_properties as a"
						." inner join #__osrs_order_details as b on b.pid = a.id"
						." where b.order_id = '$row->id'";
				$db->setQuery($query);
				$properties = $db->loadObjectList();
				$property_str = "";
				for($j=0;$j<count($properties);$j++){
					$property =$properties[$j];
					$j1 = $j + 1;
					$link = "index.php?option=com_osproperty&task=properties_edit&cid[]=".$property->pid;
					
					$property_str .= $j1.". <a href='$link' target='_blank'>".$property->pro_name."</a><div class='clearfix'></div>";
				}
				$row->property = $property_str;

				if($row->created_by == 0){
					$db->setQuery("Select name from #__osrs_agents where id = '$row->agent_id'");
					$row->name = $db->loadResult();
				}else{
					$db->setQuery("Select company_name from #__osrs_companies where id = '$row->agent_id'");
					$row->name = $db->loadResult();
				}
			}
		}

        $optionArr = array();
        $optionArr[] = JHTML::_('select.option','',JText::_('OS_SELECT_ORDER_STATUS'));
        $optionArr[] = JHTML::_('select.option','P',JText::_('OS_PENDING'));
        $optionArr[] = JHTML::_('select.option','S',JText::_('OS_COMPLETED'));
        $optionArr[] = JHTML::_('select.option','S',JText::_('OS_CANCELLED'));
        $lists['order_status'] = JHTML::_('select.genericlist',$optionArr,'order_status','class="input-large" onChange="javascript:document.adminForm.submit();"','value','text',$order_status);

        $optionArr = array();
        $optionArr[] = JHTML::_('select.option',-1,JText::_('OS_SELECT_ACTION'));
        $optionArr[] = JHTML::_('select.option','0',JText::_('OS_NEW_PROPERTY'));
        $optionArr[] = JHTML::_('select.option','1',JText::_('OS_FEATURED_UPGRADE'));
        $optionArr[] = JHTML::_('select.option','2',JText::_('OS_EXTEND_LIVETIME'));
        $lists['direction'] = JHTML::_('select.genericlist',$optionArr,'direction','class="input-large" onChange="javascript:document.adminForm.submit();"','value','text',$action);
		
		HTML_OspropertyTransaction::listTransaction($lists,$rows,$pageNav);
	}
	
	/**
	 * Save Transaction
	 *
	 * @param unknown_type $option
	 */
	function saveTransaction($option,$save){
		global $jinput, $mainframe,$configClass;
		$order_id = $jinput->getInt('order_id',0);
        $payment_made = $jinput->getInt('payment_made',0);
        $payment_method = $jinput->getString('payment_method','');
		$db = Jfactory::getDbo();
		$db->setQuery("Select * from #__osrs_orders where id = '$order_id'");
        $order = $db->loadObject();
		$old_order_status = $order->order_status;
		$order_status = $jinput->getString('order_status','');
		$db->setQuery("Update #__osrs_orders set order_status = '$order_status',payment_made = '$payment_made',payment_method='$payment_method' where id = '$order_id'");
		$db->query();

		//for test
		$old_order_status = "P";

		if(($old_order_status == "P") and ($order_status == "S")){
			$db->setQuery("Select pid,type from #__osrs_order_details where order_id = '$order_id'");
            $properties = $db->loadObjectList();
			require_once JPATH_ROOT.'/components/com_osproperty/classes/listing.php';
			require_once JPATH_ROOT.'/components/com_osproperty/classes/template.class.php';
			require_once JPATH_ROOT.'/components/com_osproperty/helpers/route.php';
            foreach($properties as $property){
                switch($order->direction){
                    case "0":
						//send Email to admin
						OspropertyEmail::sendEmail($pid,'new_property_inform',1);
						//send Email to agent
						OspropertyEmail::sendEmail($pid,'new_property_confirmation',0);
                        if($property->type == 0){
                            HelperOspropertyCommon::setApproval("n",$property->pid);
                            //set Feature expired time
                            HelperOspropertyCommon::setExpiredTime($property->pid,"n",1);
                        }else{
                            HelperOspropertyCommon::setApproval("f",$property->pid);
                            //set Feature expired time
                            HelperOspropertyCommon::setExpiredTime($property->pid,"f",1);
                        }
                        break;
                    case "1":
						$db->setQuery("Update #__osrs_properties set isFeatured = '1' where id = '$property->pid'");
						$db->query();

                        HelperOspropertyCommon::setApproval("f",$property->pid);
                        //set Feature expired time
                        HelperOspropertyCommon::setExpiredTime($property->pid,"f",0);
                        break;
					case "2";
						$type = $property->type;
						if($type == 1){
							//set Feature and approval
							HelperOspropertyCommon::setApproval("f",$property->pid);
							//set Feature expired time
							HelperOspropertyCommon::setExpiredTime($property->pid,"f",0);
						}else{
							HelperOspropertyCommon::setApproval("n",$property->pid);
							HelperOspropertyCommon::setExpiredTime($property->pid,"n",0);
						}
						break;
                }

				//send notification email
				OspropertyEmail::sendPaymentCompleteEmail($order);
            }
		}
		if($save == 1){
			$mainframe->redirect("index.php?option=com_osproperty&task=transaction_list",JText::_('OS_ITEM_HAS_BEEN_SAVED'));
		}else{
			$mainframe->redirect("index.php?option=com_osproperty&task=transaction_details&cid[]=".$order_id,JText::_('OS_ITEM_HAS_BEEN_SAVED'));
		}
	}
	
	/**
	 * Remove transaction
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 */
	function removeTransaction($option,$cid){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		if(count($cid) > 0){
			$cids = implode(",",$cid);
			$db->setQuery("Delete from #__osrs_orders where id in ($cids)");
			$db->query();
			$db->setQuery("Delete from #__osrs_order_details where order_id in ($cids)");
			$db->query();
		}
		$mainframe->redirect("index.php?option=com_osproperty&task=transaction_list",JText::_("OS_ITEM_HAVE_BEEN_REMOVED"));
	}
	
	
	/**
	 * Transaction details
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	function transactionDetails($option,$order_id){
		global $jinput, $mainframe;
        include(JPATH_ROOT.DS."components/com_osproperty/plugins".DS."os_payments.php");
        include(JPATH_COMPONENT.DS."components/com_osproperty/plugins".DS."os_payment.php");
		$db = JFactory::getDbo();
		$configs = OSPHelper::loadConfig();
		
		$db->setQuery("Select * from #__osrs_orders where id = '$order_id'");
		$order = $db->loadObject();
		
		$db->setQuery("Select a.*,b.pro_name from #__osrs_order_details as a inner join #__osrs_properties as b on b.id = a.pid where a.order_id = '$order_id'");
		$items = $db->loadObjectList();
		
		$db->setQuery("Select * from #__osrs_agents where id = '$order->agent_id'");
		$agent = $db->loadObject();
		
		$optionArr = array();
		$optionArr[] = JHTML::_('select.option','P',JText::_('OS_PENDING'));
		$optionArr[] = JHTML::_('select.option','S',JText::_('OS_COMPLETED'));
        $optionArr[] = JHTML::_('select.option','C',JText::_('OS_CANCELLED'));
		$lists['order_status'] = JHTML::_('select.genericlist',$optionArr,'order_status','class="input-medium"','value','text');

        $optionArr = array();
        $optionArr[] = JHTML::_('select.option','0',JText::_('OS_NO'));
        $optionArr[] = JHTML::_('select.option','1',JText::_('OS_YES'));
        $lists['payment_made'] = JHTML::_('select.genericlist',$optionArr,'payment_made','class="input-small"','value','text',$order->payment_made);

		HTML_OspropertyTransaction::transactionDetails($order,$configs,$items,$agent,$lists);
	}
}

?>