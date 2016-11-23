<?php
/**
 * User: Kambaa
 * Date: 12.07.2016
 * Time: 23:06
 */


require_once "vendor/autoload.php"; 

@session_start();
if (!defined("DS")) {
    define("DS", DIRECTORY_SEPARATOR);
}
if (!defined("BASEDIR")) {
    define("BASEDIR", dirname(Phar::running(false)) . DS); 
}
if (!defined("PHARDIR")) {
    define("PHARDIR", dirname(__DIR__) . DS);
}
if (!defined("BASEURL")) {
    define("BASEURL", 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}


