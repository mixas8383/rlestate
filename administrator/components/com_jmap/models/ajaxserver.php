<?php
//namespace components\com_jmap\models; 
/** 
 * @package JMAP::AJAXSERVER::components::com_jmap 
 * @subpackage models
 * @author Joomla! Extensions Store
 * @copyright (C)2015 Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.filesystem.file');

/**
 * Ajax Server model responsibilities
 *
 * @package JMAP::AJAXSERVER::components::com_jmap  
 * @subpackage models
 * @since 1.0
 */
interface IAjaxserverModel {
	public function loadAjaxEntity($id, $param, $DIModels) ;
}

/** 
 * Classe che gestisce il recupero dei dati per il POST HTTP
 * @package JMAP::AJAXSERVER::components::com_jmap  
 * @subpackage models
 * @since 1.0
 */
class JMapModelAjaxserver extends JMapModel implements IAjaxserverModel {
	/**
	 * Check if an extension is currently installed on Joomla system and answer accordingly with an encoded object
	 *
	 * @access private
	 * @param string $tableName
	 * @param Object[] $additionalModels Array for additional injected models type hinted by interface
	 * @return Object
	 */
	private function checkExtension($extensionName, $additionalModels = null) {
		// Query to check
		$query = "SELECT " . $this->_db->quoteName('extension_id') . 
				 "\n FROM " . $this->_db->quoteName('#__extensions') . 
				 "\n WHERE " . $this->_db->quoteName('element') . " = " . $this->_db->Quote($extensionName);
		$this->_db->setQuery($query);
		$extensionID = $this->_db->loadResult();

		$response = (object) array('extensionFound' => (bool) $extensionID);

		return $response;
	}

	/**
	 * Check if an extension is currently installed on Joomla system and answer accordingly with an encoded object
	 *
	 * @access private
	 * @param string $tableName
	 * @param Object[] $additionalModels Array for additional injected models type hinted by interface
	 * @return Object
	 */
	private function loadDataSources($additionalModels = null) {
		// Response JSON object
		$response = new stdClass();

		try {
			// Resource Action detection dall'HTTP method name
			$HTTPMethod = $this->app->input->server->get('REQUEST_METHOD', 'GET');

			if ($HTTPMethod !== 'GET') {
				throw new JMapException(JText::_('COM_JMAP_INVALID_RESTFUL_METHOD'), 'error');
			}
			// Default for published data sources
			$where[] = "\n v.published = 1";

			$query = "SELECT v.id, v.type, v.name" .
					"\n FROM #__jmap AS v" .
					"\n WHERE " . implode(' AND ', $where) .
					"\n ORDER BY v.ordering ASC";
			$this->_db->setQuery ( $query );

			$response->datasources = $this->_db->loadObjectList ();
			if ($this->_db->getErrorNum ()) {
				throw new JMapException(JText::sprintf('COM_JMAP_ERROR_RETRIEVING_DATA', $this->_db->getErrorMsg()), 'error');
			}

			// All completed succesfully
			$response->result = true;
		} catch (JMapException $e) {
			$response->result = false;
			$response->exception_message = $e->getMessage();
			return $response;
		} catch (Exception $e) {
			$jmapException = new JMapException(JText::sprintf('COM_JMAP_ERROR_RETRIEVING_DATA', $e->getMessage()), 'error');
			$response->result = false;
			$response->exception_message = $jmapException->getMessage();
			return $response;
		}

		return $response;
	}
	
