<?php

require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

$HOST = $_ENV['HOST'];
$USER = $_ENV['DDBB_USER'];
$PASSWORD = $_ENV['DDBB_PASSWORD'];
$BD = $_ENV['BD'];
$BD_ARTICULOS = $_ENV['BD_ARTICULOS'];
$BD_USUARIOS = $_ENV['BD_USUARIOS'];

$DIALECT = $_ENV['dialect'];
