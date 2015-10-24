<h1>Városok időjárási adatainak lekérdezése és megjelenítése</h1>
<div class="row">
    <h3>Városok listája</h3>
    <ol>
        {foreach $result.cityList as $item}
            <li>{$item.city}</li>
        {/foreach}
    </ol>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <form name="weather-form">
            <button id="getWeather" type="submit" class="btn btn-warning">Aktuális időjárás adatok lekérése a www.webservicex.net oldalról</button>
            <button id="exportXML" type="submit" name="xml" value="1" class="btn btn-primary">Export XML</button>
            <button id="exportXLS" type="submit" name="xls" value="1" class="btn btn-primary">Export XLS</button>
            <button id="exportCSV" type="submit" name="csv" value="1" class="btn btn-primary">Export CSV</button>
        </form>
    </div>
</div>
<h3>Google Térkép</h3>
<div id="map"></div>
<h3>Open Street Map</h3>
<div id="map-open"><div id="popup" style="width: 600px; height: auto;"></div></div>

    <script>

        function initMap() {

            {foreach $result.cityWeatherInfo as $key => $item}
            var myLatLng{$key} = {literal}{{/literal}lat: {$item.geoData.lati}, lng: {$item.geoData.longi}{literal}}{/literal};

            var infowindow{$key} = new google.maps.InfoWindow({literal}{{/literal}
                content: '{$item.table}'
                {literal}});{/literal}
            {/foreach}


            {literal}
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 6,
                center: myLatLng1
            });
            {/literal}


            {foreach $result.cityWeatherInfo as $key => $item}
            {literal}
            var marker{/literal}{$key}{literal} = new google.maps.Marker({
                position: myLatLng{/literal}{$key}{literal},
                map: map,{/literal}
                title: '{$item.city}'{literal}
            });
            marker{/literal}{$key}{literal}.addListener('mouseover', function() {
                infowindow{/literal}{$key}{literal}.open(map, marker{/literal}{$key}{literal});
            });
            {/literal}
            {/foreach}


        }

        function initOpenMap() {

            {literal}

            var vectorSource = new ol.source.Vector({
                //create empty vector
            });

            //create a bunch of icons and add to source vector
            {/literal}
            {foreach $result.cityWeatherInfo as $key => $item}
            {literal}

                var iconFeature = new ol.Feature({
                    geometry: new
                            ol.geom.Point(ol.proj.transform([{/literal}{$item.geoData.longi}{literal}, {/literal}{$item.geoData.lati}{literal}], 'EPSG:4326',   'EPSG:3857')),
                    name: '{/literal}{$item.table}{literal} ' + {/literal}{$key}{literal}

                });
                vectorSource.addFeature(iconFeature);

            {/literal}
            {/foreach}
            {literal}

            //create the style
            var iconStyle = new ol.style.Style({
                image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                    anchor: [0.5, 46],
                    anchorXUnits: 'fraction',
                    anchorYUnits: 'pixels',
                    opacity: 0.75,
                    src: 'http://openlayers.org/en/v3.9.0/examples/data/icon.png'
                }))
            });



            //add the feature vector to the layer vector, and apply a style to whole layer
            var vectorLayer = new ol.layer.Vector({
                source: vectorSource,
                style: iconStyle
            });

            var map = new ol.Map({
                layers: [new ol.layer.Tile({ source: new ol.source.OSM() }), vectorLayer],
                target: document.getElementById('map-open'),
                view: new ol.View({
                    center: [0,0],
                    zoom: 2
                })
            });

            var element = document.getElementById('popup');

            var popup = new ol.Overlay({
                element: element,
                positioning: 'bottom-center',
                stopEvent: false
            });
            map.addOverlay(popup);

            // display popup on click
            map.on('pointermove', function(evt) {
                var feature = map.forEachFeatureAtPixel(evt.pixel,
                        function(feature, layer) {
                            return feature;
                        });
                if (feature) {
                    popup.setPosition(evt.coordinate);
                    $(element).popover({
                        'placement': 'top',
                        'html': true,
                        'content': feature.get('name')
                    });
                    $(element).popover('show');
                } else {
                    $(element).popover('destroy');
                }
            });

            {/literal}
        }

    </script>