	/**
	 * Fetch SEO stats from remote services both Google and Alexa,
	 * based on Seo stats lib that is able to calculate Google Page rank
	 *
	 *
	 * @access private
	 * @param Object[] $additionalModels Array for additional injected models type hinted by interface
	 * @return Object
	 */
	private function fetchSeoStats($additionalModels = null) {
		// Response JSON object
		$response = new stdClass ();

		// Set the resulting array
		$pageRanksArray = array (
				'googlerank' => JText::_ ( 'COM_JMAP_NA' ),
				'alexarank' => JText::_ ( 'COM_JMAP_NA' ),
				'alexabacklinks' => JText::_ ( 'COM_JMAP_NA' ),
				'alexapageloadtime' => JText::_ ( 'COM_JMAP_NA' ),
				'googleindexedlinks' => JText::_ ( 'COM_JMAP_NA' ),
				'alexagraph' => ''
		);
		
		try {
			if (! function_exists ( 'curl_init' )) {
				throw new JMapException ( JText::_ ( 'COM_JMAP_CURL_NOT_SUPPORTED' ), 'error' );
			}

			if (1 == ini_get ( 'safe_mode' ) || 'on' === strtolower ( ini_get ( 'safe_mode' ) )) {
				throw new JMapException ( JText::_ ( 'COM_JMAP_PHP_SAFEMODE_ON' ), 'error' );
			}

			// API REQUEST, define target URL, site default or custom url
			$siteUrl = JUri::root(false);
			$customUrl = JComponentHelper::getParams('com_jmap')->get('seostats_custom_link', null);
			$url = $customUrl ? $customUrl : $siteUrl;

			// Create a new SEOstats instance.
			$seostats = new JMapSeostats ();

			// Bind the URL to the current SEOstats instance.
			if ($seostats->setUrl ( $url )) {
				$pageRanksArray ['alexarank'] = JMapSeostatsServicesAlexa::getGlobalRank ();
				$pageRanksArray ['alexabacklinks'] = JMapSeostatsServicesAlexa::getBacklinkCount ();
				$pageRanksArray ['alexapageloadtime'] = JMapSeostatsServicesAlexa::getPageLoadTime ();
				$pageRanksArray ['alexagraph'] = JMapSeostatsServicesAlexa::getTrafficGraph (1, false, 800, 320, 12);
				if ( function_exists ( 'mb_convert_encoding' )) {
					$pageRanksArray ['googlerank'] = JMapSeostatsServicesGoogle::getPageRank ();
				}
				$pageRanksArray ['googleindexedlinks'] = JMapSeostatsServicesGoogle::getSiteindexTotal ();

				// All completed succesfully
				$response->result = true;
				$response->seostats = $pageRanksArray;
			}
		} catch ( JMapException $e ) {
			$response->result = false;
			$response->exception_message = $e->getMessage ();
			$response->errorlevel = $e->getErrorLevel();
			$response->seostats = $pageRanksArray;
			return $response;
		} catch ( Exception $e ) {
			$jmapException = new JMapException ( JText::sprintf ( 'COM_JMAP_ERROR_RETRIEVING_SEOSTATS', $e->getMessage () ), 'error' );
			$response->result = false;
			$response->exception_message = $jmapException->getMessage ();
			$response->errorlevel = $e->getErrorLevel();
			$response->seostats = $pageRanksArray;
			return $response;
		}

		return $response;
	}
	
