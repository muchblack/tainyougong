<?php

namespace command;

use command\core;
use Discord\Parts\Embed\Embed;

class Divination implements core
{
    private $discord;

    public function __construct($discord)
    {
        $this->discord = $discord;
    }
    
    public function run(): array
    {
        $qianShi = json_decode(file_get_contents(dirname(__DIR__).'/divination/Divination_JP.json'), true);
        $getQian = mt_rand(0,99);
        $rightQian = $qianShi[$getQian];
        $embed = $this->discord->factory(
            Embed::class,
            [
                'color' => 14873937,
                'title' => '台灣天柚宮',
                'type' => 'rich',
                'description' => '第'.$rightQian['index'].'籤  '.$rightQian['lucky'],
                'fields' => [
                    [
                        'name' => '籤詩',
                        'value' => $rightQian['content'],
                        'inline' => false,
                    ],
                    [
                        'name' => '解釋',
                        'value' => $rightQian['explain'],
                        'inline' => false,
                    ],
                    [
                        'name' => '所求',
                        'value' => $rightQian['result'],
                        'inline' => false,
                    ],
                ],
                'footer' => [
                    'text' => '@ 柚巫女關心您'
                ],
            ],
            true
        );
        return [
            'frontMessage' => '你虔誠的投入香油錢，搖響了鈴鐺並且拜了一拜。隨後拿起籤筒搖了一隻籤出來',
            'message'=> $embed,
            'isEmbed' => true,
        ];
    }
}
