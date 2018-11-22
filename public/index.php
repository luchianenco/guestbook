<?php

use App\Application;
use App\Http\Message\Factory\RequestFactory;
use \App\Container\ContainerBuilder;
use \App\Container\DefinitionResolver;
use \App\Container\Configuration;

require __DIR__.'/../vendor/autoload.php';

$dotEnv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotEnv->load();

$resolver = new DefinitionResolver();
$builder = new ContainerBuilder($resolver);
$config = new Configuration();
$container = $builder->build($config);

$app = new Application($container);
$request = RequestFactory::create();
$response = $app->handle($request);
$response->send();

