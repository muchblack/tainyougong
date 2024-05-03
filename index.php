<?php

include __DIR__.'/config/main.php';

use App\tainYouGongBot;
use command\BaGua;

$bot = new tainYouGongBot($config);

// $bagua = new BaGua();
// var_dump($bagua->run());