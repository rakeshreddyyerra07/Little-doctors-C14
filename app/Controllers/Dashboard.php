<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        // Login check is done by the "auth" filter in Routes.php
        return view('dashboard', [
            'userName'  => session()->get('user_name'),
            'userEmail' => session()->get('user_email'),
        ]);
    }
}