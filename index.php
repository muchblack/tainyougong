<?php

include __DIR__.'/config/main.php';

use Discord\Discord;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;

$discord = new Discord([
    'token' => $config['token'],
]);

$prefix = '!';

$discord->on('ready', function ($discord) {
    echo "Bot is ready!", PHP_EOL;

    // Listen for messages.
    $discord->on('message', function ($message, $discord) {
        // If message is from a bot
        if ($message->author->bot) {
            // Do nothing
            return;
        }

        echo "{$message->author->username}: {$message->content}",PHP_EOL;

        // If message is "ping"
        if ($message->content == 'ping') {
            // Reply with "pong"
            $message->reply('pong');
        }
    });
});

$discord->run();
?>