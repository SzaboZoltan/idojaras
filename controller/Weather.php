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
        $this->getWeatherInfo();

        if(!$ajaxFunction) {
            $this->result->template = "weather.tpl";
        }else{
            switch ($ajaxFunction) {
                case "saveWeatherAjax":
                   $this->saveWeatherAjax();
                   break;
                case "exportXML":
                    $this->exportXML();
                    break;
                case "exportXLS":
                    $this->exportXLS();
                    break;
                case "exportCSV":
                    $this->exportCSV();
                    break;
                default:
                    return false;
            }
        }
        return;
    }

    /**
     * Időjárás lekérése adatbázisból
     */
    private function getWeatherInfo()
    {
        foreach($this->cityList as $city) {
            $weatherModel = new WeatherModel();
            $weatherModel->data = $city['id'];
            $weatherModel->getWeather();
            $this->result->allData['cityWeatherInfo'][$city['id']] = $city;
            $this->result->allData['cityWeatherInfo'][$city['id']]['info'] = $weatherModel->result;
            $this->result->allData['cityWeatherInfo'][$city['id']]['geoData'] = $this->geocode($city['city'] . ', ' . $city['country']);
            $this->result->allData['cityWeatherInfo'][$city['id']]['table'] = $this->generateTable($weatherModel->result, $city['city']);
        }
        //printr($this->result->allData['cityWeatherInfo']);
    }

    /**
     * Generál a térképen való megjelenítéshez egy táblázatot városonként
     */
    private function generateTable($info, $city)
    {

        $html = '<table class="table">';
        $html .= '<h4>'.$city.'</h4>';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Frissítés ideje</th>';
        $html .= '<th>Hőmérséklet</th>';
        $html .= '<th>Harmatpont</th>';
        $html .= '<th>Páratartalom</th>';
        $html .= '</tr>';
        $html .= '</thead>';

        $html .= '<tbody>';

        foreach($info as $item){
            $html .= '<tr>';
            $html .= '<th scope="row">'.$item['create_date'].'</th>';
            $html .= '<td>'.$item['temperature'].'</td>';
            $html .= '<td>'.$item['dewpoint'].'</td>';
            $html .= '<td>'.$item['relativehumidity'].'</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
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
     * XML exportálása
     */
    private function exportXML()
    {
        $weatherModel = new WeatherModel();
        $weatherModel->getAllDataFromTable();
        $weatherModel->result;

        $filename ="data.xls";
        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename='.$filename);
        echo $htmlcontent;
        $out = fopen("php://output", 'w');
        foreach ($weatherModel->result as $data)
        {
            fputcsv($out, $data,"\t");
        }
        echo ($out);
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

    private function geocode($address){

        // url encode the address
        $address = urlencode($address);

        // google map geocode api url
        $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address={$address}";

        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);

        // response status will be 'OK', if able to geocode given address
        if($resp['status']=='OK'){

            // get the important data
            $lati = $resp['results'][0]['geometry']['location']['lat'];
            $longi = $resp['results'][0]['geometry']['location']['lng'];
            $formatted_address = $resp['results'][0]['formatted_address'];

            // verify if data is complete
            if($lati && $longi && $formatted_address){

                // put the data in the array
                $data_arr = array(
                    'lati' => $lati,
                    'longi' => $longi,
                    'formatted_address' => $formatted_address
                );

                return $data_arr;

            }else{
                return false;
            }

        }else{
            return false;
        }
    }
}