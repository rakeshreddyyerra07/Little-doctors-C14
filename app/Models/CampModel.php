<?php

namespace App\Models;

use CodeIgniter\Model;

class CampModel extends Model
{
    protected $table         = 'camps';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'title', 'slug', 'tag', 'short_description', 'description', 'image', 'age_group', 'duration',
        'start_date', 'end_date', 'location', 'button_text', 'price', 'seats', 'is_featured', 'sort_order',
        'is_active', 'created_at', 'updated_at',
    ];

    public function active(): array
    {
        return $this->where('is_active', 1)->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll();
    }

    public function byDate(): array
    {
        return $this->where('is_active', 1)->orderBy('start_date', 'ASC')->findAll();
    }
}