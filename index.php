<?php

include __DIR__.'/config/main.php';

use App\tainYouGongBot;

$config = json_decode(file_get_contents('./config/config.json'), true);
$bot = new tainYouGongBot($config);


