<?php
define('WROOT',$_SERVER['DOCUMENT_ROOT'] . '/idojaras/');
require_once(WROOT . '/configMySql.php');
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
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
//****************************** MYSQL BEÁLLÍTÁSA VÉGE***************************************/

//****************************** SMARTY BEÁLLÍTÁSA ******************************************/
require_once(WROOT . 'vendor/smarty/libs/Smarty.class.php');
define('SMARTY_DIR', '/usr/local/lib/Smarty-v.e.r/libs/');
$smarty = new Smarty;

$smarty->setTemplateDir(WROOT . 'view/templates/');
$smarty->setCompileDir(WROOT . 'view/templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

$smarty->debugging = true;
$smarty->caching = true;
$smarty->cache_lifetime = 120;
//***************************SMARTY BEÁLLÍTÁSA VÉGE ******************************************/
