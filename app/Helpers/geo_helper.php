<?php

if (! function_exists('ip_location')) {
    /**
     * City, region and country for a public IP (approximate).
     * Returns 'Local network' for private/local addresses, null if the lookup fails.
     */
    function ip_location(?string $ip): ?string
    {
        $ip = trim((string) $ip);

        if ($ip === '' || ! filter_var($ip, FILTER_VALIDATE_IP)) {
            return null;
        }

        $isLocal = $ip === '::1'
            || strpos($ip, '127.') === 0
            || ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);

        if ($isLocal) {
            return 'Local network';
        }

        try {
            $client = \Config\Services::curlrequest(['timeout' => 1.5, 'http_errors' => false]);
            $res    = $client->get('http://ip-api.com/json/' . $ip . '?fields=status,city,regionName,country');
            $d      = json_decode((string) $res->getBody(), true);

            if (($d['status'] ?? '') === 'success') {
                $parts = array_filter([$d['city'] ?? '', $d['regionName'] ?? '', $d['country'] ?? '']);

                return $parts ? implode(', ', $parts) : null;
            }
        } catch (\Throwable $e) {
            log_message('error', 'IP lookup failed: ' . $e->getMessage());
        }

        return null;
    }
}

if (! function_exists('backfill_log_locations')) {
    /**
     * Fills in a missing Location for login log rows, from the row's IP address.
     * Reuses a location already stored for the same IP, and does at most
     * $maxLookups outside lookups per page load (refresh to fill more).
     */
    function backfill_log_locations(array &$rows, int $maxLookups = 6): void
    {
        $db       = \Config\Database::connect();
        $blank    = ['', 'unknown', '-', 'n/a', 'null'];
        $isBlank  = static fn ($v) => $v === null || in_array(strtolower(trim((string) $v)), $blank, true);
        $cache    = [];
        $lookups  = 0;

        foreach ($rows as &$row) {
            if (! $isBlank($row['location'] ?? null) || empty($row['ipaddress'])) {
                continue;
            }

            $ip = $row['ipaddress'];

            if (! array_key_exists($ip, $cache)) {
                $known = $db->table('login_logs')->select('location')
                    ->where('ipaddress', $ip)
                    ->where('location IS NOT NULL', null, false)
                    ->whereNotIn('location', ['', 'Unknown', 'unknown', '-', 'N/A'])
                    ->limit(1)->get()->getRowArray();

                $cache[$ip] = $known['location'] ?? null;

                if ($cache[$ip] === null && $lookups < $maxLookups) {
                    $lookups++;
                    $cache[$ip] = ip_location($ip);
                }
            }

            if (! empty($cache[$ip])) {
                $row['location'] = $cache[$ip];

                if (isset($row['id'])) {
                    $db->table('login_logs')->where('id', $row['id'])->update(['location' => $cache[$ip]]);
                }
            }
        }

        unset($row);
    }
}