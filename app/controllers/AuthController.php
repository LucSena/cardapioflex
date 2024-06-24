<?php namespace App\Controllers;

use \DB\SQL\Mapper;
class AuthController {
    function login($f3) {
        // Verifica se o usuário já está logado
        if ($f3->get('SESSION.user')) {
            $f3->reroute('/dashboard');
            return;
        }
        echo \Template::instance()->render('login.html');
    }

    function loginPost($f3) {
        // Lógica de login
        $db = $f3->get('DB');
        $email = $f3->get('POST.email');
        $password = $f3->get('POST.password');

        $admin = $db->exec('SELECT * FROM administradores WHERE email = ?', $email);

        if ($admin && password_verify($password, $admin[0]['senha'])) {
            // Iniciar sessão
            $f3->set('SESSION.user', $admin[0]['id']);
            $f3->reroute('/dashboard');
        } else {
            // Mensagem de erro
            $f3->set('error', 'Email ou senha inválidos.');
            echo \Template::instance()->render('login.html');
        }
    }

    function cadastro($f3) {
        // Verifica se o usuário já está logado
        if ($f3->get('SESSION.user')) {
            $f3->reroute('/dashboard');
            return;
        }
        echo \Template::instance()->render('cadastro.html');
    }

    function registerPost($f3) {
        // Lógica de cadastro
        $db = $f3->get('DB');
        $nome = $f3->get('POST.name');
        $email = $f3->get('POST.email');
        $password = password_hash($f3->get('POST.password'), PASSWORD_DEFAULT);

        $db->exec('INSERT INTO administradores (nome, email, senha) VALUES (?, ?, ?)', [$nome, $email, $password]);

        $f3->reroute('/login');
    }

    function logout($f3) {
        // Lógica de logout
        $f3->clear('SESSION.user');
        $f3->reroute('/login');
    }
}
