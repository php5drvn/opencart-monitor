<?php

class Config {

    public $data;

    protected $registry;

    public function __construct($registry) {
        $this->registry = $registry;
    }

    public function setData($config) {
        $this->data = $config;
    }

}