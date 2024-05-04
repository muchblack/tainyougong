<?php

namespace Traits;

trait Commands 
{
    public function getCommands()
    {
        return [
            '指令清單' => 'Help',
            '食物命運大轉輪' => 'WhatToEat',
            '神社求籤' => 'Divination',
            '八卦起卦' => 'BaGua',
        ];
    }
}