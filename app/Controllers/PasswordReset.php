<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class PasswordReset extends Controller
{
    private int $expiryMinutes = 60;

    public function forgotForm()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/forgot_password');
    }

    public function sendLink()
    {
        $email = trim((string) $this->request->getPost('email'));

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->to(base_url('forgot-password'))
                ->withInput()
                ->with('error', 'Please enter a valid email address.');
        }

        $devLink = null;
        $debug   = null; // TEMPORARY: remove after email works

        try {
            $db   = \Config\Database::connect();
            $user = $db->table('users')->where('email', $email)->get()->getRow();

            if ($user) {
                // Remove older tokens for this email
                $db->table('password_resets')->where('email', $user->email)->delete();

                $token = bin2hex(random_bytes(32));
                $db->table('password_resets')->insert([
                    'email'      => $user->email,
                    'token_hash' => hash('sha256', $token),
                    'expires_at' => date('Y-m-d H:i:s', time() + $this->expiryMinutes * 60),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                $link = base_url('reset-password/' . $token);

                $html = view('auth/reset_email', [
                    'link'    => $link,
                    'minutes' => $this->expiryMinutes,
                ]);

                if (! $this->sendMail($user->email, 'Reset your Little Doctors password', $html, $debug)) {
                    log_message('error', 'Password reset email failed: ' . $debug);

                    // Show the link only when running on your own computer
                    $ip = $this->request->getIPAddress();
                    if (in_array($ip, ['127.0.0.1', '::1'], true)) {
                        $devLink = $link;
                    }
                }
            } else {
                $debug = 'No user found with this email in the users table.'; // TEMPORARY
            }
        } catch (\Throwable $e) {
            $debug = 'Exception: ' . $e->getMessage(); // TEMPORARY
            log_message('error', 'Forgot password error: ' . $e->getMessage());
        }

        // Same message whether or not the email exists
        $redirect = redirect()->to(base_url('forgot-password'))
            ->with('success', 'If that email is registered, a reset link has been sent. Please check your inbox.');

        if ($devLink) {
            $redirect->with('dev_link', $devLink);
        }

        if ($debug) { // TEMPORARY
            $redirect->with('debug', $debug);
        }

        return $redirect;
    }

    public function resetForm(string $token)
    {
        if (! $this->findValidToken($token)) {
            return redirect()->to(base_url('forgot-password'))
                ->with('error', 'This reset link is invalid or has expired. Please request a new one.');
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
                ->with('error', 'This reset link is invalid or has expired. Please request a new one.');
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

    /**
     * Send an email through the Brevo API (HTTPS).
     * Needs BREVO_API_KEY and BREVO_SENDER (a sender verified in Brevo).
     */
    private function sendMail(string $to, string $subject, string $html, ?string &$error = null): bool
    {
        $apiKey = env('BREVO_API_KEY');
        $sender = env('BREVO_SENDER');

        if (! $apiKey || ! $sender) {
            $error = 'BREVO_API_KEY / BREVO_SENDER are not set on this server.';
            return false;
        }

        try {
            $response = \Config\Services::curlrequest()->post('https://api.brevo.com/v3/smtp/email', [
                'headers' => [
                    'api-key'      => $apiKey,
                    'accept'       => 'application/json',
                    'content-type' => 'application/json',
                ],
                'json' => [
                    'sender'      => ['name' => 'Little Doctors', 'email' => $sender],
                    'to'          => [['email' => $to]],
                    'subject'     => $subject,
                    'htmlContent' => $html,
                ],
                'http_errors' => false,
                'timeout'     => 20,
            ]);

            $code = $response->getStatusCode();
            if ($code >= 200 && $code < 300) {
                return true;
            }

            $error = 'Brevo HTTP ' . $code . ': ' . $response->getBody();
            return false;
        } catch (\Throwable $e) {
            $error = 'Mail exception: ' . $e->getMessage();
            return false;
        }
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