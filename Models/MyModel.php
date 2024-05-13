<?php
namespace Models;
include "./config/main.php";

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Events\Dispatcher;

class MyModel
{
    private array $_config;

    public function __construct()
    {
        $config = json_decode(file_get_contents('./config/config.json'), true);
        $this->_config = [
            "driver" => "mysql",
            "host" => $config['database']['host'],
            "database" => $config['database']['database'],
            "username" => $config['database']['username'],
            "password" => $config['database']['password']
        ];

        $this->init();
    }

    public function init()
    {
        $_DB = new DB();
        $_DB->addConnection($this->_config);
        $_DB->setEventDispatcher(new Dispatcher());
        $_DB->setAsGlobal();
        $_DB->bootEloquent();
    }

}
