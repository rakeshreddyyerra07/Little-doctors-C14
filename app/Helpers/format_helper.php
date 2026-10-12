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