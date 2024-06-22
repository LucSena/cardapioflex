<?php
$f3->route('GET /', 'App\Controllers\HomeController->index');
$f3->route('GET /login', 'App\Controllers\AuthController->login');
$f3->route('POST /login', 'App\Controllers\AuthController->loginPost');
$f3->route('GET /register', 'App\Controllers\AuthController->register');
$f3->route('POST /register', 'App\Controllers\AuthController->registerPost');
$f3->route('GET /dashboard', 'App\Controllers\DashboardController->index');
// Outras rotas para editar cardápio, promoções, disponibilidade, etc.
