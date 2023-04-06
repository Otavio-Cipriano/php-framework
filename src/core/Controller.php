<?php

namespace otaviocipriano\phpframephork\core;


class Controller {

    protected string $layout = 'main';
    
    protected function set_layout($layout){
        $this->layout = $layout;
    }
}