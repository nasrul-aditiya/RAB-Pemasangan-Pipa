<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'material';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama_material', 'harga', 'satuan', 'koefisien'];

    public function getMaterialsWithSatuan()
    {
        // Join material with satuan
        return $this->select('material.id, material.nama_material, satuan.nama_satuan')
            ->join('satuan', 'satuan.id = material.satuan')
            ->findAll();
    }
    public function searchMaterials($keyword)
    {
        if ($keyword) {
            return $this->table('material')
                ->like('nama_material', $keyword)
                ->findAll();
        } else {
            return $this->findAll();
        }
    }
    public function getMaterials()
    {
        return $this->findAll();
    }

    public function getMaterial($id)
    {
        return $this->find($id);
    }
    public function updateMaterialData($id, $data)
    {
        // Update data pengguna berdasarkan ID
        return $this->update($id, $data);
    }
    public function countMaterialsThisMonth()
    {
        return $this->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();
    }

    // Fungsi untuk menghitung jumlah material yang dibuat bulan lalu
    public function countMaterialsLastMonth()
    {
        return $this->where('MONTH(created_at)', date('m', strtotime('-1 month')))
            ->where('YEAR(created_at)', date('Y', strtotime('-1 month')))
            ->countAllResults();
    }
}
