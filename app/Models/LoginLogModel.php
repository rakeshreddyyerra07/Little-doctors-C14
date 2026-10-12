<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginLogModel extends Model
{
    protected $table         = 'login_logs';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'emailaddress', 'ipaddress', 'latlang', 'location',
        'last_attempted_time', 'status', 'addedDate',
    ];
}