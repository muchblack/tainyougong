<?php

namespace command;

use command\core;

class WhatToEat implements core
{
    protected $food = ['漢堡', '炸雞', '可樂'];
    protected $params ;

    public function __construct($message, $params=[])
    {
        $this->params = $params;
    }

    public function run()
    {
        $check = rand(0,2);
        $txt = '吾，柚神，推薦你吃'. $this->food[$check];
        return [
            'tts' => 2000,
            'frontMessage' => '柚巫女虔誠的向柚神祈禱，忽然在耳邊聽到柚神的聲音...',
            'message' => [$txt]
        ];
    }
}