	/**
	 * Fetch informations from the Google API for SERP to check the indexing status of a link
	 *
	 * @access private
	 * @param string $linkUrl
	 * @param Object[] $additionalModels Array for additional injected models type hinted by interface
	 * @return Object
	 */
	private function getIndexedStatus($linkUrl, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass ();
		$cParams = $this->getComponentParams();
		
		// Random user agents DB
		$userAgents=array(
				"Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0",
				"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0",
				"Mozilla/5.0 (X11; Linux i586; rv:31.0) Gecko/20100101 Firefox/31.0",
				"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:31.0) Gecko/20130401 Firefox/31.0",
				"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36",
				"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.1 Safari/537.36",
				"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1944.0 Safari/537.36",
				"Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2224.3 Safari/537.36",
				"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A",
				"Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25",
				"Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko",
				"Mozilla/5.0 (compatible, MSIE 11, Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko",
				"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)",
				"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)",
				"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/5.0)",
		 		"Mozilla/5.0 (compatible; MSIE 10.0; Macintosh; Intel Mac OS X 10_7_3; Trident/6.0)");
	    $ua = $userAgents[rand (0, count($userAgents) - 1)];
			    
	    // Format the request header array
		$headers = array (
				'Cache-Control' => 'max-age=0',
				'User-Agent' => $ua,
				'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
				'Referer' => 'http://www.webcrawler.com/',
				'Accept-Language' => 'en-GB, en'
		);
	
		// Set number of max results to evaluate in the SERP
		$maxResults = $cParams->get('linksanalyzer_serp_numresults', 10);
		
		// Start querying the SERP search engine
		try {
			// Resource Action detection dall'HTTP method name
			$HTTPMethod = $this->app->input->server->get ( 'REQUEST_METHOD', 'GET' );
			
			if ($HTTPMethod !== 'GET') {
				throw new JMapException ( JText::_ ( 'COM_JMAP_INVALID_RESTFUL_METHOD' ), 'error' );
			}
			
			if (! class_exists( 'DOMDocument' )) {
				throw new JMapException ( JText::_ ( 'COM_JMAP_DOMDOCUMENT_NOT_SUPPORTED' ), 'error' );
			}
			
			// Initialize indexing status to false AKA 'Not indexed'
			$response->indexing_status = 0;
			
			// Check if the query URL has been requested
			if ($linkUrl) {
				// Instantiante a new HTTP client
				$httpClient = new JMapHttp();
				
				// Remove the html prefix in the url and separators if any, this helps the algo to be more exact
				if($cParams->get('linksanalyzer_remove_separators', 1)) {
					$linkUrl = preg_replace('#http.?:\/\/#i', '', $linkUrl);
					$linkUrl = JString::str_ireplace('-', ' ', $linkUrl);
					$linkUrl = JString::str_ireplace('_', ' ', $linkUrl);
					$linkUrl = preg_replace('/\s[^0-9]\s/i', ' ', $linkUrl);
				}
				
				// Remove the html prefix in the url and separators if any, this helps the algo to be more exact
				$removeSlashes = $cParams->get('linksanalyzer_remove_slashes', 2);
				if($removeSlashes == 1 || ($removeSlashes >= 2 && substr_count($linkUrl, '/') <= ($removeSlashes - 1))) {
					$linkUrl = JString::str_ireplace('/', ' ', $linkUrl);
				}
				
				// Perform the query to the http://www.webcrawler.com and limit the URL length to max 106 chars
				$encodedURL = urlencode(JString::substr($linkUrl, 0 , 106));
				$httpResponse = $httpClient->get('http://www.webcrawler.com/info.wbcrwl.sbox/search/web?q=' . $encodedURL . '&submit=Search', $headers);
				
				// If the web service returns a HTTP 200 OK go on to parse results
				if($httpResponse->code == 200) {
					// Get the response body
					$responseBody = $httpResponse->body;
					
					// New instance of DOMDocument parser
					$doc = new DOMDocument('1.0', 'UTF-8');
					libxml_use_internal_errors(true);
					
					//Load the DOMDocument document
					$doc->loadHTML($responseBody);
					libxml_clear_errors();

					// Set up the DOMXPath and the css className to find in the document for the target SERP elements
					$classname = 'resultDisplayUrl';
					$finder = new DomXPath($doc);
					
					// Find SERP nodes, object of DOMNodeList
					$resultsNodes = $finder->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
				
					// If SERP nodes has been found go on to check if the link is indexed for this domain
					if($resultsNodes->length) {
						// Evaluate n SERP results based on the config param
						for ($i=0,$k=$maxResults; $i<$maxResults; $i++) {
							// Get node by object instance, DOMNode
							$node = $resultsNodes->item($i);
							if(is_object($node)) {
								// Security safe, check again if the class name is correct
								if($node->getAttribute('class') == 'resultDisplayUrl') {
									$trimmedNode = trim($node->nodeValue);
									$urlArray = explode('/', $trimmedNode);
									// Extract the SERP domain and assume that it's indexed for the current query
									$serpDomain = $urlArray[0];
									if(preg_match('/' . $serpDomain . '/i', $linkUrl)) {
										$response->indexing_status = 1;
										break;
									}
								}
							}
						}
					} else {
						// No SERP found for this link, return as not available info
						$response->indexing_status = -1;
					}
				}
				
				// Final all went well, no exceptions triggered
				$response->result = true;
			}
		} catch ( JMapException $e ) {
			$response->result = false;
			$response->exception_message = $e->getMessage ();
			return $response;
		} catch ( Exception $e ) {
			$jmapException = new JMapException ( JText::sprintf ( 'COM_JMAP_ANALYZER_INDEXING_ERROR', $e->getMessage () ), 'error' );
			$response->result = false;
			$response->exception_message = $jmapException->getMessage ();
			return $response;
		}
	
		return $response;
	}
	
