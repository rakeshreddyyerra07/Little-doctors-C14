<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        $id    = $session->get('user_id') ?? $session->get('id') ?? $session->get('userId');
        $email = $session->get('email') ?? $session->get('user_email');
        $role  = $session->get('role');

        if (! $id && ! $email && ! $role) {
            return redirect()->to('/login');
        }

        // The role saved in the session at login
        if ($role === 'admin') {
            return;
        }

        // Otherwise confirm with the database
        if ($id || $email) {
            $builder = \Config\Database::connect()->table('users')->select('role');
            $id ? $builder->where('id', $id) : $builder->where('email', $email);
            $user = $builder->get()->getRowArray();

            if ($user && ($user['role'] ?? '') === 'admin') {
                return;
            }
        }

        return redirect()->to('/dashboard');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}