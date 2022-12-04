<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('login', 'DefaultController');
Routing::get('register', 'DefaultController');
Routing::get('events', 'DefaultController');
Routing::get('my_events', 'DefaultController');
Routing::get('add_event', 'DefaultController');
Routing::run($path);
