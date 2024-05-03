<?php

namespace command;

use command\core;
use Traits\Commands;

class Help implements core
{
    use Commands;

    public function run()
    {
        $path = 'command';
        $files = scandir($path);
        $commandsList = $this->getCommands();
        $command = [];
        foreach($files as $file)
        {
            if($file != '.' && $file !='..' && $file != 'core.php')
            {
                $tmpFile = explode('.', $file);
                $command[] = array_search($tmpFile[0], $commandsList);
            }
        }

        $returnTxt = '目前的指令有：'. implode(',', $command);

        return $returnTxt;
    }
}