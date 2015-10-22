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
        $this->conn = $GLOBALS['conn'];
        $this->generateTemplate();
    }

    private function generateTemplate()
    {
        $this->result['template'] = $this->smarty->display('index.tpl');
    }

}