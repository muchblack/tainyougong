<?php

namespace command;

use command\core;

class Divination implements core
{
    private $discord;

    public function __construct($discord)
    {
        $this->discord = $discord;
    }
    
    public function run()
    {
        $path = 'command';
        $files = scandir($path);
        $command = [];
        foreach($files as $file)
        {
            if($file != '.' && $file !='..' && $file != 'core.php')
            {
                $tmpFile = explode('.', $file);
                $command[] = $tmpFile[0];
            }
        }

        $returnTxt = '目前的指令有：'. implode(',', $command);

        return $returnTxt;
    }
}