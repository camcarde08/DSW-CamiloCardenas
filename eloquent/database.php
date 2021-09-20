<?php

use Illuminate\Database\Capsule\Manager as Capsule;

define('ROOTPATH', __DIR__ . "/../");
$xml = simplexml_load_file(ROOTPATH . 'config/systemParameters.xml');
//if (!$xml)
//    $xml = simplexml_load_file('./../../../config/systemParameters.xml');
//if (!$xml)
//    $xml = simplexml_load_file('./../../config/systemParameters.xml');

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => $xml->dbParameters->dbHost,
    'database' => $xml->dbParameters->dbName,
    'username' => $xml->dbParameters->userDb,
    'password' => $xml->dbParameters->passwordDb,
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();


