<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::post('login', 'SecurityController');
/* Routing::post('register', 'DefaultController'); */
/* Routing::get('events', 'DefaultController'); */
Routing::get('my_events', 'DefaultController');
/* Routing::post('add_event', 'DefaultController'); */
Routing::run($path);
