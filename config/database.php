<?php

//引用主設定檔
include "main.php";

//If you want the errors to be shown  *是否显示错误
error_reporting(E_ALL);
ini_set('display_errors', '1');
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    "driver" => "mysqli",
    "host" => $config['database']['host'],
    "database" => $config['database']['database'],
    "username" => $config['database']['username'],
    "password" => $config['database']['password']
]);
//Make this Capsule instance available globally. *要让 capsule 能在全局使用
$capsule->setAsGlobal();
// Setup the Eloquent ORM.
$capsule->bootEloquent();