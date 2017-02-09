<?php
/*------------------------------------------------------------------------
	# install.osproperty.php - Ossolution Property
	# ------------------------------------------------------------------------
	# author    Dang Thuc Dam
	# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
	# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
	# Websites: http://www.joomdonation.com
	# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
error_reporting(0);

class com_ospropertyInstallerScript {
	public static $languageFiles = array('en-GB.com_osproperty.ini');
	
	/**
	 * Method to run before installing the component	 
	 */
	function preflight($type, $parent)
	{
		//Backup the old language file
		foreach (self::$languageFiles as $languageFile) {
			if (JFile::exists(JPATH_ROOT.'/language/en-GB/'.$languageFile)) {
				JFile::copy(JPATH_ROOT.'/language/en-GB/'.$languageFile, JPATH_ROOT.'/language/en-GB/bak.'.date('d-m-Y',time()).$languageFile);
			}
			if (JFile::exists(JPATH_ADMINISTRATOR.'/language/en-GB/'.$languageFile)) {
				JFile::copy(JPATH_ADMINISTRATOR.'/language/en-GB/'.$languageFile, JPATH_ROOT.'/language/en-GB/bak.'.date('d-m-Y',time()).$languageFile);
			}
		}				
	}	
	
	
	function install($parent)
	{
		com_install() ;
	}
	
	function update($parent)
	{
		com_install();
	}
}

