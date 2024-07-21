<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['username', 'role', 'nama', 'password'];

    protected $useTimestamps = false;
    public function searchUsers($keyword)
    {
        if ($keyword) {
            return $this->table('users')
                ->like('username', $keyword)
                ->orLike('nama', $keyword)
                ->orLike('role', $keyword)
                ->findAll();
        } else {
            return $this->findAll();
        }
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
}