	/**
	 * Check what sitemaps are cached on disk to show accordingly green labels
	 *
	 * @access private
	 * @param $idEntity
	 * @param $additionalModels
	 *
	 * @Return array
	 */
	private function getPrecachedSitemaps($queryStringLinksArray, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass ();

		try {
			// Resource Action detection dall'HTTP method name
			$HTTPMethod = $this->app->input->server->get ( 'REQUEST_METHOD', 'GET' );

			if ($HTTPMethod !== 'GET') {
				throw new JMapException ( JText::_ ( 'COM_JMAP_INVALID_RESTFUL_METHOD' ), 'error' );
			}

			// Init empty status
			$response->sitemapLinksStatus = array ();

			// Start to set an associative array based on url parsing and file existance
			if (! empty ( $queryStringLinksArray ) && is_array ( $queryStringLinksArray )) {
				$joomlaConfig = JFactory::getConfig();
				$localTimeZone = new DateTimeZone($joomlaConfig->get('offset'));
				foreach ( $queryStringLinksArray as $singlePostedSitemapLink ) {
					$filename = 'sitemap_';
					$extractedQuery = parse_url ( $singlePostedSitemapLink, PHP_URL_QUERY );
					parse_str ( $extractedQuery, $parsedLink );
					// Evaluate format
					if (! empty ( $parsedLink ['format'] )) {
						$filename .= $parsedLink ['format'];
					}
					// Evaluate language
					if (! empty ( $parsedLink ['lang'] )) {
						$filename .= '_' . $parsedLink ['lang'];
					}
					// Evaluate dataset
					if (! empty ( $parsedLink ['dataset'] )) {
						$filename .= '_dataset' . $parsedLink ['dataset'];
					}
					// Evaluate Itemid
					if (! empty ( $parsedLink ['Itemid'] )) {
						$filename .= '_menuid' . $parsedLink ['Itemid'];
					}

					if (JFile::exists ( JPATH_COMPONENT_SITE . '/precache/' . $filename . '.xml' )) {
						// get last generation time
						$lastGenerationTimestamp = filemtime ( JPATH_COMPONENT_SITE . '/precache/' . $filename . '.xml' );
						$dateObject = new JDate($lastGenerationTimestamp);
						$dateObject->setTimezone($localTimeZone);

						$response->sitemapLinksStatus [$singlePostedSitemapLink] = array (
								'cached' => true,
								'lastgeneration' => $dateObject->format('Y-m-d', true)
						);
					} else {
						$response->sitemapLinksStatus [$singlePostedSitemapLink] = false;
					}
				}
			}

			// All completed succesfully
			$response->result = true;
		} catch ( Exception $e ) {
			$jmapException = new JMapException ( $e->getMessage (), 'error' );
			$response->result = false;
			$response->exception_message = $jmapException->getMessage ();
			return $response;
		}

		return $response;
	}

