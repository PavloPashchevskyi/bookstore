<?php

require_once 'vendor/autoload.php';

//echo 'Welcome to PHP8.1<br>'.$_SERVER['REQUEST_METHOD'].' '.$_SERVER['REQUEST_URI']."\n";
//print_r(\Application\Config\Router::get());

use Application\Config\Options;
use Application\Core\Application;

$defaultOptions = Options::get();

try {
    Application::start($defaultOptions['default_route']);
} catch (Exception $exception) {
    echo 'Exception #'.$exception->getCode().': '.$exception->getMessage()."<br/>Unable to start the Application!";
}
