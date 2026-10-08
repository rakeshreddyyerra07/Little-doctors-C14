<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class PasswordReset extends Controller
{
    private int $expiryMinutes = 15;

    public function forgotForm()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/forgot_password');
    }

    /**
     * Verify registered email + name, then go straight to the reset page.
     */
    public function sendLink()
    {
        $email = trim((string) $this->request->getPost('email'));
        $name  = trim((string) $this->request->getPost('name'));

        if ($email === '' || $name === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->to(base_url('forgot-password'))
                ->withInput()
                ->with('error', 'Please enter your registered email and name.');
        }

        // Simple throttle: 5 attempts per 15 minutes per browser session
        $attempts = (int) session()->get('reset_attempts');
        $since    = (int) session()->get('reset_attempts_since');
        if ($since < time() - 900) {
            $attempts = 0;
            $since    = time();
        }
        if ($attempts >= 5) {
            return redirect()->to(base_url('forgot-password'))
                ->with('error', 'Too many attempts. Please wait 15 minutes and try again.');
        }
        session()->set(['reset_attempts' => $attempts + 1, 'reset_attempts_since' => $since]);

        try {
            $db   = \Config\Database::connect();
            $user = $db->table('users')->where('email', $email)->get()->getRow();

            if ($user && strcasecmp(trim((string) $user->name), $name) === 0) {
                // Remove older tokens for this email
                $db->table('password_resets')->where('email', $user->email)->delete();

                $token = bin2hex(random_bytes(32));
                $db->table('password_resets')->insert([
                    'email'      => $user->email,
                    'token_hash' => hash('sha256', $token),
                    'expires_at' => date('Y-m-d H:i:s', time() + $this->expiryMinutes * 60),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                return redirect()->to(base_url('reset-password/' . $token));
            }
        } catch (\Throwable $e) {
            log_message('error', 'Forgot password error: ' . $e->getMessage());
        }

        // Same message whether the email or the name was wrong
        return redirect()->to(base_url('forgot-password'))
            ->withInput()
            ->with('error', 'We could not match that email and name. Please check and try again.');
    }

    public function resetForm(string $token)
    {
        if (! $this->findValidToken($token)) {
            return redirect()->to(base_url('forgot-password'))
                ->with('error', 'This reset link is invalid or has expired. Please try again.');
        }
        return view('auth/reset_password', ['token' => $token]);
    }

    public function updatePassword()
    {
        $token           = (string) $this->request->getPost('token');
        $password        = (string) $this->request->getPost('password');
        $confirmPassword = (string) $this->request->getPost('confirm_password');

        $row = $this->findValidToken($token);
        if (! $row) {
            return redirect()->to(base_url('forgot-password'))
                ->with('error', 'This reset link is invalid or has expired. Please try again.');
        }

        if ($password === '' || $confirmPassword === '') {
            return redirect()->to(base_url('reset-password/' . $token))
                ->with('error', 'Please fill in both password fields.');
        }

        if ($password !== $confirmPassword) {
            return redirect()->to(base_url('reset-password/' . $token))
                ->with('error', 'Passwords do not match.');
        }

        // Same rule as registration
        $strongPassword =
            strlen($password) >= 8 &&
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[a-z]/', $password) &&
            preg_match('/[0-9]/', $password) &&
            preg_match('/[^A-Za-z0-9]/', $password);

        if (! $strongPassword) {
            return redirect()->to(base_url('reset-password/' . $token))
                ->with('error', 'Password must be at least 8 characters and include an uppercase letter, a lowercase letter, a number and a special character.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('users')->where('email', $row->email)->update([
                'password'   => password_hash($password, PASSWORD_DEFAULT),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $db->table('password_resets')->where('email', $row->email)->delete();
        } catch (\Throwable $e) {
            log_message('error', 'Reset password error: ' . $e->getMessage());
            return redirect()->to(base_url('reset-password/' . $token))
                ->with('error', 'Could not update your password. Please try again.');
        }

        return redirect()->to(base_url('login'))
            ->with('success', 'Password updated! Please log in with your new password.');
    }

    private function findValidToken(string $token)
    {
        if ($token === '') {
            return null;
        }
        return \Config\Database::connect()
            ->table('password_resets')
            ->where('token_hash', hash('sha256', $token))
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->get()->getRow();
    }
}