	/**
	 * Get file info to delete and check if file for precache exists
	 * In that case delete the file and clear cache
	 *
	 * @access private
	 * @param $fileInfo
	 * @param $additionalModels
	 *
	 * @Return array
	 */
	private function deletePrecachedSitemap($fileInfo, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass();
	
		try {
			// Resource Action detection dall'HTTP method name
			$HTTPMethod = $this->app->input->server->get('REQUEST_METHOD', 'POST');
	
			if ($HTTPMethod !== 'POST') {
				throw new JMapException(JText::_('COM_JMAP_INVALID_RESTFUL_METHOD'), 'error');
			}
	
			// Start to set an associative array based on url parsing and file existance
			if(!empty($fileInfo)) {
				$filename = 'sitemap_';
				// Evaluate format
				if(!empty($fileInfo->format)) {
					$filename .= $fileInfo->format;
				}
				// Evaluate language
				if(!empty($fileInfo->lang)) {
					$filename .= '_' . $fileInfo->lang;
				}
				// Evaluate dataset
				if(!empty($fileInfo->dataset)) {
					$filename .= '_dataset' . $fileInfo->dataset;
				}
				// Evaluate Itemid
				if(!empty($fileInfo->Itemid)) {
					$filename .= '_menuid' . $fileInfo->Itemid;
				}
					
				if(JFile::exists(JPATH_COMPONENT_SITE . '/precache/' . $filename . '.xml')) {
					if(!@unlink(JPATH_COMPONENT_SITE . '/precache/' . $filename . '.xml')) {
						throw new JMapException(JText::_('COM_JMAP_PRECACHING_ERROR_DELETING_FILE'), 'error');
					}

					// Check also if a temp precached file is still present and clear it
					if(JFile::exists(JPATH_COMPONENT_SITE . '/precache/temp_' . $filename . '.xml')) {
						@unlink(JPATH_COMPONENT_SITE . '/precache/temp_' . $filename . '.xml');
					}
				}
			}
	
			// All completed succesfully
			$response->result = true;
		} catch (Exception $e) {
			$jmapException = new JMapException($e->getMessage(), 'error');
			$response->result = false;
			$response->exception_message = $jmapException->getMessage();
			return $response;
		}
	
		return $response;
	}
	
	/**
	 * Load fields for selected database table
	 * 
	 * @access private
	 * @param string $tableName
	 * @param Object[] $additionalModels Array for additional injected models type hinted by interface
	 * @return array
	 */
	private function loadTableFields($tableName, $additionalModels = null) {
		// Fields select list
		$queryFields = "SHOW COLUMNS " . 
					   "\n FROM " . $this->_db->quoteName($tableName);
		$this->_db->setQuery($queryFields);
		$elements = $this->_db->loadColumn();

		return $elements;
	}

	/**
	 * Manage store/update Pingomatic entity record
	 * 
	 * @access private
	 * @param $idEntity
	 * @param $additionalModels
	 *
	 * @Return array
	 */
	private function storeUpdatePingomatic($idEntity, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass();

		// Store on ORM Table
		$table = $this->getTable('Pingomatic');
		$_POST['lastping'] = date('Y-m-d H:i:s');
		try {
			if (!$table->bind($_POST, true)) {
				throw new JMapException($table->getError(), 'error');
			}

			if (!$table->check()) {
				throw new JMapException($table->getError(), 'error');
			}

			if (!$table->store(false)) {
				throw new JMapException($table->getError(), 'error');
			}
		} catch (JMapException $e) {
			$response->result = false;
			$response->errorMsg = $e->getMessage();
			return $response;
		} catch (Exception $e) {
			$jmapException = new JMapException($e->getMessage(), 'error');
			$response->result = false;
			$response->errorMsg = $jmapException->getMessage();
			return $response;
		}

		// Manage exceptions from DB Model and return to JS domain
		$response->result = true;
		$response->id = $table->id;
		$response->lastping = $table->lastping;

		return $response;
	}
	
