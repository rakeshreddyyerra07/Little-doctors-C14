<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class AdminContent extends BaseController
{
    /** What each manageable section looks like. */
    private function resources(): array
    {
        $colorPattern = '/^(#[0-9a-fA-F]{3,8}|var\(--[a-z\-]+\)|[a-zA-Z]{3,20})$/';

        return [

            'camps' => [
                'table'      => 'camps',
                'title'      => 'Camps',
                'single'     => 'Camp',
                'slug_from'  => 'title',
                'upload_dir' => 'uploads/camps',
                'list'       => ['title' => 'Title', 'tag' => 'Tag', 'start_date' => 'Starts', 'location' => 'Location'],
                'fields'     => [
                    ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
                    ['name' => 'tag', 'label' => 'Tag (e.g. SUMMER CAMP)', 'type' => 'text', 'max' => 60],
                    ['name' => 'short_description', 'label' => 'Short description', 'type' => 'textarea', 'max' => 300],
                    ['name' => 'description', 'label' => 'Full description', 'type' => 'textarea'],
                    ['name' => 'image', 'label' => 'Photo', 'type' => 'image'],
                    ['name' => 'age_group', 'label' => 'Age group (e.g. 8 – 14)', 'type' => 'text', 'max' => 50],
                    ['name' => 'duration', 'label' => 'Duration (e.g. 5 days)', 'type' => 'text', 'max' => 50],
                    ['name' => 'start_date', 'label' => 'Start date', 'type' => 'date'],
                    ['name' => 'end_date', 'label' => 'End date', 'type' => 'date'],
                    ['name' => 'location', 'label' => 'Location', 'type' => 'text'],
                    ['name' => 'button_text', 'label' => 'Button text', 'type' => 'text', 'max' => 60, 'hint' => 'Shown on the home page card, e.g. Explore Camp →'],
                    ['name' => 'price', 'label' => 'Price', 'type' => 'number'],
                    ['name' => 'seats', 'label' => 'Seats', 'type' => 'number'],
                    ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'default' => 0, 'hint' => 'Lower numbers appear first'],
                    ['name' => 'is_featured', 'label' => 'Featured', 'type' => 'checkbox', 'default' => 0],
                    ['name' => 'is_active', 'label' => 'Visible on the website', 'type' => 'checkbox', 'default' => 1],
                ],
            ],

            'courses' => [
                'table'      => 'learning_courses',
                'title'      => 'Learning Lab Courses',
                'single'     => 'Course',
                'slug_from'  => 'title',
                'upload_dir' => 'uploads/courses',
                'list'       => ['title' => 'Title', 'short_description' => 'Short description', 'age_group' => 'Age'],
                'fields'     => [
                    ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
                    ['name' => 'short_description', 'label' => 'Short description', 'type' => 'textarea', 'max' => 300],
                    ['name' => 'content', 'label' => 'Full content (shown under "Read more")', 'type' => 'textarea'],
                    ['name' => 'icon', 'label' => 'Icon (emoji)', 'type' => 'text', 'max' => 100, 'hint' => 'Used when no picture is set, e.g. 🧠'],
                    ['name' => 'image', 'label' => 'Picture', 'type' => 'image'],
                    ['name' => 'bg_color', 'label' => 'Icon background colour', 'type' => 'text', 'max' => 40, 'pattern' => $colorPattern, 'hint' => 'e.g. #ffe7ec'],
                    ['name' => 'accent_color', 'label' => 'Link colour', 'type' => 'text', 'max' => 40, 'pattern' => $colorPattern, 'hint' => 'e.g. #e0245e or var(--pink)'],
                    ['name' => 'age_group', 'label' => 'Age group', 'type' => 'text', 'max' => 50],
                    ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'default' => 0, 'hint' => 'Lower numbers appear first'],
                    ['name' => 'is_active', 'label' => 'Visible on the website', 'type' => 'checkbox', 'default' => 1],
                ],
            ],

            'testimonials' => [
                'table'      => 'testimonials',
                'title'      => 'Testimonials',
                'single'     => 'Testimonial',
                'slug_from'  => null,
                'upload_dir' => 'uploads/testimonials',
                'list'       => ['name' => 'Name', 'designation' => 'Role / Age', 'rating' => 'Rating'],
                'fields'     => [
                    ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'max' => 120],
                    ['name' => 'designation', 'label' => 'Role / Age (e.g. Age 10)', 'type' => 'text', 'max' => 120],
                    ['name' => 'message', 'label' => 'Message', 'type' => 'textarea', 'required' => true],
                    ['name' => 'rating', 'label' => 'Rating (1 to 5)', 'type' => 'number', 'default' => 5, 'min' => 1, 'max' => 5],
                    ['name' => 'photo', 'label' => 'Photo', 'type' => 'image'],
                    ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'default' => 0, 'hint' => 'Lower numbers appear first'],
                    ['name' => 'is_active', 'label' => 'Visible on the website', 'type' => 'checkbox', 'default' => 1],
                ],
            ],
                        'slides' => [
                'table'      => 'hero_slides',
                'title'      => 'Home Slides',
                'single'     => 'Slide',
                'slug_from'  => null,
                'upload_dir' => 'uploads/slides',
                'list'       => ['title' => 'Title', 'button_text' => 'Button', 'sort_order' => 'Order'],
                'fields'     => [
                    ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true,
                     'hint' => 'Use | for a new line and {{ }} around the coloured words. Example: Big knowledge | for {{little doctors.}}'],
                    ['name' => 'subtitle', 'label' => 'Small heading above the title (optional)', 'type' => 'text'],
                    ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
                    ['name' => 'image', 'label' => 'Slide picture', 'type' => 'image'],
                    ['name' => 'button_text', 'label' => 'Button 1 text', 'type' => 'text', 'max' => 60],
                    ['name' => 'button_link', 'label' => 'Button 1 link', 'type' => 'text',
                     'pattern' => '/^(#[A-Za-z0-9_\-]*|https?:\/\/[^\s"<>]+|[A-Za-z0-9_\-\/\.]+)$/',
                     'pattern_msg' => 'must look like #lab, camps, or https://example.com',
                     'hint' => 'e.g. #lab, camps, contact or https://...'],
                    ['name' => 'button2_text', 'label' => 'Button 2 text', 'type' => 'text', 'max' => 60],
                    ['name' => 'button2_link', 'label' => 'Button 2 link', 'type' => 'text',
                     'pattern' => '/^(#[A-Za-z0-9_\-]*|https?:\/\/[^\s"<>]+|[A-Za-z0-9_\-\/\.]+)$/',
                     'pattern_msg' => 'must look like #camps, enroll, or https://example.com'],
                    ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'default' => 0, 'hint' => 'Lower numbers appear first'],
                    ['name' => 'is_active', 'label' => 'Visible on the website', 'type' => 'checkbox', 'default' => 1],
                ],
            ],
        ];
    }

    private function cfg($res): array
    {
        $all = $this->resources();

        if (! isset($all[$res])) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $all[$res];
    }

    private function activeColumn(array $cols): ?string
    {
        foreach (['is_active', 'isActive'] as $c) {
            if (in_array($c, $cols, true)) {
                return $c;
            }
        }

        return null;
    }

    /** Keep only the fields whose column really exists in the table. */
    private function prepareFields(array $cfg, array $cols): array
    {
        $out = [];

        foreach ($cfg['fields'] as $f) {
            $col = $f['name'] === 'is_active' ? $this->activeColumn($cols) : $f['name'];

            if ($col === null || ! in_array($col, $cols, true)) {
                continue;
            }

            $f['col'] = $col;
            $out[]    = $f;
        }

        return $out;
    }

    // ---------------------------------------------------------------- list

    public function index($res)
    {
        $cfg    = $this->cfg($res);
        $db     = \Config\Database::connect();
        $cols   = $db->getFieldNames($cfg['table']);
        $fields = $this->prepareFields($cfg, $cols);

        $builder = $db->table($cfg['table']);
        if (in_array('sort_order', $cols, true)) {
            $builder->orderBy('sort_order', 'ASC');
        }
        $rows = $builder->orderBy('id', 'ASC')->get()->getResultArray();

        $imageField = null;
        foreach ($fields as $f) {
            if ($f['type'] === 'image') {
                $imageField = $f['col'];
                break;
            }
        }

        $listCols = array_filter(
            $cfg['list'],
            static fn ($k) => in_array($k, $cols, true),
            ARRAY_FILTER_USE_KEY
        );

        return view('admin/content_list', [
            'res'        => $res,
            'cfg'        => $cfg,
            'rows'       => $rows,
            'listCols'   => $listCols,
            'imageField' => $imageField,
            'activeCol'  => $this->activeColumn($cols),
        ]);
    }

    // ---------------------------------------------------------------- form

    public function form($res, $id = null)
    {
        $cfg    = $this->cfg($res);
        $db     = \Config\Database::connect();
        $cols   = $db->getFieldNames($cfg['table']);
        $fields = $this->prepareFields($cfg, $cols);
        $row    = [];
        $id     = $id ? (int) $id : 0;

        if ($id) {
            $row = $db->table($cfg['table'])->where('id', $id)->get()->getRowArray();

            if (! $row) {
                return redirect()->to('admin/content/' . $res)->with('errors', ['That record was not found.']);
            }
        }

        return view('admin/content_form', [
            'res'    => $res,
            'cfg'    => $cfg,
            'fields' => $fields,
            'row'    => $row ?: [],
            'id'     => $id,
        ]);
    }

    // ---------------------------------------------------------------- save

    public function save($res)
    {
        helper('url');

        $cfg      = $this->cfg($res);
        $db       = \Config\Database::connect();
        $table    = $cfg['table'];
        $cols     = $db->getFieldNames($table);
        $fields   = $this->prepareFields($cfg, $cols);
        $id       = (int) $this->request->getPost('id');
        $existing = null;

        if ($id) {
            $existing = $db->table($table)->where('id', $id)->get()->getRowArray();

            if (! $existing) {
                return redirect()->to('admin/content/' . $res)->with('errors', ['That record no longer exists.']);
            }
        }

        $data   = [];
        $errors = [];

        foreach ($fields as $f) {
            $name = $f['name'];
            $col  = $f['col'];
            $type = $f['type'];

            if ($type === 'checkbox') {
                $value = ($this->request->getPost($name) === '1') ? 1 : 0;

            } elseif ($type === 'image') {
                $value = $this->handleImage($f, $cfg, $existing[$col] ?? null, $errors);

            } else {
                $raw = trim((string) $this->request->getPost($name));

                if ($raw === '') {
                    $value = array_key_exists('default', $f) ? $f['default'] : null;

                } elseif ($type === 'number') {
                    if (! is_numeric($raw)) {
                        $errors[] = $f['label'] . ' must be a number.';
                        continue;
                    }
                    if ((isset($f['min']) && $raw < $f['min']) || (isset($f['max']) && $raw > $f['max'])) {
                        $errors[] = $f['label'] . ' must be between ' . ($f['min'] ?? '') . ' and ' . ($f['max'] ?? '') . '.';
                        continue;
                    }
                    $value = $raw + 0;

                } elseif ($type === 'date') {
                    if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $raw) || ! strtotime($raw)) {
                        $errors[] = $f['label'] . ' is not a valid date.';
                        continue;
                    }
                    $value = $raw;

                } else {
                    $limit = $f['max'] ?? ($type === 'text' ? 255 : null);
                    $value = $limit ? mb_substr($raw, 0, $limit) : $raw;

                    if (isset($f['pattern']) && ! preg_match($f['pattern'], $value)) {
                        $errors[] = $f['label'] . ' is not a valid colour.';
                        continue;
                    }
                }
            }

            if (! empty($f['required']) && ($value === null || $value === '')) {
                $errors[] = $f['label'] . ' is required.';
            }

            $data[$col] = $value;
        }

        if ($errors) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // slug: created once, kept stable when editing
        if (! $existing && in_array('slug', $cols, true)) {
            $base = url_title((string) ($data[$cfg['slug_from']] ?? ''), '-', true) ?: 'item';
            $slug = $base;
            $n    = 2;

            while ($db->table($table)->where('slug', $slug)->countAllResults() > 0) {
                $slug = $base . '-' . $n++;
            }

            $data['slug'] = $slug;
        }

        // timestamps / audit columns, only if the table has them
        $now = date('Y-m-d H:i:s');
        $uid = session()->get('user_id') ?? session()->get('id') ?? 0;

        $stamps = $existing
            ? ['updated_at' => $now, 'updatedDate' => $now, 'updatedBy' => $uid]
            : ['created_at' => $now, 'addedDate' => $now, 'addedBy' => $uid];

        foreach ($stamps as $c => $v) {
            if (in_array($c, $cols, true)) {
                $data[$c] = $v;
            }
        }

        if (isset($data['is_active']) && in_array('isActive', $cols, true)) {
            $data['isActive'] = $data['is_active'];
        }

        try {
            $ok = $existing
                ? $db->table($table)->where('id', $id)->update($data)
                : $db->table($table)->insert($data);
        } catch (\Throwable $e) {
            log_message('error', 'Admin save failed: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('errors', ['Could not save: ' . $e->getMessage()]);
        }

        if (! $ok) {
            return redirect()->back()->withInput()->with('errors', ['Could not save. Please try again.']);
        }

        return redirect()->to('admin/content/' . $res)
            ->with('success', $cfg['single'] . ($existing ? ' updated.' : ' created.'));
    }

    // -------------------------------------------------------------- delete

    public function delete($res, $id)
    {
        $cfg   = $this->cfg($res);
        $db    = \Config\Database::connect();
        $table = $cfg['table'];
        $id    = (int) $id;
        $row   = $db->table($table)->where('id', $id)->get()->getRowArray();

        if (! $row) {
            return redirect()->to('admin/content/' . $res)->with('errors', ['That record was not found.']);
        }

        foreach ($cfg['fields'] as $f) {
            if ($f['type'] === 'image') {
                $this->deleteUpload($row[$f['name']] ?? null);
            }
        }

        $db->table($table)->where('id', $id)->delete();

        return redirect()->to('admin/content/' . $res)->with('success', $cfg['single'] . ' deleted.');
    }

    // -------------------------------------------------------------- toggle

    public function toggle($res, $id)
    {
        $cfg   = $this->cfg($res);
        $db    = \Config\Database::connect();
        $table = $cfg['table'];
        $cols  = $db->getFieldNames($table);
        $col   = $this->activeColumn($cols);
        $id    = (int) $id;

        if ($col) {
            $row = $db->table($table)->where('id', $id)->get()->getRowArray();

            if ($row) {
                $new  = ((int) $row[$col]) ? 0 : 1;
                $data = [$col => $new];

                if ($col === 'is_active' && in_array('isActive', $cols, true)) {
                    $data['isActive'] = $new;
                }

                $db->table($table)->where('id', $id)->update($data);
            }
        }

        return redirect()->to('admin/content/' . $res);
    }

    // -------------------------------------------------------------- images

    private function handleImage(array $f, array $cfg, $current, array &$errors)
    {
        $name = $f['name'];
        $file = $this->request->getFile($name . '_file');

        // 1) a file was uploaded
        if ($file && $file->isValid() && ! $file->hasMoved() && $file->getSize() > 0) {
            $ext = strtolower($file->getExtension());

            if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)
                || strpos((string) $file->getMimeType(), 'image/') !== 0) {
                $errors[] = $f['label'] . ': only JPG, PNG, WEBP or GIF images are allowed.';

                return $current;
            }

            if ($file->getSize() > 2 * 1024 * 1024) {
                $errors[] = $f['label'] . ' must be smaller than 2 MB.';

                return $current;
            }

            $dir = FCPATH . $cfg['upload_dir'];

            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $newName = $file->getRandomName();
            $file->move($dir, $newName);

            $this->deleteUpload($current);

            return $cfg['upload_dir'] . '/' . $newName;
        }

        // 2) a path was typed (or the box was cleared)
        $typed = trim((string) $this->request->getPost($name));

        if ($typed === '') {
            $this->deleteUpload($current);

            return null;
        }

        if (strpos($typed, '..') !== false || ! preg_match('#^[A-Za-z0-9_\-./]+$#', $typed)) {
            $errors[] = $f['label'] . ': the path contains characters that are not allowed.';

            return $current;
        }

        return ltrim($typed, '/');
    }

    /** Only deletes files this admin screen uploaded (inside /uploads/). */
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