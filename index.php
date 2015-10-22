<?php
require_once('config.php');
require_once(WROOT.'/controller/Controller.php');
/**
 * Created by PhpStorm.
 * User: Oz
 * Date: 2015.10.19.
 * Time: 21:09
 */
$index = new Controller();
echo $index->result['template'];