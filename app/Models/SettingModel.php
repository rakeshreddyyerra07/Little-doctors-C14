<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table         = 'settings';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'setting_key',
        'setting_value',
    ];

    /**
     * Fetch all settings in one database query.
     * Returns an easy-to-use key => value array.
     */
    public function getAllSettings(): array
    {
        $rows = $this->select('setting_key, setting_value')
                     ->findAll();

        $settings = [];

        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        return $settings;
    }
}
