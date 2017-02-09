<?php
/*------------------------------------------------------------------------
# plugin.php - OS Property
# ------------------------------------------------------------------------
# author    Ossolution team
# copyright Copyright (C) 2015 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die;

class OspropertyPlugin{
	function display($option,$task){
		global $jinput, $mainframe;
		$mainframe = JFactory::getApplication();
		$cid = $jinput->get( 'cid', array(),'ARRAY');
		switch ($task){
			default:
			case "plugin_list":
				OspropertyPlugin::plugin_list($option);
			break;
			case "plugin_unpublish":
				OspropertyPlugin::plugin_state($option,$cid,0);
			break;
			case "plugin_publish":
				OspropertyPlugin::plugin_state($option,$cid,1);
			break;	
			case "plugin_remove":
				OspropertyPlugin::plugin_remove($cid);
			break;
			case "plugin_edit":
				OspropertyPlugin::plugin_modify($option,$cid[0]);
			break;
			case "plugin_apply":
				OspropertyPlugin::plugin_save($option,0);
			break;
			case "plugin_save":
				OspropertyPlugin::plugin_save($option,1);
			break;
			case "goto_index":
				$mainframe = JFactory::getApplication();
				$mainframe->redirect("index.php");
			break;
			case "plugin_orderup":
				OspropertyPlugin::plugin_order($option,$cid[0],-1);
			break;
			case "plugin_orderdown":
				OspropertyPlugin::plugin_order($option,$cid[0],1);
			break;
			case "plugin_saveorder":
				OspropertyPlugin::plugin_saveorder($option,$cid);
			break;
			case "plugin_gotolist":
				$mainframe = JFactory::getApplication();
				$mainframe->redirect("index.php?option=com_osproperty&task=plugin_list");
			break;
			case "plugin_install":
				OspropertyPlugin::install();
			break;
		}
	}
	
	/**
	 * Install payment plugin
	 *
	 */
	function install(){
		global $jinput, $mainframe;
		$db = & JFactory::getDBO();
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.archive');
		$db = JFactory::getDBO();
		if (version_compare(JVERSION, '3.4.0', 'ge'))
		{
			$plugin = $jinput->files->get('plugin_package', null, 'raw');
		}
		else
		{
			$plugin = $jinput->files->get('plugin_package', null, 'none');
		}
		if ($plugin['error'] || $plugin['size'] < 1)
		{
			$jinput->set('msg', JText::_('Upload plugin package error'));
			$mainframe->redirect("index.php?option=com_osproperty&task=plugin_list",$jinput->getString('msg'));
		}
		$config = new JConfig();
		$dest = $config->tmp_path . '/' . $plugin['name'];
		//$uploaded = JFile::upload($plugin['tmp_name'], $dest);

		if (version_compare(JVERSION, '3.4.4', 'ge'))
		{
			$uploaded = JFile::upload($plugin['tmp_name'], $dest , false, true);
		}else{
			$uploaded = JFile::upload($plugin['tmp_name'], $dest);
		}


		if (!$uploaded)
		{
            $jinput->set('msg', JText::_('Upload plugin package fail'));
			$mainframe->redirect("index.php?option=com_osproperty&task=plugin_list",$jinput->getString('msg'));
		}


		// Temporary folder to extract the archive into
		$tmpdir = uniqid('install_');
		$extractdir = JPath::clean(dirname($dest) . '/' . $tmpdir);
		$result = JArchive::extract($dest, $extractdir);
		if (!$result)
		{
            $jinput->set('msg', JText::_('Extract plugin error'));
			$mainframe->redirect("index.php?option=com_osproperty&task=plugin_list",$jinput->getString('msg'));
		}
		$dirList = array_merge(JFolder::files($extractdir, ''), JFolder::folders($extractdir, ''));
		if (count($dirList) == 1)
		{
			if (JFolder::exists($extractdir . '/' . $dirList[0]))
			{
				$extractdir = JPath::clean($extractdir . '/' . $dirList[0]);
			}
		}
		//Now, search for xml file
		$xmlfiles = JFolder::files($extractdir, '.xml$', 1, true);
		if (empty($xmlfiles))
		{
			$jinput->set('msg', JText::_('Could not find XML file'));
			$mainframe->redirect("index.php?option=com_osproperty&task=plugin_list",$jinput->getString('msg'));
		}
		$file = $xmlfiles[0];
		$root = JFactory::getXML($file, true);
		$pluginType = $root->attributes()->type;
		$pluginGroup = $root->attributes()->group;
		if ($root->getName() !== 'install')
		{
            $jinput->set('msg', JText::_('Invalid XML file'));
			$mainframe->redirect("index.php?option=com_osproperty&task=plugin_list",$jinput->getString('msg'));
		}
		if ($pluginType != 'osplugin')
		{
            $jinput->set('msg', JText::_('Invalid OS Property payment plugin'));
			$mainframe->redirect("index.php?option=com_osproperty&task=plugin_list",$jinput->getString('msg'));
		}
		
		$name = (string) $root->name;
		$title = (string) $root->title;
		$author = (string) $root->author;
		$creationDate = (string) $root->creationDate;
		$copyright = (string) $root->copyright;
		$license = (string) $root->license;
		$authorEmail = (string) $root->authorEmail;
		$authorUrl = (string) $root->authorUrl;
		$version = (string) $root->version;
		$description = (string) $root->description;
		$row = & JTable::getInstance('Plugins', 'OspropertyTable') ;
		$sql = 'SELECT id FROM #__osrs_plugins WHERE name="'.$name.'"';
		$db->setQuery($sql);
		$pluginId = (int) $db->loadResult();
		if ($pluginId)
		{
			$row->load($pluginId);
			$row->name = $name;
			$row->title = $title;
			$row->author = $author;
			$row->creation_date = $creationDate;
			$row->copyright = $copyright;
			$row->license = $license;
			$row->author_email = $authorEmail;
			$row->author_url = $authorUrl;
			$row->version = $version;
			$row->description = $description;
		}
		else
		{
			$row->name = $name;
			$row->title = $title;
			$row->author = $author;
			$row->creation_date = $creationDate;
			$row->copyright = $copyright;
			$row->license = $license;
			$row->author_email = $authorEmail;
			$row->author_url = $authorUrl;
			$row->version = $version;
			$row->description = $description;
			$row->published = 0;
			$row->ordering = $row->getNextOrder('published=1');
		}
		
		$row->store();
		$pluginDir = JPATH_ROOT . '/components/com_osproperty/plugins';
		JFile::move($file, $pluginDir . '/' . basename($file));
		$files = $root->files->children();
		for ($i = 0, $n = count($files); $i < $n; $i++)
		{
			$file = $files[$i];
			if ($file->getName() == 'filename')
			{
				$fileName = $file;
				if (!JFile::exists($pluginDir . '/' . $fileName))
				{
					JFile::copy($extractdir . '/' . $fileName, $pluginDir . '/' . $fileName);
				}
			}elseif ($file->getName() == 'logo')
			{
				$fileName = $file;
				if (!JFile::exists($pluginDir . '/' . $fileName))
				{
					JFile::copy($extractdir . '/' . $fileName,JPATH_ROOT . '/images/osproperty/plugins/' . $fileName);
				}
			}
			elseif ($file->getName() == 'folder')
			{
				$folderName = $file;
				if (JFolder::exists($extractdir . '/' . $folderName))
				{
					JFolder::move($extractdir . '/' . $folderName, $pluginDir . '/' . $folderName);
				}
			}
		}
		JFolder::delete($extractdir);
				
		$msg = JText::_('OS_PAYMENT_PLUGIN_HAS_BEEN_INSTALLED_SUCCESSFULLY');
		$mainframe->redirect("index.php?option=com_osproperty&task=plugin_list",$msg);
	}
	
	/**
	 * Save plugin
	 *
	 * @param unknown_type $option
	 * @param unknown_type $save
	 * @return unknown
	 */
	function plugin_save($option,$save){
		global $jinput, $mainframe;
		$id = $jinput->getInt('id',0);
		$row = & JTable::getInstance('Plugins', 'OspropertyTable');
		$data = $jinput->post->getArray();
		if ($id > 0)
			$row->load($id);									
		if (!$row->bind($data)) {
			return false;
		}				
		//Save parameters
		$params		= $jinput->get( 'params', array(), 'array' );
		if (is_array($params))
		{
			$txt = array ();
			foreach ($params as $k => $v) {
				if (is_array($v)) {
					$v = implode(',', $v);	
				}
				$v =  str_replace("\r\n", '@@', $v) ;				
				$txt[] = "$k=\"$v\"";
			}
			$row->params = implode("\n", $txt);
		}
		if (!$row->store()) {
			return false;
		}				
		$data['id'] = $row->id ;
		
		if($save == 1){
			$mainframe->redirect("index.php?option=com_osproperty&task=plugin_list",JText::_('OS_ITEM_HAS_BEEN_SAVED'));
		}else{
			$mainframe->redirect("index.php?option=com_osproperty&task=plugin_edit&cid[]=$row->id",JText::_('OS_ITEM_HAS_BEEN_SAVED'));
		}
	}
	
	/**
	 * Remove payment plugins
	 *
	 * @param unknown_type $cid
	 */
	function plugin_remove($cid){
		global $jinput, $mainframe;
		jimport('joomla.filesystem.folder') ;
		jimport('joomla.filesystem.file') ;
		$row = & JTable::getInstance('Plugins', 'OsAppTable');				
		$pluginDir = JPATH_ROOT.DS.'components'.DS.'com_osproperty'.DS.'plugins' ;
		foreach ($cid as $id) {
			$row->load($id);
			$name = $row->name ;			
			$file = $pluginDir.DS.$name.'.xml' ;
			$root = JFactory::getXML($file);
			$files = $root->files->children();
			//$pluginDir = JPATH_ROOT . '/components/com_osproperty/plugins';
			for ($i = 0, $n = count($files); $i < $n; $i++)
			{
				$file = $files[$i];
				if ($file->getName() == 'filename')
				{
					$fileName = $file;
					if (JFile::exists($pluginDir . '/' . $fileName))
					{
						JFile::delete($pluginDir . '/' . $fileName);
					}
				}
				elseif ($file->getName() == 'folder')
				{
					$folderName = $file;
					if ($folderName)
					{
						if (JFolder::exists($pluginDir . '/' . $folderName))
						{
							JFolder::delete($pluginDir . '/' . $folderName);
						}
					}
				}
			}
			$files = $root->languages->children();
			$languageFolder = JPATH_ROOT . '/language';
			for ($i = 0, $n = count($files); $i < $n; $i++)
			{
				$fileName = $files[$i];
				$pos = strpos($fileName, '.');
				$languageSubFolder = substr($fileName, 0, $pos);
				if (JFile::exists($languageFolder . '/' . $languageSubFolder . '/' . $fileName))
				{
					JFile::delete($languageFolder . '/' . $languageSubFolder . '/' . $fileName);
				}
			}
			JFile::delete($pluginDir . '/' . $name . '.xml');
			$row->delete();	
		}				
		$mainframe->enqueueMessage(JText::_("OS_ITEMS_HAS_BEEN_DELETED"),'message');
		OspropertyPlugin::plugin_list($option);
	}
	
	/**
	 * change order price group
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 * @param unknown_type $direction
	 */
	function plugin_order($option,$id,$direction){
		global $jinput, $mainframe;
		$mainframe = JFactory::getApplication();
		$row = &JTable::getInstance('Plugins','OsAppTable');
		$row->load($id);
		$row->move( $direction);
		$row->reorder();
		$mainframe->enqueueMessage(JText::_("OS_NEW_ORDERING_SAVED"),'message');
		OspropertyPlugin::plugin_list($option);
	}
	
	/**
	 * save new order
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 */
	function plugin_saveorder($option,$cid){
		global $jinput, $mainframe;
		$mainframe = JFactory::getApplication();
		$msg = JText::_("OS_NEW_ORDERING_SAVED");
		$order 	= $jinput->get( 'order', array(), 'array' );
		JArrayHelper::toInteger($order);
		$row = &JTable::getInstance('Plugins','OsAppTable');
		
		// update ordering values
		for( $i=0; $i < count($cid); $i++ )
		{
			$row->load( (int) $cid[$i] );
			if ($row->ordering != $order[$i]){
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$msg = JText::_("OS_ERROR_SAVING_ORDERING");
					break;
				}
			}
		}
		// execute updateOrder
		$row->reorder();
		$mainframe->enqueueMessage($msg,'message');
		OspropertyPlugin::plugin_list($option);
	}
	
	/**
	 * List all plugins
	 *
	 * @param unknown_type $option
	 */
	function plugin_list($option){
		global $jinput, $mainframe;
		$db = JFactory::getDbo();
		// filte sort
		$filter_order 				= $mainframe->getUserStateFromRequest($option.'.plugin.filter_order','filter_order','ordering','string');
		$filter_order_Dir 			= $mainframe->getUserStateFromRequest($option.'.plugin.filter_order_Dir','filter_order_Dir','','string');
		$lists['order'] 			= $filter_order;
		$lists['order_Dir'] 		= $filter_order_Dir;
		$order_by 					= " ORDER BY $filter_order $filter_order_Dir";
		$limitstart = $jinput->getInt('limitstart',0);
		$limit = $jinput->getInt('limit',20);
		$keyword = $jinput->getString('keyword','');
		$query = "Select count(id) from #__osrs_plugins where 1=1";
		if($keyword != ""){
			$query .= " and name like '%$keyword%'";
		}
		$db->setQuery($query);
		$count = $db->loadResult();
		jimport('joomla.html.pagination');
		$pageNav = new JPagination($count,$limitstart,$limit);
		$query = "Select * from #__osrs_plugins where 1=1";
		if($keyword != ""){
			$query .= " and name like '%$keyword%'";
		}
		$query .= $order_by;
		$db->setQuery($query,$pageNav->limitstart,$pageNav->limit);
		$rows = $db->loadObjectList();
		HTML_OspropertyPlugin::listPlugins($option,$rows,$pageNav,$lists);
	}
	
	/**
	 * Plugin modification
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	function plugin_modify($option, $id){
		global $jinput, $mainframe;
		$db = JFactory::getDbo();
		$db->setQuery("Select * from #__osrs_plugins where id = '$id'");
		$item = $db->loadObject();
		$optionState[] = JHTML::_('select.option',1,JText::_('OS_PUBLISH'));
		$optionState[] = JHTML::_('select.option',0,JText::_('OS_UNPUBLISH'));
		$lists['published'] = JHtml::_('select.genericlist',$optionState,'published','class="inputbox"','value','text',$row->published);
		
		$registry = new JRegistry();
		$registry->loadString($item->params);
		$data = new stdClass();
		$data->params = $registry->toArray();
		$form = JForm::getInstance('osproperty', JPATH_ROOT . '/components/com_osproperty/plugins/' . $item->name . '.xml', array(), false, '//config');
		$form->bind($data);
		
		HTML_OspropertyPlugin::editPlugin($option,$item,$lists,$form);
	}
	
	/**
	 * Plugin change state
	 *
	 * @param unknown_type $option
	 * @param unknown_type $cid
	 * @param unknown_type $state
	 */
	function plugin_state($option,$cid,$state){
		global $jinput, $mainframe;
		$db 		= JFactory::getDBO();
		if(count($cid)>0)	{
			$cids 	= implode(",",$cid);
			$db->setQuery("UPDATE #__osrs_plugins SET `published` = '$state' WHERE id IN ($cids)");
			$db->query();
		}
		$mainframe->enqueueMessage(JText::_("OS_STATUS_CHANGED"),'message');
		OspropertyPlugin::plugin_list($option);
	}
}
?>