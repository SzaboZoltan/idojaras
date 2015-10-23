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

    private $ajax;

    function __construct(){

        $this->ajax = (isset($_REQUEST['ajaxFunction']) && !empty($_REQUEST['ajaxFunction']))?true:false;

        $this->smarty = $GLOBALS['smarty'];
        $this->weatherInfo();
        if(!$this->ajax) {
            $this->templateSettings();
        }

    }

    private function weatherInfo()
    {
        $this->weather = new Weather();
    }

    private function templateSettings()
    {

        $this->classResultToSmarty();
        $this->templateNameFromClassToSmarty();
        $this->generateTemplate();

    }

    /**
     * Template-nek küldött változók átadása
     *
     */
    private function classResultToSmarty()
    {
        if(isset($this->weather->result->allData) && !empty($this->weather->result->allData)) {
            $this->smarty->assign('result', $this->weather->result->allData);
        }
    }

    /**
     * Osztály Template meghívása
     *
     */
    private function templateNameFromClassToSmarty()
    {
        if(isset($this->weather->result->template) && !empty($this->weather->result->template)) {
            $this->template = $this->smarty->fetch($this->weather->result->template);
            $this->smarty->assign('modul', $this->template);
        }
    }

    /**
     * Alap template hívása
     */
    private function generateTemplate()
    {
        $this->result->template = $this->smarty->display('index.tpl');
    }



}