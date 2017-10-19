<?php

use AppSkeleton\Utils\Constants;

require_once "src/main/php/bootstrap.php";
header('Content-Type: application/json; charset=utf-8');

if (!defined("AJAX_PAGE_PREFIX")) {
    define("AJAX_PAGE_PREFIX", 'ajax_');
}

function ajax_test($param)
{
    Constants::returnData(['result' => true, 'description' => 'test operation successfull', 'data' => $param]);
}


if (is_array($_GET) && count($_GET) > 0 && isset($_GET['action']) && function_exists(AJAX_PAGE_PREFIX . $_GET["action"])) {
    call_user_func(AJAX_PAGE_PREFIX . $_GET["action"], $_GET);
} else if (is_array($_POST) && count($_POST) > 0 && isset($_POST['action']) && function_exists(AJAX_PAGE_PREFIX . $_POST["action"])) {
    call_user_func(AJAX_PAGE_PREFIX . $_POST["action"], $_POST);
} else {
    header("HTTP/1.1 404 Not Found");
    header('Content-Type: text/html; charset=utf-8');
    exit('<!doctype html><title>404!</title><h1 style="text-align: center">404!</h1><hr/>');
}