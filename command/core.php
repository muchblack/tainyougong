<?php
namespace command;

interface core
{
    public function __construct($discord);

    public function run();
}