	/**
	 * Manage store/update for menu priorities
	 *
	 * @access private
	 * @param $params
	 * @param $additionalModels
	 *
	 * @Return array
	 */
	private function storeUpdatePriority($params, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass();
	
		// Store on ORM Table
		$table = $this->getTable($params->type);
		$table->load((int)$params->itemId);
		$table->priority = $params->priorityValue;
	
		try {
			// Switch on subaction
			if(!isset($params->task)) {
				throw new JMapException(JText::_('COM_JMAP_VALIDATON_ERROR_NOPRIORITY'), 'warning');
			}
			if($params->task == 'store') {
				if (!$table->store(false, $params->itemId)) {
					throw new JMapException($table->getError(), 'warning');
				}
			} else {
				// Check if record still exists in database
				if(!$table->id) {
					throw new JMapException(JText::_('COM_JMAP_VALIDATON_ERROR_NOPRIORITY'), 'warning');
				}
				// Delete always
				if (!$table->delete()) {
					throw new JMapException($table->getError(), 'warning');
				}
			}
		} catch (JMapException $e) {
			$response->result = false;
			$response->errorMsg = $e->getMessage();
			return $response;
		} catch (Exception $e) {
			$jmapException = new JMapException($e->getMessage(), 'warning');
			$response->result = false;
			$response->errorMsg = $jmapException->getMessage();
			return $response;
		}
	
		// Manage exceptions from DB Model and return to JS domain
		$response->result = true;
	
		return $response;
	}
	/**
	 * Get existing priority value for menu items
	 *
	 * @access private
	 * @param $params
	 * @param $additionalModels
	 *
	 * @Return array
	 */
	private function getPriority($params, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass();
		
		// Store on ORM Table
		$table = $this->getTable($params->type);
		
		try {
			if (!$table->load((int)$params->iditem)) {
				throw new JMapException($table->getError(), 'warning');
			}
			
			// Load a non existing record
			if(!$table->id) {
				throw new JMapException('nopriority', 'warning');
			}
		} catch (JMapException $e) {
			$response->result = false;
			$response->errorMsg = $e->getMessage();
			return $response;
		} catch (Exception $e) {
			$jmapException = new JMapException($e->getMessage(), 'warning');
			$response->result = false;
			$response->errorMsg = $jmapException->getMessage();
			return $response;
		}
		
		// Manage exceptions from DB Model and return to JS domain
		$response->result = true;
		$response->priority = $table->priority;
		
		return $response;
	}

	/**
	 * Manage robots.txt entry
	 *
	 * @access private
	 * @param $idEntity
	 * @param $additionalModels
	 *
	 * @Return array
	 */
	private function robotsSitemapEntry($queryStringLink, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass();

		try {
			// Resource Action detection dall'HTTP method name
			$HTTPMethod = $this->app->input->server->get('REQUEST_METHOD', 'GET');

			if ($HTTPMethod !== 'POST') {
				throw new JMapException(JText::_('COM_JMAP_INVALID_RESTFUL_METHOD'), 'error');
			}

			// Update robots.txt add entry Sitemap if not exists
			$targetRobot = null;
			// Try standard robots.txt
			if(JFile::exists(JPATH_ROOT . '/robots.txt')) {
				$targetRobot = JPATH_ROOT . '/robots.txt';
			} elseif (JFile::exists(JPATH_ROOT . '/robots.txt.dist')) { // Fallback on distribution version
				$targetRobot = JPATH_ROOT . '/robots.txt.dist';
			} else {
				throw new JMapException(JText::_('COM_JMAP_ROBOTS_NOTFOUND'), 'error');
			}
			
			// Robots.txt found!
			if($targetRobot !== false) {
				// If file permissions ko
				if(!$robotContents = JFile::read($targetRobot)) {
					throw new JMapException(JText::_('COM_JMAP_ERROR_READING_ROBOTS'), 'error');
				}
				
				$newEntry = null;
				// Entry for this sitemap 
				if(!stristr($robotContents, 'Sitemap: ' . $queryStringLink)) {
					$toAppend = null;
					// Check if JSitemap added already some entries
					if(!stristr($robotContents, '# JSitemap')) {
						// Empty line double EOL
						$toAppend = PHP_EOL . PHP_EOL . '# JSitemap entries';
					}
					$toAppend .= PHP_EOL . 'Sitemap: ' . $queryStringLink;
					$newEntry = $robotContents . $toAppend;
				}
				
				// If file permissions ko on rewrite updated contents
				if($newEntry) {
					if(!is_writable($targetRobot)) {
						@chmod($targetRobot, 0777);
					}
					if(@!JFile::write($targetRobot, $newEntry)) {
						throw new JMapException(JText::_('COM_JMAP_ERROR_WRITING_ROBOTS'), 'error');
					}
				} else {
					throw new JMapException(JText::_('COM_JMAP_ENTRY_ALREADY_ADDED'), 'error');
				}
			}
			
			// All completed succesfully
			$response->result = true;
		} catch (JMapException $e) {
			$response->result = false;
			$response->errorMsg = $e->getMessage();
			return $response;
		} catch (Exception $e) {
			$jmapException = new JMapException($e->getMessage(), 'error');
			$response->result = false;
			$response->errorMsg = $jmapException->getMessage();
			return $response;
		}
		
		return $response;
	}

