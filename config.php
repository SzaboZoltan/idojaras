<?php
define('WROOT',$_SERVER['DOCUMENT_ROOT'] . '/');
require_once(WROOT . '/configMySql.php');
require_once(WROOT . '/controller/Controller.php');
require_once(WROOT . '/controller/Weather.php');
require_once(WROOT . '/model/Weather.php');

error_reporting(E_ALL);

/**
 * Konfigurációs file
 *
 * Created by PhpStorm.
 * User: Oz
 * Date: 2015.10.20.
 * Time: 8:11
 */

/**
 * Print_r szépítő függvény
 * @param $data
 */
function printr($data)
{
    if ($data) {
        print '<pre>';
        print_r($data);
        print '</pre>';
    }
}

//****************************** MYSQL BEÁLLÍTÁSA *******************************************/
try {
    $db= new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $GLOBALS['db'] = $db;
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
//****************************** MYSQL BEÁLLÍTÁSA VÉGE***************************************/

//****************************** SMARTY BEÁLLÍTÁSA ******************************************/
require_once(WROOT . 'vendor/smarty/libs/Smarty.class.php');
define('SMARTY_DIR', '/usr/local/lib/Smarty-v.e.r/libs/');
$GLOBALS['smarty'] = new Smarty;

$smarty->setTemplateDir(WROOT . 'view/templates/');
$smarty->setCompileDir(WROOT . 'view/templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

$smarty->debugging = false;
$smarty->caching = true;
$smarty->cache_lifetime = 120;
//***************************SMARTY BEÁLLÍTÁSA VÉGE ******************************************/
