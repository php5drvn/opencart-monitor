<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('GMT');
}

require_once 'library/opencart.php';
require_once 'library/engine/loader.php';
require_once 'library/engine/registry.php';
require_once 'library/engine/router.php';
require_once 'library/config.php';
require_once 'library/html_parser.php';


function startup($config){
    //init registry
    $registry = new Registry();

    // Config init
    $configClass = new Config($registry);
    $configClass->setData($config);
    $registry->set('config', $configClass);

    // Router init / get route
    $router = new Router($registry);
    $registry->set('router', $router);
    $route = $router->route;

    // Connect to Opencart.com
    $opencart = new Opencart($config);
    $registry->set('opencart', $opencart);

    // HtmlParser init
    $htmlParser = new HtmlParser();
    $registry->set('htmlParser', $htmlParser);

    // Load controller with route
    $loader = new Loader($registry);
    $registry->set('load', $loader);

    $output = $loader->controller($route, $registry);

    //output html
    echo $output;
}