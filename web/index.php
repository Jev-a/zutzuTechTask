<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);
define('ROOT', dirname(__FILE__));

require '../vendor/autoload.php';
require_once(ROOT . '/../http/Router.php');

use ZTT\http\Router;

(new Router())->run();
