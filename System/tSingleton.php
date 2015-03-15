<?php
namespace MazeGenerator\System;

trait tSingleton
{
    protected static $instance;

    protected function __construct(){}
    protected function __clone(){}
    protected function __sleep(){}
    protected function __wake(){}

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}

?>