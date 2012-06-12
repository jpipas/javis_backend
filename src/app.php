<?php

/**
* Bootstrap
**/
//$client = require __DIR__.'/client.php';
//$territory = require __DIR__.'/territory.php';

$app = require __DIR__.'/bootstrap.php';

$app['debug'] = true;

$app->get('/hello/{name}', function($name) use($app) { 
    return 'Hello '.$app->escape($name); 
});