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

        var data,
            successMessage = $('#success-data'),
            errorMessage = $('#success-data');

        $('#getWeather').on('click', function () {
            var btn = $(this);
            btn.button('loading');
            data = {
                'ajaxFunction': 'saveWeatherAjax'
            };

            $.ajax({
                type: 'GET',
                url: _this.ajaxUrl,
                data: data
            }).done(function(resultData) {
                if(resultData == '1'){
                    $('#success-data').removeClass('hide').delay( 800 ).addClass('hide');
                    successMessage.removeClass('hide');
                    setTimeout(function(){ successMessage.addClass('hide'); }, 5000);
                }else{
                    $('#error-data').removeClass('hide');
                    errorMessage.removeClass('hide');
                    setTimeout(function(){ errorMessage.addClass('hide'); }, 5000);
                }
                btn.button('reset')
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