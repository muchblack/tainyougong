<?php

include __DIR__.'/config/main.php';

use Discord\Discord;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;
use Discord\Parts\Embed\Embed;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;

//建立新的logger,避免太多DEBUG敘述
$streamHandler = new StreamHandler('php://stdout', Monolog::INFO);
$lineFormatter = new LineFormatter(null, null, true, true);
$streamHandler->setFormatter($lineFormatter);
$newLogger = new Monolog('DiscordPHP', [$streamHandler]);

//建立新的discord連線
$discord = new Discord([
    'token' => $config['token'],
    'intents' => [
        Intents::MESSAGE_CONTENT, 
        Intents::GUILD_MESSAGES, 
        Intents::DIRECT_MESSAGES, 
        Intents::GUILD_MESSAGE_TYPING, 
        Intents::DIRECT_MESSAGE_REACTIONS
    ],
    'logger' => $newLogger,
]);

$commands = [
    'help' => '指令清單',
    'whatToEat' => '食物命運大轉輪',
];

$discord->on('init', function ($discord) use ($config, $commands) {
    echo "Bot is ready!", PHP_EOL;
    $discord->on(Event::MESSAGE_CREATE, function ($message, $discord) use ($config, $commands) {        
        // If message is from a bot
        if ($message->author->bot) {
            // Do nothing
            return;
        }
        echo "{$message->author->global_name}: {$message->content}",PHP_EOL;
        // If message is "ping"
        if ($message->content == 'ping') {
            // Reply with "pong"
            $message->reply('pong');
        }
        //測試
        $originCommand = $message->content ;

        $builder = \Discord\Builders\MessageBuilder::new();

        //指令類型 !help <參數1> <參數2>
        if(strpos($originCommand, $config['prefix']) !== false ){
            $oriParams  = explode(' ', $originCommand);
            //先拆params
            $command = explode($config['prefix'], $oriParams[0]);
            unset($oriParams[0]);

            $class = '\command\\'.$command[1];
            if(class_exists($class))
            {
                $objClass = new $class($oriParams);
                $txt = $objClass->run();
            }
            else
            {
                $txt = '指令輸入錯誤';
            }

            $message->reply('請稍等...');
            $message->delayedReply($txt, 1500);
        }
    });
});

$discord->run();
