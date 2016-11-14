<?php
// namespace components\com_jmap\views\sitemap;
/**
 * @package JMAP::SITEMAP::components::com_jmap
 * @subpackage views
 * @subpackage sitemap
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 * Main view class
 *
 * @package JMAP::SITEMAP::components::com_jmap
 * @subpackage views
 * @subpackage sitemap
 * @since 1.0
 */
class JMapViewSitemap extends JMapView {
	/**
	 * Display the sitemap
	 * @access public
	 * @return void
	 */
	public function display($tpl = null) {
		$app = JFactory::getApplication ();
		$menu = $app->getMenu ();
		$document = $this->document;
		$this->menuname = $menu->getActive ();
		$this->cparams = $this->getModel ()->getState ( 'cparams' );
		if (isset ( $this->menuname )) {
			$this->menuname = $this->menuname->title;
		}
		
		// Call by cache handler get no params, so recover from model state
		if(!$tpl) {
			$tpl = $this->getModel ()->getState ( 'documentformat' );
		}
		
		// Accordion della sitemap
		if($this->getModel ()->getState ( 'cparams' )->get('includejquery', 1)) {
			JHtml::_('jquery.framework');
		}
		
		// Check if enabled the draggable mindmap sitemap
		$draggableSitemap = $this->cparams->get('draggable_sitemap', 0);
		$mindMapSitemap = $this->cparams->get('sitemap_html_template', '') == 'mindmap';
		if($draggableSitemap && $mindMapSitemap) {
			$this->loadJQueryUI($document);
		}
		
		$document->addScript ( JURI::root(true) . '/components/com_jmap/js/jquery.treeview.js' );
		// Manage sitemap layout
		if(!$this->cparams->get('show_icons', 1)) {
			$document->addStyleDeclaration('span.folder{cursor:pointer}');
		} else {
			$document->addStyleSheet ( JURI::root(true) . '/components/com_jmap/js/jquery.treeview.css' );
			if($sitemapTemplate = $this->cparams->get('sitemap_html_template', null)) {
				$document->addStyleSheet ( JURI::root(true) . '/components/com_jmap/js/jquery.treeview-' . $sitemapTemplate . '.css' );
			}
		}
		
		// Indentation margin side
		$this->marginSide = 'margin-left:';
		
		// Detect if the language is RTL and if so load overrides
		$this->isRTL = JFactory::getLanguage()->isRTL();
		if($this->isRTL && $this->cparams->get('sitemap_html_template') != 'mindmap') {
			if($this->cparams->get('show_icons', 1)) {
				$document->addStyleSheet ( JURI::root(true) . '/components/com_jmap/js/rtl/jquery.treeview.css' );
				if($sitemapTemplate = $this->cparams->get('sitemap_html_template', null)) {
					$document->addStyleSheet ( JURI::root(true) . '/components/com_jmap/js/rtl/jquery.treeview-' . $sitemapTemplate . '.css' );
				}
			}
			$this->marginSide = 'margin-right:';
		}
		
		// Inject JS domain vars
		$document->addScriptDeclaration("
					var jmapExpandAllTree = " . $this->getModel ()->getState ( 'cparams' )->get('show_expanded', 0) . ";
					var jmapExpandLocation = '" . $this->getModel ()->getState ( 'cparams' )->get('expand_location', 'location') . "';
					var jmapAnimated = " . $this->getModel ()->getState ( 'cparams' )->get('animated', 1) . ";
					var jmapAnimateSpeed = " . $this->getModel ()->getState ( 'cparams' )->get('animate_speed', 200) . ";
					var jmapDraggableSitemap = " . $draggableSitemap . ";
					var jmapLinkableCatsSources = {};
					var jmapMergeMenuTree = {};
					jQuery(function($){
						$('ul.jmap_filetree li a:empty').parent('li').css('display', 'none');
					});
				");
		$this->data = $this->get ( 'SitemapData' );
		$this->application = $app;
		$this->document = $document;
		
		$uriInstance = JURI::getInstance();
		if($this->cparams->get('append_livesite', true)) {
			$customHttpPort = trim($this->cparams->get('custom_http_port', ''));
			$getPort = $customHttpPort ? ':' . $customHttpPort : '';
			
			$customDomain = trim($this->cparams->get('custom_sitemap_domain', ''));
			$getDomain = $customDomain ? rtrim($customDomain, '/') : rtrim($uriInstance->getScheme() . '://' . $uriInstance->getHost(), '/');

			$this->liveSite = rtrim($getDomain . $getPort, '/');
		} else {
			$this->liveSite = null;
		}
		
		// Add meta info
		$this->_prepareDocument();
		
		parent::display ( $tpl );
	}
	
	/**
	 * Prepares the document
	 */
	protected function _prepareDocument() {
		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$menus = $app->getMenu();
		$title = null;
	
		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if(is_null($menu)) {
			return;
		}
	
		$this->params = new JRegistry;
		$this->params->loadString($menu->params);
	
		$title = $this->params->get('page_title', 'Sitemap');
		
		// Joomla 3.2+ support
		if(method_exists($app, 'get')) {
			if ($app->get('sitename_pagetitles', 0) == 1) {
				$title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
			}
			elseif ($app->get('sitename_pagetitles', 0) == 2) {
				$title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
			}
		}
		$document->setTitle($title);
	
		if ($this->params->get('menu-meta_description')) {
			$document->setDescription($this->params->get('menu-meta_description'));
		}
	
		if ($this->params->get('menu-meta_keywords')) {
			$document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}
	
		if ($this->params->get('robots')) {
			$document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}