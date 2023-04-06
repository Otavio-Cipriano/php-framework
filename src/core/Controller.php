<?php

namespace app\core;


class Controller {

    protected string $layout = 'main';
    
    protected function set_layout($layout){
        $this->layout = $layout;
    }
}