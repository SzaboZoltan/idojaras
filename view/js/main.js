/**
 * Created by Oz on 2015.10.23..
 */
BaseJs = function () {

    var _this = this;

    _this.init = function () {
        _this.ajaxUrl = '/index.php';
        _this.getWeatherAjax();
        _this.exportXML();
        _this.exportXLS();
        _this.exportCSV();
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

    _this.exportXML = function () {

        var data;

        $('#exportXML').on('click', function () {

            data = {
                'ajaxFunction': 'exportXML'
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

    _this.exportXLS = function () {

        var data;

        $('#exportXLS').on('click', function () {

            data = {
                'ajaxFunction': 'exportXLS'
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

    _this.exportCSV = function () {

        var data;

        $('#exportCSV').on('click', function () {

            data = {
                'ajaxFunction': 'exportCSV'
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