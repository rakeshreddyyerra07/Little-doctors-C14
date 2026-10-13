<?php

if (! function_exists('format_date_range')) {
    function format_date_range(?string $start, ?string $end): string
    {
        if (! $start) {
            return '';
        }

        $s = strtotime($start);

        if (! $end || $end === $start) {
            return date('M j, Y', $s);
        }

        $e = strtotime($end);

        return date('Y', $s) === date('Y', $e)
            ? date('M j', $s) . ' – ' . date('M j, Y', $e)
            : date('M j, Y', $s) . ' – ' . date('M j, Y', $e);
    }
}

if (! function_exists('active_rows')) {
    /**
     * Fetch the active rows of a table, whatever the active column is called
     * (is_active or isActive). Sorts by sort_order if that column exists.
     */
    function active_rows(string $table, ?int $limit = null): array
    {
        $db      = \Config\Database::connect();
        $fields  = $db->getFieldNames($table) ?: [];
        $builder = $db->table($table);

        foreach (['is_active', 'isActive'] as $col) {
            if (in_array($col, $fields, true)) {
                $builder->where($col, 1);
                break;
            }
        }

        if (in_array('sort_order', $fields, true)) {
            $builder->orderBy('sort_order', 'ASC');
        }

        $builder->orderBy('id', 'ASC');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }
}