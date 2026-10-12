<?php

namespace App\Models;

use CodeIgniter\Model;

class TestimonialModel extends Model
{
    protected $table         = 'testimonials';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'name',
        'designation',
        'message',
        'rating',
        'photo',
        'sort_order',
        'is_active',
        'isActive',
        'addedBy',
        'addedDate',
        'updatedBy',
        'updatedDate',
        'created_at',
        'updated_at',
    ];

    /**
     * Get active testimonials.
     */
    public function active(): array
    {
        $fields = $this->db->getFieldNames($this->table);

        if (in_array('isActive', $fields, true)) {
            $activeColumn = 'isActive';
        } elseif (in_array('is_active', $fields, true)) {
            $activeColumn = 'is_active';
        } else {
            return [];
        }

        return $this->where($activeColumn, 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();
    }
}