<?php
// namespace administrator\components\com_jmap\models;
/**
 *
 * @package JMAP::INDEXING::administrator::components::com_jmap
 * @subpackage models
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 * Indexing links model concrete implementation <<testable_behavior>>
 *
 * @package JMAP::INDEXING::administrator::components::com_jmap
 * @subpackage models
 * @since 3.3
 */
class JMapModelIndexing extends JMapModel {
	/**
	 * Main get data method, retrieve model data using the Google API
	 * Search results are based on parsing of automated queries
	 *
	 * @access public
	 * @return Object[]
	 */
	public function getData() {
		// Check if it's a search by keyword
		$keyword = $this->getState ( 'searchword', null );
		$serpSearch = $keyword ? $keyword : 'site:' . $this->getComponentParams ()->get ( 'seostats_custom_link', JUri::root ( false ) );
		$customHeaders = array('countrytld'=>$this->getState('countriestld', null), 'acceptlanguage'=>$this->getState('acceptlanguage', null));
		try {
			if (! function_exists ( 'curl_init' )) {
				throw new JMapException ( JText::_ ( 'COM_JMAP_CURL_NOT_SUPPORTED' ), 'error' );
			}
			
			$result = JMapSeostatsServicesGoogle::getSerps ( $serpSearch, $this->getState ( 'limitstart', 0 ), $customHeaders);
			
			if (! $result) {
				throw new JMapException ( JText::_ ( 'COM_JMAP_ERROR_RETRIEVING_INDEXING' ) . $this->_db->getErrorMsg (), 'notice' );
			}
			$this->setState('serpsearch', $serpSearch);
		} catch ( JMapException $e ) {
			$this->app->enqueueMessage ( $e->getMessage (), $e->getErrorLevel () );
			$result = array ();
		} catch ( Exception $e ) {
			$jmapException = new JMapException ( $e->getMessage (), 'error' );
			$this->app->enqueueMessage ( $jmapException->getMessage (), $jmapException->getErrorLevel () );
			$result = array ();
		}
		return $result;
	}
	
