<?php

namespace App\Models;

use CodeIgniter\Model;

class RabModel extends Model
{
    protected $table = 'rab_profile';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id_rab', 'nama_pekerjaan', 'lokasi', 'tanggal'];

    public function searchRabs($keyword)
    {
        if ($keyword) {
            return $this->table('rab_profile')
                ->like('nama_pekerjaan', $keyword)
                ->findAll();
        } else {
            return $this->findAll();
        }
    }
    public function getRabs()
    {
        return $this->findAll();
    }

    public function getRab($id)
    {
        return $this->find($id);
    }
    public function getRabDetailsWithTotal($rabId)
    {
        // Construct the query to get detailed RAB information along with total cost
        return $this->select([
            'rab_profile.id',
            'rab_profile.id_rab',
            'rab_profile.nama_pekerjaan',
            'rab_profile.lokasi',
            'pekerjaan.nama AS pekerjaan_name',
            'pekerjaan.jenis AS jenis_pekerjaan',
            'item.nama AS item_name',
            'satuan.nama_satuan',
            'pekerjaan.volume',
            'item.harga',
            'SUM(item.harga * pekerjaan.volume) AS jumlah_biaya' // Calculating total cost
        ])
            ->join('rab_detail', 'rab_profile.id = rab_detail.id_rab')
            ->join('pekerjaan', 'rab_detail.id_pekerjaan = pekerjaan.id')
            ->join('pekerjaan_detail', 'pekerjaan.id = pekerjaan_detail.pekerjaan_id')
            ->join('item', 'pekerjaan_detail.item_id = item.id')
            ->join('satuan', 'item.satuan = satuan.id')
            ->where('rab_detail.id_rab', $rabId)
            ->groupBy([
                'rab_profile.id',
                'rab_profile.id_rab',
                'rab_profile.nama_pekerjaan',
                'rab_profile.lokasi',
                'pekerjaan.nama',
                'pekerjaan.jenis',
                'item.nama',
                'satuan.nama_satuan',
                'pekerjaan.volume',
                'item.harga'
            ])
            ->findAll();
    }
    public function updateRabData($id, $data)
    {
        // Update data pengguna berdasarkan ID
        return $this->update($id, $data);
    }
    public function countRabsThisMonth()
    {
        return $this->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();
    }

    // Fungsi untuk menghitung jumlah material yang dibuat bulan lalu
    public function countRabsLastMonth()
    {
        return $this->where('MONTH(created_at)', date('m', strtotime('-1 month')))
            ->where('YEAR(created_at)', date('Y', strtotime('-1 month')))
            ->countAllResults();
    }
}
