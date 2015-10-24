/**
 * Created by Oz on 2015.10.23..
 */
BaseJs = function () {

    var _this = this;

    _this.init = function () {
        _this.ajaxUrl = '/index.php';
        _this.getWeatherAjax();
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

};


baseJs  = new BaseJs();

$(window).on('load', function () {
    baseJs.init();
    initMap();
    initOpenMap();
});