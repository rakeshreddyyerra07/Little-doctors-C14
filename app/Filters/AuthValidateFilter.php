<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthValidateFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (strtolower($request->getMethod()) !== 'post') {
            return;
        }

        $type = $arguments[0] ?? 'login';

        if ($type === 'register') {
            $rules = [
                'name'             => 'required|min_length[2]|max_length[100]',
                'email'            => 'required|valid_email|max_length[255]|is_unique[users.email]',
                'password'         => 'required|min_length[8]|max_length[72]',
                'confirm_password' => 'required|matches[password]',
            ];
            $messages = [
                'email'            => ['is_unique' => 'This email is already registered.'],
                'confirm_password' => ['matches' => 'Passwords do not match.'],
            ];
        } else {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required',
            ];
            $messages = [];
        }

        $validation = \Config\Services::validation();
        $validation->setRules($rules, $messages);

        if (! $validation->run($request->getPost())) {
            return redirect()->back()
                ->withInput()
                ->with('validation_errors', $validation->getErrors());
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}