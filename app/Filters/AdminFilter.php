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
        $id      = $session->get('user_id');
        $email   = $session->get('email');

        if (! $id && ! $email) {
            return redirect()->to('/login');
        }

        $builder = \Config\Database::connect()->table('users')->select('role');
        $id ? $builder->where('id', $id) : $builder->where('email', $email);
        $user = $builder->get()->getRowArray();

        if (! $user || $user['role'] !== 'admin') {
            return redirect()->to('/dashboard');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}