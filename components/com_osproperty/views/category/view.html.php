<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2015 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct accees
defined('_JEXEC') or die('restricted aceess');

// import Joomla view library
jimport('joomla.application.component.view');

if (!class_exists('SppagebuilderHelperSite'))
{
    require_once JPATH_ROOT . '/components/com_sppagebuilder/helpers/helper.php';
}

class OspropertyViewCategory extends JViewLegacy
{

    protected $page;

    function display($tpl = null)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $option = JFactory::getApplication()->input->get('option');
//        ini_set('display_errors', 1);
//        ini_set('display_startup_errors', 1);
//        error_reporting(E_ALL);
        global $mainframe, $jinput, $configClass;
        $cid = $jinput->getInt('cid', 0);
        $id = $jinput->getInt('id', 0);
       global $mainframe, $jinput, $configClass;
        $db = JFactory::getDBO();

        $user = JFactory::getUser();
        //access
        
        
        $access = ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';

        $db->setQuery("Select count(id) from #__osrs_categories where id = '$id' and published = '1' $access");
        $count = $db->loadResult();
         if(isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] == 'Debug')
         {
             echo '<pre>'.__FILE__.' -->>| <b> Line </b>'.__LINE__.'</pre><pre>';
             print_r($count);
             die;
             
         }
        
        
        if ($count == 0)
        {
            $mainframe->redirect("index.php", JText::_('OS_YOU_DO_NOT_HAVE_PERMISSION_TO_GO_TO_THIS_AREA'));
        }
        $db->setQuery("Select * from #__osrs_categories where id = '$id' and published = '1' $access");
        $cat = $db->loadObject();

        //pathway
        $pathway = $mainframe->getPathway();
        if ($cat->parent_id > 0)
        {
            $db->setQuery("Select category_name from #__osrs_categories where id = '$cat->parent_id'");
            $parent_category_name = $db->loadResult();
            $pathway->addItem($parent_category_name, Jroute::_('index.php?option=com_osproperty&task=category_details&id=' . $cat->parent_id . '&Itemid=' . $jinput->getInt('Itemid', 0)));
        }
        $pathway->addItem($cat->category_name, Jroute::_('index.php?option=com_osproperty&task=category_details&id=' . $cat->id . '&Itemid=' . $jinput->getInt('Itemid', 0)));

        $document = JFactory::getDocument();
        $document->setTitle($configClass['general_bussiness_name'] . " - " . JText::_('OS_CATEGORY') . " - " . OSPHelper::getLanguageFieldValue($cat, 'category_name'));

        if ($cat->category_meta != "")
        {
            $document->setMetaData("description", $cat->category_meta);
        }

        //get the subcates
        $query = "select * from #__osrs_categories where published = '1' and parent_id = '$id' $access order by ordering";
        $db->setQuery($query);
        $subcats = $db->loadObjectList();
        if (count($subcats) > 0)
        {
            for ($i = 0; $i < count($subcats); $i++)
            {
                $row = $subcats[$i];
                $total = 0;
                //$db->setQuery("Select count(id) from #__osrs_properties where approved = '1' and published = '1' and id in (select pid from #__osrs_property_categories where category_id = '$row->id')");
                ///$row->nlisting = $db->loadResult();
                $total = OspropertyCategories::countProperties($row->id, $total);
                $row->nlisting = $total;
            }
        }

       // HTML_OspropertyCategories::categoryDetailsForm($option, $cat, $subcats);

        $this->option = $option;
        $this->cat = $cat;
        $this->subcats = $subcats;
        
        $this->_prepareDocument();

        parent::display($tpl);
    }

    protected function _prepareDocument()
    {
       
        $config = JFactory::getConfig();
        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();
        $menus = $app->getMenu();
        $menu = $menus->getActive();
        $title = '';

        $menu = $menus->getActive();

        //Title
        if (isset($meta['title']) && $meta['title'])
        {
            $title = $meta['title'];
        } else
        {
            if ($menu)
            {
                if ($menu->params->get('page_title', ''))
                {
                    $title = $menu->params->get('page_title');
                } else
                {
                    $title = $menu->title;
                }
            }
        }

        //Include Site title
        $sitetitle = $title;
        if ($config->get('sitename_pagetitles') == 2)
        {
            $sitetitle = $title . ' | ' . $config->get('sitename');
        } elseif ($config->get('sitename_pagetitles') == 1)
        {
            $sitetitle = $config->get('sitename') . ' | ' . $title;
        }

        $doc->setTitle($sitetitle);

        $this->document->addCustomTag('<meta content="website" property="og:type"/>');
        $this->document->addCustomTag('<meta content="' . JURI::current() . '" property="og:url" />');

        if ($this->page && $this->page->og_title)
        {
            $og_title = $this->page->og_title;
        }
        if (isset($og_title))
        {
            $this->document->addCustomTag('<meta content="' . $og_title . '" property="og:title" />');
        } else
        {
            $doc->addCustomTag('<meta content="' . $title . '" property="og:title" />');
        }
        if ($this->page && $this->page->og_image)
        {
            $og_image = $this->page->og_image;
        }

        if (isset($og_image))
        {
            $this->document->addCustomTag('<meta content="' . JURI::root() . $og_image . '" property="og:image" />');
            $this->document->addCustomTag('<meta content="1200" property="og:image:width" />');
            $this->document->addCustomTag('<meta content="630" property="og:image:height" />');
        }
        if ($this->page && $this->page->og_description)
        {
            $og_description = $this->page->og_description;
        }

        if (isset($og_description))
        {
            $this->document->addCustomTag('<meta content="' . $og_description . '" property="og:description" />');
        }

        if ($menu)
        {

            if ($menu->params->get('menu-meta_description'))
            {
                $this->document->setDescription($menu->params->get('menu-meta_description'));
            }

            if ($menu->params->get('menu-meta_keywords'))
            {
                $this->document->setMetadata('keywords', $menu->params->get('menu-meta_keywords'));
            }

            if ($menu->params->get('robots'))
            {
                $this->document->setMetadata('robots', $menu->params->get('robots'));
            }
        }
    }

}
