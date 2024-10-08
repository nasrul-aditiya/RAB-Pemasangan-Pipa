<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table = 'item';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama', 'jenis', 'kode', 'satuan', 'harga'];

    // Method untuk mencari material berdasarkan keyword
    public function searchMaterials($num, $keyword)
    {
        $this->select('item.id, item.nama AS nama_material, satuan.nama_satuan AS satuan_nama, item.kode, item.harga')
            ->join('satuan', 'item.satuan = satuan.id')
            ->where('item.jenis', 'material')
            ->orderBy('item.id', 'DESC');
        if ($keyword) {
            $this->groupStart()
                ->like('item.nama', $keyword)
                ->orLike('satuan.nama_satuan', $keyword)
                ->orLike('item.harga', $keyword)
                ->groupEnd();
        }
        return [
            'material' => $this->paginate($num),
            'pager' => $this->pager,
        ];
    }

    // Method untuk mendapatkan semua material
    public function getMaterials()
    {
        return $this->select('item.id, item.nama AS nama_material, satuan.nama_satuan AS satuan_nama, item.kode, item.harga')
            ->join('satuan', 'item.satuan = satuan.id')
            ->where('item.jenis', 'material')
            ->orderBy('item.id', 'DESC')
            ->findAll();
    }
    public function countAllMaterials()
    {
        return $this->where('item.jenis', 'material')
            ->countAllResults();
    }
    public function countMaterialsThisMonth()
    {
        return $this->where('MONTH(created_at)', date('m'))
            ->where('item.jenis', 'material')
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();
    }

    // Fungsi untuk menghitung jumlah material yang dibuat bulan lalu
    public function countMaterialsLastMonth()
    {
        return $this->where('MONTH(created_at)', date('m', strtotime('-1 month')))
            ->where('item.jenis', 'material')
            ->where('YEAR(created_at)', date('Y', strtotime('-1 month')))
            ->countAllResults();
    }

    // Method untuk mencari upah berdasarkan keyword
    public function searchUpah($num, $keyword)
    {
        $this->select('item.id, item.nama AS nama_upah, satuan.nama_satuan AS satuan_nama, item.kode, item.harga')
            ->join('satuan', 'item.satuan = satuan.id')
            ->where('item.jenis', 'upah')
            ->orderBy('item.id', 'DESC');
        if ($keyword) {
            $this->groupStart()
                ->like('item.nama', $keyword)
                ->orLike('satuan.nama_satuan', $keyword)
                ->orLike('item.harga', $keyword)
                ->groupEnd();
        }
        return [
            'upah' => $this->paginate($num),
            'pager' => $this->pager,
        ];
    }

    // Method untuk mendapatkan semua upah
    public function getUpah()
    {
        return $this->select('item.id, item.nama AS nama_upah, satuan.nama_satuan AS satuan_nama, item.kode, item.harga')
            ->join('satuan', 'item.satuan = satuan.id')
            ->where('item.jenis', 'upah')
            ->orderBy('item.id', 'DESC')
            ->findAll();
    }
    // Method untuk mencari upah berdasarkan keyword
    public function searchAlat($num, $keyword)
    {
        $this->select('item.id, item.nama AS nama_alat, satuan.nama_satuan AS satuan_nama, item.kode, item.harga')
            ->join('satuan', 'item.satuan = satuan.id')
            ->where('item.jenis', 'alat')
            ->orderBy('item.id', 'DESC');
        if ($keyword) {
            $this->groupStart()
                ->like('item.nama', $keyword)
                ->orLike('satuan.nama_satuan', $keyword)
                ->orLike('item.harga', $keyword)
                ->groupEnd();
        }
        return [
            'alat' => $this->paginate($num),
            'pager' => $this->pager,
        ];
    }

    // Method untuk mendapatkan semua upah
    public function getAlat()
    {
        return $this->select('item.id, item.nama AS nama_alat, satuan.nama_satuan AS satuan_nama, item.kode, item.harga')
            ->join('satuan', 'item.satuan = satuan.id')
            ->where('item.jenis', 'alat')
            ->orderBy('item.id', 'DESC')
            ->findAll();
    }
    public function countAlatsThisMonth()
    {
        return $this->where('MONTH(created_at)', date('m'))
            ->where('item.jenis', 'alat')
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();
    }
    public function countAllAlat()
    {
        return $this->where('item.jenis', 'alat')
            ->countAllResults();
    }
    public function getItem($id)
    {
        return $this->find($id);
    }
    public function countAllUpah()
    {
        return $this->where('item.jenis', 'upah')
            ->countAllResults();
    }
    public function countUpahsThisMonth()
    {
        return $this->where('MONTH(created_at)', date('m'))
            ->where('item.jenis', 'upah')
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();
    }

    // Fungsi untuk menghitung jumlah material yang dibuat bulan lalu
    public function countUpahsLastMonth()
    {
        return $this->where('MONTH(created_at)', date('m', strtotime('-1 month')))
            ->where('item.jenis', 'upah')
            ->where('YEAR(created_at)', date('Y', strtotime('-1 month')))
            ->countAllResults();
    }
}
