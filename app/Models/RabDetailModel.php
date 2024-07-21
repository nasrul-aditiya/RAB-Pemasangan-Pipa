<?php

namespace App\Models;

use CodeIgniter\Model;

class RabDetailModel extends Model
{
    protected $table = 'rab_detail';
    protected $primaryKey = 'id';

    protected $allowedFields = ['rab_id', 'id_pekerjaan'];
}
