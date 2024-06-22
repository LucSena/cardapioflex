<?php
namespace App\Controllers;

class AuthController {
    function login($f3) {
        echo \Template::instance()->render('login.html');
    }

    function loginPost($f3) {
        // Lógica de login
    }

    function register($f3) {
        echo \Template::instance()->render('register.html');
    }

    function registerPost($f3) {
        // Lógica de cadastro
    }
}
