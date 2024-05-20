<?php
namespace App;

use Discord\Discord;
use Discord\Exceptions\IntentException;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;
use Discord\Builders\MessageBuilder;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;

use Traits\Commands;

class tainYouGongBot {

    use Commands;

    private Discord $_discord;

    /**
     * @throws IntentException
     */
    public function __construct($config)
    {
        //建立新的logger,避免太多DEBUG敘述
        $streamHandler = new StreamHandler('php://stdout', Monolog::INFO);
        $lineFormatter = new LineFormatter(null, null, true, true);
        $streamHandler->setFormatter($lineFormatter);
        $newLogger = new Monolog('DiscordPHP', [$streamHandler]);

        //建立新的discord連線
        $this->_discord = new Discord([
            'token' => $config['token'],
            'intents' => [
                Intents::MESSAGE_CONTENT, 
                Intents::GUILD_MESSAGES, 
                Intents::DIRECT_MESSAGES, 
                Intents::GUILD_MESSAGE_TYPING, 
                Intents::DIRECT_MESSAGE_REACTIONS,
                Intents::GUILDS,
            ],
            'logger' => $newLogger,
        ]);

        $this->run($this->_discord, $config);
    }

    public function run($discord, $config): void
    {
        $discord->on('init', function (Discord $discord) use ($config) {
            echo "Bot is ready!", PHP_EOL;
        });
        $discord->on(Event::MESSAGE_CREATE, function ($message) use ($config, $discord) {  
            // 只要是bot發的訊息一律不處理，防止一直loop
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
    
            //指令類型 !help <參數1> <參數2>
            if(str_contains($originCommand, $config['prefix'])){
                $oriParams  = explode(' ', $originCommand);
                //先拆params
                $command = explode($config['prefix'], $oriParams[0]);
                unset($oriParams[0]);
    
                //用中文換英文class name
                $commandsList = $this->getCommands();
                $className = $commandsList[$command[1]];
    
                $class = '\command\\'.$className;
                if(class_exists($class))
                {
                    $objClass = new $class($discord);
                    //注意：回傳格式['tts'=> 1500, 'frontMessage'=>'','message'=>'']
                    $txt = $objClass->run();
                }
                else
                {
                    $txt = [
                        'tts' => 1500,
                        'frontMessage' => '請稍等...',
                        'message' => ['指令輸入錯誤，可以使用!指令清單確認服務項目哦！'],
                        'isEmbed' => false,
                    ];
                }

                if($txt['isEmbed'])
                {
                    if(isset($txt['frontMessage']))
                    {
                        $message->channel->sendMessage(MessageBuilder::new()->setContent($txt['frontMessage']));
                    }
                    $message->channel->sendMessage(MessageBuilder::new()->setContent('')->addEmbed($txt['message']));
                }
                else
                {
                    $message->channel->sendMessage(MessageBuilder::new()->setContent($txt['frontMessage']));
                    if(isset($txt['fileName']))
                    {
                        $message->channel->sendMessage(MessageBuilder::new()->setContent('')->addFile($txt['filePath'], $txt['fileName']));
                    }
                    foreach($txt['message'] as $item)
                    {
                        $message->delayedReply($item, $txt['tts']);
                    }
                }
            }
        });
        
        $discord->run();
    }
}
