<?php

class Loader {

    private $registry;

    private $method = 'index';
    public $route = '';
    public $file = '';

    public function __construct($registry) {
        $this->registry = $registry;
    }

    public function controller($route, $registry) {

        $parts = explode('/', preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route));

        // Break apart the route
        while ($parts) {
            $file = DIR_APP . 'controller/' . implode('/', $parts) . '.php';

            if (is_file($file)) {
                $this->route = implode('/', $parts);
                $this->file = $file;

                break;
            } else {
                $this->method = array_pop($parts);
            }
        }

        $class = explode('/', $this->route);
        $class = array_pop($class);
        $class = $class.'Controller';

        if (!is_file($this->file)) {
            $this->file = DIR_APP.'controller/common/error.php';
            $class = 'ErrorController';
            $this->method = 'index';
        }

        include_once $this->file;

        $controller = new $class($registry);
        $output = $controller->{$this->method}();

        return $output;
    }

    public function model($route) {
        // Sanitize the call
        $route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);

        if (!$this->registry->has('model_' . str_replace('/', '_', $route))) {
            $file  = DIR_APP . 'model/' . $route . '.php';

            $className = explode('/', $route);
            $className = array_pop($className);

            if (is_file($file)) {
                include_once($file);

                $model = new $className($this->registry);


                $this->registry->set('model_' . str_replace('/', '_', (string)$route), $model);
            } else {
                throw new \Exception('Error: Could not load model ' . $route . '!');
            }
        }
    }

}