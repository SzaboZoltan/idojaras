<?php
require_once(WROOT.'/config.php');
/**
 * Weboldal vezérlő
 *
 * Created by PhpStorm.
 * User: Oz
 * Date: 2015.10.19.
 * Time: 21:16
 */
class Controller{

    public $result = array();

    function __construct(){
        $this->smarty = $GLOBALS['smarty'];
        $this->weatherInfo();
        $this->generateTemplate();
    }

    private function weatherInfo()
    {
        $this->weather = new Weather();
    }

    private function generateTemplate()
    {
        $this->result['template'] = $this->smarty->display('index.tpl');
    }



}