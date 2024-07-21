<?php

namespace App\Models;

use CodeIgniter\Model;

class PekerjaModel extends Model
{
    protected $table = 'pekerja';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama_pekerja', 'harga', 'satuan', 'koefisien'];

    public function searchPekerjas($keyword)
    {
        if ($keyword) {
            return $this->table('pekerja')
                ->like('nama_pekerja', $keyword)
                ->findAll();
        } else {
            return $this->findAll();
        }
    }
    public function getPekerjas()
    {
        return $this->findAll();
    }

    public function getPekerja($id)
    {
        return $this->find($id);
    }
    public function updatePekerjaData($id, $data)
    {
        // Update data pengguna berdasarkan ID
        return $this->update($id, $data);
    }
    public function countPekerjasThisMonth()
    {
        return $this->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();
    }

    // Fungsi untuk menghitung jumlah material yang dibuat bulan lalu
    public function countPekerjasLastMonth()
    {
        return $this->where('MONTH(created_at)', date('m', strtotime('-1 month')))
            ->where('YEAR(created_at)', date('Y', strtotime('-1 month')))
            ->countAllResults();
    }
}
