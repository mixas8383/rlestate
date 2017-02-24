<?php
/* ------------------------------------------------------------------------
  # locator.html.php - Ossolution Property
  # ------------------------------------------------------------------------
  # author    Dang Thuc Dam
  # copyright Copyright (C) 2016 joomdonation.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  # Websites: http://www.joomdonation.com
  # Technical Support:  Forum - http://www.joomdonation.com/forum.html
 */

// No direct access.
defined('_JEXEC') or die;

class HTML_OspropertyLocator
{

    /**
     * Locator Search Html
     *
     * @param unknown_type $option
     * @param unknown_type $agent
     */
    static function locatorSearchHtml($option, $rows, $lists, $locator_type, $search_lat, $search_long)
    {
        global $mainframe, $configClass, $jinput;
        if ($search_lat == "")
        {
            $search_lat = $configClass['goole_default_lat'];
        }
        if ($search_long == "")
        {
            $search_long = $configClass['goole_default_long'];
        }
        $db = JFactory::getDbo();
        $country_code = "";
        if (!HelperOspropertyCommon::checkCountry())
        {
            $country_id = HelperOspropertyCommon::getDefaultCountry();
            $db->setQuery("Select country_code from #__osrs_countries where id = '$country_id'");
            $country_code = $db->loadResult();
        }

        JHTML::_('behavior.tooltip');
        $division_col = 0;

        $mapheight = 800;
        ?>
        <script type="text/javascript">
            function checkCats() {
                var cat_elements = document.getElementsByName('categoryArr[]');
                var check_all_cats = document.getElementById('check_all_cats');
                if (check_all_cats.value == 1) {
                    check_all_cats.value = 0;
                    for (var i = 0; i < cat_elements.length; i++) {
                        cat_elements[i].checked = false;
                    }
                } else {
                    check_all_cats.value = 1;
                    for (var i = 0; i < cat_elements.length; i++) {
                        cat_elements[i].checked = true;
                    }
                }
            }
            function submitForm() {
                var radius_search = document.getElementById('radius_search');
                if (radius_search.value != "") {
                    document.profileForm.submit();
                } else {
                    document.profileForm.submit();
                }
            }

            function checkingLocatorForm() {
                var form = document.profileForm;
                var location = form.location;
                if (location.value == "") {
                    alert("<?php echo JText::_('OS_PLEASE_ENTER_ADDRESS'); ?>");
                    location.focus();
                } else {
                    document.profileForm.submit();
                }
            }
        </script>

        <?php
        OSPHelper::generateHeading(2, JText::_('OS_SEARCH_LOCATOR'));
        ?>

        <div id="notice" style="display:none;">
        </div>
        <div class="clearfix"></div>
        <form method="POST"
              action="<?php echo JRoute::_('index.php?option=com_osproperty&view=lsearch&Itemid=' . $jinput->getInt('Itemid', 0)) ?>"
              name="profileForm" id="profileForm" enctype="multipart/form-data">
            <div class="mainframe_search">
                <?php
                if (($configClass['locator_type_ids'] == "0") or ( $configClass['locator_type_ids'] == ""))
                {
                    HelperOspropertyCommon::generateLocatorForm($lists, $locator_type);
                } else
                {
                    $locator_type_ids = $configClass['locator_type_ids'];
                    $locator_type_idsArr = explode("|", $locator_type_ids);
                    ?>
                    <div class="row-fluid">
                        <ul class="nav nav-tabs">
                            <?php
                            for ($i = 0; $i < count($locator_type_idsArr); $i++)
                            {
                                $tid = $locator_type_idsArr[$i];
                                $db->setQuery("Select * from #__osrs_types where id = '$tid'");
                                $ptype = $db->loadObject();
                                $type_name = OSPHelper::getLanguageFieldValue($ptype, 'type_name');
                                if ($locator_type > 0)
                                {
                                    if ($tid == $locator_type)
                                    {
                                        $active = "class='active'";
                                    } else
                                    {
                                        $active = "";
                                    }
                                } else
                                {
                                    if ($i == 0)
                                    {
                                        $active = "class='active'";
                                        $locator_type = $locator_type_idsArr[0];
                                    } else
                                    {
                                        $active = "";
                                    }
                                }
                                ?>
                                <li <?php echo $active; ?> ><a
                                        href="<?php echo JRoute::_('index.php?option=com_osproperty&view=lsearch&locator_type=' . $tid . '&Itemid=' . $jinput->getInt('Itemid', 0)) ?>"><?php echo $type_name; ?></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="<?php echo strtolower(str_replace(" ", "_", $type_name)) ?>">
                                <?php
                                HelperOspropertyCommon::generateLocatorForm($lists, $locator_type);
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
                OSPHelper::showPriceTypesConfig();
                ?>
                <script type="text/javascript">
                    //filter form with property type and price
                    jQuery("#property_type").change(function () {
                        updateLocatorPrice(jQuery("#property_type").val(), "<?php echo JUri::root(); ?>");
                    });
                    function updateLocatorPrice(type_id, live_site) {
                        xmlHttp = GetXmlHttpObject();
                        url = live_site + "index.php?option=com_osproperty&no_html=1&tmpl=component&task=ajax_updatePrice&type_id=" + type_id + "&option_id=<?php echo $lists['price_value']; ?>&min_price=<?php echo $lists['min_price']; ?>&max_price=<?php echo $lists['max_price']; ?>&module_id=adv";
                        xmlHttp.onreadystatechange = ajax_updateLocatorSearch;
                        xmlHttp.open("GET", url, true)
                        xmlHttp.send(null)
                    }

                    function ajax_updateLocatorSearch() {
                        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
                            var mod_osservice_price = document.getElementById("locator_price");
                            if (mod_osservice_price != null) {
                                mod_osservice_price.innerHTML = xmlHttp.responseText;
                                var ptype = jQuery("#property_type").val();
                                jQuery.ui.slider.prototype.widgetEventPrefix = 'slider';
                                jQuery(function () {
                                    var min_value = jQuery("#min" + ptype).val();
                                    min_value = parseFloat(min_value);
                                    var step_value = jQuery("#step" + ptype).val();
                                    step_value = parseFloat(step_value);
                                    var max_value = jQuery("#max" + ptype).val();
                                    max_value = parseFloat(max_value);
                                    jQuery("#advsliderange").slider({
                                        range: true,
                                        min: min_value,
                                        step: step_value,
                                        max: max_value,
                                        values: [min_value, max_value],
                                        slide: function (event, ui) {
                                            var price_from = ui.values[0];
                                            var price_to = ui.values[1];
                                            jQuery("#advprice_from_input1").val(price_from);
                                            jQuery("#advprice_to_input1").val(price_to);

                                            price_from = price_from.formatMoney(0, ',', '.');
                                            price_to = price_to.formatMoney(0, ',', '.');

                                            jQuery("#advprice_from_input").text(price_from);
                                            jQuery("#advprice_to_input").text(price_to);
                                        }
                                    });
                                });
                                Number.prototype.formatMoney = function (decPlaces, thouSeparator, decSeparator) {
                                    var n = this,
                                            decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
                                            decSeparator = decSeparator == undefined ? "." : decSeparator,
                                            thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
                                            sign = n < 0 ? "-" : "",
                                            i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
                                            j = (j = i.length) > 3 ? j % 3 : 0;
                                    return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
                                };
                            }
                        }
                    }

                </script>
                <div class="clearfix"></div>
                <div class="result_search" style="">
                    <?php //if (count($rows)){
                    ?>
                    <?php
                    if (($lists['location'] == "") or ( count($rows) == 0))
                    {
                        $class = "span12";
                    } else
                    {
                        $class = "span7";
                    }
                    ?>
                    <div class="row-fluid">
                        <div class="<?php echo $class ?>" id="mapDiv">
                            <?php
                            $zoomlevel = 7;
                            if (isset($configClass['goole_map_resolution']) && $configClass['goole_map_resolution'] != '')
                            {
                                $zoomlevel = $configClass['goole_map_resolution'];
                            }
                            $lladd = $rows[0]->lat_add . "," . $rows[0]->long_add;
                            ?>
                            <?php
                            $geocode = array();
                            for ($i = 0; $i < count($rows); $i++)
                            {
                                $row = $rows[$i];
                                $geocode[$i]->id = $row->id;
                                if (($row->lat_add == "") or ( $row->long_add == ""))
                                {
                                    //find the address
                                    $return = HelperOspropertyGoogleMap::findAddress($option, $row, '', 0);
                                    $lat = $return[0];
                                    $long = $return[1];
                                    $db->setQuery("UPDATE #__osrs_properties SET lat_add = '$lat',long_add='$long' WHERE id = '$row->id'");
                                    $db->query();
                                    $row->lat_add = $lat;
                                    $row->long_add = $long;
                                }
                                $geocode[$i]->show_address = $row->show_address;
                                $geocode[$i]->lat = $row->lat_add;
                                $geocode[$i]->long = $row->long_add;
                                $lladd = "$row->lat_add,$row->long_add";
                                $popup = "<div style='width:100%;'><div style='float:left;margin-right:10px;'>";

                                // image
                                $db->setQuery("Select * from #__osrs_photos where pro_id = '$row->id' order by ordering limit 1");
                                $photo = $db->loadObjectList();
                                if (count($photo) > 0)
                                {
                                    $photo = $photo[0];
                                    $popup .= "<img src='" . JURI::root() . "images/osproperty/properties/" . $row->id . "/thumb/" . $photo->image . "'style='width:50px;' class='img-polaroid' />";
                                } else
                                {
                                    $popup .= "<img src='" . JURI::root() . "components/com_osproperty/images/assets/nopropertyphoto.png' style='width:50px;' class='img-polaroid' />";
                                }
                                $popup .= "</div>";

                                $popup .= "<strong>" . $row->pro_name;
                                if ($row->ref != "")
                                {
                                    $popup .= " (" . $row->ref . ")";
                                }
                                $popup .= "</strong>";
                                if ($row->show_address == 1)
                                {
                                    $popup .= "<BR />";
                                    $popup .= OSPHelper::generateAddress($row);
                                }
                                $popup .= "</div>";
                                $geocode[$i]->content = $popup;
                                $geocode[$i]->title = $row->pro_name;
                            }
                            //adjust the same coordinates
                            $duplicate = OSPHelper::findGoogleDuplication($rows);
                            ?>
                            <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
                            <?php
                            HelperOspropertyGoogleMap::loadGoogleScript('libraries=places');
                            ?>
                            <script type='text/javascript' src='<?php echo JUri::root() ?>components/com_osproperty/js/markerclusterer.js'></script>
                            <link rel="stylesheet" href="<?php echo JURI::root() ?>components/com_osproperty/style/jquery-ui.css" type="text/css"/>
                            <script type="text/javascript">
                    jQuery.noConflict();
                    (function ($) {
                        jQuery(document).ready(function () {
                            var markers = [];
                            var markerIndex = 0;
                            var markerArray = [];
                            var infowindow;
                            var cityCircle;
                            var gmarkers = [];
                            var min = .999999;
                            var max = 1.000001;
                            var myHome = new google.maps.LatLng(<?php echo $search_lat; ?>, <?php echo $search_long ?>);

        <?php
        for ($i = 0; $i < count($duplicate); $i++)
        {
            $item = $duplicate[$i];
            $key = OSPHelper::find_key($item->id, $rows);
            if (($rows[$key]->show_address == 1) and ( $rows[$key]->lat_add != "") and ( $rows[$key]->long_add != ""))
            {
                ?>
                                    var propertyListing<?php echo $rows[$key]->id ?> = new google.maps.LatLng(<?php echo $rows[$key]->lat_add; ?>, <?php echo $rows[$key]->long_add; ?>);
                <?php
            }
        }
        ?>
                            var styles = [
                                {
                                    stylers: [
                                        {hue: "#B1BDD6"},
                                        {saturation: -20}
                                    ]
                                },
                                {
                                    "featureType": "landscape.natural",
                                    "elementType": "geometry",
                                    "stylers": [
                                        {
                                            "color": "#d0e3b4"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "poi.park",
                                    "elementType": "geometry",
                                    "stylers": [
                                        {
                                            "color": "#bde6ab"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.highway",
                                    "elementType": "geometry.fill",
                                    "stylers": [
                                        {
                                            "color": "#ffe15f"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.highway",
                                    "elementType": "geometry.stroke",
                                    "stylers": [
                                        {
                                            "color": "#efd151"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.arterial",
                                    "elementType": "geometry.fill",
                                    "stylers": [
                                        {
                                            "color": "#ffffff"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.local",
                                    "elementType": "geometry.fill",
                                    "stylers": [
                                        {
                                            "color": "black"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "transit.station.airport",
                                    "elementType": "geometry.fill",
                                    "stylers": [
                                        {
                                            "color": "#cfb2db"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "water",
                                    "elementType": "geometry",
                                    "stylers": [
                                        {
                                            "color": "#B1BDD6"
                                        }
                                    ]
                                },
                                {
                                    featureType: "road",
                                    elementType: "geometry",
                                    stylers: [
                                        {lightness: 100},
                                        {visibility: "simplified"}
                                    ]
                                }, {
                                    featureType: "road",
                                    elementType: "labels",
                                    stylers: [
                                        {visibility: "off"}
                                    ]
                                }
                            ];

                            // Create a new StyledMapType object, passing it the array of styles,
                            // as well as the name to be displayed on the map type control.
                            var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});

                            var mapOptions = {
                                zoom: 13,
                                streetViewControl: true,
                                mapTypeControl: true,
                                panControl: true,
                                center: myHome,
                                icon: "<?php echo JURI::root() . 'components/com_osproperty/images/assets/2-default.png' ?>",
                                mapTypeControl:false,
                                        mapTypeControlOptions: {
                                            mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
                                        },
                                zoomControl: true,
                                zoomControlOptions: {
                                    position: google.maps.ControlPosition.LEFT_BOTTOM
                                },
                                scaleControl: true,
                                streetViewControl: true,
                                        streetViewControlOptions: {
                                            position: google.maps.ControlPosition.BOTTOM_LEFT
                                        }

                            };
                            var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
                            map.mapTypes.set('map_style', styledMap);
                            map.setMapTypeId('map_style');

        <?php
        if ($lists['search_my_location'] == 1)
        {
            ?>

                                var mylocation = new google.maps.Marker({
                                    position: myHome,
                                    animation: google.maps.Animation.DROP,
                                    map: map,
                                    icon: "<?php echo JURI::root() . 'components/com_osproperty/images/assets/userpin.png' ?>"
                                });
                                var myCircle = new google.maps.Circle({
                                    strokeWeight: 0,
                                    fillColor: "#008595",
                                    fillOpacity: 0.25,
                                    radius: 50,
                                    map: map,
                                    center: myHome,
                                    radius: jQuery('#radius_search').val() * 1000
                                });
        <?php } ?>


                            var infoWindow = new google.maps.InfoWindow();
                            var markerBounds = new google.maps.LatLngBounds();
                            var tempBound = new google.maps.LatLngBounds();
                            jQuery('#togglebtn').click(function () {
                                if (jQuery("#mapDiv").hasClass("span7")) {
                                    jQuery("#mapDiv").removeClass("span7");
                                    jQuery("#mapDiv").addClass("span12");
                                    jQuery("#listPropertiesDiv").hide();
                                    google.maps.event.trigger(map, 'resize');
                                    map.fitBounds(markerBounds);
        <?php
        if ($lists['search_my_location'] == 1)
        {
            ?>
                                        markerBounds.extend(myHome);
                                        map.fitBounds(markerBounds);
                                        //map.setCenter(myHome); 
        <?php } ?>
                                    jQuery('#togglebtn').empty().append('<img src="<?php echo JUri::root(); ?>components/com_osproperty/images/assets/exit_full_screen.png" style="width:25px !important;" alt="<?php JText::_("OS_EXIT_FULL_SCREEN"); ?>"/>');
                                } else {
                                    jQuery("#mapDiv").removeClass("span12");
                                    jQuery("#mapDiv").addClass("span7");
                                    jQuery("#listPropertiesDiv").show();
                                    google.maps.event.trigger(map, 'resize');
                                    map.fitBounds(markerBounds);
        <?php
        if ($lists['search_my_location'] == 1)
        {
            ?>
                                        markerBounds.extend(myHome);
                                        map.fitBounds(markerBounds);
        <?php } ?>
                                    jQuery('#togglebtn').empty().append('<img src="<?php echo JUri::root(); ?>components/com_osproperty/images/assets/full_screen.png" style="width:25px !important;" alt="<?php JText::_("OS_FULL_SCREEN"); ?>"/>');
                                }
                                return false;
                            });

                            function makeMarker(options) {
                                var pushPin = new google.maps.Marker({map: map});
                                pushPin.setOptions(options);

                                google.maps.event.addListener(pushPin, 'click', function () {
                                    infoWindow.setOptions(options);
                                    infoWindow.open(map, pushPin);
                                    map.panTo(pushPin.getPosition());
                                    map.setZoom(20);
                                });
                                google.maps.event.addListener(pushPin, 'mouseover', function () {
                                    pushPin.setAnimation(google.maps.Animation.BOUNCE);
                                });
                                google.maps.event.addListener(pushPin, 'mouseout', function () {
                                    pushPin.setAnimation(null);
                                });
                                markerArray.push(pushPin);
                                return pushPin;
                            }

                            google.maps.event.addListener(map, 'click', function () {
                                infoWindow.close();
                            });

        <?php
        $showfit = 0;
        for ($i = 0; $i < count($duplicate); $i++)
        {

            $item = $duplicate[$i];
            $key = OSPHelper::find_key($item->id, $rows);
            if (count($item->value) == 0)
            { //having no duplication
                $row = $rows[$key];
                $row->mapid = $i;
                $needs = array();
                $needs[] = "property_details";
                $needs[] = $row->id;
                $itemid = OSPRoute::getItemid($needs);
                $title = "";
                if ($row->ref != "")
                {
                    $title .= $row->ref . ",";
                }
                $title .= $row->pro_name;
                $title = str_replace("'", "", $title);
                $title = htmlspecialchars($title);
                $created_on = $row->created;
                $modified_on = $row->modified;
                $created_on = strtotime($created_on);
                $modified_on = strtotime($modified_on);

                $addInfo = array();
                if ($row->bed_room > 0)
                {
                    $addInfo[] = $row->bed_room . " " . JText::_('OS_BEDROOMS');
                }
                if ($row->bath_room > 0)
                {
                    $addInfo[] = OSPHelper::showBath($row->bath_room) . " " . JText::_('OS_BATHROOMS');
                }
                if ($row->rooms > 0)
                {
                    $addInfo[] = $row->rooms . " " . JText::_('OS_ROOMS');
                }
                ?>
                                    var contentString<?php echo $row->id ?> = '<div class="row-fluid">' +
                                            '<div class="span4">' +
                                            '<a href="<?php echo JRoute::_("index.php?option=com_osproperty&task=property_details&id=" . $row->id . "&Itemid=" . $itemid) ?>"><img class="span12 thumbnail" src="<?php echo $row->photo ?>" /></a>' +
                                            '</div><div class="span8 ezitem-smallleftpad">' +
                                            '<div class="row-fluid"><div class="span12 ospitem-maptitle title-blue"><?php echo $title; ?></div></div>';
                <?php
                if (count($addInfo) > 0)
                {
                    ?>
                                        contentString<?php echo $row->id ?> += '<div class="ospitem-iconbkgr"><span class="ezitem-leftpad"><?php echo implode(" | ", $addInfo); ?></span></div>';
                    <?php
                }
                ?>
                                    contentString<?php echo $row->id ?> += '<?php echo htmlspecialchars(str_replace("'", "\"", str_replace("\r", "", str_replace("\n", "", $row->pro_small_desc)))); ?> <a href="<?php echo JRoute::_("index.php?option=com_osproperty&task=property_details&id=" . $row->id . "&Itemid=" . $itemid) ?>"><?php echo JText::_('OS_DETAILS'); ?></a></p>' +
                                            '</div>' +
                                            '</div>';
                <?php
                //if(($row->show_address == 1) and ($row->lat_add != "") and ($row->long_add != "")){
                $show_map = 1;
                $db->setQuery("Select type_icon from #__osrs_types where id = '$row->pro_type'");
                $type_icon = $db->loadResult();
                if ($type_icon == "")
                {
                    $type_icon = "1.png";
                }
                ?>
                                    makeMarker({
                                        position: propertyListing<?php echo $row->id ?>,
                                        title: "<?php echo $title; ?>",
                                        content: contentString<?php echo $row->id ?>,
                                        animation: google.maps.Animation.DROP,
                                        icon: new google.maps.MarkerImage('<?php echo JURI::root() ?>components/com_osproperty/images/assets/googlemapicons/<?php echo $type_icon; ?>')
                                                    });
                <?php
                // }
            } else
            { //having duplication
                $row = $rows[$key];
                $row->mapid = $i;
                $itemIdArr = array();
                $titleArr = array();
                $descArr = array();

                $needs = array();
                $needs[] = "property_details";
                $needs[] = $row->id;
                $itemid = OSPRoute::getItemid($needs);
                $itemIdArr[] = $itemid;

                $title = "";
                if ($row->ref != "")
                {
                    $title .= $row->ref . ",";
                }
                $title .= $row->pro_name;
                $title = str_replace("'", "", $title);
                $title = htmlspecialchars($title);
                $titleArr[] = $title;

                $addInfo = array();
                if ($row->bed_room > 0)
                {
                    $addInfo[] = $row->bed_room . " " . JText::_('OS_BEDROOMS');
                }
                if ($row->bath_room > 0)
                {
                    $addInfo[] = OSPHelper::showBath($row->bath_room) . " " . JText::_('OS_BATHROOMS');
                }
                if ($row->rooms > 0)
                {
                    $addInfo[] = $row->rooms . " " . JText::_('OS_ROOMS');
                }
                $desc = '<div class="row-fluid"><div class="span4"><a href="' . JRoute::_("index.php?option=com_osproperty&task=property_details&id=" . $row->id . "&Itemid=" . $itemid) . '"><img class="span12 thumbnail" src="' . $row->photo . '" /></a></div><div class="span8 ezitem-smallleftpad"><div class="row-fluid"><div class="span12 ospitem-maptitle title-blue">' . $title . '</div></div>';
                if (count($addInfo) > 0)
                {
                    $desc .= '<div class="ospitem-iconbkgr"><span class="ezitem-leftpad">' . implode(" | ", $addInfo) . '</span></div>';
                }
                $desc .= htmlspecialchars(str_replace("'", "\"", str_replace("\r", "", str_replace("\n", "", $row->pro_small_desc)))) . '<a href="' . JRoute::_("index.php?option=com_osproperty&task=property_details&id=" . $row->id . "&Itemid=" . $itemid) . '">' . JText::_('OS_DETAILS') . '</a></p></div></div>';
                $descArr[] = $desc;
                $l = 1;
                foreach ($item->value as $value)
                {
                    $key = OSPHelper::find_key($value, $rows);
                    $dupItem = $rows[$key];
                    $dupItem->mapid = $i;
                    $dupItem->subid = $l;
                    $l++;
                    $needs = array();
                    $needs[] = "property_details";
                    $needs[] = $dupItem->id;
                    $itemid = OSPRoute::getItemid($needs);
                    $itemIdArr[] = $itemid;

                    $title = "";
                    if ($dupItem->ref != "")
                    {
                        $title .= $dupItem->ref . ",";
                    }
                    $title .= $dupItem->pro_name;
                    $title = str_replace("'", "", $title);
                    $title = htmlspecialchars($title);
                    $titleArr[] = $title;

                    $addInfo = array();
                    if ($dupItem->bed_room > 0)
                    {
                        $addInfo[] = $dupItem->bed_room . " " . JText::_('OS_BEDROOMS');
                    }
                    if ($dupItem->bath_room > 0)
                    {
                        $addInfo[] = OSPHelper::showBath($dupItem->bath_room) . " " . JText::_('OS_BATHROOMS');
                    }
                    if ($dupItem->rooms > 0)
                    {
                        $addInfo[] = $dupItem->rooms . " " . JText::_('OS_ROOMS');
                    }
                    $desc = '<div class="row-fluid"><div class="span4"><a href="' . JRoute::_("index.php?option=com_osproperty&task=property_details&id=" . $dupItem->id . "&Itemid=" . $itemid) . '"><img class="span12 thumbnail" src="' . $dupItem->photo . '" /></a></div><div class="span8 ezitem-smallleftpad"><div class="row-fluid"><div class="span12 ospitem-maptitle title-blue">' . $title . '</div></div>';
                    if (count($addInfo) > 0)
                    {
                        $desc .= '<div class="ospitem-iconbkgr"><span class="ezitem-leftpad">' . implode(" | ", $addInfo) . '</span></div>';
                    }
                    $desc .= htmlspecialchars(str_replace("'", "\"", str_replace("\r", "", str_replace("\n", "", $dupItem->pro_small_desc)))) . '<a href="' . JRoute::_("index.php?option=com_osproperty&task=property_details&id=" . $dupItem->id . "&Itemid=" . $itemid) . '">' . JText::_('OS_DETAILS') . '</a></p></div></div>';
                    $descArr[] = $desc;
                }

                $desc = implode('<div class="clearfix" style="height:25px;border-top:1px dotted #efefef;"></div>', $descArr);
                ?>

                                                    var contentString<?php echo $row->id ?> = '<?php echo $desc; ?>';
                <?php
                $show_map = 1;
                $db->setQuery("Select type_icon from #__osrs_types where id = '$row->pro_type'");
                $type_icon = $db->loadResult();
                if ($type_icon == "")
                {
                    $type_icon = "1.png";
                }
                ?>
                                                    makeMarker({
                                                        position: propertyListing<?php echo $row->id ?>,
                                                        title: "<?php echo JText::_('OS_MULTIPLE_PROPERTIES'); ?>",
                                                        content: contentString<?php echo $row->id ?>,
                                                        animation: google.maps.Animation.DROP,
                                                        icon: new google.maps.MarkerImage('<?php echo JURI::root() ?>components/com_osproperty/images/assets/googlemapicons/<?php echo $type_icon; ?>')
                                                                    });

                <?php
            }
            ?>

                                                                jQuery("#item<?php echo $i ?>").click(function () {
                                                                    google.maps.event.trigger(markerArray[<?php echo $i ?>], 'click');
                                                                })
                                                                jQuery("#divitem<?php echo $i ?>").mouseover(function () {
                                                                    google.maps.event.trigger(markerArray[<?php echo $i ?>], 'mouseover');
                                                                })
                                                                jQuery("#divitem<?php echo $i ?>").mouseout(function () {
                                                                    google.maps.event.trigger(markerArray[<?php echo $i ?>], 'mouseout');
                                                                })
                                                                jQuery("#pitem<?php echo $i ?>").click(function () {
                                                                    google.maps.event.trigger(markerArray[<?php echo $i ?>], 'click');
                                                                })
            <?php
            if ($l > 0)
            {
                $l--;
                for ($l1 = 1; $l1 <= $l; $l1++)
                {
                    ?>
                                                                        jQuery("#item<?php echo $i ?>_<?php echo $l1 ?>").click(function () {
                                                                            google.maps.event.trigger(markerArray[<?php echo $i ?>], 'click');
                                                                        })
                                                                        jQuery("#pitem<?php echo $i ?>_<?php echo $l1 ?>").click(function () {
                                                                            google.maps.event.trigger(markerArray[<?php echo $i ?>], 'click');
                                                                        })
                    <?php
                }
            }
            ?>
                                                                gmarkers.push(markerArray[<?php echo $i ?>]);
                                                                markerBounds.extend(propertyListing<?php echo $row->id ?>);

            <?php
        }

        $showfit = 1;
        if ($showfit == 1)
        {
            ?>
                                                                map.fitBounds(markerBounds);
            <?php
            if ($lists['search_my_location'] == 1)
            {
                ?>
                                                                    markerBounds.extend(myHome);
                                                                    map.fitBounds(markerBounds);
            <?php } ?>
            <?php
        }
        ?>
                                                            clusterStyles = [
                                                                {
                                                                    textColor: '#ffffff',
                                                                    opt_textColor: '#ffffff',
                                                                    url: '<?php echo Juri::root() ?>components/com_osproperty/images/assets/cloud.png',
                                                                    height: 72,
                                                                    width: 72,
                                                                    textSize: 20
                                                                }
                                                            ];
                                                            var mcOptions = {gridSize: 50, maxZoom: 15, styles: clusterStyles};
                                                            var markerCluster = new MarkerClusterer(map, gmarkers, mcOptions);


                                                            var geocoder = new google.maps.Geocoder();
                                                            jQuery(function () {
                                                                jQuery("#location").autocomplete({
                                                                    source: function (request, response) {
                                                                        if (geocoder == null) {
                                                                            geocoder = new google.maps.Geocoder();
                                                                        }
        <?php
        if ($country_code != "")
        {
            ?>
                                                                            geocoder.geocode({'address': request.term, 'componentRestrictions':{'country':'<?php echo $country_code; ?>'}}, function (results, status) {
        <?php } else
        {
            ?>
                                                                                geocoder.geocode({'address': request.term}, function (results, status) {
        <?php } ?>
                                                                                if (status == google.maps.GeocoderStatus.OK) {

                                                                                    var searchLoc = results[0].geometry.location;
                                                                                    var lat = results[0].geometry.location.lat();
                                                                                    var lng = results[0].geometry.location.lng();
                                                                                    var latlng = new google.maps.LatLng(lat, lng);
                                                                                    var bounds = results[0].geometry.bounds;

                                                                                    var marker = new google.maps.Marker({
                                                                                        draggable: false,
                                                                                        raiseOnDrag: false,
                                                                                        position: latlng,
                                                                                        map: map,
                                                                                        icon: "<?php echo JURI::root() . 'components/com_osproperty/images/assets/2-default.png' ?>"
                                                                                    });

                                                                                    var circle = new google.maps.Circle({
                                                                                        map: map,
                                                                                        radius: 1609.344 * jQuery('#radius_search').val(), // 1 mile
                                                                                        strokeColor: '#FFFFFF',
                                                                                        fillColor: '#FFFFFF',
                                                                                        fillOpacity: 0,
                                                                                        strokeWeight: 1,
                                                                                        editable: false
                                                                                    });
                                                                                    circle.bindTo('center', marker, 'position');

                                                                                    geocoder.geocode({'latLng': latlng}, function (results1, status1) {
                                                                                        if (status1 == google.maps.GeocoderStatus.OK) {
                                                                                            if (results1[1]) {
                                                                                                response($.map(results1, function (loc) {
                                                                                                    return {
                                                                                                        label: loc.formatted_address,
                                                                                                        value: loc.formatted_address,
                                                                                                        bounds: loc.geometry.bounds
                                                                                                    }
                                                                                                }));
                                                                                            }
                                                                                        }
                                                                                    });
                                                                                }
                                                                            });
                                                                        },
                                                                                select: function (event, ui) {
                                                                                var pos = ui.item.position;
                                                                                var lct = ui.item.locType;
                                                                                var bounds = ui.item.bounds;
                                                                                if (bounds) {
                                                                                    jQuery('#location').change(function () {
                                                                                        map.fitBounds(bounds);
        <?php
        if ($lists['search_my_location'] == 1)
        {
            ?>
                                                                                            markerBounds.extend(myHome);
                                                                                            map.fitBounds(markerBounds);
        <?php } ?>
                                                                                    });
                                                                                }
                                                                            }
                                                                });
                                                                function openMarker(i) {
                                                                    google.maps.event.trigger(markerArray[i], 'click');
                                                                }
                                                                ;
                                                                function makerOver(i) {
                                                                    google.maps.event.trigger(markerArray[i], 'mouseover');
                                                                }

                                                                function makerOut(i) {
                                                                    google.maps.event.trigger(markerArray[i], 'mouseout');
                                                                }
                                                            });
                                                        });
                                                    })(jQuery);

                                                    function showOption() {
                                                        var more_option_link = document.getElementById('more_option_link');
                                                        var more_option_div = document.getElementById('more_option_div');
                                                        if (more_option_div.style.display == "none") {
                                                            more_option_link.innerHTML = "<?php echo JText::_('OS_LESS_OPTION'); ?>";
                                                            more_option_div.style.display = "block";
                                                        } else {
                                                            more_option_link.innerHTML = "<?php echo JText::_('OS_MORE_OPTION'); ?>";
                                                            more_option_div.style.display = "none";
                                                        }
                                                    }

                                                    function updateOrderBy(value) {
                                                        var orderby = document.getElementById('orderby');
                                                        orderby.value = value;
                                                        document.getElementById('profileForm').submit();
                                                    }
                                                    function updateSortBy(value) {
                                                        var orderby = document.getElementById('sortby');
                                                        orderby.value = value;
                                                        document.getElementById('profileForm').submit();
                                                    }
                            </script>
                            <?php
                            if (count($rows) > 0)
                            {
                                ?>
                                <div id="toggle" class="gmapcontroller" style="">
                                    <span id="togglebtn" class="gmapcontroller_fullscreen">
                                        <img src="<?php echo JUri::root(); ?>components/com_osproperty/images/assets/full_screen.png" style="width:25px !important;" alt="<?php JText::_('OS_FULL_SCREEN'); ?>"/>
                                    </span>
                                </div>
                                <?php
                            }
                            if (($lists['location'] != "") and ( count($rows) == 0))
                            {
                                ?>
                                <div id="gmap-noresult">
                                <?php echo JText::_('OS_WE_DIDNOT_FIND_ANY_RESULTS'); ?>
                                </div>
                                <?php
                            }

                            if ($lists['location'] == "")
                            {
                                ?>
                                <div id="gmap-noresult">
                                <?php echo JText::_('OS_PLEASE_ENTER_LOCATION'); ?>
                                </div>
                                <?php
                            }
                            ?>
                            <!-- Notice -->
                            <?php
                            if ((count($rows) > 0) and ( (int) $configClass['max_locator_results'] > 0))
                            {
                                ?>
                                <div id="locator_map_notice" class="locator_map_notice hidden-phone" style="">
                                    <strong><?php echo sprintf(JText::_('OS_ONLY_SHOW_PROPERTIES'), $configClass['max_locator_results']); ?></strong> <?php echo JText::_('OS_USE_FILTER_TO_NARROW_YOUR_SEARCH'); ?>
                                </div>
        <?php } ?>
                            <!-- End Notice -->
                            <div id="map_canvas" style="max-width:100%;width:auto; height: 600px;padding:5px;"></div>
                        </div>

                        <?php
                        if ($lists['location'] != "")
                        {
                            ?>
                            <div class="span5 hidden-phone" id="listPropertiesDiv">
                                <?php
                                if (count($rows) > 0)
                                {
                                    ?>
                                    <div class="property_listing_left" style="height: 600px;">
                                        <div class="clearfix"></div>
                                        <div class="header_property_listing"><?php echo JText::_('OS_PROPERTIES_LIST') ?>
                                            (<?php echo count($rows); ?>)
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row-fluid">
                                            <div class="span12" style="padding-left:10px;">
                                                <a href="javascript:void(0);" id="gridviewbtn" title="<?php echo JText::_('OS_CHANGE_TO_GRID_VIEW'); ?>">
                                                    <img src="<?php echo JUri::root(); ?>components/com_osproperty/images/assets/gridview.png" style="width:25px;border:1px solid #CCC !important;;"/>
                                                </a>
                                                <a href="javascript:void(0);" id="listviewbtn" title="<?php echo JText::_('OS_CHANGE_TO_LIST_VIEW'); ?>">
                                                    <img src="<?php echo JUri::root(); ?>components/com_osproperty/images/assets/listview.png" style="width:25px;border:1px solid #CCC !important;"/>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div id="gridview" style="display:none;padding:0px 10px 10px 10px;">
                                            <div class="row-fluid">
                                                <?php
                                                $k = 0;
                                                $j = 0;
                                                foreach ($rows as $property)
                                                {
                                                    $k++;
                                                    if ($property->subid != "")
                                                    {
                                                        $subid = "_" . $property->subid;
                                                    } else
                                                    {
                                                        $subid = "";
                                                    }
                                                    if ($property->isFeatured == 1)
                                                    {
                                                        $featured_class = " featured";
                                                    } else
                                                    {
                                                        $featured_class = "";
                                                    }
                                                    ?>
                                                    <div class="span6 element_property<?php echo $featured_class; ?>">
                                                        <div class="span12 image_property_showcase" style="margin-left:0px !important;">
                                                            <?php
                                                            if ($property->isFeatured == 1)
                                                            {
                                                                ?>
                                                                <div class="randompropertyfeatured">
                                                                    <strong><?php echo JText::_('OS_FEATURED') ?></strong>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <div class="randompropertytype">
                                                                <strong><?php echo $property->type_name; ?></strong></div>
                                                            <?php
                                                            $db->setQuery("Select * from #__osrs_photos where pro_id = '$property->id' order by ordering limit 1");
                                                            $photo = $db->loadObject();
                                                            if ($photo->image != '')
                                                            {
                                                                ?>
                                                                <a href="#map_canvas" title="<?php echo OSPHelper::getLanguageFieldValue($property, 'pro_name'); ?>">
                                                                    <?php
                                                                    OSPHelper::showPropertyPhoto($photo->image, 'medium', $property->id, '', '', '');
                                                                    ?>
                                                                </a>
                    <?php } else
                    {
                        ?>
                                                                <a href="#map_canvas" title="<?php echo OSPHelper::getLanguageFieldValue($property, 'pro_name'); ?>">
                                                                    <img alt="<?php echo $property->pro_name ?>"
                                                                         src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/nopropertyphoto.png"/>

                                                                </a>
                    <?php } ?>
                                                            <span class="overlayPhoto overlayFull mls clickable" ></span>
                                                            <div class="overlayTransparent overlayBottom typeReversed hpCardText clickable">
                                                                <ul class="mbm property-card-details">
                                                                    <li class="man">
                                                                        <a href="#map_canvas" title="<?php echo OSPHelper::getLanguageFieldValue($property, 'pro_name'); ?>" id="pitem<?php echo $property->mapid . $subid; ?>">
                                                                            <?php
                                                                            if ($property->ref != "")
                                                                            {
                                                                                echo $property->ref . ", ";
                                                                            }
                                                                            ?>
                                                                            <?php
                                                                            $limit_title_word = 4;
                                                                            $arr_title_word = explode(' ', $property->pro_name);
                                                                            if (!$limit_title_word || $limit_title_word > count($arr_title_word))
                                                                            {
                                                                                echo $property->pro_name;
                                                                            } else
                                                                            {
                                                                                $tmp_title = array();
                                                                                for ($i = 0; $i < $limit_title_word; $i++)
                                                                                {
                                                                                    $tmp_title[] = $arr_title_word[$i];
                                                                                    if ($i > 2 * count($arr_title_word) / 3 && stristr($arr_title_word[$i], '.'))
                                                                                        break;
                                                                                }
                                                                                echo implode(' ', $tmp_title);
                                                                                echo "...";
                                                                            }
                                                                            ?>
                                                                        </a>
                                                                    </li>
                                                                    <?php
                                                                    if ($property->show_address == 1)
                                                                    {
                                                                        echo "<li class='man showcase_address'>";
                                                                        echo $property->address;
                                                                        echo "</li>";
                                                                        ?>
                                                                        <li class="man showcase_address">
                                                                            <span
                                                                                class="man noWrap"> <?php echo OSPHelper::loadCityName($property->city); ?>
                                                                                    <?php
                                                                                    if (!OSPHelper::userOneState())
                                                                                    {
                                                                                        echo ", " . OSPHelper::loadSateName($property->state);
                                                                                    }
                                                                                    ?>
                                                                            </span>
                                                                        </li>
                        <?php
                    }
                    ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $j++;
                                                    if ($k == 2)
                                                    {
                                                        $k = 0;
                                                        ?>
                                                    </div>
                                                    <div class="row-fluid">
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div id="listview">
                                            <?php
                                            for ($i = 0; $i < count($rows); $i++)
                                            {
                                                $row = $rows[$i];
                                                if ($row->subid != "")
                                                {
                                                    $subid = "_" . $row->subid;
                                                } else
                                                {
                                                    $subid = "";
                                                }
                                                $link = Jroute::_('index.php?option=com_osproperty&task=property_details&id=' . $row->id . '&Itemid=' . $row->itemid);
                                                ?>
                                                <div class="row-fluid locatormap_icon" >
                                                    <div class="span12 conten_e_property" id="divitem<?php echo $i ?>">
                                                        <div class="locator_image_property">
                                                            <?php
                                                            $db->setQuery("Select * from #__osrs_photos where pro_id = '$row->id' order by ordering limit 1");
                                                            $photo = $db->loadObjectList();
                                                            if (count($photo) > 0)
                                                            {
                                                                $photo = $photo[0];
                                                                OSPHelper::showPropertyPhoto($photo->image, 'thumb', $row->id, 'width:120px;', 'img-polaroid', '');
                                                            } else
                                                            {
                                                                ?>
                                                                <img
                                                                    src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/nopropertyphoto.png"
                                                                    width="90"/>
                        <?php
                    }
                    ?>
                                                        </div>
                                                        <strong>
                                                            <a href="#map_canvas"
                                                               class="locator_title_link" id="item<?php echo $row->mapid . $subid; ?>">
                                                                   <?php
                                                                   echo $row->pro_name;
                                                                   if ($row->ref != "")
                                                                   {
                                                                       echo " ($row->ref)";
                                                                   }
                                                                   ?>
                                                            </a>
                                                            <?php
                                                            if ($configClass['locator_show_type'] == 1)
                                                            {
                                                                ?>
                                                                &nbsp;|&nbsp;
                                                                <strong><?php echo OSPHelper::getLanguageFieldValue($row, 'type_name'); ?></strong>
                                                                <?php
                                                            }
                                                            if ($row->price_call == 1)
                                                            {
                                                                echo "&nbsp;|&nbsp;<span style='color: red;font-weight:bold;'>" . JText::_('OS_CALL_FOR_PRICE') . "</span>";
                                                            } elseif ($row->price > 0)
                                                            {
                                                                echo "&nbsp;|&nbsp;<span style='color: red;font-weight:bold;'>" . OSPHelper::generatePrice($row->curr, $row->price) . "</span>";
                                                                if ($row->rent_time != "")
                                                                {
                                                                    echo " /" . JText::_($row->rent_time);
                                                                }
                                                            }
                                                            $temp_path_img = JURI::root() . "components/com_osproperty/images/assets";
                                                            $user = JFactory::getUser();
                                                            ?>
                                                            &nbsp;&nbsp;
                                                            <?php
                                                            if ($configClass['show_compare_task'] == 1)
                                                            {
                                                                ?>
                                                                <span id="compare<?php echo $row->id; ?>">
                                                                    <?php
                                                                    if (!OSPHelper::isInCompareList($row->id))
                                                                    {
                                                                        $msg = JText::_('OS_DO_YOU_WANT_TO_ADD_PROPERTY_TO_COMPARE_LIST');
                                                                        $msg = str_replace("'", "\'", $msg);
                                                                        ?>
                                                                        <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>', 'ajax_addCompare', '<?php echo $row->id ?>', '<?php echo JURI::root() ?>', 'compare<?php echo $row->id; ?>', 'theme3', 'listing')" href="javascript:void(0)">
                                                                            <img title="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST') ?>" alt="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST') ?>" src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/compare24_gray.png" border="0" width="16"/></a>
                                                                    </span>
                                                                    <?php
                                                                } else
                                                                {
                                                                    $msg = JText::_('OS_DO_YOU_WANT_TO_REMOVE_PROPERTY_OUT_OF_COMPARE_LIST');
                                                                    $msg = str_replace("'", "\'", $msg);
                                                                    ?>
                                                                    <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>', 'ajax_removeCompare', '<?php echo $row->id ?>', '<?php echo JURI::root() ?>', 'compare<?php echo $row->id; ?>', 'theme3', 'listing')" href="javascript:void(0)">
                                                                        <img title="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST') ?>" alt="<?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST') ?>" src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/compare24.png" border="0" width="16"/></a>
                                                                    </span>
                                                                    <?php
                                                                }
                                                                ?>
                                                                </span>
                                                                <?php
                                                            }
                                                            if (intval($user->id) > 0)
                                                            {
                                                                if ($configClass['property_save_to_favories'] == 1)
                                                                {
                                                                    $db->setQuery("Select count(id) from #__osrs_favorites where user_id = '$user->id' and pro_id = '$row->id'");
                                                                    $count = $db->loadResult();
                                                                    if ($count == 0)
                                                                    {
                                                                        $msg = JText::_('OS_DO_YOU_WANT_TO_REMOVE_PROPERTY_OUT_OF_COMPARE_LIST');
                                                                        $msg = str_replace("'", "\'", $msg);
                                                                        ?>
                                                                        <span id="fav<?php echo $row->id; ?>">
                                                                            <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>', 'ajax_addFavorites', '<?php echo $row->id ?>', '<?php echo JURI::root() ?>', 'fav<?php echo $row->id; ?>', 'theme3', 'listing')" href="javascript:void(0)">
                                                                                <img style="width:16px;" title="<?php echo JText::_('OS_ADD_TO_FAVORITES') ?>" alt="<?php echo JText::_('OS_ADD_TO_FAVORITES') ?>" src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/save24_gray.png" border="0"/>
                                                                            </a>
                                                                        </span>
                                                                        <?php
                                                                    } else
                                                                    {
                                                                        $msg = JText::_('OS_DO_YOU_WANT_TO_ADD_PROPERTY_TO_YOUR_FAVORITE_LISTS');
                                                                        $msg = str_replace("'", "\'", $msg);
                                                                        ?>
                                                                        <span id="fav<?php echo $row->id; ?>">
                                                                            <a onclick="javascript:osConfirmExtend('<?php echo $msg; ?>', 'ajax_removeFavorites', '<?php echo $row->id ?>', '<?php echo JURI::root() ?>', 'fav<?php echo $row->id; ?>', 'theme3', 'listing')" href="javascript:void(0)">
                                                                                <img style="width:16px;" title="<?php echo JText::_('OS_REMOVE_PROPERTY_OUT_OF_FAVORITES_LIST') ?>" alt="<?php echo JText::_('OS_REMOVE_PROPERTY_OUT_OF_FAVORITES_LIST') ?>" src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/save24.png" border="0"/>
                                                                            </a>
                                                                        </span>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <span id="fav<?php echo $row->id; ?>">
                                                                <a href="<?php echo $link; ?>" title="<?php echo JText::_('OS_VIEW_LISTING_DETAILS') ?>">
                                                                    <img title="<?php echo JText::_('OS_VIEW_LISTING_DETAILS') ?>" alt="<?php echo JText::_('OS_VIEW_LISTING_DETAILS') ?>" src="<?php echo JURI::root() ?>components/com_osproperty/images/assets/details.png" border="0"/>
                                                                </a>
                                                            </span>
                                                        </strong>
                                                        <BR />
                                                        <?php
                                                        if ($configClass['locator_show_address'] == 1)
                                                        {
                                                            if ($row->show_address == 1)
                                                            {
                                                                ?>
                                                                <span class="small_text">
                                                                <?php echo htmlspecialchars(OSPHelper::generateAddress($row)); ?>
                                                                </span>
                                                                <BR />
                                                                <?php
                                                            }
                                                        }
                                                        if ($configClass['locator_show_category'] == 1)
                                                        {
                                                            ?>
                                                            <?php echo JText::_('OS_CATEGORY') ?>: <strong><?php echo $row->category_name; ?></strong>
                                                            <BR />
                                                                <?php
                                                            }
                                                            ?>
                                                        <span class="small_text">
                                                            <?php
                                                            if ($configClass['locator_showrooms'] == 1)
                                                            {
                                                                ?>
                                                                <?php echo $row->rooms; ?> <?php echo JText::_('OS_ROOMS') ?>
                                                                &nbsp;|&nbsp;
                                                                <?php
                                                            }
                                                            if ($configClass['locator_showbedrooms'] == 1)
                                                            {
                                                                ?>
                                                                <?php echo $row->bed_room; ?> <?php echo JText::_('OS_BEDROOMS') ?>
                                                                &nbsp;|&nbsp;
                                                                <?php
                                                            }
                                                            if ($configClass['locator_showbathrooms'] == 1)
                                                            {
                                                                ?>
                                                                <?php echo OSPHelper::showBath($row->bath_room); ?> <?php echo JText::_('OS_BATHROOMS') ?>
                                                                <?php
                                                            }
                                                            if ($configClass['locator_showsquarefeet'] == 1)
                                                            {
                                                                ?>
                                                                &nbsp;|&nbsp;
                                                                <?php echo $row->square_feet; ?> <?php echo OSPHelper::showSquareSymbol(); ?>
                                                            <?php
                                                        }
                                                        ?>
                                                        </span>
                                                        <?php
                                                        if (($configClass['locator_showrooms'] == 1) or ( $configClass['locator_showbedrooms'] == 1) or ( $configClass['locator_showbathrooms'] == 1))
                                                        {
                                                            ?>
                                                            <BR />
                        <?php
                    }
                    ?>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                    <?php
                }
                ?>
                                        </div>
                                    </div>
                                    <?php
                                } elseif ($lists['location'] != "")
                                {
                                    
                                }
                                ?>
                            </div>
        <?php } ?>
                    </div>	
                </div>
            </div>
            <script type="text/javascript">
                function focusMarker(i)
                {
                    var obj = eval("marker" + i);
                    var html = arrBuble[i];
                    obj.openInfoWindowHtml(html, {maxWidth: 500});
                }
            </script>
            <input type="hidden" name="option" value="com_osproperty" />
            <input type="hidden" name="task" value="locator_search" />
            <input type="hidden" name="Itemid" value="<?php echo $jinput->getInt('Itemid', 0) ?>" />
            <input type="hidden" name="locator_search" value="1" />
            <input type="hidden" name="locator_type" id="locator_type" value="<?php echo $locator_type ?>" />
            <input type="hidden" name="doSearch" id="doSearch" value="1" />
            <input type="hidden" name="process_element" id="process_element" value="" />
            <input type="hidden" name="live_site" id="live_site" value="<?php echo JUri::root(); ?>" />
            <input type="hidden" name="my_lat" id="my_lat" value="" />
            <input type="hidden" name="my_long" id="my_long" value="" />
            <input type="hidden" name="search_my_location" id="search_my_location" value="0" />
        </form>
        <script type="text/javascript">
            var live_site = '<?php echo JURI::root() ?>';
            function change_country_company(country_id, state_id, city_id) {
                var live_site = '<?php echo JURI::root() ?>';
                loadLocationInfoStateCityLocator(country_id, state_id, city_id, 'country', 'state_id', live_site);
            }
            function change_state(state_id, city_id) {
                var live_site = '<?php echo JURI::root() ?>';
                loadLocationInfoCity(state_id, city_id, 'state_id', live_site);
            }
            jQuery("#gridviewbtn").click(function () {
                jQuery("#listview").hide("fast");
                jQuery("#gridview").show("slow");
            });
            jQuery("#listviewbtn").click(function () {
                jQuery("#listview").show("slow");
                jQuery("#gridview").hide("fast");
            });
            function updateMyLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (p) {
                        document.getElementById('my_lat').value = p.coords.latitude;
                        document.getElementById('my_long').value = p.coords.longitude;
                        document.getElementById('search_my_location').value = '1';
                        document.profileForm.submit();
                    });
                }
            }

            var width = jQuery("#gridview").width();
            if (width > 500) {
                jQuery(".randompropertytype").show();
                jQuery(".randompropertyfeatured").show();
            } else {
                jQuery(".randompropertytype").hide();
                jQuery(".randompropertyfeatured").hide();
            }
        </script>
        <?php
    }

}
?>