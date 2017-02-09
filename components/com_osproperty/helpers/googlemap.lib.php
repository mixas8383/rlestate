<?php
/*------------------------------------------------------------------------
# googlemap.lib.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// No direct access.
defined('_JEXEC') or die;
class HelperOspropertyGoogleMap{

	public static function loadGoogleScript($suffix){
		global $configClass;
		$configClass = OSPHelper::loadConfig();
		if($configClass['goole_aip_key'] != ""){
			$key = "&key=".$configClass['goole_aip_key'];
		}else{
			$key = "";
		}
		if($suffix != ""){
			$suffix = "&".$suffix;
		}
		?>
		<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false<?php echo $key;?><?php echo $suffix;?>"></script>
		<?php
	}

	/**
	 * Get Lat Long address
	 *
	 * @param unknown_type $address
	 * @return unknown
	 */
	static function getLatlongAdd($address){
		$configClass = OSPHelper::loadConfig();
		if($configClass['goole_aip_key'] != ""){
			$key = "&key=".$configClass['goole_aip_key'];
		}else{
			$key = "";
		}
		$address = urlencode($address);
		$base_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=false";
		if(HelperOspropertyGoogleMap::_iscurlinstalled()){
			$ch = curl_init();
		    curl_setopt ($ch, CURLOPT_URL, $base_url);
		    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
		    $fileContents = curl_exec($ch);
		    curl_close($ch);
		}else{
			$fileContents = file_get_contents($base_url);
		}
		$output =  json_decode($fileContents);
		$lat    =  $output->results[0]->geometry->location->lat;
		$long   =  $output->results[0]->geometry->location->lng;
		
		$return = array();
		$return[0]->lat  = $lat;
		$return[0]->long = $long;
		return $return;
	}
	
	/**
	 * Check curl existing
	 *
	 * @return unknown
	 */
	public static function _iscurlinstalled() {
		if  (in_array  ('curl', get_loaded_extensions())) {
			return true;
		}
		else{
			return false;
		}
	}
	
	/**
	 * Load Google Map
	 *
	 * @param unknown_type $geocode
	 */
	static function loadGoogleMap($geocode,$mapdiv,$maptype){
		global $configClass;
		switch ($maptype){
			case "agent":
			case "company":
				$icon = "workoffice.png";
			break;
			default:
				$icon = "house.png";
			break;
		}
		if(count($geocode) == 1){
			$lat = $geocode[0]->lat;
			$long = $geocode[0]->long;
		}else{
			$lat = $geocode[0]->lat;
			$long = $geocode[0]->long;
		}
		if (!isset($configClass['goole_map_overlay'])) $configClass['goole_map_overlay'] = 'ROADMAP';

        OSPHelper::loadGoogleJS();
		?>
		<script type="text/javascript">
		function initialize() {
		  var myOptions = {
		  zoom: <?php echo $configClass['goole_map_resolution']?>,
center: new google.maps.LatLng(<?php echo $lat?>,<?php echo $long?>),mapTypeId: google.maps.MapTypeId.<?php echo  $configClass['goole_map_overlay'];?>};
		  var map = new google.maps.Map(document.getElementById("<?php echo $mapdiv?>"),myOptions);
		  setMarkers(map, addressArray);
		}
		
		<?php
		$address = "[";
		for($i=0;$i<count($geocode);$i++){
			$geo = $geocode[$i];
			$address .= '["'.$geo->text.'",'.$geo->lat.','.$geo->long.','.$i.'],';
		}
		$address = substr($address,0,strlen($address)-1);
		$address .= "]";
		?>
		
		var addressArray = <?php echo $address?>;
		
		function setMarkers(map, locations) {
		  
		  for (var i = 0; i < locations.length; i++) {
		  	var j = i + 1;
		  	var imagelink = '<?php echo JURI::root()?>components/com_osproperty/images/assets/mapicon/i' + j + '.png';
		  	var image = new google.maps.MarkerImage(imagelink,new google.maps.Size(36, 31),new google.maps.Point(0,0),new google.maps.Point(0, 31));
		    var add = locations[i];
		    var myLatLng = new google.maps.LatLng(add[1], add[2]);
		    var marker = new google.maps.Marker({
		        position: myLatLng,
		        map: map,
		        icon: image,
		        title: add[0],
		        zIndex: add[3]
		    });
		  }
		}
		</script>
		<?php
	}
	
	/**
	 * load Google Map in Edit Property
	 *
	 */
	static function loadGMapinEditProperty($geocode,$div_name,$lat_div,$long_div){
		global $mainframe,$configClass;
		if (!isset($configClass['goole_map_overlay'])) $configClass['goole_map_overlay'] = 'ROADMAP';
		$icon = "house.png";
		self::loadGoogleScript();
		?>
		<script type="text/javascript">
		  var propertyPoint = new google.maps.LatLng(<?php echo $geocode[0]->lat?>,<?php echo $geocode[0]->long?>);
		  var marker;
		  var map;
		  var geocoder;
		  var centerChangedLast;
		  var reverseGeocodedLast;
		  var currentReverseGeocodeResponse;
		  var markersArray = [];
		  function initialize() {
		    var mapOptions = {
		      zoom: <?php echo $configClass['goole_map_resolution']?>,
		      mapTypeId: google.maps.MapTypeId.<?php echo  $configClass['goole_map_overlay'];?>,
		      mapTypeControl: true,
              navigationControl: true,
		      center: propertyPoint
		    };
			geocoder = new google.maps.Geocoder();
		    map = new google.maps.Map(document.getElementById("<?php echo $div_name?>"),mapOptions);
		    marker = new google.maps.Marker({
		      map:map,
		      draggable:true,
		      animation: google.maps.Animation.DROP,
		      position: propertyPoint
		    });
		    markersArray.push(marker);
		    google.maps.event.addListener(marker, 'dragend', toggleBounce);
		  }
		
		  function toggleBounce() {
		     if (marker.getAnimation() != null) {
		       marker.setAnimation(null);
		     } else {
		       marker.setAnimation(google.maps.Animation.BOUNCE);
		     }
		     var point = marker.getPosition();
		     map.panTo(point);
		     document.getElementById("<?php echo $lat_div?>").value = point.lat().toFixed(5);
		     document.getElementById("<?php echo $long_div?>").value = point.lng().toFixed(5);
		  }
		  
		  function showAddress(address){
			  geocoder.geocode({'address': address,'partialmatch': true}, geocodeResult);
		  }
		  function geocodeResult(results, status) {
		    if (status == 'OK' && results.length > 0) {
		      map.fitBounds(results[0].geometry.viewport);
		      
		      marker.setPosition(map.getCenter());
		      marker.setMap(map);
			  //markersArray.push(marker);
			  google.maps.event.addListener(marker, 'dragend', toggleBounce);
			  document.getElementById("<?php echo $lat_div?>").value = map.getCenter().lat().toFixed(5);
		      document.getElementById("<?php echo $long_div?>").value = map.getCenter().lng().toFixed(5);
		    } else {
		      alert("Geocode was not successful for the following reason: " + status);
		    }
		  }
		 	
	      function addMarkerAtCenter() {
		    var marker = new google.maps.Marker({
		        position: map.getCenter(),
		        map: map
		    });
		    //var infowindow = new google.maps.InfoWindow({ content: text });
		    //google.maps.event.addListener(marker, 'click', function() {
		    // infowindow.open(map,marker);
		    //});
	      }
	      
	      function addMarker(location) {
			  marker = new google.maps.Marker({
			    position: location,
			    map: map
			  });
			  markersArray.push(marker);
			}
			
			// Removes the overlays from the map, but keeps them in the array
			function clearOverlays() {
			  if (markersArray) {
			    for (i in markersArray) {
			      markersArray[i].setMap(null);
			    }
			  }
			}

		</script>
		<?php
	}
	
	/**
	 * Load Locator Map
	 *
	 * @param unknown_type $rows
	 * @param unknown_type $mapdiv
	 */
	static function loadLocatorMap($rows,$mapdiv,$zoomlevel,$search_lat,$search_long){
		global $mainframe,$configClass;
		
		$icon = "house.png";
		if(($search_lat != "") or ($search_long != "")){
			$lat = $search_lat;
			$long = $search_long;
		}else{
			if(count($rows) == 1){
				$lat = $rows[0]->lat;
				$long = $rows[0]->long;
			}else{
				$lat = $rows[0]->lat;
				$long = $rows[0]->long;
			}
		}
		if (!isset($configClass['goole_map_overlay'])) $configClass['goole_map_overlay'] = 'ROADMAP';
        OSPHelper::loadGoogleJS();
		?>
		<script type="text/javascript">
		  var infowindow;
		  var map;
		  var bounds;
		  var markers = [];
		  var markerIndex=0;
		  var markerArray = [];
		  var bounds = new google.maps.LatLngBounds();
		  function initMap() {
			  var myOptions = {
			  zoom: <?php echo $zoomlevel;?>,
			  center: new google.maps.LatLng(<?php echo $lat?>,<?php echo $long?>),
			  mapTypeId: google.maps.MapTypeId.<?php echo $configClass['goole_map_overlay'];?>,
			  mapTypeControl: true,
              navigationControl: true,
              streetViewControl: true,
              zoomControl: true,
	          zoomControlOptions: {
	            style: google.maps.ZoomControlStyle.SMALL
	          }
			  };
			  var map = new google.maps.Map(document.getElementById("<?php echo $mapdiv?>"),myOptions);
			  //setMarkers(map, addressArray);
			  var infoWindow = new google.maps.InfoWindow();
	 		  var markerBounds = new google.maps.LatLngBounds();
	 
	 		  function makeMarker(options){
				   var pushPin = new google.maps.Marker({map:map});
				   pushPin.setOptions(options);
				   google.maps.event.addListener(pushPin, 'click', function(){
					     infoWindow.setOptions(options);
					     infoWindow.open(map, pushPin);
				   });
				   markerArray.push(pushPin);
				   return pushPin;
			 }
			 
			
			 google.maps.event.addListener(map, 'click', function(){
			   infoWindow.close();
			 });
			 
			 <?php
			 for($i=0;$i<count($rows);$i++){
			 	$row = $rows[$i];
			 	if($mapdiv == "map_canvas"){
			 	?>
			 	 makeMarker({
				   position: new google.maps.LatLng(<?php echo $row->lat?>,<?php echo $row->long?>),
				   title: "<?php echo htmlspecialchars($row->title);?>",
				   content: "<?php echo htmlspecialchars($row->content)?>",
				   icon:new google.maps.MarkerImage('<?php echo JURI::root()?>components/com_osproperty/images/assets/<?php echo $icon?>')
				 });
			 	<?php
			 	}else{
			 	?>
			 	 makeMarker({
				   position: new google.maps.LatLng(<?php echo $row->lat?>,<?php echo $row->long?>),
				   title: "<?php echo htmlspecialchars($row->title)?>",
				   content: "<?php echo htmlspecialchars($row->content)?>"
				 });
				 bounds.extend(new google.maps.LatLng(<?php echo $row->lat?>,<?php echo $row->long?>));
			 	<?php
			 	}
			 }
			 ?>
			 map.fitBounds(bounds);
			 var listener = google.maps.event.addListener(map, "idle", function() { 
			    if (map.getZoom() > 16) map.setZoom(16); 
			    google.maps.event.removeListener(listener); 
			 });
		  }
		  
		  window.onload=function(){
			if(window.initMap) initMap();
		  }
		  window.onunload=function(){
		    if(typeof(GUnload)!="undefined") GUnload();
		  }
		  
		  function openMarker(i){
			   google.maps.event.trigger(markerArray[i],'click');
		  };
		</script>
		<?php
	}

	/**
	 * Find Address
	 *
	 * @param unknown_type $option
	 * @param unknown_type $row
	 * @return unknown
	 */
	public static function findAddress($option,$row,$address,$type){
		global $configClass;
		if($configClass['goole_aip_key'] != ""){
			$key = "&key=".$configClass['goole_aip_key'];
		}else{
			$key = "";
		}
		if($type == 0){
			$db = JFactory::getDbo();
			$address = "";
			if($row->address != ""){
				$address .= $row->address;
			}
			if($row->city != ""){
				$address .= " ".$row->city;
			}
			if($row->state != ""){
				$db->setQuery("Select state_name from #__osrs_states where id = '$state'");
				$state_name = $db->loadResult();
				$address .= " ".$state_name;
				$db->setQuery("Select country_id from #__osrs_states where id = '$state'");
				$country_id = $db->loadResult();
				$db->setQuery("Select country_name from #__osrs_countries where id = '$country_id'");
				$country_name = $db->loadResult();
				$address .= " ".$country_name;
			}
			$address = trim($address);
		}
		
		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false";
		if(HelperOspropertyGoogleMap::_iscurlinstalled()){
			$ch = curl_init();
		    curl_setopt ($ch, CURLOPT_URL, $url);
		    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
		    $return_data = curl_exec($ch);
		    curl_close($ch);
		}else{
			$return_data = file_get_contents($url) or die("url not loading");
		}
		$return_data = json_decode($return_data);
		$return_location = $return_data->results;
		$return = array();
		if($return_data->status == "OK"){
			$return[0] = $return_location[0]->geometry->location->lat;
			$return[1] = $return_location[0]->geometry->location->lng;
			$return[2] = $return_data->status;
		}
		return $return;
	}
	
	/**
	 * Load Street View Map
	 *
	 * @param unknown_type $geocode
	 * @param unknown_type $divname
	 */
	public static function loadStreetViewMap($geocode,$divname){
		global $mainframe;
		$lat = $geocode[0]->lat;
		$long = $geocode[0]->long;
        OSPHelper::loadGoogleJS();
		?>
		<script type="text/javascript">
		function initialize() {
		  var fenway = new google.maps.LatLng(<?php echo $lat?>,<?php echo $long?>);
		  // Note: constructed panorama objects have visible: true
		  // set by default.
		  var panoOptions = {
		    position: fenway,
		    addressControlOptions: {
		      position: google.maps.ControlPosition.BOTTOM
		    },
		    linksControl: false,
		    panControl: false,
		    zoomControlOptions: {
		      style: google.maps.ZoomControlStyle.SMALL
		    },
		    enableCloseButton: false
		  };
		
		  var panorama = new google.maps.StreetViewPanorama(
		      document.getElementById("pano"), panoOptions);
		}
		</script>
		</head>
		<body onload="initialize()">
		  <div id="pano" style="width: 500px; height: 300px;"></div>
		</body>
		</html>
		<?php
	}

	
	static function loadMapInListing($rows,$state_id = 0,$city_id = 0){
		global $mainframe,$configClass;
		if($configClass['goole_aip_key'] != ""){
			$key = "&key=".$configClass['goole_aip_key'];
		}else{
			$key = "";
		}
		//find default lat/long addresses
        $show_map = 0;
		$city_name = "";
		$state_name = "";
		$db = JFactory::getDbo();
		if($state_id > 0){
			$db->setQuery("Select state_name from #__osrs_states where id = '$state_id'");
			$state_name = $db->loadResult();
			
			$db->setQuery("Select country_id from #__osrs_states where id = '$state_id'");
			$country_id = $db->loadResult();
			
			$db->setQuery("Select country_name from #__osrs_countries where id = '$country_id'");
			$country_name = $db->loadResult();
		}
		if($city_id > 0){
			$db->setQuery("Select city from #__osrs_cities where id = '$city_id'");
			$city_name = $db->loadResult();
		}
		
		if(($city_name != "") or ($state_name != "")){
			$address = "";
			if($city_name != ""){
				$address = $city_name;
			}
			if($state_name != ""){
				$address .= " ".$state_name;
			}
			if($country_name != ""){
				$address .= " ".$country_name;
			}
			$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false".$key;
			if(HelperOspropertyGoogleMap::_iscurlinstalled()){
				$ch = curl_init();
			    curl_setopt ($ch, CURLOPT_URL, $url);
			    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
			    $return_data = curl_exec($ch);
			    curl_close($ch);
			}else{
				$return_data = file_get_contents($url) or die("url not loading");
			}
			$return_data = json_decode($return_data);
			$return_location = $return_data->results;
			$return = array();
			if($return_data->status == "OK"){
				$default_lat  = $return_location[0]->geometry->location->lat;
				$default_long = $return_location[0]->geometry->location->lng;
			}
		}else{
			$default_lat  = $configClass['goole_default_lat'];
			$default_long = $configClass['goole_default_long'];
		}
		
		$duplicate = OSPHelper::findGoogleDuplication($rows);

        OSPHelper::loadGoogleJS();
		?>

		<script type='text/javascript' src='<?php echo JUri::root()?>components/com_osproperty/js/markerclusterer.js'></script>
		<script type="text/javascript">
		  var map;
		  var panorama;
		  var centerPlace = new google.maps.LatLng(<?php echo $default_lat; ?>, <?php echo $default_long; ?>);
		  var bounds = new google.maps.LatLngBounds();
		  var gmarkers = [];
		  var markerArray = [];
		  <?php
			$min = 0.9999999;
			$max = 1.00000000;
			$start_point = 1;
			//for($i=0; $i<count($rows)-1; $i++){
		  		//$obj1 = $rows[$i];
		  		//for($j = 1;$j<count($rows);$j++){
		  			//$obj2 = $rows[$j];
		  			//if(($obj1->lat_add == $obj2->lat_add) and ($obj1->long_add == $obj2->long_add)){
		  				//$obj2->lat_add  =  $obj2->lat_add * ($start_point * ($max - $min) + $min);
		  				//$obj2->long_add =  $obj2->long_add * ($start_point * ($max - $min) + $min);
		  				//$start_point++;
		  			//}
		  		//}
		    //}
		    
		  for($i=0;$i<count($duplicate);$i++){
			  $item = $duplicate[$i];
			  $key  = OSPHelper::find_key($item->id,$rows);
			  if(($rows[$key]->show_address == 1) and ($rows[$key]->lat_add != "") and ($rows[$key]->long_add != "")){
				  ?>
					 var propertyListing<?php echo $rows[$key]->id?> = new google.maps.LatLng(<?php echo $rows[$key]->lat_add; ?>, <?php echo $rows[$key]->long_add; ?>);
					 bounds.extend(propertyListing<?php echo $rows[$key]->id?>);
				  <?php
		  	  }
		  }

		  $google_map_overlay = $configClass['goole_map_overlay'];
	      if($google_map_overlay == ""){
			 $google_map_overlay = "ROADMAP";
		  }
		  ?>
		  var infowindow;
		  var map;
		  //var bounds;
		  var markers = [];
		  var markerIndex=0;
		  
		  function initMap() {
			// Set up the map
			var mapOptions = {
				center: centerPlace,
				scrollwheel: false,
				zoom: 12,
				streetViewControl: true,
				mapTypeId: google.maps.MapTypeId.<?php echo $google_map_overlay;?>
			};
			map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
			//map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
			map.fitBounds(bounds);
			var listener = google.maps.event.addListener(map, "idle", function() { 
			if (map.getZoom() > 18) map.setZoom(18); 
			  google.maps.event.removeListener(listener); 
			});
			var infoWindow = new google.maps.InfoWindow();
	 		var markerBounds = new google.maps.LatLngBounds();

	 		function makeMarker(options){
				  var pushPin = new google.maps.Marker({map:map});
				  pushPin.setOptions(options);
				  google.maps.event.addListener(pushPin, 'click', function(){
					    infoWindow.setOptions(options);
					    infoWindow.open(map, pushPin);
					    map.panTo(pushPin.getPosition());
						map.setZoom(18);
				  });
				  markerArray.push(pushPin);
				  return pushPin;
			}
			
			google.maps.event.addListener(map, 'click', function(){
			   infoWindow.close();
			});
			 
			 <?php
			  for($i=0;$i<count($duplicate);$i++){
		
				$item = $duplicate[$i];
				$key  = OSPHelper::find_key($item->id,$rows);
				if(count($item->value) == 0){ //having no duplication
					$row = $rows[$key];
					$row->mapid = $i;
					$needs = array();
					$needs[] = "property_details";
					$needs[] = $row->id;
					$itemid	 = OSPRoute::getItemid($needs);
					$title = "";
					if($row->ref!=""){
						$title .= $row->ref.",";
					}
					$title 		.= $row->pro_name;
					$title  	 = str_replace("'","",$title);
					$title 		 = htmlspecialchars($title);
					$created_on  = $row->created;
					$modified_on = $row->modified;
					$created_on  = strtotime($created_on);
					$modified_on = strtotime($modified_on);
					
					$addInfo = array();
					if($row->bed_room > 0){
						$addInfo[] = $row->bed_room." ".JText::_('OS_BEDROOMS');
					}
					if($row->bath_room > 0){
						$addInfo[] = OSPHelper::showBath($row->bath_room)." ".JText::_('OS_BATHROOMS');
					}
					if($row->rooms > 0){
						$addInfo[] = $row->rooms." ".JText::_('OS_ROOMS');
					}
					?>
					 var contentString<?php echo $row->id?> = '<div class="row-fluid">'+
						'<div class="span4">'+
								'<a href="<?php echo JRoute::_("index.php?option=com_osproperty&task=property_details&id=".$row->id."&Itemid=".$itemid)?>"><img class="span12 thumbnail" src="<?php echo $row->photo?>" /></a>'+
								'</div><div class="span8 ezitem-smallleftpad">'+
						'<div class="row-fluid"><div class="span12 ospitem-maptitle title-blue"><?php echo $title;?></div></div>';
					 <?php 
					 if(count($addInfo) > 0){
					 ?>
						 contentString<?php echo $row->id?> += '<div class="ospitem-iconbkgr"><span class="ezitem-leftpad"><?php echo implode(" | ",$addInfo); ?></span></div>';
					 <?php
					 }
					 ?>
					 contentString<?php echo $row->id?> += '<?php echo htmlspecialchars(str_replace("'","\"",str_replace("\r","",str_replace("\n","",$row->pro_small_desc))));?> <a href="<?php echo JRoute::_("index.php?option=com_osproperty&task=property_details&id=".$row->id."&Itemid=".$itemid)?>"><?php echo JText::_('OS_DETAILS');?></a></p>'+
						'</div>'+
						'</div>';
						<?php
						if(($row->show_address == 1) and ($row->lat_add != "") and ($row->long_add != "")){
							$show_map = 1;
							$db->setQuery("Select type_icon from #__osrs_types where id = '$row->pro_type'");
							$type_icon = $db->loadResult();
							if($type_icon == ""){
								$type_icon = "1.png";
							}
							?>
							makeMarker({
								position: propertyListing<?php echo $row->id?>,
								title: "<?php echo $title;?>",
								content: contentString<?php echo $row->id?>,
								icon:new google.maps.MarkerImage('<?php echo JURI::root()?>components/com_osproperty/images/assets/googlemapicons/<?php echo $type_icon;?>')
							});
							<?php
					   }
				  }else{ //having duplication
					
					$row = $rows[$key];
					$row->mapid = $i;
					$itemIdArr = array();
					$titleArr  = array();
					$descArr   = array();

					$needs = array();
					$needs[] = "property_details";
					$needs[] = $row->id;
					$itemid	 = OSPRoute::getItemid($needs);
					$itemIdArr[] = $itemid;

					$title = "";
					if($row->ref!=""){
						$title .= $row->ref.",";
					}
					$title 		.= $row->pro_name;
					$title  	 = str_replace("'","",$title);
					$title 		 = htmlspecialchars($title);
					$titleArr[]  = $title;


					
					$addInfo = array();
					if($row->bed_room > 0){
						$addInfo[] = $row->bed_room." ".JText::_('OS_BEDROOMS');
					}
					if($row->bath_room > 0){
						$addInfo[] = OSPHelper::showBath($row->bath_room)." ".JText::_('OS_BATHROOMS');
					}
					if($row->rooms > 0){
						$addInfo[] = $row->rooms." ".JText::_('OS_ROOMS');
					}
					$desc = '<div class="row-fluid"><div class="span4"><a href="'. JRoute::_("index.php?option=com_osproperty&task=property_details&id=".$row->id."&Itemid=".$itemid).'"><img class="span12 thumbnail" src="'.$row->photo.'" /></a></div><div class="span8 ezitem-smallleftpad"><div class="row-fluid"><div class="span12 ospitem-maptitle title-blue">'.$title.'</div></div>';
					if(count($addInfo) > 0){
						$desc .= '<div class="ospitem-iconbkgr"><span class="ezitem-leftpad">'.implode(" | ",$addInfo).'</span></div>';
					}
					$desc .= htmlspecialchars(str_replace("'","\"",str_replace("\r","",str_replace("\n","",$row->pro_small_desc)))).'<a href="'.JRoute::_("index.php?option=com_osproperty&task=property_details&id=".$row->id."&Itemid=".$itemid).'">'.JText::_('OS_DETAILS').'</a></p></div></div>';
					$descArr[] = $desc;

					foreach($item->value as $value){
						$key  = OSPHelper::find_key($value,$rows);
						$dupItem = $rows[$key];
						$dupItem->mapid = $i;
						$needs = array();
						$needs[] = "property_details";
						$needs[] = $dupItem->id;
						$itemid	 = OSPRoute::getItemid($needs);
						$itemIdArr[] = $itemid;

						$title = "";
						if($dupItem->ref!=""){
							$title .= $dupItem->ref.",";
						}
						$title 		.= $dupItem->pro_name;
						$title  	 = str_replace("'","",$title);
						$title 		 = htmlspecialchars($title);
						$titleArr[]  = $title;


						
						$addInfo = array();
						if($dupItem->bed_room > 0){
							$addInfo[] = $dupItem->bed_room." ".JText::_('OS_BEDROOMS');
						}
						if($dupItem->bath_room > 0){
							$addInfo[] = OSPHelper::showBath($dupItem->bath_room)." ".JText::_('OS_BATHROOMS');
						}
						if($dupItem->rooms > 0){
							$addInfo[] = $dupItem->rooms." ".JText::_('OS_ROOMS');
						}
						$desc = '<div class="row-fluid"><div class="span4"><a href="'. JRoute::_("index.php?option=com_osproperty&task=property_details&id=".$dupItem->id."&Itemid=".$itemid).'"><img class="span12 thumbnail" src="'.$dupItem->photo.'" /></a></div><div class="span8 ezitem-smallleftpad"><div class="row-fluid"><div class="span12 ospitem-maptitle title-blue">'.$title.'</div></div>';
						if(count($addInfo) > 0){
							$desc .= '<div class="ospitem-iconbkgr"><span class="ezitem-leftpad">'.implode(" | ",$addInfo).'</span></div>';
						}
						$desc .= htmlspecialchars(str_replace("'","\"",str_replace("\r","",str_replace("\n","",$dupItem->pro_small_desc)))).'<a href="'.JRoute::_("index.php?option=com_osproperty&task=property_details&id=".$dupItem->id."&Itemid=".$itemid).'">'.JText::_('OS_DETAILS').'</a></p></div></div>';
						$descArr[] = $desc;
					}

					$desc = implode('<div class="clearfix" style="height:25px;border-top:1px dotted #efefef;"></div>',$descArr);
					?>
						
					 var contentString<?php echo $row->id?> = '<?php echo $desc;?>';
						<?php
						if(($row->show_address == 1) and ($row->lat_add != "") and ($row->long_add != "")){
							$show_map = 1;
							$db->setQuery("Select type_icon from #__osrs_types where id = '$row->pro_type'");
							$type_icon = $db->loadResult();
							if($type_icon == ""){
								$type_icon = "1.png";
							}
							?>
							makeMarker({
								position: propertyListing<?php echo $row->id?>,
								title: "<?php echo JText::_('OS_MULTIPLE_PROPERTIES');?>",
								content: contentString<?php echo $row->id?>,
								icon:new google.maps.MarkerImage('<?php echo JURI::root()?>components/com_osproperty/images/assets/googlemapicons/<?php echo $type_icon;?>')
							});
							<?php
					   }
						
				  }
			  }
			  for($i=0;$i<count($duplicate);$i++){
			  	  ?>
			  	  gmarkers.push(markerArray[<?php echo $i?>]);
			  	  <?php 
			  }
			  
			  ?>
			  clusterStyles = [
                  {
                      textColor: '#ffffff',
                      opt_textColor: '#ffffff',
                      url: '<?php echo Juri::root()?>components/com_osproperty/images/assets/cloud.png',
                      height: 72,
                      width: 72,
                      textSize: 15,
                  }
              ];
              var mcOptions = {gridSize: 50, maxZoom: 15, styles: clusterStyles};
			  var markerCluster = new MarkerClusterer(map,gmarkers,mcOptions);
		  }

		  window.onload=function(){
			if(window.initMap) initMap();
		  }
		  window.onunload=function(){
		    if(GUnload) GUnload();
		  }
		  function openMarker(i){
		  	   //location.hash = "#map_canvas";
			   jQuery("html, body").scrollTop(jQuery("#map_canvas").offset().top);
			   google.maps.event.trigger(markerArray[i],'click');
		  };
		</script>
		<?php
        if($show_map == 0){
            return false;
        }else{
            return true;
        }
	}

    static function loadMapInListing_yandex($rows,$state_id = 0,$city_id = 0){
        global $mainframe,$configClass;
		$configClass = OSPHelper::loadConfig();
		if($configClass['goole_aip_key'] != ""){
			$key = "&key=".$configClass['goole_aip_key'];
		}else{
			$key = "";
		}
        //find default lat/long addresses
        $show_map = 0;
        $city_name = "";
        $state_name = "";
        $db = JFactory::getDbo();
        if($state_id > 0){
            $db->setQuery("Select state_name from #__osrs_states where id = '$state_id'");
            $state_name = $db->loadResult();

            $db->setQuery("Select country_id from #__osrs_states where id = '$state_id'");
            $country_id = $db->loadResult();

            $db->setQuery("Select country_name from #__osrs_countries where id = '$country_id'");
            $country_name = $db->loadResult();
        }
        if($city_id > 0){
            $db->setQuery("Select city from #__osrs_cities where id = '$city_id'");
            $city_name = $db->loadResult();
        }
        if(($city_name != "") or ($state_name != "")){
            $address = "";
            if($city_name != ""){
                $address = $city_name;
            }
            if($state_name != ""){
                $address .= " ".$state_name;
            }
            if($country_name != ""){
                $address .= " ".$country_name;
            }
            $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false".$key;
            if(HelperOspropertyGoogleMap::_iscurlinstalled()){
                $ch = curl_init();
                curl_setopt ($ch, CURLOPT_URL, $url);
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
                $return_data = curl_exec($ch);
                curl_close($ch);
            }else{
                $return_data = file_get_contents($url) or die("url not loading");
            }
            $return_data = json_decode($return_data);
            $return_location = $return_data->results;
            $return = array();
            if($return_data->status == "OK"){
                $default_lat  = $return_location[0]->geometry->location->lat;
                $default_long = $return_location[0]->geometry->location->lng;
            }
        }else{
            $default_lat  = $configClass['goole_default_lat'];
            $default_long = $configClass['goole_default_long'];
        }

        $google_map_overlay = $configClass['goole_map_overlay'];
        if($google_map_overlay == ""){
            $google_map_overlay = "ROADMAP";
        }
        $google_map_overlay = strtolower($google_map_overlay);
        if($google_map_overlay == "roadmap"){
            $google_map_overlay = "map";
        }

        $language = JFactory::getLanguage();
        $activate_lang = $language->getTag();
        $document = JFactory::getDocument();
        $document->addScript("//api-maps.yandex.ru/2.0/?coordorder=longlat&amp;load=package.full&amp;lang=".$activate_lang);
        $min = 0.9999999;
        $max = 1.00000000;
        $start_point = 1;
        for($i=0; $i<count($rows)-1; $i++){
            $obj1 = $rows[$i];
            for($j = 1;$j<count($rows);$j++){
                $obj2 = $rows[$j];
                if(($obj1->lat_add == $obj2->lat_add) and ($obj1->long_add == $obj2->long_add)){
                    $obj2->lat_add  =  $obj2->lat_add * ($start_point * ($max - $min) + $min);
                    $obj2->long_add =  $obj2->long_add * ($start_point * ($max - $min) + $min);
                    $start_point++;
                }
            }
        }
        ?>
        <div id="YMapsMainRoutePanel"><div id="YMapsMainRoutePanel_Total"></div></div><div id="YMapsRoutePanel"><div id="YMapsRoutePanel_Description"></div><div id="YMapsRoutePanel_Total"></div><div id="YMapsRoutePanel_Steps"></div></div>
        <script type="text/javascript">/*<![CDATA[*/
            var map, mapcenter, geoResult, geoRoute;
            var searchControl, searchControlPMAP;
            //var group = new YMaps.GeoObjectCollection();
            <?php
            for($i=0;$i<count($rows);$i++){
                ?>
                var clustermarkers<?php echo $rows[$i]->id;?>;
                <?php
            }
            ?>
            ymaps.ready(initialize);
            function initialize () {
                mapcenter = [<?php echo $default_lat; ?>, <?php echo $default_long; ?>];
                map = new ymaps.Map("map_canvas", {
                    center: mapcenter,
                    zoom: 14
                });
                geoResult = new ymaps.GeoObjectCollection();
                <?php
                for($i=0;$i<count($rows);$i++){
                ?>
                    clustermarkers<?php echo $rows[$i]->id;?> = [];
                <?php
                }
                ?>
                markerCluster<?php echo $rows[0]->id;?> = new ymaps.Clusterer({
                    maxZoom: 14
                    , clusterDisableClickZoom: false
                    , synchAdd: false
                    , showInAlphabeticalOrder: false
                    , gridSize: 64
                    , minClusterSize: 2
                });

                map.geoObjects.add(markerCluster<?php echo $rows[0]->id;?>);
                if (map.behaviors.isEnabled('dblClickZoom'))
                    map.behaviors.disable('dblClickZoom');
                map.behaviors.enable('scrollZoom');
                map.controls.add(new ymaps.control.ZoomControl());
                map.setType("yandex#map");
                map.setZoom(14);
                map.options.set("minZoom", 1);
                map.events.add("typechange", function (e) {
                    map.zoomRange.get(map.getCenter()).then(function (range) {
                        if (map.getZoom() > range[1]) {
                            map.setZoom(range[1]);
                        }
                    });
                });

                minimap = new ymaps.control.MiniMap();
                minimap.expand();
                map.controls.add(minimap);
                var toolbar = new ymaps.control.MapTools();
                map.controls.add(toolbar);
                if (map.behaviors.isEnabled('rightMouseButtonMagnifier'))
                    map.behaviors.disable('rightMouseButtonMagnifier');
                map.behaviors.enable('drag');

                <?php
                for($i=0;$i<count($rows);$i++){
                    $row = $rows[$i];
                    if(($row->show_address == 1) and ($row->lat_add != "") and ($row->long_add != "")){
                        $needs = array();
                        $needs[] = "property_details";
                        $needs[] = $row->id;
                        $itemid	 = OSPRoute::getItemid($needs);
                        $title = "";
                        if($row->ref!=""){
                            $title .= $row->ref.",";
                        }
                        $title 		.= $row->pro_name;
                        $title  	 = str_replace("'","",$title);
                        $title 		 = htmlspecialchars($title);
                        $db->setQuery("Select type_icon from #__osrs_types where id = '$row->pro_type'");
                        $type_icon = $db->loadResult();
                        if($type_icon == ""){
                            $type_icon = "1.png";
                        }
                        ?>
                        var latlng<?php echo $row->id?> = [<?php echo $row->lat_add; ?>, <?php echo $row->long_add; ?>];
                        var placemark<?php echo $row->id?> = new ymaps.Placemark(latlng<?php echo $row->id?>);
                        placemark<?php echo $row->id?>.options.set("hasBalloon", true);
                        //placemark<?php echo $row->id?>.properties.set("hintContent", 'Place Mark new 1');
                        placemark<?php echo $row->id?>.options.set("iconImageHref", "<?php echo JURI::root()?>components/com_osproperty/images/assets/googlemapicons/<?php echo $type_icon;?>");
                        placemark<?php echo $row->id?>.options.set("iconImageSize", [34, 44]);
                        placemark<?php echo $row->id?>.options.set("iconImageOffset", [-7, -29]);
                        var contentStringHead<?php echo $row->id?> = '<div id="placemarkContent<?php echo $row->id?>">' +
                            '<h1 id="headContent<?php echo $row->id?>" class="placemarkHead"><?php echo $title; ?></h1>' +
                            '</div>';
                        <?php
                        $addInfo = array();
                        if($row->bed_room > 0){
                            $addInfo[] = $row->bed_room." ".JText::_('OS_BEDROOMS');
                        }
                        if($row->bath_room > 0){
                            $addInfo[] = OSPHelper::showBath($row->bath_room)." ".JText::_('OS_BATHROOMS');
                        }
                        if($row->rooms > 0){
                            $addInfo[] = $row->rooms." ".JText::_('OS_ROOMS');
                        }
                        ?>
                        var contentStringBody<?php echo $row->id?> = '<div class="row-fluid">' +
                            '<div class="span4">' +
                            '<a href="<?php echo JRoute::_("index.php?option=com_osproperty&task=property_details&id=".$row->id."&Itemid=".$itemid)?>"><img class="span12 thumbnail" src="<?php echo $row->photo?>" /></a>' +
                            '</div><div class="span8 ezitem-smallleftpad">' +
                            '<div class="row-fluid"><div class="span12 ospitem-maptitle title-blue"><?php echo $title;?></div></div>';
                        <?php
                        if(count($addInfo) > 0){
                        ?>
                        contentStringBody<?php echo $row->id?> += '<div class="ospitem-iconbkgr"><span class="ezitem-leftpad"><?php echo implode(" | ",$addInfo); ?></span></div>';
                        <?php
                        }
                        ?>
                        contentStringBody<?php echo $row->id?> += '<?php echo htmlspecialchars(str_replace("'","\"",str_replace("\r","",str_replace("\n","",$row->pro_small_desc))));?> <a href="<?php echo JRoute::_("index.php?option=com_osproperty&task=property_details&id=".$row->id."&Itemid=".$itemid)?>"><?php echo JText::_('OS_DETAILS');?></a></p>' +
                        '</div>' +
                        '</div>';
                        placemark<?php echo $row->id?>.properties.set("balloonContentHeader", contentStringHead<?php echo $row->id?>);
                        placemark<?php echo $row->id?>.properties.set("balloonContentBody", contentStringBody<?php echo $row->id?>);
                        placemark<?php echo $row->id?>.events.add("click", function (e) {
                        });
                        clustermarkers<?php echo $row->id?>.push(placemark<?php echo $row->id?>);
                        //placemark<?php echo $row->id?>.properties.set("clusterCaption", contentStringHeadCluster<?php echo $row->id?>);
                        //markerCluster<?php echo $rows[0]->id?>.add(clustermarkers<?php echo $row->id?>);
                        //geoResult.add(placemark<?php echo $row->id?>);
                        <?php
                    }
                }
                for($i=0;$i<count($rows);$i++){
                    $row = $rows[$i];
                    if(($row->show_address == 1) and ($row->lat_add != "") and ($row->long_add != "")){
                        ?>
                        markerCluster<?php echo $rows[0]->id?>.add(clustermarkers<?php echo $row->id?>);
                        geoResult.add(placemark<?php echo $row->id?>);
                        <?php
                    }
                }
                ?>
                map.addOverlay(geoResult);
                map.setBounds(geoResult.getBounds());
            }
            function PlacemarkByIDShow(p_id, p_action, p_zoom) {
                //alert("This feature is supported only when you enable it in map menu item property!");
            }
            /*]]>*/</script>
    <?php
    }

    /**
     * Load Google Map in Details page
     * @param $property
     */
    public static function loadGoogleMapDetails($property,$configClass,$style="position:relative;width: 100%; height: 300px",$toggleposition = 0){
        $db = JFactory::getDbo();
        $google_map_overlay = $configClass['goole_map_overlay'];
        if($google_map_overlay == ""){
            $google_map_overlay = "ROADMAP";
        }
        $google_map_resolution = $configClass['goole_map_resolution'];
        if($google_map_resolution == 0){
            $google_map_resolution = 15;
            $population = 150;
        }elseif(($google_map_resolution > 0) and ($google_map_resolution <= 5)){
            $population = 400000;
        }elseif(($google_map_resolution > 5) and ($google_map_resolution <= 10)){
            $population = 2000;
        }elseif(($google_map_resolution > 10) and ($google_map_resolution <= 15)){
            $population = 150;
        }else{
            $population = 100;
        }

        $db->setQuery("Select type_icon from #__osrs_types where id = '$row->pro_type'");
        $type_icon = $db->loadResult();
        if($type_icon == ""){
            $type_icon = "1.png";
        }
        ?>
        <script type="text/javascript">
            // <![CDATA[
            var map;
            var panorama;
            var centerPlace = new google.maps.LatLng(<?php echo $property->lat_add?>, <?php echo $property->long_add?>);
            var propertyListing = new google.maps.LatLng(<?php echo $property->lat_add?>, <?php echo $property->long_add?>);
            var citymap = {};
            citymap['chicago'] = {
                center: new google.maps.LatLng(<?php echo $property->lat_add?>, <?php echo $property->long_add?>),population: <?php echo $population;?>
            };

            function initMapPropertyDetails() {
                // Set up the map
                var streetview = new google.maps.StreetViewService();
                var mapOptions = {
                    center: centerPlace,
                    scrollwheel: false,
                    zoom: <?php echo $google_map_resolution;?>,
                    mapTypeId: google.maps.MapTypeId.<?php echo $google_map_overlay?>,
                    streetViewControl: false
                };
                map = new google.maps.Map(document.getElementById('googlemapdiv'), mapOptions);
				map.addListener('click', function() {
				    if(map.scrollwheel === false){
						map.setOptions({'scrollwheel': true});
						jQuery('#googlemapdiv').addClass('scrollon');
					}else{
						map.setOptions({'scrollwheel': false});
						jQuery('#googlemapdiv').removeClass('scrollon');
					}
				});

                // Setup the markers on the map
                <?php if($property->show_address == 1){?>
                var propertyListingMarkerImage =
                    new google.maps.MarkerImage(
                        '<?php echo JURI::root()?>components/com_osproperty/images/assets/googlemapicons/<?php echo $type_icon;?>');
                var propertyListingMarker = new google.maps.Marker({
                    position: propertyListing,
                    map: map,
                    icon: propertyListingMarkerImage,
                    title: 'Property ID <?php echo $row->id?>'
                });
                <?php }else {?>
                for (var city in citymap) {
                    var populationOptions = {
                        strokeColor: '#1D86A0',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: '#1D86A0',
                        fillOpacity: 0.35,
                        map: map,
                        center: citymap[city].center,
                        radius: Math.sqrt(citymap[city].population) * 100
                    };
                    // Add the circle for this city to the map.
                    cityCircle = new google.maps.Circle(populationOptions);
                }
                <?php } ?>

                // We get the map's default panorama and set up some defaults.
                // Note that we don't yet set it visible.
                panorama = map.getStreetView();
                streetview.getPanoramaByLocation(centerPlace, 25, function(data, status){
                    switch(status){
                        case google.maps.StreetViewStatus.OK:
                            panorama.setPosition(centerPlace);
                            panorama.setPov({
                                    heading: 265,
                                    zoom:1,
                                    pitch:0}
                            );
                            break;
                        case google.maps.StreetViewStatus.ZERO_RESULTS:
                            document.getElementById('togglebtn').style.display = "none";
                            break;
                        default:
                            document.getElementById('togglebtn').style.display = "none";
                    }
                });
            }

            function toggleStreetView() {
                var toggle = panorama.getVisible();
                if (toggle == false) {
                    panorama.setVisible(true);
                } else {
                    panorama.setVisible(false);
                }
            }

            window.onload=function(){
                if(window.initMapPropertyDetails) initMapPropertyDetails();
            }

            window.onunload=function(){
                if(typeof(GUnload)!="undefined") GUnload();
            }
            // ]]>
            </script>
        <?php
        if(($configClass['show_streetview'] == 1) and ($property->show_address == 1) and ($toggleposition == 0)){
            ?>
            <div id="toggle">
                <input type="button" id="togglebtn" class="btn btn-info btn-small" value="<?php echo JText::_('OS_TOGGLE_STREET_VIEW');?>" onclick="toggleStreetView();" />
            </div>
        <?php } ?>
        <div id="googlemapdiv" style="<?php echo $style; ?>"></div>
        <?php
        if(($configClass['show_streetview'] == 1) and ($property->show_address == 1) and ($toggleposition == 1)){
            ?>
            <div id="toggle">
                <input type="button" id="togglebtn" class="btn btn-info btn-small" value="<?php echo JText::_('OS_TOGGLE_STREET_VIEW');?>" onclick="toggleStreetView();" />
            </div>
        <?php } ?>
        <?php
    }


    /**
     * Load Google Map in Details page
     * @param $property
     */
    public static function loadYandexDetails($property,$configClass,$style="position:relative;width: 100%; height: 300px")
    {
        $db = JFactory::getDbo();
        $db->setQuery("Select type_icon from #__osrs_types where id = '$property->pro_type'");
        $type_icon = $db->loadResult();
        if($type_icon == ""){
            $type_icon = "1.png";
        }
        $google_map_overlay = $configClass['goole_map_overlay'];
        if($google_map_overlay == ""){
            $google_map_overlay = "ROADMAP";
        }
        $google_map_overlay = strtolower($google_map_overlay);
        $google_map_resolution = $configClass['goole_map_resolution'];
        if($google_map_overlay == "roadmap"){
            $google_map_overlay = "map";
        }
        if($google_map_resolution == 0){
            $google_map_resolution = 15;
            $population = 150;
        }elseif(($google_map_resolution > 0) and ($google_map_resolution <= 5)){
            $population = 400000;
        }elseif(($google_map_resolution > 5) and ($google_map_resolution <= 10)){
            $population = 2000;
        }elseif(($google_map_resolution > 10) and ($google_map_resolution <= 15)){
            $population = 150;
        }else{
            $population = 100;
        }

        $language = JFactory::getLanguage();
        $activate_lang = $language->getTag();
        $document = JFactory::getDocument();
        $document->addScript("http://api-maps.yandex.ru/2.0/?coordorder=longlat&amp;load=package.full&amp;lang=".$activate_lang);
        ?>
        <div id="YMapsID"  style="<?php echo $style;?>"></div><div id="YMapsCredit" class="zhym-credit"></div><div id="YMapsMainRoutePanel"><div id="YMapsMainRoutePanel_Total"></div></div><div id="YMapsRoutePanel"><div id="YMapsRoutePanel_Description"></div><div id="YMapsRoutePanel_Total"></div><div id="YMapsRoutePanel_Steps"></div></div>
        <script type="text/javascript" >/*<![CDATA[*/
        var map, mapcenter, geoResult, geoRoute;
        var searchControl, searchControlPMAP;
        var clustermarkers0;
        var markerCluster0;
        ymaps.ready(initialize);
        function initialize () {
            mapcenter = [<?php echo $property->lat_add;?>, <?php echo $property->long_add;?>];
            map = new ymaps.Map("YMapsID", {
                center: mapcenter,
                zoom: <?php echo $google_map_resolution;?>
            });
            geoResult = new ymaps.GeoObjectCollection();
            clustermarkers0 = [];
            markerCluster0 = new ymaps.Clusterer({ maxZoom: 14
                , clusterDisableClickZoom: false
                , synchAdd: false
                , showInAlphabeticalOrder: false
                , gridSize: 64
                , minClusterSize: 2
            });
            map.geoObjects.add(markerCluster0);
            if (map.behaviors.isEnabled('dblClickZoom'))
                map.behaviors.disable('dblClickZoom');
            map.behaviors.enable('scrollZoom');
            map.controls.add(new ymaps.control.ZoomControl());
            map.setType("yandex#<?php echo $google_map_overlay;?>");
            map.setZoom(9);
            map.options.set("minZoom",1);
            map.events.add("typechange", function (e) {
                map.zoomRange.get(map.getCenter()).then(function (range) {
                    if (map.getZoom() > range[1] )
                    {
                        map.setZoom(range[1]);
                    }
                });
            });
            minimap = new ymaps.control.MiniMap();
            minimap.expand();
            //map.controls.add(minimap);
            var toolbar = new ymaps.control.MapTools();
            map.controls.add(toolbar);
            document.getElementById("YMapsCredit").innerHTML = '';
            if (map.behaviors.isEnabled('rightMouseButtonMagnifier'))
                map.behaviors.disable('rightMouseButtonMagnifier');
            map.behaviors.enable('drag');
            //map.balloon.open([<?php echo $property->lat_add;?>, <?php echo $property->long_add;?>]);
            var latlng1= [<?php echo $property->lat_add;?>, <?php echo $property->long_add;?>];
            var placemark1= new ymaps.Placemark(latlng1);
            placemark1.options.set("hasBalloon", true);
           // placemark1.properties.set("hintContent", '');
            placemark1.options.set("iconImageHref", "<?php echo JURI::root()?>components/com_osproperty/images/assets/googlemapicons/<?php echo $type_icon;?>");
            placemark1.options.set("iconImageSize", [34,44]);
            //placemark1.options.set("iconImageOffset", [-7,-29]);
            var contentStringHead1 = '<div id="placemarkContent1">' +
                '<h1 id="headContent1" class="placemarkHead"><?php echo $property->pro_name; ?></h1>'+
                '</div>';
            var contentStringHeadCluster1 = '<div id="placemarkContentCluster1">' +
                '<span id="headContentCluster1" class="placemarkHeadCluster"><?php echo $property->pro_name; ?></span>'+
                '</div>';
            //var contentStringBody1 = '<div id="bodyContent1"  class="placemarkBody"></div>';
            //placemark1.properties.set("balloonContentHeader", contentStringHead1);
            //placemark1.properties.set("balloonContentBody", contentStringBody1);
            //placemark1.events.add("click", function (e) {
            //});
            clustermarkers0.push(placemark1);
            //placemark1.properties.set("clusterCaption", contentStringHeadCluster1);
            markerCluster0.add(clustermarkers0);
        }
        function PlacemarkByIDShow(p_id, p_action, p_zoom) {
            //alert("This feature is supported only when you enable it in map menu item property!");
        }
        /*]]>*/</script>
        <?php
    }
}
?>