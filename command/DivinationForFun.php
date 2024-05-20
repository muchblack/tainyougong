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
    
    public function run(): array
    {
        $getQian = mt_rand(1,27);
        $picPath = dirname(__DIR__).'/Pics/YC_'.$getQian.'.jpg';
        $picName = 'YC_'.$getQian.'.jpg';

        return [
            'frontMessage' => '你虔誠的投入香油錢，搖響鈴鐺並且虔誠一拜。隨後拿起B4君搖出一顆松果出來',
            'message'=> [],
            'isEmbed' => false,
            'filePath' => $picPath,
            'fileName' => $picName
        ];
    }
}
