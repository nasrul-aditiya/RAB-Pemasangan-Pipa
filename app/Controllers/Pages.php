<?php

namespace App\Controllers;

use IntlDateFormatter;
use App\Models\ChartModel;
use App\Models\ItemModel;
use App\Models\UserModel;
use App\Models\SatuanModel;
use App\Models\PekerjaanModel;
use App\Models\JenisPekerjaanModel;
use App\Models\PekerjaanDetailModel;
use App\Models\RabModel;
use App\Models\RabDetailModel;

class Pages extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $itemModel = new ItemModel();

        $allMaterial = $itemModel->countAllMaterials();
        $materialsThisMonth = $itemModel->countMaterialsThisMonth();

        $allUpah = $itemModel->countAllUpah();
        $pekerjasThisMonth = $itemModel->countUpahsThisMonth();

        $pekerjaanModel = new PekerjaanModel();
        $pekerjaansThisMonth = $pekerjaanModel->countPekerjaansThisMonth();
        $allPekerjaan = $pekerjaanModel->countAllPekerjaans();

        $rabModel = new RabModel();
        $rabsThisMonth = $rabModel->countRabsThisMonth();
        $allRab = $rabModel->countAllRabs();

        $model = new ChartModel();
        $data = [
            'title' => "Dashboard",
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
            'materialsThisMonth' => $materialsThisMonth,
            'allMaterial' => $allMaterial,
            'pekerjasThisMonth' => $pekerjasThisMonth,
            'allUpah' => $allUpah,
            'pekerjaansThisMonth' => $pekerjaansThisMonth,
            'allPekerjaan' => $allPekerjaan,
            'rabsThisMonth' => $rabsThisMonth,
            'allRab' => $allRab,
            'chartData' => $model->findAll()
        ];
        return view('pages/dashboard', $data);
    }
    public function daftarMaterial()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new ItemModel();

        $keyword = $this->request->getGet('keyword');

        // Get the selected number of items per page from the dropdown
        $perPage = $this->request->getGet('per_page') ?: 10; // Default to 10 if not set

        // Retrieve data with the specified number of items per page
        $materials = $model->searchMaterials($perPage, $keyword);

        $data = [
            'title' => "Daftar Material",
            'materials' => $materials,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
            'keyword' => $keyword, // To keep the keyword in the search bar
            'perPage' => $perPage, // Pass perPage to the view
        ];
        return view('pages/daftarMaterial', $data);
    }

    public function tambahMaterial()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
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
            return redirect()->to('/');
        }

        $model = new ItemModel();
        $data = [
            'nama' => $this->request->getVar('nama'),
            'jenis' => 'material',
            'kode' => $this->request->getVar('kode'),
            'satuan' => $this->request->getVar('satuan'),
            'harga' => $this->request->getVar('harga'),
            'koefisien' => $this->request->getVar('koefisien'),
        ];
        try {
            $model->insert($data);
            $session->setFlashdata('success', 'Material berhasil disimpan.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'Material gagal disimpan. Silahkan coba lagi.');
        }

        return redirect()->to('/daftar-material');
    }

    public function editMaterial($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new ItemModel();
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
            return redirect()->to('/');
        }

        $model = new ItemModel();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'kode' => $this->request->getPost('kode'),
            'harga' => $this->request->getPost('harga'),
            'satuan' => $this->request->getPost('satuan'),
            'koefisien' => $this->request->getPost('koefisien'),
            'jenis' => 'material', // Tetap 'material'
        ];
        try {
            $model->update($id, $data);
            $session->setFlashdata('success', 'Material berhasil diubah.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'Material gagal diubah. Silahkan coba lagi.');
        }

        return redirect()->to('/daftar-material');
    }

    public function deleteMaterial($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new ItemModel();
        $material = $model->find($id);

        if ($material) {
            $model->delete($id);
            return redirect()->to('/daftar-material')->with('success', 'Material berhasil dihapus.');
        } else {
            return redirect()->to('/daftar-material')->with('error', 'Material tidak ditemukan.');
        }
    }
    public function daftarUpah()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new ItemModel();

        $keyword = $this->request->getGet('keyword');
        // Get the selected number of items per page from the dropdown
        $perPage = $this->request->getGet('per_page') ?: 10; // Default to 10 if not set

        // Retrieve data with the specified number of items per page
        $upah = $model->searchUpah($perPage, $keyword);

        $data = [
            'title' => "Daftar Upah",
            'upah' => $upah,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
            'keyword' => $keyword, // To keep the keyword in the search bar
            'perPage' => $perPage, // Pass perPage to the view
        ];
        return view('pages/daftarUpah', $data);
    }
    public function tambahUpah()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $satuanModel = new SatuanModel();
        $data = [
            'title' => "Tambah Upah",
            'satuan' => $satuanModel->findAll(),
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
        return view('pages/upah/tambahUpah', $data);
    }

    public function storeUpah()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new ItemModel();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'kode' => $this->request->getPost('kode'),
            'harga' => $this->request->getPost('harga'),
            'satuan' => $this->request->getPost('satuan'),
            'koefisien' => $this->request->getPost('koefisien'),
            'jenis' => 'upah',
        ];
        try {
            $model->insert($data);
            $session->setFlashdata('success', 'Upah berhasil disimpan.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'Upah gagal disimpan. Silahkan coba lagi.');
        }

        return redirect()->to('/daftar-upah');
    }

    public function editUpah($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new ItemModel();
        $upah = $model->find($id);
        $satuanModel = new SatuanModel();

        if ($upah) {
            $data = [
                'title' => "Edit Upah",
                'upah' => $upah,
                'satuan' => $satuanModel->findAll(),
                'nama' => $session->get('nama'),
                'role' => $session->get('role'),
            ];
            return view('pages/upah/editUpah', $data);
        } else {
            return redirect()->to('/daftar-upah')->with('error', 'Upah tidak ditemukan.');
        }
    }

    public function updateUpah($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new ItemModel();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'kode' => $this->request->getPost('kode'),
            'harga' => $this->request->getPost('harga'),
            'satuan' => $this->request->getPost('satuan'),
            'koefisien' => $this->request->getPost('koefisien'),
            'jenis' => 'upah',
        ];
        try {
            $model->update($id, $data);
            $session->setFlashdata('success', 'Upah berhasil diubah.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'Upah gagal diubah. Silahkan coba lagi.');
        }

        return redirect()->to('/daftar-upah');
    }

    public function deleteUpah($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new ItemModel();
        $model->delete($id);

        return redirect()->to('/daftar-upah')->with('success', 'Upah berhasil dihapus.');
    }
    public function daftarPekerjaan()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new PekerjaanModel();
        $keyword = $this->request->getGet('keyword');

        // Get the selected number of items per page from the dropdown
        $perPage = $this->request->getGet('per_page') ?: 10; // Default to 10 if not set

        // Retrieve data with the specified number of items per page
        $pekerjaans = $model->getPekerjaanWithDetails($perPage, $keyword);

        $data = [
            'title' => "Daftar Pekerjaan",
            'pekerjaans' => $pekerjaans,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
            'keyword' => $keyword, // To keep the keyword in the search bar
            'perPage' => $perPage, // Pass perPage to the view
        ];
        // dd($data);

        return view('pages/daftarPekerjaan', $data);
    }

    public function tambahPekerjaan()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $satuanModel = new SatuanModel();
        $jenisModel = new JenisPekerjaanModel();
        $pekerjaanModel = new PekerjaanModel();
        $pekerjaans = $pekerjaanModel->findAll();
        // Group the results by id_rab and jenis_pekerjaan
        $groupedJenisPekerjaan = [];
        foreach ($pekerjaans as $pekerjaan) {
            // Ensure $rab is an array
            if (is_array($pekerjaan)) {
                $jenisPekerjaan = $pekerjaan['jenis_pekerjaan'];
                $subJenisPekerjaan = $pekerjaan['subjenis_pekerjaan'];

                // Initialize the RAB grouping if not already set
                if (!isset($groupedJenisPekerjaan[$jenisPekerjaan])) {
                    $groupedJenisPekerjaan[$jenisPekerjaan] = [
                        'jenis_pekerjaan' => $pekerjaan['jenis_pekerjaan'],
                        'subjenis_pekerjaan' => [],
                    ];
                }
                // Initialize the jenis_pekerjaan grouping if not already set
                if (!isset($groupedJenisPekerjaan[$jenisPekerjaan]['subjenis_pekerjaan'][$subJenisPekerjaan])) {
                    $groupedJenisPekerjaan[$jenisPekerjaan]['subjenis_pekerjaan'][$subJenisPekerjaan] = [
                        'sub_jenis' => $pekerjaan['subjenis_pekerjaan'],
                    ];
                }
            }
        }
        // dd($groupedJenisPekerjaan);
        $data = [
            'title' => "Tambah Pekerjaan",
            'satuans' => $satuanModel->findAll(),
            'jenis' => $jenisModel->findAll(),
            'jenis_pekerjaan' => $groupedJenisPekerjaan,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
        // dd($data);
        return view('pages/pekerjaan/tambahPekerjaan', $data);
    }

    public function storePekerjaan()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new PekerjaanModel();
        $data = [
            'nama' => $this->request->getVar('nama'),
            'jenis_pekerjaan' => $this->request->getVar('jenis2'),
            'subjenis_pekerjaan' => $this->request->getVar('sub_jenis'),
            'volume' => $this->request->getVar('volume'),
            'satuan' => $this->request->getVar('satuan'),
            'profit' => $this->request->getVar('profit'),
        ];
        try {
            $model->insert($data);
            $session->setFlashdata('success', 'Pekerjaan berhasil disimpan.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'Pekerjaan gagal disimpan. Silahkan coba lagi.');
        }

        return redirect()->to('/daftar-pekerjaan');
    }

    public function editPekerjaan($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new PekerjaanModel();
        $pekerjaan = $model->find($id);
        $satuanModel = new SatuanModel();
        $pekerjaans = $model->findAll();
        // Group the results by id_rab and jenis_pekerjaan
        $groupedJenisPekerjaan = [];
        foreach ($pekerjaans as $p) {
            // Ensure $rab is an array
            if (is_array($pekerjaan)) {
                $jenisPekerjaan = $p['jenis_pekerjaan'];
                $subJenisPekerjaan = $p['subjenis_pekerjaan'];

                // Initialize the RAB grouping if not already set
                if (!isset($groupedJenisPekerjaan[$jenisPekerjaan])) {
                    $groupedJenisPekerjaan[$jenisPekerjaan] = [
                        'jenis_pekerjaan' => $p['jenis_pekerjaan'],
                        'subjenis_pekerjaan' => [],
                    ];
                }
                // Initialize the jenis_pekerjaan grouping if not already set
                if (!isset($groupedJenisPekerjaan[$jenisPekerjaan]['subjenis_pekerjaan'][$subJenisPekerjaan])) {
                    $groupedJenisPekerjaan[$jenisPekerjaan]['subjenis_pekerjaan'][$subJenisPekerjaan] = [
                        'sub_jenis' => $p['subjenis_pekerjaan'],
                    ];
                }
            }
        }

        if ($pekerjaan) {
            $data = [
                'title' => "Edit Pekerjaan",
                'pekerjaan' => $pekerjaan,
                'satuans' => $satuanModel->findAll(),
                'jenis_pekerjaan' => $groupedJenisPekerjaan,
                'nama' => $session->get('nama'),
                'role' => $session->get('role'),
            ];
            // dd($data);
            return view('pages/pekerjaan/editPekerjaan', $data);
        } else {
            return redirect()->to('/daftar-pekerjaan')->with('error', 'Pekerjaan tidak ditemukan.');
        }
    }

    public function updatePekerjaan($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new PekerjaanModel();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'jenis_pekerjaan' => $this->request->getVar('jenis'),
            'subjenis_pekerjaan' => $this->request->getVar('sub_jenis'),
            'volume' => $this->request->getPost('volume'),
            'satuan' => $this->request->getPost('satuan'),
            'profit' => $this->request->getPost('profit'),
        ];
        try {
            $model->updatePekerjaanData($id, $data);
            $session->setFlashdata('success', 'Pekerjaan berhasil diubah.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'Pekerjaan gagal diubah. Silahkan coba lagi.');
        }

        return redirect()->to('/daftar-pekerjaan');
    }

    public function deletePekerjaan($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new PekerjaanModel();
        if ($model->find($id)) {
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
            return redirect()->to('/');
        }

        $pekerjaanModel = new PekerjaanModel();
        $pekerjaanDetailModel = new PekerjaanDetailModel();

        $pekerjaan = $pekerjaanModel->getPekerjaan($id);
        $items = $pekerjaanDetailModel->getPekerjaanDetails($id);

        $data = [
            'title' => "Detail Pekerjaan",
            'pekerjaan' => $pekerjaan,
            'items' => $items,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
        // dd($data);

        return view('pages/pekerjaan/detailPekerjaan', $data);
    }
    public function tambahDetailPekerjaan($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $pekerjaanModel = new PekerjaanModel();
        $itemModel = new ItemModel();

        $pekerjaan = $pekerjaanModel->getPekerjaan($id);
        $items = $itemModel->findAll();

        $data = [
            'title' => "Tambah Detail Pekerjaan",
            'pekerjaan' => $pekerjaan,
            'items' => $items,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
        return view('pages/pekerjaan/detail/tambahDetailPekerjaan', $data);
    }
    public function storeDetailPekerjaan()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $pekerjaanDetailModel = new PekerjaanDetailModel();

        $data = [
            'pekerjaan_id' => $this->request->getPost('pekerjaan_id'),
            'item_id' => $this->request->getPost('item_id'),
            'koefisien' => $this->request->getPost('koefisien'),
        ];

        try {
            $pekerjaanDetailModel->save($data);
            $session->setFlashdata('success', 'Detail Pekerjaan berhasil disimpan.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'Detail Pekerjaan gagal disimpan. Silahkan coba lagi.');
        }

        return redirect()->to('/daftar-pekerjaan/detail/' . $data['pekerjaan_id']);
    }
    public function editDetailPekerjaan($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $pekerjaanDetailModel = new PekerjaanDetailModel();
        $pekerjaanModel = new PekerjaanModel();
        $itemModel = new ItemModel();

        $pekerjaanDetail = $pekerjaanDetailModel->find($id);
        if (!$pekerjaanDetail) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $filter = $itemModel->find($pekerjaanDetail['item_id']);

        $pekerjaan = $pekerjaanModel->find($pekerjaanDetail['pekerjaan_id']);
        $items = $itemModel->findAll();
        // Tentukan tipe item yang sudah dipilih sebelumnya (contoh)
        $selectedType = $filter['jenis'] ?? '';
        if ($pekerjaanDetail) {
            $data = [
                'title' => "Edit Detail Pekerjaan",
                'pekerjaan' => $pekerjaan,
                'pekerjaanDetail' => $pekerjaanDetail,
                'selectedType' => $selectedType,
                'items' => $items,
                'filter' => $filter,
                'nama' => $session->get('nama'),
                'role' => $session->get('role'),
            ];
            // dd($data);
            return view('pages/pekerjaan/detail/editDetailPekerjaan', $data);
        } else {
            return redirect()->to('/daftar-pekerjaan/detail' . $pekerjaanDetail['pekerjaan_id'])->with('error', 'Item tidak ditemukan.');
        }
    }

    public function updateDetailPekerjaan($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $pekerjaanDetailModel = new PekerjaanDetailModel();

        $data = [
            'item_id' => $this->request->getPost('item_id'),
            'koefisien' => $this->request->getPost('koefisien'),
        ];
        try {
            $pekerjaanDetailModel->update($id, $data);
            $session->setFlashdata('success', 'Detail Pekerjaan berhasil diubah.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'Detail Pekerjaan gagal diubah. Silahkan coba lagi.');
        }

        return redirect()->to('/daftar-pekerjaan/detail/' . $this->request->getPost('pekerjaan_id'));
    }

    public function deleteDetailPekerjaan($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $pekerjaanDetailModel = new PekerjaanDetailModel();
        $detail = $pekerjaanDetailModel->find($id);
        if ($detail) {
            $pekerjaanDetailModel->delete($id);
            return redirect()->to('/daftar-pekerjaan/detail/' . $detail['pekerjaan_id'])->with('success', 'Detail Pekerjaan berhasil dihapus.');
        } else {
            return redirect()->to('/daftar-pekerjaan/detail/' . $detail['pekerjaan_id'])->with('error', 'Detail Pekerjaan tidak ditemukan.');
        }
    }
    public function daftarRab()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }
        $model = new RabModel();

        // Ambil keyword pencarian dari input form atau query string
        $keyword = $this->request->getGet('keyword');

        // Get the selected number of items per page from the dropdown
        $perPage = $this->request->getGet('per_page') ?: 10; // Default to 10 if not set

        // Retrieve data with the specified number of items per page
        $rabs = $model->searchRabs($perPage, $keyword);
        // Format dates using IntlDateFormatter
        $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE);

        foreach ($rabs['rab'] as &$rab) {
            $timestamp = strtotime($rab['tanggal']);
            $rab['tanggal'] = $formatter->format($timestamp);
        }
        $data = [
            'title' => "Daftar RAB",
            'rabs' => $rabs,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
            'keyword' => $keyword, // To keep the keyword in the search bar
            'perPage' => $perPage, // Pass perPage to the view
        ];
        return view('pages/daftarRab', $data);
    }
    public function tambahRab()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
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
            return redirect()->to('/');
        }

        $model = new RabModel();

        $data = [
            'id_rab'     => $this->request->getVar('id_rab'),
            'nama_pekerjaan'     => $this->request->getVar('nama_pekerjaan'),
            'lokasi'     => $this->request->getVar('lokasi'),
            'tanggal' => $this->request->getVar('tanggal'),
            'administrasi' => $this->request->getVar('administrasi'),
        ];
        try {
            $model->insert($data);
            $session->setFlashdata('success', 'RAB berhasil disimpan.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'RAB gagal disimpan. Silahkan coba lagi.');
        }

        return redirect()->to('/daftar-rab');
    }
    public function editRab($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
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
            return redirect()->to('/');
        }

        $model = new RabModel();
        $data = [
            'id_rab' => $this->request->getPost('id_rab'),
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'lokasi' => $this->request->getPost('lokasi'),
            'tanggal' => $this->request->getPost('tanggal'),
        ];
        try {
            $model->updateRabData($id, $data);
            $session->setFlashdata('success', 'RAB berhasil diubah.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'RAB gagal diubah. Silahkan coba lagi.');
        }

        return redirect()->to('/daftar-rab');
    }
    public function deleteRab($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
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
    public function detailRab($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $rabModel = new RabDetailModel();
        $model = new RabModel();
        $rabs = $model->find($id);
        $rabDetails = $rabModel->getRabDetailsWithTotal($id);
        // dd($rabDetails);

        // Group the results by id_rab and jenis_pekerjaan
        $groupedRabDetails = [];
        foreach ($rabDetails as $rab) {
            // Ensure $rab is an array
            if (is_array($rab)) {
                $rabId = $rab['id_rab'];
                $jenisPekerjaan = $rab['jenis'];
                $subJenis = $rab['sub_jenis'];
                $pekerjaanName = $rab['pekerjaan_name'];

                // Initialize the RAB grouping if not already set
                if (!isset($groupedRabDetails[$rabId])) {
                    $groupedRabDetails[$rabId] = [
                        'id_rab' => $rab['id_rab'],
                        'nama_pekerjaan' => $rab['nama_pekerjaan'],
                        'lokasi' => $rab['lokasi'],
                        'jenis_pekerjaan' => [],
                        'jenis' => $rab['jenis'],
                        'administrasi' => $rab['administrasi'],
                        'total_biaya' => 0,
                    ];
                }

                // Initialize the jenis_pekerjaan grouping if not already set
                if (!isset($groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan])) {
                    $groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan] = [
                        'jenis' => $jenisPekerjaan,
                        'jenis_pekerjaan' => $rab['jenis'],
                        'sub_jenis' => $rab['sub_jenis'],
                        'total_biaya_jenis' => 0,
                        'sub_pekerjaan' => [],
                    ];
                }

                // Initialize the pekerjaan grouping if not already set
                if (!isset($groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan]['sub_pekerjaan'][$subJenis])) {
                    $groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan]['sub_pekerjaan'][$subJenis] = [
                        'sub_jenis' => $subJenis,
                        'pekerjaan' => [],
                    ];
                }
                // Initialize the pekerjaan grouping if not already set
                if (!isset($groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan]['sub_pekerjaan'][$subJenis]['pekerjaan'][$pekerjaanName])) {
                    $groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan]['sub_pekerjaan'][$subJenis]['pekerjaan'][$pekerjaanName] = [
                        'id' => $rab['id'],
                        'pekerjaan_name' => $pekerjaanName,
                        'volume_pekerjaan' => $rab['volume_pekerjaan'],
                        'volume_rab' => $rab['volume_rab'],
                        'nama_satuan' => $rab['nama_satuan'],
                        'items' => [],
                        'total_biaya_pekerjaan' => 0,
                    ];
                }

                // Calculate total biaya for each item
                $totalBiayaItem = $rab['volume_rab'] * $rab['harga'];

                // Add item details with total biaya
                $groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan]['sub_pekerjaan'][$subJenis]['pekerjaan'][$pekerjaanName]['items'][] = [
                    'item_name' => $rab['item_name'],
                    'nama_satuan' => $rab['nama_satuan'],
                    'harga' => $rab['harga'],
                    'koefisien' => $rab['koefisien'],
                    'koefisien_item' => $rab['koefisien_item'],
                    'profit' => $rab['profit'],
                    'volume_rab' => $rab['volume_rab'],
                    'volume_pekerjaan' => $rab['volume_pekerjaan'],
                    'total_biaya' => $totalBiayaItem,
                ];

                // Add to total biaya for this pekerjaan
                $groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan]['sub_pekerjaan'][$subJenis]['pekerjaan'][$pekerjaanName]['total_biaya_pekerjaan'] += $totalBiayaItem;

                // Add to total biaya for this jenis pekerjaan
                $groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan]['total_biaya_jenis'] += $totalBiayaItem;
                // Add to total biaya for this RAB
                $groupedRabDetails[$rabId]['total_biaya'] += $totalBiayaItem;
            } else {
                // Handle the error if $rab is not an array
                error_log('Unexpected data structure for $rab: ' . print_r($rab, true));
            }
        }
        // dd($groupedRabDetails);
        $data = [
            'title' => "Detail RAB",
            'rab' => $rabs,
            'id' => $id,
            'items' => $groupedRabDetails,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
        // dd($data);

        return view('pages/rab/detailRab', $data);
    }


    public function tambahDetailRab($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }
        $rabModel = new RabModel();
        $pekerjaanModel = new PekerjaanModel();

        $rab = $rabModel->find($id);

        // Ambil data jenis pekerjaan yang sudah dikelompokkan
        $jenis_pekerjaan = $pekerjaanModel->getGroupedJenisPekerjaan();
        // dd($jenis_pekerjaan);
        // dd($jenis_pekerjaan['PENGADAAN PIPA DAN AKSESORIS']['subjenis_pekerjaan']['Pengadaan Pipa']['pekerjaan']);
        // dd($jenis_pekerjaan['PENGADAAN PIPA DAN AKSESORIS']['subjenis_pekerjaan']);

        $data = [
            'title' => "Tambah Detail RAB",
            'rab' => $rab,
            'jenis_pekerjaan' => $jenis_pekerjaan,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
        return view('pages/rab/detail/tambahDetailRab', $data);
    }
    public function storeDetailRab()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $idRab = $this->request->getPost('id_rab');
        $idPekerjaan = $this->request->getPost('id_pekerjaan');
        $volume = $this->request->getPost('volume');
        $db = \Config\Database::connect();

        $sql = "INSERT INTO rab_detail (id_rab, id_pekerjaan, volume) VALUES (?, ?, ?)";

        // Eksekusi query dengan binding parameter
        $result = $db->query($sql, [$idRab, $idPekerjaan, $volume]);
        // dd($data);

        if ($result) {
            // Berhasil, redirect ke halaman detail RAB
            return redirect()->to('/daftar-rab/detail/' . $idRab)->with('success', 'Detail RAB berhasil disimpan.');
        } else {
            return redirect()->back()->with('error', 'Detail RAB gagal disimpan. Silahkan coba lagi');
        }
    }
    public function editDetailRab($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $rabModel = new RabModel();
        $rabDetailModel = new RabDetailModel();
        $pekerjaanModel = new PekerjaanModel();

        // Ambil detail RAB dan pekerjaan
        $detail = $rabDetailModel->find($id);
        $rab = $rabModel->find($detail['id_rab']);
        $jenisPekerjaan = $pekerjaanModel->getGroupedJenisPekerjaan();

        if ($detail) {
            // Menentukan jenis dan sub jenis pekerjaan yang sudah dipilih
            $selected_jenis = null;
            $selected_sub_jenis = null;

            foreach ($jenisPekerjaan as $jenis => $data) {
                foreach ($data['subjenis_pekerjaan'] as $subJenis => $subData) {
                    if (isset($subData['pekerjaan'][$detail['id_pekerjaan']])) {
                        $selected_jenis = $jenis;
                        $selected_sub_jenis = $subJenis;
                        break 2;
                    }
                }
            }
        }

        // Pastikan detail ada
        if ($detail) {
            $data = [
                'title' => "Edit Detail RAB",
                'detail' => $detail,
                'rab' => $rab,
                'jenis_pekerjaan' => $jenisPekerjaan,
                'selected_jenis' => $selected_jenis,
                'selected_sub_jenis' => $selected_sub_jenis,
                'nama' => $session->get('nama'),
                'role' => $session->get('role'),
            ];

            return view('pages/rab/detail/editDetailRab', $data);
        } else {
            return redirect()->to('/daftar-rab/detail/' . $rab['id'])->with('error', 'Pekerjaan tidak ditemukan.');
        }
    }


    public function updateDetailRab()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $id = $this->request->getPost('id');
        $idRab = $this->request->getPost('id_rab');
        $idPekerjaan = $this->request->getPost('id_pekerjaan');
        $volume = $this->request->getPost('volume');
        $db = \Config\Database::connect();

        $sql = "UPDATE rab_detail SET id_rab = ?, id_pekerjaan = ?, volume = ? WHERE id = ?";

        // Execute the query with bound parameters
        $result = $db->query($sql, [$idRab, $idPekerjaan, $volume, $id]);

        if ($result) {
            // Successful, redirect to the detail page
            return redirect()->to('/daftar-rab/detail/' . $idRab)->with('success', 'Detail RAB berhasil diubah.');
        } else {
            // Failure, show error message
            $error = $db->error();
            return redirect()->back()->with('error', 'Detail RAB gagal diubah. Silahkan coba lagi.');
        }
    }

    public function deleteDetailRab($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $rabDetailModel = new RabDetailModel();
        $detail = $rabDetailModel->find($id);
        if ($detail) {
            $rabDetailModel->delete($id);
            return redirect()->to('/daftar-rab/detail/' . $detail['id_rab'])->with('success', 'Detail RAB berhasil dihapus.');
        } else {
            return redirect()->to('/daftar-rab/detail/' . $detail['id_rab'])->with('error', 'Detail RAB tidak ditemukan.');
        }
    }
    public function kelolaPengguna()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }
        if ($session->get('role') !== 'Admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $model = new UserModel();

        // Ambil keyword pencarian dari input form atau query string
        $keyword = $this->request->getGet('keyword');

        // Get the selected number of items per page from the dropdown
        $perPage = $this->request->getGet('per_page') ?: 10; // Default to 10 if not set

        // Retrieve data with the specified number of items per page
        $users = $model->searchUsers($perPage, $keyword);

        $data = [
            'title' => "Kelola Pengguna",
            'users' => $users,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
            'keyword' => $keyword, // To keep the keyword in the search bar
            'perPage' => $perPage, // Pass perPage to the view
        ];

        return view('pages/kelolaPengguna', $data);
    }
    public function tambahPengguna()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
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
            return redirect()->to('/');
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
        try {
            $model->insert($data);
            $session->setFlashdata('success', 'Pengguna baru berhasil disimpan.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'Pengguna baru gagal disimpan. Silahkan coba lagi.');
        }

        return redirect()->to('/kelola-pengguna');
    }
    public function editPengguna($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
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
            return redirect()->to('/');
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

        try {
            $userModel->update($id, $userData);
            $session->setFlashdata('success', 'Data Pengguna berhasil diubah.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'Data Pengguna gagal diubah. Silahkan coba lagi.');
        }

        return redirect()->to('/kelola-pengguna');
    }
    public function deletePengguna($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }
        if ($session->get('role') !== 'Admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        $userModel = new UserModel();

        // Cek apakah user ada
        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->to('/kelola-pengguna')->with('error', 'Pengguna tidak ditemukan.');
        }

        // Lakukan penghapusan user
        $userModel->delete($id);

        // Redirect kembali ke halaman pengelolaan pengguna dengan pesan sukses
        return redirect()->to('/kelola-pengguna')->with('success', 'Pengguna berhasil dihapus.');
    }
    public function kelolaAkun()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }
        $model = new UserModel();
        $user = $model->find($session->get('id'));

        $data = [
            'title' => 'Kelola Akun',
            'user' => $user,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];

        return view('pages/kelolaAkun', $data);
    }

    public function updateAkun()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new UserModel();
        $id = $session->get('id');
        $data = [
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
            'password' => $this->request->getPost('password'),
            'role' => $this->request->getPost('role'),
        ];
        try {
            $model->update($id, $data);
            // Perbarui data session dengan data yang baru diupdate
            $session->set('username', $data['username']);
            $session->set('nama', $data['nama']);
            $session->set('role', $data['role']);
            $session->setFlashdata('success', 'Akun berhasil diperbarui.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'Akun gagal diperbarui. Silahkan coba lagi.');
        }
        return redirect()->back();
    }
}
