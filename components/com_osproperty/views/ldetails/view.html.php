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

class OspropertyViewLdetails extends JViewLegacy
{

    protected $page;

    function display($tpl = null)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        global $mainframe, $configClass, $ismobile, $lang_suffix, $languages, $jinput;
        $option = JFactory::getApplication()->input->getString('option', 'com_osproperty');

        $translatable = JLanguageMultilang::isEnabled() && count($languages);
        
        
        $configs = OSPHelper::getGonfigurations();


        $id = $jinput->getInt('id', 0);
        if ($id == 0)
        {
            JError::raiseError(404, JText::_('OS_PROPERTY_IS_NOT_AVAILABLE'));
        }
       
       

        $model = $this->getModel();
      
        
        $propertyObject = $model->getItem();
        
        
        $propertyObject->setConfigClass($configClass);
        $propertyObject->remakeData($configClass);




        $property = $propertyObject->getPropertyObject();
       
        
        
          if (($property->published == 0) or ( $property->approved == 0))
        {
            JError::raiseError(404, JText::_('OS_PROPERTY_IS_NOT_AVAILABLE'));
        }
        $document = JFactory::getDocument();

        //find Itemid of property
        $needs = array();
        $needs[] = "property_details";
        $needs[] = $id;
        $property_item_id = OSPRoute::getItemid($needs);


        $show_meta = 1;
        $itemid = $jinput->getInt('Itemid', 0);

        if ($itemid != $property_item_id)
        {
            foreach ($document->_links as $k => $array)
            {
                if ($array['relation'] == 'canonical')
                {
                    unset($document->_links[$k]);
                }
            }
            $plink = JUri::getInstance()->toString(array('scheme', 'user', 'pass', 'host')) . JRoute::_('index.php?option=com_osproperty&task=property_details&id=' . $id . '&Itemid=' . $property_item_id);
            $document->addCustomTag('<link rel="canonical" content="' . $plink . '" />');
        }

        if ($itemid > 0)
        {
            $menus = JSite::getMenu();
            $current_menu = $menus->getItem($itemid);
            $current_menu_query = $current_menu->query;
            $view = $current_menu_query['view'];
            if ($view == "ldetails")
            {
                $current_menu_params = $current_menu->params;
                //$show_page_heading = $current_menu_params['show_page_heading'];
                $page_heading = $current_menu_params['page_heading'];
                if ($page_heading != "")
                {
                    $property->pro_name = $page_heading;
                }
                $page_title = $current_menu_params['page_title'];
                if ($page_title != "")
                {
                    //page title
                    OSPHelper::generateHeading(1, $page_title);
                } elseif (OSPHelper::getLanguageFieldValue($property, 'pro_browser_title') != "")
                {
                    OSPHelper::generateHeading(1, OSPHelper::getLanguageFieldValue($property, 'pro_browser_title'));
                } else
                {
                    //page title
                    OSPHelper::generateHeading(1, OSPHelper::getLanguageFieldValue($property, 'pro_name'));
                }

                $meta_description = $current_menu_params['menu-meta_description'];
                if ($meta_description != "")
                {
                    $document->setMetaData("description", $meta_description);
                    $show_meta = 0;
                }
            } elseif (OSPHelper::getLanguageFieldValue($property, 'pro_browser_title') != "")
            {
                OSPHelper::generateHeading(1, OSPHelper::getLanguageFieldValue($property, 'pro_browser_title'));
            } else
            {
                //page title
                OSPHelper::generateHeading(1, OSPHelper::getLanguageFieldValue($property, 'pro_name'));
            }
        } elseif (OSPHelper::getLanguageFieldValue($property, 'pro_browser_title') != "")
        {
            OSPHelper::generateHeading(1, OSPHelper::getLanguageFieldValue($property, 'pro_browser_title'));
        } else
        {
            //page title
            OSPHelper::generateHeading(1, OSPHelper::getLanguageFieldValue($property, 'pro_name'));
        };

        //store this property into cookie
        $session = JFactory::getSession();
        $session->set('pid', $property->id); //add Property ID into session
        $recent_properties_viewed = array();
        $recent_properties_viewed_str = $session->get('recent_properties_viewed', ''); //$_COOKIE['recent_properties_viewed'];
        if ($recent_properties_viewed_str != "")
        {
            $recent_properties_viewed = explode(",", $recent_properties_viewed_str);
        }
        if (count($recent_properties_viewed) == 0)
        {
            $recent_properties_viewed[] = $id;
        } else
        {
            if (!in_array($id, $recent_properties_viewed))
            {
                $recent_properties_viewed[] = $id;
            } else
            {
                $key = array_search($id, $recent_properties_viewed);
                unset($recent_properties_viewed[$key]);
                $recent_properties_viewed[] = $id;
            }
        }
        $session->set('recent_properties_viewed', implode(",", $recent_properties_viewed));
        $owner = $propertyObject->isOwner();
        
        $propertyObject->showMeta($show_meta);

        $access = $property->access;
        if (!in_array($access, JFactory::getUser()->getAuthorisedViewLevels()) and ( !HelperOspropertyCommon::isOwner($property->id)))
        {
            $mainframe->redirect(JURI::root(), JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
        }
//        $pathway = $propertyObject->getPathway($configClass);
        $propertyObject->getPathway($configClass);
        $propertyObject->hit();

        $property->core_fields = OSPHelper::showCoreFields($property);
        $this->option = $option;
        $this->property = $property;
        $this->configs = $configs;
        $this->owner = $owner;

        //HTML_OspropertyListing::propertyDetails($option, $property, $configs, $owner);

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

    public static function _getSchoolData($values)
    {
        $key = $values['key'];
        $radius = $values['radius'];
        $min = $values['min'];
        $lat = $values['latitude'];
        $lon = $values['longitude'];
        $zip = $values['zip'];
        $city = urlencode($values['city']);
        $state = $values['state'];

        $query_string = "";
        $query_string .= "key=" . $key;
        $query_string .= "&v=3";
        $query_string .= "&f=system.multiCall";
        $query_string .= "&resf=php";

        // do the school search
        $query_string .= "&methods[0][f]=schoolSearch";
        $query_string .= "&methods[0][sn]=sf";
        $query_string .= "&methods[0][key]=" . $key;
        if ($lat != 0 && $lon != 0)
        {
            $query_string .= "&methods[0][latitude]=" . $lat;
            $query_string .= "&methods[0][longitude]=" . $lon;
            $query_string .= "&methods[0][distance]=" . $radius;
        } elseif (($lat = 0 && $lon = 0) && $zip != 0)
        {
            $query_string .= "&methods[0][zip]=" . $zip;
        }
        $query_string .= "&methods[0][minResult]=" . $min;
        $query_string .= "&methods[0][fid]=F1";

        // do the branding search
        $query_string .= "&methods[1][f]=gbd";
        $query_string .= "&methods[1][city]=" . $city;
        if ($state)
            $query_string .= "&methods[1][state]=" . $state;
        $query_string .= "&methods[1][sn]=sf";
        $query_string .= "&methods[1][key]=" . $key;
        $query_string .= "&methods[1][fid]=F2";

        $result = self::_curlContents($query_string);

        $schoolinfo = unserialize($result);

        return $schoolinfo;
    }

}