	/**
	 * Store meta info for a given url
	 *
	 * @access private
	 * @param Object $dataObject
	 * @param Object[] $additionalModels Array for additional injected models type hinted by interface
	 * @return Object
	 */
	private function saveMeta($dataObject, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass();
	
		try {
			// Check if the link already exists in this table
			$selectQuery = "SELECT" . $this->_db->quoteName('id') .
						   "\n FROM " . $this->_db->quoteName('#__jmap_metainfo') .
						   "\n WHERE" .
						   $this->_db->quoteName('linkurl') . " = " . $this->_db->quote($dataObject->linkurl);
			$linkExists = $this->_db->setQuery ( $selectQuery )->loadResult();

			// If the link exists just update it, otherwise insert a new one
			if($linkExists) {
				$query = "UPDATE" .
						 "\n " . $this->_db->quoteName('#__jmap_metainfo') .
						 "\n SET " .
						 "\n " . $this->_db->quoteName('meta_title') . " = " . $this->_db->quote($dataObject->meta_title) . "," .
						 "\n " . $this->_db->quoteName('meta_desc') . " = " . $this->_db->quote($dataObject->meta_desc) . "," .
						 "\n " . $this->_db->quoteName('meta_image') . " = " . $this->_db->quote($dataObject->meta_image) . "," .
						 "\n " . $this->_db->quoteName('robots') . " = " . $this->_db->quote($dataObject->robots) .
						 "\n WHERE " .
						 "\n " . $this->_db->quoteName('linkurl') . " = " . $this->_db->quote($dataObject->linkurl);
				$this->_db->setQuery ( $query );
			} else {
				$query = "INSERT INTO" .
						 "\n " . $this->_db->quoteName('#__jmap_metainfo') . "(" .
						 $this->_db->quoteName('linkurl') . "," .
						 $this->_db->quoteName('meta_title') . "," .
						 $this->_db->quoteName('meta_desc') . "," .
						 $this->_db->quoteName('meta_image') . "," .
						 $this->_db->quoteName('robots') . "," .
						 $this->_db->quoteName('published') . ") VALUES (" .
						 $this->_db->quote($dataObject->linkurl) . "," .
						 $this->_db->quote($dataObject->meta_title) . "," .
						 $this->_db->quote($dataObject->meta_desc) . "," .
						 $this->_db->quote($dataObject->meta_image) . "," .
						 $this->_db->quote($dataObject->robots) . "," .
						 $this->_db->quote($dataObject->published) . ")";
				$this->_db->setQuery ( $query );
			}
			$this->_db->execute ();
			if ($this->_db->getErrorNum ()) {
				throw new JMapException(JText::sprintf('COM_JMAP_METAINFO_ERROR_STORING_DATA', $this->_db->getErrorMsg()), 'error');
			}
	
			// All completed succesfully
			$response->result = true;
		} catch (JMapException $e) {
			$response->result = false;
			$response->exception_message = $e->getMessage();
			return $response;
		} catch (Exception $e) {
			$jmapException = new JMapException(JText::sprintf('COM_JMAP_ERROR_RETRIEVING_DATA', $e->getMessage()), 'error');
			$response->result = false;
			$response->exception_message = $jmapException->getMessage();
			return $response;
		}
	
		return $response;
	}
	
