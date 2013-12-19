<?php

define('ROOT', dirname(__FILE__));

function __autoload($className) 
{
    $ext = (strpos($className, "i") === 0) ? ".interface.php" : ".class.php";

    if (strpos($className, "i") === 0)
        $className = substr($className, 1);

    $filename = ROOT . "/model/". $className . $ext;

    if (!file_exists($filename)) 
        throw new Exception('Failed to include class file for [' . $className . ']');

    include_once($filename);
}

function exception_handler($exception) 
{
    echo "Error: " . $exception->getMessage() . "\n";
}

set_exception_handler('exception_handler');
