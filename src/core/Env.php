<?php

namespace app\core;

use Dotenv\Dotenv;

class Env{

    private $dotenv;

    function __construct()
    {
        $this->dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $this->dotenv->safeLoad();
    }
}