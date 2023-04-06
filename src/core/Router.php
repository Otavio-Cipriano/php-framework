<?php

namespace app\core;

class Router{

   

    protected Request $request;

    protected Response $response;
    
    public array $routes = [];

    function __construct()
    {
        $this->request = new Request;
        $this->response = new Response;
    }

    public function get(string $path, ...$callback){
        $this->routes[$path]['get'] = $callback;
        return $this;
    }

    public function post($path, ...$callback){
        $this->routes[$path]['post'] = $callback;
        return $this;
    }

    public function resolve(){
        $path = $this->request->path;
        $method = $this->request->method;
        $callbacks = $this->routes[$path][$method] ?? false;

        if($callbacks === false){
            echo "Está Rota não existe";
            return;
        }

        foreach ($callbacks as $key => $callback) {
            if(is_string($callback)){
                echo $callback;
                return;
            }
    
            if(is_array($callback)){
                $callback[0] = new $callback[0]();
            }
            
            $next = call_user_func($callback, $this->request, $this->response);

            if(!$next){
                break;
            }
        }
    }
}