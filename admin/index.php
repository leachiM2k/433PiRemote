<?php
error_log(E_ALL);
ini_set("display_errors", "on");

$includeBaseDir = realpath("../") . '/';
include_once $includeBaseDir . 'vendor/autoload.php';
include_once $includeBaseDir . 'PiRemote.class.php';

$twigTemplates = new Twig_Loader_Filesystem($includeBaseDir . 'twig/templates');
$twig = new Twig_Environment($twigTemplates, array(
    'cache' => $includeBaseDir . 'twig/cache',
    'debug' => true,
));

$remoteBackend = new PiRemote();
$data = $remoteBackend->getEntries();

$twigParams  = array(
    'data' => $data,
    'isConfigWritable' => $remoteBackend->isConfigWritable(),
);
echo $twig->render("admin/index.html.twig", $twigParams);
