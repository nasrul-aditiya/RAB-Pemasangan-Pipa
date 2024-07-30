<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisPekerjaanModel extends Model
{
    protected $table = 'jenis_pekerjaan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_jenis'];
}
