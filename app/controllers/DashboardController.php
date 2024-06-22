<?php
namespace App\Controllers;

class DashboardController {
    function index($f3) {
        echo \Template::instance()->render('dashboard.html');
    }
}
