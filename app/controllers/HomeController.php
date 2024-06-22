<?php
namespace App\Controllers;

class HomeController {
    function index($f3) {
        echo \Template::instance()->render('home.html');
    }
}
