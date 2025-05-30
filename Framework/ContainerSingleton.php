<?php

namespace Framework;

class ContainerSingleton extends Container
{
    private static Container $_instance;

    public function __construct()
    {
        if (isset(self::$instance)) {
            self::$_instance;
        } else {
            self::$_instance = $this;
        }
    }

    public static function getInstance()
    {
        return new ContainerSingleton();
    }
}
