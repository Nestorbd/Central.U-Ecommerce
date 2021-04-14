<?php

require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

$HOST = $_ENV['HOST'];
$USER = $_ENV['DDBB_USER'];
$PASSWORD = $_ENV['DDBB_PASSWORD'];
$BD = $_ENV['BD'];

$DIALECT = $_ENV['dialect'];
