<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home', [
            'title' => 'Little Doctors — Big knowledge for little doctors',
        ]);
    }
}
