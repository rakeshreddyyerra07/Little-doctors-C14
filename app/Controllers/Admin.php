<?php

namespace App\Controllers;

use App\Models\LoginLogModel;

class Admin extends BaseController
{
    public function index()
    {
        helper('geo');

        $db    = \Config\Database::connect();
        $today = date('Y-m-d');

        $recent = $db->table('login_logs')->orderBy('last_attempted_time', 'DESC')
                     ->limit(10)->get()->getResultArray();

        backfill_log_locations($recent);

        $data = [
            'totalUsers'   => $db->table('users')->countAllResults(),
            'successToday' => $db->table('login_logs')->where('status', 'success')
                                 ->where('DATE(last_attempted_time) =', $today)->countAllResults(),
            'failedToday'  => $db->table('login_logs')->where('status', 'failed')
                                 ->where('DATE(last_attempted_time) =', $today)->countAllResults(),
            'recent'       => $recent,
        ];

        return view('admin/dashboard', $data);
    }

    public function users()
    {
        $users = \Config\Database::connect()->table('users')
                    ->select('id, name, email, role')->orderBy('id', 'ASC')
                    ->get()->getResultArray();

        return view('admin/users', ['users' => $users]);
    }

    public function logs()
    {
        helper('geo');

        $model  = new LoginLogModel();
        $status = $this->request->getGet('status');
        $email  = trim((string) $this->request->getGet('email'));
        $from   = $this->request->getGet('from');
        $to     = $this->request->getGet('to');

        if (in_array($status, ['success', 'failed'], true)) {
            $model->where('status', $status);
        }
        if ($email !== '') {
            $model->like('emailaddress', $email);
        }
        if ($from) {
            $model->where('last_attempted_time >=', $from . ' 00:00:00');
        }
        if ($to) {
            $model->where('last_attempted_time <=', $to . ' 23:59:59');
        }

        $logs = $model->orderBy('last_attempted_time', 'DESC')->paginate(20);

        backfill_log_locations($logs);

        return view('admin/logs', [
            'logs'   => $logs,
            'pager'  => $model->pager,
            'filter' => ['status' => $status, 'email' => $email, 'from' => $from, 'to' => $to],
        ]);
    }
}