<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends Controller
{
    /**
     * LOGIN
     */
    public function login()
    {
        // Already logged in -> go to dashboard
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        // Show login page
        if (strtolower($this->request->getMethod()) !== 'post') {
            return view('auth/login');
        }

        // Get form values
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        // Check empty fields
        if ($email === '' || $password === '') {
            return view('auth/login', [
                'error' => 'Please enter your email and password.'
            ]);
        }

        try {
            // Connect to database
            $db = \Config\Database::connect();

            // Find user by email
            $user = $db->table('users')
                ->where('email', $email)
                ->get()
                ->getRow();

            // User not found
            if (!$user) {
                return view('auth/login', [
                    'error' => 'Invalid email or password.'
                ]);
            }

            // Check password
            if (!password_verify($password, $user->password)) {
                return view('auth/login', [
                    'error' => 'Invalid email or password.'
                ]);
            }

            // Create login session (new session ID for safety)
            session()->regenerate();

            // Set normal CodeIgniter session variables
            session()->set([
                'user_id'    => $user->id,
                'user_name'  => $user->name,
                'user_email' => $user->email,
                'logged_in'  => true
            ]);

            // -------------------------------------------------
            // SAVE SESSION VARIABLES IN SEPARATE TABLE
            // -------------------------------------------------

            $db->table('user_sessions')->insert([
                'user_id'    => $user->id,
                'user_name'  => $user->name,
                'user_email' => $user->email,
                'logged_in'  => 1,
                'session_id' => session_id()
            ]);

            // Login successful -> go to dashboard
            return redirect()->to(base_url('dashboard'));

        } catch (\Throwable $e) {

            return view('auth/login', [
                'error' => 'Unable to login. Please try again.'
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
        // Already logged in -> go to dashboard
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        // Get request method
        $method = strtolower($this->request->getMethod());

        // -------------------------------------------------
        // GET REQUEST
        // -------------------------------------------------
        // When user opens /register, show registration page.
        if ($method !== 'post') {
            return view('auth/register');
        }


        // -------------------------------------------------
        // GET FORM DATA
        // -------------------------------------------------

        $name = trim((string) $this->request->getPost('name'));

        $email = trim((string) $this->request->getPost('email'));

        $password = (string) $this->request->getPost('password');

        $confirmPassword = (string) $this->request->getPost('confirm_password');

        $terms = $this->request->getPost('terms');


        // -------------------------------------------------
        // REQUIRED FIELDS
        // -------------------------------------------------

        if (
            $name === '' ||
            $email === '' ||
            $password === '' ||
            $confirmPassword === ''
        ) {
            return view('auth/register', [
                'error' => 'Please fill in all required fields.',
                'name'  => $name,
                'email' => $email
            ]);
        }


        // -------------------------------------------------
        // EMAIL VALIDATION
        // -------------------------------------------------

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return view('auth/register', [
                'error' => 'Please enter a valid email address.',
                'name'  => $name,
                'email' => $email
            ]);
        }


        // -------------------------------------------------
        // PASSWORD MATCH
        // -------------------------------------------------

        if ($password !== $confirmPassword) {
            return view('auth/register', [
                'error' => 'Passwords do not match.',
                'name'  => $name,
                'email' => $email
            ]);
        }


        // -------------------------------------------------
        // STRONG PASSWORD VALIDATION
        // -------------------------------------------------

        $strongPassword =
            strlen($password) >= 8 &&
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[a-z]/', $password) &&
            preg_match('/[0-9]/', $password) &&
            preg_match('/[^A-Za-z0-9]/', $password);


        if (!$strongPassword) {
            return view('auth/register', [
                'error' => 'Invalid password. Please enter a valid password.',
                'name'  => $name,
                'email' => $email
            ]);
        }


        // -------------------------------------------------
        // TERMS & CONDITIONS
        // -------------------------------------------------

        if (!$terms) {
            return view('auth/register', [
                'error' => 'Please accept the Terms & Conditions.',
                'name'  => $name,
                'email' => $email
            ]);
        }


        // -------------------------------------------------
        // DATABASE
        // -------------------------------------------------

        try {

            // Connect to Little Doctors database
            $db = \Config\Database::connect();


            // -------------------------------------------------
            // CHECK DUPLICATE EMAIL
            // -------------------------------------------------

            $existingUser = $db->table('users')
                ->where('email', $email)
                ->get()
                ->getRow();


            if ($existingUser) {
                return view('auth/register', [
                    'error' => 'An account with this email already exists.',
                    'name'  => $name,
                    'email' => $email
                ]);
            }


            // -------------------------------------------------
            // HASH PASSWORD
            // -------------------------------------------------

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );


            // -------------------------------------------------
            // INSERT USER
            // -------------------------------------------------

            $inserted = $db->table('users')->insert([
                'name'       => $name,
                'email'      => $email,
                'password'   => $hashedPassword,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);


            // -------------------------------------------------
            // CHECK INSERT
            // -------------------------------------------------

            if (!$inserted) {
                return view('auth/register', [
                    'error' => 'Registration failed. Please try again.',
                    'name'  => $name,
                    'email' => $email
                ]);
            }


        } catch (\Throwable $e) {

            // Database error
            return view('auth/register', [
                'error' => 'Registration failed. Please try again.',
                'name'  => $name,
                'email' => $email
            ]);
        }


        // -------------------------------------------------
        // REGISTRATION SUCCESS
        // -------------------------------------------------
        //
        // IMPORTANT:
        // This is OUTSIDE the database try/catch.
        //
        // The user has already been successfully inserted.
        //

        return view('auth/register_success');
    }
}