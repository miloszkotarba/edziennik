<?php

class App
{
    protected $routes = [
        '/home',
        '/login',
        '/dashboard',
        '/profile',
        '/oceny',
        '/ogloszenia',
        '/admin',
        '/teacher',
        '/student',
        '/subject',
        '/oddzial',
        '/zajecia',
        '/kartaocen'
    ];
    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        $name = 'app/' . $url[0] . '.php';
        if (in_array('/' . $url[0], $this->routes)) {
            $this->controller = $url[0];
            unset($url[0]);

            require_once 'app/' . $this->controller . '.php';

            $this->controller = new $this->controller;

            ///sprawdzanie czy istnieje metoda w kontrolerze
            if (isset($url[1])) {
                if (method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    unset($url[1]);
                }
                else {
                    http_response_code(404);
                    require '404.php';
                    die();
                }
            }

            $this->params = $url ? array_values($url) : [];
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else if ($url[0] === '') {
            header('Location: /home');
        } else {
            http_response_code(404);
            require '404.php';
            die();
        }

    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}