<?php

namespace Generic;


class AbstractApplication
{
    public $config;

    public function __construct()
    {
        error_reporting(-1);
        $this->config = include('../config/app.php');
    }

    public function getLocale()
    {
        return $this->config['locale'];
    }

    public function csrf()
    {
        // Not Yet Implemented
    }
}