<?php

namespace App\Models;

use CodeIgniter\Model;

class LearningCourseModel extends Model
{
    protected $table         = 'learning_courses';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'title', 'slug', 'short_description', 'content', 'image', 'icon', 'bg_color', 'accent_color',
        'age_group', 'sort_order', 'is_active', 'created_at', 'updated_at',
    ];

    public function active(): array
    {
        return $this->where('is_active', 1)->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll();
    }
}