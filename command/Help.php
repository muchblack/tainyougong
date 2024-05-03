<?php

namespace command;

use command\core;

class Help implements core
{
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