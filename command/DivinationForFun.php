<?php

namespace command;

use command\core;
use Discord\Parts\Embed\Embed;

class DivinationForFun implements core
{
    private $discord;

    public function __construct($discord)
    {
        $this->discord = $discord;
    }
    
    public function run()
    {
        $qianShi = json_decode(file_get_contents('./divination/Divination_JP.json'), true);
        $getQian = mt_rand(0,99);
        $rightQian = $qianShi[$getQian];
        
        return [
            'frontMessage' => '你虔誠的投入香油錢，搖響鈴鐺並且虔誠一拜。隨後拿起B4君搖出一顆松果出來',
            'message'=> [],
        ];
    }
}