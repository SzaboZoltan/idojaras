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

    function __construct()
    {
        $this->db = $GLOBALS['db'];
    }

    public function select()
    {
        $stmt = $this->db->query('SELECT * FROM table');

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['field1'].' '.$row['field2']; //etc...
        }
    }
}
