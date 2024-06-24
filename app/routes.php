<?php
$f3->route('GET /', 'App\Controllers\HomeController->index');
$f3->route('GET /login', 'App\Controllers\AuthController->login');
$f3->route('POST /login', 'App\Controllers\AuthController->loginPost');
$f3->route('GET /cadastro', 'App\Controllers\AuthController->cadastro');
$f3->route('POST /cadastro', 'App\Controllers\AuthController->registerPost');
$f3->route('GET /dashboard', 'App\Controllers\DashboardController->index');
$f3->route('GET /logout', 'App\Controllers\AuthController->logout');
// Outras rotas para editar cardápio, promoções, disponibilidade, etc.
