<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        // Login check is done by the "auth" filter in Routes.php

        // This parent's enrollments (empty list if the table is missing)
        $enrollments = [];

        try {
            $db = \Config\Database::connect();

            $enrollments = $db->table('enrollments')
                ->where('user_id', session()->get('user_id'))
                ->orderBy('id', 'DESC')
                ->get()
                ->getResult();

        } catch (\Throwable $e) {
            $enrollments = [];
        }

        return view('dashboard', [
            'userName'    => session()->get('user_name'),
            'userEmail'   => session()->get('user_email'),
            'enrollments' => $enrollments,

            // TEMPORARY: shows all session data on the dashboard. Remove later.
            'sessionData' => session()->get(),
        ]);
    }
}