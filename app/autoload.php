<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 29.04.17
 * Time: 12:43
 */
spl_autoload_register(function ($class) {
    $searchPath = __DIR__ . '/';
    $classFilename = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $filename = $searchPath . $classFilename . '.php';
    if(is_readable($filename)) {
        require_once $filename;
    }
});