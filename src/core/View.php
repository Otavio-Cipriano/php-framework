<?php

namespace otaviocipriano\phpframephork\core;

class View{

    protected string $files_path= __DIR__ . '/../views';
    
    public function render($view, $layout, $params = []){
        $path = $this->files_path . "/$view.php";
        $view = $this->fetch_view($path);
        $view = $this->renderLayout($view, $layout); 
        echo $this->renderParams($view, $params);
    }

    protected function renderParams($view, $params){
        foreach ($params as $key => $value) {
            $view = str_replace('{{'.$key.'}}',$value,$view);
        }
        return $view;
    }

    protected function renderLayout($view, $layout){
        $layout = $this->fetch_layout($layout);
        return str_replace('{{'. 'content' .'}}', $view, $layout);
    }

    protected function fetch_layout($layout){
        ob_start();
        include($this->files_path . "/layout/$layout.php");       
        return ob_get_clean();
    }

    protected function fetch_view($path){
        ob_start();
        include($path);
        return ob_get_clean();
    }
}