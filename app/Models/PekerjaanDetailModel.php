<?php

namespace App\Models;

use CodeIgniter\Model;

class PekerjaanDetailModel extends Model
{
    protected $table = 'pekerjaan_detail';
    protected $primaryKey = 'id';

    protected $allowedFields = ['pekerjaan_id', 'item_id', 'volume', 'koefisien'];

    public function getPekerjaanDetails($pekerjaanId)
    {
        return $this->select('pekerjaan_detail.*, item.nama AS item_name, item.jenis, satuan.nama_satuan, item.harga')
            ->join('item', 'pekerjaan_detail.item_id = item.id')
            ->join('satuan', 'item.satuan = satuan.id')
            ->where('pekerjaan_detail.pekerjaan_id', $pekerjaanId)
            ->findAll();
    }
}