	/**
	 * Store meta info for a given url
	 *
	 * @access private
	 * @param Object $dataObject
	 * @param Object[] $additionalModels Array for additional injected models type hinted by interface
	 * @return Object
	 */
	private function deleteMeta($dataObject, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass();
	
		try {
			// Check if the link already exists in this table
			$selectQuery = "SELECT" . $this->_db->quoteName('id') .
						   "\n FROM " . $this->_db->quoteName('#__jmap_metainfo') .
						   "\n WHERE" .
						   $this->_db->quoteName('linkurl') . " = " . $this->_db->quote($dataObject->linkurl);
			$linkExists = $this->_db->setQuery ( $selectQuery )->loadResult();

			// If the link exists just update it, otherwise insert a new one
			if($linkExists) {
				$query = "DELETE" .
						 "\n FROM " . $this->_db->quoteName('#__jmap_metainfo') .
						 "\n WHERE " .
						 "\n " . $this->_db->quoteName('linkurl') . " = " . $this->_db->quote($dataObject->linkurl);
				$this->_db->setQuery ( $query );
				$this->_db->execute ();
				if ($this->_db->getErrorNum ()) {
					throw new JMapException(JText::sprintf('COM_JMAP_METAINFO_ERROR_STORING_DATA', $this->_db->getErrorMsg()), 'error');
				}
			} else {
				$response->result = true;
				$response->exception_message = JText::_('COM_JMAP_NO_METAINFO_SAVED');
				return $response;
			}
	
			// All completed succesfully
			$response->result = true;
		} catch (JMapException $e) {
			$response->result = false;
			$response->exception_message = $e->getMessage();
			return $response;
		} catch (Exception $e) {
			$jmapException = new JMapException(JText::sprintf('COM_JMAP_ERROR_RETRIEVING_DATA', $e->getMessage()), 'error');
			$response->result = false;
			$response->exception_message = $jmapException->getMessage();
			return $response;
		}
	
		return $response;
	}
	
	/**
	 * Store meta info for a given url
	 *
	 * @access private
	 * @param Object $dataObject
	 * @param Object[] $additionalModels Array for additional injected models type hinted by interface
	 * @return Object
	 */
	private function stateMeta($dataObject, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass();
	
		try {
			// Check if the link already exists in this table
			$selectQuery = "SELECT" . $this->_db->quoteName('id') .
						   "\n FROM " . $this->_db->quoteName('#__jmap_metainfo') .
						   "\n WHERE" .
			$this->_db->quoteName('linkurl') . " = " . $this->_db->quote($dataObject->linkurl);
			$linkExists = $this->_db->setQuery ( $selectQuery )->loadResult();
	
			// If the link exists just update it, otherwise insert a new one
			if($linkExists) {
				$query = "UPDATE" .
						 "\n " . $this->_db->quoteName('#__jmap_metainfo') .
						 "\n SET " .
						 "\n " . $this->_db->quoteName('published') . " = " . (int)($dataObject->published) .
						 "\n WHERE " .
						 "\n " . $this->_db->quoteName('linkurl') . " = " . $this->_db->quote($dataObject->linkurl);
				$this->_db->setQuery ( $query );
				$this->_db->execute ();
				if ($this->_db->getErrorNum ()) {
					throw new JMapException(JText::sprintf('COM_JMAP_METAINFO_ERROR_STORING_DATA', $this->_db->getErrorMsg()), 'error');
				}
			} else {
				$response->result = true;
				$response->exception_message = JText::_('COM_JMAP_NO_METAINFO_SAVED');
				return $response;
			}
	
			// All completed succesfully
			$response->result = true;
		} catch (JMapException $e) {
			$response->result = false;
			$response->exception_message = $e->getMessage();
			return $response;
		} catch (Exception $e) {
			$jmapException = new JMapException(JText::sprintf('COM_JMAP_ERROR_RETRIEVING_DATA', $e->getMessage()), 'error');
			$response->result = false;
			$response->exception_message = $jmapException->getMessage();
			return $response;
		}
	
		return $response;
	}
	
	/**
	 * Mimic an entities list, as ajax calls arrive are redirected to loadEntity public responsibility to get handled
	 * by specific subtask. Responses are returned to controller and encoded from view over HTTP to JS client
	 * 
	 * @access public 
	 * @param string $id Rappresenta l'op da eseguire tra le private properties
	 * @param mixed $param Parametri da passare al private handler
	 * @param Object[]& $DIModels
	 * @return Object& $utenteSelezionato
	 */
	public function loadAjaxEntity($id, $param , $DIModels) {
		//Delega la private functions delegata dalla richiesta sulla entity
		$response = $this->$id($param, $DIModels);

		return $response;
	}
}