	/**
	 * Return select lists used as filter for listEntities
	 *
	 * @access public
	 * @return array
	 */
	public function getFilters() {
		// Number of Google page for SERPS
		$incrementOptions = array ();
		$incrementOptions [] = JHtml::_ ( 'select.option', 10, JText::_ ( 'COM_JMAP_10PAGES' ) );
		$incrementOptions [] = JHtml::_ ( 'select.option', 100, JText::_ ( 'COM_JMAP_100PAGES' ) );
		$incrementOptions [] = JHtml::_ ( 'select.option', 200, JText::_ ( 'COM_JMAP_200PAGES' ) );
		$incrementOptions [] = JHtml::_ ( 'select.option', 500, JText::_ ( 'COM_JMAP_500PAGES' ) );
		$incrementOptions [] = JHtml::_ ( 'select.option', 1000, JText::_ ( 'COM_JMAP_1000PAGES' ) );
		$incrementOptions [] = JHtml::_ ( 'select.option', 5000, JText::_ ( 'COM_JMAP_5000PAGES' ) );
		$incrementOptions [] = JHtml::_ ( 'select.option', 10000, JText::_ ( 'COM_JMAP_10000PAGES' ) );
		$lists ['numpages'] = JHtml::_ ( 'select.genericlist', $incrementOptions, 'numpages', 'onchange="Joomla.submitform();" class="inputbox input-medium"', 'value', 'text', $this->getState ( 'numpages' ) );
		
		// Languages
		$languagesHttpAcceptHeaders = array (
				"af-NA"=>"Afrikaans (Namibia)",
				"af-ZA"=>"Afrikaans (South Africa)",
				"ak-GH"=>"Akan (Ghana)",
				"sq-AL"=>"Albanian (Albania)",
				"am-ET"=>"Amharic (Ethiopia)",
				"ar-DZ"=>"Arabic (Algeria)",
				"ar-BH"=>"Arabic (Bahrain)",
				"ar-EG"=>"Arabic (Egypt)",
				"ar-IQ"=>"Arabic (Iraq)",
				"ar-JO"=>"Arabic (Jordan)",
				"ar-KW"=>"Arabic (Kuwait)",
				"ar-LB"=>"Arabic (Lebanon)",
				"ar-LY"=>"Arabic (Libya)",
				"ar-MA"=>"Arabic (Morocco)",
				"ar-OM"=>"Arabic (Oman)",
				"ar-QA"=>"Arabic (Qatar)",
				"ar-SA"=>"Arabic (Saudi Arabia)",
				"ar-SD"=>"Arabic (Sudan)",
				"ar-SY"=>"Arabic (Syria)",
				"ar-TN"=>"Arabic (Tunisia)",
				"ar-AE"=>"Arabic (United Arab Emirates)",
				"ar-YE"=>"Arabic (Yemen)",
				"hy-AM"=>"Armenian (Armenia)",
				"as-IN"=>"Assamese (India)",
				"asa-TZ"=>"Asu (Tanzania)",
				"az-Cyrl"=>"Azerbaijani (Cyrillic)",
				"az-Cyrl-AZ"=>"Azerbaijani (Cyrillic, Azerbaijan)",
				"az-Latn"=>"Azerbaijani (Latin)",
				"az-Latn-AZ"=>"Azerbaijani (Latin, Azerbaijan)",
				"bm-ML"=>"Bambara (Mali)",
				"eu-ES"=>"Basque (Spain)",
				"be-BY"=>"Belarusian (Belarus)",
				"bem-ZM"=>"Bemba (Zambia)",
				"bez-TZ"=>"Bena (Tanzania)",
				"bn-BD"=>"Bengali (Bangladesh)",
				"bn-IN"=>"Bengali (India)",
				"bs-BA"=>"Bosnian (Bosnia and Herzegovina)",
				"bg-BG"=>"Bulgarian (Bulgaria)",
				"my-MM"=>"Burmese (Myanmar [Burma])",
				"ca-ES"=>"Catalan (Spain)",
				"tzm-Latn"=>"Central Morocco Tamazight (Latin)",
				"tzm-Latn-MA"=>"Central Morocco Tamazight (Latin, Morocco)",
				"tzm"=>"Central Morocco Tamazight",
				"chr-US"=>"Cherokee (United States)",
				"cgg-UG"=>"Chiga (Uganda)",
				"zh-Hans"=>"Chinese (Simplified Han)",
				"zh-Hans-CN"=>"Chinese (Simplified Han, China)",
				"zh-Hans-HK"=>"Chinese (Simplified Han, Hong Kong SAR China)",
				"zh-Hans-MO"=>"Chinese (Simplified Han, Macau SAR China)",
				"zh-Hans-SG"=>"Chinese (Simplified Han, Singapore)",
				"zh-Hant"=>"Chinese (Traditional Han)",
				"zh-Hant-HK"=>"Chinese (Traditional Han, Hong Kong SAR China)",
				"zh-Hant-MO"=>"Chinese (Traditional Han, Macau SAR China)",
				"zh-Hant-TW"=>"Chinese (Traditional Han, Taiwan)",
				"kw-GB"=>"Cornish (United Kingdom)",
				"hr-HR"=>"Croatian (Croatia)",
				"cs-CZ"=>"Czech (Czech Republic)",
				"da-DK"=>"Danish (Denmark)",
				"nl-BE"=>"Dutch (Belgium)",
				"nl-NL"=>"Dutch (Netherlands)",
				"ebu-KE"=>"Embu (Kenya)",
				"en-AS"=>"English (American Samoa)",
				"en-AU"=>"English (Australia)",
				"en-BE"=>"English (Belgium)",
				"en-BZ"=>"English (Belize)",
				"en-BW"=>"English (Botswana)",
				"en-CA"=>"English (Canada)",
				"en-GU"=>"English (Guam)",
				"en-HK"=>"English (Hong Kong SAR China)",
				"en-IN"=>"English (India)",
				"en-IE"=>"English (Ireland)",
				"en-JM"=>"English (Jamaica)",
				"en-MT"=>"English (Malta)",
				"en-MH"=>"English (Marshall Islands)",
				"en-MU"=>"English (Mauritius)",
				"en-NA"=>"English (Namibia)",
				"en-NZ"=>"English (New Zealand)",
				"en-MP"=>"English (Northern Mariana Islands)",
				"en-PK"=>"English (Pakistan)",
				"en-PH"=>"English (Philippines)",
				"en-SG"=>"English (Singapore)",
				"en-ZA"=>"English (South Africa)",
				"en-TT"=>"English (Trinidad and Tobago)",
				"en-UM"=>"English (U.S. Minor Outlying Islands)",
				"en-VI"=>"English (U.S. Virgin Islands)",
				"en-GB"=>"English (United Kingdom)",
				"en-US"=>"English (United States)",
				"en-ZW"=>"English (Zimbabwe)",
				"et-EE"=>"Estonian (Estonia)",
				"ee-GH"=>"Ewe (Ghana)",
				"ee-TG"=>"Ewe (Togo)",
				"fo-FO"=>"Faroese (Faroe Islands)",
				"fil-PH"=>"Filipino (Philippines)",
				"fi-FI"=>"Finnish (Finland)",
				"fr-BE"=>"French (Belgium)",
				"fr-BJ"=>"French (Benin)",
				"fr-BF"=>"French (Burkina Faso)",
				"fr-BI"=>"French (Burundi)",
				"fr-CM"=>"French (Cameroon)",
				"fr-CA"=>"French (Canada)",
				"fr-CF"=>"French (Central African Republic)",
				"fr-TD"=>"French (Chad)",
				"fr-KM"=>"French (Comoros)",
				"fr-CG"=>"French (Congo - Brazzaville)",
				"fr-CD"=>"French (Congo - Kinshasa)",
				"fr-CI"=>"French (Cote Ivoire)",
				"fr-DJ"=>"French (Djibouti)",
				"fr-GQ"=>"French (Equatorial Guinea)",
				"fr-FR"=>"French (France)",
				"fr-GA"=>"French (Gabon)",
				"fr-GP"=>"French (Guadeloupe)",
				"fr-GN"=>"French (Guinea)",
				"fr-LU"=>"French (Luxembourg)",
				"fr-MG"=>"French (Madagascar)",
				"fr-ML"=>"French (Mali)",
				"fr-MQ"=>"French (Martinique)",
				"fr-MC"=>"French (Monaco)",
				"fr-NE"=>"French (Niger)",
				"fr-RW"=>"French (Rwanda)",
				"fr-RE"=>"French (Reunion)",
				"fr-BL"=>"French (Saint Barthelemy)",
				"fr-MF"=>"French (Saint Martin)",
				"fr-SN"=>"French (Senegal)",
				"fr-CH"=>"French (Switzerland)",
				"fr-TG"=>"French (Togo)",
				"ff-SN"=>"Fulah (Senegal)",
				"gl-ES"=>"Galician (Spain)",
				"lg-UG"=>"Ganda (Uganda)",
				"ka-GE"=>"Georgian (Georgia)",
				"de-AT"=>"German (Austria)",
				"de-BE"=>"German (Belgium)",
				"de-DE"=>"German (Germany)",
				"de-LI"=>"German (Liechtenstein)",
				"de-LU"=>"German (Luxembourg)",
				"de-CH"=>"German (Switzerland)",
				"el-CY"=>"Greek (Cyprus)",
				"el-GR"=>"Greek (Greece)",
				"gu-IN"=>"Gujarati (India)",
				"guz-KE"=>"Gusii (Kenya)",
				"ha-Latn"=>"Hausa (Latin)",
				"ha-Latn-GH"=>"Hausa (Latin, Ghana)",
				"ha-Latn-NE"=>"Hausa (Latin, Niger)",
				"ha-Latn-NG"=>"Hausa (Latin, Nigeria)",
				"haw-US"=>"Hawaiian (United States)",
				"he-IL"=>"Hebrew (Israel)",
				"hi-IN"=>"Hindi (India)",
				"hu-HU"=>"Hungarian (Hungary)",
				"is-IS"=>"Icelandic (Iceland)",
				"ig-NG"=>"Igbo (Nigeria)",
				"id-ID"=>"Indonesian (Indonesia)",
				"ga-IE"=>"Irish (Ireland)",
				"it-IT"=>"Italian (Italy)",
				"it-CH"=>"Italian (Switzerland)",
				"ja-JP"=>"Japanese (Japan)",
				"kea-CV"=>"Kabuverdianu (Cape Verde)",
				"kab-DZ"=>"Kabyle (Algeria)",
				"kl-GL"=>"Kalaallisut (Greenland)",
				"kln-KE"=>"Kalenjin (Kenya)",
				"kam-KE"=>"Kamba (Kenya)",
				"kn-IN"=>"Kannada (India)",
				"kk-Cyrl"=>"Kazakh (Cyrillic)",
				"kk-Cyrl-KZ"=>"Kazakh (Cyrillic, Kazakhstan)",
				"km-KH"=>"Khmer (Cambodia)",
				"ki-KE"=>"Kikuyu (Kenya)",
				"rw-RW"=>"Kinyarwanda (Rwanda)",
				"kok-IN"=>"Konkani (India)",
				"ko-KR"=>"Korean (South Korea)",
				"khq-ML"=>"Koyra Chiini (Mali)",
				"ses-ML"=>"Koyraboro Senni (Mali)",
				"lag-TZ"=>"Langi (Tanzania)",
				"lv-LV"=>"Latvian (Latvia)",
				"lt-LT"=>"Lithuanian (Lithuania)",
				"luo-KE"=>"Luo (Kenya)",
				"luy-KE"=>"Luyia (Kenya)",
				"mk-MK"=>"Macedonian (Macedonia)",
				"jmc-TZ"=>"Machame (Tanzania)",
				"kde-TZ"=>"Makonde (Tanzania)",
				"mg-MG"=>"Malagasy (Madagascar)",
				"ms-BN"=>"Malay (Brunei)",
				"ms-MY"=>"Malay (Malaysia)",
				"ml-IN"=>"Malayalam (India)",
				"mt-MT"=>"Maltese (Malta)",
				"gv-GB"=>"Manx (United Kingdom)",
				"mr-IN"=>"Marathi (India)",
				"mas-KE"=>"Masai (Kenya)",
				"mas-TZ"=>"Masai (Tanzania)",
				"mer-KE"=>"Meru (Kenya)",
				"mfe-MU"=>"Morisyen (Mauritius)",
				"naq-NA"=>"Nama (Namibia)",
				"ne-IN"=>"Nepali (India)",
				"ne-NP"=>"Nepali (Nepal)",
				"nd-ZW"=>"North Ndebele (Zimbabwe)",
				"nb-NO"=>"Norwegian Bokmal (Norway)",
				"nn-NO"=>"Norwegian Nynorsk (Norway)",
				"nyn-UG"=>"Nyankole (Uganda)",
				"or-IN"=>"Oriya (India)",
				"om-ET"=>"Oromo (Ethiopia)",
				"m-KE"=>"Oromo (Kenya)",
				"ps-AF"=>"Pashto (Afghanistan)",
				"fa-AF"=>"Persian (Afghanistan)",
				"fa-IR"=>"Persian (Iran)",
				"pl-PL"=>"Polish (Poland)",
				"pt-BR"=>"Portuguese (Brazil)",
				"pt-GW"=>"Portuguese (Guinea-Bissau)",
				"pt-MZ"=>"Portuguese (Mozambique)",
				"pt-PT"=>"Portuguese (Portugal)",
				"pa-Arab"=>"Punjabi (Arabic)",
				"pa-Arab-PK"=>"Punjabi (Arabic, Pakistan)",
				"pa-Guru"=>"Punjabi (Gurmukhi)",
				"pa-Guru-IN"=>"Punjabi (Gurmukhi, India)",
				"ro-MD"=>"Romanian (Moldova)",
				"ro-RO"=>"Romanian (Romania)",
				"rm-CH"=>"Romansh (Switzerland)",
				"rof-TZ"=>"Rombo (Tanzania)",
				"ru-MD"=>"Russian (Moldova)",
				"ru-RU"=>"Russian (Russia)",
				"ru-UA"=>"Russian (Ukraine)",
				"rwk-TZ"=>"Rwa (Tanzania)",
				"saq-KE"=>"Samburu (Kenya)",
				"sg-CF"=>"Sango (Central African Republic)",
				"seh-MZ"=>"Sena (Mozambique)",
				"sr-Cyrl"=>"Serbian (Cyrillic)",
				"sr-Cyrl-BA"=>"Serbian (Cyrillic, Bosnia and Herzegovina)",
				"sr-Cyrl-ME"=>"Serbian (Cyrillic, Montenegro)",
				"sr-Cyrl-RS"=>"Serbian (Cyrillic, Serbia)",
				"sr-Latn"=>"Serbian (Latin)",
				"sr-Latn-BA"=>"Serbian (Latin, Bosnia and Herzegovina)",
				"sr-Latn-ME"=>"Serbian (Latin, Montenegro)",
				"sr-Latn-RS"=>"Serbian (Latin, Serbia)",
				"sn-ZW"=>"Shona (Zimbabwe)",
				"ii-CN"=>"Sichuan Yi (China)",
				"si-LK"=>"Sinhala (Sri Lanka)",
				"sk-SK"=>"Slovak (Slovakia)",
				"sl-SI"=>"Slovenian (Slovenia)",
				"xog-UG"=>"Soga (Uganda)",
				"so-DJ"=>"Somali (Djibouti)",
				"so-ET"=>"Somali (Ethiopia)",
				"so-KE"=>"Somali (Kenya)",
				"so-SO"=>"Somali (Somalia)",
				"es-AR"=>"Spanish (Argentina)",
				"es-BO"=>"Spanish (Bolivia)",
				"es-CL"=>"Spanish (Chile)",
				"es-CO"=>"Spanish (Colombia)",
				"es-CR"=>"Spanish (Costa Rica)",
				"es-DO"=>"Spanish (Dominican Republic)",
				"es-EC"=>"Spanish (Ecuador)",
				"es-SV"=>"Spanish (El Salvador)",
				"es-GQ"=>"Spanish (Equatorial Guinea)",
				"es-GT"=>"Spanish (Guatemala)",
				"es-HN"=>"Spanish (Honduras)",
				"es-419"=>"Spanish (Latin America)",
				"es-MX"=>"Spanish (Mexico)",
				"es-NI"=>"Spanish (Nicaragua)",
				"es-PA"=>"Spanish (Panama)",
				"es-PY"=>"Spanish (Paraguay)",
				"es-PE"=>"Spanish (Peru)",
				"es-PR"=>"Spanish (Puerto Rico)",
				"es-ES"=>"Spanish (Spain)",
				"es-US"=>"Spanish (United States)",
				"es-UY"=>"Spanish (Uruguay)",
				"es-VE"=>"Spanish (Venezuela)",
				"sw-KE"=>"Swahili (Kenya)",
				"sw-TZ"=>"Swahili (Tanzania)",
				"sv-FI"=>"Swedish (Finland)",
				"sv-SE"=>"Swedish (Sweden)",
				"gsw-CH"=>"Swiss German (Switzerland)",
				"shi-Latn"=>"Tachelhit (Latin)",
				"shi-Latn-MA"=>"Tachelhit (Latin, Morocco)",
				"shi-Tfng"=>"Tachelhit (Tifinagh)",
				"shi-Tfng-MA"=>"Tachelhit (Tifinagh, Morocco)",
				"dav-KE"=>"Taita (Kenya)",
				"ta-IN"=>"Tamil (India)",
				"ta-LK"=>"Tamil (Sri Lanka)",
				"te-IN"=>"Telugu (India)",
				"teo-KE"=>"Teso (Kenya)",
				"teo-UG"=>"Teso (Uganda)",
				"th-TH"=>"Thai (Thailand)",
				"bo-CN"=>"Tibetan (China)",
				"bo-IN"=>"Tibetan (India)",
				"ti-ER"=>"Tigrinya (Eritrea)",
				"ti-ET"=>"Tigrinya (Ethiopia)",
				"to-TO"=>"Tonga (Tonga)",
				"tr-TR"=>"Turkish (Turkey)",
				"uk-UA"=>"Ukrainian (Ukraine)",
				"ur-IN"=>"Urdu (India)",
				"ur-PK"=>"Urdu (Pakistan)",
				"uz-Arab"=>"Uzbek (Arabic)",
				"uz-Arab-AF"=>"Uzbek (Arabic, Afghanistan)",
				"uz-Cyrl"=>"Uzbek (Cyrillic)",
				"uz-Cyrl-UZ"=>"Uzbek (Cyrillic, Uzbekistan)",
				"uz-Latn"=>"Uzbek (Latin)",
				"uz-Latn-UZ"=>"Uzbek (Latin, Uzbekistan)",
				"vi-VN"=>"Vietnamese (Vietnam)",
				"vun-TZ"=>"Vunjo (Tanzania)",
				"cy-GB"=>"Welsh (United Kingdom)",
				"yo-NG"=>"Yoruba (Nigeria)",
				"zu-ZA"=>"Zulu (South Africa)" 
		);
		
		$languagesHttpAcceptHeadersOptions = array ();
		$languagesHttpAcceptHeadersOptions [] = JHtml::_ ( 'select.option', null, JText::_('COM_JMAP_INDEXING_SELECT_DEFAULT') );
		foreach ($languagesHttpAcceptHeaders as $value=>$text) {
			$languagesHttpAcceptHeadersOptions [] = JHtml::_ ( 'select.option', $value, $text );
		}
		$lists ['acceptlanguages'] = JHtml::_ ( 'select.genericlist', $languagesHttpAcceptHeadersOptions, 'acceptlanguage', 'class="inputbox input-medium serpcontrol"', 'value', 'text', $this->getState ( 'acceptlanguage' ) );
		
		$countriedTopLevelDomains = array (
				'Algeria'=>'dz',
				'Ascension Island'=>'ac',
				'Andorra'=>'ad',
				'Afghanistan'=>'com.af',
				'Antigua and Barbuda'=>'com.ag',
				'Anguilla'=>'com.ai',
				'Albania'=>'al',
				'Armenia'=>'am',
				'Angola'=>'co.ao',
				'Argentina'=>'com.ar',
				'American Samoa'=>'as',
				'Austria'=>'at',
				'Australia'=>'com.au',
				'Azerbaijan'=>'az',
				'Bosnia and Herzegovina'=>'ba',
				'Bangladesh'=>'com.bd',
				'Belgium'=>'be',
				'Burkina Faso'=>'bf',
				'Bulgaria'=>'bg',
				'Bahrain'=>'com.bh',
				'Burma'=>'com.mm',
				'Burundi'=>'bi',
				'Benin'=>'bj',
				'Brunei'=>'com.bn',
				'Bolivia'=>'com.bo',
				'Brazil'=>'com.br',
				'Bahamas'=>'bs',
				'Bhutan'=>'bt',
				'Botswana'=>'co.bw',
				'Belarus'=>'by',
				'Belize'=>'com.bz',
				'British Indian Ocean Territory'=>'io',
				'British Virgin Islands'=>'vg',
				'Canada'=>'ca',
				'Cambodia'=>'com.kh',
				'Cocos (Keeling) Islands'=>'cc',
				'Central African Republic'=>'cf',
				'Catalonia Catalan Countries'=>'cat',
				'Cook Islands'=>'co.ck',
				'Chile'=>'cl',
				'Cameroon'=>'cm',
				'Chad'=>'td',
				'China'=>'cn',
				'Colombia'=>'com.co',
				'Costa Rica'=>'co.cr',
				'Croatia'=>'hr',
				'Cuba'=>'com.cu',
				'Cape Verde'=>'cv',
				'Cyprus'=>'com.cy',
				'Czech Republic'=>'cz',
				'Democratic Republic of the Congo'=>'cd',
				'Denmark'=>'dk',
				'Djibouti'=>'dj',
				'Dominica'=>'dm',
				'Dominican Republic'=>'com.do',
				'Ecuador'=>'com.ec',
				'Estonia'=>'ee',
				'Egypt'=>'com.eg',
				'El Salvador'=>'com.sv',
				'Ethiopia'=>'com.et',
				'Finland'=>'fi',
				'Fiji'=>'com.fj',
				'Federated States of Micronesia'=>'fm',
				'France'=>'fr',
				'French Guiana'=>'gf',
				'Gabon'=>'ga',
				'Georgia'=>'ge',
				'Germany'=>'de',
				'Guernsey'=>'gg',
				'Ghana'=>'com.gh',
				'Gibraltar'=>'com.gi',
				'Greenland'=>'gl',
				'Gambia'=>'gm',
				'Guadeloupe'=>'gp',
				'Greece'=>'gr',
				'Guatemala'=>'com.gt',
				'Guyana'=>'gy',
				'Hong Kong'=>'com.hk',
				'Honduras'=>'hn',
				'Haiti'=>'ht',
				'Hungary'=>'hu',
				'Indonesia'=>'co.id',
				'Iran'=>'ir',
				'Iraq'=>'iq',
				'Ireland'=>'ie',
				'Israel'=>'co.il',
				'India'=>'co.in',
				'Iceland'=>'is',
				'Italy'=>'it',
				'Ivory Coast'=>'ci',
				'Jersey'=>'je',
				'Jamaica'=>'com.jm',
				'Jordan'=>'jo',
				'Japan'=>'co.jp',
				'Kenya'=>'co.ke',
				'Kiribati'=>'ki',
				'Kyrgyzstan'=>'kg',
				'Kuwait'=>'com.kw',
				'Kazakhstan'=>'kz',
				'Laos'=>'la',
				'Lebanon'=>'com.lb',
				'Liechtenstein'=>'li',
				'Lesotho'=>'co.ls',
				'Lithuania'=>'lt',
				'Luxembourg'=>'u',
				'Latvia'=>'lv',
				'Libya'=>'ly',
				'Morocco'=>'co.ma',
				'Moldova'=>'md',
				'Montenegro'=>'me',
				'Madagascar'=>'mg',
				'Macedonia'=>'mk',
				'Mali'=>'ml',
				'Mongolia'=>'mn',
				'Montserrat'=>'ms',
				'Malta'=>'com.mt',
				'Mauritius'=>'mu',
				'Maldives'=>'mv',
				'Malawi'=>'mw',
				'Mexico'=>'com.mx',
				'Malaysia'=>'com.my',
				'Mozambique'=>'co.mz',
				'Namibia'=>'com.na',
				'Niger'=>'ne',
				'Norfolk Island'=>'com.nf',
				'Nigeria'=>'com.ng',
				'Nicaragua'=>'com.ni',
				'Netherlands'=>'nl',
				'Norway'=>'no',
				'Nepal'=>'com.np',
				'Nauru'=>'nr',
				'Niue'=>'nu',
				'New Zealand'=>'co.nz',
				'Oman'=>'com.om',
				'Panama'=>'com.pa',
				'Peru'=>'com.pe',
				'Philippines'=>'com.ph',
				'Pakistan'=>'com.pk',
				'Poland'=>'pl',
				'Papua New Guinea'=>'com.pg',
				'Pitcairn Islands'=>'pn',
				'Puerto Rico'=>'com.pr',
				'Palestine'=>'ps',
				'Portugal'=>'pt',
				'Paraguay'=>'com.py',
				'Qatar'=>'com.qa',
				'Romania'=>'ro',
				'Republic of the Congo'=>'cg',
				'Russia'=>'ru',
				'Rwanda'=>'rw',
				'Saint Vincent and the Grenadines'=>'com.vc',
				'Sao Tome and Principe'=>'st',
				'Saudi Arabia'=>'com.sa',
				'Serbia'=>'rs',
				'Solomon Islands'=>'com.sb',
				'Seychelles'=>'sc',
				'Sweden'=>'se',
				'Singapore'=>'com.sg',
				'Saint Helena'=>'sh',
				'Saint Lucia'=>'com.lc',
				'Samoa'=>'ws',
				'Slovenia'=>'si',
				'Slovakia'=>'sk',
				'Sierra Leone'=>'com.sl',
				'Senegal'=>'sn',
				'San Marino'=>'sm',
				'Somalia'=>'so',
				'South Africa'=>'co.za',
				'South Korea'=>'co.kr',
				'Spain'=>'es',
				'Sri Lanka'=>'lk',
				'Switzerland'=>'ch',
				'Togo'=>'tg',
				'Thailand'=>'co.th',
				'Tajikistan'=>'com.tj',
				'Tokelau'=>'tk',
				'Timor-Leste'=>'tl',
				'Turkmenistan'=>'tm',
				'Tonga'=>'to',
				'Tunisia'=>'tn',
				'Tunisia com.tn',
				'Turkey'=>'com.tr',
				'Trinidad and Tobago'=>'tt',
				'Taiwan'=>'com.tw',
				'Tanzania'=>'co.tz',
				'Ukraine'=>'com.ua',
				'Uganda'=>'co.ug',
				'United Kingdom'=>'co.uk',
				'United Arab Emirates'=>'ae',
				'United States'=>'com',
				'Uruguay'=>'com.uy',
				'Uzbekistan'=>'co.uz',
				'Venezuela'=>'co.ve',
				'United States Virgin Islands'=>'co.vi',
				'Vietnam'=>'com.vn',
				'Vanuatu'=>'vu',
				'Zambia'=>'co.zm',
				'Zimbabwe'=>'co.zw' 
		);
		$countriesOptions = array ();
		$countriesOptions [] = JHtml::_ ( 'select.option', null, JText::_('COM_JMAP_INDEXING_SELECT_DEFAULT') );
		foreach ($countriedTopLevelDomains as $text=>$value) {
			$countriesOptions [] = JHtml::_ ( 'select.option', $value, $text );
		}
		$lists ['countriestld'] = JHtml::_ ( 'select.genericlist', $countriesOptions, 'countriestld', 'class="inputbox input-medium serpcontrol"', 'value', 'text', $this->getState ( 'countriestld' ) );
		
		return $lists;
	}
}