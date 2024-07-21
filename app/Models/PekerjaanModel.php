<?php

namespace App\Models;

use CodeIgniter\Model;

class PekerjaanModel extends Model
{
    protected $table = 'pekerjaan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_pekerjaan'];
    public function searchPekerjaans($keyword)
    {
        if ($keyword) {
            return $this->table('pekerjaan')
                ->like('nama_pekerjaan', $keyword)
                ->findAll();
        } else {
            return $this->findAll();
        }
    }
    public function getPekerjaans()
    {
        return $this->findAll();
    }

    public function getPekerjaan($id)
    {
        return $this->find($id);
    }
    public function updatePekerjaanData($id, $data)
    {
        // Update data pengguna berdasarkan ID
        return $this->update($id, $data);
    }
    public function countPekerjaansThisMonth()
    {
        return $this->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();
    }

    // Fungsi untuk menghitung jumlah material yang dibuat bulan lalu
    public function countPekerjaansLastMonth()
    {
        return $this->where('MONTH(created_at)', date('m', strtotime('-1 month')))
            ->where('YEAR(created_at)', date('Y', strtotime('-1 month')))
            ->countAllResults();
    }
}
