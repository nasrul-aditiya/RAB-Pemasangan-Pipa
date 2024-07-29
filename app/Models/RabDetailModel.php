<?php

namespace App\Models;

use CodeIgniter\Model;

class RabDetailModel extends Model
{
    protected $table = 'rab_detail';
    protected $primaryKey = 'id';

    protected $allowedFields = ['rab_id', 'id_pekerjaan'];
    public function getDetailsByRabId($id_rab)
    {
        return $this->where('id_rab', $id_rab)->findAll();
    }
    public function getRabDetailsWithTotal($rabId)
    {
        // Construct the query to get detailed RAB information along with total cost
        return $this->select([
            'rab_profile.id',
            'rab_detail.id',
            'rab_profile.id_rab',
            'rab_profile.nama_pekerjaan',
            'rab_profile.lokasi',
            'rab_detail.volume AS volume_rab',
            'pekerjaan.nama AS pekerjaan_name',
            'jenis_pekerjaan.nama_jenis AS jenis_pekerjaan',
            'item.nama AS item_name',
            'satuan.nama_satuan',
            'pekerjaan_detail.koefisien',
            'pekerjaan.volume AS volume_pekerjaan',
            'pekerjaan.profit',
            'item.harga',
            'SUM(item.harga * pekerjaan.volume) AS jumlah_biaya' // Calculating total cost
        ])
            ->join('rab_profile', 'rab_detail.id_rab = rab_profile.id')
            ->join('pekerjaan', 'rab_detail.id_pekerjaan = pekerjaan.id')
            ->join('pekerjaan_detail', 'pekerjaan.id = pekerjaan_detail.pekerjaan_id')
            ->join('jenis_pekerjaan', 'pekerjaan.jenis = jenis_pekerjaan.id')
            ->join('item', 'pekerjaan_detail.item_id = item.id')
            ->join('satuan', 'item.satuan = satuan.id')
            ->where('rab_profile.id', $rabId)
            ->groupBy([
                'rab_profile.id',
                'rab_detail.id',
                'pekerjaan.id',
                'pekerjaan_detail.item_id',

                // 'pekerjaan.jenis',
                // 'pekerjaan.nama',
                // 'item.nama',
            ])
            ->findAll();
    }
}
