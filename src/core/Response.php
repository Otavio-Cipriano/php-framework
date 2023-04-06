<?php

namespace otaviocipriano\phpframephork\core;

class Response
{
    public function send($data){
        if(is_array($data)){
            $data = json_encode($data);
            $this->setHeader(['content-type' => 'application/json']);
            echo $data;
            return $this;
        }

        if(is_string($data)){
            $this->setHeader(['content-type' => 'text/html']);
            echo $data;
            return $this;
        }
    }
    public function status(int $code){
        http_response_code($code);
        return $this;
    }

    public function setHeader(array $header){
        foreach ($header as $key => $value) {
            $head = ucwords($key);
            header("$head: $value");
        }
        return $this;
    }

    public function redirect(string $url){
        header("Location: $url");
        return $this;
    }

    public function render($view, $layout, $params = []){
        $render = new View();
        $render->render($view, $layout, $params);
    }
    
}
