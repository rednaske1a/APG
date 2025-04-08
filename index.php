<?php
require 'core/Router.php';

$router = new Router();

// Routes for login, registration, home, and logout
$router->add('/',           'Page@landing');
$router->add('/home',       'Page@home');
$router->add('/chat',       'Page@chat');

$router->add('/login',      'Auth@login');
$router->add('/register',   'Auth@register');
$router->add('/logout',     'Auth@logout');

$router->dispatch($_SERVER['REQUEST_URI']);
