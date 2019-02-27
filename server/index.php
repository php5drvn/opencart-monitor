<?php
define('VERSION', '1.0.0');

header('Access-Control-Allow-Origin: *');
header('access-control-allow-headers: DNT,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Range,Token,token');
//header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

include_once  ('vendor/autoload.php');

include_once('config.php');

include_once(DIR_SYSTEM.'startup.php');

startup($config);