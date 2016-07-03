<?php

use Symfony\Component\HttpFoundation\Request;

/** @var $loader Composer\Autoload\ClassLoader */
$loader = require __DIR__ . '/../app/autoload.php';
include_once __DIR__ . '/../app/bootstrap.php.cache';

$apcLoader = new Symfony\Component\ClassLoader\ApcClassLoader('antlers-ads-master', $loader);
$loader->unregister();
$apcLoader->register(true);

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();
$kernel = new AppCache($kernel);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
