<?php
namespace Model;
include "./config/main.php";

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Events\Dispatcher;

class MyModel
{
    private $_config; 
    private $_DB;
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
        $this->_DB = new DB();
        $this->_DB->addConnection($this->_config);
        $this->_DB->setEventDispatcher(new Dispatcher());
        $this->_DB->setAsGlobal();
        $this->_DB->bootEloquent();
    }

}