<?php

include __DIR__.'/config/main.php';

use App\tainYouGongBot;

$config = json_decode(file_get_contents('./config/config.json'), true);
try {
    $bot = new tainYouGongBot($config);
} catch (\Discord\Exceptions\IntentException $e) {
}


