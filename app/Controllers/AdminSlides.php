<?php

namespace App\Controllers;

class AdminSlides extends BaseController
{
    private string $table     = 'hero_slides';
    private string $uploadDir = 'uploads/slides';

    public function index()
    {
        $rows = \Config\Database::connect()->table($this->table)
            ->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')
            ->get()->getResultArray();

        return view('admin/slides_list', ['rows' => $rows]);
    }

    public function form($id = null)
    {
        $id  = $id ? (int) $id : 0;
        $row = [];

        if ($id) {
            $row = \Config\Database::connect()->table($this->table)->where('id', $id)->get()->getRowArray();

            if (! $row) {
                return redirect()->to('admin/slides')->with('errors', ['That slide was not found.']);
            }
        }

        return view('admin/slides_form', ['row' => $row ?: [], 'id' => $id]);
    }

    public function save()
    {
        $db  = \Config\Database::connect();
        $id  = (int) $this->request->getPost('id');
        $old = null;

        if ($id) {
            $old = $db->table($this->table)->where('id', $id)->get()->getRowArray();

            if (! $old) {
                return redirect()->to('admin/slides')->with('errors', ['That slide no longer exists.']);
            }
        }

        $errors = [];

        $title = $this->text('title', 200);
        if ($title === null) {
            $errors[] = 'Title is required.';
        }

        $linkPattern = '/^(#[A-Za-z0-9_\-]*|https?:\/\/[^\s"<>]+|[A-Za-z0-9_\-\/\.]+)$/';
        $links       = [];

        foreach (['button_link', 'button2_link'] as $k) {
            $v = $this->text($k, 255);

            if ($v !== null && ! preg_match($linkPattern, $v)) {
                $errors[] = 'The link "' . $v . '" is not valid. Use something like #lab, camps or https://example.com';
            }

            $links[$k] = $v;
        }

        $sort = trim((string) $this->request->getPost('sort_order'));
        if ($sort !== '' && ! is_numeric($sort)) {
            $errors[] = 'Sort order must be a number.';
        }

        $image = $this->handleImage($old['image'] ?? null, $errors);

        if ($errors) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $now  = date('Y-m-d H:i:s');
        $data = [
            'title'        => $title,
            'subtitle'     => $this->text('subtitle', 255),
            'description'  => $this->text('description', 2000),
            'image'        => $image,
            'button_text'  => $this->text('button_text', 60),
            'button_link'  => $links['button_link'],
            'button2_text' => $this->text('button2_text', 60),
            'button2_link' => $links['button2_link'],
            'sort_order'   => $sort === '' ? 0 : (int) $sort,
            'is_active'    => $this->request->getPost('is_active') === '1' ? 1 : 0,
            'updated_at'   => $now,
        ];

        try {
            if ($old) {
                $db->table($this->table)->where('id', $id)->update($data);
            } else {
                $data['created_at'] = $now;
                $db->table($this->table)->insert($data);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Slide save failed: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('errors', ['Could not save: ' . $e->getMessage()]);
        }

        return redirect()->to('admin/slides')->with('success', $old ? 'Slide updated.' : 'Slide created.');
    }

    public function delete($id)
    {
        $db  = \Config\Database::connect();
        $id  = (int) $id;
        $row = $db->table($this->table)->where('id', $id)->get()->getRowArray();

        if ($row) {
            $this->deleteUpload($row['image'] ?? null);
            $db->table($this->table)->where('id', $id)->delete();
        }

        return redirect()->to('admin/slides')->with('success', 'Slide deleted.');
    }

    public function toggle($id)
    {
        $db  = \Config\Database::connect();
        $id  = (int) $id;
        $row = $db->table($this->table)->where('id', $id)->get()->getRowArray();

        if ($row) {
            $db->table($this->table)->where('id', $id)->update(['is_active' => ((int) $row['is_active']) ? 0 : 1]);
        }

        return redirect()->to('admin/slides');
    }

    // ---------------------------------------------------------------- helpers

    private function text(string $key, int $max): ?string
    {
        $v = trim((string) $this->request->getPost($key));

        return $v === '' ? null : mb_substr($v, 0, $max);
    }

    private function handleImage($current, array &$errors)
    {
        $file = $this->request->getFile('image_file');

        if ($file && $file->isValid() && ! $file->hasMoved() && $file->getSize() > 0) {
            $ext = strtolower($file->getExtension());

            if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)
                || strpos((string) $file->getMimeType(), 'image/') !== 0) {
                $errors[] = 'Only JPG, PNG, WEBP or GIF pictures are allowed.';

                return $current;
            }

            if ($file->getSize() > 2 * 1024 * 1024) {
                $errors[] = 'The picture must be smaller than 2 MB.';

                return $current;
            }

            $dir = FCPATH . $this->uploadDir;
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $name = $file->getRandomName();
            $file->move($dir, $name);
            $this->deleteUpload($current);

            return $this->uploadDir . '/' . $name;
        }

        $typed = trim((string) $this->request->getPost('image'));

        if ($typed === '') {
            $this->deleteUpload($current);

            return null;
        }

        if (strpos($typed, '..') !== false || ! preg_match('#^[A-Za-z0-9_\-./]+$#', $typed)) {
            $errors[] = 'The picture path contains characters that are not allowed.';

            return $current;
        }

        return ltrim($typed, '/');
    }

    /** Only removes files uploaded through this screen (inside uploads/). */
    private function deleteUpload($path): void
    {
        if (! $path || strpos($path, 'uploads/') !== 0 || strpos($path, '..') !== false) {
            return;
        }

        $full = FCPATH . $path;

        if (is_file($full)) {
            @unlink($full);
        }
    }
}