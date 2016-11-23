<?php
/**
 * User: Kambaa
 * Date: 8/8/16
 * Time: 1:53 PM
 */

require_once "src/main/php/bootstrap.php";
header('Content-Type: application/json; charset=utf-8');


function ret($data, $print = true)
{
    $resultData = [
        "result" => $data['result'],
        "description" => $data['description'],
        "data" => $data['data'],
        'html' => $data['html']
    ];
    $result = json_encode($resultData, JSON_UNESCAPED_UNICODE);
    return $print == true ? print($result) : $resultData;
}

function returnError($str = null, $print = true)
{
    $resultArr = ["result" => false];
    if (!empty($str)) {
        $resultArr["description"] = $str;
    }
    $result = json_encode($resultArr, JSON_UNESCAPED_UNICODE);
    return $print == true ? print($result) : $resultArr;
}


if (is_array($_GET) && count($_GET) > 0 && isset($_GET['action']) && function_exists($_GET["action"])) {
    call_user_func($_GET["action"], $_GET);
} else if (is_array($_POST) && count($_POST) > 0 && isset($_POST['action']) && function_exists($_POST["action"])) {
    call_user_func($_POST["action"], $_POST);
} else {
    header("HTTP/1.1 404 Not Found");
    header('Content-Type: text/html; charset=utf-8');
    exit('<!doctype html><title>404!</title><h1 style="text-align: center">404!</h1><hr/>');
}
