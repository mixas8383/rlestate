<?php
/*------------------------------------------------------------------------
# listing.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/

// No direct access.
defined('_JEXEC') or die;

class OspropertyListing{
	static function display($option,$task){
		global $mainframe,$jinput;

		$cid        = $jinput->get('cid',array(),'ARRAY');
		$id         = $jinput->getInt('id',0);
		$db         = JFactory::getDbo();

		$document = JFactory::getDocument();
		$document->addScript(JURI::root()."components/com_osproperty/js/ajax.js");

		switch ($task){
			case "property_details":
				OspropertyListing::details($option);
				HelperOspropertyCommon::loadFooter($option);
			break;
			case "property_new":
				echo HelperOspropertyCommon::buildToolbar('default');
				OspropertyListing::edit($option,0);
				HelperOspropertyCommon::loadFooter($option);
			break;
			case "property_edit":
				echo HelperOspropertyCommon::buildToolbar('default');
				OspropertyListing::edit($option,$id);
				HelperOspropertyCommon::loadFooter($option);
			break;
			case "property_save":
				OspropertyListing::save($option,1);
			break;
			case "property_apply":
				OspropertyListing::save($option,0);
			break;
			case "property_upgrade":
				echo HelperOspropertyCommon::buildToolbar('default');
				OspropertyListing::upgrade_step1($option,$cid);
				HelperOspropertyCommon::loadFooter($option);
			break;
			case "property_removeUpgrade":
				OspropertyListing::removeUpgrade($option,$cid);
			break;
			case "property_confirmupgrade":
				OspropertyListing::confirmUpgrade($option,$cid);
			break;
			case "property_confirmupgradewithMembership":
				OspropertyListing::confirmUpgradewithMembership($option,$cid);
			break;
			case "property_paymentprocess":
				OspropertyListing::paymentprocess($option,$cid);
			break;
			case "property_loadState":
				OspropertyListing::loadStates($option);
			break;
			case "property_favorites":
				OspropertyListing::favorites($option);
			break;
			case "property_emaildetails":
				OspropertyListing::propertyDetails($id);
			break;
			case "property_thankyou":
				OspropertyListing::thankyouPage($option,$id);
				HelperOspropertyCommon::loadFooter($option);
			break;
			case "property_print":
				OspropertyListing::printProperty($option,$id);
			break;
			case "property_type":
				OspropertyListing::propertyType($option);
				HelperOspropertyCommon::loadFooter($option);
			break;
			case "property_city":
				OspropertyListing::propertyCity($option,$id);
				HelperOspropertyCommon::loadFooter($option);
			break;
			case "property_tag":
				OspropertyListing::propertyTag($option);
				HelperOspropertyCommon::loadFooter($option);
			break;
			case "property_listing":
				global $configClass,$jinput;
				echo HelperOspropertyCommon::buildToolbar('default');
				$catIds			= $jinput->get('catIds',array(),'ARRAY');
				$agent_id    	= $jinput->getInt('agent_id',0);
				$property_type	= $jinput->getInt('property_type',0);
				$keyword		= OSPHelper::getStringRequest('keyword','','post');
				$nbed			= $jinput->getInt('nbed',0);
				$nbath			= $jinput->getInt('nbath',0);
				$isfeatured		= $jinput->getInt('isfeatured',0);
				$isSold			= $jinput->getInt('isSold',0);
				$nrooms			= $jinput->getInt('nrooms',0);
				$orderby		= OSPHelper::getStringRequest('orderby','a.isFeatured desc,a.pro_name',''); //JRequest::getVar('orderby','a.isFeatured desc,a.pro_name','','string');
				$ordertype		= OSPHelper::getStringRequest('ordertype','','');//JRequest::getVar('ordertype','');
				$limitstart		= $jinput->getInt('limitstart',0);
				$limit			= $jinput->getInt('limit',$configClass['general_number_properties_per_page']);
				$favorites		= $jinput->getInt('favorites',0);
				$price			= $jinput->getInt('price',0);
				$company_id		= $jinput->getInt('company_id',0);
				$city_id		= $jinput->getInt('city',0);
				$state_id		= $jinput->getInt('state_id',0);
				$country_id		= OSPHelper::getStringRequest('country_id',HelperOspropertyCommon::getDefaultCountry(),''); //JRequest::getVar('country_id',HelperOspropertyCommon::getDefaultCountry());
				$filterParams	= array();
				
				$u =& JURI::getInstance();
				?>
				<form method="POST" action="<?php echo $u->toString();?>" name="ftForm">
				<?php
				OspropertyListing::listProperties($option,$company_id,$catIds,$agent_id,$property_type,$keyword,$nbed,$nbath,$isfeatured,$isSold,$nrooms,$orderby,$ordertype,$limitstart,$limit,$favorites,$price,$filterParams,$city_id,$state_id,$country_id,0,1,-1);
				?>
				<input type="hidden" name="option" value="<?php echo $option?>" />
				<input type="hidden" name="task" value="property_listing" />
				<input type="hidden" name="Itemid" value="<?php echo $jinput->getInt('Itemid',0)?>" />
				</form>
				<?php
				//HelperOspropertyCommon::loadFooter($option);
			break;
			case "property_showSharingForm":
				OspropertyListing::showSharingForm($id);
			break;
			case "property_submittellfriend":
				OspropertyListing::submitTellfriend($option,$id);
			break;
			case "property_submitcomment":
				OspropertyListing::submitComment($option,$id);
			break;
			case "property_pdf":
				OspropertyListing::exportpdf($option,$id);
			break;
			case "property_captcha":
				OspropertyListing::generateCaptcha($option);
			break;
			case "property_approvaldetails":
				OspropertyListing::approvalDetails($option,$id);
			break;
			case "property_requestapproval":
				OspropertyListing::requestApproval($option,$cid);
			break;
			case "property_processrequestapproval":
				OspropertyListing::processRequestApproval($option,$cid);
			break;
			
			case "property_search":
				OspropertyListing::search($option);
			break;
			case "property_setexpiredInPayment":
				OspropertyListing::setexpiredInPayment($option,$id);
			break;
			case "property_updateEnglandState":
				OspropertyListing::updateEnglandStates($option);
			break;
			case "property_streetview":
				OspropertyListing::showStreetView($option);
			break;
			case "property_advsearch":
				echo HelperOspropertyCommon::buildToolbar('locator');
				OspropertyListing::advSearch($option);
				HelperOspropertyCommon::loadFooter($option);
			break;
            case "property_cancelalertemail":
                OspropertyListing::cancelAlertEmail();
            break;
			case "property_saveSearchList":
				OspropertyListing::saveSearchList($option);
			break;
			case "property_updateSearchList":
				OspropertyListing::updateSearchList($option);
			break;
			case "property_searchlist":
				echo HelperOspropertyCommon::buildToolbar('default');
				OspropertyListing::showSearchList($option);
				HelperOspropertyCommon::loadFooter($option);
			break;
			case "property_savelistname":
				OspropertyListing::saveListName($option);
			break;
			case "property_removesearchlist":
				OspropertyListing::removesearchlist($option);
			break;
			case "property_showRequestMoreDetails":
				OspropertyListing::showRequestMoreDetails($id);
			break;
			case "property_requestmoredetails":
				OspropertyListing::sendRequestDetails($option);
			break;
			case "property_generatelocation":
				OspropertyListing::generateLocation();
			break;
			case "property_changelayout":
				OspropertyListing::changeLayout();
			break;
			case "property_resetdata":
				OspropertyListing::resetData();
			break;
			case "property_generatephoto":
				OspropertyListing::generatePhoto();
			break;
			case "property_savephoto":
				OspropertyListing::savingPhoto();
			break;
			case "property_exportrss":
				OspropertyListing::exportRSS();
			break;
			case "property_reportForm":
				OspropertyListing::reportForm($id);
			break;
			case "property_doreportproperty":
				OspropertyListing::doreportproperty($id);
			break;
			case "property_unfeatured":
				OspropertyListing::unfeaturedproperty($id);
			break;
			case "property_skip":
				OspropertyListing::skip();
			break;
			case "property_getJson":
				OspropertyListing::getjson();
			break;
            case "property_editcomment":
                OspropertyListing::editComment();
            break;
            case "property_submiteditcomment":
                OspropertyListing::submitEditComment();
            break;
			case "property_stas":
				OspropertyListing::stasInformation();
			break;
			case "property_manageallproperties":
				if (!JFactory::getUser()->authorise('frontendmanage', 'com_osproperty')) {
					return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
				}
				OspropertyListing::manageAllProperties($option);
			break;
            case "property_changevalueisFeatured":
				if (!JFactory::getUser()->authorise('frontendmanage', 'com_osproperty')) {
					return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
				}
                OspropertyListing::changeStatus($option,$id,'isFeatured');
            break;
            case "property_changevalueapproved":
				if (!JFactory::getUser()->authorise('frontendmanage', 'com_osproperty')) {
					return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
				}
                OspropertyListing::changeStatus($option,$id,'approved');
                break;
			case "property_changevaluepublished":
				if (!JFactory::getUser()->authorise('frontendmanage', 'com_osproperty')) {
					return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
				}
                OspropertyListing::changeStatus($option,$id,'published');
                break;
			
			case "property_publishproperties":
				if (!JFactory::getUser()->authorise('frontendmanage', 'com_osproperty')) {
					return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
				}
				OspropertyListing::changeStatuses($option,$cid,'published',1);
			break;
			case "property_unpublishproperties":
				if (!JFactory::getUser()->authorise('frontendmanage', 'com_osproperty')) {
					return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
				}
				OspropertyListing::changeStatuses($option,$cid,'published',0);
			break;
			case "property_editproperty":
				if (!JFactory::getUser()->authorise('frontendmanage', 'com_osproperty')) {
					return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
				}
				echo HelperOspropertyCommon::buildToolbar('default');
				OspropertyListing::edit($option,$cid[0],1);
				HelperOspropertyCommon::loadFooter($option);
			break;
			case "property_deleteproperties":
				if (!JFactory::getUser()->authorise('frontendmanage', 'com_osproperty')) {
					return JError::raise(E_WARNING, 404, JText::_('JERROR_ALERTNOAUTHOR'));
				}
				OspropertyListing::deleteProperties($option,$cid,1);
			break;

			case "property_test":
				OspropertyListing::test();
			break;
		}
	}
	
	public static function splitQueries($sql)
	{
		// Initialise variables.
		$buffer		= array();
		$queries	= array();
		$in_string	= false;

		// Trim any whitespace.
		$sql = trim($sql);

		// Remove comment lines.
		$sql = preg_replace("/\n\#[^\n]*/", '', "\n".$sql);

		// Parse the schema file to break up queries.
		for ($i = 0; $i < strlen($sql) - 1; $i ++)
		{
			
			if ($sql[$i] == ";" && !$in_string) {
				$queries[] = substr($sql, 0, $i);
				$sql = substr($sql, $i +1);
				$i = 0;
			}

			if ($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
				$in_string = false;
			}
			elseif (!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset ($buffer[0]) || $buffer[0] != "\\")) {
				$in_string = $sql[$i];
			}
			if (isset ($buffer[1])) {
				$buffer[0] = $buffer[1];
			}
			$buffer[1] = $sql[$i];			
		}

		// If the is anything left over, add it to the queries.
		if (!empty($sql)) {
			$queries[] = $sql;
		}

		return $queries;
	}
	
	function test(){
		global $mainframe;
        $Itemid = 0;
		jimport( 'joomla.document.feed.feed' );
		$db = JFactory::getDbo();
		$db->setQuery("Select * from #__osrs_properties");
		$rows = $db->loadObjectList();
		$doc		= JFactory::getDocument();
		for($i=0;$i<count($rows);$i++){
			$row = $rows[$i];
			$title = $row->pro_name;
			$title = html_entity_decode($title, ENT_COMPAT, 'UTF-8');		
			$link = JRoute::_('index.php?option=com_edocman&view=document&id='.$row->id.'&Itemid='.$Itemid);			
			// feed item description text
			@$created = ($row->created ? date('r', strtotime($row->created)) : '');
			// load individual item creator class
			$item = new JFeedItem();
			$item->title 		= $title;
			$item->link 		= $link;
			$item->description 	= $row->pro_small_desc;
			$item->date			= @$created;
			$item->category		= "lalalaa";						
			$doc->addItem( $item );
		}
		
	}
	
	function generateLocation(){
		global $mainframe;
		$db = JFactory::getDbo();
		$db->setQuery("Select * from t_region");
		$rows = $db->loadObjectList();
		if(count($rows) > 0){
			$stateArr = array();
			for($i=0;$i<count($rows);$i++){
				$row = $rows[$i];
				$region_id = $row->pk_i_id;
				$region_name = $row->s_name;
				$db->setQuery("Select * from t_city where fk_i_region_id = '$region_id'");
				$cities = $db->loadObjectList();
				$city_str = "";
				if(count($cities) > 0){
					$cityArr = array();
					for($j=0;$j<count($cities);$j++){
						$city = $cities[$j];
						$cityArr[] = $city->s_name;
					}
					$city_str = implode(",",$cityArr);
				}
				$state_str = $region_name.":".$city_str;
				$stateArr[] = $state_str;
			}
		}
		
		if(count($stateArr) > 0){
			$return_value = implode("\n",$stateArr);
			$tmp_file = JPATH_ROOT.DS."tmp".DS."bo_bolivia.txt";
			$fb = fopen($tmp_file,"w");
			fwrite($fb,$return_value);
			fclose($fb);
		}
	}
	
	/**
	 * Change layout
	 *
	 */
	function changeLayout(){
		global $mainframe,$jinput;
        $jinput = JFactory::getApplication()->input;
		$viewtype = $jinput->getInt('viewtype',0);
		$url = $jinput->getString('url','');
		@setcookie('viewtypecookie',$viewtype,time()+3600,"/");
		$mainframe->redirect($url);
	}
	
	/**
	 * Show Request More Details
	 *
	 * @param unknown_type $id
	 */
	static function showRequestMoreDetails($id){
		global $mainframe,$configClass,$jinput;
        $jinput = JFactory::getApplication()->input;
		$captcha_value = $jinput->getString('c','');
		$db = JFactory::getDbo();
		$db->setQuery("Select * from #__osrs_properties where id = '$id'");
		$property = $db->loadObject();
		$title = "";
		if($property->ref != ""){
			$title .= $property->ref.", ";
		}
		$title .= OSPHelper::getLanguageFieldValue($property,'pro_name');
		
		//$db->setQuery("Select * from #__osrs_themes where published = '1'");
		//$theme = $db->loadObject();
		//$themename = ($theme->name!= "")? $theme->name:"default";
		$themename = OSPHelper::getThemeName();
		$db->setQuery("Select * from #__osrs_themes where name like '$themename'");
		$themeobj = $db->loadObject();
		if(file_exists(JPATH_COMPONENT.DS."templates".DS.$themename.DS."request.html.tpl.php")){
			$tpl = new OspropertyTemplate();
			$tpl->set('id',$id);
			$tpl->set('title',$title);
			$tpl->set('captcha_value',$captcha_value);
			$tpl->set('configClass',$configClass);
			$body = $tpl->fetch("request.html.tpl.php");	
			echo $body;	
		}
	}
	
	/**
	 * Send details request
	 *
	 * @param unknown_type $option
	 */
	static function sendRequestDetails($option){
		global $mainframe,$configClass,$jinput;
		$db			= JFactory::getDbo();

		$id			= $jinput->getInt('id',0);
		
		$itemid		= OSPRoute::getPropertyItemid($id);

		if($configClass['show_request_more_details'] == 0){
			$msg = JText::_('OS_THIS_FUNCTIONALITY_DOES_NOT_BE_ACTIVATED');
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,$msg);
		}

        $hiddencaptchaname = "csrqt".intval(date("m",time()));

		$captcha_str = $_POST[$hiddencaptchaname];
		$request_security_code = $jinput->getString('request_security_code','');
		if($request_security_code == ''){
			$msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,$msg);
		}
		if($captcha_str == ''){
			$msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,$msg);
		}
		if($request_security_code != $captcha_str){
			$msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,$msg);
		}
		if($configClass['integrate_stopspamforum'] == 1){
			if(OSPHelper::spamChecking()){
				$msg = JText::_('OS_EMAIL_CANT_BE_SENT');
				$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
				$mainframe->redirect($url,$msg);
			}
		}
		
		if($configClass['integrate_stopspamforum'] == 1){
			if(OSPHelper::spamChecking()){
				$msg = JText::_('OS_EMAIL_CANT_BE_SENT');
				$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
				$mainframe->redirect($url,$msg);
			}
		}

        $session = JFactory::getSession();
        $pid = $session->get('pid',0);
        if(($pid == 0) or ($pid != $id)){
            $msg = JText::_('OS_EMAIL_CANT_BE_SENT');
            $url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
            $mainframe->redirect($url,$msg);
        }

		$query = "Select a.email from #__osrs_agents as a inner join #__osrs_properties as b on b.agent_id = a.id where b.id = '$id'";
		$db->setQuery($query);
		$agent_email = $db->loadResult();
		//echo $agent_email;
		$subject = OSPHelper::getStringRequest('subject','','');//JRequest::getVar('subject','');
	
		$your_phone = OSPHelper::getStringRequest('your_phone','',''); //JRequest::getVar('your_phone','');
		$requestmessage = htmlspecialchars($_POST['requestmessage']);
		$requestyour_email = OSPHelper::getStringRequest('requestyour_email','','');//JRequest::getVar('requestyour_email','');
		$requestyour_name = OSPHelper::getStringRequest('requestyour_name','','');//JRequest::getVar('requestyour_name','');
		$sj = "";
		switch ($subject){
			case "1":
				$sj .= JText::_('OS_REQUEST_1');
			break;
			case "2":
				$sj .= JText::_('OS_REQUEST_2');
			break;
			case "3":
				$sj .= JText::_('OS_REQUEST_3');
			break;
			case "4":
				$sj .= JText::_('OS_REQUEST_4');
			break;
			case "5":
				$sj .= JText::_('OS_REQUEST_5');
			break;
			case "6":
				$sj .= JText::_('OS_REQUEST_6');
			break;
			default:
				$sj .= JText::_('OS_REQUEST_MORE_INFOR');
			break;
		}
		$db->setQuery("Select * from #__osrs_properties where id = '$id'");
		$property = $db->loadObject();
		$pro_name = OSPHelper::getLanguageFieldValue($property,'pro_name');
		$ref 	  = $property->ref;
		if($ref != ""){
			$pro_name = "#".$ref." - ".$pro_name;
		}
		
		$subject = JText::_('OS_FROM')." ".$configClass['general_bussiness_name']." - ".$sj;
		$subject = JText::_('OS_REQUEST_MORE_INFOR')." {".$pro_name."} ".JText::_('OS_FROM')." {".$configClass['general_bussiness_name']."}";
		$msg .= JText::_('OS_CUSTOMER').": ".$requestyour_name." <BR />";
		$msg .= JText::_('OS_EMAIL').": ".$requestyour_email." <BR />";
		if($your_phone != ""){
			$msg .= JText::_('OS_PHONE').": ".$your_phone." <BR />";	
		}
		$msg .= JText::_('OS_MESSAGE').": ".$requestmessage." <BR />";
		$msg .= JText::_('OS_PROPERTY')." ID: ".$id."<BR />";
		$url = JRoute::_("index.php?option=com_osproperty&task=property_details&id=".$id."&Itemid=".$itemid);
		$url = JUri::getInstance()->toString(array('scheme', 'user', 'pass', 'host')).$url;
		$msg .= JText::_('OS_PROPERTY')." URL: <a href='".$url."'>".$url."</a>";
		
		$emailfrom = $configClass['general_bussiness_email'];
        if($emailfrom == ""){
            $config = new JConfig();
            $emailfrom = $config->mailfrom;
        }
		$business_name = $configClass['general_bussiness_name'];

		$mailer = JFactory::getMailer();
        $replyto = array();
        if(JMailHelper::isEmailAddress($requestyour_email)) {
            $replyto[] = $requestyour_email;
        }
        if(JMailHelper::isEmailAddress($agent_email)) {
            $mailer->sendMail($emailfrom, $business_name, $agent_email, $subject, $msg, 1, null, null, null, $replyto);
        }
		if(($configClass['copy_admin'] == 1) && (JMailHelper::isEmailAddress($configClass['notify_email']))){
            $mailer = JFactory::getMailer();
            $mailer->sendMail($emailfrom,$business_name,$configClass['notify_email'],$subject,$msg,1);
        }
		//update into database
		$db->setQuery("Update #__osrs_properties set total_request_info = total_request_info + 1  where id = '$id'");
		$db->query();
		
		$tmpl = $jinput->getString('tmpl','');
		if($tmpl == "component"){
			
			?>
			<div style="width:90%;padding:20px;">
				<h2>
					<?php echo JText::_('OS_YOUR_REQUEST_HAS_BEEN_SENT');?>
				</h2>
			</div>
			<?php
		}else{
			$msg = JText::_('OS_YOUR_REQUEST_HAS_BEEN_SENT');
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,$msg);
			
		}
	}
	
	
	static function removesearchlist($option){
		global $mainframe,$jinput;
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		if(intval($user->id) == 0){
			$mainframe->redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
		}
		$chkid = $jinput->get('cid',array(),'ARRAY');
		if(count($chkid) > 0){
			for($i=0;$i<count($chkid);$i++){
				$id = $chkid[$i];
				$db->setQuery("DELETE FROM #__osrs_user_list WHERE id = '$id'");
				$db->query();
				$db->setQuery("DELETE FROM #__osrs_user_list_details WHERE list_id = '$id'");
				$db->query();
			}
		}
		$msg = JText::_('OS_SEARCH_LIST_REMOVED');
		$needs = array();
		$needs[] = "rsearchlist";
		$needs[] = "property_searchlist";
		$itemid = OSPRoute::getItemid($needs);
		$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=property_searchlist&Itemid=".$itemid),$msg);
	}
	
	/**
	 * Show search list
	 *
	 * @param unknown_type $option
	 */
	static function showSearchList($option){
		global $mainframe;
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		if(intval($user->id) == 0){
			$mainframe->redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
		}
		$db->setQuery("Select * from #__osrs_user_list where user_id = '$user->id' order by created_on desc");
		$lists = $db->loadObjectList();
		HTML_OspropertyListing::searchList($option,$lists);
	}
	
	
	static function saveListName($option){
		global $mainframe,$jinput;
		$db = JFactory::getDbo();
		$i = $jinput->getInt('id',0);
		$list_id = $jinput->getInt('list_id',0);
		$list_name = OSPHelper::getStringRequest('list_name','',''); //JRequest::getVar('list_name','');
		$itemid = $jinput->getInt('Itemid',0);
		$db->setQuery("UPDATE #__osrs_user_list set list_name = '$list_name' where id = '$list_id'");
		$db->query();
		
		$db->setQuery("Select * from #__osrs_user_list where id = '$list_id'");
		$list = $db->loadObject();
		?>
		<a href="<?php echo JURI::root()?>index.php?option=com_osproperty&task=property_advsearch&list=1&list_id=<?php echo $list->id?>&Itemid=<?php echo $itemid;?>" title="<?php echo JText::_('OS_GET_SEARCH_RESULT')?>">
			<?php echo $list->list_name?>
		</a>
		<a href="javascript:showInputbox('<?php echo $i?>')">
			<img src="<?php echo JURI::root()?>components/com_osproperty/images/assets/edit.png">
		</a>
		<div id="div_input_<?php echo $i?>" style="display:none;">
			<input type="text" name="list_name_<?php echo $i?>" class="inputbox" value="<?php echo $list->list_name?>" size="40">
			<a href="javascript:saveListName('<?php echo $i?>','<?php echo $list->id?>')">
				<img src="<?php echo JURI::root()?>components/com_osproperty/images/assets/savefavorites.png">
			</a>
		</div>
		<?php
		
	}

    /**
     * Cancel the alert email
     */
    static function cancelAlertEmail(){
        global $mainframe,$jinput;
        $db = Jfactory::getDbo();
        $list_id = $jinput->getString('list_id','');
        if($list_id == ""){
            JError::raiseError( 500, JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA') );
        }else{
            $list_id_array = explode("|",$list_id);
            $list_id = $list_id_array[1];
            $list_id_md5 = $list_id_array[0];
            if($list_id_md5 != md5($list_id)){
                JError::raiseError( 500, JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA') );
            }else{
                $db->setQuery("Update #__osrs_user_list set receive_email = '0' where id = '$list_id'");
                $db->query();
                $mainframe->redirect(JUri::root(),JText::_('OS_YOU_WILL_NOT_RECEIVE_THE_ALERT_EMAILS_ANYMORE'));
            }
        }

    }
	
	/**
	 * Save search list
	 *
	 * @param unknown_type $option
	 */
	static function saveSearchList($option)
    {
        global $mainframe, $configClass,$jinput;
        $db = JFactory::getDbo();
        $keyword        = OSPHelper::getStringRequest('keyword', '');
        $isFeatured     = $jinput->getInt('isFeatured', 0);
        $isSold         = $jinput->getInt('isSold', 0);
        $agent_type     = $jinput->getInt('agent_type', -1);
        $category_id    = $jinput->getInt('category_id', 0);
        $category_ids   = $jinput->get('category_ids',array(),'ARRAY');
        $amenities      = $jinput->get('amenities',array(),'ARRAY');
        $property_type  = $jinput->getInt('property_type', 0);
        $property_types = $jinput->get('property_types',array(),'ARRAY');
        $country_id     = $jinput->getString('country_id', HelperOspropertyCommon::getDefaultCountry());
        $city           = $jinput->getInt('city', 0);
        $state_id       = $jinput->getInt('state_id', 0);
        $nbed           = $jinput->getInt('nbed', 0);
        $nbath          = $jinput->getInt('nbath', 0);
        $price          = $jinput->getInt('price', '');
        $nroom          = $jinput->getInt('nroom', 0);
        $nfloors        = $jinput->getInt('nfloors', 0);
        $min_price      = $jinput->getInt('min_price', 0);
        $max_price      = $jinput->getInt('max_price', 0);
        $sqft_min       = $jinput->getInt('sqft_min', 0);
        $sqft_max       = $jinput->getInt('sqft_max', 0);
        $lotsize_min    = $jinput->getInt('lotsize_min', 0);
        $lotsize_max    = $jinput->getInt('lotsize_max', 0);
        $address        = OSPHelper::getStringRequest('address', '', 'post');
        $sortby         = $jinput->getString('sortby', $configClass['adv_sortby']);
        $orderby        = $jinput->getString('orderby', $configClass['adv_orderby']);
        $lists['address_value'] = $address;
        $param = array();
        if ($address != "") {
            $param[] = "add:" . $address;
        }
        if ($category_id > 0) {
            $param[] = "catid:" . $category_id;
        }
        if (count($category_ids) > 0) {
            foreach ($category_ids as $cat_id) {
                $param[] = "catid:" . $cat_id;
            }
        }
        if (count($amenities) > 0) {
            foreach ($amenities as $amenity) {
                $param[] = "amenity:" . $amenity;
            }
        }
        if ($property_type > 0) {
            $param[] = "type:" . $property_type;
        }
        if (count($property_types) > 0) {
            foreach ($property_types as $type_id) {
                $param[] = "type:" . $type_id;
            }
        }
        if ($city > 0) {
            $param[] = "city:" . $city;
        }
        if ($country_id > 0) {
            $param[] = "country:" . $country_id;
        }
        if ($state_id > 0) {
            $param[] = "state:" . $state_id;
        }
        if ($nbath > 0) {
            $param[] = "nbath:" . $nbath;
        }
        if ($nbed > 0) {
            $param[] = "nbed:" . $nbed;
        }
        if ($nroom > 0) {
            $param[] = "nroom:" . $nroom;
        }
        if ($nfloors > 0) {
            $param[] = "nfloors:" . $nfloors;
        }
        if ($price > 0) {
            $param[] = "price:" . $price;
        }
        if ($agent_type > 0) {
            $param[] = "agent_type:" . $agent_type;
        }
        if ($min_price > 0) {
            $param[] = "min_price:" . $min_price;
        }
        if ($max_price > 0) {
            $param[] = "max_price:" . $max_price;
        }
        if ($sqft_min > 0) {
            $param[] = "sqft_min:" . $sqft_min;
        }
        if ($sqft_max > 0) {
            $param[] = "sqft_max:" . $sqft_max;
        }
        if ($lotsize_min > 0) {
            $param[] = "lotsize_min:" . $lotsize_min;
        }
        if ($lotsize_max > 0) {
            $param[] = "lotsize_max:" . $lotsize_max;
        }
        if ($isFeatured > 0) {
            $param[] = "featured:" . $isFeatured;
        }
        if ($isSold > 0) {
            $param[] = "sold:" . $isSold;
        }
        if ($keyword != "") {
            $param[] = "keyword:". $keyword;
        }
		$param[] = "sortby:".$sortby;
		$param[] = "orderby:".$orderby;
		$db->setQuery("Select * from #__osrs_fieldgroups where published = '1' order by ordering");
		$groups = $db->loadObjectList();
		if(count($groups) > 0){
			$extrafieldSql = array();
			for($i=0;$i<count($groups);$i++){
				$group = $groups[$i];
				$db->setQuery("Select * from #__osrs_extra_fields where group_id = '$group->id' and published = '1' and searchable = '1' order by ordering");
				$fields = $db->loadObjectList();
				$group->fields = $fields;
				
				for($j=0;$j<count($fields);$j++){
					$field = $fields[$j];
					//check do search
					$check = HelperOspropertyFields::checkField($field);
					if($check){
						$dosearch = 1;
						$param[]  = HelperOspropertyFields::getFieldParam($field);
					}
				}
			}
		}
		
		$user = JFactory::getUser();
		$list_name = "List: ".date("Y-m-d H:i:s",time());
		$created_on = date("Y-m-d H:i:s",time());
		$row = &JTable::getInstance('Searchlist','OspropertyTable');
		$row->id = 0;
		$row->user_id = $user->id;
		$row->list_name = $list_name;
		$row->created_on = $created_on;
        $current_language = Jfactory::getLanguage();
        $language_tag = $current_language->getTag();
        $row->lang = $language_tag;

		$row->store();
		
		$list_id = $db->insertid();
		
		if(count($param) > 0){
			$numArr = array('0','1','2','3','4','5','6','7','8','9');
			for($i=0;$i<count($param);$i++){
				$p = $param[$i];
				$pArr = explode(":",$p);
				$type = "";
				if(count($pArr) == 3){
					$name = $pArr[0];
					$type = $pArr[1];
					$value = $pArr[2];
					$firstChar = substr($name,0,1);
				}else{
					$name = $pArr[0];
					$value = $pArr[1];
					$firstChar = substr($name,0,1);
				}
				if(in_array($firstChar,$numArr)){
					//is the extra field
					$db->setQuery("INSERT INTO #__osrs_user_list_details (id,list_id,field_id,field_type,search_type,search_param) VALUES (NULL,'$list_id','$name','1','$type','$value')");
					$db->query();
				}else{
					//is the normal field
					$db->setQuery("INSERT INTO #__osrs_user_list_details (id,list_id,field_id,field_type,search_type,search_param) VALUES (NULL,'$list_id','$name','0','$type','$value')");
					$db->query();
				}
			}
		}
		$msg = JText::_('OS_NEW_SEARCH_LIST_CREATED');
		$needs = array();
		$needs[] = "ladvsearch";
		$needs[] = "property_advsearch";
		$itemid  = OSPRoute::getItemid($needs);
		$itemid  = OSPRoute::confirmItemid($itemid,"ladvsearch");
		if($itemid == 0){
			OSPRoute::confirmItemid($itemid,"property_advsearch");
		}
		$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=property_advsearch&list=1&list_id=$list_id&Itemid=".$itemid),$msg);
	}
	
	
	static function updateSearchList($option){
		global $mainframe,$configClass,$jinput;
		$db = JFactory::getDbo();
        $keyword        = OSPHelper::getStringRequest('keyword', '','post');
        $isFeatured		= $jinput->getInt('isFeatured',0);
        $isSold			= $jinput->getInt('isSold',0);
        $list_id		= $jinput->getInt('list_id',0);
        $agent_type		= $jinput->getInt('agent_type',-1);
        $category_id 	= $jinput->getInt('category_id',0);
        $amenities		= $jinput->get('amenities',array(),'ARRAY');
        $category_ids   = $jinput->get('category_ids',array(),'ARRAY');
        $property_types = $jinput->get('property_types',array(),'ARRAY');
        $property_type	= $jinput->getInt('property_type',0);
        $country_id		= $jinput->getString('country_id',HelperOspropertyCommon::getDefaultCountry());
        $city			= $jinput->getInt('city',0);
        $state_id		= $jinput->getInt('state_id',0);
        $nbed			= $jinput->getInt('nbed',0);
        $nbath			= $jinput->getInt('nbath',0);
        $price			= $jinput->getInt('price','');
        $nroom 			= $jinput->getInt('nroom',0);
        $nfloors		= $jinput->getInt('nfloors',0);
        $min_price		= $jinput->getInt('min_price',0);
        $max_price		= $jinput->getInt('max_price',0);
        $sqft_min 		= $jinput->getInt('sqft_min',0);
        $sqft_max 		= $jinput->getInt('sqft_max',0);
        $lotsize_min 	= $jinput->getInt('lotsize_min',0);
        $lotsize_max 	= $jinput->getInt('lotsize_max',0);
        $sortby			= $jinput->getString('sortby',$configClass['adv_sortby']);
        $orderby		= $jinput->getString('orderby',$configClass['adv_orderby']);
        $address		= OSPHelper::getStringRequest('address','','post');
		$lists['address_value'] = $address;
		$param = array();
		if($address != ""){
			$param[] = "add:".$address;
		}
		if($category_id > 0){
			$param[] = "catid:".$category_id;
		}
		if(count($category_ids) > 0){
			foreach ($category_ids as $cat_id){
				$param[] = "catid:".$cat_id;	
			}
		}
		if(count($amenities) > 0){
			foreach ($amenities as $amenity){
				$param[] = "amenity:".$amenity;	
			}
		}
		if($property_type > 0){
			$param[] = "type:".$property_type;
		}
		if(count($property_types) > 0){
			foreach ($property_types as $type_id){
				$param[] = "type:".$type_id;	
			}
		}
		if($city > 0){
			$param[] = "city:".$city;
		}
		if($country_id > 0){
			$param[] = "country:".$country_id;
		}
		if($state_id > 0){
			$param[] = "state:".$state_id;
		}
		if($nbath > 0){
			$param[] = "nbath:".$nbath;
		}
		if($nbed > 0){
			$param[] = "nbed:".$nbed;
		}
		if($nroom > 0){
			$param[] = "nroom:".$nroom;
		}
		if($nfloors > 0){
			$param[] = "nfloors:".$nfloors;
		}
		if($price > 0){
			$param[] = "price:".$price;
		}
		if($agent_type > 0){
			$param[] = "agent_type:".$agent_type;
		}
		if($min_price > 0){
			$param[] = "min_price:".$min_price;
		}
		if($max_price > 0){
			$param[] = "max_price:".$max_price;
		}
		if($sqft_min > 0){
			$param[] = "sqft_min:".$sqft_min;
		}
		if($sqft_max > 0){
			$param[] = "sqft_max:".$sqft_max;
		}
		if($lotsize_min > 0){
			$param[] = "lotsize_min:".$lotsize_min;
		}
		if($lotsize_max > 0){
			$param[] = "lotsize_max:".$lotsize_max;
		}
		if($isFeatured > 0){
			$param[] = "featured:".$isFeatured;
		}
		if($isSold > 0){
			$param[] = "sold:".$isSold;
		}
        if ($keyword != "") {
            $param[] = "keyword:". $keyword;
        }
		$param[] = "sortby:".$sortby;
		$param[] = "orderby:".$orderby;
		$db->setQuery("Select * from #__osrs_fieldgroups where published = '1' order by ordering");
		$groups = $db->loadObjectList();
		if(count($groups) > 0){
			$extrafieldSql = array();
			for($i=0;$i<count($groups);$i++){
				$group = $groups[$i];
				$db->setQuery("Select * from #__osrs_extra_fields where group_id = '$group->id' and published = '1' and searchable = '1' order by ordering");
				$fields = $db->loadObjectList();
				$group->fields = $fields;
				
				for($j=0;$j<count($fields);$j++){
					$field = $fields[$j];
					//check do search
					$check = HelperOspropertyFields::checkField($field);
					if($check){
						$dosearch = 1;
						$param[]		 = HelperOspropertyFields::getFieldParam($field);
					}
				}
			}
		}
		
		$user = JFactory::getUser();
		$list_name = "List: ".date("Y-m-d H:i:s",time());
		$created_on = date("Y-m-d H:i:s",time());
		$row = &JTable::getInstance('Searchlist','OspropertyTable');
		$row->id = $list_id;
		$row->user_id = $user->id;
		$row->list_name = $list_name;
		$row->created_on = $created_on;
        $current_language = Jfactory::getLanguage();
        $language_tag = $current_language->getTag();
        $row->lang = $language_tag;
		$row->store();
		
		$db->setQuery("DELETE FROM #__osrs_user_list_details WHERE list_id = '$list_id'");
		$db->query();
		
		if(count($param) > 0){
			$numArr = array('0','1','2','3','4','5','6','7','8','9');
			for($i=0;$i<count($param);$i++){
				$p = $param[$i];
				$pArr = explode(":",$p);
				if(count($pArr) == 3){
					$name = $pArr[0];
					$type = $pArr[1];
					$value = $pArr[2];
					
				}else{
					$name = $pArr[0];
					$value = $pArr[1];
				}
				$firstChar = substr($name,0,1);
				if(in_array($firstChar,$numArr)){
					//is the extra field
					$db->setQuery("INSERT INTO #__osrs_user_list_details (id,list_id,field_id,field_type,search_type,search_param) VALUES (NULL,'$list_id','$name','1','$type','$value')");
					$db->query();
				}else{
					//is the normal field
					$db->setQuery("INSERT INTO #__osrs_user_list_details (id,list_id,field_id,field_type,search_type,search_param) VALUES (NULL,'$list_id','$name','0','$type','$value')");
					$db->query();
				}
			}
		}
		$msg = JText::_('OS_SEARCH_LIST_SAVED');
		$needs = array();
		$needs[] = "ladvsearch";
		$needs[] = "property_advsearch";
		$itemid  = OSPRoute::getItemid($needs);
		$itemid  = OSPRoute::confirmItemid($itemid,"ladvsearch");
		if($itemid == 0){
			OSPRoute::confirmItemid($itemid,"property_advsearch");
		}
		$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=property_advsearch&list=1&list_id=$list_id&Itemid=".$itemid),$msg);
	}
	
	/**
	 * Advanced search function
	 *
	 * @param unknown_type $option
	 */
	
	static function advSearch($option){
		global $mainframe,$configClass,$lang_suffix,$jinput;
		$session = JFactory::getSession();
		$db = JFactory::getDbo();
        $prefix_url = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://');
        $url = $prefix_url.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];


        $user = JFactory::getUser();
        $agent_id_permission = 0;
        if($user->id > 0){
            if(HelperOspropertyCommon::isAgent()){
                $agent_id_permission = HelperOspropertyCommon::getAgentID();
            }
        }
		//condition in config
		//check to see if OS Calendar intergrated
		if(file_exists(JPATH_ROOT.DS."components".DS."com_oscalendar".DS."oscalendar.php")){
			if($configClass['integrate_oscalendar'] == 1){
				$start_time = $jinput->getInt('start_time',0);
				$end_time = $jinput->getInt('end_time',0);
				if($start_time != ""){
					@setcookie('start_time',$start_time,time() + 3600,'/');
				}
				if($end_time != ""){
					@setcookie('end_time',$end_time,time() + 3600,'/');
				}
			}
		}
		
		OSPHelper::generateHeading(1,$configClass['general_bussiness_name']." - ".JText::_('OS_ADVSEARCH'));
		$dosearch  		= 0;
		$list = $jinput->getInt('list',0);
		if($list == 1){
			$temp_category_ids = array();
			$temp_type_ids	   = array();
			$temp_amen_ids     = array();
			$list_id = $jinput->getInt('list_id',0);
			$db->setQuery("Select * from #__osrs_user_list_details where list_id = '$list_id'");
			$list_details = $db->loadObjectList();
			for($i=0;$i<count($list_details);$i++){
				$list_detail = $list_details[$i];
				switch ($list_detail->field_id){
                    case "keyword":
                        $jinput->set('keyword',$list_detail->search_param);
                        break;
					case "add":
                        $jinput->set('address',$list_detail->search_param);
					break;
					case "agent_type":
                        $jinput->set('agent_type',$list_detail->search_param);
					break;
					case "catid":
						$temp_category_ids[] = $list_detail->search_param;
					break;
					case "type":
						//JRequest::setVar('property_type',$list_detail->search_param);
						$temp_type_ids[] = $list_detail->search_param;
					break;
					case "amenity":
						$temp_amen_ids[] = $list_detail->search_param;
					break;
					case "country":
                        $jinput->set('country_id',$list_detail->search_param);
					break;
					case "state":
                        $jinput->set('state_id',$list_detail->search_param);
                        break;
                    case "city":
                        $jinput->set('city',$list_detail->search_param);
                        break;
                    case "nbath":
                        $jinput->set('nbath',$list_detail->search_param);
                        break;
                    case "nbed":
                        $jinput->set('nbed',$list_detail->search_param);
                        break;
                    case "price":
                        $jinput->set('price',$list_detail->search_param);
                        break;
                    case "min_price":
                        $jinput->set('min_price',$list_detail->search_param);
                        break;
                    case "max_price":
                        $jinput->set('max_price',$list_detail->search_param);
                        break;
                    case "nroom":
                        $jinput->set('nroom',$list_detail->search_param);
                        break;
                    case "nfloors":
                        $jinput->set('nfloors',$list_detail->search_param);
                        break;
                    case "sqft_min":
                        $jinput->set('sqft_min',$list_detail->search_param);
                        break;
                    case "sqft_max":
                        $jinput->set('sqft_max',$list_detail->search_param);
                        break;
                    case "lotsize_min":
                        $jinput->set('lotsize_min',$list_detail->search_param);
                        break;
                    case "lotsize_max":
                        $jinput->set('lotsize_max',$list_detail->search_param);
                        break;
                    case "featured":
                        $jinput->set('isFeatured',$list_detail->search_param);
                        break;
                    case "sold":
                        $jinput->set('isSold',$list_detail->search_param);
                        break;
                    case "sortby":
                        $jinput->set('sortby',$list_detail->search_param);
                        break;
                    case "orderby":
                        $jinput->set('orderby',$list_detail->search_param);
                        break;
					default:
						HelperOspropertyFields::setFieldValue($list_detail);
					break;
				}
			}
            if(count($temp_category_ids) > 0){
                $jinput->set('category_ids',$temp_category_ids);
            }
            if(count($temp_type_ids) > 0){
                $jinput->set('property_types',$temp_type_ids);
            }
            if(count($temp_amen_ids) > 0){
                $jinput->set('amenities',$temp_amen_ids);
            }
		}
		
		$adv_type_ids = $configClass['adv_type_ids'];
		if(($adv_type_ids != "") and ($adv_type_ids != "0")){
			$adv_type_ids = explode("|",$adv_type_ids);
			if(count($adv_type_ids) > 0){
				$adv_type_ids = $adv_type_ids[0];
			}
		}
		
		$property_type	= $jinput->getInt('property_type',0);
		if($property_type > 0){
			$adv_type		= $jinput->getInt('adv_type',$property_type);
		}else{
			$adv_type		= $jinput->getInt('adv_type',$adv_type_ids);
		}
		$property_types	= array();
		$property_types	= $jinput->get('property_types',array(),'ARRAY');
		if(!in_array($property_type,$property_types)){
			$property_types[count($property_types)] = $property_type;
		}


        $category_id 	= $jinput->getInt('category_id',0);
        $category_ids	=  $jinput->get('category_ids',array(),'ARRAY');
        if(!in_array($category_id,$category_ids)){
            $category_ids[count($category_ids)] = $category_id;
        }

        $agent_type		= $jinput->getInt('agent_type',-1);
        $country_id		= $jinput->getString('country_id',HelperOspropertyCommon::getDefaultCountry());
        $city			= $jinput->getInt('city',0);
        $state_id		= $jinput->getInt('state_id',0);
        $nbed			= $jinput->getInt('nbed',0);
        $nbath			= $jinput->getInt('nbath',0);
        $price			= $jinput->getInt('price',0);
        $nroom 			= $jinput->getInt('nroom',0);
        $nfloors		= $jinput->getInt('nfloors',0);
		$address		= OSPHelper::getStringRequest('address','','get');
		if($address == ""){
			$address		= OSPHelper::getStringRequest('address','','post');
		}
		$address		= $db->escape($address);
		$keyword		= OSPHelper::getStringRequest('keyword','','get'); //JRequest::getVar('keyword','','','string');
		if($keyword == ""){
			$keyword		= OSPHelper::getStringRequest('keyword','','post'); 
		}
		$keyword		= $db->escape($keyword);
        $isFeatured		= $jinput->getInt('isFeatured',0);
        $isSold			= $jinput->getInt('isSold',0);
        $sortby			= $jinput->getString('sortby',$configClass['adv_sortby']);
        $orderby		=  $jinput->getString('orderby',$configClass['adv_orderby']);
        $orderbyArray = array('a.pro_name','a.ref','a.id','a.modified','a.price','a.isFeatured');
        if(!in_array($sortby, $orderbyArray)){
            $sortby = "a.id";
            $orderby = "desc";
        }
        $min_price		= $jinput->getInt('min_price',0);
        $max_price   	= $jinput->getInt('max_price',0);
        $sqft_min		= $jinput->getInt('sqft_min',0);
        $sqft_max		= $jinput->getInt('sqft_max',0);
        $lotsize_min	= $jinput->getInt('lotsize_min',0);
        $lotsize_max	= $jinput->getInt('lotsize_max',0);

		$amenities		= $jinput->get('amenities',array(),'ARRAY');

		if(count($amenities) > 0){
			
			$amenities_str = implode(",",$amenities);
			
			if($amenities_str != ""){
				$amenities_sql = " AND a.id in (SELECT pro_id FROM #__osrs_property_amenities WHERE amen_id in ($amenities_str) group by pro_id having count(pro_id) = ".count($amenities).")";
				$dosearch = 1;
			}else{
				$amenities_sql = "";	
			}
		}else{
			$amenities_sql = "";
		}
        $limitstart		= $jinput->getInt('limitstart',0);
        $limit			= $jinput->getInt('limit',$configClass['general_number_properties_per_page']);
			
		$lists['address_value'] = $address;
		$lists['keyword_value'] = $keyword;
		$param = array();
		if($address != ""){
			$dosearch = 1;
			$param[] = "add:".$address;
		}
		if($keyword != ""){
			$dosearch = 1;
			$param[] = "keyword:".$keyword;
		}
		if($category_id > 0){
			$dosearch = 1;
			$param[] = "catid:".$category_id;
		}
		if(count($category_ids) > 0){
			foreach ($category_ids as $cat_id){
				if($cat_id > 0){
					$dosearch = 1;
					$param[] = "catid:".$cat_id;
				}
			}
		}
		$types = array();
		if($property_type > 0){
			$dosearch = 1;
			$param[] = "type:".$property_type;
			$types[] = $property_type;
		}
		if(count($property_types) > 0){
			foreach ($property_types as $type_id){
				if($type_id > 0){
					$dosearch = 1;
					$param[] = "type:".$type_id;
					$types[] = $type_id;
				}
			}
		}
		if(($country_id > 0) and (HelperOspropertyCommon::checkCountry())){
			$dosearch = 1;
			$param[] = "country:".$country_id;
		}else{
			//$dosearch = 0;
			$param[] = "country:".$country_id;
		}
		if($city > 0){
			$dosearch = 1;
			$param[] = "city:".$city;
		}
		if($state_id > 0){
			$dosearch = 1;
			$param[] = "state:".$state_id;
		}
		if($nbath > 0){
			$dosearch = 1;
			$param[] = "nbath:".$nbath;
		}
		if($nbed > 0){
			$dosearch = 1;
			$param[] = "nbed:".$nbed;
		}
		if($nroom > 0){
			$dosearch = 1;
			$param[] = "nroom:".$nroom;
		}
		if($nfloors > 0){
			$dosearch = 1;
			$param[] = "nfloors:".$nfloors;
		}
		if($price > 0){
			$dosearch = 1;
			$param[] = "price:".$price;
		}
		if($min_price > 0){
			$dosearch = 1;
			$param[] = "min_price:".$min_price;
		}
		if($max_price > 0){
			$dosearch = 1;
			$param[] = "max_price:".$max_price;
		}
		if($sqft_min > 0){
			$dosearch = 1;
			$param[] = "sqft_min:".$sqft_min;
		}
		if($sqft_max > 0){
			$dosearch = 1;
			$param[] = "sqft_max:".$sqft_max;
		}
		if($lotsize_min > 0){
			$dosearch = 1;
			$param[] = "lotsize_min:".$lotsize_min;
		}
		if($lotsize_max > 0){
			$dosearch = 1;
			$param[] = "lotsize_max:".$lotsize_max;
		}
		if($isFeatured == 1){
			$dosearch = 1;
			$param[] = "featured:".$isFeatured;
		}
		if($isSold == 1){
			$dosearch = 1;
			$param[] = "sold:".$isSold;
		}
		if($agent_type >= 0){
			$dosearch = 1;
			$param[] = "agent_type:".$agent_type;
		}
		$param[] = "sortby:".$sortby;
		$param[] = "orderby:".$orderby;
	
		$lists['show_date_range'] = 0;
		$rangeDateQuery = "";
		if($configClass['integrate_oscalendar'] == 1){
			if(file_exists(JPATH_ROOT.DS."components".DS."com_oscalendar".DS."oscalendar.php")){
				if(($start_time != "") and ($end_time != "")){
					$dosearch = 1;
					$rangeDateQuery = OSCHelper::buildDateRangeQuery();
				}
			}
		}
		//checked do search through extra field
		//get the list of the field groups
        $access_sql = ' and access IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';

		$db->setQuery("Select * from #__osrs_fieldgroups where published = '1' $access_sql order by ordering");
		$groups = $db->loadObjectList();
		if(count($groups) > 0){
			$extrafieldSql = array();
			for($i=0;$i<count($groups);$i++){
				$group = $groups[$i];
				$extraSql = "";
				if(count($types) > 0){
					$extraSql = " and id in (Select fid from #__osrs_extra_field_types where type_id in (".implode(",",$types).")) ";
				}elseif($adv_type > 0){
					$extraSql = " and id in (Select fid from #__osrs_extra_field_types where type_id = '$adv_type')";
				}
				$db->setQuery("Select * from #__osrs_extra_fields where group_id = '$group->id' $extraSql and published = '1' and searchable = '1' $access_sql order by ordering");
				//echo $db->getQuery();
				$fields = $db->loadObjectList();
				$group->fields = $fields;
				if(count($fields) > 0){
					for($j=0;$j<count($fields);$j++){
						$field = $fields[$j];
						//check do search
						$check = HelperOspropertyFields::checkField($field);
						if($check){
							$dosearch = 1;
							$sql = HelperOspropertyFields::buildQuery($field);
							if($sql != ""){
								$extrafieldSql[] = $sql;
								$param[]		 = HelperOspropertyFields::getFieldParam($field);
							}
						}
					}
				}
			}
		}
		//build query for searching
		if($dosearch == 1){
			// Query database
			$select = "SELECT distinct a.id, a.*, c.name as agent_name,c.photo as agent_photo, d.id as type_id,d.type_name$lang_suffix as type_name, e.country_name"; 
			$count  = "SELECT count(distinct a.id) "; 
			$from =	 " FROM #__osrs_properties as a"
					." INNER JOIN #__osrs_agents as c on c.id = a.agent_id"
					." INNER JOIN #__osrs_types as d on d.id = a.pro_type"
					." INNER JOIN #__osrs_states as g on g.id = a.state"
					." LEFT JOIN #__osrs_cities as h on h.id = a.city"
					." LEFT JOIN #__osrs_property_categories as i on i.pid = a.id"
					." LEFT JOIN #__osrs_countries as e on e.id = a.country";
			$where = " WHERE a.published = '1' AND a.approved = '1' ";
            if($agent_id_permission > 0){
                $where .= ' and ((a.access IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')) or (a.agent_id = "'.$agent_id_permission.'"))';
            }else {
                $where .= ' and a.access IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
            }
			if($sortby == "a.isFeatured"){
				$Order_by = " ORDER BY $sortby $orderby,a.created desc";
			}else{
				$Order_by = " ORDER BY $sortby $orderby";
			}
			
			if($isFeatured == 1){
				$where .= " AND a.isFeatured = '1'";
			}
			
			if($isSold == 1){
				$where .= " AND a.isSold = '1'";
			}
			
			if($address != ""){
				$address = str_replace(";","",$address);
				if(strpos($address,",")){
					$addressArr = explode(",",$address);
					if(count($addressArr) > 0){
						$where .= " AND (";
						foreach ($addressArr as $address_item){
							$where .= " a.ref like '%$address_item%' OR";
							$where .= " a.pro_name$lang_suffix like '%$address_item%' OR";
							$where .= " a.address like '%$address_item%' OR";
							$where .= " a.region like '%$address_item%' OR";
							$where .= " a.postcode like '%$address_item%' OR";
							$where .= " g.state_name$lang_suffix like '%$address_item%' OR";
							$where .= " h.city$lang_suffix like '%$address_item%' OR";
						}
						$where = substr($where,0,strlen($where)-2);
						$where .= " )";	
					}
				}else{
					$where .= " AND (";
					$where .= " a.ref like '%$address%' OR";
					$where .= " a.pro_name$lang_suffix like '%$address%' OR";
					$where .= " a.address like '%$address%' OR";
					$where .= " a.region like '%$address%' OR";
					$where .= " g.state_name$lang_suffix like '%$address%' OR";
					$where .= " h.city$lang_suffix like '%$address%' OR";
					$where .= " a.postcode like '%$address%'";
					$where .= " )";
				}
				$no_search = false;
			}
			
			if($keyword != ""){
				$where .= " AND (";
				$where .= " a.ref like '%$keyword%' OR";
				$where .= " a.pro_name$lang_suffix like '%$keyword%' OR";
				$where .= " a.pro_small_desc$lang_suffix like '%$keyword%' OR";
				$where .= " a.pro_full_desc$lang_suffix like '%$keyword%' OR";
				$where .= " a.note like '%$keyword%' OR";
				$where .= " a.postcode like '%$keyword%' OR";
				$where .= " g.state_name$lang_suffix like '%$keyword%' OR";
				$where .= " h.city$lang_suffix like '%$keyword%' OR";
				$where .= " a.ref like '%$keyword%'";
				
				$where .= " )";
				$no_search = false;
			}
			if (count($category_ids) >  0){
				$categoryArr = array();
				foreach ($category_ids as $category_id){
					if($category_id > 0){
						$categoryArr = HelperOspropertyCommon::getSubCategories($category_id,$categoryArr);
						$no_search = false;
					}
				}
				$temp = array();
				if(count($categoryArr) > 0){
					foreach($categoryArr as $cat_id){
						$temp[] = " i.category_id = '$cat_id'";
					}
					$tempStr = implode(" or ",$temp);
					$where .= " AND (".$tempStr.")";
				}
			}

			if (count($property_types) >  0){
				$no_search = false;
				//$type_ids = implode(",",$property_types);
				$tempArr = array();
				foreach ($property_types as $type_id){
					if($type_id > 0){
						$tempArr[] = "$type_id";
					}
				}
				if(count($tempArr) > 0){
					$temp_sql = implode(",",$tempArr);
					$where .= " AND a.pro_type in (".$temp_sql.")";
				}
			}
	
			if ($country_id > 0)		{$where .= " AND a.country = '$country_id'";		$no_search = false;}
			if ($city > 0)				{$where .= " AND a.city = '$city'";					$no_search = false;}
			if ($state_id >0)			{$where .= " AND a.state = '$state_id'";			$no_search = false;}
			if ($nbed > 0)				{$where .= " AND a.bed_room >= '$nbed'";			$no_search = false;}
			if ($nbath > 0)				{$where .= " AND a.bath_room >= '$nbath'";			$no_search = false;}
			if ($nroom > 0)				{$where .= " AND a.rooms >= '$nroom'";				$no_search = false;}
			if ($nfloors > 0)			{$where .= " AND a.number_of_floors >= '$nfloors'";	$no_search = false;}
			if ($agent_type >= 0)		{$where .= " AND c.agent_type = '$agent_type'";		$no_search = false;}

			if($price > 0){
				$db->setQuery("Select * from #__osrs_pricegroups where id = '$price'");
				$pricegroup = $db->loadObject();
				$price_from = $pricegroup->price_from;
				$price_to	= $pricegroup->price_to;
				if($price_from  > 0){
					$where .= " AND (a.price >= '$price_from')";
				}
				if($price_to > 0){
					$where .= " AND (a.price <= '$price_to')";
				}
				$no_search = false;
			}
			
			if($min_price > 0){
				$where .= " AND a.price >= '$min_price'";
			}
			if($max_price > 0){
				$where .= " AND a.price <= '$max_price'";
			}
			if($sqft_min > 0){
				$where .= " AND a.square_feet >= '$sqft_min'";
				$lists['sqft_min'] = $sqft_min;
			}
			if($sqft_max > 0){
				$where .= " AND a.square_feet <= '$sqft_max'";
				$lists['sqft_max'] = $sqft_max;
			}
			if($lotsize_min > 0){
				$where .= " AND a.lot_size >= '$lotsize_min'";
				$lists['lotsize_min'] = $lotsize_min;
			}
			if($lotsize_max > 0){
				$where .= " AND a.lot_size <= '$lotsize_max'";
				$lists['lotsize_max'] = $lotsize_max;
			}
			if((isset($extrafieldSql)) AND (count($extrafieldSql)) > 0){
				$extrafieldSql = implode(" AND ",$extrafieldSql);
				if(trim($extrafieldSql) != ""){
					$where .= " AND ".$extrafieldSql;
				}
			}
			
			$where .= $amenities_sql;
			
			$where .= $rangeDateQuery;
			$db->setQuery($count.' '.$from.' '.$where.' '.$Order_by);
			$total = $db->loadResult();
			
			$pageNav = new OSPJPagination($total,$limitstart,$limit);
			
			$view_type_cookie = $jinput->getString('listviewtype','');
			if($view_type_cookie == ""){
				$view_type_cookie = $_COOKIE['viewtypecookie'];	
			}
			if($view_type_cookie == 2){
				$db->setQuery("Select * from #__osrs_themes where published = '1'");
				$theme = $db->loadObject();
				$themename = ($theme->name!= "")? $theme->name:"default";
				$db->setQuery("Select * from #__osrs_themes where name like '$themename'");
				$themeobj = $db->loadObject();
				$params = $themeobj->params;
				$params = new JRegistry($params);
				$max_properties_google_map = $params->get('max_properties_map',50);
				$db->setQuery($select.' '.$from.' '.$where.' '.$Order_by,0,$max_properties_google_map);
			}else{
				$select_session = "Select distinct a.id";
				$db->setQuery($select_session.' '.$from.' '.$where.' '.$Order_by);
				//echo $db->getQuery();
				$sessionObjs = $db->loadColumn(0);
				//print_r($sessionObjs);
				if(count($sessionObjs) > 0){
					$session->set('advsearchresult',$sessionObjs);
				}else{
					$sessionVar = array();
					$session->set('advsearchresult',$sessionVar);
				}
				//print_r($session->get('advsearchresult'));
				$db->setQuery($select.' '.$from.' '.$where.' '.$Order_by,$pageNav->limitstart,$pageNav->limit);
				//echo "<BR />";
				//echo $db->getQuery();
			}
			//echo $db->getQuery();
			$rows = $db->loadObjectList();

            $session->set('advurl',$url);
			if(count($rows) > 0){
				$fields = HelperOspropertyCommon::getExtrafieldInList();
				//get the list of extra fields that show at the list
				for($i=0;$i<count($rows);$i++){//for
					$row = $rows[$i];
					$pro_name = OSPHelper::getLanguageFieldValue($row,'pro_name');
					$row->pro_name = $pro_name;
					
					$pro_small_desc = OSPHelper::getLanguageFieldValue($row,'pro_small_desc');
					$row->pro_small_desc = $pro_small_desc;
					
					$alias = $row->pro_alias;
					$new_alias = OSPHelper::generateAlias('property',$row->id,$row->pro_alias);
					if($alias != $new_alias){
						$db->setQuery("Update #__osrs_properties set pro_alias = '$new_alias' where id = '$row->id'");
						$db->query();
					}
					
					$category_name = OSPHelper::getCategoryNamesOfPropertyWithLinks($row->id);
					$row->category_name = $category_name;
					
					$category_name = OSPHelper::getCategoryNamesOfProperty($row->id);
					$category_nameArr = explode(" ",$category_name);
					$row->category_name_short = "";
					//echo count($category_nameArr);
					//echo "<BR />";
					if(count($category_nameArr) > 4){
						for ($j=0;$j<4;$j++){
							$row->category_name_short .= $category_nameArr[$j]." ";
						}
						$row->category_name_short .= "...";
						//echo $row->category_name;
					}else{
						$row->category_name_short = $category_name;
					}
					
					$query = $db->getQuery(true);
					$query->select("*")->from("#__osrs_property_open")->where("pid='".$row->id."' and end_to > '".date("Y-m-d H:i:s",time())."'")->order("start_from");
					$db->setQuery($query);
					$openInformation = $db->loadObjectList();
					$row->openInformation = $openInformation;
					
					if($row->number_votes > 0){
						$rate = round($row->total_points/$row->number_votes,2);
						if($rate <= 1){
							$row->cmd = JText::_('OS_POOR');
						}elseif($rate <= 2){
							$row->cmd = JText::_('OS_BAD');
						}elseif($rate <= 3){
							$row->cmd = JText::_('OS_AVERGATE');
						}elseif($rate <= 4){
							$row->cmd = JText::_('OS_GOOD');
						}elseif($rate <= 5){
							$row->cmd = JText::_('OS_EXCELLENT');
						}
						$row->rate = $rate;
					}else{
						$row->rate = '';
						$row->cmd  = JText::_('OS_NOT_SET');
					}
					
					$db->setQuery("Select * from #__osrs_comments where pro_id = '$row->id' and published = '1' order by created_on desc");
					$row->commentObject = $db->loadObject();
					
					//get field data
					if(count($fields) > 0){
						$fieldArr = array();
						$k 		  = 0;
						for($j=0;$j<count($fields);$j++){
							$field = $fields[$j];
							if(OSPHelper::checkFieldWithPropertType($field->id,$row->id)){
								$value = HelperOspropertyFieldsPrint::showField($field,$row->id);
								if($value != ""){
									if($field->displaytitle == 1){
										$fieldArr[$k]->label = OSPHelper::getLanguageFieldValue($field,'field_label');
									}
									$fieldArr[$k]->fieldvalue = $value;
									$k++;
								}
							}
						}
						$row->fieldarr = $fieldArr;
					}
					//process photo
					$db->setQuery("select count(id) from #__osrs_photos where pro_id = '$row->id'");
					$count = $db->loadResult();
					if($count > 0){
						$row->count_photo = $count;
						$db->setQuery("select image from #__osrs_photos where pro_id = '$row->id' order by ordering limit 1");	
						$picture = $db->loadResult();
						if($picture != ""){
						
							if(file_exists(JPATH_ROOT.'/images/osproperty/properties/'.$row->id.'/medium/'.$picture)){
								$row->photo = JURI::root().'images/osproperty/properties/'.$row->id.'/medium/'.$picture;	
							}else{
								$row->photo = JURI::root()."/components/com_osproperty/images/assets/nopropertyphoto.png";
							}
						}else{
							$row->photo = JURI::root()."/components/com_osproperty/images/assets/nopropertyphoto.png";
						}
							
					}else{
						$row->count_photo = 0;
						$row->photo = $row->photo = JURI::root()."/components/com_osproperty/images/assets/nopropertyphoto.png";;
					}//end photo
					
					$count = 0;
					if($row->count_photo > 0){
						$db->setQuery("Select * from #__osrs_photos where pro_id = '$row->id'");
						$photos = $db->loadObjectList();
						$photoArr = array();
						for($j=0;$j<count($photos);$j++){
							$photoArr[$j] = $photos[$j]->image;
							if(file_exists(JPATH_ROOT.'/images/osproperty/properties/'.$row->id.'/medium/'.$photos[$j]->image)){
								$count++;
							}
						}
						$row->photoArr = $photoArr;
						$row->count_photo = $count;
					}
					
					//get state
					$db->setQuery("Select state_name$lang_suffix as state_name from #__osrs_states where id = '$row->state'");
					$row->state_name = $db->loadResult();
					
					//get country
					$row->country_name = OSPHelper::getCountryName($row->country);
					//$db->setQuery("Select country_name from #__osrs_countries where id = '$row->country'");
					//$row->country_name = $db->loadResult();
					
					//rating
					if($configClass['show_rating'] == 1){
						if($row->number_votes > 0){
							$points = round($row->total_points/$row->number_votes);
							ob_start();
							?>
								<img src="<?php echo JURI::root()?>components/com_osproperty/images/assets/stars-<?php echo $points;?>.png" />	
							<?php
							$row->rating = ob_get_contents();
							ob_end_clean();
							
						}else{
							ob_start();
							
							?>
							<img src="<?php echo JURI::root()?>components/com_osproperty/images/assets/stars-0.png" />
							<?php
						
							$row->rating = ob_get_contents();
							ob_end_clean();
						} //end rating
					}
					
					//comments
					$db->setQuery("Select count(id) from #__osrs_comments where pro_id = '$row->id'");
					$ncomment = $db->loadResult();
					if($ncomment > 0){
						$row->comment = $ncomment;
					}else{
						$row->comment = 0;
					}
					
				}//for
			}//if rows > 0
		}
		
		$optionArr = array();
		$optionArr[] = JHTML::_('select.option','a.isFeatured',JText::_('OS_FEATURED'));
		$optionArr[] = JHTML::_('select.option','a.ref',JText::_('Ref'));
		$optionArr[] = JHTML::_('select.option','a.pro_name',JText::_('OS_PROPERTY_TITLE'));
		$optionArr[] = JHTML::_('select.option','a.id',JText::_('OS_LISTDATE'));
		$optionArr[] = JHTML::_('select.option','a.modified',JText::_('OS_MODIFIED'));
		$optionArr[] = JHTML::_('select.option','a.price',JText::_('OS_PRICE'));
		if($configClass['use_squarefeet'] == 1){
			if($configClass['use_square'] == 0){
				$optionArr[] = JHTML::_('select.option','a.square_feet',JText::_('OS_SQUARE_FEET'));
			}else{
				$optionArr[] = JHTML::_('select.option','a.square_feet',JText::_('OS_SQUARE_METER'));
			}
		}
		$lists['sortby'] = JHtml::_('select.genericlist',$optionArr,'sortby','class="input-small"','value','text',$sortby);
		
		$optionArr = array();
		$optionArr[] = JHTML::_('select.option','desc',JText::_('OS_DESC'));
		$optionArr[] = JHTML::_('select.option','asc',JText::_('OS_ASC'));
		$lists['orderby'] =  JHtml::_('select.genericlist',$optionArr,'orderby','class="input-medium"','value','text',$orderby);

        ob_start();
        OSPHelper::loadAgentTypeDropdownFilter($agent_type,'input-medium selectpicker','');
        $lists['agenttype'] = ob_get_contents();
        ob_end_clean();

		$lists['category'] = OSPHelper::listCategoriesInMultiple($category_ids,'');
		
		$document = JFactory::getDocument();
		
		//$document->addStyleSheet(JURI::root()."components/com_osproperty/js/chosen/chosen.css");
		//property types
		//$typeArr[] = JHTML::_('select.option','',JText::_('OS_ALL_PROPERTY_TYPES'));
		$db->setQuery("SELECT id as value,type_name$lang_suffix as text FROM #__osrs_types where published = '1' ORDER BY ordering");
		$protypes = $db->loadObjectList();
		//$typeArr   = array_merge($typeArr,$protypes);
		$lists['type'] = JHTML::_('select.genericlist',$protypes,'property_types[]','class="input-large chosen" multiple','value','text',$property_types);
		
		//price
		//$lists['price'] = HelperOspropertyCommon::generatePriceList($adv_type,$price);
		$lists['price_value'] = $price;
		$lists['adv_type'] = $adv_type;
		$lists['min_price'] = $min_price;
		$lists['max_price'] = $max_price;
		//$lists['price'] = $price;
		// number bath room
		$bathArr[] = JHTML::_('select.option','',JText::_('OS_ANY'));
		for($i=1;$i<=5;$i++){
			$bathArr[] = JHTML::_('select.option',$i,$i.'+');
		}
		$lists['nbath'] = JHTML::_('select.genericlist',$bathArr,'nbath',' class="input-small" style="width:100px;"','value','text',$nbath);
		
		
		//number bed room
		$lists['nbed'] = $nbed;
		$bedArr[] = JHTML::_('select.option','',JText::_('OS_ANY'));
		for($i=1;$i<=5;$i++){
			$bedArr[] = JHTML::_('select.option',$i,$i.'+');
		}
		$lists['nbed'] = JHTML::_('select.genericlist',$bedArr,'nbed','class="input-small" style="width:100px;"','value','text',$nbed);
		
		//number bed room
		$lists['room'] = $nroom;
		$roomArr[] = JHTML::_('select.option','',JText::_('OS_ANY'));
		for($i=1;$i<=5;$i++){
			$roomArr[] = JHTML::_('select.option',$i,$i.'+');
		}
		$lists['nroom'] = JHTML::_('select.genericlist',$roomArr,'nroom','class="input-small" style="width:100px;"','value','text',$nroom);
		
		
		//number bed floors
		$lists['nfloors'] = $nfloors;
		$floorArr[] = JHTML::_('select.option','',JText::_('OS_ANY'));
		for($i=1;$i<=5;$i++){
			$floorArr[] = JHTML::_('select.option',$i,$i.'+');
		}
		$lists['nfloor'] = JHTML::_('select.genericlist',$floorArr,'nfloors','class="input-small" style="width:100px;"','value','text',$nfloors);
		
		
		//country
		$lists['country'] = HelperOspropertyCommon::makeCountryList($country_id,'country_id','onchange="change_country_company(this.value)"',JText::_('OS_ALL_COUNTRIES'),'style="width:150px;"');
		
		//$lists['state'] = HelperOspropertyCommon::makeStateList($country_id,$state_id,'state_id','onchange="change_state(this.value,'.intval($city).')"',JText::_('OS_ALL_STATES'),'');
		//list city
		//$lists['city'] = HelperOspropertyCommon::loadCity($option,$state_id, $city);
		if(OSPHelper::userOneState()){
			$lists['state'] = "<input type='hidden' name='state_id' id='state_id' value='".OSPHelper::returnDefaultState()."'/>";
		}else{
			$lists['state'] = HelperOspropertyCommon::makeStateList($country_id,$state_id,'state_id','onchange="change_state(this.value,'.intval($city).')"',JText::_('OS_ALL_STATES'),'');
		}
		
		if(OSPHelper::userOneState()){
			$default_state = OSPHelper::returnDefaultState();
		}else{
			$default_state = $state_id;
		}
		//if(intval($row->state) == 0){
			///$row->state = OSPHelper::returnDefaultState();
		//}
		$lists['city'] = HelperOspropertyCommon::loadCity($option,$default_state,$city);
		
		$db->setQuery("Select * from #__osrs_amenities where published = '1' order by ordering");
		$amenities = $db->loadObjectList();
		$lists['amenities'] = $amenities;
		
		HTML_OspropertyListing::advSearchForm($option,$groups,$lists,$rows,$pageNav,$param,$adv_type,$dosearch);
	}	
	
	/**
	 * Show street view
	 *
	 * @param unknown_type $option
	 */
	static function showStreetView($option){
		global $mainframe,$jinput;
		$db = JFactory::getDbo();
		$id = $jinput->getInt('id');
		$db->setQuery("Select * from #__osrs_properties where id = '$id'");
		$row = $db->loadObject();
		$geocode = array();
		$geocode[0]->lat = $row->lat_add;
		$geocode[0]->long = $row->long_add;
		HelperOspropertyGoogleMap::loadStreetViewMap($geocode,"map_canvas");
	}
	
	
	/**
	 * List properties following by city
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	static function propertyCity($option,$city_id){
		global $mainframe,$_jversion,$configClass,$jinput,$lang_suffix;
        $catIds = $jinput->get('catIds',array(),'ARRAY');
        $type_id = $jinput->getInt('type_id',0);

        //$category_id = $jinput->getInt('category_id',0);
        $category_id = array();
        $show_filter_agent = $jinput->getInt('show_filter_agent',0);
        $show_filter_state = $jinput->getInt('show_filter_state',1);
        $show_filter_keyword = $jinput->getInt('show_filter_keyword',0);
        $show_filter_bed = $jinput->getInt('show_filter_bed',0);
        $show_filter_bath = $jinput->getInt('show_filter_bath',0);
        $show_filter_price = $jinput->getInt('show_filter_price',0);
        $show_filter_room = $jinput->getInt('show_filter_room',0);
		
		
		$menus = JSite::getMenu();
		$menu = $menus->getActive();
		if (is_object($menu)) {
		   
	        $params = new JRegistry() ;
	        $params->loadString($menu->params) ;

            if($type_id == 0){
                $type_id = $params->get('type_id', 0);
                if ($type_id == 0) {
                    $jinput->set('type_id', $type_id);
                }
            }
            if(count($catIds) == 0){
                $category_id = $params->get('catIds',0);
                if(count($catIds) == 0) {
                    $jinput->set('catIds',$category_id);
                }
            }
            if($show_filter_agent == 0){
                $show_filter_agent = $params->get('show_filter_agent',$show_filter_agent);
                if($show_filter_agent == 0){
                    $jinput->set('show_filter_agent',$show_filter_agent);
                }
            }
            if($show_filter_state == 0){
                $show_filter_state = $params->get('show_filter_state',$show_filter_state);
                if($show_filter_state == 0){
                    $jinput->set('show_filter_state',$show_filter_state);
                }
            }
            if($show_filter_keyword == 0){
                $show_filter_keyword = $params->get('show_filter_keyword',$show_filter_keyword);
                if($show_filter_keyword == 0){
                    $jinput->set('show_filter_keyword',$show_filter_keyword);
                }
            }
            if($show_filter_bed == 0){
                $show_filter_bed = $params->get('show_filter_bed',$show_filter_bed);
                if($show_filter_bed == 0){
                    $jinput->set('show_filter_bed',$show_filter_bed);
                }
            }
            if($show_filter_bath == 0){
                $show_filter_bath = $params->get('show_filter_bath',$show_filter_bath);
                if($show_filter_bath == 0){
                    $jinput->set('show_filter_bath',$show_filter_bath);
                }
            }
            if($show_filter_price == 0){
                $show_filter_price = $params->get('show_filter_price',$show_filter_price);
                if($show_filter_price == 0){
                    $jinput->set('show_filter_price',$show_filter_price);
                }
            }
            if($show_filter_room == 0){
                $show_filter_room = $params->get('show_filter_room',$show_filter_room);
                if($show_filter_room == 0){
                    $jinput->set('show_filter_room',$show_filter_room);
                }
            }
		}
		//echo $type_id;
		$db = JFactory::getDbo();
		if($type_id > 0){
			$db->setQuery("Select * from #__osrs_types where id = '$type_id'");
			$type = $db->loadObject();
		}
		
		if($city_id > 0){
			$db->setQuery("Select state_id from #__osrs_cities where id = '$city_id'");
			$state_id = $db->loadResult();
			$db->setQuery("Select country_id from #__osrs_cities where id = '$city_id'");
			$country_id = $db->loadResult();
			$db->setQuery("Select city$lang_suffix as city from #__osrs_cities where id = '$city_id'");
			$city = $db->loadResult();
		}
		
		$country_id = $jinput->getInt('country_id',$country_id);
		$state_id = $jinput->getInt('state_id',$state_id);

		$app = JFactory::getApplication();
        $menus = $app->getMenu('site');
        $menu = $menus->getActive();
		if (is_object($menu)) {
			$link = $menu->link;
			if(strpos($link,"view=ltype") !== false){
				OSPHelper::generateHeading(1,$city,1);
				OSPHelper::generateHeading(2,$city,1);
			}
		}
		

		HTML_OspropertyListing::showPropertyCityListing($option,$type_id,$category_id,$show_filter_agent,$show_filter_state,$show_filter_keyword,$show_filter_bed,$show_filter_bath,$show_filter_price,$show_filter_room,$menu,$city_id,$state_id,$country_id);
	}
	
	/**
	 * Property Tag
	 *
	 * @param unknown_type $option
	 */
	static function propertyTag($option){
		global $mainframe,$configClass,$lang_suffix,$jinput;
        $tag_id = $jinput->getInt('tag_id',0);
        $db = JFactory::getDbo();
        if($tag_id > 0){
            $db->setQuery("Select keyword$lang_suffix as keyword from #__osrs_tags where id = '$tag_id'");
            $tag = $db->loadResult();
            $orderby		= $jinput->getString('orderby','a.created');
            $ordertype		= $jinput->getString('ordertype','desc');
            $limitstart		= $jinput->getInt('limitstart',0);
            $limit			= $jinput->getInt('limit',$configClass['general_number_properties_per_page']);
            $favorites		= $jinput->getInt('favorites',0);
            $price			= $jinput->getInt('price',0);
            $agent_id		= $jinput->getInt('agent_id',0);
            OSPHelper::generateHeading(2,JText::_('OS_LIST_PROPERTIES_WITH_TAG')." [".$tag."]");
            ?>
            <div class="clearfix"></div>
            <form method="POST" action="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_tag&tag_id='.$tag_id.'&Itemid='.$jinput->getInt('Itemid',0))?>" name="ftForm" id="ftForm">
                <?php
                OspropertyListing::listProperties($option,0,null,0,0,'',0,0,0,0,0,$orderby,$ordertype,$limitstart,$limit,0,0,array(),0,0,0,0,1,-1,$tag_id);
                ?>
                <input type="hidden" name="option" value="<?php echo $option?>" />
                <input type="hidden" name="task" value="property_tag" />
                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $jinput->getInt('Itemid',0);?>" />
			<input type="hidden" name="max_properties" id="max_properties" value="" />
			<input type="hidden" name="show_filterform" id="show_filterform" value="1" />
			<input type="hidden" name="show_categoryfilter" id="show_categoryfilter" value="0" />
			<input type="hidden" name="show_propertytypefilter" id="show_propertytypefilter" value="0" />
			<input type="hidden" name="show_locationfilter" id="show_locationfilter" value="0" />
			<input type="hidden" name="show_pricefilter" id="show_pricefilter" value="0" />
			<input type="hidden" name="show_keywordfilter" id="show_keywordfilter" value="0" />
			<input type="hidden" name="show_agenttypefilter" id="show_agenttypefilter" value="0" />	
			</form>
			<?php
		}
	}
	/**
	 * Property type
	 *
	 * @param unknown_type $option
	 */
	static function propertyType($option){
		global $mainframe,$configClass,$jinput;
		$session = JFactory::getSession();
        $itemid		= $jinput->getInt('Itemid');
        if($itemid != $session->get('Itemid')){
            //set session variable empty
            $session->set('orderby','');
            $session->set('ordertype','');
            $session->set('state_id','');
            $session->set('country_id','');
            $session->set('isFeatured','');
            $session->set('isSold','');
            $session->set('city_id','');
            $session->set('catIds',array());
            $session->set('agenttype','');
            $session->set('type_id','');
            $session->set('min_price','');
            $session->set('max_price','');
            $session->set('price','');
            $session->set('Itemid',$itemid);
        }

        $type_id 					= $jinput->getInt('type_id',0);
        $property_type				= $jinput->getInt('property_type',-1);
        if($property_type > -1){
            $type_id = $property_type;
        }
        $catIds 					= $jinput->get('category_id',array(),'ARRAY');
        if(count($catIds) == 0){
            $catIds 					= $jinput->get('catIds',array(),'ARRAY');
        }
        //$catIds 					= $jinput->getArray('category_id',null,array());
        if(count($catIds) == 0){
            //$catIds 				= $jinput->getArray('catIds',null,array());
            $category_id		 	= $jinput->get('category_id',array(),'ARRAY');
            $catIds					= array();
            if(is_array($category_id)){
                $catIds 					= $jinput->get('category_id',array(),'ARRAY');
            }else{
                $catIds[]				= $category_id;
            }
        }
        $submitCategory				= $jinput->getInt('submitCategory',0);

        $isFeatured 				= $jinput->getInt('isFeatured',0);
        if($isFeatured == 0){
            $isFeatured = $session->get('isFeatured',0);
        }
        $isSold						= $jinput->getInt('isSold',0);
        if($isSold == 0){
            $isSold = $session->get('isSold',0);
        }
        $orderby					= OSPHelper::getStringRequest('orderby','','post');
        if($orderby == ""){
            $orderby = $session->get('orderby');
        }
        $ordertype					= OSPHelper::getStringRequest('ordertype','','post');
        if($ordertype == ""){
            $ordertype = $session->get('ordertype');
        }
        $country_id					= $jinput->getInt('country_id',-1);
        if($country_id < 0){
            $country_id = $session->get('country_id');
        }
        $state_id					= $jinput->getInt('state_id',-1);
        if($state_id == -1){
            $state_id = $session->get('state_id');
        }
        $agenttype					= $jinput->getInt('agent_type',-2);
        if($agenttype == -2){
            $agenttype = $session->get('agenttype',-1);
        }
        //print_r($session);
        //$catIds						= $jinput->getArray('category_id',array());

        //$type_id					= $jinput->getInt('property_type',-1);
        if($type_id == -1){
            $type_id = $session->get('type_id');
        }

        $min_price					= $jinput->getFloat('min_price',-1);
        if($min_price == -1){
            $min_price = $session->get('min_price');
        }
        $max_price					= $jinput->getFloat('max_price',-1);
        if($max_price == -1){
            $max_price = $session->get('max_price');
        }
        $price					= $jinput->getFloat('price',-1);
        if($price == -1){
            $price = $session->get('price');
        }

        $show_filter_keyword 		= $jinput->getInt('show_filter_keyword',0);
        $company_id					= $jinput->getInt('company_id',0);
        $limitstart					= $jinput->getInt('limitstart','0');
        $limit						= $jinput->getInt('limit',$configClass['general_number_properties_per_page']);
        $max_properties				= $jinput->getInt('max_properties',0);
        $show_filterform			= $jinput->getInt('show_filterform',$configClass['show_searchform']);
        $show_categoryfilter		= $jinput->getInt('show_categoryfilter',1);
        $show_propertytypefilter	= $jinput->getInt('show_propertytypefilter',1);
        $show_locationfilter		= $jinput->getInt('show_locationfilter',1);
        $show_keywordfilter			= $jinput->getInt('show_keywordfilter',1);
        $show_pricefilter			= $jinput->getInt('show_pricefilter',1);
        $show_agenttypefilter		= $jinput->getInt('show_agenttypefilter',1);

        $city_id = $jinput->getInt('city',-1);
        if($city_id < 0){
            $city_id = $session->get('city_id');
        }
        $menus = JSite::getMenu();
        $menu = $menus->getActive();

        if (is_object($menu)) {
            $params = new JRegistry() ;
            $params->loadString($menu->params);
            if($type_id == -1){
                $type_id_param = $params->get('type_id', 0);
                $jinput->set('type_id', $type_id_param);
            }

            if($isFeatured == 0){
                $isFeatured_param = $params->get('isFeatured', 0);
                if ($isFeatured == 0) {
                    $isFeatured = $isFeatured_param;
                    $jinput->set('isFeatured', $isFeatured_param);
                }
            }

            if($isSold == 0){
                $isSold_param = $params->get('isSold', 0);
                if ($isSold == 0) {
                    $isSold = $isSold_param;
                    $jinput->set('isSold', $isSold_param);
                }
            }

            if($orderby == ""){
                $orderby = $params->get('orderby', 'a.pro_name');
                $jinput->set('orderby', $orderby);
            }

            if($ordertype == ""){
                $ordertype = $params->get('ordertype', 'desc');
                $jinput->set('ordertype', $ordertype);
            }

            if($country_id == 0){
                $country_id_param = $params->get('country_id', 0);
                if ($country_id == 0) {
                    $jinput->set('country_id', $country_id_param);
                }
            }

            //still == 0
            if($country_id == 0){
                $country_id = OSPHelper::getStringRequest('country_id',HelperOspropertyCommon::getDefaultCountry());
            }

            if($company_id == 0){
                $company_id = $jinput->getInt('company_id',0);
            }

            if(((int)$state_id == 0) or ((int)$state_id == -1)){
                $state_id_param = $params->get('state_id', 0);
                if ($state_id_param > 0) {
                    $jinput->set('state_id', $state_id_param);
                    $state_id = $state_id_param;
                }
            }

            if($show_filter_keyword == 0){
                $show_filter_keyword = $params->get('show_filter_keyword',$show_filter_keyword);
                if($show_filter_keyword == 0){
                    $jinput->set('show_filter_keyword',$show_filter_keyword);
                }
            }

            if($max_properties == 0){
                $max_properties = $params->get('max_properties',0);
                if($max_properties == 0) {
                    $jinput->set('max_properties',$max_properties);
                }
            }

            $show_filterform = $params->get('show_filterform');
            if($show_filterform != $configClass['show_searchform']){
                $jinput->set('show_filterform',$show_filterform);
            }

            if(($agenttype == -1) or ($agenttype == "")){
                $agenttype = $params->get('agenttype',-1);
            }

            $show_agenttypefilter 		= $params->get('show_agenttypefilter',1);
            $show_categoryfilter 		= $params->get('show_categoryfilter',1);
            $show_propertytypefilter 	= $params->get('show_propertytypefilter',1);
            $show_locationfilter		= $params->get('show_locationfilter',1);
            $show_keywordfilter 		= $params->get('show_keywordfilter',1);
            $show_pricefilter 			= $params->get('show_pricefilter',1);
        }
        $db = JFactory::getDbo();
        if($type_id > 0){
            $db->setQuery("Select * from #__osrs_types where id = '$type_id'");
            $type = $db->loadObject();
        }
        $session->set('orderby',$orderby);
        $session->set('ordertype',$ordertype);
        $session->set('state_id',$state_id);
        $session->set('country_id',$country_id);
        $session->set('isFeatured',$isFeatured);
        $session->set('isSold',$isSold);
        $session->set('city_id',$city_id);
        $session->set('catIds',$catIds);
        $session->set('agenttype',$agenttype);
        $session->set('type_id',$type_id);
        $session->set('min_price',$min_price);
        $session->set('max_price',$max_price);
        $session->set('price',$price);

		HTML_OspropertyListing::showPropertyTypeListing($option,$type,$catIds,$show_agenttypefilter,0,$show_keywordfilter,0,0,$show_pricefilter,0,$menu,$city_id,$state_id,$country_id,$isFeatured,$isSold,$orderby,$ordertype,$company_id,$max_properties,$show_filterform,$show_categoryfilter,$show_propertytypefilter,$show_locationfilter,$show_keywordfilter,$show_pricefilter,$show_agenttypefilter,$agenttype,$min_price,$max_price,$price);
	}
	
	/**
	 * List properties
	 *
	 * @param unknown_type $option
	 * @param unknown_type $category_id
	 * @param unknown_type $agent_id
	 * @param unknown_type $property_type
	 * @param unknown_type $keyword
	 * @param unknown_type $nbed
	 * @param unknown_type $nbath
	 * @param unknown_type $isfeatured
	 * @param unknown_type $orderby
	 * @param unknown_type $limitstart
	 * @param unknown_type $limit
	 */
	static function listProperties($option,$company_id,$category_ids,$agent_id,$property_type,$keyword,$nbed,$nbath,$isfeatured,$isSold,$nrooms,$orderby,$ordertype,$limitstart,$limit,$favorites,$price,$filterParams,$city_id,$state_id,$country_id,$max_properties,$show_filterform,$agenttype=-1,$tag_id = 0,$min_price=-1,$max_price=-1){
		global $mainframe,$configClass,$lang_suffix,$jinput;
		$limitstart					= OSPHelper::getLimitStart();
		if(!$limit){
			$limit					= $configClass['general_number_properties_per_page'];
		}
        $orderbyArray = array('a.pro_name','a.ref','a.created','a.modified','a.price','a.isFeatured','rand()','a.isFeatured desc, a.id');
        if(!in_array($orderby, $orderbyArray)){
            $orderby = "a.id";
            $ordertype = "desc";
        }

		$viewtype = $jinput->getInt('listviewtype',0);
		$url = $jinput->getString('url','');
		@setcookie('viewtypecookie',$viewtype,time()+3600,"/");
		
		if(intval($limit) == 0){
			$limit = $configClass['general_number_properties_per_page'];
		}
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
        $agent_id_permission = 0;
        if($user->id > 0){
            if(HelperOspropertyCommon::isAgent()){
                $agent_id_permission = HelperOspropertyCommon::getAgentID();
            }
        }
		
		//$db->setQuery("Select * from #__osrs_configuration");
		//$configs = $db->loadObjectList();
        $companyQuery = "";
		if($company_id > 0){
			$companyQuery .= " and a.id in (Select id from #__osrs_properties where agent_id in (Select id from #__osrs_agents where company_id = '$company_id'))";
		}

		$query = "Select count(distinct a.id) from #__osrs_properties as a"
				." INNER JOIN #__osrs_agents as c on c.id = a.agent_id"
				." LEFT JOIN #__osrs_types as d on d.id = a.pro_type"
				." INNER JOIN #__osrs_countries as e on e.id = a.country"
				." LEFT JOIN #__osrs_property_categories as g on g.pid = a.id"
				." WHERE 1=1";

        if($agent_id_permission > 0){
            $query .= ' and ((a.access IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')) or (a.agent_id = "'.$agent_id_permission.'"))';
        }else{
            $query .= ' and a.access IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
        }

        $query .= $companyQuery;
		
		if($keyword != ""){
			$keyword = $db->escape($keyword);
			$query .= " AND (";
			$query .= " a.ref like '%$keyword%' OR";
			$query .= " a.pro_name$lang_suffix like '%$keyword%' OR";
			$query .= " a.ref like '%$keyword%' OR";
			$query .= " a.pro_small_desc$lang_suffix like '%$keyword%' OR";
			$query .= " a.pro_full_desc$lang_suffix like '%$keyword%' OR";
			$query .= " a.address like '%$keyword%' OR";

			$query .= " a.region like '%$keyword%' OR";
			//$query .= " a.province like '%$keyword%' OR";
			$query .= " a.postcode like '%$keyword%' OR";
			$query .= " a.bed_room like '%$keyword%' OR";
			$query .= " a.bath_room like '%$keyword%' OR";
			$query .= " a.parking like '%$keyword%'";
			$query .= " )";
		}
		if($country_id > 0){
			$query .= " AND a.country = '$country_id'";
		}
		if($state_id > 0){
			$query .= " AND a.state = '$state_id'";
		}elseif(OSPHelper::userOneState()){
			$query .= " AND a.state = '".OSPHelper::returnDefaultState()."'";
		}
		if(($city_id > 0) and (($state_id > 0) or (OSPHelper::userOneState()))){
			$query .= " AND a.city = '$city_id'";
		}
		if(is_array($category_ids) and (count($category_ids) > 0) and ($category_ids[0] != "0")){
			$temp = array();
			if(count($category_ids) > 0){
				foreach($category_ids as $cat_id){
					if((int)$cat_id > 0){
						$temp[] = " g.category_id = '$cat_id'";
					}
				}
				$tempStr = implode(" or ",$temp);
				if($tempStr != ""){
					$query .= " AND (".$tempStr.")";
				}
			}
		}

		if($agent_id > 0){
			$query .= " AND a.agent_id = '$agent_id'";
		}

		if($property_type > 0){
			$query .= " AND a.pro_type = '$property_type'";
		}

		if($nbath > 0){
			$query .= " AND a.bath_room >= '$nbath'";
		}
		if($nbed > 0){
			$query .= " AND a.bed_room >= '$nbed'";
		}
		if($nrooms > 0){
			$query .= " AND a.rooms >= '$nrooms'";
		}
		if($isfeatured > 0){
			$query .= " AND a.isFeatured = '$isfeatured'";
		}
		if($isSold > 0){
			$query .= " AND a.isSold = '$isSold'";
		}

		if($price > 0){
			$db->setQuery("Select * from #__osrs_pricegroups where id = '$price'");
			$pricegroup = $db->loadObject();
			$price_from = $pricegroup->price_from;
			$price_to	= $pricegroup->price_to;
			if($price_from  > 0){
				$query .= " AND (a.price >= '$price_from')";
			}
			if($price_to > 0){
				$query .= " AND (a.price <= '$price_to')";
			}
		}

        if($min_price == -1){
            $min_price = $jinput->getFloat('min_price',0);
        }
        if($max_price == -1){
            $max_price = $jinput->getFloat('max_price',0);
        }
		
		$lists['min_price'] = $min_price;
		$lists['max_price'] = $max_price;
		
		if($min_price > 0){
			$query .= " AND a.price >= '$min_price'";
		}
		if($max_price > 0){
			$query .= " AND a.price <= '$max_price'";
		}
		
		if($favorites == 1){
			
			$query .= " AND a.id in (Select pro_id from #__osrs_favorites where user_id = '$user->id')";
		}
		
		if($company_id > 0){
			$query .= " and a.id in (Select id from #__osrs_properties where agent_id in (Select id from #__osrs_agents where company_id = '$company_id'))";
		}
		
		if(intval($agenttype) >=0){
			$query .= " and c.agent_type = '$agenttype'";
		}
		
		if($tag_id > 0){
			$query .= " and a.id in (Select pid from #__osrs_tag_xref where tag_id = '$tag_id')";
		}
		
		$query .= " and a.published = '1' and a.approved = '1'";
		
		$db->setQuery($query);
		$total = $db->loadResult();
		//echo $total;
		if($max_properties > 0){
			if($total > $max_properties){
				$total = $max_properties;	
			}
			
			if($limitstart + $limit > $max_properties){
				$limit_number = $max_properties - $limitstart;
			}else{
				$limit_number = $limit;
			}
		}else{
			$limit_number = $limit;
		}

		if($configClass['overrides_pagination'] == 1){
			$pageNav = new OSPJPagination($total,$limitstart,$limit);
		}else{
			$pageNav = new JPagination($total,$limitstart,$limit);
		}
		
		$query = "Select a.*,c.name as agent_name,c.photo as agent_photo,c.email as agent_email,d.id as typeid,d.type_name$lang_suffix as type_name,e.country_name from #__osrs_properties as a"
				." INNER JOIN #__osrs_agents as c on c.id = a.agent_id"
				." LEFT JOIN #__osrs_types as d on d.id = a.pro_type"
				." LEFT JOIN #__osrs_countries as e on e.id = a.country"
				." LEFT JOIN #__osrs_property_categories as g on g.pid = a.id"
				." WHERE 1=1";
        if($agent_id_permission > 0){
            $query .= ' and ((a.access IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')) or (a.agent_id = "'.$agent_id_permission.'"))';
        }else{
            $query .= ' and a.access IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
        }
		if($keyword != ""){
			$keyword = $db->escape($keyword);
			$query .= " AND (";
			$query .= " a.ref like '%$keyword%' OR";
			$query .= " a.pro_name$lang_suffix like '%$keyword%' OR";
			$query .= " a.ref like '%$keyword%' OR";
			$query .= " a.pro_small_desc$lang_suffix like '%$keyword%' OR";
			$query .= " a.pro_full_desc$lang_suffix like '%$keyword%' OR";
			$query .= " a.address like '%$keyword%' OR";
			$query .= " a.state like '%$keyword%' OR";
			$query .= " a.region like '%$keyword%' OR";
			$query .= " a.postcode like '%$keyword%' OR";
			$query .= " a.bed_room like '%$keyword%' OR";
			$query .= " a.bath_room like '%$keyword%' OR";
			$query .= " a.parking like '%$keyword%'";
			$query .= " )";
		}
		if($country_id > 0){
			$query .= " AND a.country = '$country_id'";
		}
		
		if($state_id > 0){
			$query .= " AND a.state = '$state_id'";
		}elseif(OSPHelper::userOneState()){
			$query .= " AND a.state = '".OSPHelper::returnDefaultState()."'";
		}
		if(($city_id > 0) and (($state_id > 0) or (OSPHelper::userOneState()))){
			$query .= " AND a.city = '$city_id'";
		}

		if(is_array($category_ids) and (count($category_ids) > 0) and ($category_ids[0] != "0")){
			$temp = array();
			if(count($category_ids) > 0){
				foreach($category_ids as $cat_id){
					if((int)$cat_id > 0){
						$temp[] = " g.category_id = '$cat_id'";
					}
				}
				$tempStr = implode(" or ",$temp);
				if($tempStr != ""){
					$query .= " AND (".$tempStr.")";
				}
			}
		}
		
		if($agent_id > 0){
			$query .= " AND a.agent_id = '$agent_id'";
		}
		if($property_type > 0){
			$query .= " AND a.pro_type = '$property_type'";
		}
		if($nbath > 0){
			$query .= " AND a.bath_room >= '$nbath'";
		}
		if($nbed > 0){
			$query .= " AND a.bed_room >= '$nbed'";
		}
		if($nrooms > 0){
			$query .= " AND a.bath_room >= '$nrooms'";
		}
		if($isfeatured > 0){
			$query .= " AND a.isFeatured = '$isfeatured'";
		}
		if($isSold > 0){
			$query .= " AND a.isSold = '$isSold'";
		}
		if($price > 0){
			$db->setQuery("Select * from #__osrs_pricegroups where id = '$price'");
			$pricegroup = $db->loadObject();
			$price_from = $pricegroup->price_from;
			$price_to	= $pricegroup->price_to;
			if($price_from  > 0){
				$query .= " AND (a.price >= '$price_from')";
			}
			if($price_to > 0){
				$query .= " AND (a.price <= '$price_to')";
			}
		}
		
		if($min_price > 0){
			$query .= " AND a.price >= '$min_price'";
		}
		if($max_price > 0){
			$query .= " AND a.price <= '$max_price'";
		}
		
		if($tag_id > 0){
			$query .= " and a.id in (Select pid from #__osrs_tag_xref where tag_id = '$tag_id')";
		}
		
		if($favorites == 1){
			$user = JFactory::getUser();
			$query .= " AND a.id in (Select pro_id from #__osrs_favorites where user_id = '$user->id')";
		}
	
		if($company_id > 0){
			$query .= " and a.id in (Select id from #__osrs_properties where agent_id in (Select id from #__osrs_agents where company_id = '$company_id'))";
		}

		if(intval($agenttype) >=0){
			$query .= " and c.agent_type = '$agenttype'";
		}
		$query .= " and a.published = '1' and a.approved = '1'";
		if($orderby == ""){
			$orderby = "a.id";
		}
        if($orderby == "rand()"){
            $ordertype = "";
        }

		$query .= " GROUP BY a.id ORDER BY $orderby $ordertype";
		
		$view_type_cookie = $jinput->getString('listviewtype','');
		if($view_type_cookie == ""){
			$view_type_cookie = $_COOKIE['viewtypecookie'];	
		}
		if($view_type_cookie == 2){
			$db->setQuery("Select * from #__osrs_themes where published = '1'");
			$theme = $db->loadObject();
			$themename = ($theme->name!= "")? $theme->name:"default";
			
			$db->setQuery("Select * from #__osrs_themes where name like '$themename'");
			$themeobj = $db->loadObject();
			$params = $themeobj->params;
			$params = new JRegistry($params) ;
			$max_properties_google_map = $params->get('max_properties_map',50);
			$db->setQuery($query,0,$max_properties_google_map);	
		}elseif($view_type_cookie == 4){
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			if(count($rows) > 0){
				HelperOspropertyCommon::generateGoogleEarthKML($rows);
			}
			exit();
		}else{
			$db->setQuery($query,$pageNav->limitstart,$limit_number);
		}
		//echo $db->getQuery();
        //die();
		$rows = $db->loadObjectList();
		//print_r($rows);
		//$session = JFactory::getSession();
		//$session->set('advsearchresult',array());


		if(count($rows) > 0){
			$fields = HelperOspropertyCommon::getExtrafieldInList();
			//get the list of extra fields that show at the list
			for($i=0;$i<count($rows);$i++){//for
				$row = $rows[$i];
				
				$pro_name = OSPHelper::getLanguageFieldValue($row,'pro_name');
				$row->pro_name = $pro_name;
				$pro_small_desc = OSPHelper::getLanguageFieldValue($row,'pro_small_desc');
				$row->pro_small_desc = $pro_small_desc;
					
				OSPHelper::generateAlias('property',$row->id,$row->pro_alias);
				$alias = $row->pro_alias;
				$new_alias = OSPHelper::generateAlias('property',$row->id,$row->pro_alias);
				if($alias != $new_alias){
					$db->setQuery("Update #__osrs_properties set pro_alias = '$new_alias' where id = '$row->id'");
					$db->query();
				}
				
				$category_name = OSPHelper::getCategoryNamesOfPropertyWithLinks($row->id);
				$row->category_name = $category_name;
				
				$category_name = OSPHelper::getCategoryNamesOfProperty($row->id);
				$category_nameArr = explode(" ",$category_name);
				$row->category_name_short = "";
				//echo count($category_nameArr);
				//echo "<BR />";
				if(count($category_nameArr) > 4){
					for ($j=0;$j<4;$j++){
						$row->category_name_short .= $category_nameArr[$j]." ";
					}
					$row->category_name_short .= "...";
					//echo $row->category_name;
				}else{
					$row->category_name_short = $category_name;
				}
				
				$query = $db->getQuery(true);
				$query->select("*")->from("#__osrs_property_open")->where("pid='".$row->id."' and end_to > '".date("Y-m-d H:i:s",time())."'")->order("start_from");
				$db->setQuery($query);
				$openInformation = $db->loadObjectList();
				$row->openInformation = $openInformation;
				
				if($row->number_votes > 0){
					$rate = round($row->total_points/$row->number_votes,2);
					if($rate <= 1){
						$row->cmd = JText::_('OS_POOR');
					}elseif($rate <= 2){
						$row->cmd = JText::_('OS_BAD');
					}elseif($rate <= 3){
						$row->cmd = JText::_('OS_AVERGATE');
					}elseif($rate <= 4){
						$row->cmd = JText::_('OS_GOOD');
					}elseif($rate <= 5){
						$row->cmd = JText::_('OS_EXCELLENT');
					}
					$row->rate = $rate;
				}else{
					$row->rate = '';
					$row->cmd  = JText::_('OS_NOT_SET');
				}
				
				$db->setQuery("Select * from #__osrs_comments where pro_id = '$row->id' and published = '1' order by created_on desc");
				$row->commentObject = $db->loadObject();
				
				
				//get field data
				if(count($fields) > 0){
					$fieldArr = array();
					$k 		  = 0;
					for($j=0;$j<count($fields);$j++){
						$field = $fields[$j];
						if(OSPHelper::checkFieldWithPropertType($field->id,$row->id)){
							$value = HelperOspropertyFieldsPrint::showField($field,$row->id);
							if($value != ""){
								if($field->displaytitle == 1){
									$fieldArr[$k]->label = OSPHelper::getLanguageFieldValue($field,'field_label');
								}
								$fieldArr[$k]->fieldvalue = $value;
								$k++;
							}
						}
					}
					$row->fieldarr = $fieldArr;
				}
				//process photo
				$db->setQuery("select count(id) from #__osrs_photos where pro_id = '$row->id'");
				$count = $db->loadResult();
				if($count > 0){
					$row->count_photo = $count;
					$db->setQuery("select image from #__osrs_photos where pro_id = '$row->id' order by ordering limit 1");	
					$picture = $db->loadResult();
					if($picture != ""){
					
						if(file_exists(JPATH_ROOT.'/images/osproperty/properties/'.$row->id.'/medium/'.$picture)){
							$row->photo = JURI::root().'images/osproperty/properties/'.$row->id.'/medium/'.$picture;	
						}else{
							$row->photo = JURI::root()."/components/com_osproperty/images/assets/nopropertyphoto.png";
						}
					}else{
						$row->photo = JURI::root()."/components/com_osproperty/images/assets/nopropertyphoto.png";
					}
						
				}else{
					$row->count_photo = 0;
					$row->photo = $row->photo = JURI::root()."/components/com_osproperty/images/assets/nopropertyphoto.png";;
				}//end photo
				
				$count = 0;
				if($row->count_photo > 0){
					$db->setQuery("Select * from #__osrs_photos where pro_id = '$row->id'");
					$photos = $db->loadObjectList();
					$photoArr = array();
					for($j=0;$j<count($photos);$j++){
						$photoArr[$j] = $photos[$j]->image;
						if(file_exists(JPATH_ROOT.'/images/osproperty/properties/'.$row->id.'/medium/'.$photos[$j]->image)){
							$count++;
						}
					}
					$row->photoArr = $photoArr;
					$row->count_photo = $count;
				}
				//get state
				$db->setQuery("Select state_name$lang_suffix as state_name from #__osrs_states where id = '$row->state'");
				$row->state_name = $db->loadResult();
				
				//get country
				//$db->setQuery("Select country_name from #__osrs_countries where id = '$row->country'");
				//$row->country_name = $db->loadResult();
				$row->country_name = OSPHelper::getCountryName($row->country);
				
				//rating
				if($configClass['show_rating'] == 1){
					if($row->number_votes > 0){
						$points = round($row->total_points/$row->number_votes);
						ob_start();
						
							?>
							<img src="<?php echo JURI::root()?>components/com_osproperty/images/assets/stars-<?php echo $points;?>.png" />
							<?php
						
						$row->rating = ob_get_contents();
						ob_end_clean();
						
					}else{
						ob_start();
						
							?>
							<img src="<?php echo JURI::root()?>components/com_osproperty/images/assets/stars-0.png" />
							<?php
						
						$row->rating = ob_get_contents();
						ob_end_clean();
					} //end rating
				}
				
				//comments
				$db->setQuery("Select count(id) from #__osrs_comments where pro_id = '$row->id'");
				$ncomment = $db->loadResult();
				if($ncomment > 0){
					$row->comment = $ncomment;
				}else{
					$row->comment = 0;
				}
				
			}//for
		}//if rows > 0
		
		//show the query form
		//property types
		$typeArr[] = JHTML::_('select.option','',JText::_('OS_ALL_PROPERTY_TYPES'));
		$db->setQuery("Select id as value,type_name$lang_suffix as text from #__osrs_types where published = '1' order by ordering");
		$protypes = $db->loadObjectList();
		$typeArr   = array_merge($typeArr,$protypes);
		$lists['type'] = JHTML::_('select.genericlist',$typeArr,'property_type','class="input-medium"','value','text',$property_type);
		//categories
		//$lists['category'] = OSPHelper::listCategories($category_id,'');
		$lists['category'] = OSPHelper::checkboxesCategory('category_id[]',$category_ids);
		$lists['country'] = HelperOspropertyCommon::makeCountryList($country_id,'country_id','onChange="javascript:loadStateInListPage()"',JText::_('OS_ALL_COUNTRIES'),' class="input-medium"');
		
		
		$lists['state'] = HelperOspropertyCommon::makeStateList($country_id,$state_id,'state_id','onChange="javascript:changeCity(this.value,'.intval($city_id).') " class="input-large"',JText::_('OS_ALL_STATES'),'');
		
		if(OSPHelper::userOneState()){
			$default_state = OSPHelper::returnDefaultState();
		}else{
			$default_state = $state_id;
		}
		$lists['city'] = HelperOspropertyCommon::loadCity($option,$default_state,$city_id);
		
		//number bed rooms
		$bedArr[] = JHTML::_('select.option','',JText::_('OS_SELECT_MINIMUN_BED_ROOMS'));
		for($i=1;$i<=20;$i++){
			$bedArr[] = JHTML::_('select.option',$i,$i);
		}
		$lists['nbed'] = JHTML::_('select.genericlist',$bedArr,'nbed','style="width:100px;"  class="input-small"','value','text',$nbed);
		
		//number bath rooms
		$bathArr[] = JHTML::_('select.option','',JText::_('OS_SELECT_MINIMUN_BATH_ROOMS'));
		for($i=1;$i<=20;$i++){
			$bathArr[] = JHTML::_('select.option',$i,$i);
		}
		$lists['nbath'] = JHTML::_('select.genericlist',$bathArr,'nbath','style="width:100px;"  class="input-small"','value','text',$nbath);
		
		//number rooms
		$roomsArr[] = JHTML::_('select.option','',JText::_('OS_SELECT_MINIMUN_ROOMS'));
		for($i=1;$i<=20;$i++){
			$roomsArr[] = JHTML::_('select.option',$i,$i);
		}
		$lists['nrooms'] = JHTML::_('select.genericlist',$roomsArr,'nrooms','style="width:100px;" class="input-small"','value','text',$nrooms);
		
		//order by, order type
		$sortBy[] = JHTML::_('select.option','a.pro_name',JText::_('OS_TITLE'));
		$sortBy[] = JHTML::_('select.option','a.ref',JText::_('Ref #'));
		$sortBy[] = JHTML::_('select.option','a.created',JText::_('OS_LIST_DATE'));
		$sortBy[] = JHTML::_('select.option','a.modified',JText::_('OS_MODIFIED'));
		$sortBy[] = JHTML::_('select.option','a.price',JText::_('OS_PRICE'));
		$sortBy[] = JHTML::_('select.option','a.isFeatured',JText::_('OS_FEATURED'));
		$lists['sortby'] = JHTML::_('select.genericlist',$sortBy,'orderby','class="input-small"','value','text',$orderby);
		
		$ordertypeArr[] = JHTML::_('select.option','desc',JText::_('OS_DESC'));
		$ordertypeArr[] = JHTML::_('select.option','asc',JText::_('OS_ASC'));
		$lists['ordertype'] = JHTML::_('select.genericlist',$ordertypeArr,'ordertype','class="input-medium"','value','text',$ordertype);
		
		$lists['keyword'] = $keyword;
		
		$agentArr[] = JHTML::_('select.option','',JText::_('OS_SELECT_AGENT'));
		if($company_id > 0){
			$company_query = " and a.company_id = '$company_id'";
		}else{
			$company_query = " ";
		}
		$db->setQuery("Select a.id as value, a.name as text from #__osrs_agents as a inner join #__users as b on b.id = a.user_id where a.published = '1' $company_query order by a.name");
		$agentlists = $db->loadObjectList();
		$agentArr = array_merge($agentArr,$agentlists);
		$lists['agent'] = JHTML::_('select.genericlist',$agentArr,'agent_id','class = "input-small"','value','text',$agent_id);
		
		$lists['show_filterform'] = $show_filterform;
		$lists['price_value'] = $price;
		$lists['property_type'] = $property_type;
		
		$lists['agenttype'] = $agenttype;
		
		HTML_OspropertyListing::listProperties($option,$rows,$pageNav,$lists,$filterParams);
	}
	
	/**
	 * User favorites
	 *
	 * @param unknown_type $option
	 */
	static function favorites($option){
		global $mainframe,$configClass;
		$db = JFactory::getDBO();
		if(!HelperOspropertyCommon::isUser()){
			$mainframe->redirect(JURI::root(),JText::_('OS_YOU_HAVE_NOT_GOT_PERMISSION_GO_TO_THIS_AREA'));
		}
		$document = JFactory::getDocument();
		OSPHelper::generateHeading(1,$configClass['general_bussiness_name']." - ".JText::_('OS_MY_FAVORITES'));
		
		echo HelperOspropertyCommon::buildToolbar('property');
		
		$user = JFactory::getUser();
		if(intval($user->id) > 0){
			$db->setQuery("Select count(id) from #__osrs_favorites where user_id = '$user->id'");
			$countFav = $db->loadResult();
		}
		HTML_OspropertyListing::favorites($option,$countFav);
	}
	
	
	/**
	 * Property details
	 *
	 * @param unknown_type $option
	 */
	static function details($option){
		global $mainframe,$configClass,$ismobile,$lang_suffix,$languages,$jinput;
		$translatable = JLanguageMultilang::isEnabled() && count($languages);
		$db = JFactory::getDBO();
		$pathway	= $mainframe->getPathway();
		//$db->setQuery("Select * from #__osrs_configuration");
		//$configs = $db->loadObjectList();
		
		$id = $jinput->getInt('id',0);
		if($id == 0){
			JError::raiseError( 404, JText::_('OS_PROPERTY_IS_NOT_AVAILABLE') );
		}
		$db->setQuery("Select * from #__osrs_properties where id = '$id'");
		$property = $db->loadObject();
		if(($property->published == 0) or ($property->approved == 0)){
			JError::raiseError( 404, JText::_('OS_PROPERTY_IS_NOT_AVAILABLE') );
		}
		$pro_name = OSPHelper::getLanguageFieldValue($property,'pro_name');
		$property->pro_name = $pro_name;
		$pro_small_desc = OSPHelper::getLanguageFieldValue($property,'pro_small_desc');
		$property->pro_small_desc = $pro_small_desc;
		$pro_full_desc = OSPHelper::getLanguageFieldValue($property,'pro_full_desc');
		$property->pro_full_desc = $pro_full_desc;
		if(($property->published == 0) or ($property->approved == 0)){
			$redirect_link = $configClass['property_not_avaiable'];
			if($redirect_link != ""){
				$mainframe->redirect($redirect_link,JText::_("OS_PROPERTY_IS_NOT_AVAILABLE"));
			}else{
				JError::raiseError( 404, JText::_('OS_PROPERTY_IS_NOT_AVAILABLE') );
			}
		}

		$document = JFactory::getDocument();

		//find Itemid of property
		$needs = array();
		$needs[] = "property_details";
		$needs[] = $id;
		$property_item_id = OSPRoute::getItemid($needs);

		
		$show_meta = 1;
		$itemid = $jinput->getInt('Itemid',0);

		if($itemid != $property_item_id){
			foreach ( $document->_links as $k => $array ) {
				if ( $array['relation'] == 'canonical' ) {
					unset($document->_links[$k]);
				}
			}
			$plink = JUri::getInstance()->toString(array('scheme', 'user', 'pass', 'host')).JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$property_item_id);
			$document->addCustomTag('<link rel="canonical" content="'.$plink.'" />');
		}

		if($itemid > 0){
			$menus = JSite::getMenu();
			$current_menu = $menus->getItem($itemid);
			$current_menu_query = $current_menu->query;
			$view = $current_menu_query['view'];
			if($view == "ldetails"){
				$current_menu_params = $current_menu->params;
				//$show_page_heading = $current_menu_params['show_page_heading'];
				$page_heading = $current_menu_params['page_heading'];
				if($page_heading != ""){
					$property->pro_name = $page_heading;
				}
				$page_title = $current_menu_params['page_title'];
				if($page_title != ""){
					//page title
					OSPHelper::generateHeading(1,$page_title);
				}elseif(OSPHelper::getLanguageFieldValue($property,'pro_browser_title') != ""){
					OSPHelper::generateHeading(1,OSPHelper::getLanguageFieldValue($property,'pro_browser_title'));
				}else{
					//page title
					OSPHelper::generateHeading(1,OSPHelper::getLanguageFieldValue($property,'pro_name'));
				}

				$meta_description = $current_menu_params['menu-meta_description'];
				if($meta_description != ""){
					$document->setMetaData( "description", $meta_description ); 
					$show_meta = 0;
				}
			}elseif(OSPHelper::getLanguageFieldValue($property,'pro_browser_title') != ""){
				OSPHelper::generateHeading(1,OSPHelper::getLanguageFieldValue($property,'pro_browser_title'));
			}else{
				//page title
				OSPHelper::generateHeading(1,OSPHelper::getLanguageFieldValue($property,'pro_name'));
			}
		}elseif(OSPHelper::getLanguageFieldValue($property,'pro_browser_title') != ""){
			OSPHelper::generateHeading(1,OSPHelper::getLanguageFieldValue($property,'pro_browser_title'));
		}else{
			//page title
			OSPHelper::generateHeading(1,OSPHelper::getLanguageFieldValue($property,'pro_name'));
		};

		//store this property into cookie
		$session = JFactory::getSession();
        $session->set('pid',$property->id);//add Property ID into session
		$recent_properties_viewed = array();
		$recent_properties_viewed_str = $session->get('recent_properties_viewed',''); //$_COOKIE['recent_properties_viewed'];
		if($recent_properties_viewed_str != ""){
			$recent_properties_viewed = explode(",",$recent_properties_viewed_str);
		}
		if(count($recent_properties_viewed) == 0){
			$recent_properties_viewed[] = $id;
		}else{
			if(!in_array($id,$recent_properties_viewed)){
				$recent_properties_viewed[] = $id;
			}else{
				$key = array_search($id,$recent_properties_viewed);
				unset($recent_properties_viewed[$key]);
				$recent_properties_viewed[] = $id;
			}
		}
		$session->set('recent_properties_viewed',implode(",",$recent_properties_viewed));
		$agent_id = $property->agent_id;
		$user = JFactory::getUser();
		$owner = 0;
		if(intval($user->id) > 0){
			$db->setQuery("Select count(a.id) from #__osrs_agents as a inner join #__users as b on b.id = a.user_id where a.user_id = '$user->id'");
			$countagent = $db->loadResult();
			if($countagent > 0){
				$db->setQuery("Select id from #__osrs_agents where user_id = '$user->id'");
				$user_agent_id = $db->loadResult();
				if($user_agent_id == $agent_id){
					$owner = 1;
				}
			}
			//check to see if user is already comments for this property
            /*
			if($owner == 0){
				$db->setQuery("Select count(id) from #__osrs_comments where pro_id = '$property->id' and user_id = '$user->id'");	
				$isAlreadyComment = $db->loadResult();
				if($isAlreadyComment > 0){
					$owner = 1;
				}
			}
            */
		}

		if($show_meta == 1){
			// set meta keywords
			$keywords = "";
			if($property->id){
				$query = "Select a.* from #__osrs_tags as a inner join #__osrs_tag_xref as b on b.tag_id = a.id where b.pid = '$property->id'";
				$db->setQuery($query);
				$tags = $db->loadObjectList();
			}

			if($translatable){
				$metadesc = $property->{'metadesc'.$lang_suffix};
				
				if($metadesc == ""){
					$metadesc = $property->metadesc;
				}
				if(count($tags) > 0){
					$tagArr = array();
					foreach ($tags as $tag){
						$tagArr[] = $tag->{'keyword'.$lang_suffix};
					}
					if(count($tagArr) > 0){
						$keywords = implode(", ",$tagArr);
					}
				}
			}else{
				$metadesc = $property->metadesc;

				if(count($tags) > 0){
					$tagArr = array();
					foreach ($tags as $tag){
						$tagArr[] = $tag->keyword;
					}
					if(count($tagArr) > 0){
						$keywords = implode(", ",$tagArr);
					}
				}
			}
			
			$orig_metakey = $document->getMetaData('keywords');
			if( $keywords != "" ) $document->setMetaData( "keywords", $keywords );

			$orig_metadesc = $document->getMetaData('description');
			if( $property->metadesc ) $document->setMetaData( "description", $metadesc );  
		}
		
		$access = $property->access;
        if(!in_array($access,JFactory::getUser()->getAuthorisedViewLevels()) and (!HelperOspropertyCommon::isOwner($property->id))){
			$mainframe->redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
		}
		
		//add pathway
		$catArr = array();
		$catArr = HelperOspropertyCommon::getCatList($property->category_id,$catArr);
		if($configClass['include_categories'] == 1) {
			if(count($catArr) > 0){
				for($i=0;$i<count($catArr);$i++){
					$pathway->addItem($catArr[$i]->cat_name,JRoute::_('index.php?option=com_osproperty&task=category_details&id='.$catArr[$i]->id.'&Itemid='.$jinput->getInt('Itemid',0)));
				}
			}
		}
		$type_id = $property->pro_type;
		$db->setQuery("Select * from #__osrs_types where id = '$type_id'");
		$type = $db->loadObject();
		$type_name = OSPHelper::getLanguageFieldValue($type,'type_name');
		$needs = array();
		$needs[] = "ltype";
		$needs[] = "property_type";
		$needs[] = "type_id=".$type_id;
		$itemid  = OSPRoute::getItemid($needs);
        if($configClass['include_type'] == 1) {
            $pathway->addItem($type_name, JRoute::_('index.php?option=com_osproperty&view=ltype&type_id=' . $type_id . '&Itemid=' . $itemid));
        }
		$needs = array();
		$needs[] = "property_type";
		$needs[] = $property->id;
		$itemid  = OSPRoute::getItemid($needs);
        if($configClass['include_categories'] == 1) {
            $pathway->addItem(OSPHelper::getLanguageFieldValue($property, 'pro_name'), JRoute::_('index.php?option=com_osproperty&task=property_details&id=' . $property->id . '&Itemid=' . $itemid));
        }

		//increase hits
		$user_data = "";
		$user_data = $_COOKIE['osp_user_data'.$property->id];
		if($user_data == ""){
			$user_data = md5(time());
			setcookie('osp_user_data'.$property->id,$user_data,time() + 3600);
			//increase hits
			$hits = $property->hits;
			$hits++;
			$db->setQuery("Update #__osrs_properties set hits = '$hits' where id = '$property->id'");
			$db->query();
			$hit_time = time();
			setcookie('osp_hit_time'.$property->id,$hit_time,time() + 3600);
		}else{
			$hit_time = $_COOKIE['osp_hit_time'.$property->id];
			if($hit_time <= time() - 3600){
				$hits = $property->hits;
				$hits++;
				$db->setQuery("Update #__osrs_properties set hits = '$hits' where id = '$property->id'");
				$db->query();
			}
		}
		
		//get the list of photos
		$db->setQuery("Select image from #__osrs_photos where pro_id = '$property->id' order by ordering");
		$image = $db->loadResult();
		if($image != ""){
			if(file_exists(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$id.DS."medium".DS.$image)){
				$link = JUri::root()."images/osproperty/properties/".$id."/medium/".$image;
				$document->addCustomTag('<link rel="image_src" href="'.$link.'" />');
				$document->addCustomTag('<meta property="og:image" content="'.$link.'" />');
			}
		}
        $document->addCustomTag( '<meta property="og:title" content="'.$pro_name.'" />' );
        $uri = JURI::getInstance();
        $document->addCustomTag( '<meta property="og:url" content="'.htmlspecialchars( $uri->toString() ).'" />' );
        $document->addCustomTag( '<meta property="og:type" content="website" />' );
        $document->addCustomTag( '<meta property="og:description" content="'.OSPHelper::getLanguageFieldValue($property,'pro_small_desc').'" />' );

		//pro_video
		if($property->pro_video != ""){
			$property->pro_video = "<div class='video-container'>".$property->pro_video."</div>";
		}
		
		//country;
		//$db->setQuery("select country_name from #__osrs_countries where id = '$property->country'");
		$property->country_name = OSPHelper::getCountryName($property->country);
		
		//state;
		$db->setQuery("select state_name$lang_suffix as state_name from #__osrs_states where id = '$property->state'");
		$property->state_name = $db->loadResult();
		
		//cat;
		$db->setQuery("select * from #__osrs_categories where id = '$property->category_id'");
		$category = $db->loadObject();
		$property->category_name = OSPHelper::getCategoryNamesOfPropertyWithLinks($property->id);
		
		//type;
		$db->setQuery("select * from #__osrs_types where id = '$property->pro_type'");
		$property_type = $db->loadObject();
		$property->type_name = OSPHelper::getLanguageFieldValue($property_type,'type_name');
		
		
		$optionArr = array();
		$optionArr[] = JText::_('OS_GENERAL_AMENITIES');
		$optionArr[] = JText::_('OS_ACCESSIBILITY_AMENITIES');
		$optionArr[] = JText::_('OS_APPLIANCE_AMENITIES');
		$optionArr[] = JText::_('OS_COMMUNITY_AMENITIES');
		$optionArr[] = JText::_('OS_ENERGY_SAVINGS_AMENITIES');
		$optionArr[] = JText::_('OS_EXTERIOR_AMENITIES');
		$optionArr[] = JText::_('OS_INTERIOR_AMENITIES');
		$optionArr[] = JText::_('OS_LANDSCAPE_AMENITIES');
		$optionArr[] = JText::_('OS_SECURITY_AMENITIES');
		$l = 0;
        if($configClass['show_unselected_amenities'] == 1) {
            ob_start();
            foreach ($optionArr as $amen_cat) {
                $query = "Select * from #__osrs_amenities where published = '1' and category_id = '$l' order by ordering";
                $db->setQuery($query);
                $amenities = $db->loadObjectList();

                $query = "Select a.id from #__osrs_amenities as a"
                    . " inner join #__osrs_property_amenities as b on b.amen_id = a.id"
                    . " where a.published = '1' and b.pro_id = '$property->id' and a.category_id = '$l' order by a.ordering";
                $db->setQuery($query);
                $property_amenities = $db->loadColumn(0);
                $amens_str1 = "";
                if (count($amenities) > 0) {
                    $amens_str = "";
                    $j = 0;
                    $k = 0;
                    if ($configClass['amenities_layout'] == 1) {
                        $span = "span6";
                        $jump = 2;
                    } else {
                        $span = "span4";
                        $jump = 3;
                    }
                    ?>
                    <div class="row-fluid">
                        <h5><strong><?php echo $amen_cat?></strong></h5>
                    </div>
                    <div class="row-fluid">
                        <?php
                        for ($i = 0; $i < count($amenities); $i++) {
                            $k++;
                            $amen = $amenities[$i];
                            if (in_array($amen->id, $property_amenities)) {
                                $style = "color:#99103A;";
                                $style1 = "";
                            } else {
                                $style = "color:#CCC;";
                                $style1 = $style;
                            }
                            ?>
                            <div class="<?php echo $span;?>" style="<?php echo $style1;?>">
                                <i class='osicon-ok'
                                   style="<?php echo $style;?>"></i> <?php echo OSPHelper::getLanguageFieldValue($amen, 'amenities');?>
                            </div>
                            <?php
                            if ($k % $jump == 0) {
                                $k = 0;
                                echo "</div><div class='row-fluid'>";
                            }
                        }
                        ?>
                    </div>
                <?php
                }
                $l++;
            }
            $amens_str = ob_get_contents();
            ob_end_clean();
        }else{
            ob_start();
            foreach ($optionArr as $amen_cat){
                $query = "Select a.* from #__osrs_amenities as a"
                    ." inner join #__osrs_property_amenities as b on b.amen_id = a.id"
                    ." where a.published = '1' and b.pro_id = '$property->id' and a.category_id = '$l' order by a.ordering";
                $db->setQuery($query);
                $amens = $db->loadObjectList();
                $amens_str1 = "";
                if(count($amens) > 0){
                    $amens_str = "";
                    $j = 0;
                    $k = 0;
                    if($configClass['amenities_layout'] == 1){
                        $span = "span6";
                        $jump = 2;
                    }else{
                        $span = "span4";
                        $jump = 3;
                    }
                    ?>
                    <div class="row-fluid">
                        <h5><strong><?php echo $amen_cat?></strong></h5>
                        <div class="span12">
                            <?php
                            for($i=0;$i<count($amens);$i++){
                                $k++;
                                $amen = $amens[$i];
                                ?>
                                <div class="<?php echo $span;?>">
                                    <i class='osicon-ok'></i> <?php echo OSPHelper::getLanguageFieldValue($amen,'amenities');?>
                                </div>
                                <?php
                                if($k % $jump == 0){
                                    $k = 0;
                                    echo "</div><div class='span12' style='min-height:0px !important;'>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php
                }
                $l++;
            }
            $amens_str = ob_get_contents();
            ob_end_clean();
        }
		$property->amens_str = $amens_str;
		$property->amens_str1 = $amens_str;

		//get the field groups
        $access_sql = ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';

		$extra_field_groups = array();
		$db->setQuery("Select * from #__osrs_fieldgroups where published = '1' $access_sql order by ordering");
		$fieldgroups = $db->loadObjectList();
		$j = 0;
		if(count($fieldgroups) > 0){
			for($i=0;$i<count($fieldgroups);$i++){
				$fieldgroup = $fieldgroups[$i];

                $access_sql = ' and b.access IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
				$checkgroup = HelperOspropertyFields::checkFieldData($property->id, $fieldgroup->id);
				
				if($checkgroup == 1){
					$extra_field_groups[$j]->group_name = OSPHelper::getLanguageFieldValue($fieldgroup,'group_name');
					$extra_field_groups[$j]->fields = HelperOspropertyFields::getFieldsData($property->id, $fieldgroup->id);
					$j++;
				}
			}
		}
		
		$property->extra_field_groups = $extra_field_groups;
		
		//agent information
		$db->setQuery("Select * from #__osrs_agents where id = '$property->agent_id'");
		$agent = $db->loadObject();
		
		//agent country;
		//$db->setQuery("select country_name from #__osrs_countries where id = '$agent->country'");
		$agent->country_name = OSPHelper::getCountryName($agent->country);
		
		//agent state;
		$db->setQuery("select state_name$lang_suffix as state_name from #__osrs_states where id = '$agent->state'");
		$agent->state_name = $db->loadResult();
		
		$db->setQuery("Select count(id) from #__osrs_properties where published = '1' and approved = '1' and agent_id = '$property->agent_id'");
		$agent->countlisting = $db->loadResult();
		$property->agent = $agent;
		
		$db->setQuery("Select * from #__osrs_comments where pro_id = '$id' and published = '1' order by created_on desc");
		$comments = $db->loadObjectList();
		$property->comments = $comments;

		$property->core_fields			= OSPHelper::showCoreFields($property);
		
		//it in search result
		$session = JFactory::getSession();
		$advsearchresult = $session->get('advsearchresult',array());
		
		if(count($advsearchresult) > 0){
			$property->pagination = 1;
			$key = array_search($id,$advsearchresult);
			//echo $key;
			//echo $id;
			if($key == 0){
				$prev = $advsearchresult[count($advsearchresult)-1];
				$next = $advsearchresult[1];
			}elseif($key == count($advsearchresult)-1){
				$prev = $advsearchresult[$key - 1];
				$next = $advsearchresult[0];
			}else{
				$prev = $advsearchresult[$key - 1];
				$next = $advsearchresult[$key + 1];
			}
			$property->next = $next;
			$property->prev = $prev;
			$itemid = OSPRoute::getPropertyItemid($property->next);
			$property->next_link = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->next.'&Itemid='.$itemid);
			$db->setQuery("Select pro_type,pro_name,pro_name".$lang_suffix." from #__osrs_properties where id = '$property->next'");
			$nextObj = $db->loadObject();			
			$property->next_property = OSPHelper::getLanguageFieldValue($nextObj,"pro_name");
			$db->setQuery("Select type_name,type_name".$lang_suffix." from #__osrs_types where id = '$nextObj->pro_type'");
			$property->next_type = OSPHelper::getLanguageFieldValue($db->loadObject(),"type_name");
			
			$itemid = OSPRoute::getPropertyItemid($property->prev);
			$property->prev_link = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->prev.'&Itemid='.$itemid);
			$db->setQuery("Select pro_type,pro_name,pro_name".$lang_suffix." from #__osrs_properties where id = '$property->prev'");
			$prevObj = $db->loadObject();	
			$property->prev_property = OSPHelper::getLanguageFieldValue($prevObj,"pro_name");
			$db->setQuery("Select type_name,type_name".$lang_suffix." from #__osrs_types where id = '$prevObj->pro_type'");
			$property->prev_type = OSPHelper::getLanguageFieldValue($db->loadObject(),"type_name");
		}else{
			$property->pagination = 0;
		}
		
		//allow to show the relate properties
		if($configClass['relate_properties'] == 1){
			$radius_search = $configClass['relate_distance'];
			if(intval($radius_search) == 0){
				$radius_search = 5;
			}
			$multiFactor = 3959;
			// Search the rows in the table
			$select = sprintf(", ( %s * acos( cos( radians('%s') ) * 
								cos( radians( pr.lat_add ) ) * cos( radians( pr.long_add ) - radians('%s') ) + 
								sin( radians('%s') ) * sin( radians( pr.lat_add ) ) ) ) 
								AS distance",
								$multiFactor,
								doubleval($property->lat_add),
								doubleval($property->long_add),
								doubleval($property->lat_add)
								);
			$where = sprintf("	HAVING distance < '%s'", doubleval($radius_search));
			
			$Order_by = " ORDER BY distance ASC, pr.isFeatured desc ";
			$sql =   " SELECT pr.* "
					."\n, ci.city AS city_name"
					."\n, st.state_name" 
					."\n, co.country_name"
					."\n, ty.type_name$lang_suffix, ty.id as type_id"
					.$select
					."\n FROM #__osrs_properties pr"
					."\n LEFT JOIN #__osrs_cities AS ci ON ci.id = pr.city "
					."\n LEFT JOIN #__osrs_states AS st ON st.id = pr.state"
					."\n LEFT JOIN #__osrs_countries AS co ON co.id = pr.country"
					."\n INNER JOIN #__osrs_types AS ty ON ty.id = pr.pro_type"
					
					."\n WHERE 	pr.approved  = '1' and pr.published = '1'"
					."\n AND pr.access IN (" . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ")"
					."\n AND	pr.id 	   	<> '$property->id' AND 	pr.state 	 = '$property->state' ";
			//if($configClass['relate_property_type'] == 1){
				//$sql .= "\n AND 	pr.pro_type  = '$property->pro_type'";
			//}
			if($configClass['relate_city'] == 1){
				$sql .= "\n AND 	pr.city		 = '$property->city'";
			}
			if($configClass['relate_category'] == 1){
				//$sql .= "\n AND 	pr.category_id		 = '$property->category_id'";
			}
			$sql .=	$where.$Order_by;
			if($configClass['max_relate'] > 0){
				$sql .= " LIMIT ".$configClass['max_relate'];
			}
			$db->setQuery($sql);
			//echo $db->getQuery();
			$relates = $db->loadObjectList();
			if (count($relates)){
				for($i=0;$i<count($relates);$i++){//for
					$relate = $relates[$i];
					$type_name = OSPHelper::getLanguageFieldValue($relate,'type_name');
					$relate->type_name = $type_name;
					$db->setQuery("select image from #__osrs_photos where pro_id = '$relate->id' order by ordering");
					$relate->photo = $db->loadResult();
					if ($relate->photo == ''){
						$relate->photo = JURI::root()."components/com_osproperty/images/assets/nopropertyphoto.png";
					}else {
						if(file_exists(JPATH_ROOT.'/images/osproperty/properties/'.$relate->id.'/thumb/'.$relate->photo)){
							$relate->photo = JURI::root()."images/osproperty/properties/".$relate->id."/thumb/".$relate->photo;	
						}else{
							$relate->photo = JURI::root()."components/com_osproperty/images/assets/nopropertyphoto.png";	
						}
					}

					if($configClass['load_lazy']){
						$relate->photosrc = JUri::root()."components/com_osproperty/images/assets/loader.gif";
					}else{
						$relate->photosrc = $relate->photo;
					}

					$needs = array();
					$needs[] = "property_details";
					$needs[] = $relate->id;
					$item_id = OSPRoute::getItemid($needs);
					$relate->itemid = $item_id;
					
				}//for
				$property->relate_properties = $relates;
			}// if count($relate) > 0
		}
		
		if($configClass['relate_property_type'] == 1){
			// Search the rows in the table
			$Order_by = " ORDER BY pr.isFeatured desc ";
			$sql =   " SELECT pr.* "
					."\n, ci.city AS city_name"
					."\n, st.state_name" 
					."\n, co.country_name"
					."\n, ty.type_name$lang_suffix, ty.id as type_id"
					."\n FROM #__osrs_properties pr"
					."\n LEFT JOIN #__osrs_cities AS ci ON ci.id = pr.city "
					."\n LEFT JOIN #__osrs_states AS st ON st.id = pr.state"
					."\n LEFT JOIN #__osrs_countries AS co ON co.id = pr.country"
					."\n INNER JOIN #__osrs_types AS ty ON ty.id = pr.pro_type"
					."\n WHERE 	pr.approved  = '1' and pr.published = '1'" 
					."\n AND pr.id <> '$property->id' "
					."\n AND pr.access IN (" . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ")";
			if($configClass['relate_property_type'] == 1){
				$sql .= "\n AND 	pr.pro_type  = '$property->pro_type'";
			}
			$sql .=	$Order_by;
			if($configClass['max_relate'] > 0){
				$sql .= " LIMIT ".$configClass['max_relate'];
			}
			$db->setQuery($sql);
			//secho $db->getQuery();
			$relates = $db->loadObjectList();
			if (count($relates)){
				for($i=0;$i<count($relates);$i++){//for
					$relate = $relates[$i];
					$type_name = OSPHelper::getLanguageFieldValue($relate,'type_name');
					$relate->type_name = $type_name;
					$db->setQuery("select image from #__osrs_photos where pro_id = '$relate->id' order by ordering");
					$relate->photo = $db->loadResult();
					if ($relate->photo == ''){
						$relate->photo = JURI::root()."components/com_osproperty/images/assets/nopropertyphoto.png";
					}else {
						if(file_exists(JPATH_ROOT.'/images/osproperty/properties/'.$relate->id.'/thumb/'.$relate->photo)){
							$relate->photo = JURI::root()."images/osproperty/properties/".$relate->id."/thumb/".$relate->photo;	
						}else{
							$relate->photo = JURI::root()."components/com_osproperty/images/assets/nopropertyphoto.png";	
						}
					}

					if($configClass['load_lazy']){
						$relate->photosrc = JUri::root()."components/com_osproperty/images/assets/loader.gif";
					}else{
						$relate->photosrc = $relate->photo;
					}

					$needs = array();
					$needs[] = "property_details";
					$needs[] = $relate->id;
					$item_id = OSPRoute::getItemid($needs);
					$relate->itemid = $item_id;
				}//for
				$property->relate_type_properties = $relates;
			}// if count($relate) > 0
		}
		
		HTML_OspropertyListing::propertyDetails($option,$property,$configs,$owner);		
	}
	
	
	
	
	/**
	 * List photos of property
	 *
	 * @param unknown_type $option
	 * @param unknown_type $property_id
	 */
	static function listingPhotos($option,$property_id){
		global $mainframe;
		$db = JFactory::getDBO();
		$db->setQuery("Select * from #__osrs_photos where pro_id = '$property_id' order by ordering");
		$photos = $db->loadObjectList();
		if(count($photos) > 0){
			return HTML_OspropertyListing::listingPhotos($option,$property_id,$photos);
		}else{
			return JText::_('No photo');
		}
	}
	
	/**
	 * Edit/Add new property
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	static function edit($option,$id, $type = 0){
		global $mainframe,$configs,$configClass,$lang_suffix,$languages,$jinput;

		JHtml::_('behavior.keepalive');
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS."classes".DS."property.php");
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS."helpers".DS."extrafields.php");
		//check to see if user is agent
		if($user->id == 0){
			$mainframe->redirect(JUri::root(),JText::_('OS_LOGIN_WARNING'));
		}

		if (!JFactory::getUser()->authorise('frontendmanage', 'com_osproperty')) {
			if($type == 0){
				if((!HelperOspropertyCommon::isRegisteredAgent()) and (!HelperOspropertyCommon::isRegisteredCompanyAdmin())){
					$agent_id = OSPHelper::registerNewAgent($user,$configClass['default_user_type']);
				}

				if((HelperOspropertyCommon::isCompanyAdmin()) and ($configClass['company_admin_add_properties'] == 0)){
					$mainframe->redirect(JUri::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
				}

				if($configClass['company_admin_add_properties'] == 1){
					if((! HelperOspropertyCommon::isCompanyAdmin()) and (HelperOspropertyCommon::isRegisteredCompanyAdmin()) ){
						$mainframe->redirect(JUri::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
					}
				}
				
				if($id > 0){
					if((!HelperOspropertyCommon::isOwner($id)) and (!HelperOspropertyCommon::isCompanyOwner($id))){
						$mainframe->redirect(JUri::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
					}
				}
				
				if(($configClass['general_agent_listings'] != 1) and ($id == 0) and (HelperOspropertyCommon::isAgent())){
					$mainframe->redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
				}
			}
		}

		$document = JFactory::getDocument();
		if($id > 0){
			$document->setTitle($configClass['general_bussiness_name']." - ".JText::_('OS_EDIT_PROPERTY'));
			//check to see if current user is owner of the property
			if(($type == 0) and (!JFactory::getUser()->authorise('frontendmanage', 'com_osproperty'))){
				if(HelperOspropertyCommon::isAgent()){
					$db->setQuery("Select id from #__osrs_agents where user_id = '$user->id'");
					$agent_id = $db->loadResult();
					$db->setQuery("Select count(id) from #__osrs_properties where agent_id = '$agent_id' and id = '$id'");
					$count = $db->loadResult();
					if($count == 0){
						$mainframe->redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
					}
				}elseif(!HelperOspropertyCommon::isCompanyOwner($id)){
					$mainframe->redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));	
				}
			}
		}else{
			$document->setTitle($configClass['general_bussiness_name']." - ".JText::_('OS_ADD_NEW_PROPERTY'));
		}
		$session = JFactory::getSession();
		$session->set('ownid',md5($user->id));

		//load Property Instance Table Object
		
		$row = &JTable::getInstance('Property','OspropertyTable');
		$amenitylists = array();
		if($id > 0){
			$row->load((int)$id);
			$db->setQuery("Select amen_id from #__osrs_property_amenities where pro_id = '$row->id'");
			$amenitylists = $db->loadOBjectList();
			$amenitylists1 = array();
			if(count($amenitylists) > 0){
				for($i=0;$i<count($amenitylists);$i++){
					$amenitylists1[$i] = $amenitylists[$i]->amen_id;
				}
				$amenitylists = array();
				$amenitylists = $amenitylists1;
			}
			
			$db->setQuery("Select * from #__osrs_photos where pro_id = '$id' order by ordering");
			$photos = $db->loadobjectList();
			$row->photo = $photos;
			$isNew = 0;
		}else{
			$row->published = 1;
			$row->access = 0;
			$row->price_call = 0;
            $row->isSold = 0;
			$row->isFeatured = 0;
			$row->show_address = 1;
			$isNew = 1;
		}
		
		if($row->approved == 0){
			$db->setQuery("Update #__osrs_expired set expired_time = '' where pid = '$row->id'");
			$db->query();
		}
		if($row->isFeatured == 0){
			$db->setQuery("Update #__osrs_expired set expired_feature_time = '' where pid = '$row->id'");
			$db->query();
		}
		
		$optionArr = array();
		$optionArr[] = JHTML::_('select.option',1,JText::_('OS_YES'));
		$optionArr[] = JHTML::_('select.option',0,JText::_('OS_NO'));
		
		//$lists['state'] = JHTML::_('select.genericlist',$optionArr,'published','class="input-mini"','value','text',$row->published);
		$lists['featured'] = JHTML::_('select.genericlist',$optionArr,'isFeatured','class="input-small chosen"','value','text',$row->isFeatured);
		$lists['approved'] = JHTML::_('select.genericlist',$optionArr,'approved','class="input-small chosen"','value','text',$row->approved);
		$optionArr1 = array();
		$optionArr1[] = JHTML::_('select.option',1,JText::_('OS_YES'));
		$optionArr1[] = JHTML::_('select.option',0,JText::_('OS_NO'));
		$lists['show_address'] = JHTML::_('select.genericlist',$optionArr1,'show_address','class="input-mini"','value','text',$row->show_address);
		$lists['price_call'] = JHTML::_('select.genericlist',$optionArr,'price_call','class="input-small chosen" onChange="javascript:showPriceFields()"','value','text',$row->price_call);
		$lists['property_sold'] = JHTML::_('select.genericlist',$optionArr,'isSold','class="input-small"','value','text',$row->isSold);

		//agent
		
		//check to see if i am agent
		$db->setQuery("Select count(id) from #__osrs_agents where user_id = '$user->id'");
		$count = $db->loadResult();
		if($count == 0){
			$row->isAgent = 0;
			//get company id
			$company_id = HelperOspropertyCommon::getCompanyId();
			$agentArr[] = JHTML::_('select.option','',JText::_('OS_SELECT_AGENT'));
			$query  = "Select a.id as value,a.name as text from #__osrs_agents as a inner join #__users as b on b.id = a.user_id where a.published = '1' and a.company_id = '$company_id'";
			$query .= " order by a.name";
			$db->setQuery($query);
			$agents = $db->loadObjectList();
			$agentArr   = array_merge($agentArr,$agents);
			$lists['agent'] = JHTML::_('select.genericlist',$agentArr,'agent_id','class="input-medium"','value','text',$row->agent_id);
		}else{
			$row->isAgent = 1;
			$db->setQuery("Select id from #__osrs_agents where user_id = '$user->id'");
			$agent_id = $db->loadResult();
			$lists['agent'] = "<input type='hidden' name='agent_id' id='agent_id' value='$agent_id'>";

			$db->setQuery("Select name from #__osrs_agents where user_id = '$user->id'");
			$agent_name = $db->loadResult();
			$lists['agentname'] = $agent_name;
		}
		
		//property types
		$typeArr[] = JHTML::_('select.option','',JText::_('OS_SELECT_PROPERTY_TYPE'));
		$db->setQuery("Select id as value,type_name$lang_suffix as text from #__osrs_types where published = '1' order by ordering");
		$protypes = $db->loadObjectList();
		$typeArr   = array_merge($typeArr,$protypes);
		$lists['type'] = JHTML::_('select.genericlist',$typeArr,'pro_type','class="input-large chosen"','value','text',$row->pro_type);
		
		//categories
		$categoryIds = OSPHelper::getCategoryIdsOfProperty($row->id);
		$lists['category'] = OSPHelper::dropdownCategory('categoryIds[]',$categoryIds,'input-large chosen');
		
		$lists['country'] = HelperOspropertyCommon::makeCountryList($row->country,'country','onChange="javascript:loadState(this.value,\''.$row->state.'\',\''.$row->city.'\')"',JText::_('OS_SELECT_COUNTRY'),'style="width:150px;"');
		
		if(OSPHelper::userOneState()){
			$lists['state'] = "<input type='hidden' name='state' id='state' value='".OSPHelper::returnDefaultState()."'/>";
		}else{
			$lists['state'] = HelperOspropertyCommon::makeStateListAddProperty($row->country,$row->state,'state','onChange="javascript:loadCity(this.value,\''.$row->city.'\')" class="input-small"',JText::_('OS_SELECT_STATE'),'');
		}
		
		//$lists['city'] = HelperOspropertyCommon::loadCityAddProperty($option,$row->state,$row->city);
		if($id > 0){
			if(intval($row->state) == 0){
				$row->state = OSPHelper::returnDefaultState();
			}
			$lists['city'] = HelperOspropertyCommon::loadCityAddProperty($option,$row->state,$row->city);
		}else{
			$default_state = 0;
			if(OSPHelper::userOneState()){
				$default_state = OSPHelper::returnDefaultState();
			}else{
				$default_state = $row->state;
			}
			$lists['city'] = HelperOspropertyCommon::loadCityAddProperty($option,$default_state,$row->city);
		}

        //number bed rooms
        $lists['nbed'] = OSPHelper::dropdropBed('bed_room',$row->bed_room,'input-small chosen','','OS_BED');
        //number bath rooms
        $lists['nbath'] = OSPHelper::dropdropBath('bath_room',$row->bath_room,'input-small chosen','','OS_BATH');
        //number rooms
        $lists['nrooms'] = OSPHelper::dropdropRoom('rooms',$row->rooms,'input-small chosen','','OS_ROOMS');
        //number floors
        $lists['nfloors'] = OSPHelper::dropdropRoom('number_of_floors',$row->number_of_floors,'input-small chosen','','OS_FLOORS');
		
		$accessArr[] = JHTML::_('select.option','0',JText::_('OS_PUBLIC'));
		$accessArr[] = JHTML::_('select.option','1',JText::_('OS_REGISTERED'));
		$accessArr[] = JHTML::_('select.option','2',JText::_('OS_SPECIAL'));
		$lists['access'] = JHTML::_('select.genericlist',$accessArr,'access','class="input-small" size="2"','value','text',$row->access);
		
		$db->setQuery("select * from #__osrs_amenities where published = '1' order by ordering");
		$amenities = $db->loadObjectList();
		
		
		$db->setQuery("Select * from #__osrs_fieldgroups where id in (Select group_id from #__osrs_extra_fields) and published = '1' order by ordering");
		$groups = $db->loadObjectList();
		if(count($groups) > 0){
			for($i=0;$i<count($groups);$i++){
				$group = $groups[$i];
				//if($id > 0){
					//$extraSql = " and id in (Select fid from #__osrs_extra_field_types where type_id = '$row->pro_type') ";
				//}
				$db->setQuery("Select * from #__osrs_extra_fields where published = '1' and group_id = '$group->id' order by ordering");
				$fields = $db->loadObjectList();
				$groups[$i]->fields = $fields;
			}
		}
		
		$timeArr[] = JHTML::_('select.option','',JText::_('OS_NOT_APPLICABLE'));
		$timeArr[] = JHTML::_('select.option','OS_PER_NIGHT',JText::_('OS_PER_NIGHT'));
		$timeArr[] = JHTML::_('select.option','OS_PER_WEEK',JText::_('OS_PER_WEEK'));
		$timeArr[] = JHTML::_('select.option','OS_PER_MONTH',JText::_('OS_PER_MONTH'));
		$timeArr[] = JHTML::_('select.option','OS_PER_SQUARE_FEET',JText::_('OS_PER_SQUARE_FEET'));
		$timeArr[] = JHTML::_('select.option','OS_PER_SQUARE_METRE',JText::_('OS_PER_SQUARE_METRE'));
		$lists['time'] = JHTML::_('select.genericlist',$timeArr,'rent_time','class="input-medium chosen"','value','text',$row->rent_time);
		//html
		
		$db->setQuery("Select * from #__osrs_neighborhoodname");
		$neighborhoods = $db->loadObjectList();
		
		if($configClass['integrate_membership'] == 1){ //allow to integrate with membership
			if(intval($id) == 0){
				//is New
				if(!HelperOspropertyCommon::checkMembershipIsAvailable()){
					$redirect_link = $configClass['no_subscription_link'];
					if($redirect_link == ""){
						$redirect_link = JURI::root()."index.php?option=com_osmembership&Itemid=".$jinput->getInt('Itemid',0);
					}
					$mainframe->redirect($redirect_link,JText::_('OS_YOU_NEED_TO_PURCHASE_SUBSCRIPTION_IF_YOU_WANT_TO_ADD_PROPERTY'));
				}else{
					$agentAcc = HelperOspropertyCommon::returnAccountValue(true);
					$lists['agentAcc'] = $agentAcc;
				}
			}else{
				$canApproval = 1;
				$current_time = date("Y-m-d H:i:s",time());
				$db->setQuery("Select count(id) from #__osrs_expired where pid = '$id' and expired_time < '$current_time'");
				$count = $db->loadResult();
				if($count > 0){
					if(!HelperOspropertyCommon::checkMembershipIsAvailable()){
						$redirect_link = $configClass['no_subscription_link'];
						if($redirect_link == ""){
							$redirect_link = JURI::root()."index.php?option=com_osmembership&Itemid=".$jinput->getInt('Itemid',0);
						}
						$canApproval = 0;
					}
				}
				$agentAcc = HelperOspropertyCommon::returnAccountValue(true);
				$lists['agentAcc'] = $agentAcc;
				$lists['canApproval'] = $canApproval;
			}
		}
		
		if($row->id){
        	$query = "Select a.* from #__osrs_tags as a inner join #__osrs_tag_xref as b on b.tag_id = a.id where b.pid = '$row->id'";
        	$db->setQuery($query);
            $lists['tags'] = $db->loadObjectList();
        }


        $translatable = JLanguageMultilang::isEnabled() && count($languages);

        $db->setQuery("Select id from #__osrs_types");
        $types = $db->loadObjectList();
        if(count($types) > 0){
        	foreach ($types as $type){
        		$db->setQuery("Select fid from #__osrs_extra_field_types where type_id = '$type->id'");
        		$type->fields = $db->loadColumn(0);

				$db->setQuery("Select a.fid from #__osrs_extra_field_types as a left join #__osrs_extra_fields as b on b.id = a.fid where a.type_id = '$type->id' and b.published = '1' and b.required = '1'");
        		$type->required_fields = $db->loadColumn(0);

				$db->setQuery("Select b.field_name from #__osrs_extra_field_types as a left join #__osrs_extra_fields as b on b.id = a.fid where a.type_id = '$type->id' and b.published = '1' and b.required = '1'");
        		$type->required_fields_name = $db->loadColumn(0);

				$db->setQuery("Select b.field_label".$lang_suffix." as field_label from #__osrs_extra_field_types as a left join #__osrs_extra_fields as b on b.id = a.fid where a.type_id = '$type->id' and b.published = '1' and b.required = '1'");
        		$type->required_fields_label = $db->loadColumn(0);
        	}
        }
		$lists['types'] = $types;
		
		if($row->id > 0){
			$query = $db->getQuery(true);
			$query->select("*")->from("#__osrs_property_price_history")->where("pid = '$row->id'");
			$db->setQuery($query);
			$lists['history'] = $db->loadObjectList();
			
			$query = $db->getQuery(true);
			$query->select("*")->from("#__osrs_property_history_tax")->where("pid = '$row->id'");
			$db->setQuery($query);
			$lists['tax'] = $db->loadObjectList();
			
			$query = $db->getQuery(true);
			$query->select("*")->from("#__osrs_property_open")->where("pid = '$row->id'")->order("start_from desc");
			$db->setQuery($query);
			$lists['open'] = $db->loadObjectList();
		}


		//expiration checking
		if($configClass['general_use_expiration_management'] == 1){
			$db->setQuery("Select * from #__osrs_expired where pid = '$row->id'");
			$row->expiration = $db->loadObject();
		}

        //payment for checking
        if($configClass['active_payment'] == 1){
			$paymentMethod = $jinput->getString('payment_method', os_payments::getDefautPaymentMethod(), 'post');
			if (!$paymentMethod) $paymentMethod = os_payments::getDefautPaymentMethod();
        }

		###############Payment Methods parameters###############################
		
		//Creditcard payment parameters		
		$x_card_num         = $jinput->getString('x_card_num', '');
		$expMonth           = $jinput->getString('exp_month', date('m')) ;
		$expYear            = $jinput->getString('exp_year', date('Y')) ;
		$x_card_code        = $jinput->getString('x_card_code', '');
		$cardHolderName     = $jinput->getString('card_holder_name', '') ;
		$lists['exp_month'] = JHTML::_('select.integerlist', 1, 12, 1, 'exp_month', ' id="exp_month" class="input-mini"  ', $expMonth, '%02d') ;
		$currentYear = date('Y') ;
		$lists['exp_year'] = JHTML::_('select.integerlist', $currentYear, $currentYear + 10 , 1, 'exp_year', ' id="exp_year" class="input-small" ', $expYear) ;
		$options =  array() ;
		$cardTypes = explode(',', $configClass['enable_cardtypes']);
		if (in_array('Visa', $cardTypes)) {
			$options[] = JHTML::_('select.option', 'Visa', JText::_('OS_VISA_CARD')) ;			
		}
		if (in_array('MasterCard', $cardTypes)) {
			$options[] = JHTML::_('select.option', 'MasterCard', JText::_('OS_MASTER_CARD')) ;
		}
		
		if (in_array('Discover', $cardTypes)) {
			$options[] = JHTML::_('select.option', 'Discover', JText::_('OS_DISCOVER')) ;
		}		
		if (in_array('Amex', $cardTypes)) {
			$options[] = JHTML::_('select.option', 'Amex', JText::_('OS_AMEX')) ;
		}		
		$lists['card_type'] = JHTML::_('select.genericlist', $options, 'card_type', ' class="input-large" ', 'value', 'text') ;
		//Echeck
				
		$x_bank_aba_code    = $jinput->getString('x_bank_aba_code', '') ;
		$x_bank_acct_num    = $jinput->getString('x_bank_acct_num', '') ;
		$x_bank_name        = $jinput->getString('x_bank_name', '') ;
		$x_bank_acct_name   = $jinput->getString('x_bank_acct_name', '') ;
		$options = array() ;
		$options[] = JHTML::_('select.option', 'CHECKING', JText::_('OS_BANK_TYPE_CHECKING')) ;
		$options[] = JHTML::_('select.option', 'BUSINESSCHECKING', JText::_('OS_BANK_TYPE_BUSINESSCHECKING')) ;
		$options[] = JHTML::_('select.option', 'SAVINGS', JText::_('OS_BANK_TYPE_SAVING')) ;
		$lists['x_bank_acct_type'] = JHTML::_('select.genericlist', $options, 'x_bank_acct_type', ' class="input-large" ', 'value', 'text', OSPHelper::getStringRequest('x_bank_acct_type')) ;
		
		$methods = os_payments::getPaymentMethods(true, false) ;
		
		$lists['x_card_num'] = $x_card_num;
		$lists['x_card_code'] = $x_card_code;
		$lists['cardHolderName'] = $cardHolderName;
		$lists['x_bank_acct_num'] = $x_bank_acct_num;
		$lists['x_bank_acct_name'] = $x_bank_acct_name;
		$lists['methods'] = $methods;
		$lists['idealEnabled'] = false;
		$lists['paymentMethod'] = $paymentMethod;
        
		HTML_OspropertyListing::editListing($option,$row,$lists,$amenities,$amenitylists,$groups,$configs,$neighborhoods,$translatable,$isNew);
	}
	
	/**
	 * Change property status (Publish/Unpublish)
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 * @param unknown_type $state
	 */
	static function propertyChange($option,$cid,$state){
		global $mainframe;
		$user = JFactory::getUser();
		$db = JFactory::getDBO();
		if(count($cid) > 0){
			foreach ($cid as $id){
				if(HelperOspropertyCommon::isOwner($id)){
					$db->setQuery("Update #__osrs_properties set published = '$state' where id = '$id'");
					$db->query();
				}else{
					JError::raiseError( 500, JText::_('OS_YOU_HAVE_NOT_GOT_PERMISSION_GO_TO_THIS_AREA') );
				}
			}
		}
		
		$needs = array();
		$needs[] = "agent_editprofile";
		$needs[] = "agent_default";
		$needs[] = "aeditdetails";
		$itemid = OSPRoute::getItemid($needs);
		$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=agent_editprofile&Itemid=".$itemid),JText::_('OS_STATUS_HAVE_BEEN_CHANGED'));
	}
	
	/**
	 * Save property
	 *
	 * @param unknown_type $option
	 */
	static function save($option,$save){
		global $mainframe,$configClass,$bio,$languages,$lang_suffix,$jinput;
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');

		$user = JFactory::getUser();
		$session = JFactory::getSession();
		$ownid = $session->get('ownid');
		if($ownid  != md5($user->id)){
			JError::raiseError(500, JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA') );
		}

		$limit_photo = $configClass['limit_upload_photos'];
		if(intval($limit_photo) == 0){
			$limit_photo = 24;
		}
		$db = JFactory::getDBO();
		$row = &JTable::getInstance('Property','OspropertyTable');
		$post = $jinput->post->getArray();

		$row->bind($post);
		$id = $jinput->getInt('id',0);
		$isNew = ($id == 0 ? 1:0);
		$passcheck = 0;
		if($isNew == 0){
			$extend = $jinput->getInt('extend',0);
			if($extend == 0){
				$passcheck = 1;
			}
		}
		
		//request feature
		if($configClass['integrate_membership'] == 1){
			//do nothing
		}elseif($configClass['active_payment'] == 1){ //Active payment
			if($isNew==1){
				$row->isFeatured = $jinput->getInt('isFeatured',0);
				$touchExpireTable = 1;//setup expired for this property
			}else{
				$db->setQuery("Select isFeatured from #__osrs_properties where id = '$id'");
				$featured = $db->loadResult();
				$row->isFeatured = $featured;
				$touchExpireTable = 0;
			}
		}else{
			if($isNew==1){
				$row->isFeatured = 0;
				$touchExpireTable = 1;//setup expired for this property
			}else{
				$db->setQuery("Select isFeatured from #__osrs_properties where id = '$id'");
				$featured = $db->loadResult();
				$row->isFeatured = $featured;
				$touchExpireTable = 0;
			}
			
		}
		
		$remove_pdf = $jinput->getInt('remove_pdf',0);
		if($id > 0){
			$db->setQuery("Select pro_pdf_file from #__osrs_properties where id = '$id'");
			$document_file = $db->loadResult();
		}
		if(is_uploaded_file($_FILES['pro_pdf_file']['tmp_name'])){
			if(!HelperOspropertyCommon::checkIsDocumentFileUploaded('pro_pdf_file')){
				//return to previous page
				//do nothing
			}else{
				if(is_uploaded_file($_FILES['pro_pdf_file']['tmp_name'])){
					if($document_file != ""){ // remove old file
						@unlink(JPATH_ROOT.DS."components".DS."com_osproperty".DS."document".DS.$document_file);
					}
					$pro_pdf_file = time()."_".$_FILES['pro_pdf_file']['name'];
					move_uploaded_file($_FILES['pro_pdf_file']['tmp_name'],JPATH_ROOT.DS."components".DS."com_osproperty".DS."document".DS.$pro_pdf_file);
					$row->pro_pdf_file = $pro_pdf_file;
				}
			}
		}
		if($remove_pdf == 1){
			if($document_file != ""){ // remove old file
				@unlink(JPATH_ROOT.DS."components".DS."com_osproperty".DS."document".DS.$document_file);
			}
			$pro_pdf_file = "";
			$row->pro_pdf_file = "";
		}
		
		$pro_video = $_POST['pro_video'];
		$row->pro_video = $pro_video;
		$pro_small_desc = $_POST['pro_small_desc'];
		$row->pro_small_desc = $pro_small_desc;
		$pro_full_desc = $_POST['pro_full_desc'];
		$row->pro_full_desc = $pro_full_desc;
		$note = $_POST['note'];
		$row->note = $note;
		$metakey = $_POST['metakey'];
		$row->metakey = $metakey;
		$metadesc = $_POST['metadesc'];
		$row->metadesc = $metadesc;
		if (JFactory::getUser()->authorise('frontendmanage', 'com_osproperty')) {
			$agent_id = $jinput->getInt('agent_id',0);
		}elseif(HelperOspropertyCommon::isRegisteredAgent()){
			$agent_id = HelperOspropertyCommon::getAgentID();
            $row->company_id = 0;
			if($id == 0){
				$row->posted_by = 0;
			}
            $posted_by = 0;
            $created_by = $agent_id;
		}else{
			$agent_id = $jinput->getInt('agent_id',0);
            $company_id = HelperOspropertyCommon::getCompanyId();
			if($id == 0){
				$row->company_id = $company_id;
				$row->posted_by = 1;
			}
            $posted_by = 1;
            $created_by = $company_id;
		}
		$row->agent_id = $agent_id;
		if($id == 0){
			$row->created = date("Y-m-d",time());
			$row->created_by = $user->id;
			$row->hits =  0;
			$row->modified = $row->created;
		}else{
			$row->modified = date("Y-m-d",time());
			$row->modified_by = $user->id;
			$row->company_id  = $jinput->getInt('company_id',0);
		}
		//Auto approval or waiting for confirmation from admin
		if($isNew == 1){
			if($configClass['general_approval']==1){ //auto approval
				if($configClass['active_payment'] == 1){
					$row->approved = 0;
				}else{
					$row->approved = 1;
				}
				$row->published = 1;
				$row->publish_up = date("Y-m-d");
			}else{
				$row->approved = 0;
				$row->published = 0;	
			}
		}
		//check to lat long
		$lat_add = OSPHelper::getStringRequest('lat_add','','post');
		$long_add = OSPHelper::getStringRequest('long_add','','post');
		if(($lat_add == "") or ($long_add == "")){
			include_once(JPATH_SITE.DS."components".DS."com_osproperty".DS."helpers".DS."googlemap.lib.php");
			$address_search = OSPHelper::getStringRequest('address','','post').", ".OSPHelper::getStringRequest('city','','post');
			$state = OSPHelper::getStringRequest('state','','post');
			$db->setQuery("Select state_name$lang_suffix as state_name from #__osrs_states where id = '$state'");
			$sname = $db->loadResult();
			$address_search .= ", ".$sname;
			$country = OSPHelper::getStringRequest('country','','post');
			//$db->setQuery("Select country_name from #__osrs_countries where id = '$country'");
			$cname = OSPHelper::getCountryName($country);
			$address_search .= ", ".$cname;
			//$q = urlencode($address_search);
			$return = HelperOspropertyGoogleMap::findAddress($option,'',$address_search,1);
			if($return[2] == "OK"){
				$lat_add = $return[0];
				$long_add = $return[1];
				$row->lat_add = $lat_add;
				$row->long_add = $long_add;
			}
		}else{
			$row->lat_add = $lat_add;
			$row->long_add = $long_add;
		}
		//store into database
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		//get id
		if($isNew == 1){
			$id = $db->insertID();
            //auto ref?
            if($configClass['ref_field'] == 1){
                $ref_prefix = $configClass['ref_prefix'];
                $db->setQuery("Update #__osrs_properties set ref = '".$ref_prefix.$id."' where id = '$id'");
                $db->query();
            }
            //version 2.7.5
            //add ID of property into New Properties Table
            OSPHelper::addPropertyToQueue($id);
		}else{
			if($row->ref == ""){
				if($configClass['ref_field'] == 1){
					$ref_prefix = $configClass['ref_prefix'];
					$db->setQuery("Update #__osrs_properties set ref = '".$ref_prefix.$id."' where id = '$id'");
					$db->query();
				}
			}
		}

		//create directories if they don't exists
		if(! JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$id)){
			JFolder::create(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$id);
		}
		if(! JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$id.DS."thumb")){
			JFolder::create(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$id.DS."thumb");
		}
		if(! JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$id."medium")){
			JFolder::create(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$id.DS."medium");
		}
		
		//Update into Property table
		$categoryIds = $jinput->get('categoryIds',array(),'ARRAY');
		$db->setQuery("Delete from #__osrs_property_categories where pid = '$id'");
		$db->query();
		if(count($categoryIds) > 0){
			foreach ($categoryIds as $catid){
				$db->setQuery("Insert into #__osrs_property_categories (id,pid,category_id) values (NULL,'$id','$catid')");
				$db->query();
			}
		}
		
		//update other information
		$translatable = JLanguageMultilang::isEnabled() && count($languages);
		if($translatable){
			foreach ($languages as $language){	
				$sef = $language->sef;
				
				$pro_name_language 			= OSPHelper::getStringRequest('pro_name_'.$sef,'');
				$pro_small_desc_language 	= $_POST['pro_small_desc_'.$sef];
				$pro_full_desc_language 	= $_POST['pro_full_desc_'.$sef];
				
				$metakey_language			= $_POST['metakey_'.$sef];
				$metadesc_language			= $_POST['metadesc_'.$sef];
				
				if($pro_name_language == ""){
					$pro_name_language = $row->pro_name;
					$property = &JTable::getInstance('Property','OspropertyTable');
					$property->id = $id;
					$property->{'pro_name_'.$sef} = $pro_name_language;
					$property->store();
				}
				
				if($pro_small_desc_language == ""){
					$pro_small_desc_language = $row->pro_small_desc;
				}
				if($pro_small_desc_language != ""){
					$property = &JTable::getInstance('Property','OspropertyTable');
					$property->id = $id;
					$property->access = $row->access;
					$property->category_id = $row->category_id;
					$property->{'pro_small_desc_'.$sef} = $pro_small_desc_language;
					$property->store();
				}
				
				if($pro_full_desc_language == ""){
					$pro_full_desc_language = $row->pro_full_desc;
				}
				if($pro_full_desc_language != ""){
					$property = &JTable::getInstance('Property','OspropertyTable');
					$property->id = $id;
					$property->access = $row->access;
					$property->category_id = $row->category_id;
					$property->{'pro_full_desc_'.$sef} = $pro_full_desc_language;
					$property->store();
				}
				
				if($metadesc_language == ""){
					$metadesc_language = $metadesc;
				}
				if($metadesc_language != ""){
					$db->setQuery("Update #__osrs_properties set `metadesc_".$sef."` = ".$db->quote($metadesc_language)." where  id = '$id'");
					$db->query();
				}
				
				if($metakey_language == ""){
					$metakey_language = $metakey;
				}
				if($metakey_language != ""){
					$db->setQuery("Update #__osrs_properties set `metakey_".$sef."` = ".$db->quote($metakey_language)." where  id = '$id'");
					$db->query();
				}
				
				$pro_alias = OSPHelper::getStringRequest('pro_alias_'.$sef);
				$pro_alias = OSPHelper::generateAliasMultipleLanguages('property',$id,$pro_alias,$sef);
				$db->setQuery("Update #__osrs_properties set pro_alias_".$sef." = '$pro_alias' where id = '$id'");
				$db->query();
			}
		}
		
		//alias
		$pro_alias = OSPHelper::getStringRequest('pro_alias','','');
		if($pro_alias == ""){
			$pro_alias = OSPHelper::generateAlias('property',$id,'');
		}else{
			$pro_alias = OSPHelper::generateAlias('property',$id,$pro_alias);
		}
		$db->setQuery("Update #__osrs_properties set pro_alias = '$pro_alias' where id = '$id'");
		$db->query();
		
		//collect the id of the photos
		$photoIds = array();
		
		//save photos and extra fields
		if($isNew == 0){
			$db->setQuery("Select * from #__osrs_photos where pro_id = '$id' order by ordering");
			$photos = $db->loadObjectList();
			if(count($photos) > 0){
				for($i=0;$i<count($photos);$i++){
					$j = $i + 1;
					$photo = $photos[$i];
					$remove_name   = "remove_".$photo->id;
					$photo_name    = "photo_".$j;
					$desc_name     = "photodesc_".$j;
					$ordering_name = "ordering_".$j;
					$remove        = $jinput->getInt($remove_name,0);
					
					$photorecord   = &JTable::getInstance('Photo','OspropertyTable');
					$photorecord->id = $photo->id;
					$description   = $_POST[$desc_name];
					$photorecord->image_desc = $description;
					$photorecord->ordering   = $jinput->getInt($ordering_name,0);
					
					if(is_uploaded_file($_FILES[$photo_name]['tmp_name'])){
						if(!HelperOspropertyCommon::checkIsPhotoFileUploaded($photo_name)){
							//return to previous page
							//do nothing
						}else{
							$image_name = $_FILES[$photo_name]['name'];
							$image_name = OSPHelper::processImageName($id.time().$image_name);
							$original_image_link = JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$id.DS.$image_name;
							move_uploaded_file($_FILES[$photo_name]['tmp_name'],$original_image_link);
							HelperOspropertyCommon::returnMaxsize($original_image_link);
							//copy and resize
							//thumb
							$thumb_width = $configClass['images_thumbnail_width'];
							$thumb_height = $configClass['images_thumbnail_height'];
							$thumb_image_link = JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$id.DS."thumb".DS.$image_name;
							JFile::copy($original_image_link,$thumb_image_link);
							OSPHelper::resizePhoto($thumb_image_link,$thumb_width,$thumb_height);
							
							//medium
						    $medium_width = $configClass['images_large_width'];
						    $medium_height = $configClass['images_large_height'];
						    $medium_image_link = JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$id.DS."medium".DS.$image_name;
						    JFile::copy($original_image_link,$medium_image_link);
						    OSPHelper::resizePhoto($medium_image_link,$medium_width,$medium_height);
						    
						    $photorecord->image = $image_name;
						    
						    //add into the array
						    $photoIds[] = $photo->id;
						}
					}
					if($remove == 1){
						HelperOspropertyCommon::removePhoto($photo->id,1);
						$db->setQuery("Select image from #__osrs_photos where id = '$photo->id'");
						$image = $db->loadResult();
						$db->setQuery("Delete from #__osrs_watermark where pid = '$id' and image like '$image'");
						$db->query();
					}else{
						//save the image
						$photorecord->store();
					}
				}
			}
		}//end edit photos of property
		
		//with new photos of the property
		$newphoto = $jinput->getInt('newphoto',0);
		for($i=$newphoto;$i<=$limit_photo;$i++){
			$j = $i + 1;
			$photo_name    = "photo_".$j;
			$desc_name     = "photodesc_".$j;
			$ordering_name = "ordering_".$j;
			$photorecord   = &JTable::getInstance('Photo','OspropertyTable');
			$photorecord->id = 0;
			$description   = $_POST[$desc_name];
			$photorecord->image_desc = $description;
			$photorecord->pro_id     = $id;
			$db->setQuery("Select ordering from #__osrs_photos where pro_id = '$id' order by ordering desc limit 1");
			$ordering = $db->loadResult();
			$photorecord->ordering   = $ordering +1;
			
			if(is_uploaded_file($_FILES[$photo_name]['tmp_name'])){
				if(!HelperOspropertyCommon::checkIsPhotoFileUploaded($photo_name)){
					//return to previous page
					//do nothing
				}else{	
					$image_name = $_FILES[$photo_name]['name'];
					$image_name = OSPHelper::processImageName($id.time().$image_name);
					$original_image_link = JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$id.DS.$image_name;
					move_uploaded_file($_FILES[$photo_name]['tmp_name'],$original_image_link);
					HelperOspropertyCommon::returnMaxsize($original_image_link);
					//copy and resize
					//thumb
					$thumb_width = $configClass['images_thumbnail_width'];
					$thumb_height = $configClass['images_thumbnail_height'];
					$thumb_image_link = JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$id.DS."thumb".DS.$image_name;
					JFile::copy($original_image_link,$thumb_image_link);
					OSPHelper::resizePhoto($thumb_image_link,$thumb_width,$thumb_height);
					
					//medium
				    $medium_width = $configClass['images_large_width'];
				    $medium_height = $configClass['images_large_height'];
				    $medium_image_link = JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$id.DS."medium".DS.$image_name;
				    JFile::copy($original_image_link,$medium_image_link);
				    OSPHelper::resizePhoto($medium_image_link,$medium_width,$medium_height);
						    
				    $photorecord->image = $image_name;
				    //save the image
					$photorecord->store();
					
					$new_photo_id = $db->insertID();
					$photoIds[] = $new_photo_id;
				}
			}
		}
		//end new photos of the property
		
		//let save extra fields
		$db->setQuery("Select * from #__osrs_extra_fields where published = '1'");
		$fields = $db->loadObjectList();
		if(count($fields) > 0){
			$db->setQuery("Delete from #__osrs_property_field_value where pro_id = '$id'");
			$db->query();
			for($i=0;$i<count($fields);$i++){
				$field = $fields[$i];
				HelperOspropertyFields::saveField($field,$id);
			}
		}
		//end save extra field
		
		//save convenience
		$amenities = $jinput->get('amenities',array(),'ARRAY');
		$db->setQuery("Delete from #__osrs_property_amenities where pro_id = '$id'");
		$db->query();
		if(count($amenities) > 0){
			for($i=0;$i<count($amenities);$i++){
				$amen_id = $amenities[$i];
				$db->setQuery("Insert into #__osrs_property_amenities (id,pro_id,amen_id) values (NULL,'$id','$amen_id')");
				$db->query();
			}
		}
		
		//update tags
		$query = $db->getQuery(true);
		$query->delete("#__osrs_tag_xref")->where("pid = '$id'");
		$db->setQuery($query);
		$db->execute();
		
		if($translatable){
			$keyword = $jinput->get('keyword',array(),'ARRAY');
			if(count($keyword) > 0){
				for($i=0;$i<count($keyword);$i++){
					$tag = htmlspecialchars($keyword[$i]);
					$tag = $db->escape($tag);
					if($tag != ""){
						$sql = "Select count(id) from #__osrs_tags where keyword like '$tag'";
						foreach ($languages as $language){	
							$sef = $language->sef;
							$temp_keyword = OSPHelper::getStringRequest('keyword_'.$sef);
							$temp_keyword = htmlspecialchars($temp_keyword[$i]);
							$sql .= " and keyword_".$sef." like '$temp_keyword'";
						}
						$db->setQuery($sql);
						$count = $db->loadResult();
						if($count == 0){
							$tagobj = &Jtable::getInstance('Tag','OspropertyTable');
							$tagobj->id = 0;
							$tagobj->keyword = $tag;
							$tagobj->published = 1;
							foreach ($languages as $language){	
								$sef = $language->sef;
								$temp_keyword = OSPHelper::getStringRequest('keyword_'.$sef);
								$temp_keyword = htmlspecialchars($temp_keyword[$i]);
								$tagobj->{'keyword_'.$sef} = $temp_keyword;
							}
							$tagobj->store();
							$tagid = $db->insertID();
						}else{ 
							$sql = "Select id from #__osrs_tags where keyword like '$tag'";
							foreach ($languages as $language){	
								$sef = $language->sef;
								$temp_keyword = OSPHelper::getStringRequest('keyword_'.$sef);
								$temp_keyword = htmlspecialchars($temp_keyword[$i]);
								$sql .= " and keyword_".$sef." like '$temp_keyword'";
							}
							$db->setQuery($sql);
							$tagid = $db->loadResult();
						}
						$db->setQuery("Insert into #__osrs_tag_xref (id,pid,tag_id) values (NULL,'$id','$tagid')");
						$db->query();
					}
				}
			}
		}else{
			$keyword = $jinput->get('keyword',array(),'ARRAY');
			if(count($keyword) > 0){
				foreach ($keyword as $tag){
					$tag = htmlspecialchars($tag);
					if($tag != ""){
						$db->setQuery("Select count(id) from #__osrs_tags where keyword like '$tag'");
						$count = $db->loadResult();
						if($count == 0){
							$tagobj = &Jtable::getInstance('Tag','OspropertyTable');
							$tagobj->id = 0;
							$tagobj->keyword = $tag;
							$tagobj->published = 1;
							$tagobj->store();
							$tagid = $db->insertID();
						}else{ 
							$db->setQuery("Select id from #__osrs_tags where keyword like '$tag'");
							$tagid = $db->loadResult();
						}
						$db->setQuery("Insert into #__osrs_tag_xref (id,pid,tag_id) values (NULL,'$id','$tagid')");
						$db->query();
					}
				}
			}
		}
		
		//save neighborhood
		$db->setQuery("Delete from #__osrs_neighborhood where pid = '$id'");
		$db->query();
		$db->setQuery("Select id from #__osrs_neighborhoodname");
		$neighborhoods = $db->loadObjectList();
		if(count($neighborhoods) > 0){
			for($i=0;$i<count($neighborhoods);$i++){
				$neighborhood = $neighborhoods[$i];
				$neighborhood_checkbox_name = "nei_".$neighborhood->id;
				$neighborhood_checkbox_value = $jinput->getInt($neighborhood_checkbox_name,0);
				if($neighborhood_checkbox_value == 1){
					$mins_name = "mins_nei_".$neighborhood->id;
					$mins = $jinput->getString($mins_name,'');
					$traffic_name = "traffic_type_".$neighborhood->id;
					$traffic_type = $jinput->getInt($traffic_name,'0');
					$db->setQuery("Insert into #__osrs_neighborhood (id,pid,neighbor_id,mins,traffic_type) values (NULL,'$id','$neighborhood->id','$mins','$traffic_type')");
					$db->query();
				}
			}
		}
		//update property history
		if($configClass['use_property_history']== 1){
			$query = $db->getQuery(true);
			$query->delete("#__osrs_property_price_history")->where("pid = '$id'");
			$db->setQuery($query);
			$db->execute();

            $history_date   = $jinput->get('history_date',array(),'ARRAY');
            $history_event  = $jinput->get('history_event',array(),'ARRAY');
            $history_price  = $jinput->get('history_price',array(),'ARRAY');
            $history_source = $jinput->get('history_source',array(),'ARRAY');
			if(count($history_date) > 0){
				for($i=0;$i<count($history_date);$i++){
					if(($history_date[$i] != "") and ($history_event[$i] != "") and ($history_price [$i] != "") and ($history_source[$i] != "")){
						$query = $db->getQuery(true);
						$columns = array('id','pid','date','event','price','source');
						$query->insert("#__osrs_property_price_history")->columns($columns)->values('NULL,'.$id.','.$db->quote($history_date[$i]).','.$db->quote($history_event[$i]).','.$db->quote($history_price [$i]).','.$db->quote($history_source[$i]).'');
						$db->setQuery($query);
						$db->execute();
					}
				}
			}
			
			$query = $db->getQuery(true);
			$query->delete("#__osrs_property_history_tax")->where("pid = '$id'");
			$db->setQuery($query);
			$db->execute();

            $tax_year   			= $jinput->get('tax_year',array(),'ARRAY');
            $tax_value  			= $jinput->get('tax_value',array(),'ARRAY');
            $tax_change  			= $jinput->get('tax_change',array(),'ARRAY');
            $tax_assessment 		= $jinput->get('tax_assessment',array(),'ARRAY');
            $tax_assessment_change 	= $jinput->get('tax_assessment_change',array(),'ARRAY');
			if(count($tax_year) > 0){
				for($i=0;$i<count($tax_year);$i++){
					if(($tax_year[$i] != "") and ($tax_value[$i] != "")  ){
						if($tax_assessment [$i] == ""){
							$tax_assessment [$i] = 0;
						}
						if($tax_assessment_change [$i] == ""){
							$tax_assessment_change [$i] = 0;
						}
						$query = $db->getQuery(true);
						$columns = array('id','pid','tax_year','property_tax','tax_change','tax_assessment','tax_assessment_change');
						$query->insert("#__osrs_property_history_tax")->columns($columns)->values('NULL,'.$id.','.$db->quote($tax_year[$i]).','.$db->quote($tax_value[$i]).','.$db->quote($tax_change[$i]).','.$db->quote($tax_assessment[$i]).','.$tax_assessment_change[$i].'');
						$db->setQuery($query);
						$db->execute();
					}
				}
			}
		}
		
		if($configClass['use_open_house'] == 1){
			$query = $db->getQuery(true);
			$query->delete("#__osrs_property_open")->where("pid = '$id'");
			$db->setQuery($query);
			$db->execute();

            $start_from = $jinput->get('start_from',array(),'ARRAY');
            $end_to     = $jinput->get('end_to',array(),'ARRAY');
			
			if(count($start_from) > 0){
				for($i=0;$i<count($start_from);$i++){
					if(($start_from[$i] != "") and ($end_to[$i]!= "")){
						$query = $db->getQuery(true);
						$columns = array('id','pid','start_from','end_to');
						$query->insert('#__osrs_property_open')->columns($columns)->values('NULL,'.$id.','.$db->quote($start_from[$i]).','.$db->quote($end_to[$i]).'');
						$db->setQuery($query);
						$db->execute();
					}
				}
			}
		}

		if(($row->published == 1) and ($row->approved == 1)) {
			OSPHelper::updateFacebook($row, $isNew);
			OSPHelper::updateTweet($row, $isNew);
		}

		//check to see if the system use expired mode
		//in that case, check if the property has been published automatically
		//we should insert the expired date into the database
		//in case user is supervisor, he will be redirected to the Manage All Properties
		if (JFactory::getUser()->authorise('frontendmanage', 'com_osproperty')) {
			if($save == 1){
				$needs = array();
				$needs[] = "lmanageproperties";
				$needs[] = "property_manageallproperties";
				$itemid = OSPRoute::getItemid($needs);
				$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&view=lmanageproperties&Itemid=".$itemid),JText::_('OS_ITEM_HAS_BEEN_SAVE'));
			}else{
				$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=property_edit&id=".$id),JText::_('OS_ITEM_HAS_BEEN_SAVE'));
			}
		}else{

			if((intval($configClass['integrate_membership']) == 0) and ($configClass['active_payment'] == 0)){
				if($isNew == 1){
					$db->setQuery("Select count(id) from #__osrs_expired where pid = '$id'");
					$count = $db->loadResult();

					if(($count == 0) and ($configClass['general_approval']==1)){
					
						HelperOspropertyCommon::setApproval("n",$id);
						OspropertyListing::setexpired($option,$id);
					}
					//send Email to admin
					OspropertyEmail::sendEmail($id,'new_property_inform',1);
					//send Email to agent	
					OspropertyEmail::sendEmail($id,'new_property_confirmation',0);
				}else{ //edit
					//do nothing

				}
			}elseif(intval($configClass['integrate_membership']) == 1){//integrate with Membership component
				$membership_sub_id = $jinput->getInt('membership_sub_id',0);
				if($membership_sub_id > 0){
					$db->setQuery("Select * from #__osrs_agent_account where sub_id = '$membership_sub_id'");
					$account = $db->loadObject();
					if($isNew == 1){
						if($account->type == 1){
							//set expired to feature
							//set feature
							//set Feature and approval
							HelperOspropertyCommon::setApproval("f",$id);
							//set Feature expired time
							HelperOspropertyCommon::setExpiredTime($id,"f",$isNew);
							HelperOspropertyCommon::discountSubscription($account->sub_id);
						}else{
							//set expired to normal
							HelperOspropertyCommon::setApproval("n",$id);
							HelperOspropertyCommon::setExpiredTime($id,"n",$isNew);
							HelperOspropertyCommon::discountSubscription($account->sub_id);
						}
					}else{
						if($account->type == 1){
							//set expired to feature
							//set feature
							//set Feature and approval
							HelperOspropertyCommon::setApproval("f",$id);
							//set Feature expired time
							HelperOspropertyCommon::setExpiredTime($id,"f",$isNew);
							HelperOspropertyCommon::discountSubscription($account->sub_id);
						}else{
							//set expired to normal
							HelperOspropertyCommon::setApproval("n",$id);
							HelperOspropertyCommon::setExpiredTime($id,"n",$isNew);
							HelperOspropertyCommon::discountSubscription($account->sub_id);
						}
						
						//compare expired time and featur expired time
						HelperOspropertyCommon::adjustExpiredTime($id);
					}
				}
			}

			//process property type
			$isFeatured = $jinput->getInt('isFeatured',0);
			if($isFeatured == 0){
				$total = $configClass['normal_cost'];
			}else{
				$total = $configClass['general_featured_upgrade_amount'];
			}

			if(($configClass['active_payment'] == 1) and ($passcheck == 0) and ($configClass['integrate_membership'] == 0)){
				//generate water maker image
				OSPHelper::generateWaterMark($id);
				
				//add into order table
				$order = & JTable::getInstance('Order', 'OspropertyTable') ;
				$order->id = 0;
				$order->created_by = $posted_by; //agent or company administrator
				$order->agent_id = $created_by;
				$order->created_on = date("Y-m-d h:i:s",time());
				$order->payment_method = $jinput->getString('payment_method','');
				$card_num = $jinput->getString('x_card_num','');
				$card_num = base64_encode($card_num);
				$order->x_card_num = $card_num;
				$order->x_card_code = $jinput->getInt('x_card_code','');
				$order->card_holder_name = $jinput->getString('card_holder_name','');
				$order->exp_year = $jinput->getString('exp_year','');
				$order->exp_month = $jinput->getString('exp_month','');
				$order->card_type = $jinput->getString('card_type','');
				$order->order_status = 'P';
				$order->total = $total;
				$order->curr = $configClass['general_currency_default'];
				if($isNew == 1){
					$order->direction = 0; //new property
				}else{
					$order->direction = 2; //edit property
				}
				$order->store();
				$order_id = $db->insertid();

				//add into order details table
				$db->setQuery("Insert into #__osrs_order_details (id,order_id,pid,`type`) values (NULL,'$order_id','$id','$isFeatured')");
				$db->query();

				//process payment
				if(floatVal($total) > 0){
					$mainframe->redirect(JURI::root().'index.php?option=com_osproperty&direction=add_new&task=payment_process&order_id='.$order_id.'&Itemid='.$jinput->getInt('Itemid',0));
				}else{

					OspropertyPayment::paymentComplete($order_id);
					//Update Order Status to Complete
					$db->setQuery("Update #__osrs_orders set order_status = 'S' where id = '$order_id'");
					$db->query();
					$mainframe->redirect(JURI::root()."index.php?option=com_osproperty&task=property_thankyou&id=$id&Itemid=".$jinput->getInt('Itemid',0));
				}

			}else{
				if(count($photoIds)  == 0){
					//generate water maker image
					OSPHelper::generateWaterMark($id);
					
					$msg = JText::_('OS_ITEM_SAVED');
					if($isNew == 0){
						if($save == 1){
							if(HelperOspropertyCommon::isAgent()){
								$needs = array();
								$needs[] = "agent_editprofile";
								$needs[] = "agent_default";
								$needs[] = "aeditdetails";
								$itemid = OSPRoute::getItemid($needs);
								$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&view=aeditdetails&Itemid=".$itemid),JText::_('OS_ITEM_HAS_BEEN_SAVE'));
							}elseif(HelperOspropertyCommon::isCompanyAdmin()){
								$needs = array();
								$needs[] = "company_properties";
								$itemid = OSPRoute::getItemid($needs);
								$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=company_properties&Itemid=".$itemid),JText::_('OS_ITEM_HAS_BEEN_SAVE'));
							}
						}else{
							$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=property_edit&id=".$id),JText::_('OS_ITEM_HAS_BEEN_SAVE'));
						}
					}else{
						$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=property_thankyou&id=$id&Itemid=".$jinput->getInt('Itemid',0)));
					}
				}elseif($configClass['custom_thumbnail_photo'] == 1){
					$mainframe->redirect(JURI::root()."index.php?option=com_osproperty&task=property_generatephoto&pid=$id&save=$save&isNew=$isNew&photoIds=".implode(",",$photoIds));
				}else{
					OSPHelper::generateWaterMark($id);
					$msg = JText::_('OS_ITEM_SAVED');
					
					if($isNew == 0){
						if($save == 1){
							if(HelperOspropertyCommon::isAgent()){
								$needs = array();
								$needs[] = "agent_editprofile";
								$needs[] = "agent_default";
								$needs[] = "aeditdetails";
								$itemid = OSPRoute::getItemid($needs);
								$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&view=aeditdetails&Itemid=".$itemid),JText::_('OS_ITEM_HAS_BEEN_SAVE'));
							}elseif(HelperOspropertyCommon::isCompanyAdmin()){
								$needs = array();
								$needs[] = "company_properties";
								$itemid = OSPRoute::getItemid($needs);
								$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=company_properties&Itemid=".$itemid),JText::_('OS_ITEM_HAS_BEEN_SAVE'));
							}
						}else{
							$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=property_edit&id=".$id),JText::_('OS_ITEM_HAS_BEEN_SAVE'));
						}
					}else{
						$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=property_thankyou&id=$id&Itemid=".$jinput->getInt('Itemid',0)));
					}
				}
			}
		}
	}
	
	/**
	 * generator photo
	 *
	 */
	static function generatePhoto(){
		global $mainframe,$jinput;
		$db = JFactory::getDbo();
		$document = JFactory::getDocument();
		$document->addScript(JURI::root()."components/com_osproperty/js/yui/script/yuiloader-min.js");
		$document->addScript(JURI::root()."components/com_osproperty/js/yui/script/yahoo-dom-event.js");
		$document->addScript(JURI::root()."components/com_osproperty/js/yui/script/element-min.js");
		$document->addScript(JURI::root()."components/com_osproperty/js/yui/script/dragdrop-min.js");
		$document->addScript(JURI::root()."components/com_osproperty/js/yui/script/imagecropper-min.js");
		$document->addScript(JURI::root()."components/com_osproperty/js/yui/script/resize-min.js");
		$document->addScript(JURI::root()."components/com_osproperty/js/yui/script/event-min.js");
		$document->addScript(JURI::root()."components/com_osproperty/js/yui/script/dom-min.js");
		$document->addStyleSheet(JURI::root()."components/com_osproperty/js/yui/style/fonts-min.css");
		$document->addStyleSheet(JURI::root()."components/com_osproperty/js/yui/style/imagecropper.css");
		$document->addStyleSheet(JURI::root()."components/com_osproperty/js/yui/style/resize.css");
		$document->addStyleSheet(JURI::root()."components/com_osproperty/js/yui/style/yui.css");
		$document->addStyleSheet(JURI::root()."components/com_osproperty/js/yui/style/dpSyntaxHighlighter.css");
		
		$id = $jinput->getInt('pid',0);
		$db->setQuery("Select * from #__osrs_properties where id = '$id'");
		$property = $db->loadObject();
		$pro_name = OSPHelper::getLanguageFieldValue($property,'pro_name');
		$photoIds = OSPHelper::getStringRequest('photoIds','','');
		$save = $jinput->getInt('save',0);
		HTML_OspropertyListing::generatePhotoCrop("com_osproperty",$id,$photoIds,$save,$pro_name);
	}
	
	/**
	 * Save croping photos
	 *
	 */
	static function savingPhoto(){
        global $mainframe,$jinput;
        $db = JFactory::getDbo();
        $pid = $jinput->getInt('pid',0);
        $isNew = $jinput->getInt('isNew',0);
        $photoIds = OSPHelper::getStringRequest('photoIds','','');
        $save = $jinput->getInt('save',0);
        if($photoIds != ""){
            $photoArr = explode(",",$photoIds);
            if(count($photoArr) > 0){
                for($i=0;$i<count($photoArr);$i++){
                    $photo_id = $photoArr[$i];
                    $db->setQuery("Select image from #__osrs_photos where id = '$photo_id'");
                    $photo_name = $db->loadResult();
                    //thumbnail first
                    $tb = $jinput->getInt('tb_'.$photo_id,0);
                    if($tb == 1){
                        $top    = $jinput->getInt('tb_t_'.$photo_id,0);
                        $left   = $jinput->getInt('tb_l_'.$photo_id,0);
                        $height = $jinput->getInt('tb_h_'.$photo_id,0);
                        $width  = $jinput->getInt('tb_w_'.$photo_id,0);
                        HelperOspropertyCommon::create_photo($top,$left,$height,$width,$photo_name,0,$pid);
                    }

                    $me = $jinput->getInt('me_'.$photo_id,0);
                    if($me == 1){
                        $top    = $jinput->getInt('me_t_'.$photo_id,0);
                        $left   = $jinput->getInt('me_l_'.$photo_id,0);
                        $height = $jinput->getInt('me_h_'.$photo_id,0);
                        $width  = $jinput->getInt('me_w_'.$photo_id,0);
                        HelperOspropertyCommon::create_photo($top,$left,$height,$width,$photo_name,1,$pid);
                    }
                }
            }
        }

        //generate water maker image
        OSPHelper::generateWaterMark($pid);

        $msg = JText::_('OS_ITEM_SAVED');
        if($isNew == 0){
            if($save == 1){
                $needs = array();
                $needs[] = "agent_editprofile";
                $needs[] = "agent_default";
                $needs[] = "lagents";
                $itemid = OSPRoute::getItemid($needs);
                $mainframe->redirect(JRoute::_("index.php?option=com_osproperty&view=aeditdetails&Itemid=".$itemid),JText::_('OS_ITEM_HAS_BEEN_SAVE'));
            }else{
                $mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=property_edit&id=".$pid),JText::_('OS_ITEM_HAS_BEEN_SAVE'));
            }
        }else{
            if($save == 1){
                $mainframe->redirect(JURI::root()."index.php?option=com_osproperty&task=property_thankyou&id=$pid&Itemid=".$jinput->getInt('Itemid',0));
            }else{
                $mainframe->redirect(JURI::root()."index.php?option=com_osproperty&task=property_edit&id=".$pid,JText::_('OS_ITEM_HAS_BEEN_SAVE'));
            }
        }
    }
	
	/**
	 * Skip croping photos
	 *
	 */
    function skip(){
        global $mainframe,$jinput;
        //generate water maker image
        $pid        = $jinput->getInt('pid',0);
        OSPHelper::generateWaterMark($pid);
        $pid        = $jinput->getInt('pid',0);
        $isNew      = $jinput->getInt('isNew',0);
        $save       = $jinput->getInt('save',0);
        if($isNew == 0){
            if($save == 1){
                $needs = array();
                $needs[] = "agent_editprofile";
                $needs[] = "agent_default";
                $needs[] = "lagents";
                $itemid = OSPRoute::getItemid($needs);

                $mainframe->redirect(JRoute::_("index.php?option=com_osproperty&view=aeditdetails&Itemid=".$itemid),JText::_('OS_ITEM_HAS_BEEN_SAVE'));
            }else{
                $mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=property_edit&id=".$pid),JText::_('OS_ITEM_HAS_BEEN_SAVE'));
            }
        }else{
            $mainframe->redirect(JURI::root()."index.php?option=com_osproperty&task=property_thankyou&id=$pid&Itemid=".$jinput->getInt('Itemid',0));
        }
    }
	
	/**
	 * Thank you function 
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
    static  function thankyouPage($option,$id){
        global $mainframe,$configClass,$lang_suffix,$jinput;
        $configClass = OSPHelper::loadConfig();
        $document = JFactory::getDocument();
        $new = $jinput->getInt('new',1);
        if($new == 1){
            $document->setTitle(JText::_('OS_PROPERTY_SAVED'));
        }else{
            $document->setTitle(JText::_('OS_PROPERTY_SAVED'));
        }
        $db = JFactory::getDbo();

        $db->setQuery("Select a.*,c.country_name,d.type_name,e.state_name$lang_suffix as state_name from #__osrs_properties as a inner join #__osrs_countries as c on c.id = a.country inner join #__osrs_types as d on d.id = a.pro_type inner join #__osrs_states as e on e.id = a.state where a.id = '$id'");
        $property = $db->loadObject();

        $db->setQuery("Select * from #__osrs_photos where pro_id = '$id'");
        $photos = $db->loadObjectList();

        $db->setQuery("select b.* from #__osrs_property_amenities as a inner join #__osrs_amenities as b on b.id = a.amen_id where a.pro_id = '$id'");
        $amenities = $db->loadObjectList();

        $db->setQuery("Select * from #__osrs_fieldgroups where published = '1' order by ordering");
        $groups = $db->loadObjectList();
        if(count($groups) > 0){
            for($i=0;$i<count($groups);$i++){
                $group = $groups[$i];
                $db->setQuery("Select * from #__osrs_extra_fields where published = '1' and group_id = '$group->id' order by ordering");

                $fields = $db->loadObjectList();
                $groups[$i]->fields = $fields;
            }
        }

        $db->setQuery("Select * from #__osrs_expired where pid = '$id'");
        $expired = $db->loadObjectList();

        $db->setQuery("Select name from #__osrs_agents where id = '$property->agent_id'");
        $property->agentname = $db->loadResult();

        $order_id = OSPHelper::getStringRequest('order_id','');
        if($order_id != ""){
            $order_id = base64_decode($order_id);
            if(intval($order_id) > 0){
                $db->setQuery("Select * from #__osrs_orders where id = '$order_id'");
                $order = $db->loadObject();
                $msg = array();
                if($order->order_status == "P"){
                    $msg[] = JText::_('OS_ORDER_HAS_BEEN_STORED');
                }
                if($order->payment_made == 0){
                    $msg[] = JText::_('OS_PROPERTY_WILL_BE_APPROVED_AFTER_YOU_MAKE_PAYMENT');
                }else{
                    $msg[] = JText::_('OS_PAYMENT_MADE');
                }
                if(count($msg) > 0){
                    for($i=0;$i<count($msg);$i++){
                        $msg[$i] = "<i class='osicon-ok'></i>&nbsp;".$msg[$i];
                    }
                    $msg = implode("<Br />",$msg);
                    JFactory::getApplication()->enqueueMessage($msg, 'message');
                }
            }
        }

        HTML_OspropertyListing::thankyouPage($option,$property,$expired,$photos,$amenities,$groups);
    }
	
	/**
	 * Upgrade Property step 1
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 */
	function upgrade_step1($option,$cid){
		global $mainframe,$configs,$configClass,$jinput;
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$document = JFactory::getDocument();
        OSPHelper::generateHeading(1,$configClass['general_bussiness_name']." - ".JText::_('OS_UPGRADE_PROPERTIES_TO_FEATURE'));
		//check to see if user is agent
        
		if(!HelperOspropertyCommon::isAgent()){
			if(!HelperOspropertyCommon::isCompanyAdmin()){
				JError::raiseError( 500, JText::_('OS_YOU_HAVE_NOT_GOT_PERMISSION_GO_TO_THIS_AREA') );
			}else{
				$agent_id = HelperOspropertyCommon::getCompanyId();
			}
		}else{
			$agent_id = HelperOspropertyCommon::getAgentID();
		}
		//
		if(count($cid) > 0){
			for($i=0;$i<count($cid);$i++){
				$id = $cid[$i];
				//check to see if current user is owner of the property
				$db->setQuery("Select count(id) from #__osrs_properties where agent_id = '$agent_id'");
				$count = $db->loadResult();
				if($count == 0){
					JError::raiseError( 500, JText::_('OS_YOU_HAVE_NOT_GOT_PERMISSION_GO_TO_THIS_AREA') );
				}
			}
		}
		
		if(count($cid) > 0){
			$cids = implode(",",$cid);
			$db->setQuery("Select a.*,b.image from #__osrs_properties as a left join #__osrs_photos as b on b.pro_id = a.id where a.id in ($cids) group by a.id order by b.ordering");
			$rows = $db->loadObjectList();
		}
		
		//check to see if we have the coupon
        /*
		$current_time = date("Y-m-d",time());
		$db->setQuery("Select * from #__osrs_coupon where start_time <= '$current_time' and end_time >= '$current_time' and published = '1'");
		$coupon = $db->loadObject();
        */
        //payment for checking
        if($configClass['active_payment'] == 1){
            $paymentMethod = $jinput->getString('payment_method', os_payments::getDefautPaymentMethod());
            if (!$paymentMethod) $paymentMethod = os_payments::getDefautPaymentMethod();
        }

        ###############Payment Methods parameters###############################

        //Creditcard payment parameters
        $x_card_num = $jinput->getString('x_card_num', '');
        $expMonth =  $jinput->getString('exp_month', date('m')) ;
        $expYear = $jinput->getString('exp_year', date('Y')) ;
        $x_card_code = $jinput->getString('x_card_code', '');
        $cardHolderName = $jinput->getString('card_holder_name', '') ;
        $lists['exp_month'] = JHTML::_('select.integerlist', 1, 12, 1, 'exp_month', ' id="exp_month" class="input-mini"  ', $expMonth, '%02d') ;
        $currentYear = date('Y') ;
        $lists['exp_year'] = JHTML::_('select.integerlist', $currentYear, $currentYear + 10 , 1, 'exp_year', ' id="exp_year" class="input-small" ', $expYear) ;
        $options =  array() ;
        $cardTypes = explode(',', $configClass['enable_cardtypes']);
        if (in_array('Visa', $cardTypes)) {
            $options[] = JHTML::_('select.option', 'Visa', JText::_('OS_VISA_CARD')) ;
        }
        if (in_array('MasterCard', $cardTypes)) {
            $options[] = JHTML::_('select.option', 'MasterCard', JText::_('OS_MASTER_CARD')) ;
        }

        if (in_array('Discover', $cardTypes)) {
            $options[] = JHTML::_('select.option', 'Discover', JText::_('OS_DISCOVER')) ;
        }
        if (in_array('Amex', $cardTypes)) {
            $options[] = JHTML::_('select.option', 'Amex', JText::_('OS_AMEX')) ;
        }
        $lists['card_type'] = JHTML::_('select.genericlist', $options, 'card_type', ' class="input-large" ', 'value', 'text') ;
        //Echeck

        $x_bank_aba_code = $jinput->getString('x_bank_aba_code', '') ;
        $x_bank_acct_num = $jinput->getString('x_bank_acct_num', '') ;
        $x_bank_name = $jinput->getString('x_bank_name', '') ;
        $x_bank_acct_name = $jinput->getString('x_bank_acct_name', '') ;
        $options = array() ;
        $options[] = JHTML::_('select.option', 'CHECKING', JText::_('OS_BANK_TYPE_CHECKING')) ;
        $options[] = JHTML::_('select.option', 'BUSINESSCHECKING', JText::_('OS_BANK_TYPE_BUSINESSCHECKING')) ;
        $options[] = JHTML::_('select.option', 'SAVINGS', JText::_('OS_BANK_TYPE_SAVING')) ;
        $lists['x_bank_acct_type'] = JHTML::_('select.genericlist', $options, 'x_bank_acct_type', ' class="input-large" ', 'value', 'text', OSPHelper::getStringRequest('x_bank_acct_type')) ;

        $methods = os_payments::getPaymentMethods(true, false) ;

        $lists['x_card_num'] = $x_card_num;
        $lists['x_card_code'] = $x_card_code;
        $lists['cardHolderName'] = $cardHolderName;
        $lists['x_bank_acct_num'] = $x_bank_acct_num;
        $lists['x_bank_acct_name'] = $x_bank_acct_name;
        $lists['methods'] = $methods;
        $lists['idealEnabled'] = false;
        $lists['paymentMethod'] = $paymentMethod;
		//check to see if user has already get the coupon before
		
		if($configClass['integrate_membership'] == 1){
			HTML_OspropertyListing::updateFormStep1WithMembership($option,$rows,$coupon);
		}else{
			HTML_OspropertyListing::updateFormStep1($rows,$lists);
		}
	}
	
	/**
	 * Remove Upgrade property from the list
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 */
	function removeUpgrade($option,$cid){
		global $mainframe,$jinput;
		$db = JFactory::getDBO();
		$remove_value = $jinput->getInt('remove_value',0);
		$cids = array();
		$needs = array();
		$needs[] = "aeditdetails";
		$needs[] = "agent_default";
		$needs[] = "agent_editprofile";
		$itemid = OSPRoute::getItemid($needs);
		if(count($cid) > 0){
			$j = 0;
			for($i=0;$i<count($cid);$i++){
				if($cid[$i] != $remove_value){
					$cids[$j] = $cid[$i];
					$j++;
				}
			}
			$cid = $cids;
			//make the form and submit it
			if(count($cid) > 0){
				?>
				<form method="POST" action="index.php" name="ftForm">
					<input type="hidden" name="option" value="com_osproperty" />
					<input type="hidden" name="task" value="property_upgrade" />
					<input type="hidden" name="Itemid" value="<?php echo $jinput->getInt('Itemid',0)?>" />
					<select name="cid[]" multiple style="display:none;">
					<?php
					for($i=0;$i<count($cid);$i++){
						?>
						<option value="<?php echo $cid[$i]?>" selected></option>
						<?php
					}
					?>
					</select>
				</form>
				<script language="javascript">
					document.ftForm.submit();
				</script>
				<?php
			}else{
				//change to agent's properties because there aren't any properties
				$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=agent_default&Itemid=".$itemid));
			}
		}else{
			//change to agent's properties
			$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=agent_default&Itemid=".$itemid));
		}
	}
	
	/**
	 * Confirm upgrade;
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 */
	function confirmUpgrade($option,$cid){
		global $mainframe,$configClass,$configs;
		$db = JFactory::getDBO();
		$document = JFactory::getDocument();
		$document->setTitle($configClass['general_bussiness_name']." - ".JText::_('OS_UPGRADE_PROPERTIES_TO_FEATURE'));
		$user = JFactory::getUser();
		//check to see if user is agent
		if(!HelperOspropertyCommon::isAgent()){
			$mainframe->redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
		}else{
			$agentId = HelperOspropertyCommon::getAgentID();
		}
		
		//
		if(count($cid) > 0){
			for($i=0;$i<count($cid);$i++){
				$id = $cid[$i];
				//check to see if current user is owner of the property
				$db->setQuery("Select count(id) from #__osrs_properties where agent_id = '$agentId'");
				$count = $db->loadResult();
				if($count == 0){
					$mainframe->redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));	
				}
			}
		}else{
			$mainframe->redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));	
		}
		
		if(count($cid) > 0){
			$cids = implode(",",$cid);
			$db->setQuery("Select a.*,b.image from #__osrs_properties as a left join #__osrs_photos as b on b.pro_id = a.id where a.id in ($cids) group by a.id order by b.ordering");
			$rows = $db->loadObjectList();
		}
		
		//check to see if we have the coupon
		$current_time = date("Y-m-d",time());
		$db->setQuery("Select * from #__osrs_coupon where start_time <= '$current_time' and end_time >= '$current_time' and published = '1'");
		$coupon = $db->loadObject();
		
		$coupon_id = $_COOKIE['coupon_code_awarded'];
		$awarded = 0;
		if($coupon_id != ""){
			if($coupon_id == $coupon->id){
				$awarded = 1;
				setcookie('coupon_id',$coupon_id,time() + 3600);
			}
		}
		if(($configClass['general_featured_upgrade_amount'] == 0) and ((int)$configClass['active_payment'] == 0)){
			//process upgrade
			OspropertyListing::upgradeProperties($cid);
			$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=agent_editprofile"),JText::_('OS_PROPERTIES_HAVE_BEEN_UPGRADED'));
		}else{
			HTML_OspropertyListing::confirmUpgrade($option,$rows,$coupon,$awarded);
		}
	}
	
	function confirmUpgradewithMembership($option,$cid){
		global $mainframe,$configClass,$jinput;
		$db = JFactory::getDBO();
		$document = JFactory::getDocument();
		$document->setTitle($configClass['general_bussiness_name']." - ".JText::_('OS_UPGRADE_PROPERTIES_TO_FEATURE'));
		$user = JFactory::getUser();
		//check to see if user is agent
		if(!HelperOspropertyCommon::isAgent()){
			$mainframe->redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
		}else{
			$agentId = HelperOspropertyCommon::getAgentID();
		}
		
		//
		if(count($cid) > 0){
			for($i=0;$i<count($cid);$i++){
				$id = $cid[$i];
				//check to see if current user is owner of the property
				$db->setQuery("Select count(id) from #__osrs_properties where agent_id = '$agentId'");
				$count = $db->loadResult();
				if($count == 0){
					$mainframe->redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));	
				}
			}
		}else{
			$mainframe->redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));	
		}
		
		if(count($cid) > 0){
			$cids = implode(",",$cid);
			$db->setQuery("Select a.*,b.image from #__osrs_properties as a left join #__osrs_photos as b on b.pro_id = a.id where a.id in ($cids) group by a.id order by b.ordering");
			$rows = $db->loadObjectList();
		}
		
		$membership_sub_id = $jinput->getInt('membership_sub_id',0);
		if($membership_sub_id == 0){
			$msg = JText::_('OS_PLEASE_SELECT_SUBSCRIPTION_PLAN');
			$mainframe->redirect(JURI::root()."index.php?option=com_osproperty&task=property_upgrade&cid[]=".$rows[0]->id,$msg);
		}else{
			$db->setQuery("UPDATE #__osrs_properties SET isFeatured = '1' WHERE id = '".$rows[0]->id."'");
			$db->query();
			HelperOspropertyCommon::setExpiredTime($rows[0]->id,'f',0);
			HelperOspropertyCommon::discountSubscription($membership_sub_id);
			$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=agent_editprofile"),JText::_('OS_PROPERTIES_HAVE_BEEN_UPGRADED'));
		}
	}
	/**
	 * payment process
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 */
	function paymentprocess($option,$cid){
		global $mainframe,$configClass,$jinput;
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$amount = $configClass['general_featured_upgrade_amount'];
		//check to see if user is agent
		if(!HelperOspropertyCommon::isAgent()){
			if(!HelperOspropertyCommon::isCompanyAdmin()){
	            JError::raiseError(500,JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
			}else{
				$agent_id = HelperOspropertyCommon::getCompanyId();
				$created_by = 1;
			}
		}else{
			$agent_id = HelperOspropertyCommon::getAgentID();
			$created_by = 0;
		}
		//
		if(count($cid) > 0){
			for($i=0;$i<count($cid);$i++){
				$id = $cid[$i];
				//check to see if current user is owner of the property
				$db->setQuery("Select count(id) from #__osrs_properties where agent_id = '$agent_id'");
				$count = $db->loadResult();
				if($count == 0){
					JError::raiseError(500,JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
				}
			}
		}else{
			//$mainframe->redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
            JError::raiseError(500,JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
		}

        if((floatVal($amount) > 0) and ($configClass['active_payment'] == 1)){
            $total = 0;
            if (count($cid) > 0) {
                $cids = implode(",", $cid);
                $db->setQuery("Select * from #__osrs_properties where id in ($cids)");
                $rows = $db->loadObjectList();
                for ($i = 0; $i < count($rows); $i++) {
                    $total = $total + $amount;
                }
            }

            //make the new order
            $row = &JTable::getInstance('Order', 'OspropertyTable');
            $row->id = 0;
            $row->created_on = date("Y-m-d H:i:s", time());
            $row->order_status = "P";
            $row->transaction_id = "";
            $row->total = $total;
            $row->message = "";
            $row->agent_id = $agent_id;
            $row->created_by = $created_by;
            $row->payment_method = $jinput->getString('payment_method', '');
            $card_num = $jinput->getString('x_card_num', '');
            $card_num = base64_encode($card_num);
            $row->x_card_num = $card_num;
            $row->x_card_code = $jinput->getInt('x_card_code', '');
            $row->card_holder_name = $jinput->getString('card_holder_name', '');
            $row->exp_year = $jinput->getString('exp_year', '');
            $row->exp_month = $jinput->getString('exp_month', '');
            $row->card_type = $jinput->getString('card_type', '');
            $row->curr = $configClass['general_currency_default'];
            $row->direction = 1; //upgrade property to featured
            $row->store();

            //order id
            $order_id = $db->insertID();

            //add property into order details table

            for ($i = 0; $i < count($cid); $i++) {
                $pid = $cid[$i];
                $db->setQuery("Insert into #__osrs_order_details (id, order_id, pid,`type`) values (NULL,'$order_id','$pid',1)");
                $db->query();
            }
            $mainframe->redirect(JUri::root() . "index.php?option=com_osproperty&task=payment_process&order_id=$order_id&Itemid=" . $jinput->getInt('Itemid', 0));
        }else{
            if (count($cid) > 0) {
                for ($i = 0; $i < count($cid); $i++) {
                    $pid = $cid[$i];
                    HelperOspropertyCommon::setApproval("f",$pid);
                    //set Feature expired time
                    HelperOspropertyCommon::setExpiredTime($pid,"f",0);
                }
            }
            $msg = array();
            $msg[] = JText::_('OS_PROPERTIES_HAS_BEEN_UPGRADED_TO_FEATURED');
            $needs = array();
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
            $mainframe->redirect($url,$msg);
        }
	}
	
	/**
	 * Load States
	 *
	 * @param unknown_type $option
	 */
	static function loadStates($option){
		global $mainframe,$lang_suffix,$jinput;
		$db = JFactory::getDBO();
		$country_id = $jinput->getInt('country_id',0);
		$stateArr = array();
		$stateArr[] = JHTML::_('select.option','',JText::_('OS_SELECT_STATE'));
		$query  = "Select id as value,state_name$lang_suffix as text from #__osrs_states where 1=1 ";
		if($country_id > 0){
			$query .= " and country_id = '$country_id'";
		}
		$query .= " order by state_name";
		$db->setQuery($query);
		$states = $db->loadObjectList();
		$stateArr   = array_merge($stateArr,$states);
		echo JHTML::_('select.genericlist',$stateArr,'state','class="input-small"','value','text');
		?>
		<!--<label><font class="small_text"><?php echo JText::_('OS_NEW_STATE')?>:</font></label> <input type="text" name="nstate" id="nstate" size="10" class="inputbox">-->
		<?php
		echo '<span class="required">(*)</span>';
	}
	
	
	static function propertyDetails($pid){
		global $mainframe,$configClass,$lang_suffix,$option;
		$db = JFactory::getDBO();
		
		//$db->setQuery("Select * from #__osrs_configuration");
		//$configs = $db->loadObjectList();
		
		$row = &JTable::getInstance('Property','OspropertyTable');
		if($pid > 0){
			$row->load((int)$pid);
			$db->setQuery("Select amen_id from #__osrs_property_amenities where pro_id = '$row->id'");
			$amenitylists = $db->loadOBjectList();
			$amenitylists1 = array();
			if(count($amenitylists) > 0){
				for($i=0;$i<count($amenitylists);$i++){
					$amenitylists1[$i] = $amenitylists[$i]->amen_id;
				}
				$amenitylists = array();
				$amenitylists = $amenitylists1;
			}
			
			$db->setQuery("Select * from #__osrs_photos where pro_id = '$pid' order by ordering");
			$photos = $db->loadobjectList();
			$row->photo = $photos;
		}else{
			$row->published = 1;
			$row->access = 0;
		}
		
		$lists['show_address'] = JHTML::_('select.booleanlist', 'show_address', '', $row->show_address);
		$lists['price_call'] = JHTML::_('select.booleanlist', 'price_call', '', $row->price_call);
		
		//agent
		$db->setQuery("SELECT * FROM #__osrs_agents WHERE `published` = '1' AND `id` = '$row->agent_id'");
		$agent = $db->loadObject();
		//agent country;
		//$db->setQuery("select country_name from #__osrs_countries where id = '$agent->country'");
		$agent->country_name = OSPHelper::getCountryName($agent->country);
		$row->agent = $agent;
		
		//agent state;
		$db->setQuery("select state_name$lang_suffix as state_name from #__osrs_states where id = '$agent->state'");
		$agent->state_name = $db->loadResult();
		
		//property types
		$db->setQuery("SELECT * FROM #__osrs_types WHERE `published` = '1' AND `id` = '$row->pro_type'");
		$rs = $db->loadObject();
		$lists['type'] = OSPHelper::getLanguageFieldValue($rs,'type_name');
		
		//categories
		$db->setQuery("SELECT * FROM #__osrs_categories WHERE `id` = '$row->category_id'");
		$rs = $db->loadObject();
		$lists['category'] = OSPHelper::getLanguageFieldValue($rs,'category_name');
		
		//country
		//$db->setQuery("SELECT country_name FROM #__osrs_countries WHERE `id` = '$row->country'");
		//$lists['country'] = $db->loadResult();
		
		//states
		//$db->setQuery("SELECT state_name FROM #__osrs_states WHERE `id` = '$row->state'");
		//$lists['states'] = $db->loadResult();
		
		// access
			$lists['access'][0] = JText::_('OS_PUBLIC');
			$lists['access'][1] = JText::_('OS_REGISTERED');
			$lists['access'][2] = JText::_('OS_SPECIAL');
		
		$db->setQuery("SELECT * FROM #__osrs_amenities WHERE published = '1' order by ordering");
		$amenities = $db->loadObjectList();
		
		$user = JFactory::getUser();

        $access_sql = ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
		$db->setQuery("Select * from #__osrs_fieldgroups where published = '1' $access_sql order by ordering");
		$groups = $db->loadObjectList();
		if(count($groups) > 0){
			for($i=0;$i<count($groups);$i++){
				$group = $groups[$i];
                $access_sql = ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
			}
		}
		
		//ob_start();
		//HTML_OspropertyListing::printPropertyEmail($option,$row,$lists,$amenities,$amenitylists,$groups,$configs);
		//$body = ob_get_contents();
		//ob_end_clean();
		//return $body;
		
		if(JFile::exists(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/propertyprint.php')){
			$tpl = new OspropertyTemplate(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/');
		}else{
			$tpl = new OspropertyTemplate(JPATH_COMPONENT.'/helpers/layouts/');
		}
		$tpl->set('option',$option);
		$tpl->set('row',$row);
		$tpl->set('lists',$lists);
		$tpl->set('amenities',$amenities);	
		$tpl->set('amenitylists',$amenitylists);
		$tpl->set('groups',$groups);
		//$tpl->set('configs',$configs);
		$tpl->set('configClass',$configClass);
		$body = $tpl->fetch("propertyprint.php");
		echo $body;
	}
	
	/**
	 * Print property function
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	static function printProperty($option,$id){
		global $mainframe;
		$document = JFactory::getDocument();
		$document->setMetaData( "robots", "noindex" );
		echo OspropertyListing::propertyDetails($id);
	}
	
	static  function showSharingForm($id){
		global $mainframe,$configClass,$jinput;
		$captcha_value = $jinput->getString('c','');
		$db = JFactory::getDbo();
		$db->setQuery("Select * from #__osrs_properties where id = '$id'");
		$property = $db->loadObject();
		$title = "";
		if($property->ref != ""){
			$title .= $property->ref.", ";
		}
		$title .= OSPHelper::getLanguageFieldValue($property,'pro_name');
		
		//$db->setQuery("Select * from #__osrs_themes where published = '1'");
		//$theme = $db->loadObject();
		//$themename = ($theme->name!= "")? $theme->name:"default";
		$themename = OSPHelper::getThemeName();
		$db->setQuery("Select * from #__osrs_themes where name like '$themename'");
		$themeobj = $db->loadObject();
		if(file_exists(JPATH_COMPONENT.DS."templates".DS.$themename.DS."sharing.html.tpl.php")){
			$tpl = new OspropertyTemplate();
			$tpl->set('id',$id);
			$tpl->set('title',$title);
			$tpl->set('captcha_value',$captcha_value);
			$body = $tpl->fetch("sharing.html.tpl.php");	
			echo $body;	
		}
	}
	/**
	 * Submit tell friend form
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	static function submitTellfriend($option,$id){
		global $mainframe,$configClass,$jinput;
		$db = JFactory::getDbo();

		$itemid = OSPRoute::getPropertyItemid($id);
		
		if($configClass['property_mail_to_friends'] == 0){
			$msg = JText::_('OS_THIS_FUNCTIONALITY_DOES_NOT_BE_ACTIVATED');
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,$msg);
		}
		
		$captcha_str = $_POST['captcha_str'];
		$sharing_security_code = $jinput->getString('sharing_security_code','');
		if($sharing_security_code == ''){
			$msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,$msg);
		}
		if($captcha_str == ''){
			$msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,$msg);
		}
		if($sharing_security_code != $captcha_str){
			$msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,$msg);
		}
		if($configClass['integrate_stopspamforum'] == 1){
			if(OSPHelper::spamChecking()){
				$msg = JText::_('OS_EMAIL_CANT_BE_SENT');
				$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
				$mainframe->redirect($url,$msg);
			}
		}

        $session = JFactory::getSession();
        $pid = $session->get('pid',0);
        if(($pid == 0) or ($pid != $id)){
            $msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
            $url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
            $mainframe->redirect($url,$msg);
        }
		
		$friend_name 				 = OSPHelper::getStringRequest('friend_name','','');
		$friend_email 				 = OSPHelper::getStringRequest('friend_email','','');
		$your_name 					 = OSPHelper::getStringRequest('your_name','','');
		$your_email 			 	 = OSPHelper::getStringRequest('your_email','','');
		$message					 = $_POST['message'];
		
		$contact['friend_name']  	 = $friend_name;
		$contact['friend_email'] 	 = $friend_email;
		$contact['your_name']   	 = $your_name;
		$contact['your_email']  	 = $your_email;
		$contact['message'] 		 = $message;
		//$link 						 = JRoute::_(JURI::root()."index.php?option=com_osproperty&task=property_details&id=$id");
		$link						 = JRoute::_("index.php?option=com_osproperty&task=property_details&id=".$id."&Itemid=".$itemid);
		$link						 = JUri::getInstance()->toString(array('scheme', 'user', 'pass', 'host')).$link;
		$contact['link']			 = "<a href='".$link."'>".$link."</a>";
		OspropertyEmail::sendFriendEmail($option,$contact);
		$tmpl = $jinput->getString('tmpl','');
		if($tmpl == "component"){
			?>
			<div style="width:90%;padding:20px;">
				<h2>
					<?php echo JText::_('OS_EMAIL_HAS_BEEN_SENT_TO_YOUR_FRIEND');?>
				</h2>
			</div>
			<?php
		}else{
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,JText::_('OS_EMAIL_HAS_BEEN_SENT_TO_YOUR_FRIEND'));
		}
	}
	
	/**
	 * Submit comment
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	function submitComment($option,$id){
		global $mainframe,$configClass,$jinput;
		$db = JFactory::getDbo();

		$itemid = OSPRoute::getPropertyItemid($id);
		
		if($configClass['comment_active_comment'] == 0){
			$msg = JText::_('OS_THIS_FUNCTIONALITY_DOES_NOT_BE_ACTIVATED');
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,$msg);
		}
		
		$captcha_str = $_POST['captcha_str'];
		$sharing_security_code = $jinput->getString('comment_security_code','','post');
		if($sharing_security_code == ''){
			$msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,$msg);
		}
		if($captcha_str == ''){
			$msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,$msg);
		}
		if($sharing_security_code != $captcha_str){
			$msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
			$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
			$mainframe->redirect($url,$msg);
		}
		
		
		if($configClass['integrate_stopspamforum'] == 1){
			if(OSPHelper::spamChecking()){
				$msg = JText::_('0S_CANNOT_ADD_THE_COMMENT_NOW');
				$url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
				$mainframe->redirect($url,$msg);
			}
		}

        $session = JFactory::getSession();
        $pid = $session->get('pid',0);
        if(($pid == 0) or ($pid != $id)){
            $msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
            $url = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid);
            $mainframe->redirect($url,$msg);
        }
		
		$comment_author 	= OSPHelper::getStringRequest('comment_author','','');
		$comment_title  	= OSPHelper::getStringRequest('comment_title','','');
		$comment_message	= $_POST['comment_message'];
		$rating				=$jinput->getString('rating','');
		
		//check to see if user is already 
		//and only in the case comment_allow_register=1;
		if($configClass['registered_user_write_comment'] == 1){
			$user = JFactory::getUser();
			$db->setQuery("Select count(id) from #__osrs_comments where pro_id = '$id' and user_id = '$user->id'");
            $count = $db->loadResult();
			if(($count > 0) and ($configClass['only_one_review'] == 1)){
				$mainframe->redirect(JRoute::_("index.php?opton=com_osproperty&task=property_details&id=$id&Itemid=".$itemid),JText::_('OS_YOU_HAVE_COMMENTED_FOR_THIS_PROPERTY_ALREADY'));
			}
		}
		
		$row = JTable::getInstance('Comment','OspropertyTable');
		$post = $jinput->post->getArray();
		$row->bind($post);
		$row->id = 0;
		if($configClass['registered_user_write_comment'] == 1){
			$user = JFactory::getUser();
			$row->user_id = $user->id;
		}else{
			$row->user_id = 0;
		}
		$row->content = $comment_message;
		$row->title = $comment_title;
		$row->name = $comment_author;
		$row->pro_id = $id;
		$row->rate = $rating;
		$row->created_on = date("Y-m-d H:i:s",time());
		if($configClass['comment_auto_approved'] == 1){
			$row->published = 1;
			$row->alreadyPublished = 1;
		}else{
			$row->published = 0;
			$row->alreadyPublished = 0;
		}
		$row->store();
		
		$cmt_id = $db->insertID();
		
		//if the comment is published automatically, update the rating and send email to property's onwer
		if($configClass['comment_auto_approved'] == 1){
			$db->setQuery("Select number_votes,total_points from #__osrs_properties where id = '$id'");
			$rating_details = $db->loadObject();
			$number_votes = $rating_details->number_votes;
			$total_points = $rating_details->total_points;
			$number_votes++;
			$total_points += $rating;	
			
			$db->setQuery("Update #__osrs_properties set number_votes = '$number_votes',total_points='$total_points' where id = '$id'");
			$db->query();
			
			//send email to property's onwer
			$emailopt['author'] 	= $comment_author;
			$emailopt['message']	= $comment_message;
			$emailopt['title'] 		= $comment_title;
			$emailopt['rate'] 		= $rating."/5";
			
			$query = "Select a.name,a.email from #__osrs_agents as a inner join #__osrs_properties as b on b.agent_id = a.id where b.id = '$id'";
			$db->setQuery($query);
			$agent = $db->loadObject();
			$emailopt['agentname'] = $agent->name;
			$emailopt['agentemail'] = $agent->email;
			
			$link = JRoute::_("index.php?option=com_osproperty&task=property_details&id=".$id);
			$emailopt['link'] 		= "<a href='$link'>".$link."</a>";
					
			OspropertyEmail::sendCommentEmail($option,$emailopt);
			
			$msg = JText::_('OS_COMMENT_HAS_BEEN_SUBMITTED');
		}else{
			//send email to administrator to inform there are new comment			
			//send email to property's onwer
			$db->setQuery("Select * from #__osrs_properties where id = '$id'");
			$property = $db->loadObject();
			$pro_name = OSPHelper::getLanguageFieldValue($property,'pro_name');
			
			$emailopt['pro_name']	= $pro_name;
			$emailopt['author'] 	= $comment_author;
			$emailopt['message']	= $comment_message;
			$emailopt['title'] 		= $comment_title;
			$emailopt['rate'] 		= $rating."/5";
			
			$link = JURI::root()."administrator/index.php?option=com_osproperty&task=comment_list";
			$emailopt['link'] 		= "<a href='$link'>".$link."</a>";
					
			OspropertyEmail::sendAdministratorCommentEmail($option,$emailopt);
			
			$msg = JText::_('OS_COMMENT_HAS_BEEN_SUBMITTED_ADMINISTRATOR_WILL_CHECK_AND_PUBLISH_THE_COMMENT_AS_SOON_AS_POSSIBLE');
		}
		$link = JRoute::_("index.php?option=com_osproperty&task=property_details&id=$id&Itemid=".$itemid);
		$mainframe->redirect($link,$msg);
	}
	
	
	/**
	 * Export property in pdf layout
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	function exportpdf($option,$pid){
		global $mainframe,$configClass,$lang_suffix,$languages;
		$db = JFactory::getDBO();
		
		$pdf_root = JPATH_ROOT.DS."tmp";
		$filename = "property".$pid.".pdf";
		//update the content of the pdf file before download it
		//$db->setQuery("Select * from #__osrs_configuration");
		//$configs = $db->loadObjectList();
		
		$row = &JTable::getInstance('Property','OspropertyTable');
		if($pid > 0){
			$row->load((int)$pid);
			$db->setQuery("Select amen_id from #__osrs_property_amenities where pro_id = '$row->id'");
			$amenitylists = $db->loadOBjectList();
			$amenitylists1 = array();
			if(count($amenitylists) > 0){
				for($i=0;$i<count($amenitylists);$i++){
					$amenitylists1[$i] = $amenitylists[$i]->amen_id;
				}
				$amenitylists = array();
				$amenitylists = $amenitylists1;
			}
			
			$db->setQuery("Select * from #__osrs_photos where pro_id = '$pid' order by ordering");
			$photos = $db->loadobjectList();
			$row->photo = $photos;
		}else{
			$row->published = 1;
			$row->access = 0;
		}
		
		$lists['show_address'] = JHTML::_('select.booleanlist', 'show_address', '', $row->show_address);
		$lists['price_call'] = JHTML::_('select.booleanlist', 'price_call', '', $row->price_call);
		
		//agent
		$db->setQuery("SELECT * FROM #__osrs_agents WHERE `published` = '1' AND `id` = '$row->agent_id'");
		$agent = $db->loadObject();
		//agent country;
		//$db->setQuery("select country_name from #__osrs_countries where id = '$agent->country'");
		$agent->country_name = OSPHelper::getCountryName($agent->country);//$db->loadResult();
		$row->agent = $agent;
		
		//agent state;
		$db->setQuery("select state_name$lang_suffix as state_name from #__osrs_states where id = '$agent->state'");
		$agent->state_name = $db->loadResult();
		
		//property types
		$db->setQuery("SELECT id,type_name$lang_suffix as type_name FROM #__osrs_types WHERE `published` = '1' AND `id` = '$row->pro_type'");
		$type = $db->loadObject();
		$lists['type'] = OSPHelper::getLanguageFieldValue($type,'type_name');
		
		
		//country
		///$db->setQuery("SELECT country_name FROM #__osrs_countries WHERE `id` = '$row->country'");
		$lists['country'] = OSPHelper::getCountryName($row->country);//$db->loadResult();
		
		//states
		$db->setQuery("SELECT state_name$lang_suffix as state_name FROM #__osrs_states WHERE `id` = '$row->state'");
		$lists['states'] = $db->loadResult();
		
		$db->setQuery("SELECT * FROM #__osrs_amenities WHERE published = '1' order by ordering");
		$amenities = $db->loadObjectList();

        $access_sql = ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';

		$db->setQuery("Select * from #__osrs_fieldgroups where published = '1' $access_sql order by ordering");
		$groups = $db->loadObjectList();

		if(count($groups) > 0){
			for($i=0;$i<count($groups);$i++){
				$group = $groups[$i];

                $access_sql = ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
				$db->setQuery("Select * from #__osrs_extra_fields where published = '1' and group_id = '$group->id' $access_sql order by ordering");
				$fields = $db->loadObjectList();
				
				
				$groups[$i]->fields = $fields;
			}
		}
		
		while (@ob_end_clean());
		ob_start();
		HTML_OspropertyListing::printPropertyPdf($option,$row,$lists,$amenities,$amenitylists,$groups);
		$body = ob_get_contents();
		ob_clean();
		//echo $body;
		//die();
		jimport('joomla.filesystem.folder');
		if(($configClass['pdf_lib'] == 2) and (JFolder::exists(JPATH_COMPONENT.DS."helpers".DS."npdf"))){
			require_once(JPATH_COMPONENT.DS."helpers".DS."npdf".DS."html2pdf.class.php");
			$html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8');
			//$html2pdf->setDefaultFont('dejavusans'); //add this line
			//$html2pdf->addFont('Times','',JPATH_COMPONENT.'/helpers/npdf/_tcpdf_5.0.002/fonts/times.php');
			//$html2pdf->setDefaultFont('javiergb');
	        $html2pdf->writeHTML($body);
	        $html2pdf->Output($filename);
			exit();
		}else{
			require_once(JPATH_COMPONENT.DS."helpers".DS."pdf".DS."html2fpdf.php");
			$pdf=new HTML2FPDF();
			$pdf->AddPage();
			$pdf->WriteHTML($body);
			$pdf->Output($pdf_root.DS.$filename);
			//update completed, download it
			HelperOspropertyCommon::downloadfile($filename);
			exit();
		}
	}
	
	static function generateCaptcha($option){
		global $mainframe;
		while (@ob_end_clean());
		$ResultStr = OSPHelper::getStringRequest('ResultStr','','');
		$NewImage =imagecreatefromjpeg(JPATH_ROOT.DS."components".DS."com_osproperty".DS."captcha".DS."img.jpg");//image create by existing image and as back ground 
		$LineColor = imagecolorallocate($NewImage,233,239,239);//line color 
		$TextColor = imagecolorallocate($NewImage, 58, 43, 149);//text color-white
		imageline($NewImage,1,1,40,40,$LineColor);//create line 1 on image 
		imageline($NewImage,1,100,60,0,$LineColor);//create line 2 on image 
		imagestring($NewImage, 5, 20, 10, $ResultStr, $TextColor);// Draw a random string horizontally 
		header("Content-type: image/jpeg");// out out the image 
		imagejpeg($NewImage);//Output image to browser 
		exit();
	}
	
	/**
	 * Approval details
	 *
	 * @param unknown_type $option
	 */
	static function approvalDetails($option,$id){
		global $mainframe;
		$db = JFactory::getDbo();
		$db->setQuery("Select * from #__osrs_properties where id = '$id'");
		$property = $db->loadObject();
		$db->setQuery("Select * from #__osrs_expired where id = '$id'");
		$expired = $db->loadObject();
		
		HTML_OspropertyListing::approvalDetails($option,$property,$expired);
	}
	
	/**
	 * Unfeatured
	 *
	 * @param unknown_type $id
	 */
	function unFeatured($id){
		global $mainframe;
		$db = JFactory::getDbo();
		$db->setQuery("Update #__osrs_properties set isFeatured = '0' where id = '$id'");
		$db->query();
	}
	
	/**
	 * Un approved
	 *
	 * @param unknown_type $id
	 */
	function unApproved($id){
		global $mainframe;
		$db = JFactory::getDbo();
		$db->setQuery("Update #__osrs_properties set approved = '0' where id = '$id'");
		$db->query();
	}
	
	
	/**
	 * Request approval
	 * Confirm page
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 */
	function requestApproval($option,$cid){
		global $mainframe,$configClass;
		$db = JFactory::getDbo();
		$document = JFactory::getDocument();
		$document->setTitle($configClass['general_bussiness_name']." - ".JText::_('OS_REQUEST_APPROVAL'));
		if(count($cid) == 0){
			?>
			<script language="javascript">
			history.go(-1);
			</script>
			<?php
		}else{
			$rows = array();
			for($i=0;$i<count($cid);$i++){
				$id = $cid[$i];
				$db->setQuery("Select * from #__osrs_properties where id = '$id'");
				$property = $db->loadObject();
				if(($property->isNew == 0) and ($property->approved == 0)){
					$rows[$i]->id = $property->id;
					$rows[$i]->property = $property->pro_name;
				}
			}
			if(count($rows) == 0){
				?>
				<script language="javascript">
				history.go(-1);
				</script>
				<?php
			}
			HTML_OspropertyListing::confirmApproval($option,$rows);
		}
	}
	
	/**
	 * Process request approval
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 */
	function processRequestApproval($option,$cid){
		global $mainframe,$configClass;
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$cids = implode(",",$cid);
        $emailOpt = array();
		if($configClass['general_approval'] == 1){
			$db->setQuery("Update #__osrs_properties set approved = '1',published = '1' where id in ($cids)");
			$db->query();
			for($i=0;$i<count($cid);$i++){
				OspropertyListing::setexpired($option,$cid[$i]);
			}
			$needs = array();
			$needs[] = "agent_editprofile";
			$needs[] = "agent_default";
			$needs[] = "lagents";
			$itemid = OSPRoute::getItemid($needs);
			$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=agent_default&Itemid=".$itemid),JText::_('OS_PROPERTIES_HAVE_BEEN_APPROVED'));
		}else{
			$db->setQuery("Update #__osrs_properties set request_to_approval = '1' where id in ($cids)");
			$db->query();
			
			//send email to admin to inform
			$db->setQuery("Select * from #__osrs_agents where user_id = '$user->id'");
			$agent = $db->loadObject();
			
			$emailOpt[0]->customer = $agent->name;
			$db->setQuery("Select id,pro_name from #__osrs_properties where id  in ($cids)");
			$rows = $db->loadObjectList();
			$proArr = array();
			for($i=0;$i<count($rows);$i++){
				$proArr[$i] = $rows[$i]->pro_name;
			}
			$pro_name = implode(",",$proArr);
			$emailOpt[0]->property = $pro_name;
			OspropertyEmail::sendPropertyApprovalRequest($option,$emailOpt);
			$needs[] = "agent_editprofile";
			$needs[] = "agent_default";
			$needs[] = "lagents";
			$itemid = OSPRoute::getItemid($needs);
			$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=agent_default&Itemid=".$itemid),JText::_('OS_REQUEST_HAVE_BEEN_SENT_TO_ADMINISTRATOR'));
		}
		
	}
	
	
	/**
	 * Updade properties
	 *
	 * @param unknown_type $cid
	 */
	function upgradeProperties($cid){
		global $mainframe;
		$configClass = OSPHelper::loadConfig();
		$db = JFactory::getDbo();
		//$db->setQuery("select * from #__osrs_configuration");
		//$configs = $db->loadObjectList();
		$time_amount = $configClass['general_time_in_days_featured'];//$configs[16]->fieldvalue;
		if(count($cid) > 0){
			for($i=0;$i<count($cid);$i++){
				$id = $cid[$i];
				//update approved, published, approved
				$db->setQuery("Update #__osrs_properties set isFeatured = '1',approved = '1',published = '1' where id = '$id'");
				$db->query();
				//calculate the expired feature time
				$current_time = time();
				$expired_time = $current_time + $time_amount*3600*24;
				$expired_time = date("Y-m-d H:i:s",$expired_time);
				//update into expired table
				$db->setQuery("Select count(id) from #__osrs_expired where pid = '$id'");
				$count = $db->loadResult();
				if($count == 0){
					self::setexpiredInPayment($id);
				}
				
				$db->setQuery("select count(id) from #__osrs_expired where pid = '$id'");
				$countItem = $db->loadResult();
				if($countItem == 0){
					$db->setQuery("INSERT INTO #__osrs_expired (id,expired_feature_time,pid) values (NULL,'$expired_time','$id')");
					$db->query();
				}else{
					$db->setQuery("Update #__osrs_expired set expired_feature_time = '$expired_time' where pid = '$id'");
					$db->query();
				}
			}
		}
	}
	
	/**
	 * After customer complete the payment, the system must auto set expired the time. 
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	public static function setexpiredInPayment($id){
		global $mainframe,$configs,$configClass;
		$db = JFactory::getDbo();
		$current_time 	 = HelperOspropertyCommon::getRealTime();
		$db->setQuery("Select count(id) from #__osrs_expired where pid = '$id'");
		$count = $db->loadResult();
		$use_expired = $configClass['general_use_expiration_management'];
		if($use_expired == 1){
			if($count == 0){
				//$general_approval = $configs[12]->fieldvalue;
				//check and calculate the expired and clean db time
				$unpublish_time  = intval($configClass['general_time_in_days']);
				$remove_time	 = intval($configClass['general_unpublished_days']);
				$feature_time    = intval($configClass['general_time_in_days_featured']);
				$send_appro	     = $configClass['send_approximates'];
				$appro_days		 = $configClass['approximates_days'];
				
				
				$unpublish_time  = $current_time + $unpublish_time*24*3600;
				$feature_time    = $current_time + $feature_time*24*3600;
				$remove_time     = $unpublish_time + $remove_time*24*3600;
				//allow to send the approximates expired day
				if($send_appro == 1){
					$inform_time = $unpublish_time - $appro_days*24*3600;
					$inform_time = date("Y-m-d H:i:s",$inform_time);
				}else{
					$inform_time = "";
				}
				$unpublish_time	 = date("Y-m-d H:i:s",$unpublish_time);
				$remove_time	 = date("Y-m-d H:i:s",$remove_time);
				$feature_time	 = date("Y-m-d H:i:s",$feature_time);
				//insert into #__osrs_expired
				$db->setQuery("Insert into #__osrs_expired (id,pid,inform_time,expired_time,expired_feature_time,remove_from_database) values (NULL,$id,'$inform_time','$unpublish_time','$feature_time','$remove_time')");
				$db->query();
				//update start publishing today
				OspropertyListing::updateStartPublishing($id);
			}else{
				//$general_approval = $configs[12]->fieldvalue;
				//check and calculate the expired and clean db time
				$db->setQuery("Select * from #__osrs_expired where pid = '$id'");
				$row = $db->loadObject();
				$expired_time    = $row->expired_time;
				$unpublish_time  = strtotime($expired_time);
				
				
				$remove_time	 = intval($configClass['general_unpublished_days']);
				$feature_time    = intval($configClass['general_time_in_days_featured']);
				$send_appro	     = $configClass['send_approximates'];
				$appro_days		 = $configClass['approximates_days'];
				
				$current_time 	 = time();
				$feature_time    = $current_time + $feature_time*24*3600;
				if($current_time > $unpublish_time){
					$new = 1;
					$unpublish_time = intval($configClass['general_time_in_days']);
					$unpublish_time  = $current_time + $unpublish_time*24*3600;
				}else{
					$new = 0;
					if($feature_time > $unpublish_time){
						$unpublish_time = $feature_time;
					}
				}
				$remove_time     = $unpublish_time + $remove_time*24*3600;
				$remove_time	 = date("Y-m-d H:i:s",$remove_time);
				//allow to send the approximates expired day
				if($send_appro == 1){
					$inform_time = $unpublish_time - $appro_days*24*3600;
					$inform_time = date("Y-m-d H:i:s",$inform_time);
				}else{
					$inform_time = "";
				}
				$unpublish_time	 = date("Y-m-d H:i:s",$unpublish_time);
				$feature_time	 = date("Y-m-d H:i:s",$feature_time);
				//insert into #__osrs_expired
				$db->setQuery("UPDATE #__osrs_expired SET inform_time = '$inform_time',expired_time='$unpublish_time',expired_feature_time= '$feature_time',remove_from_database='$remove_time' WHERE pid = '$id'");
				$db->query();
				
				//update start publishing today
				$db->setQuery("Select publish_up from #__osrs_properties where id = '$id'");
				$publish_up = $db->loadResult();
				if(($publish_up == "0000-00-00") or ($new == 1)){
					OspropertyListing::updateStartPublishing($id);
				}
			}
		}
	}
	
	/**
	 * Set expired time for properties
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	function setexpired($option,$id){
		global $mainframe,$configs,$configClass;
		$db = JFactory::getDbo();
		$db->setQuery("Select count(id) from #__osrs_expired where pid = '$id'");
		$count = $db->loadResult();
		$current_time 	= HelperOspropertyCommon::getRealTime();
		$use_expired = $configClass['general_use_expiration_management'];
		if($use_expired == 1){
			if($count == 0){
				//check and calculate the expired and clean db time
				$unpublish_time = intval($configClass['general_time_in_days']);
				$remove_time	= intval($configClass['general_unpublished_days']);
				$send_appro		= $configClass['send_approximates'];
				$appro_days		= $configClass['approximates_days'];
				
				$unpublish_time = $current_time + $unpublish_time*24*3600;
				//calculate remove time
				$remove_time    = $unpublish_time + $remove_time*24*3600;
				//allow to send the approximates expired day
				if($send_appro == 1){
					$inform_time = $unpublish_time - $appro_days*24*3600;
					$inform_time = date("Y-m-d H:i:s",$inform_time);
				}else{
					$inform_time = "";
				}
				//change to time stamp
				$unpublish_time	= date("Y-m-d H:i:s",$unpublish_time);
				$remove_time	= date("Y-m-d H:i:s",$remove_time);
				//insert into #__osrs_expired
				$db->setQuery("Insert into #__osrs_expired (id,pid,inform_time,expired_time,remove_from_database) values (NULL,$id,'$inform_time','$unpublish_time','$remove_time')");
				$db->query();
				//update start publishing today
				OspropertyListing::updateStartPublishing($id);
				
			}else{//in the case this property is already in the expired table
				//check and calculate the expired and clean db time
				$unpublish_time = intval($configClass['general_time_in_days']);
				$remove_time	= intval($configClass['general_unpublished_days']);
				$send_appro		= $configClass['send_approximates'];
				$appro_days		= $configClass['approximates_days'];
				
				$current_time 	= time();
				$unpublish_time = $current_time + $unpublish_time*24*3600;
				//calculate remove time
				$remove_time    = $unpublish_time + $remove_time*24*3600;
				//allow to send the approximates expired day
				if($send_appro == 1){
					$inform_time = $unpublish_time - $appro_days*24*3600;
					$inform_time = date("Y-m-d H:i:s",$inform_time);
				}else{
					$inform_time = "";
				}
				//change to time stamp
				$unpublish_time	= date("Y-m-d H:i:s",$unpublish_time);
				$remove_time	= date("Y-m-d H:i:s",$remove_time);
				//insert into #__osrs_expired
				$db->setQuery("UPDATE #__osrs_expired SET inform_time = '$inform_time',expired_time='$unpublish_time',remove_from_database='$remove_time' WHERE pid = '$id'");
				$db->query();
				//update start publishing today
				OspropertyListing::updateStartPublishing($id);
			}
		}
	}
	
	/**
	 * Update start publishing
	 *
	 * @param unknown_type $id
	 */
	function updateStartPublishing($id){
		global $mainframe;
		$db = JFactory::getDbo();
		$time = date("Y-m-d",time());
		$db->setQuery("Update #__osrs_properties set publish_up = '$time' where id = '$id'");
		$db->query();
	}
	
	
	/**
	 * Search function for ajax search module.
	 *
	 * @param unknown_type $option
	 */
	static function search($option){
		global $mainframe,$configClass,$languages,$lang_suffix,$jinput;
		$db = JFactory::getDBO();
        $ordering = $jinput->getString('ordering','category');
        $show_introtext = $jinput->getInt('show_introtext',1);
        $show_address = $jinput->getInt('show_address',1);
        $show_cost = $jinput->getInt('show_cost',1);
        $show_agent = $jinput->getInt('show_agent',1);
        $orderby = $jinput->getString('orderby','listdate');
        $ordertype = $jinput->getString('ordertype','');
        $search_name = $jinput->getInt('search_name',1);
        $search_address = $jinput->getInt('search_address',1);
        $search_agent = $jinput->getInt('search_agent',1);
        $search_desc = $jinput->getInt('search_desc',1);
        $keyword = OSPHelper::getStringRequest('search_exp','','');
		$keyword = $db->escape($keyword);
		$results = array();
		//if keyword is not null. Do search
		if ($keyword != ""){
			if(!function_exists('json_decode'))
			{
			    function json_decode($json)
			    {
			        $comment = false;
			        $out = '$x=';
			        for ($i=0; $i<strlen($json); $i++)
			        {
			            if (!$comment)
			            {
			                if (($json[$i] == '{') || ($json[$i] == '['))
			                    $out .= ' array(';
			                else if (($json[$i] == '}') || ($json[$i] == ']'))
			                    $out .= ')';
			                else if ($json[$i] == ':')
			                    $out .= '=>';
			                else
			                    $out .= $json[$i];
			            }
			            else
			                $out .= $json[$i];
			            if ($json[$i] == '"' && $json[($i-1)]!="\\")
			                $comment = !$comment;
			        }
			        eval($out . ';');
			        return $x;
			    }
			}
			if (!function_exists('json_encode'))
			{
				  function json_encode($a=false){
				  		global $mainframe;
					    if (is_null($a)) return 'null';
					    if ($a === false) return 'false';
					    if ($a === true) return 'true';
					    if (is_scalar($a)){
					        if (is_float($a)){
						        // Always use "." for floats.
						        return floatval(str_replace(",", ".", strval($a)));
					        }
					        if (is_string($a)){
					        	static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
					       		return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
					        }else{
					        	return $a;
					        }
					    }
					    $isList = true;
					    for ($i = 0, reset($a); $i < count($a); $i++, next($a)){
						      if (key($a) !== $i)
						      {
							        $isList = false;
							        break;
						      }
					    }
					    $result = array();
					    if ($isList){
						      foreach ($a as $v) $result[] = json_encode($v);
						      return '[' . join(',', $result) . ']';
					    }else{
						      foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
						      return '{' . join(',', $result) . '}';
					    }
				   }
			 }
		
			 ob_end_clean();
			 
			 //$db->setQuery("select * from #__osrs_configuration");
			// $configs = $db->loadObjectList();
			 
			 switch ($ordering){
			 	
			 	case "category": //category
			 		$db->setQuery("Select * from #__osrs_categories where published = '1' order by ordering");
			 		$categories = $db->loadObjectList();
			 		if(count($categories) > 0){
			 			for($i=0;$i<count($categories);$i++){
			 				$category = $categories[$i];
			 				$category_name = OSPHelper::getLanguageFieldValue($category,'category_name');
			 				$query = "Select a.*,c.name as agent_name,d.country_name,e.state_name from #__osrs_properties as a"
			 						." inner join #__osrs_agents as c on c.id = a.agent_id"
			 						." inner join #__osrs_countries as d on d.id = a.country"
			 						." inner join #__osrs_states as e on e.id = a.state"
									." inner join #__osrs_cities as g on g.id = a.city"
			 						." where a.approved = '1' and a.published = '1' and a.category_id = '$category->id' and (";
			 				//
			 				$query1 = array();
			 				if($search_name == 1){
			 					$query1[] = " a.pro_name$lang_suffix like '%$keyword%'";
			 					$query1[] = " a.ref like '%$keyword%'";
			 				}
			 				if($search_address == 1){
			 					$query1[] = " a.address like '%$keyword%' or a.region like '%$keyword%' or a.postcode like '%$keyword%' or d.country_name like '%$keyword%' or e.state_name like '%$keyword%' or g.city like '%$keyword%'";
			 				}
			 				
			 				if($search_desc == 1){
			 					$query1[] = " a.pro_small_desc$lang_suffix like '%$keyword%' or a.pro_full_desc$lang_suffix like '%$keyword%'";
			 				}
			 				
			 				if($search_agent == 1){
			 					$query1[] = " c.name like '%$keyword%'";
			 				}
			 				
			 				$query1a = implode(" or ",$query1);
			 				$query .= $query1a." )";
			 				
			 				switch ($orderby){
			 					case "pro_name":
			 						$query .= " order by a.pro_name$lang_suffix ".$ordertype;
			 					break;
			 					case "price":
			 						$query .= " order by a.price ".$ordertype;
			 					break;
			 					case "listdate":
			 						$query .= " order by a.created ".$ordertype;
			 					break;
			 				}
			 				
			 				$db->setQuery($query);
			 				
			 				$rows = $db->loadObjectList();
			 				
			 				if(count($rows) > 0){
			 					//echo $db->getQuery();
				  	  	  	   //add categories into array
				  	  	  	   for($j=0;$j<count($rows);$j++){
				  	  	  	   		
				  	  	  	   		$row = $rows[$j];
				  	  	  	   		$needs = array();
                                    $needs[] = "property_details";
                                    $needs[] = $row->id;
                                    $itemid = OSPRoute::getItemid($needs);

				  	  	  	   		$pro_name = OSPHelper::getLanguageFieldValue($row,'pro_name');
				  	  	  	   		$row->pro_name = $pro_name;
				  	  	  	   		
				  	  	  	   		$db->setQuery("Select image from #__osrs_photos where pro_id = '$row->id'");
				  	  	  	   		$image = $db->loadResult();
				  	  	  	   		if($image != ""){
				  	  	  	   			//having thumbnail image
				  	  	  	   			if(file_exists(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$row->id.DS."thumb".DS.$image)){
				  	  	  	   				$results[$category_name][$j]->pimage = "<img src='".JURI::root()."images/osproperty/properties/".$row->id."/thumb/".$image."' height='60' width='60' border='0'>"; 
				  	  	  	   			}else{
				  	  	  	   				$results[$category_name][$j]->pimage = "<img src='".JURI::root()."components/com_osproperty/images/assets/noimage64.png' height='60' width='60' border='0'>"; 
				  	  	  	   			}
				  	  	  	   		}else{
				  	  	  	   			$results[$category_name][$j]->pimage = "<img src='".JURI::root()."components/com_osproperty/images/assets/noimage64.png' height='60' width='60' border='0'>"; 
				  	  	  	   		}
				  	  	  	   		$title = "";
				  	  	  	   		if($rows[$j]->ref  != ""){
				  	  	  	   			$title .= $rows[$j]->ref.", ";
				  	  	  	   		}
				  	  	  	   		$title .= $rows[$j]->pro_name;
				  	  	  	   		$results[$category_name][$j]->title = $title;
				  	  	  	   		//text here
				  	  	  	   		$text = "";
				  	  	  	   		
				  	  	  	   		if($show_cost == 1){
				  	  	  	   			$text .= "(".JText::_('OS_COST')." : ";
				  	  	  	   			if($row->price_call == 1){
				  	  	  	   				$text.= JText::_('OS_CALL_FOR_PRICE');
				  	  	  	   			}else{
				  	  	  	   				$text.= HelperOspropertyCommon::loadCurrency($row->curr)." ".HelperOspropertyCommon::showPrice($row->price);
				  	  	  	   				if($row->rent_time != ""){
				  	  	  	   					$text .= " / ".JText::_($row->rent_time);
				  	  	  	   				}
				  	  	  	   			}
				  	  	  	   			$text .= ")  ";
				  	  	  	   		}
				  	  	  	   		if($show_address == 1){
				  	  	  	   			$text .= $row->address.", ".HelperOspropertyCommon::loadCityName($row->city).", ";
				  	  	  	   			$text .= $row->state_name.", ".$row->country_name;
				  	  	  	   		}
				  	  	  	   		if ($show_introtext == 1){
				                        $text .= strip_tags(stripslashes($row->pro_small_desc));
				                    }
				                    if ($show_agent == 1){
				                    	$text .= ". ".JText::_('OS_AGENT').": ".strip_tags(stripslashes($row->agent_name));
				                    }
				  	  	  	   		$results[$category_name][$j]->text  = $text;
				  	  	  	   		$results[$category_name][$j]->href  = JRoute::_("index.php?option=com_osproperty&task=property_details&id=$row->id&Itemid=".$itemid);
				  	  	  	   }
				  	  	    }
			 			}
			 		}
			 	break;
			 	case "type": //category
			 		$db->setQuery("Select * from #__osrs_types where published = '1'");
			 		$categories = $db->loadObjectList();
			 		if(count($categories) > 0){
			 			for($i=0;$i<count($categories);$i++){
			 				$category = $categories[$i];
			 				$type_name = OSPHelper::getLanguageFieldValue($category,'type_name');
			 				$query = "Select a.*,c.name as agent_name,d.country_name,e.state_name from #__osrs_properties as a"
			 						." inner join #__osrs_agents as c on c.id = a.agent_id"
			 						." inner join #__osrs_countries as d on d.id = a.country"
			 						." inner join #__osrs_states as e on e.id = a.state"
									." inner join #__osrs_cities as g on g.id = a.city"
			 						." where a.approved = '1' and a.published = '1' and a.pro_type = '$category->id' and (";
			 				//
			 				$query1 = array();
			 				if($search_name == 1){
			 					$query1[] = " a.pro_name$lang_suffix like '%$keyword%'";
			 					$query1[] = " a.ref like '%$keyword%'";
			 				}
			 				if($search_address == 1){
			 					$query1[] = " a.address like '%$keyword%' or a.region like '%$keyword%' or a.postcode like '%$keyword%' or d.country_name like '%$keyword%' or e.state_name like '%$keyword%' or g.city like '%$keyword%'";
			 				}
			 				
			 				if($search_desc == 1){
			 					$query1[] = " a.pro_small_desc$lang_suffix like '%$keyword%' or a.pro_full_desc$lang_suffix like '%$keyword%'";
			 				}
			 				
			 				if($search_agent == 1){
			 					$query1[] = " c.name like '%$keyword%'";
			 				}
			 				
			 				$query1a = implode(" or ",$query1);
			 				$query .= $query1a." )";
			 				
			 				switch ($orderby){
			 					case "pro_name":
			 						$query .= " order by a.pro_name ".$ordertype;
			 					break;
			 					case "price":
			 						$query .= " order by a.price ".$ordertype;
			 					break;
			 					case "listdate":
			 						$query .= " order by a.created ".$ordertype;
			 					break;
			 				}
			 				
			 				$db->setQuery($query);
			 				$rows = $db->loadObjectList();
			 				
			 				if(count($rows) > 0){
			 					//echo $db->getQuery();
				  	  	  	   //add categories into array
				  	  	  	   for($j=0;$j<count($rows);$j++){
				  	  	  	   		
				  	  	  	   		$row = $rows[$j];
                                    $needs = array();
                                    $needs[] = "property_details";
                                    $needs[] = $row->id;
                                    $itemid = OSPRoute::getItemid($needs);
				  	  	  	   		$pro_name = OSPHelper::getLanguageFieldValue($row,'pro_name');
				  	  	  	   		$row->pro_name = $pro_name;
				  	  	  	   		
				  	  	  	   		$db->setQuery("Select image from #__osrs_photos where pro_id = '$row->id'");
				  	  	  	   		$image = $db->loadResult();
				  	  	  	   		if($image != ""){
				  	  	  	   			//having thumbnail image
				  	  	  	   			if(file_exists(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$row->id.DS."thumb".DS.$image)){
				  	  	  	   				$results[$type_name][$j]->pimage = "<img src='".JURI::root()."images/osproperty/properties/".$row->id."/thumb/".$image."' height='60' width='60' border='0'>"; 
				  	  	  	   			}else{
				  	  	  	   				$results[$type_name][$j]->pimage = "<img src='".JURI::root()."components/com_osproperty/images/assets/noimage64.png' height='60' width='60' border='0'>"; 
				  	  	  	   			}
				  	  	  	   		}else{
				  	  	  	   			$results[$type_name][$j]->pimage = "<img src='".JURI::root()."components/com_osproperty/images/assets/noimage64.png' height='60' width='60' border='0'>"; 
				  	  	  	   		}
				  	  	  	   		$title = "";
				  	  	  	   		if($rows[$j]->ref  != ""){
				  	  	  	   			$title .= $rows[$j]->ref.", ";
				  	  	  	   		}
				  	  	  	   		$title .= $rows[$j]->pro_name;
				  	  	  	   		$results[$type_name][$j]->title = $title;
				  	  	  	   		//text here
				  	  	  	   		$text = "";
				  	  	  	   		
				  	  	  	   		if($show_cost == 1){
				  	  	  	   			$text .= "(".JText::_('OS_COST')." : ";
				  	  	  	   			if($row->price_call == 1){
				  	  	  	   				$text.= JText::_('OS_CALL_FOR_PRICE');
				  	  	  	   			}else{
				  	  	  	   				$text.= HelperOspropertyCommon::loadCurrency($row->curr)." ".HelperOspropertyCommon::showPrice($row->price);
				  	  	  	   			}
				  	  	  	   			$text .= ")  ";
				  	  	  	   		}
				  	  	  	   		if($show_address == 1){
				  	  	  	   			$text .= $row->address.", ".HelperOspropertyCommon::loadCityName($row->city).", ";
				  	  	  	   			//$text .= "<BR />";
				  	  	  	   			$text .= $row->state_name.", ".$row->country_name;
				  	  	  	   		}
				  	  	  	   		if ($show_introtext == 1){
				                        $text .= strip_tags(stripslashes($row->pro_small_desc));
				                    }
				                    if ($show_agent == 1){
				                    	$text .= ". ".JText::_('OS_AGENT').": ".strip_tags(stripslashes($row->agent_name));
				                    }
				  	  	  	   		$results[$type_name][$j]->text  = $text;
				  	  	  	   		$results[$type_name][$j]->href  = JRoute::_("index.php?option=com_osproperty&task=property_details&id=$row->id&Itemid=".$itemid);
				  	  	  	   }
				  	  	    }
			 			}
			 		}
			 	break;
			 	case "country": //category
			 		$db->setQuery("Select * from #__osrs_countries");
			 		$categories = $db->loadObjectList();
			 		if(count($categories) > 0){
			 			for($i=0;$i<count($categories);$i++){
			 				$category = $categories[$i];
			 				$query = "Select a.*,c.name as agent_name,d.country_name,e.state_name from #__osrs_properties as a"
			 						." inner join #__osrs_agents as c on c.id = a.agent_id"
			 						." inner join #__osrs_countries as d on d.id = a.country"
			 						." inner join #__osrs_states as e on e.id = a.state"
									." inner join #__osrs_cities as g on g.id = a.city"
			 						." where a.approved = '1' and a.published = '1' and a.country = '$category->id' and (";
			 				//
			 				$query1 = array();
			 				if($search_name == 1){
			 					$query1[] = " a.pro_name$lang_suffix like '%$keyword%'";
			 					$query1[] = " a.ref like '%$keyword%'";
			 				}
			 				if($search_address == 1){
			 					$query1[] = " a.address like '%$keyword%' or a.region like '%$keyword%' or a.postcode like '%$keyword%' or d.country_name like '%$keyword%' or e.state_name like '%$keyword%' or g.city like '%$keyword%'";
			 				}
			 				
			 				if($search_desc == 1){
			 					$query1[] = " a.pro_small_desc$lang_suffix like '%$keyword%' or a.pro_full_desc$lang_suffix like '%$keyword%'";
			 				}
			 				
			 				if($search_agent == 1){
			 					$query1[] = " c.name like '%$keyword%'";
			 				}
			 				
			 				$query1a = implode(" or ",$query1);
			 				$query .= $query1a." )";
			 				
			 				switch ($orderby){
			 					case "pro_name":
			 						$query .= " order by a.pro_name ".$ordertype;
			 					break;
			 					case "price":
			 						$query .= " order by a.price ".$ordertype;
			 					break;
			 					case "listdate":
			 						$query .= " order by a.created ".$ordertype;
			 					break;
			 				}
			 				
			 				$db->setQuery($query);
			 				
			 				$rows = $db->loadObjectList();
			 				
			 				if(count($rows) > 0){
			 					//echo $db->getQuery();
				  	  	  	   //add categories into array
				  	  	  	   for($j=0;$j<count($rows);$j++){
				  	  	  	   		
				  	  	  	   		$row = $rows[$j];
                                    $needs = array();
                                    $needs[] = "property_details";
                                    $needs[] = $row->id;
                                    $itemid = OSPRoute::getItemid($needs);
				  	  	  	   		$pro_name = OSPHelper::getLanguageFieldValue($row,'pro_name');
				  	  	  	   		$row->pro_name = $pro_name;
				  	  	  	   		
				  	  	  	   		$db->setQuery("Select image from #__osrs_photos where pro_id = '$row->id'");
				  	  	  	   		$image = $db->loadResult();
				  	  	  	   		if($image != ""){
				  	  	  	   			//having thumbnail image
				  	  	  	   			if(file_exists(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS.$row->id.DS."thumb".DS.$image)){
				  	  	  	   				$results[$category->country_name][$j]->pimage = "<img src='".JURI::root()."images/osproperty/properties/".$row->id."/thumb/".$image."' height='60' width='60' border='0'>"; 
				  	  	  	   			}else{
				  	  	  	   				$results[$category->country_name][$j]->pimage = "<img src='".JURI::root()."components/com_osproperty/images/assets/noimage64.png' height='60' width='60' border='0'>"; 
				  	  	  	   			}
				  	  	  	   		}else{
				  	  	  	   			$results[$category->country_name][$j]->pimage = "<img src='".JURI::root()."components/com_osproperty/images/assets/noimage64.png' height='60' width='60' border='0'>"; 
				  	  	  	   		}
				  	  	  	   		$title = "";
				  	  	  	   		if($rows[$j]->ref  != ""){
				  	  	  	   			$title .= $rows[$j]->ref.", ";
				  	  	  	   		}
				  	  	  	   		$title .= $rows[$j]->pro_name;
				  	  	  	   		$results[$category->country_name][$j]->title = $title;
				  	  	  	   		//text here
				  	  	  	   		$text = "";
				  	  	  	   		
				  	  	  	   		if($show_cost == 1){
				  	  	  	   			$text .= "(".JText::_('OS_COST')." : ";
				  	  	  	   			if($row->price_call == 1){
				  	  	  	   				$text.= JText::_('OS_CALL_FOR_PRICE');
				  	  	  	   			}else{
				  	  	  	   				$text.= HelperOspropertyCommon::showPrice($row->price)." ".$configClass['general_currency_default'];
				  	  	  	   			}
				  	  	  	   			$text .= ")  ";
				  	  	  	   		}
				  	  	  	   		if($show_address == 1){
				  	  	  	   			$text .= $row->address.", ".HelperOspropertyCommon::loadCityName($row->city).", ";
				  	  	  	   			$text .= $row->state_name.", ".$row->country_name;
				  	  	  	   		}
				  	  	  	   		if ($show_introtext == 1){
				                        $text .= strip_tags(stripslashes($row->pro_small_desc));
				                    }
				                    if ($show_agent == 1){
				                    	$text .= ". ".JText::_('OS_AGENT').": ".strip_tags(stripslashes($row->agent_name));
				                    }
				  	  	  	   		$results[$category->country_name][$j]->text  = $text;
				  	  	  	   		$results[$category->country_name][$j]->href  = JRoute::_("index.php?option=com_osproperty&task=property_details&id=$row->id&Itemid=".$itemid);
				  	  	  	   }
				  	  	    }
			 			}
			 		}
			 	break;
			 }
		 	 
		  	 print_r(json_encode($results));
		}
	}
	
	function resetData(){
		global $mainframe;
		$db = JFactory::getDbo();
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.archive');
		jimport('joomla.filesystem.folder');
		
		$db->setQuery("Select runtime from #__osrs_resetdemo");
		$runtime = $db->loadResult();
		$runtime = intval($runtime);
		
		if($runtime < time() - 4*3600){
			if(JFile::exists(JPATH_ROOT.DS."sample.sql")){
				$sql = JFile::read(JPATH_ROOT.DS."sample.sql") ;
				$queries = $db->splitSql($sql);
				if (count($queries)) {
					foreach ($queries as $query) {
					$query = trim($query);
					if ($query != '' && $query{0} != '#') {
							$db->setQuery($query);
							$db->query();						
						}	
					}
				}
			}
			
			if(JFile::exists(JPATH_ROOT.DS."osproperty.zip")){
				JFolder::delete(JPATH_ROOT.DS."images".DS."osproperty");
				JArchive::extract(JPATH_ROOT.DS."osproperty.zip",JPATH_ROOT.DS."images");
			}
			$db->setQuery("Update #__osrs_resetdemo set runtime = '".time()."'");
			$db->query();
		}
	}
	
	/**
	 * Delete properties
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 */                      
	function deleteProperties($option,$cid,$type=0){
		global $mainframe;
		$db = JFactory::getDBO();
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		if(count($cid) > 0){
			//only check if type = 1
			if($type == 0){
				foreach ($cid as $id){
					if(!HelperOspropertyCommon::isOwner($id)){
						JError::raiseError( 500, JText::_('OS_YOU_HAVE_NOT_GOT_PERMISSION_GO_TO_THIS_AREA') );
					}
				}
			}
            //remove attachment
            foreach($cid as $pid){
                $db->setQuery("Select pro_pdf_file from #__osrs_properties where id = '$pid'");
                $pro_pdf_file = $db->loadResult();
                if($pro_pdf_file != ""){
                    if(JFile::exists(JPATH_ROOT.'/components/com_osproperty/document/'.$pro_pdf_file)){
                        JFile::delete(JPATH_ROOT.'/components/com_osproperty/document/'.$pro_pdf_file);
                    }
                }
				JFolder::delete(JPATH_ROOT.'/images/osproperty/properties/'.$pid);
            }
			
			
			$cids = implode(",",$cid);
            //remove properties in property category relation
            $db->setQuery("Delete from #__osrs_property_categories where pid in ($cids)");
            $db->query();
			//remove from properties table
			$db->setQuery("Delete from #__osrs_properties where id in ($cids)");
			$db->query();
			//remove from amenities table
			$db->setQuery("Delete from #__osrs_property_amenities where pro_id in ($cids)");
			$db->query();
			//remove from extra field table
			$db->setQuery("Delete from #__osrs_property_field_value where pro_id in ($cids)");
			$db->query();
			//remove from expired table
			$db->setQuery("Delete from #__osrs_expired where pid in ($cids)");
			$db->query();
			//remove from queue table
			$db->setQuery("Delete from #__osrs_queue where pid in ($cids)");
			$db->query();
            //remove from neighborhood table
            $db->setQuery("Delete from #__osrs_neighborhood where pid in ($cids)");
            $db->query();
            //remove from #__osrs_property_field_opt_value
            $db->setQuery("Delete from #__osrs_property_field_opt_value where pid in ($cids)");
            $db->query();
            //remove from tag xref
            $db->setQuery("Delete from #__osrs_tag_xref where pid in ($cids)");
            $db->query();			
			$db->setQuery("Delete from #__osrs_photos where pro_id in ($cids)");
			$db->query();
		}
		if($type == 0){
			$needs = array();
			$needs[] = "agent_editprofile";
			$needs[] = "agent_default";
			$needs[] = "aeditdetails";
			$itemid = OSPRoute::getItemid($needs);
			$mainframe->redirect(JRoute::_("index.php?option=com_osproperty&task=agent_editprofile&Itemid=".$itemid),JText::_('OS_PROPERTIES_HAVE_BEEN_REMOVED'));
		}else{
			$needs = array();
			$needs[] = "lmanageproperties";
			$needs[] = "property_manageallproperties";
			$itemid  = OSPRoute::getItemid($needs);
			$mainframe->redirect(JRoute::_('index.php?option=com_osproperty&task=property_manageallproperties&Itemid='.$itemid),JText::_('OS_PROPERTY_STATUS_HAS_BEEN_CHANGED'));
		}
	}
	
	function exportRSS(){
		global $mainframe,$configClass,$jinput;
		jimport( 'joomla.document.feed.feed' );
		$db = JFactory::getDbo();
		$category_id = $jinput->getInt('category_id',0);
		$db->setQuery("Select * from #__osrs_categories where id = '$category_id'");
		$category = $db->loadObject();
		$query = "Select a.*,c.name as agent_name,d.id as typeid,d.type_name from #__osrs_properties as a"
				//." LEFT JOIN #__osrs_categories as b on b.id = a.category_id"
				." INNER JOIN #__osrs_agents as c on c.id = a.agent_id"
				." LEFT JOIN #__osrs_types as d on d.id = a.pro_type"
				." WHERE 1=1";
		//$query .= " and a.`access` = '0' ";
		if($category_id > 0){
			$categoryArr = array();
			$categoryArr = HelperOspropertyCommon::getSubCategories($category_id,$categoryArr);
			$catids      = implode(",",$categoryArr);
			$query .= " AND a.id in(Select pid from #__osrs_property_categories where category_id in ($catids))";
		}
		$query .= " and a.published = '1' and a.approved = '1'";
		$query .= " order by a.id desc";
		$db->setQuery($query);
		//echo $db->getQuery();
		//die();
		$rows = $db->loadObjectList();
		$doc		= JFactory::getDocument();
		$doc->setLink(JRoute::_('index.php?option=com_osproperty&task=category_details&id='.$category_id));
		$doc->setTitle($category->category_name);
		$doc->setDescription(strip_tags($category->category_description));
		$doc->setGenerator($configClass['general_bussiness_name']);
		for($i=0;$i<count($rows);$i++){
			$row = $rows[$i];
			$db->setQuery("Select image from #__osrs_photos where pro_id = '$row->id' order by ordering");
			$image = $db->loadResult();
			
			$title = $row->pro_name;
			$title = html_entity_decode($title, ENT_COMPAT, 'UTF-8');
			if($row->ref != "")	{
				$title = $row->ref.", ".$title;
			}
			
			$itemid = OSPRoute::getPropertyItemid($row->id);
			$link = JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$row->id.'&Itemid='.$itemid);			
			// feed item description text
			@$created = ($row->created ? date('r', strtotime($row->created)) : '');
			// load individual item creator class
			$item = new JFeedItem();
			$item->title 		= $title;
			$item->link 		= $link;
			$item->author		= $row->agent_name;
			ob_start();
			?>
			<div style="width:100%;">
				<?php
				if($image != ""){
					if(file_exists(JPATH_ROOT.'/images/osproperty/properties/'.$row->id.'/thumb/'.$image)){
						?>
						<div style="float:left;">
							<img src="<?php echo JURI::root().'images/osproperty/properties/'.$row->id.'/thumb/'.$image?>" />
						</div>
						<?php
					}
				}
				echo $row->pro_small_desc;
				?>
			</div>
			<?php
			$desc = ob_get_contents();
			ob_end_clean();
			$item->description 	= $desc;
			$item->date			= @$created;
			$item->category		= OSPHelper::getCategoryNamesOfProperty($row->id);//$row->category_name;						
			$doc->addItem( $item );
		}
	}
	
	/**
	 * Report form
	 *
	 */
	function reportForm($id){
        global $jinput;
		$session = JFactory::getSession();
        $session->set('item',$id);
		$item_type = $jinput->getInt('item_type',0);
		$reportArr = array();
		if($item_type == 0){
			$reportArr[] = JHtml::_('select.option','',JText::_('OS_PLEASE_SELECT'));
			$reportArr[] = JHtml::_('select.option','OS_INVALID_DATA',JText::_('OS_INVALID_DATA'));
			$reportArr[] = JHtml::_('select.option','OS_INCORRECT_AGENT_CLAIM',JText::_('OS_INCORRECT_AGENT_CLAIM'));
			$reportArr[] = JHtml::_('select.option','OS_PROPERTY_SOLD',JText::_('OS_PROPERTY_SOLD'));
			$reportArr[] = JHtml::_('select.option','OS_PROPERTY_NOT_FOR_SALE',JText::_('OS_PROPERTY_NOT_FOR_SALE'));
			$reportArr[] = JHtml::_('select.option','OS_PRICE_CHANGE',JText::_('OS_PRICE_CHANGE'));
			$reportArr[] = JHtml::_('select.option','OS_INCORRECT_PHOTO',JText::_('OS_INCORRECT_PHOTO'));
			$reportArr[] = JHtml::_('select.option','OS_INCORRECT_MAP_LOCATION',JText::_('OS_INCORRECT_MAP_LOCATION'));
			$reportArr[] = JHtml::_('select.option','OS_INCORRECT_SOLD_PRICE',JText::_('OS_INCORRECT_SOLD_PRICE'));
			$reportArr[] = JHtml::_('select.option','OS_OFFENSIVE_CONTENT',JText::_('OS_OFFENSIVE_CONTENT'));
			$reportArr[] = JHtml::_('select.option','OS_IRRELEVANT_CONTENT',JText::_('OS_IRRELEVANT_CONTENT'));
			$reportArr[] = JHtml::_('select.option','OS_SPAM',JText::_('OS_SPAM'));
			$reportArr[] = JHtml::_('select.option','OS_OTHER',JText::_('OS_OTHER'));
			
		}else{
			$reportArr[] = JHtml::_('select.option','',JText::_('OS_PLEASE_SELECT'));
			$reportArr[] = JHtml::_('select.option','OS_INVALID_DATA',JText::_('OS_INVALID_DATA'));
			$reportArr[] = JHtml::_('select.option','OS_INCORRECT_AGENT_CLAIM',JText::_('OS_INCORRECT_AGENT_CLAIM'));
			$reportArr[] = JHtml::_('select.option','OS_INCORRECT_PHOTO',JText::_('OS_INCORRECT_PHOTO'));
			$reportArr[] = JHtml::_('select.option','OS_OFFENSIVE_CONTENT',JText::_('OS_OFFENSIVE_CONTENT'));
			$reportArr[] = JHtml::_('select.option','OS_IRRELEVANT_CONTENT',JText::_('OS_IRRELEVANT_CONTENT'));
			$reportArr[] = JHtml::_('select.option','OS_SPAM',JText::_('OS_SPAM'));
			$reportArr[] = JHtml::_('select.option','OS_OTHER',JText::_('OS_OTHER'));
		}
		$lists['report_reason'] = JHtml::_('select.genericlist',$reportArr,'report_reason','class="input-large"','value','text');
		HTML_OspropertyListing::reportForm($lists,$id,$item_type);
	}

	/**
	 * Send report
	 *
	 * @param unknown_type $id
	 */
	function doreportproperty($id){
		global $mainframe,$configClass,$jinput;
		$db = JFactory::getDbo();
		if($configClass['enable_report']==0){
			JError::raiseError( 404, JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA') );
		}

        $security_code = $jinput->getString('security_code','');
        $captcha_str   = $jinput->getString('captcha_str','');
        if($security_code != $captcha_str){
            ?>
            <script language="javascript">
                window.history.go(-1);
            </script>
            <?php
        }

        $session = JFactory::getSession();
        $item = $session->get('item',0);
        if(($item != $id) or ($item == 0)){
            ?>
            <script language="javascript">
                window.history.go(-1);
            </script>
            <?php
        }

		$report_reason = OSPHelper::getStringRequest('report_reason','');
		$report_details = $jinput->getString('report_details','');
		$your_email = OSPHelper::getStringRequest('your_email','','');
		$item_type = $jinput->getInt('item_type',0);
		$itemid = $jinput->getInt('Itemid',0);
		if($report_reason == ""){
			OspropertyListing::reportForm($id);
		}else{
			$row = &JTable::getInstance('Report','OspropertyTable');
			$row->id = 0;
			$row->item_type = $item_type;
			$row->report_ip = OSPHelper::get_ip_address();
			$row->report_reason = $report_reason;
			$row->report_details = $report_details;
			$row->report_email = $your_email;
			$row->item_id = $id;
			if($item_type == 0){
				$row->frontend_url = JURI::root().'index.php?option=com_osproperty&task=property_details&id='.$id.'&Itemid='.$itemid;
				$row->backend_url = JURI::root()."administrator/index.php?option=com_osproperty&task=properties_edit&cid[]=".$id;
			}elseif($item_type == 1){
				$row->frontend_url = JURI::root().'index.php?option=com_osproperty&task=agent_info&id='.$id.'&Itemid='.$itemid;
				$row->backend_url = JURI::root()."administrator/index.php?option=com_osproperty&task=agent_edit&cid[]=".$id;
			}elseif($item_type == 2){
				$row->frontend_url = JURI::root().'index.php?option=com_osproperty&task=company_edit&id='.$id.'&Itemid='.$itemid;
				$row->backend_url = JURI::root()."administrator/index.php?option=com_osproperty&task=companies_edit&cid[]=".$id;
			}
			$row->report_on = time();
			
			jimport('joomla.filesystem.file');
			if($row->store()){
				if(JFile::exists(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/reportcomplete.php')){
					$tpl = new OspropertyTemplate(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/');
				}else{
					$tpl = new OspropertyTemplate(JPATH_COMPONENT.'/helpers/layouts/');
				}
				$tpl->set('mainframe',$mainframe);
				$body = $tpl->fetch("reportcomplete.php");
			}else{
				if(JFile::exists(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/reportfailure.php')){
					$tpl = new OspropertyTemplate(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/');
				}else{
					$tpl = new OspropertyTemplate(JPATH_COMPONENT.'/helpers/layouts/');
				}
				$tpl->set('mainframe',$mainframe);
				$body = $tpl->fetch("reportfailure.php");
			}
			echo $body;
		}
	}
	
	/**
	 * This function is used to unfeatured property by agent
	 *
	 * @param unknown_type $id
	 */
	static function unfeaturedproperty($id){
		global $mainframe,$jinput;
		$db = JFactory::getDbo();
		if((!HelperOspropertyCommon::isAgent()) or ($id == 0)){
			JError::raiseError( 500, JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));	
		}
		if($id > 0){
			if(!HelperOspropertyCommon::isOwner($id)){
				JError::raiseError( 500, JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));	
			}
		}
		$db->setQuery("Update #__osrs_properties set isFeatured = '0' where id = '$id'");
		$db->query();
		$mainframe->redirect(JRoute::_('index.php?option=com_osproperty&task=agent_editprofile&Itemid='.$jinput->getInt('Itemid',0)),JText::_('OS_FEATURED').' '.JText::_('OS_STATUS_CHANGED'));
	}
	
	/**
	 * Get Json
	 *
	 */
	function getjson(){
        global $jinput;
        $db = JFactory::getDbo();
        $lang_suffix = OSPHelper::getFieldSuffix();
        $configClass = OSPHelper::loadConfig();
        $mainframe = JFactory::getApplication();
        $db = JFactory::getDbo();
        $map_layout = $jinput->getInt('map_layout','');
        $map_type = $jinput->getInt('map_type',0);
        if($map_type > 0){
            $typeSql = " and a.pro_type = '$map_type'";
        }
        $map_category = $jinput->getInt('map_category',0);
        if($map_category > 0){
            $catSql = " and a.id in (Select pid from #__osrs_property_categories where category_id = '$map_category')";
        }
        $map_country = $jinput->getInt('map_country',0);
        if($map_country > 0){
            $countrySql = " and a.country = '$map_country'";
        }
        $map_state = $jinput->getInt('map_state',0);
        if($map_state > 0){
            $stateSql = " and a.state = '$map_state'";
        }
        $map_city = $jinput->getInt('map_city',0);
        if($map_city > 0){
            $citySql = " and a.city = '$map_city'";
        }
        $priceSql = "";
        if($configClass['price_filter_type'] == 1){
            $price_from = $jinput->getFloat('price_from',0);
            if($price_from > 0){
                $priceSql .= " AND a.price >= '$price_from'";
            }
            $price_to = $jinput->getFloat('price_to',0);
            if($price_to > 0){
                $priceSql .= " AND a.price <= '$price_to'";
            }
        }else{
            $price = $jinput->getInt('price',0);
            if($price > 0){
                $db->setQuery("Select * from #__osrs_pricegroups where id = '$price'");
                $pricegroup = $db->loadObject();
                $price_from = $pricegroup->price_from;
                $price_to	= $pricegroup->price_to;
                if($price_from  > 0){
                    $priceSql .= " AND (a.price >= '$price_from')";
                }
                if($price_to > 0){
                    $priceSql .= " AND (a.price <= '$price_to')";
                }
            }
        }
        $count = $jinput->getInt('max_items',50);
        $query  = "Select a.*,b.type_name$lang_suffix as type_name,b.type_icon from #__osrs_properties as a"
            ." inner join #__osrs_types as b on b.id = a.pro_type"
            ." where a.published = '1' and a.approved = '1' and show_address = '1' and lat_add <> '' and long_add <> '' "
            .$typeSql
            .$catSql
            .$countrySql
            .$stateSql
            .$citySql
            .$priceSql
            ." order by id desc limit ".$count;
        ;
        $db->setQuery($query);
        //echo $db->getQuery();
        $properties = $db->loadObjectList();
        if(count($properties) > 0){
            foreach ($properties as $property){
                $needs = array();
                $needs[] = "property_details";
                $needs[] = $property->id;
                $itemid  = OSPRoute::getItemid($needs);
                $property->url = Jroute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid);

                $db->setQuery("Select image from #__osrs_photos where pro_id = '$property->id' order by ordering");
                $image = $db->loadResult();
                if($image != ""){
                    $property->photo = JUri::root()."images/osproperty/properties/".$property->id."/medium/".$image;
                }else{
                    $property->photo = JUri::root()."components/com_osproperty/images/assets/nopropertyphoto.png";
                }
            }

            $min = 0.9999997;
            $max = 1.00000000;
            $start_point = 1;
            for($i=0; $i<count($properties)-1; $i++){
                $obj1 = $properties[$i];
                for($j = 1;$j<count($properties);$j++){
                    $obj2 = $properties[$j];
                    if(($obj1->lat_add == $obj2->lat_add) and ($obj1->long_add == $obj2->long_add)){
                        $properties[$j]->lat_add  =  $obj2->lat_add * ($start_point * ($max - $min) + $min);
                        $properties[$j]->long_add =  $obj2->long_add * ($start_point * ($max - $min) + $min);
                        $start_point++;
                    }
                }
            }
        }

        while (@ob_end_clean());
        $tempArr = array();
        $i = 0;
        if(count($properties) > 0){
            foreach ($properties as $property){
                $tempArr['markers'][$i]->url 		= $property->url;
                $tempArr['markers'][$i]->latitude 	= $property->lat_add;
                $tempArr['markers'][$i]->longitude 	= $property->long_add;
                $tempArr['markers'][$i]->title 		= $property->pro_name;
                $tempArr['markers'][$i]->pro_name 	= OSPHelper::getLanguageFieldValue($property,'pro_name');//$property->pro_name;
                if($property->price_call == 1){
                    $tempArr['markers'][$i]->price  = JText::_("OS_CALL_FOR_PRICE");
                }else{
                    $tempArr['markers'][$i]->price 	= OSPHelper::generatePrice($property->curr,$property->price);
                }
                $tempArr['markers'][$i]->curr 		= $property->curr;
                $tempArr['markers'][$i]->price_call = $property->price_call;
                $tempArr['markers'][$i]->photo		= $property->photo;
                $tempArr['markers'][$i]->type_name	= $property->type_name;
                $type_icon							= $property->type_icon;
                if($type_icon == ""){
                    $type_icon = "1.png";
                }
                $tempArr['markers'][$i]->bath_room	= OSPHelper::showBath($property->bath_room);
                $tempArr['markers'][$i]->bed_room	= $property->bed_room;
                if($property->square_feet > 0){
                    $tempArr['markers'][$i]->square_feet= $property->square_feet."&nbsp;".OSPHelper::showSquareSymbol();
                }
                switch ($map_layout){
                    case "2":
                        if(file_exists(JPATH_ROOT.'/modules/mod_osmapsearch/asset/images/2/'.$type_icon)){
                            $tempArr['markers'][$i]->icon = Juri::root()."modules/mod_osmapsearch/asset/images/2/".$type_icon;
                        }elseif(file_exists(JPATH_ROOT.'/modules/mod_osmapsearch/asset/images/2/1.png')){
                            $tempArr['markers'][$i]->icon = Juri::root()."modules/mod_osmapsearch/asset/images/2/1.png";
                        }else{
                            $tempArr['markers'][$i]->icon = Juri::root()."components/com_osproperty/images/assets/googlemapicons/".$type_icon;
                        }
                        break;
                    case "3":
                        if(file_exists(JPATH_ROOT.'/modules/mod_osmapsearch/asset/images/3/'.$type_icon)){
                            $tempArr['markers'][$i]->icon = Juri::root()."modules/mod_osmapsearch/asset/images/3/".$type_icon;
                        }elseif(file_exists(JPATH_ROOT.'/modules/mod_osmapsearch/asset/images/3/1.png')){
                            $tempArr['markers'][$i]->icon = Juri::root()."modules/mod_osmapsearch/asset/images/3/1.png";
                        }else{
                            $tempArr['markers'][$i]->icon = Juri::root()."components/com_osproperty/images/assets/googlemapicons/".$type_icon;
                        }
                        break;
                    case "4":
                        if(file_exists(JPATH_ROOT.'/modules/mod_osmapsearch/asset/images/4/'.$type_icon)){
                            $tempArr['markers'][$i]->icon = Juri::root()."modules/mod_osmapsearch/asset/images/4/".$type_icon;
                        }elseif(file_exists(JPATH_ROOT.'/modules/mod_osmapsearch/asset/images/4/1.png')){
                            $tempArr['markers'][$i]->icon = Juri::root()."modules/mod_osmapsearch/asset/images/4/1.png";
                        }else{
                            $tempArr['markers'][$i]->icon = Juri::root()."components/com_osproperty/images/assets/googlemapicons/".$type_icon;
                        }
                        break;
                    case "5":
                        if(file_exists(JPATH_ROOT.'/modules/mod_osmapsearch/asset/images/5/'.$type_icon)){
                            $tempArr['markers'][$i]->icon = Juri::root()."modules/mod_osmapsearch/asset/images/5/".$type_icon;
                        }elseif(file_exists(JPATH_ROOT.'/modules/mod_osmapsearch/asset/images/5/1.png')){
                            $tempArr['markers'][$i]->icon = Juri::root()."modules/mod_osmapsearch/asset/images/5/1.png";
                        }else{
                            $tempArr['markers'][$i]->icon = Juri::root()."components/com_osproperty/images/assets/googlemapicons/".$type_icon;
                        }
                        break;
                    case "6":
                        if(file_exists(JPATH_ROOT.'/modules/mod_osmapsearch/asset/images/6/'.$type_icon)){
                            $tempArr['markers'][$i]->icon = Juri::root()."modules/mod_osmapsearch/asset/images/6/".$type_icon;
                        }elseif(file_exists(JPATH_ROOT.'/modules/mod_osmapsearch/asset/images/6/1.png')){
                            $tempArr['markers'][$i]->icon = Juri::root()."modules/mod_osmapsearch/asset/images/6/1.png";
                        }else{
                            $tempArr['markers'][$i]->icon = Juri::root()."components/com_osproperty/images/assets/googlemapicons/".$type_icon;
                        }
                        break;
                    default:
                        $tempArr['markers'][$i]->icon = Juri::root()."components/com_osproperty/images/assets/googlemapicons/".$type_icon;
                        break;
                }
                //$tempArr['markers'][$i]->icon		= Juri::root()."components/com_osproperty/images/assets/googlemapicons/".$type_icon;
                $i++;
            }
        }
        print_r(json_encode($tempArr));
        exit();
	}


    /**
     * Edit Comment
     */
    public static function editComment(){
        global $configClass,$jinput;
        $user = Jfactory::getUser();
        if($user->id == 0){
            JError::raiseError( 500, JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
        }else{
            $id = $jinput->getInt('id',0);
            if($id == 0){
                JError::raiseError( 500, JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
            }else{
                $db = JFactory::getDbo();
                $db->setQuery("Select * from #__osrs_comments where id = '$id'");
                $comment = $db->loadObject();
                if($user->id != $comment->user_id){
                    JError::raiseError( 500, JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
                }else{
                    HTML_OspropertyListing::editCommentForm($comment);
                }
            }
        }
    }

    /**
     * Edit Comment
     */
    public static function submitEditComment(){
        global $configClass,$mainframe,$jinput;
        $id = $jinput->getInt('id',0);
        $db = JFactory::getDbo();
        $user = Jfactory::getUser();
        $db->setQuery("Select * from #__osrs_comments where id = '$id'");
        $comment = $db->loadObject();
        $pro_id = $comment->pro_id;
        $needs = array();
        $needs[] = "property_details";
        $needs[] = $pro_id;
        $itemid  = OSPRoute::getItemid($needs);

        $comment_author 	= OSPHelper::getStringRequest('comment_author','','');
        $comment_title  	= OSPHelper::getStringRequest('comment_title','','');
        $comment_message	= $_POST['comment_message'];
        $rating				= $jinput->getString('rating');

        $row = JTable::getInstance('Comment','OspropertyTable');
        $post = $jinput->post->getArray();
        $row->bind($post);
        $row->id = $id;
        $row->content = $comment_message;
        $row->title = $comment_title;
        $row->name = $comment_author;
        $row->pro_id = $pro_id;
        $row->rate = $rating;
        $row->store();

        //if the comment is published automatically, update the rating and send email to property's onwer
        if($configClass['comment_auto_approved'] == 1){
            $db->setQuery("Select number_votes,total_points from #__osrs_properties where id = '$pro_id'");
            $rating_details = $db->loadObject();
            $number_votes = $rating_details->number_votes;
            $total_points = $rating_details->total_points;
            $total_points = $total_points + (int)$rating - (int)$comment->rate;
            $db->setQuery("Update #__osrs_properties set total_points='$total_points' where id = '$pro_id'");
            $db->query();
            $msg = JText::_('OS_COMMENT_HAS_BEEN_UPDATED');
        }
        $link = JUri::root()."index.php?option=com_osproperty&task=property_editcomment&tmpl=component&id=".$id;
        $mainframe->redirect($link,$msg);
    }

    /**
     * This is function is used to manage all properties at front-end through layout: Manage Properties
     */
	static function manageAllProperties($option){
		global $configClass,$jinput;
		//check permission
        $db = JFactory::getDbo();
        $document = JFactory::getDocument();
        $document->setTitle($configClass['general_bussiness_name']." - ".JText::_('OS_MANAGE_PROPERTIES'));
		OSPHelper::generateHeading(2,JText::_('OS_MANAGE_PROPERTIES'));
        $limit			= $jinput->getInt('limit',$configClass['general_number_properties_per_page']);
        $limitstart     = OSPHelper::getLimitStart();

        $category_id    = $jinput->getInt('category_id',0);
        $catIds 	    = array();
        $catIds[]	    = $category_id;
        $type_id        = $jinput->getInt('type_id',0);
        $status         = $jinput->getString('status','');
        $featured       = $jinput->getInt('featured_stt',-1);
        $approved       = $jinput->getInt('approved',-1);

        $keyword = OSPHelper::getStringRequest('filter_search','','post');
        $orderby = OSPHelper::getStringRequest('orderby','desc','post');
        $sortby = OSPHelper::getStringRequest('sortby','a.id','post');

        $query = "Select count(a.id) from #__osrs_properties as a"
            ." INNER JOIN #__osrs_agents as g on g.id = a.agent_id"
            ." LEFT  JOIN #__osrs_types as d on d.id = a.pro_type"
            ." INNER JOIN #__osrs_countries as e on e.id = a.country"
            ." LEFT JOIN #__osrs_states as s on s.id = a.state"
            ." LEFT JOIN #__osrs_cities as c on c.id = a.city"
            ." LEFT join #__osrs_expired as ex on ex.pid = a.id"
            ." WHERE 1=1";
        if($keyword != ""){
            $query .= " AND (a.pro_name LIKE '%$keyword%'";
            $query .= " OR a.ref like '%$keyword%'";
            $query .= " OR g.name like '%$keyword%'";
            $query .= " OR d.type_name like '%$keyword%'";
            $query .= " OR s.state_name like '%$keyword%'";
            $query .= " OR c.city like '%$keyword%'";
            $query .= " OR g.name like '%$keyword%'";
            $query .= ")";
        }
        if($category_id > 0){
            $query .= " AND a.id in (Select pid from #__osrs_property_categories where category_id = '$category_id')";
        }
        if($type_id > 0){
            $query .= " AND a.pro_type = '$type_id'";
        }
        if($status != ""){
            $query .= " AND a.published = '$status'";
        }
        if($featured > -1){
            $query .= " AND a.isFeatured = '$featured'";
        }
        if($approved > -1){
            $query .= " AND a.approved = '$approved'";
        }
        $db->setQuery($query);
        $count = $db->loadResult();

        $pageNav = new OSPJPagination($count,$limitstart,$limit);

        $query = "Select a.id, a.ref, a.pro_name,a.posted_by,a.company_id, d.id as typeid,d.type_name as type_name,g.name as agent_name,a.published,a.approved, a.isFeatured,a.curr,a.price,a.price_call,a.rent_time,a.show_address,a.hits,c.city,s.state_name as state_name,a.address, ex.expired_time,ex.expired_feature_time,a.total_request_info,a.total_points,a.number_votes,a.agent_id from #__osrs_properties as a"
            ." INNER JOIN #__osrs_agents as g on g.id = a.agent_id"
            ." LEFT  JOIN #__osrs_types as d on d.id = a.pro_type"
            ." INNER JOIN #__osrs_countries as e on e.id = a.country"
            ." LEFT JOIN #__osrs_states as s on s.id = a.state"
            ." LEFT JOIN #__osrs_cities as c on c.id = a.city"
            ." LEFT JOIN #__osrs_expired as ex on ex.pid = a.id"
            ." WHERE 1=1";
        if($keyword != ""){
            $query .= " AND (a.pro_name LIKE '%$keyword%'";
            $query .= " OR a.ref like '%$keyword%'";
            $query .= " OR g.name like '%$keyword%'";
            $query .= " OR d.type_name like '%$keyword%'";
            $query .= " OR s.state_name like '%$keyword%'";
            $query .= " OR c.city like '%$keyword%'";
			$query .= " OR g.name like '%$keyword%'";
            $query .= ")";
        }
        if($category_id > 0){
            $query .= " AND a.id in (Select pid from #__osrs_property_categories where category_id = '$category_id')";
        }
        if($type_id > 0){
            $query .= " AND a.pro_type = '$type_id'";
        }
        if($status != ""){
            $query .= " AND a.published = '$status'";
        }
        if($featured > -1){
            $query .= " AND a.isFeatured = '$featured'";
        }
        if($approved > -1){
            $query .= " AND a.approved = '$approved'";
        }
        $query .= " ORDER BY $sortby $orderby";

        $db->setQuery($query,$pageNav->limitstart,$pageNav->limit);
        $rows = $db->loadObjectList();
        if(count($rows) > 0){
            for($i=0;$i<count($rows);$i++){
                $row = $rows[$i];
                $db->setQuery("select count(id) from #__osrs_photos where pro_id = '$row->id'");
                $count = $db->loadResult();
                if($count > 0){
                    $row->count_photo = $count;
                    $db->setQuery("select image from #__osrs_photos where pro_id = '$row->id' order by ordering");
                    $photo = $db->loadResult();
                    if($photo != ""){
                        if(file_exists(JPATH_ROOT.'/images/osproperty/properties/'.$row->id.'/thumb/'.$photo)){
                            $row->photo = JURI::root()."images/osproperty/properties/".$row->id."/thumb/".$photo;
                        }else{
                            $row->photo = JURI::root()."components/com_osproperty/images/assets/nopropertyphoto.png";
                        }
                    }else{
                        $row->photo = JURI::root()."components/com_osproperty/images/assets/nopropertyphoto.png";
                    }
                }else{
                    $row->count_photo = 0;
                    $row->photo = JURI::root()."components/com_osproperty/images/assets/nopropertyphoto.png";
                }//end photo
            }
        }

        $orderbyArr[] = JHTML::_('select.option','',JText::_('OS_ORDERBY'));
        $orderbyArr[] = JHTML::_('select.option','asc',JText::_('OS_ASC'));
        $orderbyArr[] = JHTML::_('select.option','desc',JText::_('OS_DESC'));
        $lists['orderby'] = JHTML::_('select.genericlist',$orderbyArr,'orderby','class="input-medium" onchange="javascript:document.manageagent.submit();"','value','text',$orderby);

        $sortbyArr[] = JHTML::_('select.option','',JText::_('OS_SORTBY'));
        $sortbyArr[] = JHTML::_('select.option','a.ref',JText::_('Ref #'));
        $sortbyArr[] = JHTML::_('select.option','a.title',JText::_('OS_TITLE'));
        $sortbyArr[] = JHTML::_('select.option','a.address',JText::_('OS_ADDRESS'));
        $sortbyArr[] = JHTML::_('select.option','a.state',JText::_('OS_STATE'));
        $sortbyArr[] = JHTML::_('select.option','a.city',JText::_('OS_CITY'));
        $sortbyArr[] = JHTML::_('select.option','a.published',JText::_('OS_PUBLISHED'));
        $sortbyArr[] = JHTML::_('select.option','a.isFeatured',JText::_('OS_FEATURED'));
        $sortbyArr[] = JHTML::_('select.option','a.id',JText::_('ID'));
        $lists['sortby'] = JHTML::_('select.genericlist',$sortbyArr,'sortby','class="input-medium" onchange="javascript:document.manageagent.submit();"','value','text',$sortby);

        $lists['category'] = OSPHelper::listCategories($category_id,'onChange="this.form.submit();"');

        //property types
        $typeArr[] = JHTML::_('select.option','',JText::_('OS_ALL_PROPERTY_TYPES'));
        $db->setQuery("SELECT id as value,type_name as text FROM #__osrs_types where published = '1' ORDER BY type_name");
        $protypes = $db->loadObjectList();
        $typeArr   = array_merge($typeArr,$protypes);
        $lists['type'] = JHTML::_('select.genericlist',$typeArr,'type_id','class="input-large" onChange="this.form.submit();"','value','text',$type_id);

        $statusArr = array();
        $statusArr[] = JHTML::_('select.option','',JText::_('OS_ALL_STATUS'));
        $statusArr[] = JHTML::_('select.option',0,JText::_('OS_UNPUBLISHED'));
        $statusArr[] = JHTML::_('select.option',1,JText::_('OS_PUBLISHED'));
        $lists['status'] = JHTML::_('select.genericlist',$statusArr,'status','class="input-medium" onChange="this.form.submit();"','value','text',$status);

        $featuredArr = array();
        $featuredArr[] = JHtml::_('select.option','-1',JText::_('OS_FEATURED_STATUS'));
        $featuredArr[] = JHtml::_('select.option','0',JText::_('OS_NON_FEATURED_PROPERTIES'));
        $featuredArr[] = JHtml::_('select.option','1',JText::_('OS_FEATURED_PROPERTIES'));
        $lists['featured'] = JHTML::_('select.genericlist',$featuredArr,'featured_stt','class="input-medium" onChange="this.form.submit();"','value','text',$featured);

        $approvedArr = array();
        $approvedArr[] = JHtml::_('select.option','-1',JText::_('OS_APPROVAL_STATUS'));
        $approvedArr[] = JHtml::_('select.option','0',JText::_('OS_UNAPPROVED'));
        $approvedArr[] = JHtml::_('select.option','1',JText::_('OS_APPROVED'));
        $lists['approved'] = JHTML::_('select.genericlist',$approvedArr,'approved','class="input-medium" onChange="this.form.submit();"','value','text',$approved);

        $db->setQuery("select id as value, company_name as text from #__osrs_companies where published = '1' order by company_name");
        $companies 	  = $db->loadObjectList();
        $companyArr[] = JHTML::_('select.option','',JText::_('OS_SELECT_COMPANY'));
        $companyArr   = array_merge($companyArr,$companies);
        $lists['company'] = JHTML::_('select.genericlist',$companyArr,'company_id','class="input-large"','value','text',$agent->company_id);
        HTML_OspropertyListing::manageAllProperties($rows,$lists,$pageNav);
	}

    static function changeStatus($option,$id,$type){
        global $mainframe,$jinput,$configClass;
        $value = $jinput->getInt('value',0);
        $db = JFactory::getDbo();
        $db->setQuery("Update #__osrs_properties set $type = '$value' where id = '$id'");
        $db->query();
		if(($type == "isFeatured") or ($type == "approved")){
			require_once(JPATH_ADMINISTRATOR.'/components/com_osproperty/classes/property.php');
			OspropertyProperties::updateStatus($option,$type,$value,$id);
		}
		$needs = array();
		$needs[] = "lmanageproperties";
		$needs[] = "property_manageallproperties";
		$itemid  = OSPRoute::getItemid($needs);
		$mainframe->redirect(JRoute::_('index.php?option=com_osproperty&task=property_manageallproperties&Itemid='.$itemid),JText::_('OS_PROPERTY_STATUS_HAS_BEEN_CHANGED'));
    }

	static function changeStatuses($option,$cid,$type,$value){
		global $mainframe,$jinput,$configClass;
        $db = JFactory::getDbo();
        $db->setQuery("Update #__osrs_properties set $type = '$value' where id in (".implode(",",$cid).")");
        $db->query();
		$needs = array();
		$needs[] = "lmanageproperties";
		$needs[] = "property_manageallproperties";
		$itemid  = OSPRoute::getItemid($needs);
		$mainframe->redirect(JRoute::_('index.php?option=com_osproperty&task=property_manageallproperties&Itemid='.$itemid),JText::_('OS_PROPERTY_STATUS_HAS_BEEN_CHANGED'));
	}

	public static function stasInformation(){
		global $configClass,$mainframe,$jinput;
        $db   = JFactory::getDbo();
        $user = JFactory::getUser();
        $document = JFactory::getDocument();
        $id = $jinput->get("id",0);
        $document->addScript(JURI::root()."components/com_osproperty/js/Chart.min.js");
        if($user->id==0){
            $mainframe->redirect(JUri::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
        }
        $company=array();
        if($id > 0){
            if((!HelperOspropertyCommon::isOwner($id)) and (!HelperOspropertyCommon::isCompanyOwner($id)) and (!JFactory::getUser()->authorise('frontendmanage', 'com_osproperty'))){
                $mainframe->redirect(JUri::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
            }
        }
        if((HelperOspropertyCommon::isCompanyAdmin())){
            $db->setQuery("SELECT id FROM #__osrs_agents WHERE company_id=(SELECT id FROM #__osrs_companies WHERE user_id=$user->id)");
            $company=$db->loadColumn();
        }else{
            $db->setQuery("SELECT id FROM #__osrs_agents WHERE published=1 AND user_id=$user->id");
            $company[]=$user->id;
        }

        $company='('.implode(",",$company).')';
        $query = "SELECT a.*,c.type_name as pro_type, c.type_icon FROM #__osrs_properties as a LEFT JOIN #__osrs_types as c on c.id = a.pro_type LEFT JOIN #__osrs_countries as d on d.id = a.country  WHERE a.id = $id";
        $db->setQuery($query);

        $row = $db->loadObject();

		$type_icon = $row->type_icon;
		if($type_icon == ""){
			$type_icon = "1.png";
		}
		$row->type_icon = JUri::root()."components/com_osproperty/images/assets/googlemapicons/".$type_icon;

        $query ="SELECT image FROM #__osrs_photos WHERE pro_id=$id AND ordering=1";
        $db->setQuery($query);
        $row->photo=$db->loadObject();

		//saved
		$query = $db->getQuery(true);
		$query->select('count(id)')->from('#__osrs_favorites')->where('pro_id="'.$id.'"');
		$db->setQuery($query);
		$row->saved = (int)$db->loadResult();
		$query->clear();

		$document->setTitle($row->pro_name);

		$Order_by = " ORDER BY pr.hits desc ";
		$sql =   " SELECT pr.* "
				."\n, ci.city AS city_name"
				."\n, st.state_name" 
				."\n, co.country_name"
				."\n, ty.type_name$lang_suffix, ty.id as type_id"
				."\n FROM #__osrs_properties pr"
				."\n LEFT JOIN #__osrs_cities AS ci ON ci.id = pr.city "
				."\n LEFT JOIN #__osrs_states AS st ON st.id = pr.state"
				."\n LEFT JOIN #__osrs_countries AS co ON co.id = pr.country"
				."\n INNER JOIN #__osrs_types AS ty ON ty.id = pr.pro_type"
				."\n WHERE 	pr.approved  = '1' and pr.published = '1'" 
				."\n AND pr.id <> '$property->id' "
				."\n AND pr.access IN (" . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ")";
		$sql .=	$Order_by;
		$sql .= " LIMIT 10";
		$db->setQuery($sql);

		$relates = $db->loadObjectList();
		if (count($relates)){
			for($i=0;$i<count($relates);$i++){//for
				$relate = $relates[$i];
				$type_name = OSPHelper::getLanguageFieldValue($relate,'type_name');
				$relate->type_name = $type_name;
				$db->setQuery("select image from #__osrs_photos where pro_id = '$relate->id' order by ordering");
				$relate->photo = $db->loadResult();
				if ($relate->photo == ''){
					$relate->photo = JURI::root()."components/com_osproperty/images/assets/nopropertyphoto.png";
				}else {
					if(file_exists(JPATH_ROOT.'/images/osproperty/properties/'.$relate->id.'/thumb/'.$relate->photo)){
						$relate->photo = JURI::root()."images/osproperty/properties/".$relate->id."/thumb/".$relate->photo;	
					}else{
						$relate->photo = JURI::root()."components/com_osproperty/images/assets/nopropertyphoto.png";	
					}
				}

				if($configClass['load_lazy']){
					$relate->photosrc = JUri::root()."components/com_osproperty/images/assets/loader.gif";
				}else{
					$relate->photosrc = $relate->photo;
				}

				$needs = array();
				$needs[] = "property_details";
				$needs[] = $relate->id;
				$item_id = OSPRoute::getItemid($needs);
				$relate->itemid = $item_id;
			}//for			
		}

		jimport('joomla.filesystem.file');
		
		ob_start();
		if(JFile::exists(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/relateproperties.php')){
			$tpl = new OspropertyTemplate(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/');
		}else{
			$tpl = new OspropertyTemplate(JPATH_COMPONENT.'/helpers/layouts/');
		}
		$tpl->set('mainframe',$mainframe);
		$tpl->set('relates',$relates);
		$tpl->set('configClass',$configClass);
		echo $tpl->fetch("relateproperties.php");
		$relate = ob_get_contents();
		ob_end_clean();
		$row->relate_properties = $relate;

        if(JFile::exists(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/propertystatistic.php')){
			$tpl = new OspropertyTemplate(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/');
		}else{
			$tpl = new OspropertyTemplate(JPATH_COMPONENT.'/helpers/layouts/');
		}
		$tpl = new OspropertyTemplate(JPATH_COMPONENT.'/helpers/layouts/');
        $tpl->set('row',$row);
		$tpl->set('configClass',$configClass);
        $body= $tpl->fetch("propertystatistic.php");
		echo $body;
	}
}
?>