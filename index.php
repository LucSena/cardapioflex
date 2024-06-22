<?php
require 'vendor/autoload.php';

$f3 = \Base::instance();

// Configuração do banco de dados
$f3->set('DB', new \DB\SQL('mysql:host=localhost;port=3306;dbname=cardapioflex', 'root', ''));

// Definindo o diretório de templates
$f3->set('UI', 'app/views/');

// Definindo rotas
require 'app/routes.php';

$f3->run();
