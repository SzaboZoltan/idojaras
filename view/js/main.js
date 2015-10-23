/**
 * Created by Oz on 2015.10.23..
 */
BaseJs = function () {

    var _this = this;

    _this.init = function () {
        _this.ajaxUrl = '/index.php';
        _this.getWeatherAjax();

        _this.locations = [
            'New Delhi, India',
            'Mumbai, India',
            'Bangaluru, Karnataka, India',
            'Hyderabad, Ahemdabad, India',
            'Gurgaon, Haryana, India',
            'Cannaught Place, New Delhi, India',
            'Bandra, Mumbai, India',
            'Nainital, Uttranchal, India',
            'Guwahati, India',
            'West Bengal, India',
            'Jammu, India',
            'Kanyakumari, India',
            'Kerala, India',
            'Himachal Pradesh, India',
            'Shillong, India',
            'Chandigarh, India',
            'Dwarka, New Delhi, India',
            'Pune, India',
            'Indore, India',
            'Orissa, India',
            'Shimla, India',
            'Gujarat, India'
        ];
        _this.nextAddress = 0;

        //_this.initMap();
    };

    _this.getWeatherAjax = function () {

        var data;

        $('#getWeather').on('click', function () {

            data = {
                'ajaxFunction': 'saveWeatherAjax'
            };

            $.ajax({
                type: 'GET',
                url: _this.ajaxUrl,
                data: data
            }).done(function() {

            }).error(function () {
                console.log();
            });
            return false;

        });
    };


    _this.initMap = function () {

        var delay = 100;
        var infowindow = new google.maps.InfoWindow();
        var latlng = new google.maps.LatLng(21.0000, 78.0000);
        var mapOptions = {
            zoom: 5,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var geocoder = new google.maps.Geocoder();
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
        var bounds = new google.maps.LatLngBounds();
    };

    _this.geocodeAddress = function (address, next) {

        geocoder.geocode({address:address}, function (results,status)
            {
                if (status == google.maps.GeocoderStatus.OK) {
                    var p = results[0].geometry.location;
                    var lat=p.lat();
                    var lng=p.lng();
                    createMarker(address,lat,lng);
                }
                else {
                    if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                        nextAddress--;
                        delay++;
                    } else {
                    }
                }
                next();
            }
        );
    }

    _this.createMarker = function (add,lat,lng) {
        var contentString = add;
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat,lng),
            map: map,
        });

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(contentString);
            infowindow.open(map,marker);
        });

        bounds.extend(marker.position);

    }

    function theNext() {
        if (nextAddress < locations.length) {
            setTimeout('geocodeAddress("'+locations[nextAddress]+'",theNext)', delay);
            nextAddress++;
        } else {
            map.fitBounds(bounds);
        }
    }
    theNext();



};


baseJs  = new BaseJs();

$(window).on('load', function () {
    baseJs.init();
});