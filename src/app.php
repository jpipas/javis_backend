<?php

/**
* Bootstrap
**/


require_once __DIR__.'/../vendor/autoload.php';

use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;


$client = require __DIR__.'/client.php';
//$territory = require __DIR__.'/territory.php';


$app = new Silex\Application();

require __DIR__ . '/config.php';

$app->register(new HttpCacheServiceProvider());

$app->register(new SessionServiceProvider());
//$app->register(new ValidatorServiceProvider());
//$app->register(new FormServiceProvider());
$app->register(new UrlGeneratorServiceProvider());

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile'       => __DIR__.'/../log/app.log',
    'monolog.name'          => 'app',
    'monolog.level'         => 300 // = Logger::WARNING
));

$app->register(new DoctrineServiceProvider(), array(
    'db.options'    => array(
        'driver'    => $app['db.config.driver'],
        'dbname'    => $app['db.config.dbname'],
        'host'      => $app['db.config.host'],
        'user'      => $app['db.config.user'],
        'password'  => $app['db.config.password'],
        'port'      => $app['db.config.port'], 
    )
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/../views',
));

// Temporary hack. Silex should start session on demand.
$app->before(function() use ($app) {
    $app['session']->start();
});

$app->mount('/client',$client);