function com_install() {
	jimport('joomla.filesystem.file') ;
    jimport('joomla.filesystem.folder') ;
    define('DS',DIRECTORY_SEPARATOR);
    $db = & JFactory::getDBO(); 		
    
    $config = new JConfig();
    $dbname = $config->db;
    $prefix = $config->dbprefix;
    
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_configuration'");
    $count = $db->loadResult();
    if($count == 0){
    	$configSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/install.osproperty.sql' ;
    	$sql = JFile::read($configSql) ;
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
    
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_neighborhood'");
    $count = $db->loadResult();
    if($count == 0){
    	$configSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/neighborhood.osproperty.sql' ;
    	$sql = JFile::read($configSql) ;
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
    
    $db->setQuery("ALTER TABLE `#__osrs_configuration` CHANGE `fieldvalue` `fieldvalue` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL ");
    $db->query();
    
    
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_company_agents'");
    $count = $db->loadResult();
    if($count == 0){
    	$configSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/companyagents.osproperty.sql' ;
    	$sql = JFile::read($configSql) ;
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

    
    //update city
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_cities'");    
    $count = $db->loadResult();
    if($count == 0){ //the city tables doesn't exists
    	$configSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/cities.osproperty.sql' ;
    	$sql = JFile::read($configSql) ;
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
    }else{
    	$db->setQuery("SELECT COUNT(id) FROM #__osrs_cities");
    	$count = $db->loadResult();
    	if($count == 0){
    		$configSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/cities.osproperty.sql' ;
	    	$sql = JFile::read($configSql) ;
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
    }
    
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_currencies'");    
    $count = $db->loadResult();
    if($count == 0){ //the currency tables doesn't exists
	    //currency
	    $configSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/currency.osproperty.sql' ;
		$sql = JFile::read($configSql) ;
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
    
    $db->setQuery("SELECT COUNT(id) FROM #__osrs_currencies");
    $count = $db->loadResult();
    if($count == 0){//in case count currency = 0, import currency data
    	$configSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/currency.osproperty.sql' ;
		$sql = JFile::read($configSql) ;
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
    
    $db->setQuery("ALTER TABLE `#__osrs_currencies` CHANGE `currency_symbol` `currency_symbol` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ");
    $db->query();
    //update Russian Rubbie
    $db->setQuery("Update #__osrs_currencies set currency_symbol = '&#1088;&#1091;&#1073;' where id = '44'");
    $db->query();

	$db->setQuery("SHOW COLUMNS FROM #__osrs_currencies");
	$fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('published',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_currencies` ADD `published` tinyint(1) NOT NULL DEFAULT '1' ;");
    		$db->query();
    	}
    }
    
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_report'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_report` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `report_ip` varchar(50) DEFAULT NULL,
					  `item_type` tinyint(1) unsigned DEFAULT NULL,
					  `report_reason` varchar(255) DEFAULT NULL,
					  `report_details` text,
					  `report_email` varchar(100) DEFAULT NULL,
					  `item_id` int(11) DEFAULT NULL,
					  `frontend_url` varchar(255) DEFAULT NULL,
					  `backend_url` varchar(255) DEFAULT NULL,
					  `report_on` int(11) DEFAULT '0',
					  `is_checked` tinyint(1) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }

	$db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_property_price_history'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_property_price_history` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `pid` int(11) DEFAULT NULL,
					  `date` date DEFAULT NULL,
					  `event` varchar(255) DEFAULT NULL,
					  `price` decimal(12,2) DEFAULT NULL,
					  `source` varchar(255) DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }
    

	$db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_property_open'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_property_open` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `pid` int(11) DEFAULT NULL,
					  `start_from` datetime DEFAULT NULL,
					  `end_to` datetime DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }

	$db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_property_history_tax'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_property_history_tax` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `pid` int(11) DEFAULT NULL,
					  `tax_year` int(4) DEFAULT NULL,
					  `property_tax` decimal(10,2) DEFAULT NULL,
					  `tax_change` decimal(10,2) DEFAULT NULL,
					  `tax_assessment` decimal(10,2) DEFAULT NULL,
					  `tax_assessment_change` decimal(10,2) DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }
    
	$db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_extra_field_types'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_extra_field_types` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `fid` int(11) DEFAULT NULL,
						  `type_id` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
						");
    	$db->query();
    	
    	$db->setQuery("Select id from #__osrs_types");
    	$types = $db->loadObjectList();
    	
    	$db->setQuery("Select id from #__osrs_extra_fields");
    	$fields = $db->loadObjectList();
    	
    	foreach ($fields as $field){
    		foreach ($types as $type){
    			$db->setQuery("Insert into #__osrs_extra_field_types (id,fid,type_id) values (NULL,'$field->id','$type->id')");
    			$db->query();
    		}
    	}
    }

    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_tags'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_tags` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `keyword` varchar(255) DEFAULT NULL,
					  `published` tinyint(1) unsigned DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }
    
	$db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_property_categories'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_property_categories` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `pid` int(11) DEFAULT NULL,
						  `category_id` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    	
    	$db->setQuery("Select id,category_id from #__osrs_properties");
    	$properties = $db->loadObjectList();
    	if(count($properties) > 0){
    		foreach ($properties as $property){
    			$db->setQuery("Insert into #__osrs_property_categories (id, pid, category_id) values (NULL,'$property->id','$property->category_id')");
    			$db->query();
    		}
    	}
    }
    
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_tag_xref'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_tag_xref` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `tag_id` int(11) DEFAULT NULL,
					  `pid` int(1) DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }
    
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_themes'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_themes` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `name` varchar(255) DEFAULT NULL,
					  `title` varchar(100) DEFAULT NULL,
					  `author` varchar(60) DEFAULT NULL,
					  `creation_date` varchar(50) DEFAULT NULL,
					  `copyright` varchar(100) DEFAULT NULL,
					  `license` varchar(255) DEFAULT NULL,
					  `author_email` varchar(50) DEFAULT NULL,
					  `author_url` varchar(50) DEFAULT NULL,
					  `version` varchar(40) DEFAULT NULL,
					  `description` text,
					  `params` text,
					  `support_mobile_device` tinyint(1) unsigned DEFAULT NULL,
					  `published` tinyint(1) unsigned DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }
        
    $db->setQuery("Select count(id) from #__osrs_themes");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("INSERT INTO `#__osrs_themes` (`id`, `name`, `title`, `author`, `creation_date`, `copyright`, `license`, `author_email`, `author_url`, `version`, `description`, `params`, `support_mobile_device`, `published`) VALUES
(1, 'default', 'Default theme', 'Dang Thuc Dam', '2013-03-01 00:00:00', 'http://joomdonation.com', NULL, 'damdt@joomservices.com', 'http://osproperty.ext4joomla.com', '1.0', 'This is default template of OS Property component', NULL, 1, 1),
(3, 'theme1', 'OS Property Template 1', 'Dang Thuc Dam', '26-05-2013', 'Copyright 2007-2013 Ossolution Team', 'http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2', 'damdt@joomservices.com', 'www.joomdonation.com', '1.0', 'Template 1 for OS Property component', NULL, 1, 0),
(5, 'theme2', 'OSP Responsive theme 2 - Bootstrap twitter supported', 'Dang Thuc Dam', '26-05-2013', 'Copyright 2007-2013 Ossolution Team', 'http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2', 'damdt@joomservices.com', 'www.joomdonation.com', '1.0', 'OSP Responsive theme 2 - Bootstrap twitter supported. This theme uses Twitter Bootstrap 2.3.2, it can display correctly if you''re using a Joomla template which isn''t a responsive design.', NULL, 1, 0);");
    	$db->query();
    }

	$db->setQuery("Select count(id) from #__osrs_themes where `name` like 'theme1'");
	$count = $db->loadResult();
    if($count == 0){
		$db->setQuery("INSERT INTO `#__osrs_themes` (`id`, `name`, `title`, `author`, `creation_date`, `copyright`, `license`, `author_email`, `author_url`, `version`, `description`, `params`, `support_mobile_device`, `published`) VALUES (NULL, 'theme1', 'OSP Responsive theme - Bootstrap twitter supported', 'Dang Thuc Dam', '26-05-2013', 'Copyright 2007-2013 Ossolution Team', 'http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2', 'damdt@joomservices.com', 'www.joomdonation.com', '1.0', 'OSP Responsive theme - Bootstrap twitter supported. This theme uses Twitter Bootstrap 2.3.2, it can display correctly if you are using a Joomla template which is not a responsive design.', NULL, 1, 0);");
		$db->query();
	}

    $db->setQuery("Select count(id) from #__osrs_themes where `name` like 'theme2'");
	$count = $db->loadResult();
    if($count == 0){
		$db->setQuery("INSERT INTO `#__osrs_themes` (`id`, `name`, `title`, `author`, `creation_date`, `copyright`, `license`, `author_email`, `author_url`, `version`, `description`, `params`, `support_mobile_device`, `published`) VALUES (NULL, 'theme2', 'OSP Responsive theme 2 - Bootstrap twitter supported', 'Dang Thuc Dam', '26-05-2013', 'Copyright 2007-2013 Ossolution Team', 'http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2', 'damdt@joomservices.com', 'www.joomdonation.com', '1.0', 'OSP Responsive theme 2 - Bootstrap twitter supported. This theme uses Twitter Bootstrap 2.3.2, it can display correctly if you are using a Joomla template which is not a responsive design.', NULL, 1, 0);");
		$db->query();
	}
	
	$db->setQuery("Select count(id) from #__osrs_themes where `name` like 'theme_black'");
	$count = $db->loadResult();
    if($count == 0){
		$db->setQuery("INSERT INTO `#__osrs_themes` (`id`, `name`, `title`, `author`, `creation_date`, `copyright`, `license`, `author_email`, `author_url`, `version`, `description`, `params`, `support_mobile_device`, `published`) VALUES (NULL, 'theme_black', 'OSP Responsive Black Transparent theme', 'Dang Thuc Dam', '26-05-2013', 'Copyright 2007-2013 Ossolution Team', 'http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2', 'damdt@joomservices.com', 'www.joomdonation.com', '1.0', 'OSP Responsive Black Transparent theme - Bootstrap twitter supported. This theme uses Twitter Bootstrap 2.3.2, it can display correctly if you are using a Joomla template which is not a responsive design.', NULL, 1, 0);");
		$db->query();
	}
	
	$db->setQuery("Select count(id) from #__osrs_themes where `name` like 'blue'");
	$count = $db->loadResult();
    if($count == 0){
		$db->setQuery("INSERT INTO `#__osrs_themes` (`id`, `name`, `title`, `author`, `creation_date`, `copyright`, `license`, `author_email`, `author_url`, `version`, `description`, `params`, `support_mobile_device`, `published`) VALUES(NULL, 'blue', 'OSP Blue Responsive - Bootstrap twitter supported', 'Dang Thuc Dam', '26-09-2013', 'Copyright 2007-2013 Ossolution Team', 'http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2', 'damdt@joomservices.com', 'www.joomdonation.com', '1.0', 'OSP Blue Responsive - Bootstrap twitter supported. This theme uses Twitter Bootstrap 2.3.2, it can display correctly if you\'re using a Joomla template which isn\'t a responsive design.', NULL, 0, 0);");
		$db->query();
	}
	
	$db->setQuery("Select count(id) from #__osrs_themes where `name` like 'theme3'");
	$count = $db->loadResult();
    if($count == 0){
		$db->setQuery("INSERT INTO `#__osrs_themes` (`id`, `name`, `title`, `author`, `creation_date`, `copyright`, `license`, `author_email`, `author_url`, `version`, `description`, `params`, `support_mobile_device`, `published`) VALUES(NULL, 'theme3', 'Theme 3', 'Dang Thuc Dam', '24-04-14 15:38:11', 'Copyright 2007-2014 Ossolution Team', NULL, 'damdt@joomservices.com', 'www.joomdonation.com', '1.0', 'Theme 3 - CSS 3 theme', 'ncolumns=\"1\"\nthemeBackgroundColor=\"#88C354\"', 1, 0);");
		$db->query();
	}
	
    //create table #__osrs_user_list
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_user_list'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_user_list` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `user_id` int(11) NOT NULL DEFAULT '0',
					  `list_name` varchar(255) NOT NULL,
					  `receive_email` tinyint(1) NOT NULL DEFAULT '0',
					  `lang` varchar(20) NOT NULL,
					  `created_on` datetime NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }
    
    
    //create table #__osrs_user_list_details
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_init'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list_details tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_init` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `name` varchar(255) NOT NULL,
					  `value` int(255) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }   

    
    //create table #__osrs_user_list_details
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_user_list_details'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list_details tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_user_list_details` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `list_id` int(11) NOT NULL DEFAULT '0',
						  `field_id` varchar(100) NOT NULL,
						  `field_type` tinyint(1) NOT NULL DEFAULT '0',
						  `search_param` varchar(100) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
    	$db->query();
    }
    
    $db->setQuery("SHOW COLUMNS FROM #__osrs_user_list_details");
	$fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('search_type',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_user_list_details` ADD `search_type` varchar(50) NOT NULL AFTER `field_type` ;");
    		$db->query();
    	}
    }

	$db->setQuery("SHOW COLUMNS FROM #__osrs_user_list");
	$fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('receive_email',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_user_list` ADD `receive_email` tinyint(1) NOT NULL DEFAULT '0' NOT NULL AFTER `list_name` ;");
    		$db->query();
    	}
		if(!in_array('lang',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_user_list` ADD `lang` varchar(20) NOT NULL AFTER `receive_email` ;");
    		$db->query();
    	}
    }
    
    //create table #__osrs_urls
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_urls'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list_details tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_urls` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `md5_key` text,
						  `query` text,
						  PRIMARY KEY (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }
    
    //create table #__osrs_menus
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_menus'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_menus` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `menu_name` varchar(255) NOT NULL,
					  `menu_icon` varchar(255) NOT NULL,
					  `parent_id` int(11) NOT NULL DEFAULT '0',
					  `menu_task` varchar(255) NOT NULL,
					  `ordering` int(11) NOT NULL DEFAULT '0',
					  `published` tinyint(1) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }
    
    $db->setQuery("Select count(id) from `#__osrs_menus`");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("INSERT INTO `#__osrs_menus` (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES
						(1, 'OS_DASHBOARD', 'icon-home', 0, 'cpanel_list', 1, 1),
						(2, 'OS_PROPERTY_INFORMATION', 'icon-list', 0, '', 1, 1),
						(3, 'OS_MANAGE_PROPERTY_TYPES', '', 2, 'type_list', 2, 1),
						(4, 'OS_MANAGE_CATEGORIES', '', 2, 'categories_list', 3, 1),
						(5, 'OS_MANAGE_PROPERTIES', '', 2, 'properties_list', 4, 1),
						(6, 'OS_MANAGE_EXTRA_FIELD_GROUPS', '', 2, 'fieldgroup_list', 5, 1),
						(7, 'OS_MANAGE_EXTRA_FIELDS', '', 2, 'extrafield_list', 6, 1),
						(8, 'OS_PROPERTY_OWNER', 'icon-user', 0, '', 3, 1),
						(9, 'OS_MANAGE_COMPANIES', '', 8, 'companies_list', 1, 1),
						(10, 'OS_MANAGE_AGENTS', '', 8, 'agent_list', 2, 1),
						(11, 'OS_LOCATION', 'icon-location', 0, '', 3, 1),
						(12, 'OS_MANAGE_STATES', '', 11, 'state_list', 1, 1),
						(13, 'OS_MANAGE_CITY', '', 11, 'city_list', 2, 1),
						(14, 'OS_OTHER', 'icon-wrench', 0, '', 4, 1),
						(15, 'OS_MANAGE_PRICELIST', '', 14, 'pricegroup_list', 1, 1),
						(16, 'OS_MANAGE_EMAIL_FORMS', '', 14, 'email_list', 2, 1),
						(17, 'OS_MANAGE_COMMENTS', '', 14, 'comment_list', 3, 1),
						(18, 'OS_TRANSLATION', '', 14, 'translation_list', 4, 1),
						(19, 'OS_CSV_IMPORT', '', 14, 'form_default', 9, 1),
						(20, 'OS_MANAGE_THEMES', '', 14, 'theme_list', 6, 1),
						(21, 'OS_BACKUP', '', 14, 'properties_backup', 7, 1),
						(22, 'OS_RESTORE', '', 14, 'properties_restore', 8, 1),
						(23, 'OS_CONFIGURATION', 'icon-cog', 0, 'configuration_list', 6, 1),
						(24, 'OS_MANAGE_CONVENIENCE', '', 14, 'amenities_list', 5, 1),
						(25, 'OS_EXPORT_CSV', '', 14, 'csvexport_default', 10, 1),
						(26, 'OS_MANAGE_TAGS', '', 14, 'tag_list', 11, 1),
						(27, 'OS_IMPORT_XML', '', 14, 'xml_defaultimport', 10, 1),
						(28, 'OS_EXPORT_XML', '', 14, 'xml_default', 10, 1),
						(29, 'JTOOLBAR_HELP', 'icon-support', 0, 'configuration_help', 8, 1),
						(30, 'OS_MANAGE_PAYMENT_PLUGINS', '', 14, 'plugin_list', 12, 1),
						(31, 'OS_MANAGE_TRANSACTION', '', 14, 'transaction_list', 13, 1),
						(32, 'OS_TOOLS', 'icon-tools', 0, '', 7, 1),
						(33, 'OS_OPTIMIZE_SEF_URLS', '', 32, 'properties_sefoptimize', 1, 1),
						(34, 'OS_FIX_DATABASE_SCHEMA', '', 32, 'properties_fixdatabase', 2, 1),
						(35, 'OS_SHARE_TRANSLATION', '', 32, 'properties_sharetranslation', 3, 1),
						(36, 'OS_REMOVE_ORPHAN_PROPERTIES', '', 32, 'properties_removeorphan', 4, 1),
						(37, 'OS_MANAGE_COUNTRIES', '', 11, 'country_list', 0, 1);");
    	$db->query();
    }
    
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_property_listing_layout'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_user_list tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_property_listing_layout` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `itemid` int(11) DEFAULT NULL,
					  `category_id` int(11) DEFAULT NULL,
					  `type_id` int(11) DEFAULT NULL,
					  `country_id` int(11) DEFAULT NULL,
					  `company_id` int(11) DEFAULT NULL,
					  `featured` tinyint(1) unsigned DEFAULT NULL,
					  `sold` tinyint(1) NOT NULL DEFAULT '0',
					  `state_id` int(11) DEFAULT NULL,
					  `agenttype` tinyint(2) unsigned DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }
    
	$db->setQuery("SHOW COLUMNS FROM #__osrs_property_listing_layout");
	$fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('sold',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_property_listing_layout` ADD `sold` tinyint(1) NOT NULL DEFAULT '0' AFTER `featured` ;");
    		$db->query();
    	}
	}

    $db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'OS_MANAGE_CONVENIENCE'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'OS_MANAGE_CONVENIENCE','','14','amenities_list',9,1)");
    	$db->query();
    }
    
    $db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'OS_EXPORT_CSV'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'OS_EXPORT_CSV','','14','csvexport_default',10,1)");
    	$db->query();
    }
    
    $db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'OS_MANAGE_TAGS'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'OS_MANAGE_TAGS','','14','tag_list',11,1)");
    	$db->query();
    }

	$db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'OS_IMPORT_XML'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'OS_IMPORT_XML','','14','xml_defaultimport',10,1)");
    	$db->query();
    }

	$db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'OS_EXPORT_XML'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'OS_EXPORT_XML','','14','xml_default',10,1)");
    	$db->query();
    }

	$db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'JTOOLBAR_HELP'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'JTOOLBAR_HELP','icon-support','0','configuration_help',7,1)");
    	$db->query();
    }

	$db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'OS_MANAGE_PAYMENT_PLUGINS'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'OS_MANAGE_PAYMENT_PLUGINS','','14','plugin_list',12,1)");
    	$db->query();
    }

	$db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'OS_MANAGE_TRANSACTION'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'OS_MANAGE_TRANSACTION','','14','transaction_list',13,1)");
    	$db->query();
    }

	$db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'OS_TOOLS'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'OS_TOOLS','icon-tools','0','',7,1)");
    	$db->query();
		$tool_menu_id = $db->insertId();
    }else{
		$db->setQuery("Select id from #__osrs_menus where `menu_name` like 'OS_TOOLS'");
		$tool_menu_id = $db->loadResult();
	}

	$db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'OS_OPTIMIZE_SEF_URLS'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'OS_OPTIMIZE_SEF_URLS','', '$tool_menu_id', 'properties_sefoptimize', 1, 1)");
    	$db->query();
    }
	$db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'OS_FIX_DATABASE_SCHEMA'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'OS_FIX_DATABASE_SCHEMA','', '$tool_menu_id', 'properties_fixdatabase', 2, 1)");
    	$db->query();
    }
	$db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'OS_SHARE_TRANSLATION'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'OS_SHARE_TRANSLATION','', '$tool_menu_id', 'properties_sharetranslation', 3, 1)");
    	$db->query();
    }
	$db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'OS_MANAGE_COUNTRIES'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'OS_MANAGE_COUNTRIES','', '11', 'country_list', 0, 1)");
    	$db->query();
    }
	$db->setQuery("Select count(id) from #__osrs_menus where `menu_name` like 'OS_REMOVE_ORPHAN_PROPERTIES'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("Insert into #__osrs_menus (`id`, `menu_name`, `menu_icon`, `parent_id`, `menu_task`, `ordering`, `published`) VALUES (NULL,'OS_REMOVE_ORPHAN_PROPERTIES','', '32', 'properties_removeorphan', 4, 1)");
    	$db->query();
    }

	$db->setQuery("Update #__osrs_menus set `ordering` = '9' where menu_name like 'OS_CSV_IMPORT'");
	$db->query();

	$db->setQuery("Update #__osrs_menus set `ordering` = '5' where menu_name like 'OS_MANAGE_CONVENIENCE'");
	$db->query();

	$db->setQuery("Update #__osrs_menus set `menu_icon` = 'icon-location' where menu_name like 'OS_LOCATION'");
	$db->query();

	$db->setQuery("Update #__osrs_menus set `menu_icon` = 'icon-list' where menu_name like 'OS_PROPERTY_INFORMATION'");
	$db->query();

	$db->setQuery("Update #__osrs_menus set `menu_icon` = 'icon-wrench' where menu_name like 'OS_OTHER'");
	$db->query();

	$db->setQuery("Update #__osrs_menus set `menu_icon` = 'icon-cog' where menu_name like 'OS_CONFIGURATION'");
	$db->query();

	$db->setQuery("Update #__osrs_menus set `ordering` = '8' where menu_name like 'JTOOLBAR_HELP'");
	$db->query();

	//create table #__osrs_plugins
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_plugins'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_plugins` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `name` varchar(255) DEFAULT NULL,
					  `title` varchar(100) DEFAULT NULL,
					  `author` varchar(250) DEFAULT NULL,
					  `creation_date` datetime DEFAULT NULL,
					  `copyright` varchar(255) DEFAULT NULL,
					  `license` varchar(255) DEFAULT NULL,
					  `author_email` varchar(50) DEFAULT NULL,
					  `author_url` varchar(50) DEFAULT NULL,
					  `version` varchar(50) DEFAULT NULL,
					  `description` varchar(255) DEFAULT NULL,
					  `params` text,
					  `ordering` int(11) DEFAULT NULL,
					  `published` tinyint(3) unsigned DEFAULT NULL,
					  `support_recurring_subscription` tinyint(4) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }
	
    $db->setQuery("SHOW COLUMNS FROM #__osrs_properties");
	$fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('ref',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `ref` varchar(50) NOT NULL DEFAULT '' AFTER `id` ;");
    		$db->query();
    	}
    	if(!in_array('pro_alias',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `pro_alias` varchar(50) NOT NULL DEFAULT '' AFTER `pro_name` ;");
    		$db->query();
    	}
		if(!in_array('pro_browser_title',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `pro_browser_title` varchar(50) NOT NULL DEFAULT '' AFTER `pro_alias` ;");
    		$db->query();
    	}
    	if(!in_array('total_request_info',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `total_request_info` INT(11) NOT NULL DEFAULT '0' AFTER `total_points` ;");
    		$db->query();
    	}
		if(!in_array('isSold',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `isSold` tinyint(1) NOT NULL DEFAULT '0' AFTER `isFeatured` ;");
    		$db->query();
    	}
		if(!in_array('soldOn',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `soldOn` date NOT NULL AFTER `isSold` ;");
    		$db->query();
    	}
  		if(!in_array('lot_size',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `lot_size` decimal(7,2) NOT NULL DEFAULT '0.00' AFTER `square_feet`;");
    		$db->query();
    	}
		if(!in_array('posted_by',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `posted_by` tinyint(1) NOT NULL DEFAULT '0' AFTER `request_featured`;");
    		$db->query();
    	}
		if(!in_array('company_id',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `company_id` int(11) NOT NULL DEFAULT '0' AFTER `agent_id`;");
    		$db->query();
    	}

		if(!in_array('living_areas',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `living_areas` varchar(50) NOT NULL DEFAULT '';");
    		$db->query();
    	}
	
		$varchar255 = array('garage_description','house_style','house_construction','exterior_finish','roof','flooring','basement_foundation','percent_finished','subdivision','land_holding_type','lot_dimensions','frontpage','depth','takings','returns','net_profit','business_type','stock','fixtures','fittings','percent_office','percent_warehouse','loading_facilities','fencing','rainfall','soil_type','grazing','cropping','irrigation','water_resources','carrying_capacity','storage');
		foreach($varchar255 as $field){
			if(!in_array($field,$fieldArr)){
				$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `".$field."` varchar(255) NOT NULL DEFAULT '';");
				$db->query();
			}
		}

		$int4 = array('built_on','remodeled_on');
		foreach($int4 as $field){
			if(!in_array($field,$fieldArr)){
				$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `".$field."` int(4) NOT NULL DEFAULT '0';");
				$db->query();
			}
		}

		$decimal10 = array('floor_area_lower','floor_area_main_level','floor_area_upper','floor_area_total','basement_size','land_area','total_acres');
		foreach($decimal10 as $field){
			if(!in_array($field,$fieldArr)){
				$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `".$field."` decimal(12,2) NOT NULL DEFAULT '0';");
				$db->query();
			}
		}
		
    }

    $db->setQuery("ALTER TABLE `#__osrs_properties` CHANGE `bath_room` `bath_room` DECIMAL(4,2) NULL;");
    $db->query();

	$db->setQuery("ALTER TABLE `#__osrs_properties` CHANGE `square_feet` `square_feet` DECIMAL(7,2) NOT NULL;");
    $db->query();

	$db->setQuery("SHOW COLUMNS FROM #__osrs_orders");
	$fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('agent_id',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_orders` ADD `agent_id` int(11) DEFAULT '0' AFTER `id` ;");
    		$db->query();
    	}
		if(!in_array('created_by',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_orders` ADD `created_by` tinyint(1) NOT NULL DEFAULT '0' AFTER `agent_id` ;");
    		$db->query();
    	}
		if(!in_array('payment_method',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_orders` ADD `payment_method` varchar(50) NOT NULL AFTER `created_by` ;");
    		$db->query();
    	}
		if(!in_array('x_card_num',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_orders` ADD `x_card_num` varchar(20) NOT NULL AFTER `payment_method` ;");
    		$db->query();
    	}
		if(!in_array('x_card_code',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_orders` ADD `x_card_code` int(3) NOT NULL AFTER `x_card_num` ;");
    		$db->query();
    	}
		if(!in_array('card_holder_name',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_orders` ADD `card_holder_name` varchar(100) NOT NULL AFTER `x_card_code` ;");
    		$db->query();
    	}
		if(!in_array('exp_year',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_orders` ADD `exp_year` int(4) NOT NULL AFTER `card_holder_name` ;");
    		$db->query();
    	}
		if(!in_array('exp_month',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_orders` ADD `exp_month` tinyint(2) NOT NULL AFTER `exp_year` ;");
    		$db->query();
    	}
		if(!in_array('card_type',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_orders` ADD `card_type` varchar(50) NOT NULL AFTER `exp_month` ;");
    		$db->query();
    	}
		if(!in_array('curr',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_orders` ADD `curr` int(3) NOT NULL AFTER `total` ;");
    		$db->query();
    	}
		if(!in_array('direction',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_orders` ADD `direction` tinyint(1) NOT NULL DEFAULT '0' AFTER `curr` ;");
    		$db->query();
    	}
		if(!in_array('payment_made',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_orders` ADD `payment_made` tinyint(1) NOT NULL DEFAULT '0' AFTER `direction` ;");
    		$db->query();
    	}
    }

	$db->setQuery("SHOW COLUMNS FROM #__osrs_order_details");
	$fields = $db->loadObjectList();
	if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('type',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_order_details` ADD `type`  tinyint(1) NOT NULL DEFAULT '0' AFTER `pid` ;");
    		$db->query();
    	}
    }

    $db->setQuery("SHOW COLUMNS FROM #__osrs_property_field_value");
	$fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('value_integer',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_property_field_value` ADD `value_integer` int(11) NOT NULL DEFAULT '0' AFTER `value` ;");
    		$db->query();
    	}
    	if(!in_array('value_decimal',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_property_field_value` ADD `value_decimal` decimal(12,2) NOT NULL DEFAULT '0.0' AFTER `value_integer` ;");
    		$db->query();
    	}
    	if(!in_array('value_date',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_property_field_value` ADD `value_date` date DEFAULT NULL AFTER `value_decimal` ;");
    		$db->query();
    	}
    }
    
    $db->setQuery("SHOW COLUMNS FROM #__osrs_categories");
	$fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('category_alias',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_categories` ADD `category_alias` varchar(255) NOT NULL DEFAULT '' AFTER `category_name` ;");
    		$db->query();
    	}
		if(!in_array('category_meta',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_categories` ADD `category_meta` TEXT NOT NULL DEFAULT '' AFTER `category_alias` ;");
    		$db->query();
    	}
		if(!in_array('category_ordering',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_categories` ADD `category_ordering` TINYINT(3) NOT NULL DEFAULT '0'; ");
    		$db->query();
    	}
    }
    
    $db->setQuery("SHOW COLUMNS FROM #__osrs_types");
	$fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('type_alias',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_types` ADD `type_alias` varchar(255) NOT NULL DEFAULT '' AFTER `type_name` ;");
    		$db->query();
    	}
		
   		if(!in_array('ordering',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_types` ADD `ordering` int(11) NOT NULL DEFAULT '0' AFTER `type_description` ;");
    		$db->query();
    		//set up the ordering for property types
    		$db->setQuery("Select id from #__osrs_types");
    		$types = $db->loadObjectList();
    		if(count($types) > 0){
    			for($j=0;$j<count($types);$j++){
    				$db->setQuery("Update #__osrs_types set ordering = '$j' where id = '".$types[$j]->id."'");
    				$db->query();
    			}
    		}
    	}

		if(!in_array('price_type',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_types` ADD `price_type` tinyint(1) NOT NULL DEFAULT '0' AFTER `type_description` ;");
    		$db->query();
    	}

		if(!in_array('type_icon',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_types` ADD type_icon varchar(255) NOT NULL AFTER `price_type` ;");
    		$db->query();
    	}
    }
    
    $db->setQuery("SHOW COLUMNS FROM #__osrs_agents");
	$fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('alias',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agents` ADD `alias` varchar(255) NOT NULL DEFAULT '' AFTER `name` ;");
    		$db->query();
    	}
		if(!in_array('featured',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agents` ADD `featured` tinyint(1) unsigned DEFAULT '0' AFTER `published` ;");
    		$db->query();
    	}
		if(!in_array('bio',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agents` ADD `bio` TEXT NOT NULL DEFAULT '' AFTER `request_to_approval` ;");
    		$db->query();
    	}
    	if(!in_array('agent_type',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agents` ADD `agent_type` tinyint(1) NOT NULL DEFAULT '0' AFTER `id` ;");
    		$db->query();
    	}
    }
    
    //create the image folder for each properties
    $db->setQuery("Select id from #__osrs_properties");
    $pids = $db->loadOBjectList();
    if(count($pids) > 0){
    	require_once(JPATH_ROOT.'/components/com_osproperty/helpers/helper.php');
    	for($i=0;$i<count($pids);$i++){
    		$pid = $pids[$i];
    		OSPHelper::createPhotoDirectory($pid->id);
    		OSPHelper::movingPhoto($pid->id);
    	}
    }
    
	//price group table
	$db->setQuery("SHOW COLUMNS FROM #__osrs_pricegroups");
    $fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(in_array('display_price',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_pricegroups` DROP `display_price`;");
    		$db->query();
    	}
    	if(in_array('price',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_pricegroups` DROP `price`;");
    		$db->query();
    	}
    	if(!in_array('price_to',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_pricegroups` ADD `price_to` DECIMAL( 16, 2 ) NOT NULL DEFAULT '0' AFTER `id` ");
    		$db->query();
    	}
    	if(!in_array('price_from',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_pricegroups` ADD `price_from` DECIMAL( 16, 2 ) NOT NULL DEFAULT '0' AFTER `id` ");
    		$db->query();
    	}
    	if(!in_array('type_id',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_pricegroups` ADD `type_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `id` ;");
    		$db->query();
    	}
    }
	
    $db->setQuery("ALTER TABLE `#__osrs_pricegroups` CHANGE `price_to` `price_to` DECIMAL( 16, 2 ) NULL DEFAULT NULL ");
    $db->query();
    $db->setQuery("ALTER TABLE `#__osrs_pricegroups` CHANGE `price_from` `price_from` DECIMAL( 16, 2 ) NULL DEFAULT NULL ");
    $db->query();
    
    $db->setQuery("SHOW COLUMNS FROM #__osrs_companies");
    $fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('user_id',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_companies` ADD `user_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `id` ;");
    		$db->query();
    	}
    	if(!in_array('company_alias',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_companies` ADD `company_alias` VARCHAR( 255 ) NOT NULL DEFAULT '' AFTER `company_name` ;");
    		$db->query();
    	}
    	if(!in_array('request_to_approval',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_companies` ADD `request_to_approval` tinyint(1) NOT NULL DEFAULT '0' AFTER `company_description` ;");
    		$db->query();
    	}
    }
    
    
    //ALTER TABLE `#__osrs_properties` ADD `curr` INT( 11 ) NOT NULL DEFAULT '0' AFTER `price_original` ;
    $db->setQuery("SHOW COLUMNS FROM #__osrs_properties");
    $fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('curr',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `curr` INT( 11 ) NOT NULL DEFAULT '0' AFTER `price_original` ;");
    		$db->query();
    	}
    	
    	if(!in_array('energy',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `energy` DECIMAL( 6, 2 ) NOT NULL AFTER `parking` ;");
    		$db->query();
    	}
    	
    	if(!in_array('climate',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_properties` ADD `climate` DECIMAL( 6, 2 ) NOT NULL AFTER `energy` ;");
    		$db->query();
    	}
    	
    }
    
    $db->setQuery("SHOW COLUMNS FROM #__osrs_comments");
    $fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('ip_address',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_comments` ADD `ip_address` varchar(255) NOT NULL AFTER `content` ;");
    		$db->query();
    	}
    	if(!in_array('country',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_comments` ADD `country` varchar(50) NOT NULL AFTER `content` ;");
    		$db->query();
    	}
    }
    
    $db->setQuery("SHOW COLUMNS FROM #__osrs_extra_fields");
    $fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('show_on_list',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_extra_fields` ADD `show_on_list` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `displaytitle` ;");
    		$db->query();
    	}
    	if(!in_array('access',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_extra_fields` ADD `access` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `show_on_list` ;");
    		$db->query();
    	}
    	if(!in_array('value_type',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_extra_fields` ADD `value_type` tinyint(1) NOT NULL DEFAULT '0' AFTER `maxlength` ;");
    		$db->query();
    	}
    }
	
	$db->setQuery("SHOW COLUMNS FROM #__osrs_amenities");
    $fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
		if(!in_array('ordering',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_amenities` ADD `ordering` INT( 11 ) NOT NULL DEFAULT '0' AFTER `amenities` ;");
    		$db->query();
    	}
    	if(!in_array('category_id',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_amenities` ADD `category_id` tinyint(2) NOT NULL DEFAULT '0' AFTER `id` ;");
    		$db->query();
    	}
    }

	//check and add missing amenities
	addConvenience('Gas Hot Water','4');
	addConvenience('Central Air','6');
	addConvenience('Cable Internet','0');
	addConvenience('Cable TV','0');
	addConvenience('Electric Hot Water','0');
	addConvenience('Freezer','2');
	addConvenience('Swimming Pool','3');
	addConvenience('Skylights','0');
	addConvenience('Microwave','2');
	addConvenience('Sprinkler System','0');
	addConvenience('Wood Stove','0');
	addConvenience('Fruit Trees','5');
	addConvenience('Washer/Dryer','7');
	addConvenience('Dishwasher','2');
	addConvenience('Landscaping','7');
	addConvenience('Boat Slip','5');
	addConvenience('Burglar Alarm','8');
	addConvenience('Carpet Throughout','6');
	addConvenience('Central Vac','6');
	addConvenience('Covered Patio','5');
	addConvenience('Exterior Lighting','5');
	addConvenience('Fence','5');
	addConvenience('Fireplace','4');
	addConvenience('Garage','5');
	addConvenience('Garbage Disposal','2');
	addConvenience('Gas Fireplace','4');
	addConvenience('Gas Stove','4');
	addConvenience('Gazebo','5');
	addConvenience('Grill Top','2');
	addConvenience('Handicap Facilities','1');
	addConvenience('Jacuzi Tub','6');
	addConvenience('Lawn','7');
	addConvenience('Open Deck','5');
	addConvenience('Pasture','5');
	addConvenience('Pellet Stove','4');
	addConvenience('Propane Hot Water','4');
	addConvenience('Range/Oven','2');
	addConvenience('Refrigerator','2');
	addConvenience('RO Combo Gas/Electric','2');
	addConvenience('RV Parking','5');
	addConvenience('Satellite Dish','0');
	addConvenience('Spa/Hot Tub','5');
	addConvenience('Sprinkler System','8');
	addConvenience('Tennis Court','3');
	addConvenience('Football ground','3');
	addConvenience('Trash Compactor','2');
	addConvenience('Water Softener','0');
	addConvenience('Wheelchair Ramp','1');
	addConvenience('Wood Stove','4');
    
    $db->setQuery("SHOW COLUMNS FROM #__osrs_fieldgroups");
    $fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('access',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_fieldgroups` ADD `access` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `group_name` ;");
    		$db->query();
    	}
    }
    
    
    //#__osrs_agent_account
    $db->setQuery("SHOW COLUMNS FROM #__osrs_agent_account");
    $fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(in_array('deadline_time',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agent_account` DROP `deadline_time` ;");
    		$db->query();
    	}
    	
    	//number_listings
    	if(in_array('number_listings',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agent_account` DROP `number_listings` ;");
    		$db->query();
    	}
    	
    	if(in_array('nplan',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agent_account` DROP `nplan` ;");
    		$db->query();
    	}
    	
    	if(in_array('normal_listing',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agent_account` DROP `normal_listing` ;");
    		$db->query();
    	}
    	
    	if(in_array('feature_listing',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agent_account` DROP `feature_listing` ;");
    		$db->query();
    	}
    	
    	if(in_array('fplan',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agent_account` DROP `fplan` ;");
    		$db->query();
    	}
    	
    	if(!in_array('sub_id',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agent_account` ADD `sub_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `id` ;");
    		$db->query();
    	}
    	
    	if(!in_array('type',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agent_account` ADD `type` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `agent_id` ;");
    		$db->query();
    	}
    	
    	if(!in_array('nproperties',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agent_account` ADD `nproperties` INT( 11 ) NOT NULL DEFAULT '0' AFTER `type` ;");
    		$db->query();
    	}
    	
    	if(!in_array('status',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agent_account` ADD `status` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `nproperties` ;");
    		$db->query();
    	}

		if(!in_array('company_id',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_agent_account` ADD company_id INT( 11 ) NOT NULL DEFAULT '0' AFTER `agent_id` ;");
    		$db->query();
    	}
    }
    
    	
	$sql = 'SELECT COUNT(*) FROM #__osrs_configuration';
	$db->setQuery($sql) ;	
	$total = $db->loadResult();
	if (!$total) {		
		$configSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/configuration.osproperty.sql' ;
		$sql = JFile::read($configSql) ;
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
	
	//ALTER TABLE `#__osrs_companies` ADD `user_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `id` ;
    $db->setQuery("SHOW COLUMNS FROM #__osrs_states");
    $fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('published',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_states` ADD `published` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `state_code` ;");
    		$db->query();
    	}
    }
    $db->setQuery("ALTER TABLE `#__osrs_states` CHANGE `state_name` `state_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ");
    $db->query();
    $db->setQuery("ALTER TABLE `#__osrs_states` CHANGE `state_code` `state_code` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ");
    $db->query();
    
    $db->setQuery("Select count(id) from #__osrs_states");
    $count = $db->loadResult();
    if($count == 0){
		$stateSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/states.osproperty.sql' ;
		$sql = JFile::read($stateSql) ;
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
	
	$sql = "SELECT COUNT(*) FROM #__osrs_amenities";
	$db->setQuery($sql);
	$total = $db->loadResult();
	
	if(! $total){
		$amenitiesSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/amenities.osproperty.sql' ;
		$sql = JFile::read($amenitiesSql) ;
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
	
	$sql = "SELECT COUNT(*) FROM #__osrs_emails";
	$db->setQuery($sql);
	$total = $db->loadResult();
	
	if(! $total){
		$emailSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/emails.osproperty.sql' ;
		$sql = JFile::read($emailSql) ;
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

	$db->setQuery("Select count(id) from #__osrs_emails where email_key like 'email_alert'");
	$count_email_alert = $db->loadResult();
	if($count_email_alert == 0){
		$db->setQuery("INSERT INTO `#__osrs_emails` (`id`, `email_key`, `email_title`, `email_content`, `published`) VALUES (NULL, 'email_alert', 'New properties uploaded', '<h1 style=\"text-align: center;\"><strong>New properties uploaded</strong></h1>\r\n<p 
style=\"text-align: center;\">Dear customer, new properties have been uploaded that suit with your Saved Search list <strong>{listname}
</strong>. Please take a look at this them bellow</p>\r\n<p style=\"text-align: center;\">�{new_properties}</p>\r\n<p style=\"text-align: 
left;\"><em>If you don''t want to receive this email, please click this link</em> {cancel_alert_email_link}</p>', 1);");
		$db->query();
	}
	
	//import csv if the csv tables doesn't exists
	$csvSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/csv.osproperty.sql' ;
	$sql = JFile::read($csvSql) ;
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
	
	$db->setQuery("SHOW COLUMNS FROM #__osrs_csv_forms");
	$fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('yes_value',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_csv_forms` ADD `yes_value` varchar(50) NOT NULL DEFAULT '' AFTER `last_import`;");
    		$db->query();
    	}
    	if(!in_array('no_value',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_csv_forms` ADD `no_value` varchar(50) NOT NULL DEFAULT '' AFTER `yes_value`;");
    		$db->query();
    	}
    	if(!in_array('ftype',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_csv_forms` ADD `ftype` TINYINT(1) NOT NULL DEFAULT '0' AFTER `no_value`;");
    		$db->query();
    	}
    	if(!in_array('type_id',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_csv_forms` ADD `type_id` INT(11) NOT NULL DEFAULT '0' AFTER `ftype`;");
    		$db->query();
    	}
    	if(!in_array('fcategory',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_csv_forms` ADD `fcategory` TINYINT(1) NOT NULL DEFAULT '0' AFTER `type_id`;");
    		$db->query();
    	}
    	if(!in_array('category_id',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_csv_forms` ADD `category_id` INT(11) NOT NULL DEFAULT '0' AFTER `fcategory`;");
    		$db->query();
    	}
    	if(!in_array('agent_id',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_csv_forms` ADD `agent_id` INT(11) NOT NULL DEFAULT '0' AFTER `category_id`;");
    		$db->query();
    	}
    	if(!in_array('country',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_csv_forms` ADD `country` INT(11) NOT NULL DEFAULT '0' AFTER `agent_id`;");
    		$db->query();
    	}
    	if(!in_array('fstate',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_csv_forms` ADD `fstate` TINYINT(1) NOT NULL DEFAULT '0' AFTER `country`;");
    		$db->query();
    	}
    	if(!in_array('state',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_csv_forms` ADD `state` INT(11) NOT NULL DEFAULT '0' AFTER `fstate`;");
    		$db->query();
    	}
    	if(!in_array('fcity',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_csv_forms` ADD `fcity` TINYINT(1) NOT NULL DEFAULT '0' AFTER `state`;");
    		$db->query();
    	}
    	if(!in_array('city',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_csv_forms` ADD `city` INT(11) NOT NULL DEFAULT '0' AFTER `fcity`;");
    		$db->query();
    	}
    }
	
	
	$sql = "SELECT COUNT(*) FROM #__osrs_types";
	$db->setQuery($sql);
	$total = $db->loadResult();
	
	if(! $total){
		$typesSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/types.osproperty.sql' ;
		$sql = JFile::read($typesSql) ;
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
	
	$db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_importlog_properties'");
    $count = $db->loadResult();
    if($count == 0){ //the #__osrs_property_field_opt_value tables doesn't exists
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_importlog_properties` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `form_id` int(11) NOT NULL DEFAULT '0',
					  `pid` int(11) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }
	
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_watermark'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_watermark` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `pid` int(11) NOT NULL DEFAULT '0',
					  `image` varchar(100) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }

	//create table #__osrs_list_properties
    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_list_properties'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_list_properties` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `pid` int(11) DEFAULT NULL,
					  `list_id` int(11) DEFAULT NULL,
					  `sent_notify` tinyint(1) unsigned DEFAULT '0',
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }

	//create table `#__osrs_new_properties` 
	$db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_new_properties`'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_new_properties` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `pid` int(11) DEFAULT NULL,
					  `processed` tinyint(1) unsigned DEFAULT '0',
					  PRIMARY KEY (`id`),
					  KEY `pid` (`pid`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }

    $db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_xml'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_xml` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `filename` varchar(255) DEFAULT NULL,
					  `publish_properties` tinyint(1) NOT NULL DEFAULT '0',
					  `imported` int(11) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }

	$db->setQuery("SHOW COLUMNS FROM #__osrs_xml");
	$fields = $db->loadObjectList();
    if(count($fields) > 0){
    	$fieldArr = array();
    	for($i=0;$i<count($fields);$i++){
    		$field = $fields[$i];
    		$fieldname = $field->Field;
    		$fieldArr[$i] = $fieldname;
    	}
    	if(!in_array('publish_properties',$fieldArr)){
    		$db->setQuery("ALTER TABLE `#__osrs_xml` ADD `publish_properties` tinyint(1) NOT NULL DEFAULT '0'");
    		$db->query();
    	}
	}

	$db->setQuery("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '".$prefix."osrs_xml_details'");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__osrs_xml_details` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `xml_id` int(11) DEFAULT NULL,
					  `obj_content` text,
					  `imported` tinyint(1) unsigned zerofill DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    	$db->query();
    }
    
    $db->setQuery("SELECT COUNT(id) FROM #__osrs_countries WHERE `country_name` LIKE 'Maldives'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_countries (id,country_name,country_code) VALUES (206,'Maldives','MV')");
		$db->query();
	}

	$db->setQuery("SELECT COUNT(id) FROM #__osrs_countries WHERE `country_name` LIKE 'Scotland'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_countries (id,country_name,country_code) VALUES (207,'Scotland','SL')");
		$db->query();
	}

	$db->setQuery("SELECT COUNT(id) FROM #__osrs_countries WHERE `country_name` LIKE 'Northen Ireland'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_countries (id,country_name,country_code) VALUES (208,'Northen Ireland','NR')");
		$db->query();
	}

	$db->setQuery("SELECT COUNT(id) FROM #__osrs_countries WHERE `country_name` LIKE 'Wales'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_countries (id,country_name,country_code) VALUES (209,'Wales','WA')");
		$db->query();
	}
   
	
	//version 2.8.4 - Joomla User groups
	//Update properties, categories, extra fields and extra field groups
	$db->setQuery("Update #__osrs_properties set `access` = '1' where `access` = '0'");
    $db->query();

	$db->setQuery("Update #__osrs_categories set `access` = '1' where `access` = '0'");
    $db->query();

	$db->setQuery("Update #__osrs_extra_fields set `access` = '1' where `access` = '0'");
    $db->query();

	$db->setQuery("Update #__osrs_fieldgroups set `access` = '1' where `access` = '0'");
    $db->query();

	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'default_access_level'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_configuration (id,fieldname,fieldvalue) VALUES (NULL,'default_access_level','1')");
		$db->query();
	}

	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'min_price_slider'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_configuration (id,fieldname,fieldvalue) VALUES (NULL,'min_price_slider','0')");
		$db->query();
	}
	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'min_price_slider' and fieldvalue like ''");
	$count = $db->loadResult();
	if(intval($count) > 0){
		$db->setQuery("UPDATE #__osrs_configuration set fieldvalue = '0' where fieldname like 'min_price_slider'");
		$db->query();
	}

	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'max_price_slider'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_configuration (id,fieldname,fieldvalue) VALUES (NULL,'max_price_slider','500000')");
		$db->query();
	}
	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'max_price_slider' and fieldvalue like ''");
	$count = $db->loadResult();
	if(intval($count) > 0){
		$db->setQuery("UPDATE #__osrs_configuration set fieldvalue = '500000' where fieldname like 'max_price_slider'");
		$db->query();
	}

	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'price_step_amount'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_configuration (id,fieldname,fieldvalue) VALUES (NULL,'price_step_amount','1000')");
		$db->query();
	}
	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'price_step_amount' and fieldvalue like ''");
	$count = $db->loadResult();
	if(intval($count) > 0){
		$db->setQuery("UPDATE #__osrs_configuration set fieldvalue = '1000' where fieldname like 'price_step_amount'");
		$db->query();
	}
	
	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'default_sort_properties_by'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_configuration (id,fieldname,fieldvalue) VALUES (NULL,'default_sort_properties_by','a.isFeatured')");
		$db->query();
	}

	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'default_sort_properties_type'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_configuration (id,fieldname,fieldvalue) VALUES (NULL,'default_sort_properties_type','desc')");
		$db->query();
	}

	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'basement_foundation'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_configuration (id,fieldname,fieldvalue) VALUES (NULL,'basement_foundation','1')");
		$db->query();
	}

	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'use_business'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_configuration (id,fieldname,fieldvalue) VALUES (NULL,'use_business','1')");
		$db->query();
	}

	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'use_rural'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_configuration (id,fieldname,fieldvalue) VALUES (NULL,'use_rural','1')");
		$db->query();
	}

	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'use_miscellaneous'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_configuration (id,fieldname,fieldvalue) VALUES (NULL,'use_miscellaneous','1')");
		$db->query();
	}

	$db->setQuery("SELECT COUNT(id) FROM #__osrs_configuration WHERE fieldname like 'load_lazy'");
	$count = $db->loadResult();
	if(intval($count) == 0){
		$db->setQuery("INSERT INTO #__osrs_configuration (id,fieldname,fieldvalue) VALUES (NULL,'load_lazy','1')");
		$db->query();
	}

	$db->setQuery("Update #__osrs_configuration set `fieldvalue` = 'AIzaSyA4t1no8tjaqP95plUJHYUewFow7RGTlEI' where fieldname like 'goole_aip_key' and `fieldvalue` = ''");
	$db->query();


	//empty #__osrs_urls table
	$db->setQuery("Delete from #__osrs_urls");
	$db->query();
	
	jimport('joomla.filesystem.file');
	jimport('joomla.filesystem.folder');
	
	$htmlfile = JPATH_ROOT.DS."components".DS."com_osproperty".DS."index.html";
	if(!JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty")){
		JFolder::create(JPATH_ROOT.DS."images".DS."osproperty");
		JFile::copy($htmlfile,JPATH_ROOT.DS."images".DS."osproperty".DS."index.html");
	}
	if(!JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty".DS."agent")){
		JFolder::create(JPATH_ROOT.DS."images".DS."osproperty".DS."agent");
		JFile::copy($htmlfile,JPATH_ROOT.DS."images".DS."osproperty".DS."agent".DS."index.html");
	}
	if(!JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty".DS."agent".DS."thumbnail")){
		JFolder::create(JPATH_ROOT.DS."images".DS."osproperty".DS."agent".DS."thumbnail");
		JFile::copy($htmlfile,JPATH_ROOT.DS."images".DS."osproperty".DS."agent".DS."thumbnail".DS."index.html");
	}
	if(!JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty".DS."company")){
		JFolder::create(JPATH_ROOT.DS."images".DS."osproperty".DS."company");
		JFile::copy($htmlfile,JPATH_ROOT.DS."images".DS."osproperty".DS."company".DS."index.html");
	}
	if(!JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty".DS."plugins")){
		JFolder::create(JPATH_ROOT.DS."images".DS."osproperty".DS."plugins");
		JFile::copy($htmlfile,JPATH_ROOT.DS."images".DS."osproperty".DS."plugins".DS."index.html");
	}
	if(!JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty".DS."company".DS."thumbnail")){
		JFolder::create(JPATH_ROOT.DS."images".DS."osproperty".DS."company".DS."thumbnail");
		JFile::copy($htmlfile,JPATH_ROOT.DS."images".DS."osproperty".DS."company".DS."thumbnail".DS."index.html");
	}
	if(!JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty".DS."properties")){
		JFolder::create(JPATH_ROOT.DS."images".DS."osproperty".DS."properties");
		JFile::copy($htmlfile,JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS."index.html");
	}
	if(!JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS."thumb")){
		JFolder::create(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS."thumb");
		JFile::copy($htmlfile,JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS."thumb".DS."index.html");
	}
	if(!JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS."medium")){
		JFolder::create(JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS."medium");
		JFile::copy($htmlfile,JPATH_ROOT.DS."images".DS."osproperty".DS."properties".DS."medium".DS."index.html");
	}
	if(!JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty".DS."category")){
		JFolder::create(JPATH_ROOT.DS."images".DS."osproperty".DS."category");
		JFile::copy($htmlfile,JPATH_ROOT.DS."images".DS."osproperty".DS."category".DS."index.html");
	}
	if(!JFolder::exists(JPATH_ROOT.DS."images".DS."osproperty".DS."category".DS."thumbnail")){
		JFolder::create(JPATH_ROOT.DS."images".DS."osproperty".DS."category".DS."thumbnail");
		JFile::copy($htmlfile,JPATH_ROOT.DS."images".DS."osproperty".DS."category".DS."thumbnail".DS."index.html");
	}

	$db->setQuery("Select count(id) from `#__osrs_plugins`");
    $count = $db->loadResult();
    if($count == 0){
    	$db->setQuery("INSERT INTO `#__osrs_plugins` (`id`, `name`, `title`, `author`, `creation_date`, `copyright`, `license`, `author_email`, `author_url`, `version`, `description`, `params`, `ordering`, `published`, `support_recurring_subscription`) VALUES
(1, 'os_paypal', 'Paypal', 'Dang Thuc Dam', '2015-10-01 00:00:00', 'Copyright 2010-2015 Ossolution Team', 'http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2', 'damdt@joomservices.com', 'www.joomdonation.com', '1.0', 'Paypal payment plugin', 'paypal_mode=\"0\"\npaypal_id=\"manuni_1241974805_per@yahoo.com\"\npaypal_currency=\"USD\"', 2, 1, 1),
(3, 'os_offline', 'Offline Payment', 'Dang Thuc Dam', '2015-10-01 00:00:00', 'Copyright 2010-2015 Ossolution Team', 'http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2', 'damdt@joomservices.com', 'www.joomdonation.com', '1.0', 'Offline Payment Plugin For OS Property Extension', 'order_status=\"1\"', 4, 1, 0),
(4, 'os_stripe', 'Stripe', 'Dang Thuc Dam', '2015-10-01 00:00:00', 'Copyright 2010-2015 Ossolution Team', 'http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2', 'damdt@joomservices.com', 'www.joomdonation.com', '1.0', 'Stripe Payment Plugin For OS Property Extension', NULL, 5, 1, 0);");
    	$db->query();
		JFile::copy(JPATH_ROOT.DS."components".DS."com_osproperty".DS."images/assets".DS."os_offline.png",JPATH_ROOT.DS."images".DS."osproperty/plugins".DS."os_offline.png");
		JFile::copy(JPATH_ROOT.DS."components".DS."com_osproperty".DS."images/assets".DS."os_paypal.png",JPATH_ROOT.DS."images".DS."osproperty/plugins".DS."os_paypal.png");
		JFile::copy(JPATH_ROOT.DS."components".DS."com_osproperty".DS."images/assets".DS."os_stripe.png",JPATH_ROOT.DS."images".DS."osproperty/plugins".DS."os_stripe.png");

    }


	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."addproperty")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."addproperty");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."agents")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."agents");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."category")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."category");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."companies")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."companies");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."compare")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."compare");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."default")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."default");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."editdetails")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."editdetails");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."favoriteproperties")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."favoriteproperties");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."manageproperties")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."manageproperties");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."properties")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."properties");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."search")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."search");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."type")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."type");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."city")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."city");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."searchlist")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."searchlist");
	}
	if(JFolder::exists(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."companydetails")){
		JFolder::delete(JPATH_ROOT.DS."components".DS."com_osproperty".DS."views".DS."companydetails");
	}
	if(!JFolder::exists(JPATH_ROOT.DS."media".DS."com_osproperty")){
		JFolder::create(JPATH_ROOT.DS."media".DS."com_osproperty");
		JFile::copy($htmlfile,JPATH_ROOT.DS."media".DS."com_osproperty".DS."index.html");
	}
	
	JFile::copy(JPATH_ROOT.DS."components".DS."com_osproperty".DS."backup".DS."flags.zip",JPATH_ROOT.DS."media".DS."com_osproperty".DS."flags.zip");
	JArchive::extract(JPATH_ROOT.DS."media".DS."com_osproperty".DS."flags.zip",JPATH_ROOT.DS."media".DS."com_osproperty");

	if(!JFolder::exists(JPATH_ROOT.DS."media".DS."com_osproperty".DS."style")){
		JFolder::create(JPATH_ROOT.DS."media".DS."com_osproperty".DS."style");
	}
	if(!JFile::exists(JPATH_ROOT.DS."media".DS."com_osproperty".DS."style".DS."custom.css")){
		JFile::write(JPATH_ROOT.DS."media".DS."com_osproperty".DS."style".DS."custom.css");
	}
	?>
	<script language="javascript">
	function installSampleData(){
		location.href = "index.php?option=com_osproperty&task=properties_prepareinstallsample";
	}
	</script>
	<div style="width:95%;padding:10px;border:1px solid #55F489;background-color:#D3FFE1;">
		<center>
			<strong>Do you want to install sample data?</strong>
			<BR>
			<input type="button" class="button" value="INSTALL SAMPLE DATA" onclick="javascript:installSampleData();">
		</center>
	</div>
	<?php
}

function addConvenience($name,$category_id){
	$db = Jfactory::getDbo();
	$db->setQuery("Select count(id) from #__osrs_amenities where `amenities` like '$name'");
	$count = $db->loadResult();
	if($count == 0){
		$db->setQuery("Insert into #__osrs_amenities (id,category_id,amenities,published) values (NULL,'$category_id','$name',1)");
		$db->query();
	}
}
?>