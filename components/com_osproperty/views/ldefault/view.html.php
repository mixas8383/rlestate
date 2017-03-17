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

class OspropertyViewLdefault extends JViewLegacy
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

        $model = $this->getModel();


        global $mainframe, $configs, $configClass, $lang_suffix;
        $db = JFactory::getDBO();

        $document = JFactory::getDocument();
        OSPHelper::generateHeading(1, $configClass['general_bussiness_name']);

        if ($configClass['show_random_feature'] == 1)
        {
            $query = "Select a.*, b.state_name$lang_suffix as state_name,e.type_name$lang_suffix as type_name from #__osrs_properties as a"
                    . " inner join #__osrs_states as b on a.state = b.id"
                    . " inner join #__osrs_types as e on e.id = a.pro_type"
                    . " where a.published = '1' and a.approved = '1' and b.published = '1' and e.published = '1' and a.isFeatured = '1' order by rand() limit 1";
            $db->setQuery($query);
            $property = $db->loadObject();
            if ($property->id > 0)
            {
                $db->setQuery("Select * from #__osrs_photos where pro_id = '$property->id'");
                $property->photos = $db->loadObjectList();
            }
        }

        $lists = array();

        $lists['country'] = HelperOspropertyCommon::makeCountryList('', 'country_id', 'onchange="change_country_state(this.value)"', JText::_('OS_SELECT_COUNTRY'), 'style="width:150px;"');

        if (OSPHelper::userOneState())
        {
            $lists['state'] = "<input type='hidden' name='state_id' id='state_id' value='" . OSPHelper::returnDefaultState() . "'/>";
        } else
        {
            $lists['state'] = HelperOspropertyCommon::makeStateList('', '', 'state_id', 'onchange="javascript:loadCity(this.value,\'\')"', JText::_('OS_SELECT_STATE'), '');
        }

        $default_state = 0;
        if (OSPHelper::userOneState())
        {
            $default_state = OSPHelper::returnDefaultState();
        } else
        {
            $default_state = 0;
        }
        $lists['city'] = HelperOspropertyCommon::loadCity($option, $default_state, 0);

        //property types
        $db->setQuery("SELECT id as value,type_name$lang_suffix as text FROM #__osrs_types where published = '1' ORDER BY ordering");
        $typeArr = $db->loadObjectList();
        array_unshift($typeArr, JHTML::_('select.option', '', JText::_('OS_PROPERTY_TYPE')));
        $lists['type'] = JHTML::_('select.genericlist', $typeArr, 'property_type', 'class="input-large"', 'value', 'text');

        $this->property = $property;
        $this->lists = $lists;
        $this->configs = $configs;
        //HTML_OspropertyDefault::defaultLayout($option, $property, $lists, $configs);

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
