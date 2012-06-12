<?php
use Silex\ControllerCollection;
$client = new ControllerCollection();


$client->get('/{name}', function($name) use($client) { 
    return "Client Hello: $name"; 
});



return $client;