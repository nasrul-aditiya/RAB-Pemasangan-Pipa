<?php

namespace App\Models;

use CodeIgniter\Model;

class RabModel extends Model
{
    protected $table = 'rab_profile';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id_rab', 'nama_pekerjaan', 'lokasi', 'tanggal', 'administrasi', 'pembuat', 'pemeriksa', 'disetujui', 'mengetahui'];

    public function searchRabs($num, $keyword)
    {
        $this->table('rab_profile');
        if ($keyword) {
            $this->groupStart()
                ->like('nama_pekerjaan', $keyword)
                ->orLike('id_rab', $keyword)
                ->orLike('lokasi', $keyword)
                ->groupEnd();
        }
        return [
            'rab' => $this->paginate($num),
            'pager' => $this->pager,
        ];
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
            'pekerjaan.jenis_pekerjaan AS jenis',
            'pekerjaan.subjenis_pekerjaan AS sub_jenis',
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
                'pekerjaan.jenis_pekerjaan',
                'pekerjaan.subjenis_pekerjaan',
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
    public function countAllRabs()
    {
        return $this->countAllResults();
    }

    public function getRabWithPembuat($rabId)
    {
        // Construct the query to get detailed RAB information along with total cost
        return $this->select([
            'rab_profile.id AS id_rab',
            'rab_profile.pembuat',
            'users.id AS id_user',
            'users.nama',
            'users.jabatan',
        ])
            ->join('users', 'users.id = rab_profile.pembuat')
            ->where('rab_profile.id', $rabId)
            ->groupBy([
                'rab_profile.id',
            ])
            ->findAll();
    }
    public function getRabWithPemeriksa($rabId)
    {
        // Construct the query to get detailed RAB information along with total cost
        return $this->select([
            'rab_profile.id AS id_rab',
            'rab_profile.pemeriksa',
            'users.id AS id_user',
            'users.nama',
            'users.jabatan',
        ])
            ->join('users', 'users.id = rab_profile.pemeriksa')
            ->where('rab_profile.id', $rabId)
            ->groupBy([
                'rab_profile.id',
            ])
            ->findAll();
    }
    public function getRabWithDisetujui($rabId)
    {
        // Construct the query to get detailed RAB information along with total cost
        return $this->select([
            'rab_profile.id AS id_rab',
            'rab_profile.disetujui',
            'users.id AS id_user',
            'users.nama',
            'users.jabatan',
        ])
            ->join('users', 'users.id = rab_profile.disetujui')
            ->where('rab_profile.id', $rabId)
            ->groupBy([
                'rab_profile.id',
            ])
            ->findAll();
    }
    public function getRabWithMengetahui($rabId)
    {
        // Construct the query to get detailed RAB information along with total cost
        return $this->select([
            'rab_profile.id AS id_rab',
            'rab_profile.mengetahui',
            'users.id AS id_user',
            'users.nama',
            'users.jabatan',
        ])
            ->join('users', 'users.id = rab_profile.mengetahui')
            ->where('rab_profile.id', $rabId)
            ->groupBy([
                'rab_profile.id',
            ])
            ->findAll();
    }
}
