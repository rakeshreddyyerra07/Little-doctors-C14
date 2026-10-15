<?php

namespace App\Controllers;

use App\Models\SettingModel;

class AdminSettings extends BaseController
{
    public function index()
    {
        $rows    = (new SettingModel())->orderBy('setting_group')->orderBy('id')->findAll();
        $grouped = [];

        foreach ($rows as $r) {
            $grouped[$r['setting_group']][] = $r;
        }

        return view('admin/settings', ['grouped' => $grouped]);
    }

    public function save()
    {
        $model  = new SettingModel();
        $post   = $this->request->getPost('settings') ?? [];
        $keys   = array_column($model->select('setting_key')->findAll(), 'setting_key');
        $errors = [];

        foreach ($post as $key => $value) {
            if (! in_array($key, $keys, true)) {
                continue;
            }

            $value = trim((string) $value);

            if ($value !== '' && $key === 'contact_email' && ! filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Contact email is not valid.';
                continue;
            }

            if ($value !== '' && in_array($key, ['facebook', 'instagram', 'youtube', 'twitter', 'linkedin', 'map_embed_url'], true)
                && ! filter_var($value, FILTER_VALIDATE_URL)) {
                $errors[] = ucfirst($key) . ' must be a full URL starting with https://';
                continue;
            }

            $model->where('setting_key', $key)
                  ->set(['setting_value' => $value, 'updated_at' => date('Y-m-d H:i:s')])
                  ->update();
        }

        $redirect = redirect()->to('/admin/settings');

        return $errors
            ? $redirect->with('errors', $errors)
            : $redirect->with('success', 'Settings saved.');
    }
}