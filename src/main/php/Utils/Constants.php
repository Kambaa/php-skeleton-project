<?php

namespace AppSkeleton\Utils;


class Constants
{
    /**
     * htaccess code
     */
    const HTACCESS_CODE = <<<HTACCESS
Options +Indexes +FollowSymLinks
<files *.ini>
order deny,allow
deny from all
</files>
RewriteEngine On
RewriteCond %{REQUEST_URI} licence-server.phar/src/main/webapp/$
RewriteRule ^(.*)$ licence-server.phar/src/main/webapp/index.php
RewriteCond %{REQUEST_URI} !licence-server.phar
RewriteRule ^(.*)$ licence-server.phar/src/main/webapp/$1
RewriteCond %{REQUEST_URI} licence-server.phar/src/main/webapp/$
HTACCESS;

    /**
     * Returns LOG4PHP configuration array
     * @return array
     */
    public static function getLog4PHPConfig()
    {
        return [
            'rootLogger' => [
                'appenders' => ["file"],
            ],
            'appenders' => [
                'file' => [
                    'class' => 'LoggerAppenderDailyFile',
                    'layout' => [
                        'class' => 'LoggerLayoutPattern',
                        'params' => [
                            'conversionPattern' => '[%p] %date{d.m.Y H:i:s,u} %l - %m%n'
                        ]
                    ],
                    'params' => [
                        'datePattern' => 'Y-m-d',
                        'file' => BASEDIR . 'logs' . DS . 'logs-%s.log',
                    ],
                ],
                /*
                 * https://logging.apache.org/log4php/docs/appenders/pdo.html
                 *
                 * First create a table named `logs`.
                 *
                 * CREATE TABLE logs (
                 * timestamp DATETIME,
                 * logger VARCHAR(256),
                 * level VARCHAR(32),
                 * message VARCHAR(4000),
                 * thread INTEGER,
                 * file VARCHAR(255),
                 * line VARCHAR(10)
                 * );
                 * */
                'mysql' => [
                    'class' => 'LoggerAppenderPDO',
                    'params' => [
                        'dsn' => 'mysql:host=DB_HOST;dbname=DB_NAME;charset=utf8',
                        'user' => 'DB_USERNAME',
                        'password' => 'DB_PASSWORD',
                        'table' => 'logs',
                    ],
                ],
            ]
        ];
    }

    /**
     * Reads configuration file
     * @return array|bool
     */
    public static function readConfigFile()
    {
        $dir = BASEDIR . 'config.ini';
        if (!file_exists($dir)) {
            return false;
        }
        $out = parse_ini_file($dir);
        if (!$out) {
            return false;
        }
        return $out;
    }

    /**
     * Returns the client's ip address.
     * @link https://stackoverflow.com/a/41382472
     * @return string
     */
    public static function getUserIP()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    /**
     * Service call result print/display method.
     *
     * @param $data array Must have these indexes:
     * <ul>
     * <li>result: true for success, false for error</li>
     * <li>description: any description texts (success or failure) to display on page, should be in here.</li>
     * <li>data: any datas that will be used in the page(js to process etc.), should be in here </li>
     * <li>html: any html data that will be used in the page (directly), should be in here</li>
     * </ul>
     * @param bool $print whether generated data will be printed on json format or not.
     * @return array|int
     */
    public static function returnData($data, $print = true)
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

    /**
     * Simple parser for logging. Can get numerous arguments.
     * First argument must be the template string. Placeholders must be in numeric order. ie. Hello {0} {1} ...
     * Other arguments can be the values if there are named placeholders in the template string.
     *
     * @return string
     */
    public static function parse()
    {
        $temp = func_get_args();
        $tpl = $temp[0];
        for ($i = 0; $i < func_num_args(); $i++) {
            $tpl = str_replace('{' . $i . '}', $temp[$i + 1], $tpl);
        }
        return $tpl;
    }


}