<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends Controller
{
    /**
     * SAVE LOGIN LOG
     */
    private function saveLoginLog(
        string $email,
        string $status,
        ?string $latlang = null
    ): void {
        log_message(
            'error',
            'LOGIN LOG: saveLoginLog called. Status=' . $status
        );

        try {
            $db = \Config\Database::connect();

            $data = [
                'emailaddress'        => $email,
                'ipaddress'           => $this->request->getIPAddress(),
                'latlang'             => $latlang ?: null,
                'location'            => null,
                'last_attempted_time' => date('Y-m-d H:i:s'),
                'status'              => $status,
                'addedDate'           => date('Y-m-d H:i:s')
            ];

            $result = $db->table('login_logs')->insert($data);

            if (!$result) {
                log_message(
                    'error',
                    'LOGIN LOG INSERT FAILED: ' .
                    json_encode($db->error())
                );

                return;
            }

            log_message(
                'error',
                'LOGIN LOG INSERT SUCCESS. Insert ID=' .
                $db->insertID()
            );

        } catch (\Throwable $e) {
            log_message(
                'error',
                'LOGIN LOG EXCEPTION: ' . $e->getMessage()
            );
        }
    }

    /**
     * LOGIN
     */
    public function login()
    {
        // Redirect already logged-in users based on role.
        if (session()->get('logged_in')) {
            if (session()->get('role') === 'admin') {
                return redirect()->to(base_url('admin/dashboard'));
            }

            return redirect()->to(base_url('dashboard'));
        }

        // Display login form.
        if (strtolower($this->request->getMethod()) !== 'post') {
            return view('auth/login');
        }

        // Get form values.
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        // Get latitude and longitude, if submitted.
        $latlang = $this->request->getPost('latlang');

        if (!is_string($latlang) || trim($latlang) === '') {
            $latlang = null;
        } else {
            $latlang = trim($latlang);
        }

        // Validate login form.
        $rules = [
            'email' => [
                'rules' => 'required|valid_email|max_length[254]',
                'errors' => [
                    'required' =>
                        'Please enter your email address.',
                    'valid_email' =>
                        'Please enter a valid email address.',
                    'max_length' =>
                        'Email cannot exceed 254 characters.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' =>
                        'Please enter your password.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return view('auth/login', [
                'validation' => $this->validator,
                'email'      => $email
            ]);
        }

        try {
            // Connect to the configured database.
            $db = \Config\Database::connect();

            // Find user by email.
            $user = $db->table('users')
                ->where('email', $email)
                ->get()
                ->getRow();

            // Log unsuccessful login if user does not exist.
            if (!$user) {
                $this->saveLoginLog(
                    $email,
                    'Failed',
                    $latlang
                );

                return view('auth/login', [
                    'error' => 'Invalid email or password.',
                    'email' => $email
                ]);
            }

            // Verify password.
            if (!password_verify($password, $user->password)) {
                $this->saveLoginLog(
                    $email,
                    'Failed',
                    $latlang
                );

                return view('auth/login', [
                    'error' => 'Invalid email or password.',
                    'email' => $email
                ]);
            }

            // Record successful login.
            $this->saveLoginLog(
                $email,
                'Success',
                $latlang
            );

            // Regenerate session ID after successful authentication.
            session()->regenerate();

            // Preserve existing session variables and add role.
            session()->set([
                'user_id'    => $user->id,
                'user_name'  => $user->name,
                'user_email' => $user->email,
                'role'       => $user->role ?? 'user',
                'logged_in'  => true
            ]);

            // Preserve existing user_sessions functionality.
            $db->table('user_sessions')->insert([
                'user_id'    => $user->id,
                'user_name'  => $user->name,
                'user_email' => $user->email,
                'logged_in'  => 1
            ]);

            // Redirect based on user role.
            if (($user->role ?? 'user') === 'admin') {
                return redirect()->to(base_url('admin/dashboard'));
            }

            return redirect()->to(base_url('dashboard'));

        } catch (\Throwable $e) {
            log_message(
                'error',
                'Login failed: ' . $e->getMessage()
            );

            return view('auth/login', [
                'error' => 'Unable to login. Please try again.',
                'email' => $email
            ]);
        }
    }

    /**
     * LOGOUT
     */
    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('login'));
    }

    /**
     * REGISTER
     */
    public function register()
    {
        // Redirect already logged-in users based on role.
        if (session()->get('logged_in')) {
            if (session()->get('role') === 'admin') {
                return redirect()->to(base_url('admin/dashboard'));
            }

            return redirect()->to(base_url('dashboard'));
        }

        $method = strtolower($this->request->getMethod());

        // Display registration form.
        if ($method !== 'post') {
            return view('auth/register');
        }

        // Get registration form values.
        $name = trim((string) $this->request->getPost('name'));
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        $confirmPassword = (string) $this->request->getPost(
            'confirm_password'
        );

        $terms = $this->request->getPost('terms');

        // Validate registration form.
        $rules = [
            'name' => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' =>
                        'Please enter your name.',
                    'min_length' =>
                        'Name must contain at least 2 characters.',
                    'max_length' =>
                        'Name cannot exceed 100 characters.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|max_length[254]',
                'errors' => [
                    'required' =>
                        'Please enter your email address.',
                    'valid_email' =>
                        'Please enter a valid email address.',
                    'max_length' =>
                        'Email cannot exceed 254 characters.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' =>
                        'Please create a password.',
                    'min_length' =>
                        'Password must be at least 8 characters.'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' =>
                        'Please confirm your password.',
                    'matches' =>
                        'Passwords do not match.'
                ]
            ],
            'terms' => [
                'rules' => 'required|in_list[1]',
                'errors' => [
                    'required' =>
                        'Please accept the Terms & Conditions.',
                    'in_list' =>
                        'Please accept the Terms & Conditions.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return view('auth/register', [
                'validation' => $this->validator,
                'name'       => $name,
                'email'      => $email
            ]);
        }

        // Preserve strong-password validation.
        $strongPassword =
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[a-z]/', $password) &&
            preg_match('/[0-9]/', $password) &&
            preg_match('/[^A-Za-z0-9]/', $password);

        if (!$strongPassword) {
            return view('auth/register', [
                'error' =>
                    'Password must contain an uppercase letter, ' .
                    'a lowercase letter, a number, and a special character.',
                'name'  => $name,
                'email' => $email
            ]);
        }

        try {
            $db = \Config\Database::connect();

            // Check for an existing account.
            $existingUser = $db->table('users')
                ->where('email', $email)
                ->get()
                ->getRow();

            if ($existingUser) {
                return view('auth/register', [
                    'error' =>
                        'An account with this email already exists.',
                    'name'  => $name,
                    'email' => $email
                ]);
            }

            // Hash password before storing it.
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Insert new user as a normal user.
            // Public registration must never grant admin privileges.
            $inserted = $db->table('users')->insert([
                'name'       => $name,
                'email'      => $email,
                'password'   => $hashedPassword,
                'role'       => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if (!$inserted) {
                return view('auth/register', [
                    'error' =>
                        'Registration failed. Please try again.',
                    'name'  => $name,
                    'email' => $email
                ]);
            }

        } catch (\Throwable $e) {
            log_message(
                'error',
                'Registration failed: ' . $e->getMessage()
            );

            return view('auth/register', [
                'error' =>
                    'Registration failed. Please try again.',
                'name'  => $name,
                'email' => $email
            ]);
        }

        return view('auth/register_success');
    }
}
