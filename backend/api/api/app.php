<?php 
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__))  .   DS);

$ruta = str_replace("/api","",  $_SERVER['REQUEST_URI']);
$_GET['url'] = $ruta;

require_once '../config/headers.php';
require_once "models/connection.php";
require_once "routes/request.php";
require_once "routes/Routes.php" ;

new Connection;

Router::run(new Request);

