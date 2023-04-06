<?php
    
namespace otaviocipriano\phpframephork\core;

class Session{

    private array $options;

    function __construct($options = [])
    {           
        $this->options = $options;
    }

    public function start(){
        session_set_cookie_params([...$this->options]);
        session_start();
    }

    public function set_session(string $session_name, mixed $props){
        $_SESSION[$session_name] = $props;
    }

    public function get_session(string $session_name){
        return $_SESSION[$session_name]?? null;
    }

    public function destroy_session(){
        session_destroy();
    }
}