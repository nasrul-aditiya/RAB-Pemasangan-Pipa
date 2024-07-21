<?php

namespace App\Models;

use CodeIgniter\Model;

class PekerjaanDetailModel extends Model
{
    protected $table = 'pekerjaan_detail';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_pekerjaan', 'jenis_item', 'item_id', 'volume'];
}
