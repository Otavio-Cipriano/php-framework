<?php

namespace otaviocipriano\phpframephork\core;

class Request{
    public string $method;

    public string $path;

    public mixed $body;

    public array $params;

    protected string $URI;

    function __construct()
    {
        $this->URI = $_SERVER['REQUEST_URI'];
        $this->method = $this->request_method();
        $this->path = $this->request_path();
        $this->body = $this->request_body();
    }

    private function request_method(){
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    private function request_path(){
        return strpos($this->URI, '?') ? substr($this->URI, 0, strpos($this->URI, '?')) : $this->URI;
    }

    private function request_body(){
        if($this->method === 'get'){
            return filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if($this->method === 'post'){
            return filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }

}