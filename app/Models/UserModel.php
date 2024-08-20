<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['username', 'role', 'nama', 'password',  'jabatan', 'avatar'];

    protected $useTimestamps = false;
    public function searchUsers($num, $keyword)
    {
        $this->table('users');
        if ($keyword) {
            $this->groupStart()
                ->like('nama', $keyword)
                ->orLike('role', $keyword)
                ->groupEnd();
        }
        return [
            'users' => $this->paginate($num),
            'pager' => $this->pager,
        ];
    }
    public function getUsers()
    {
        return $this->findAll();
    }

    public function getUser($id)
    {
        return $this->find($id);
    }
    public function updateUserData($id, $data)
    {
        // Update data pengguna berdasarkan ID
        return $this->update($id, $data);
    }
    public function countUsersThisMonth()
    {
        return $this->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();
    }
    public function countAllUsers()
    {
        return $this->countAllResults();
    }
}
