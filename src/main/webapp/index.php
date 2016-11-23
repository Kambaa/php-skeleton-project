<?php
/**
 * User: Kambaa
 * Date: 29.06.2016
 * Time: 00:16
 */

ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);

//ini_set('display_errors', 'Off');
//error_reporting(0);

header('Content-Type: text/html; charset=utf-8');

require_once "src/main/php/bootstrap.php";

if (php_sapi_name() == "cli") {
    require_once "cli.php";
} else {
    if (isset($_GET['ajax']) && file_exists(PHARDIR . 'webapp/ajax/' . $_GET['ajax'] . '.php')) {
        require_once PHARDIR . 'webapp/ajax/' . $_GET['ajax'] . '.php';
    } else if (!empty($_GET['page']) && file_exists(PHARDIR . 'webapp/' . $_GET['page'] . '.php')) {
        require_once PHARDIR . 'webapp/' . $_GET['page'] . '.php';
    } else {
        require_once PHARDIR . 'webapp/dashboard.php';
    }
}
