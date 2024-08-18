<?php

namespace App\Models;

use CodeIgniter\Model;

class PekerjaanModel extends Model
{
    protected $table = 'pekerjaan';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama', 'jenis_pekerjaan', 'satuan', 'volume', 'profit'];

    public function getPekerjaanWithDetails($num, $keyword = null)
    {
        $this->select('pekerjaan.id, pekerjaan.nama AS nama_pekerjaan, pekerjaan.jenis_pekerjaan,  pekerjaan.volume, pekerjaan.profit, pekerjaan.satuan, satuan.nama_satuan')
            ->join('satuan', 'pekerjaan.satuan = satuan.id');

        if ($keyword) {
            $this->groupStart()
                ->like('pekerjaan.nama', $keyword)
                ->orLike('pekerjaan.jenis_pekerjaan', $keyword)
                ->groupEnd();
        }
        return [
            'pekerjaan' => $this->paginate($num),
            'pager' => $this->pager,
        ];
    }

    public function getPekerjaan($id)
    {
        return $this->select('pekerjaan.id, pekerjaan.nama AS nama_pekerjaan, pekerjaan.jenis_pekerjaan, pekerjaan.volume, pekerjaan.profit, pekerjaan.satuan, satuan.nama_satuan')
            ->join('satuan', 'pekerjaan.satuan = satuan.id')
            ->find($id);
    }

    public function updatePekerjaanData($id, $data)
    {
        return $this->update($id, $data);
    }
    public function getPekerjaanWithItems($id_rab)
    {
        return $this->select('pekerjaan.id AS pekerjaan_id, pekerjaan.nama AS nama_pekerjaan, pekerjaan.jenis_pekerjaan, pekerjaan.volume, pekerjaan.profit, item.id AS item_id, item.nama AS item_name, item.satuan, item.harga')
            ->join('pekerjaan_detail', 'pekerjaan_detail.pekerjaan_id = pekerjaan.id')
            ->join('item', 'pekerjaan_detail.item_id = item.id')
            ->where('pekerjaan_detail.id_rab', $id_rab)
            ->findAll();
    }
    public function getPekerjaanById($id)
    {
        return $this->find($id);
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
    public function countAllPekerjaans()
    {
        return $this->countAllResults();
    }

    // Method untuk mengelompokkan data pekerjaan
    public function getGroupedJenisPekerjaan()
    {
        $pekerjaans = $this->findAll();

        $groupedJenisPekerjaan = [];
        foreach ($pekerjaans as $p) {
            if (is_array($p)) {
                $jenisPekerjaan = $p['jenis_pekerjaan'];
                $id = $p['id'];

                if (!isset($groupedJenisPekerjaan[$jenisPekerjaan])) {
                    $groupedJenisPekerjaan[$jenisPekerjaan] = [
                        'id' => $p['id'],
                        'jenis_pekerjaan' => $p['jenis_pekerjaan'],
                        'pekerjaan' => [],
                    ];
                }
                if (!isset($groupedJenisPekerjaan[$jenisPekerjaan]['pekerjaan'][$id])) {
                    $groupedJenisPekerjaan[$jenisPekerjaan]['pekerjaan'][$id] = [
                        'id' => $p['id'],
                        'nama' => $p['nama'],
                    ];
                }
            }
        }

        return $groupedJenisPekerjaan;
    }
}
