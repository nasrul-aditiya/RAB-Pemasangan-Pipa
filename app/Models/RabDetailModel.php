<?php

namespace App\Models;

use CodeIgniter\Model;

class RabDetailModel extends Model
{
    protected $table = 'rab_detail';
    protected $primaryKey = 'id';

    protected $allowedFields = ['rab_id', 'item_id', 'item_type', 'nama', 'harga', 'koefisien', 'volume', 'total_harga'];

    public function searchRabDetails($keyword)
    {
        if ($keyword) {
            return $this->table('rab_detail')
                ->like('nama', $keyword)
                ->findAll();
        } else {
            return $this->findAll();
        }
    }
    public function getRabDetails()
    {
        return $this->findAll();
    }

    public function getRabDetail($id)
    {
        return $this->find($id);
    }
    public function updateRabDetailData($id, $data)
    {
        // Update data pengguna berdasarkan ID
        return $this->update($id, $data);
    }
    public function countRabDetailsThisMonth()
    {
        return $this->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();
    }

    // Fungsi untuk menghitung jumlah material yang dibuat bulan lalu
    public function countRabDetailsLastMonth()
    {
        return $this->where('MONTH(created_at)', date('m', strtotime('-1 month')))
            ->where('YEAR(created_at)', date('Y', strtotime('-1 month')))
            ->countAllResults();
    }
}
