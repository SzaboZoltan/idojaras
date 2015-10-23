<?php
require_once(WROOT.'/config.php');
/**
 * Created by PhpStorm.
 * User: Oz
 * Date: 2015.10.22.
 * Time: 20:52
 */

class Weather {

    private $cityList = array();

    function __construct()
    {
        $this->defaultsFunctions();
    }

    /**
     * Alapértelmezett függvények
     */
    private function defaultsFunctions()
    {
        $this->getNewWeather();
    }

    /**
     * Lekérdezi az aktuális időjárást
     */
    private function getNewWeather()
    {
        $this->getNewWeatherInfoFromWebsite();
    }

    /**
     * Lekéri a város neveket
     * Tovább lehet fejleszteni input mezőből vagy adatbázisból beolvasott elemekkel
     */
    private function getCitys()
    {
        $this->cityList = array(
            0 => 'Los Angeles'
        );
    }

    /**
     * Kapcsolat létesítése a külső weboldallal és adatok lekérése SOAP protokollon keresztül
     */
    private function getNewWeatherInfoFromWebsite()
    {
/*        $requestParams = array(
            'CityName' => 'Berlin',
            'CountryName' => 'Germany'
        );


        $client = new SoapClient('http://www.webservicex.net/globalweather.asmx?WSDL');
        print_r($client);
        die();
        $response = $client->GetWeather($requestParams);

        print_r($response);*/


        $client = new SoapClient("http://www.webservicex.net/globalweather.asmx?wsdl");
        $params = new stdClass;
        $params->CityName= 'Auckland';
        $params->CountryName= 'New Zealand';
        $result = $client->GetWeather($params);
        printr($result);
        // Check for errors...
        $weatherXML = $result->GetWeatherResponse;


    }
}