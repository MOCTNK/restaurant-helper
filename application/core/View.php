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
        $this->pathHead = $this->route['controller'];
        $this->pathAfterBody = $this->route['controller'];
    }

    public function render($title = "", $vars = []) {
        extract($vars);
        $path = 'application/views/'.$this->path.'.php';
        $pathHead = 'application/views/'.$this->pathHead.'/head.php';
        $pathAfterBody = 'application/views/'.$this->pathAfterBody.'/afterBody.php';
        if(file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            $head = '';
            $afterBody = '';
            if(file_exists($pathHead)) {
                $head = file_get_contents($pathHead);
            }
            if(file_exists($pathAfterBody)) {
                $afterBody = file_get_contents($pathAfterBody);
            }
            require 'application/views/layouts/'.$this->layout.'.php';
        } else {
            echo "view not found ".$this->path.'.php';
        }
    }

    public function getView($path, $vars = []) {
        extract($vars);
        ob_start();
        require 'application/views/'.$path;
        return ob_get_clean();
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