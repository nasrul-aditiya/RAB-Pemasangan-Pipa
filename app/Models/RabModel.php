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
