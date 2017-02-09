<?php
/*------------------------------------------------------------------------
# email.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

class OspropertyEmail{
	/**
	 * Default function
	 *
	 * @param unknown_type $option
	 */
	function display($option,$task){
		global $jinput, $mainframe,$languages;
		JHTML::_('behavior.modal');
		$languages = OSPHelper::getLanguages();
		$cid = $jinput->get('cid',array(),'ARRAY');
		switch ($task){
			case "email_list":
				OspropertyEmail::email_list($option);
			break;
			case "email_unpublish":
				OspropertyEmail::email_change_publish($option,$cid,0);	
			break;
			case "email_publish":
				OspropertyEmail::email_change_publish($option,$cid,1);
			break;
			case "email_remove":
				OspropertyEmail::email_remove($option,$cid);
			break;
			case "email_edit":
				OspropertyEmail::email_edit($option,$cid[0]);
			break;
			case 'email_cancel':
				$mainframe->redirect("index.php?option=$option&task=email_list");
			break;	
			case "email_save":
				OspropertyEmail::email_save($option,1);
			break;
			case "email_apply":
				OspropertyEmail::email_save($option,0);
			break;
		}
	}

	/**
	 * Send email
	 *
	 * @param unknown_type $pid
	 * @param unknown_type $email_key
	 */
	function sendEmail($pid,$email_key,$sendto){
		global $mainframe,$configClass;
		include_once(JPATH_ROOT."/components/com_osproperty/helpers/helper.php");
		$db = JFactory::getDbo();
		$notify_email = $configClass['notify_email'];
		
		//$db->setQuery("Select * from #__osrs_configuration");
		//$configs = $db->loadObjectList();
		
		$auto_approval = $configClass['general_approval'];
		$db->setQuery("Select * from #__osrs_properties where id = '$pid'");
		$property = $db->loadObject();
		
		$emailfrom = $configClass['general_bussiness_email'];
		if($emailfrom == ""){
			$config = new JConfig();
			$emailfrom = $config->mailfrom;
		}
		
		if($sendto == 0){
			$agent_id = $property->agent_id;
			$db->setQuery("Select user_id from #__osrs_agents where id = '$agent_id'");
			$user_id = $db->loadResult();
			$user_language = OSPHelper::getUserLanguage($user_id);
			$language_prefix = OSPHelper::getFieldSuffix($user_language);
			$db->setQuery("Select * from #__osrs_agents where user_id = '$user_id'");
			$agent = $db->loadObject();
			$emailto = $agent->email;
			$user = JFactory::getUser($user_id);
			if($emailto != ""){
				$emailto = $user->email;
			}
		}else{
			$emailto = $notify_email;
		}
		
		if($emailto != ""){
			$db->setQuery("Select * from #__osrs_emails where email_key like '$email_key' and published = '1'");
			$email = $db->loadObject();
			if($email->id > 0){
				$subject = $email->{'email_title'.$language_prefix};
				$content = stripslashes($email->{'email_content'.$language_prefix});
				if(!OSPHelper::isEmptyMailContent($subject,$content)){
					$subject = $email->{'email_title'};
					$content = stripslashes($email->{'email_content'});
				}
				
				
				$db->setQuery("Select name from #__osrs_agents where id = '$property->agent_id'");
				$agent_name = $db->loadResult();
				ob_start();
				OspropertyListing::propertyDetails($pid);
				$body = ob_get_contents();
				ob_end_clean();
				//replace details
				$content = str_replace("{property_details}",$body,$content);
				//replace customer
				$content = str_replace("{customer}",$agent_name,$content);
				
				//replace link
				$link = JURI::root()."administrator/index.php?option=com_osproperty&task=properties_edit&cid[]=".$pid;
				$link = "<a href='".$link."'>".$link."</a>";
				$content = str_replace("{link}",$link,$content);
				
				if($auto_approval == 0){
					$information = JText::_("OS_WE_WILL_CHECK_THE_PROPERTY_AS_SOON_AS_POSSIBLE");
				}else{
					$information = JText::_("OS_THE_PROPERTY_HAS_BEEN_PUBLISHED");
				}
				$content = str_replace("{information}",$information,$content);
				
				$site_name = $configClass['general_bussiness_name'];
				
				$content = str_replace("{site_name}",$site_name,$content);
				
				$itemid = OSPRoute::getPropertyItemid($pid);
				$detail_link = JRoute::_("index.php?option=com_osproperty&task=property_details&id=".$pid."&Itemid=".$itemid);
				$detail_link = JUri::getInstance()->toString(array('scheme', 'user', 'pass', 'host')).$detail_link;
				$detail_link = "<a href='".$detail_link."'>".$detail_link."</a>";
				$content = str_replace("{details_link}",$detail_link,$content);
				$mailer = JFactory::getMailer();
				$mailer->sendMail($emailfrom,$site_name,$emailto,$subject,$content,1);
			}
		}
	}

	/**
	 * Send Payment Complete Information
	 *
	 * @param unknown_type $option
	 * @param unknown_type $order
	 * @param unknown_type $items
	 * @param unknown_type $coupon
	 */
	function sendPaymentCompleteEmail($order){
		global $jinput, $mainframe,$configClass;
		$db = JFactory::getDbo();
		$configClass = OSPHelper::loadConfig();

		$emailfrom				= $configClass['general_bussiness_email'];
		if($emailfrom == ""){
			$config				= new JConfig();
			$emailfrom			= $config->mailfrom;
		}
		$sitename				= $configClass['general_bussiness_name'];
		$notify					= $configClass['notify_email'];

		//send email to user
		
		$db->setQuery("Select * from #__osrs_emails where email_key like 'payment_accept' and published = '1'");
		$email = $db->loadObject();
		if($email->id > 0){
			$subject			= $email->email_title;
			$message			= stripslashes($email->email_content);
			
			$agent_id			= $order->agent_id;
			$created_by			= $order->created_by;

			if($created_by == 0){
				$db->setQuery("Select * from #__osrs_agents where id = '$agent_id'");
				$agent = $db->loadObject();
				$agentname		= $agent->name;
				$agentemail		= $agent->email;
			}else{
				$db->setQuery("Select * from #__osrs_companies where id = '$agent_id'");
				$agent = $db->loadObject();
				$agentname		= $agent->company_name;
				$agentemail		= $agent->email;
			}
			
			if(($order->payment_method != "") and ($order->total > 0)){
				$db->setQuery("Select title from #__osrs_plugins where name like '$order->payment_method'");
				$payment_method = $db->loadResult();
			}else{
				$payment_method = "N/A";
			}

			$message			= str_replace("{username}",$agentname,$message);
			$message			= str_replace("{gateway}",$payment_method,$message);
			$message			= str_replace("{txn}",$order->transaction_id,$message);

			$query = "Select a.pro_name,a.id as pid from #__osrs_properties as a"
					." inner join #__osrs_order_details as b on b.pid = a.id"
					." where b.order_id = '$order->id'";
			$db->setQuery($query);
			$properties			= $db->loadObjectList();
			$propertyArr		= array();
			for($j=0;$j<count($properties);$j++){
				$property		= $properties[$j];
				$propertyArr[]  = $property->pro_name;
			}

			switch($order->direction){
				case "0":
					$direction = JText::_('OS_NEW_PROPERTY_POSTED')."(".implode(", ",$propertyArr).")";
				break;
				case "1":
					$direction = JText::_('OS_FEATURED_UPGRADE')."(".implode(", ",$propertyArr).")";
				break;
				case "2":
					$direction = JText::_('OS_EXTEND_LIVE_TIME')."(".implode(", ",$propertyArr).")";
				break;
			}
			$message = str_replace("{item}",$direction,$message);
			$message = str_replace("{price}",OSPHelper::generatePrice($order->curr,$order->total),$message);
			$message = str_replace("{date}",HelperOspropertyCommon::loadTime($order->created_on,2),$message);
			$message = str_replace("{site_name}",$sitename,$message);
			$mailer = JFactory::getMailer();
			$mailer->sendMail($emailfrom,$sitename,$agentemail,$subject,$message,1);
		}

		//send email to administrator
		$db->setQuery("Select * from #__osrs_emails where email_key like 'payment_inform_to_administrator' and published = '1'");
		$email = $db->loadObject();
		if($email->id > 0){
			$subject			= $email->email_title;
			$message			= stripslashes($email->email_content);
			
			$agent_id			= $order->agent_id;
			$created_by			= $order->created_by;

			if($created_by == 0){
				$db->setQuery("Select * from #__osrs_agents where id = '$agent_id'");
				$agent = $db->loadObject();
				$agentname		= $agent->name;
				$agentemail		= $agent->email;
			}else{
				$db->setQuery("Select * from #__osrs_companies where id = '$agent_id'");
				$agent = $db->loadObject();
				$agentname		= $agent->company_name;
				$agentemail		= $agent->email;
			}
			
			if(($order->payment_method != "") and ($order->total > 0)){
				$db->setQuery("Select title from #__osrs_plugins where name like '$order->payment_method'");
				$payment_method = $db->loadResult();
			}else{
				$payment_method = "N/A";
			}

			$message			= str_replace("{username}",$agentname,$message);
			$message			= str_replace("{gateway}",$payment_method,$message);
			$message			= str_replace("{txn}",$order->transaction_id,$message);

			$query = "Select a.pro_name,a.id as pid from #__osrs_properties as a"
					." inner join #__osrs_order_details as b on b.pid = a.id"
					." where b.order_id = '$order->id'";
			$db->setQuery($query);
			$properties			= $db->loadObjectList();
			$propertyArr		= array();
			for($j=0;$j<count($properties);$j++){
				$property		= $properties[$j];
				$propertyArr[]  = $property->pro_name;
			}

			switch($order->direction){
				case "0":
					$direction = JText::_('OS_NEW_PROPERTY_POSTED')."(".implode(", ",$propertyArr).")";
				break;
				case "1":
					$direction = JText::_('OS_FEATURED_UPGRADE')."(".implode(", ",$propertyArr).")";
				break;
				case "2":
					$direction = JText::_('OS_EXTEND_LIVE_TIME')."(".implode(", ",$propertyArr).")";
				break;
			}

			$subject = str_replace("{item}",$direction,$subject);

			$message = str_replace("{item}",$direction,$message);
			$message = str_replace("{price}",OSPHelper::generatePrice($order->curr,$order->total),$message);
			$message = str_replace("{date}",HelperOspropertyCommon::loadTime($order->created_on,2),$message);
			$message = str_replace("{site_name}",$sitename,$message);
			$mailer = JFactory::getMailer();
			$mailer->sendMail($emailfrom,$sitename,$notify,$subject,$message,1);
		}
	}
	
	/**
	 * email list
	 *
	 * @param unknown_type $option
	 */
	function email_list($option){
		global $jinput, $mainframe;
		$user = JFactory::getUser();
		$db = JFactory::getDBO();
		$lists = array();
		$condition = '';
		
		// filter sort
		$filter_order = $mainframe->getUserStateFromRequest('email_list.filter.filter_order','filter_order','id');
		$mainframe->setUserState('email_list.filter.filter_order',$filter_order);

		$filter_order_Dir = $mainframe->getUserStateFromRequest('email_list.filter.filter_order_Dir','filter_order_Dir','');
		$mainframe->setUserState('email_list.filter.filter_order_Dir',$filter_order_Dir);

		$order_by = " ORDER BY $filter_order $filter_order_Dir";
		$lists['order'] = $filter_order;
		$lists['order_Dir'] = $filter_order_Dir;
		
		// filter page
		$limit = $mainframe->getUserStateFromRequest('email_list.filter.limit','limit','20');
		$mainframe->setUserState('email_list.filter.limit',$limit);

		$limitstart = $mainframe->getUserStateFromRequest('email_list.filter.limitstart','limitstart','0');
		$mainframe->setUserState('email_list.filter.limitstart',$limitstart);

		// search 
		$keyword = $jinput->getString('keyword','');
		if($keyword != ""){
			$condition .= " AND (";
			$condition .= " `email_key`  LIKE '%$keyword%'";
			$condition .= " OR `email_title` LIKE '%$keyword%'";
			$condition .= " OR `email_content` LIKE '%$keyword%'";
			$condition .= " )";
		}
			
		$count = "SELECT count(id) FROM #__osrs_emails WHERE 1=1";
		$count .= $condition;
		$db->setQuery($count);
		$total = $db->loadResult();
		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total,$limitstart,$limit);
		
		$list  = "SELECT * FROM #__osrs_emails "
				."\n WHERE 1=1 ";
		$list .= $condition;
		$list .= $order_by;
		$db->setQuery($list,$pageNav->limitstart,$pageNav->limit);
		$rows = $db->loadObjectList();
		
		HTML_OspropertyEmail::email_list($option,$rows,$pageNav,$lists);
	}
	
	/**
	 * publish or unpublish email
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 * @param unknown_type $state
	 */
	function email_change_publish($option,$cid,$state){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		if(count($cid)>0)	{
			$cids = implode(",",$cid);
			$db->setQuery("UPDATE #__osrs_emails SET `published` = '$state' WHERE id IN ($cids)");
			$db->query();
		}
		$mainframe->redirect("index.php?option=$option&task=email_list");
	}
	
	/**
	 * remove email
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 */
	function email_remove($option,$cid){
		global $jinput, $mainframe;
		$db = JFactory::getDBO();
		if(count($cid)>0)	{
			$cids = implode(",",$cid);
			$db->setQuery("DELETE FROM #__osrs_emails WHERE id IN ($cids)");
			$db->query();
		}
		$mainframe->redirect("index.php?option=$option&task=email_list");
	}
	
	
	
	/**
	 * email Detail
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	function email_edit($option,$id){
		global $jinput, $mainframe,$languages;
		$db = JFactory::getDBO();
		$row = &JTable::getInstance('Email','OspropertyTable');
		if($id > 0){
			$row->load((int)$id);
		}else{
			$row->published = 1;
		}
		
		// creat published
		//$lists['published'] = JHTML::_('select.booleanlist', 'published', '', $row->published);
		$optionArr = array();
		$optionArr[] = JHTML::_('select.option',1,JText::_('OS_YES'));
		$optionArr[] = JHTML::_('select.option',0,JText::_('OS_NO'));
		$lists['published']   = JHTML::_('select.genericlist',$optionArr,'published','class="input-mini"','value','text',$row->published);
		
		$translatable = JLanguageMultilang::isEnabled() && count($languages); 	
		
		HTML_OspropertyEmail::editHTML($option,$row,$lists,$translatable);
	}
	
	/**
	 * save email
	 *
	 * @param unknown_type $option
	 */
	function email_save($option,$save){
		global $jinput, $mainframe,$languages;
		$db = JFactory::getDBO();
		$post = $jinput->post->getArray();
		$row = &JTable::getInstance('Email','OspropertyTable');
		$row->bind($post);		 
		//print_r($_POST);
		$email_content = $_POST['email_content'];
		$row->email_content = $email_content;
		foreach ($languages as $language){												
			$sef = $language->sef;
			$email_content_name    		= 'email_content_'.$sef;
			$email_content_value   		= $_POST[$email_content_name];
			$row->{$email_content_name} = $email_content_value;
		}
		
		//print_r($row);
		//die();
		$row->check();
		$msg = JText::_('OS_ITEM_SAVED'); 
	 	if (!$row->store()){
		 	$msg = JText::_('ERROR_SAVING'); ;		 			 	
		 }
		$id = $jinput->getInt('id',0);
		if($id == 0){
			$id = $db->insertID();
		}
		if($save == 1){
			$mainframe->redirect("index.php?option=$option&task=email_list",$msg);
		}else{
			$mainframe->redirect("index.php?option=$option&task=email_edit&cid[]=".$id,$msg);
		}
	}
	
	
	/**
	 * Send activated email
	 *
	 * @param unknown_type $option
	 * @param unknown_type $emailOpt
	 */
	function sendActivedEmail($option,$id,$email_type,$emailopt){
		global $jinput, $mainframe,$configClass;
		$db = JFactory::getDbo();
		
		$emailfrom = $configClass['general_bussiness_email'];
		$sitename  = $configClass['general_bussiness_name'];
		
		if($emailfrom == ""){
			$config = new JConfig();
			$emailfrom = $config->mailfrom;
		}
		
		$db->setQuery("Select * from #__osrs_properties where id = '$id'");
		$property = $db->loadObject();
		$agent_id = $property->agent_id;
		$db->setQuery("Select user_id from #__osrs_agents where id = '$agent_id'");
		$user_id = $db->loadResult();
		if($user_id > 0){
			$user_language = OSPHelper::getUserLanguage($user_id);
			$language_prefix = OSPHelper::getFieldSuffix($user_language);
			
			$db->setQuery("Select * from #__osrs_emails where email_key like '$email_type' and published = '1'");
			$email = $db->loadObject();
			if($email->id > 0){
				$subject = $email->{'email_title'.$language_prefix};
				$content = stripslashes($email->{'email_content'.$language_prefix});
				if(!OSPHelper::isEmptyMailContent($subject,$content)){
					$subject = $email->{'email_title'};
					$content = stripslashes($email->{'email_content'});
				}
				
				$subject = str_replace("{site_name}",$sitename,$subject);
				$message = $content;
				$message = str_replace("{username}",$emailopt['agentname'],$message);
				$message = str_replace("{link}",$emailopt['link'],$message);
				$message = str_replace("{listing}",$emailopt['property'],$message);
				$message = str_replace("{site_name}",$sitename,$message);
				$mailer  = JFactory::getMailer();
				$mailer->sendMail($emailfrom,$sitename,$emailopt['agentemail'],$subject,$message,1);
			}
		}
	}
	
	/**
	 * Send Agent activate email
	 *
	 * @param unknown_type $option
	 * @param unknown_type $emailOpt
	 */
	function sendAgentActiveEmail($option,$emailOpt){
		global $jinput, $mainframe,$configClass;
		$db = JFactory::getDbo();
		
		$emailfrom = $configClass['general_bussiness_email'];
		$sitename  = $configClass['general_bussiness_name'];
		
		if($emailfrom == ""){
			$config = new JConfig();
			$emailfrom = $config->mailfrom;
		}
		
		$db->setQuery("Select user_id from #__osrs_agents where id = '".$emailOpt['agentid']."'");
		$user_id = $db->loadResult();
		
		if($user_id > 0){
			$user_language = OSPHelper::getUserLanguage($user_id);
			$language_prefix = OSPHelper::getFieldSuffix($user_language);
			
			$db->setQuery("SELECT * FROM #__osrs_emails WHERE `email_key` LIKE 'approval_agent_request' AND published = '1'");
			$email = $db->loadObject();
			if($email->id > 0){
				$subject = $email->{'email_title'.$language_prefix};
				$content = stripslashes($email->{'email_content'.$language_prefix});
				if(!OSPHelper::isEmptyMailContent($subject,$content)){
					$subject = $email->{'email_title'};
					$content = stripslashes($email->{'email_content'});
				}
				$message = $content;
				$subject = str_replace("{site_name}",$sitename,$subject);
				$message = str_replace("{agent}",$emailOpt['agentname'],$message);
				$message = str_replace("{site_name}",$sitename,$message);
				$mailer  = JFactory::getMailer();
				$mailer->sendMail($emailfrom,$sitename,$emailOpt['agentemail'],$subject,$message,1);
			}
		}
	}
	
	/**
	 * Send the activate email to user who create the company profile
	 * In case field : auto_approval_company_register = 0;
	 *
	 * @param unknown_type $company_id
	 */
	function sendActivateCompany($company_id){
		global $jinput, $mainframe,$configs,$configClass;
		$db = JFactory::getDbo();
		
		$db->setQuery("Select * from #__osrs_companies where id = '$company_id'");
		$company = $db->loadObject();
		
		$user_id = $company->user_id;
		
		if($user_id > 0){
			$user = JFactory::getUser($user_id);
			$user_language = OSPHelper::getUserLanguage($user_id);
			$language_prefix = OSPHelper::getFieldSuffix($user_language);
			
			$emailfrom = $configClass['general_bussiness_email'];
			if($emailfrom == ""){
				$config = new JConfig();
				$emailfrom = $config->mailfrom;
			}
			$sitename  = $configClass['general_bussiness_name'];
			$notify_email = $configClass['notify_email'];
			
			$db->setQuery("Select * from #__osrs_emails where email_key like 'your_company_has_been_approved' and published = '1'");
			$email = $db->loadObject();
			if($email->id > 0){
				$subject = $email->{'email_title'.$language_prefix};
				$message = stripslashes($email->{'email_content'.$language_prefix});
				if(!OSPHelper::isEmptyMailContent($subject,$message)){
					$subject = $email->{'email_title'};
					$message = stripslashes($email->{'email_content'});
				}
				$message = str_replace("{company_admin}",$user->name,$message);
				$message = str_replace("{company_name}",$company->company_name,$message);
				$link = "<a href='".JURI::root()."index.php?option=com_osproperty&task=company_edit'>".JURI::root()."index.php?option=com_osproperty&task=company_edit</a>";
				$message = str_replace("{company_edit_profile}",$link,$message);
				$mailer = JFactory::getMailer();
				if($company->email == ""){
					$company->email = $user->email;
				}
				$mailer->sendMail($emailfrom,$sitename,$company->email,$subject,$message,1);
			}
		}
	}
}
?>