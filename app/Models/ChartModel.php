<?php

namespace App\Models;

use CodeIgniter\Model;

class ChartModel extends Model
{
    protected $table = 'chart';
    protected $primaryKey = 'id';
    protected $allowedFields = ['bulan', 'jumlah'];
}
