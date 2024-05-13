<?php

namespace command;

use command\core;
use Discord\Parts\Embed\Embed;
use Traits\Commands;

class Help implements core
{
    use Commands;

    private $discord;

    public function __construct($discord)
    {
        $this->discord = $discord;
    }

    public function run(): array
    {
        $embed = $this->discord->factory(
            Embed::class,
            [
                'color' => 14873937,
                'author' => [
                    'name' => $this->discord->application->name, 
                    'icon_url' => $this->discord->application->icon,
                ],
                'title' => '天柚宮巫女服務項目',
                'type' => 'rich',
                'description' => '柚巫女將竭誠爲您服務',
                'fields' => [
                    [
                        'name' => '!八卦起卦',
                        'value' => '可以請柚巫女幫忙起卦，協助您問事',
                        'inline' => false,
                    ],
                    [
                        'name' => '!趣味抽籤',
                        'value' => '來試試看趣味抽籤吧！',
                        'inline' => false,
                    ],
                    [
                        'name' => '!神社求籤',
                        'value' => '心中有所疑惑的時候，不妨來抽個籤看看？',
                        'inline' => false,
                    ],
                    [
                        'name' => '!露營煮什麼',
                        'value' => '露營的時候不知道要煮什麼嗎？柚巫女有整理了一份美食清單哦！ 不妨試試',
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
            'message'=> $embed
        ];
    }
}
