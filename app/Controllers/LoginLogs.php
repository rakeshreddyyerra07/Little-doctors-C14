<?php

namespace App\Controllers;

use App\Models\LoginLogModel;

class LoginLogs extends BaseController
{
    public function index()
    {
        $session = session();
        $email   = $session->get('email') ?? $session->get('user_email');

        if (! $email) {
            $id = $session->get('user_id') ?? $session->get('id') ?? $session->get('userId');
            $u  = \Config\Database::connect()->table('users')->select('email')
                    ->where('id', $id)->get()->getRowArray();
            $email = $u['email'] ?? '';
        }

        $model = new LoginLogModel();
        $logs  = $model->where('emailaddress', $email)
                       ->orderBy('last_attempted_time', 'DESC')
                       ->paginate(15);

        return view('auth/login_logs', [
            'logs'  => $logs,
            'pager' => $model->pager,
        ]);
    }
}