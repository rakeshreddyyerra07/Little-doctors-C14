<?php

namespace App\Filters;

use App\Models\LoginLogModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LoginLogFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (strtolower($request->getMethod()) !== 'post') {
            return;
        }

        $status   = $response->getStatusCode();
        $location = $response->getHeaderLine('Location');
        $success  = ($status >= 300 && $status < 400 && stripos($location, 'dashboard') !== false);

        $ip  = $request->getIPAddress();
        $now = date('Y-m-d H:i:s');

        try {
            (new LoginLogModel())->insert([
                'emailaddress'        => substr((string) $request->getPost('email'), 0, 255),
                'ipaddress'           => $ip,
                'latlang'             => substr((string) $request->getPost('latlang'), 0, 100) ?: null,
                'location'            => $this->lookupLocation($ip),
                'last_attempted_time' => $now,
                'status'              => $success ? 'success' : 'failed',
                'addedDate'           => $now,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Login log failed: ' . $e->getMessage());
        }
    }

    private function lookupLocation(string $ip): ?string
    {
        if (in_array($ip, ['127.0.0.1', '::1'], true)
            || preg_match('/^(10\.|192\.168\.|172\.(1[6-9]|2\d|3[01])\.)/', $ip)) {
            return null;
        }

        try {
            $client = \Config\Services::curlrequest(['timeout' => 2, 'http_errors' => false]);
            $res    = $client->get('http://ip-api.com/json/' . $ip . '?fields=status,city,regionName,country');
            $d      = json_decode($res->getBody(), true);

            if (($d['status'] ?? '') === 'success') {
                return trim(($d['city'] ?? '') . ', ' . ($d['regionName'] ?? '') . ', ' . ($d['country'] ?? ''), ', ');
            }
        } catch (\Throwable $e) {
            // location stays NULL
        }

        return null;
    }
}