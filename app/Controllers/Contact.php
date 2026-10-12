<?php

namespace App\Controllers;

use App\Models\ContactMessageModel;
use App\Models\SettingModel;

class Contact extends BaseController
{
    /**
     * Display Contact Us page with database settings.
     */
    public function index()
    {
        $settings = (new SettingModel())->getAllSettings();

        return view('pages/contact', [
            'active'   => 'contact',
            'title'    => 'Contact Us | Little Doctors',
            'settings' => $settings,
        ]);
    }

    /**
     * Validate and save the contact form.
     */
    public function send()
    {
        // Honeypot spam protection.
        if ($this->request->getPost('website')) {
            return redirect()->to(base_url('contact'));
        }

        // Prevent repeated submissions within 30 seconds.
        $last = session()->get('contact_last');

        if ($last && (time() - $last) < 30) {
            return redirect()->back()
                ->withInput()
                ->with('errors', [
                    'Please wait a few seconds before sending another message.'
                ]);
        }

        // Server-side validation.
        $rules = [
            'name'    => 'required|min_length[2]|max_length[120]',
            'email'   => 'required|valid_email|max_length[255]',
            'phone'   => 'permit_empty|max_length[30]',
            'subject' => 'permit_empty|max_length[200]',
            'message' => 'required|min_length[10]|max_length[3000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'       => trim((string) $this->request->getPost('name')),
            'email'      => trim((string) $this->request->getPost('email')),
            'phone'      => trim((string) $this->request->getPost('phone')) ?: null,
            'subject'    => trim((string) $this->request->getPost('subject')) ?: null,
            'message'    => trim((string) $this->request->getPost('message')),
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Save the message to the database.
        try {
            $model = new ContactMessageModel();
            $saved = $model->insert($data);

            if ($saved === false) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', [
                        'Your message could not be saved. Please try again.'
                    ]);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Contact message save failed: {message}', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('errors', [
                    'Unable to send your message right now. Please try again later.'
                ]);
        }

        // Record the successful submission time.
        session()->set('contact_last', time());

        return redirect()->to(base_url('contact'))
            ->with(
                'success',
                'Thank you! Your message has been sent. We will get back to you soon.'
            );
    }
}
