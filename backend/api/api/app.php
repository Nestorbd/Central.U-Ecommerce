<?php 
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__))  .   DS);

$ruta = str_replace("/serigrafia/backend/api/","",  $_SERVER['REQUEST_URI']);
$_GET['url'] = $ruta;

require_once '../config/headers.php';
require_once "models/connection.php";
require_once "routes/request.php";
require_once "routes/Routes.php" ;
require_once '../config/config.php';

new Connection($DIALECT,$HOST,$BD,$BD_ARTICULOS,$BD_USUARIOS,$USER,$PASSWORD);

Router::run(new Request);

