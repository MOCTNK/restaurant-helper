<?php

namespace application\core;

class View
{
    public $path;
    public $pathHead;
    public $pathAfterBody;
    public $route;
    public $layout = 'default';

    public function __construct($route) {
        $this->route = $route;
        $this->path = $route['controller'].'/'.$route['action'];
        $this->pathHead = 'application/views/'.$this->route['controller'].'/head.php';
        $this->pathAfterBody = 'application/views/'.$this->route['controller'].'/afterBody.php';
    }

    public function render($title = "", $vars = []) {
        extract($vars);
        $path = 'application/views/'.$this->path.'.php';
        if(file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            $head = '';
            $afterBody = '';
            if(file_exists($this->pathHead)) {
                $head = file_get_contents($this->pathHead);
            }
            if(file_exists($this->pathAfterBody)) {
                $afterBody = file_get_contents($this->pathAfterBody);
            }
            require 'application/views/layouts/'.$this->layout.'.php';
        } else {
            echo "view not found ".$this->path.'.php';
        }
    }

    public static function redirect($url) {
        header('location: '.$url);
    }
    public static function errorCode($code) {
        http_response_code($code);
        $path = 'application/views/errors/'.$code.'.php';
        if(file_exists($path)) {
            require $path;
        }
        exit;
    }
}