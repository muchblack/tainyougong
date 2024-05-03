<?php

namespace command;

use command\core;

class WhatToEat implements core
{
    protected $food = ['漢堡', '炸雞', '可樂'];
    protected $params ;

    public function __construct($params=[])
    {
        $this->params = $params;
    }

    public function run()
    {
        $check = rand(0,2);
        $txt = '我推薦你吃'. $this->food[$check];
        return $txt;
    }
}