<?php
require_once(WROOT.'config.php');
//echo WROOT.'controller/Xml2array.php';
/**
 * Created by PhpStorm.
 * User: Oz
 * Date: 2015.10.22.
 * Time: 20:52
 */

class Weather {

    private $cityList = array();
    private $ajaxFunction;


    function __construct()
    {
        $ajaxFunction = (isset($_REQUEST['ajaxFunction']) && !empty($_REQUEST['ajaxFunction']))?$_REQUEST['ajaxFunction']:false;
        $this->getCitys();
        $this->result->allData['cityList'] = $this->cityList;
        $this->defaultsFunctions();

        if(!$ajaxFunction) {
            $this->result->template = "weather.tpl";
        }else{
            switch ($ajaxFunction) {
                case "saveWeatherAjax":
                   $this->saveWeatherAjax();
                   break;
                default:
                    return false;
            }
        }
        //printr($this->result);
        return;
    }

    /**
     * Alapértelmezett függvények
     */
    private function defaultsFunctions()
    {
        foreach($this->cityList as $city) {
            $weatherModel = new WeatherModel();
            $weatherModel->data = $city['id'];
            $weatherModel->getWeather();
            $this->result->allData['cityWeatherInfo'][$city['id']] = $weatherModel->result;
        }

    }

    /**
     * Lekérdezi az aktuális időjárást
     * Lementi az adatbázisba és visszaadja eredményül
     */
    private function saveWeatherAjax()
    {
        $this->getNewWeather();
        foreach($this->cityList as $city){
            $weatherModel = new WeatherModel();
            $weatherModel->data = $city;
            $weatherModel->weatherSave();
        }
    }


    /**
     * Lekérdezi az aktuális időjárást
     * 1. Városokat meghatározása
     * 2. Városok időjárás adatainak lekérdezése
     */
    private function getNewWeather()
    {
        foreach($this->cityList as &$city) {
            $weatherXML = $this->getNewWeatherInfoFromWebsite($city['city'], $city['country']);
            $city['info'] = $this->xmlToArray($weatherXML);
        }
        //printr($this->cityList);
    }

    /**
     * XML átalakítása objektumra, majd tömbbre a feldolgozáshoz
     */
    private function xmlToArray($xml)
    {
        $xml = str_replace('encoding="utf-16"', 'encoding="utf-8"', $xml);
        $xml = simplexml_load_string($xml);
        $array = json_encode($xml);
        $array = json_decode($array, true);

        return $array;
    }



    /**
     * Lekéri a város neveket
     * Tovább lehet fejleszteni input mezőből vagy adatbázisból beolvasott elemekkel
     */
    private function getCitys()
    {
        $this->cityList = array(
            0 => array(
                'id' => 1,
                'city' => 'Los Angeles',
                'country' => 'United States'
            ),
            1 => array(
                'id' => 2,
                'city' => 'Las Vegas',
                'country' => 'United States'
            ),
            2 => array(
                'id' => 3,
                'city' => 'Phoenix',
                'country' => 'United States'
            ),
            3 => array(
                'id' => 4,
                'city' => 'San Diego',
                'country' => 'United States'
            ),

        );
    }

    /**
     * Kapcsolat létesítése a külső weboldallal és adatok lekérése SOAP protokollon keresztül
     */
    private function getNewWeatherInfoFromWebsite($city, $country)
    {
        $client = new SoapClient("http://www.webservicex.net/globalweather.asmx?wsdl");
        $params = new stdClass;
        $params->CityName= $city;
        $params->CountryName= $country;
        $result = $client->GetWeather($params);
        $weatherXML = $result->GetWeatherResult;
        $xml = simplexml_load_string($weatherXML);
        return $weatherXML;
    }
}