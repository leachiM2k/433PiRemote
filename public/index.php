<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 29.04.17
 * Time: 12:34
 */
use Core\Application;
use Core\Configuration;
use Core\Renderer\RenderFactory;
use Core\Storage\StorageFactory;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'on');

require_once '../vendor/autoload.php';
$applicationPath = __DIR__ . '/../app';
require_once $applicationPath . '/autoload.php';

$config = new Configuration();
$config->setGeneralConfig(parse_ini_file($applicationPath . '/config.ini', true));

$renderFactory = new RenderFactory($config->getGeneralConfig()['renderer']);
$config->setRenderer($renderFactory->getRenderer());

$storageFactory = new StorageFactory($config->getGeneralConfig()['storage']);
$config->setStorage($storageFactory->getStorage());

$application = new Application($config);
$application->run();