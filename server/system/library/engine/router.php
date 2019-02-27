<?php

class Router {

    private $registry;

    public $route;

    public function __construct($registry) {
        $this->registry = $registry;
        $this->getRoute();
    }

    public function getRoute() {
        if (isset($_GET['route'])) {
            $this->route = $_GET['route'];
        } else {
            $this->route = 'extension/extension';
        }
    }

}