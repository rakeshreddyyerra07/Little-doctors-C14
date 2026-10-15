<?php

namespace App\Controllers;

class IpCheck extends BaseController
{
    public function index()
    {
        $keys = ['REMOTE_ADDR', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CF_CONNECTING_IP',
                 'HTTP_TRUE_CLIENT_IP', 'HTTP_FORWARDED', 'HTTP_CLIENT_IP'];

        $out = 'CodeIgniter getIPAddress(): ' . $this->request->getIPAddress() . "\n\n";

        foreach ($keys as $k) {
            $out .= $k . ' = ' . ($_SERVER[$k] ?? '(not sent)') . "\n";
        }

        return $this->response->setContentType('text/plain')->setBody($out);
    }
}