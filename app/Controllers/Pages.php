<?php

namespace App\Controllers;

use IntlDateFormatter;
use App\Models\ChartModel;
use App\Models\UserModel;
use App\Models\SatuanModel;
use App\Models\MaterialModel;
use App\Models\PekerjaModel;
use App\Models\PekerjaanModel;
use App\Models\PekerjaanDetailModel;
use App\Models\RabModel;

class Pages extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $materialModel = new MaterialModel();

        $materialsThisMonth = $materialModel->countMaterialsThisMonth();
        $materialsLastMonth = $materialModel->countMaterialsLastMonth();
        $materialsDifference = $materialsThisMonth - $materialsLastMonth;

        $pekerjaModel = new PekerjaModel();
        $pekerjasThisMonth = $pekerjaModel->countPekerjasThisMonth();
        $pekerjasLastMonth = $pekerjaModel->countPekerjasLastMonth();
        $pekerjasDifference = $pekerjasThisMonth - $pekerjasLastMonth;

        $rabModel = new RabModel();
        $rabsThisMonth = $rabModel->countRabsThisMonth();
        $rabsLastMonth = $rabModel->countRabsLastMonth();
        $rabsDifference = $rabsThisMonth - $rabsLastMonth;

        $model = new ChartModel();
        $data = [
            'title' => "Dashboard",
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
            'materialsThisMonth' => $materialsThisMonth,
            'materialsDifference' => $materialsDifference,
            'pekerjasThisMonth' => $pekerjasThisMonth,
            'pekerjasDifference' => $pekerjasDifference,
            'rabsThisMonth' => $rabsThisMonth,
            'rabsDifference' => $rabsDifference,
            'chartData' => $model->findAll()
        ];
        return view('pages/dashboard', $data);
    }
    public function daftarMaterial()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new MaterialModel();

        $keyword = $this->request->getGet('keyword');
        $materials = $keyword ? $model->searchMaterials($keyword) : $model->findAll();

        $data = [
            'title' => "Daftar Material",
            'materials' => $materials,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
        return view('pages/daftarMaterial', $data);
    }

    public function tambahMaterial()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $satuanModel = new SatuanModel();
        $data = [
            'title' => "Tambah Material",
            'satuan' => $satuanModel->findAll()
        ];
        return view('pages/material/tambahMaterial', $data);
    }

    public function storeMaterial()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new MaterialModel();
        $data = [
            'nama_material' => $this->request->getVar('nama_material'),
            'harga' => $this->request->getVar('harga'),
            'satuan' => $this->request->getVar('satuan'),
            'koefisien' => $this->request->getVar('koefisien'),
        ];
        $model->insert($data);

        return redirect()->to('/daftar-material');
    }

    public function editMaterial($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new MaterialModel();
        $material = $model->find($id);
        $satuanModel = new SatuanModel();

        if ($material) {
            $data = [
                'title' => "Edit Material",
                'material' => $material,
                'satuan' => $satuanModel->findAll(),
                'nama' => $session->get('nama'),
                'role' => $session->get('role'),
            ];
            return view('pages/material/editMaterial', $data);
        } else {
            return redirect()->to('/daftar-material')->with('error', 'Material tidak ditemukan.');
        }
    }

    public function updateMaterial($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new MaterialModel();
        $data = [
            'nama_material' => $this->request->getPost('nama_material'),
            'harga' => $this->request->getPost('harga'),
            'satuan' => $this->request->getPost('satuan'),
            'koefisien' => $this->request->getPost('koefisien'),
        ];

        $model->updateMaterialData($id, $data);

        return redirect()->to('/daftar-material')->with('success', 'Material berhasil diperbarui.');
    }

    public function deleteMaterial($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new MaterialModel();
        $material = $model->find($id);

        if ($material) {
            $model->delete($id);
            return redirect()->to('/daftar-material')->with('success', 'Material berhasil dihapus.');
        } else {
            return redirect()->to('/daftar-material')->with('error', 'Material tidak ditemukan.');
        }
    }
    public function daftarPekerja()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PekerjaModel();

        // Ambil keyword pencarian dari input form atau query string
        $keyword = $this->request->getGet('keyword');

        // Lakukan pencarian jika ada keyword
        if ($keyword) {
            $pekerjas = $model->searchPekerjas($keyword);
        } else {
            // Jika tidak ada keyword, ambil semua data pengguna
            $pekerjas = $model->findAll();
        }

        $data = [
            'title' => "Daftar Pekerja",
            'pekerjas' => $pekerjas,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
        return view('pages/daftarPekerja', $data);
    }
    public function tambahPekerja()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        $satuanModel = new SatuanModel();
        $data = [
            'title' => "Tambah Pekerja",
            'satuan' => $satuanModel->findAll()
        ];
        return view('pages/pekerja/tambahPekerja', $data);
    }
    public function storePekerja()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PekerjaModel();

        $data = [
            'nama_pekerja'     => $this->request->getVar('nama_pekerja'),
            'harga'     => $this->request->getVar('harga'),
            'satuan' => $this->request->getVar('satuan'),
            'koefisien' => $this->request->getVar('koefisien'),
        ];

        $model->insert($data);

        return redirect()->to('/daftar-pekerja');
    }
    public function editPekerja($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PekerjaModel();
        $pekerja = $model->find($id);
        $satuanModel = new SatuanModel();

        if ($pekerja) {
            $data = [
                'title' => "Edit Material",
                'pekerja' => $pekerja,
                'nama' => $session->get('nama'),
                'satuan' => $satuanModel->findAll(),
                'role' => $session->get('role'),
            ];
            return view('pages/pekerja/editPekerja', $data);
        } else {
            // Handle jika material tidak ditemukan
            return redirect()->to('/daftar-pekerja')->with('error', 'Pekerja tidak ditemukan.');
        }
    }

    public function updatePekerja($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PekerjaModel();
        $data = [
            'nama_pekerja' => $this->request->getPost('nama_pekerja'),
            'harga' => $this->request->getPost('harga'),
            'satuan' => $this->request->getPost('satuan'),
            'koefisien' => $this->request->getPost('koefisien'),
        ];

        $model->updatePekerjaData($id, $data);

        return redirect()->to('/daftar-pekerja')->with('success', 'Pekerja berhasil diperbarui.');
    }
    public function deletePekerja($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PekerjaModel();
        $pekerja = $model->find($id);

        if ($pekerja) {
            $model->delete($id);
            return redirect()->to('/daftar-pekerja')->with('success', 'Pekerja berhasil dihapus.');
        } else {
            return redirect()->to('/daftar-pekerja')->with('error', 'Pekerja tidak ditemukan.');
        }
    }
    public function daftarPekerjaan()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        $model = new PekerjaanModel();

        // Ambil keyword pencarian dari input form atau query string
        $keyword = $this->request->getGet('keyword');

        // Lakukan pencarian jika ada keyword
        if ($keyword) {
            $pekerjaans = $model->searchRabs($keyword);
        } else {
            // Jika tidak ada keyword, ambil semua data pengguna
            $pekerjaans = $model->findAll();
        }

        $data = [
            'title' => "Daftar Pekerjaan",
            'pekerjaans' => $pekerjaans,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
        return view('pages/daftarPekerjaan', $data);
    }
    public function tambahPekerjaan()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => "Tambah Pekerjaan"
        ];
        return view('pages/pekerjaan/tambahPekerjaan', $data);
    }
    public function storePekerjaan()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PekerjaanModel();

        $data = [
            'nama_pekerjaan'     => $this->request->getVar('nama_pekerjaan'),
        ];

        $model->insert($data);

        return redirect()->to('/daftar-pekerjaan');
    }
    public function editPekerjaan($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PekerjaanModel();
        $pekerjaan = $model->find($id);

        if ($pekerjaan) {
            $data = [
                'title' => "Edit Pekerjaan",
                'pekerjaan' => $pekerjaan,
                'nama' => $session->get('nama'),
                'role' => $session->get('role'),
            ];
            return view('pages/pekerjaan/editPekerjaan', $data);
        } else {
            // Handle jika material tidak ditemukan
            return redirect()->to('/daftar-pekerjaan')->with('error', 'Pekerjaan tidak ditemukan.');
        }
    }

    public function updatePekerjaan($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PekerjaanModel();
        $data = [
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
        ];

        $model->updatePekerjaanData($id, $data);

        return redirect()->to('/daftar-pekerjaan')->with('success', 'Pekerjaan berhasil diperbarui.');
    }
    public function deletePekerjaan($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PekerjaanModel();
        $pekerjaan = $model->find($id);

        if ($pekerjaan) {
            $model->delete($id);
            return redirect()->to('/daftar-pekerjaan')->with('success', 'Pekerjaan berhasil dihapus.');
        } else {
            return redirect()->to('/daftar-pekerjaan')->with('error', 'Pekerjaan tidak ditemukan.');
        }
    }
    public function detailPekerjaan($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $pekerjaanModel = new PekerjaanModel();
        $pekerjaanDetailModel = new PekerjaanDetailModel();
        $materialModel = new MaterialModel();
        $pekerjaModel = new PekerjaModel();

        $pekerjaan = $pekerjaanModel->find($id);
        $pekerjaanDetails = $pekerjaanDetailModel->where('id_pekerjaan', $id)->findAll();

        // Prepare data for the view
        $items = [];
        foreach ($pekerjaanDetails as $detail) {
            if ($detail['jenis_item'] === 'material') {
                $item = $materialModel->find($detail['item_id']);
                $itemName = $item['nama_material'];
            } else {
                $item = $pekerjaModel->find($detail['item_id']);
                $itemName = $item['nama_pekerja'];
            }
            $items[] = [
                'item_name' => $itemName,
                'volume' => $detail['volume'],
            ];
        }

        $data = [
            'title' => "Detail Pekerjaan",
            'pekerjaan' => $pekerjaan,
            'items' => $items,
        ];

        return view('pages/pekerjaan/detailPekerjaan', $data);
    }
    public function daftarRab()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        $model = new RabModel();

        // Ambil keyword pencarian dari input form atau query string
        $keyword = $this->request->getGet('keyword');

        // Lakukan pencarian jika ada keyword
        if ($keyword) {
            $rabs = $model->searchRabs($keyword);
        } else {
            // Jika tidak ada keyword, ambil semua data pengguna
            $rabs = $model->findAll();
        }
        // Format dates using IntlDateFormatter
        $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE);

        foreach ($rabs as &$rab) {
            $timestamp = strtotime($rab['tanggal']);
            $rab['tanggal'] = $formatter->format($timestamp);
        }
        $data = [
            'title' => "Daftar RAB",
            'rabs' => $rabs,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
        return view('pages/daftarRab', $data);
    }
    public function tambahRab()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => "Tambah RAB"
        ];
        return view('pages/rab/tambahRab', $data);
    }
    public function storeRab()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new RabModel();

        $data = [
            'nama'     => $this->request->getVar('nama'),
            'lokasi'     => $this->request->getVar('lokasi'),
            'tanggal' => $this->request->getVar('tanggal'),
        ];

        $model->insert($data);

        return redirect()->to('/daftar-rab');
    }
    public function editRab($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new RabModel();
        $rab = $model->find($id);

        if ($rab) {
            $data = [
                'title' => "Edit RAB",
                'rab' => $rab,
                'nama' => $session->get('nama'),
                'role' => $session->get('role'),
            ];
            return view('pages/rab/editRab', $data);
        } else {
            // Handle jika material tidak ditemukan
            return redirect()->to('/daftar-rab')->with('error', 'RAB tidak ditemukan.');
        }
    }

    public function updateRab($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new RabModel();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'lokasi' => $this->request->getPost('lokasi'),
            'tanggal' => $this->request->getPost('tanggal'),
        ];

        $model->updateRabData($id, $data);

        return redirect()->to('/daftar-rab')->with('success', 'RAB berhasil diperbarui.');
    }
    public function deleteRab($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new RabModel();
        $rab = $model->find($id);

        if ($rab) {
            $model->delete($id);
            return redirect()->to('/daftar-rab')->with('success', 'RAB berhasil dihapus.');
        } else {
            return redirect()->to('/daftar-rab')->with('error', 'RAB tidak ditemukan.');
        }
    }
    public function viewRab($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        $data = [
            'id' => $id,
            'title' => "View RAB",
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
        return view('pages/rab/viewRab', $data);
    }
    public function kelolaPengguna()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        if ($session->get('role') !== 'Admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $model = new UserModel();

        // Ambil keyword pencarian dari input form atau query string
        $keyword = $this->request->getGet('keyword');

        // Lakukan pencarian jika ada keyword
        if ($keyword) {
            $users = $model->searchUsers($keyword);
        } else {
            // Jika tidak ada keyword, ambil semua data pengguna
            $users = $model->findAll();
        }

        $data = [
            'title' => "Kelola Pengguna",
            'users' => $users,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];

        return view('pages/kelolaPengguna', $data);
    }
    public function tambahPengguna()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        if ($session->get('role') !== 'Admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        $data = [
            'title' => "Tambah Pengguna"
        ];
        return view('pages/pengguna/tambahPengguna', $data);
    }
    public function storePengguna()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        if ($session->get('role') !== 'Admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        $model = new UserModel();

        $data = [
            'username' => $this->request->getVar('username'),
            'nama'     => $this->request->getVar('nama'),
            'role'     => $this->request->getVar('role'),
            'password' => $this->request->getVar('password'),
        ];

        $model->insert($data);

        return redirect()->to('/kelola-pengguna');
    }
    public function editPengguna($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        if ($session->get('role') !== 'Admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        $model = new UserModel();
        $user = $model->find($id);

        if ($user) {
            $data = [
                'title' => "Edit Pengguna",
                'user' => $user,
                'nama' => $session->get('nama'),
                'role' => $session->get('role'),
            ];
            return view('pages/pengguna/editPengguna', $data); // Ganti 'pages/editUser' dengan nama view edit yang sesuai
        } else {
            // Handle jika pengguna tidak ditemukan
            return redirect()->to('/kelola-pengguna')->with('error', 'Pengguna tidak ditemukan.');
        }
    }

    public function updatePengguna($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        if ($session->get('role') !== 'Admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        $userModel = new UserModel();

        // Ambil data dari form edit
        $userData = [
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
            'role' => $this->request->getPost('role'),
            'password' => $this->request->getPost('password'),
        ];

        // Validasi data jika diperlukan
        // $validation = \Config\Services::validation();
        // $validation->run($userData, 'user');

        // Simpan perubahan ke dalam database
        $userModel->update($id, $userData);

        // Redirect kembali ke halaman kelola pengguna atau halaman lain yang sesuai
        return redirect()->to('/kelola-pengguna')->with('success', 'Data pengguna berhasil diperbarui.');
    }
    public function deletePengguna($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        if ($session->get('role') !== 'Admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        $userModel = new UserModel();

        // Cek apakah user ada
        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->to('/kelola-pengguna')->with('error', 'User not found');
        }

        // Lakukan penghapusan user
        $userModel->delete($id);

        // Redirect kembali ke halaman pengelolaan pengguna dengan pesan sukses
        return redirect()->to('/kelola-pengguna')->with('success', 'User deleted successfully');
    }
    public function kelolaAkun()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new UserModel();
        $user = $model->find($session->get('id'));

        $data = [
            'title' => 'Kelola Akun',
            'user' => $user,
        ];

        return view('pages/kelolaAkun', $data);
    }

    public function updateAkun()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new UserModel();
        $id = $session->get('id');
        $data = [
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
            'password' => $this->request->getPost('password'),
        ];

        $model->update($id, $data);
        $session->set([
            'username' => $data['username'],
            'nama' => $data['nama']
        ]);

        return redirect()->to('/kelola-akun')->with('success', 'Akun berhasil diperbarui.');
    }
}
