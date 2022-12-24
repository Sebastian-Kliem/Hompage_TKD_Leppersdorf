<?php

function autoloader($class)
{
    $newName = str_replace('\\', '/', $class);
    $path = "Libary/$newName.php";

    if (!class_exists($class)) {
        if (file_exists($path)) {
            require $path;
        }
    }
}

spl_autoload_register('autoloader');

ini_set('display_errors', true);

define('BASEPATH', dirname(__FILE__));

$bootstrap = new Bootstrap();
$bootstrap->run();