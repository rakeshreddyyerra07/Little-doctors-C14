<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Enrollment extends Controller
{
    /**
     * Camps shown in the form (same camps as the homepage)
     */
    private array $camps = [
        'summer-camp'    => 'Little Doctors Camp - Summer Camp (Boston, MA)',
        'heart-workshop' => 'Heart & Health Workshop - Weekend Workshop (New York, NY)',
        'body-explorer'  => 'Human Body Explorer Camp - Science Camp (Chicago, IL)',
    ];

    /**
     * SHOW FORM  (GET /enroll)
     */
    public function index()
    {
        return view('enroll', [
            'camps'    => $this->camps,
            'userName' => session()->get('user_name'),
        ]);
    }

    /**
     * SAVE FORM  (POST /enroll)
     */
    public function save()
    {
        $rules = [
            'child_name'   => 'required|min_length[2]|max_length[120]',
            'child_age'    => 'required|integer|greater_than_equal_to[5]|less_than_equal_to[18]',
            'camp'         => 'required|in_list[' . implode(',', array_keys($this->camps)) . ']',
            'parent_phone' => 'required|min_length[7]|max_length[20]',
            'notes'        => 'permit_empty|max_length[500]',
        ];

        $messages = [
            'child_name'   => ['required' => "Please enter the child's name."],
            'child_age'    => [
                'required'                 => "Please enter the child's age.",
                'greater_than_equal_to'    => 'Age must be 5 or above.',
                'less_than_equal_to'       => 'Age must be 18 or below.',
            ],
            'camp'         => [
                'required' => 'Please choose a camp.',
                'in_list'  => 'Please choose a camp from the list.',
            ],
            'parent_phone' => [
                'required'   => 'Please enter a phone number.',
                'min_length' => 'Please enter a valid phone number.',
                'max_length' => 'Please enter a valid phone number.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Phone: digits, spaces, + - ( ) only
        $phone = trim((string) $this->request->getPost('parent_phone'));

        if (! preg_match('/^[0-9+\-\s()]+$/', $phone)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['parent_phone' => 'Please enter a valid phone number.']);
        }

        try {
            $db = \Config\Database::connect();

            $db->table('enrollments')->insert([
                'user_id'      => session()->get('user_id'),
                'child_name'   => trim((string) $this->request->getPost('child_name')),
                'child_age'    => (int) $this->request->getPost('child_age'),
                'camp'         => $this->camps[(string) $this->request->getPost('camp')],
                'parent_phone' => trim((string) $this->request->getPost('parent_phone')),
                'notes'        => trim((string) $this->request->getPost('notes')),
                'created_at'   => date('Y-m-d H:i:s'),
            ]);

        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['db' => 'Could not save the enrollment. Please try again.']);
        }

        return redirect()->to(base_url('dashboard'))
            ->with('success', 'Enrollment submitted! We will contact you soon.');
    }
}