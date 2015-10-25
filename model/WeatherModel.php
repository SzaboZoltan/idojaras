<?php
require_once(WROOT.'/config.php');
/**
 * Model rész
 *
 * Created by PhpStorm.
 * User: Oz
 * Date: 2015.10.19.
 * Time: 21:17
 */
class WeatherModel {

    public $data;
    public $result;
    public $table = 'weather';

    function __construct()
    {
        $this->db = $GLOBALS['db'];
    }

    /**
     * Lekérdezi az utolsó 5 időjárási adatot város szerint, időszerint (friss->régi)
     */
    public function getWeather()
    {
        $statement = $this->db->prepare("SELECT * FROM ".$this->table." WHERE city_id = :id ORDER BY create_date DESC LIMIT 0, 5");
        $statement->execute(array(
            "id" => $this->data
        ));
        while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $this->result[] = $row;
        }
    }

    /**
     * Lekérdezi az összes elemet
     */
    public function getAllDataFromTable()
    {
        $statement = $this->db->prepare("SELECT * FROM ".$this->table);
        $statement->execute(array());
        while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $this->result[] = $row;
        }
    }



    /**
     * Időjárás mentése adatbázisba
     */
    public function weatherSave()
    {
        $this->saveWeatherConfig();
        if($this->saveWeatherDb())
            $this->result = true;
        else
            $this->result = false;
    }

    /**s
     * Előkészíti mentésre az adatokat.
     */
    private function saveWeatherConfig()
    {
        $this->weatherSqlData['id'] = 'NULL';
        $this->weatherSqlData['city_id'] = $this->data['id'];
        $this->weatherSqlData['city'] = $this->data['city'];
        $this->weatherSqlData['country'] = $this->data['country'];
        $this->weatherSqlData['location'] = (isset($this->data['info']['Location']))?$this->data['info']['Location']:'';
        $this->weatherSqlData['time'] = (isset($this->data['info']['Time']))?$this->data['info']['Time']:'';
        $this->weatherSqlData['wind'] = (isset($this->data['info']['Wind']))?$this->data['info']['Wind']:'';
        $this->weatherSqlData['visibility'] = (isset($this->data['info']['Visibility']))?$this->data['info']['Visibility']:'';
        $this->weatherSqlData['skyconditions'] = (isset($this->data['info']['SkyConditions']))?$this->data['info']['SkyConditions']:'';
        $this->weatherSqlData['temperature'] = (isset($this->data['info']['Temperature']))?$this->data['info']['Temperature']:'';
        $this->weatherSqlData['dewpoint'] = (isset($this->data['info']['DewPoint']))?$this->data['info']['DewPoint']:'';
        $this->weatherSqlData['relativehumidity'] = (isset($this->data['info']['RelativeHumidity']))?$this->data['info']['RelativeHumidity']:'';
        $this->weatherSqlData['pressure'] = (isset($this->data['info']['Pressure']))?$this->data['info']['Pressure']:'';
        $this->weatherSqlData['pressuretendency'] = (isset($this->data['info']['PressureTendency']))?$this->data['info']['PressureTendency']:'';
        $this->weatherSqlData['status'] = (isset($this->data['info']['Status']))?$this->data['info']['Status']:'';
        $this->weatherSqlData['create_date'] = date("Y-m-d H:i:s");
    }

    private function saveWeatherDb()
    {
        $statement = $this->db->prepare("INSERT INTO ".$this->table."(id, city_id, city, country, location, time, wind, visibility, skyconditions, temperature, dewpoint, relativehumidity, pressure, pressuretendency, status, create_date) VALUES(:id, :city_id, :city, :country, :location, :time, :wind, :visibility, :skyconditions, :temperature, :dewpoint, :relativehumidity, :pressure, :pressuretendency, :status, :create_date)");
        if($statement->execute($this->weatherSqlData)) return true; else false;
    }

    /**
     * Tábla létrehozásához
     */
    private function createWeatherTable()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `weather` (
              `id` int(11) NOT NULL COMMENT 'kulcs ID',
              `city_id` int(11) NOT NULL COMMENT 'város ID',
              `city` varchar(100) NOT NULL COMMENT 'Város neve',
              `country` varchar(100) NOT NULL COMMENT 'Ország',
              `location` varchar(150) NOT NULL COMMENT 'Hely adatok',
              `time` varchar(50) NOT NULL COMMENT 'Idő',
              `wind` varchar(50) NOT NULL COMMENT 'Szél',
              `visibility` varchar(50) NOT NULL COMMENT 'Láthatóság',
              `skyconditions` varchar(50) NOT NULL COMMENT 'Általános időjárás',
              `temperature` varchar(20) NOT NULL COMMENT 'Hőmérséklet',
              `dewpoint` varchar(20) NOT NULL COMMENT 'Harmatpont (legalacsonyabb hőmérséklet)',
              `relativehumidity` varchar(10) NOT NULL COMMENT 'Páratartalom',
              `pressure` varchar(20) NOT NULL COMMENT 'Nyomás',
              `pressuretendency` varchar(50) NOT NULL COMMENT 'Nyomás tendencia',
              `status` varchar(20) NOT NULL COMMENT 'Lekérdezés státusza',
              `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Létrehozás ideje'
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Időjárás táblája';
            ALTER TABLE `weather`
            ADD PRIMARY KEY (`id`);
            ALTER TABLE `weather` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'kulcs ID';
                        ";
    }
}
