<?php

namespace App\Controllers;

use IntlDateFormatter;
use App\Models\ChartModel;
use App\Models\ItemModel;
use App\Models\UserModel;
use App\Models\SatuanModel;
use App\Models\MaterialModel;
use App\Models\PekerjaModel;
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

        $materialsThisMonth = $itemModel->countMaterialsThisMonth();
        $materialsLastMonth = $itemModel->countMaterialsLastMonth();
        $materialsDifference = $materialsThisMonth - $materialsLastMonth;

        $pekerjasThisMonth = $itemModel->countUpahsThisMonth();
        $pekerjasLastMonth = $itemModel->countUpahsLastMonth();
        $pekerjasDifference = $pekerjasThisMonth - $pekerjasLastMonth;

        $pekerjaanModel = new PekerjaanModel();
        $pekerjaansThisMonth = $pekerjaanModel->countPekerjaansThisMonth();
        $pekerjaansLastMonth = $pekerjaanModel->countPekerjaansLastMonth();
        $pekerjaansDifference = $pekerjaansThisMonth - $pekerjaansLastMonth;

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
            'pekerjaansThisMonth' => $pekerjaansThisMonth,
            'pekerjaansDifference' => $pekerjaansDifference,
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
            return redirect()->to('/');
        }

        $model = new ItemModel();

        $keyword = $this->request->getGet('keyword');
        $materials = $keyword ? $model->searchMaterials($keyword) : $model->getMaterials();

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
        $model->insert($data);

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

        $model->update($id, $data);

        return redirect()->to('/daftar-material')->with('success', 'Material berhasil diperbarui.');
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
        $upah = $keyword ? $model->searchUpah($keyword) : $model->getUpah();

        $data = [
            'title' => "Daftar Upah",
            'upah' => $upah,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
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
        $model->insert($data);

        return redirect()->to('/daftar-upah')->with('success', 'Upah berhasil ditambahkan.');
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

        $model->update($id, $data);

        return redirect()->to('/daftar-upah')->with('success', 'Upah berhasil diperbarui.');
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
        $pekerjaans = $model->getPekerjaanWithDetails($keyword);

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
            return redirect()->to('/');
        }

        $satuanModel = new SatuanModel();
        $jenisModel = new JenisPekerjaanModel();
        $data = [
            'title' => "Tambah Pekerjaan",
            'satuans' => $satuanModel->findAll(),
            'jenis' => $jenisModel->findAll(),
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
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
            'jenis' => $this->request->getVar('jenis'),
            'volume' => $this->request->getVar('volume'),
            'satuan' => $this->request->getVar('satuan'),
            'profit' => $this->request->getVar('profit'),
        ];

        $model->insert($data);

        return redirect()->to('/daftar-pekerjaan')->with('success', 'Pekerjaan berhasil ditambahkan.');
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
        $jenisModel = new JenisPekerjaanModel();

        if ($pekerjaan) {
            $data = [
                'title' => "Edit Pekerjaan",
                'pekerjaan' => $pekerjaan,
                'jenis' => $jenisModel->findAll(),
                'satuans' => $satuanModel->findAll(),
                'nama' => $session->get('nama'),
                'role' => $session->get('role'),
            ];
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
            'jenis' => $this->request->getPost('jenis'),
            'volume' => $this->request->getPost('volume'),
            'satuan' => $this->request->getPost('satuan'),
            'profit' => $this->request->getPost('profit'),
        ];

        $model->updatePekerjaanData($id, $data);

        return redirect()->to('/daftar-pekerjaan')->with('success', 'Pekerjaan berhasil diperbarui.');
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

        $pekerjaanDetailModel->save($data);

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

        $pekerjaan = $pekerjaanModel->find($pekerjaanDetail['pekerjaan_id']);
        $items = $itemModel->findAll();

        $data = [
            'title' => "Edit Detail Pekerjaan",
            'pekerjaan' => $pekerjaan,
            'pekerjaanDetail' => $pekerjaanDetail,
            'items' => $items,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
        return view('pages/pekerjaan/detail/editDetailPekerjaan', $data);
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

        $pekerjaanDetailModel->update($id, $data);

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

        $pekerjaanDetailModel->delete($id);

        return redirect()->to('/daftar-pekerjaan/detail/' . $detail['pekerjaan_id']);
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
        ];

        $model->insert($data);

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

        $model->updateRabData($id, $data);

        return redirect()->to('/daftar-rab')->with('success', 'RAB berhasil diperbarui.');
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
                $jenisPekerjaan = $rab['jenis_pekerjaan'];
                $pekerjaanName = $rab['pekerjaan_name'];

                // Initialize the RAB grouping if not already set
                if (!isset($groupedRabDetails[$rabId])) {
                    $groupedRabDetails[$rabId] = [
                        'id_rab' => $rab['id_rab'],
                        'nama_pekerjaan' => $rab['nama_pekerjaan'],
                        'lokasi' => $rab['lokasi'],
                        'jenis_pekerjaan' => [],
                        'jenis' => $rab['jenis_pekerjaan'],
                        'administrasi' => $rab['administrasi'],
                        'total_biaya' => 0,
                    ];
                }

                // Initialize the jenis_pekerjaan grouping if not already set
                if (!isset($groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan])) {
                    $groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan] = [
                        'jenis' => $jenisPekerjaan,
                        'total_biaya_jenis' => 0,
                        'pekerjaan' => [],
                    ];
                }

                // Initialize the pekerjaan grouping if not already set
                if (!isset($groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan]['pekerjaan'][$pekerjaanName])) {
                    $groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan]['pekerjaan'][$pekerjaanName] = [
                        'id' => $rab['id'],
                        'pekerjaan_name' => $pekerjaanName,
                        'volume_pekerjaan' => $rab['volume_pekerjaan'],
                        'items' => [],
                        'total_biaya_pekerjaan' => 0,
                    ];
                }

                // Calculate total biaya for each item
                $totalBiayaItem = $rab['volume_rab'] * $rab['harga'];

                // Add item details with total biaya
                $groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan]['pekerjaan'][$pekerjaanName]['items'][] = [
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
                $groupedRabDetails[$rabId]['jenis_pekerjaan'][$jenisPekerjaan]['pekerjaan'][$pekerjaanName]['total_biaya_pekerjaan'] += $totalBiayaItem;

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

        $pekerjaans = $pekerjaanModel->findAll();

        $data = [
            'title' => "Tambah Detail RAB",
            'rab' => $rab,
            'pekerjaans' => $pekerjaans,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];
        // dd($data);
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
            return redirect()->to('/daftar-rab/detail/' . $idRab)->with('success', 'Data berhasil disimpan.');
        } else {
            // Gagal, tampilkan pesan error
            $error = $db->error();
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $error['message']);
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

        $id_rab = $rabDetailModel->find($id);
        $detail = $rabModel->find($id_rab['id_rab']);
        // dd($id_rab);
        $pekerjaans = $pekerjaanModel->findAll();

        // echo '<pre>';
        // print_r($detail);
        // echo '</pre>';
        // exit;

        $data = [
            'title' => "Edit Detail RAB",
            'detail' => $id_rab,
            'rab' => $detail,
            'pekerjaans' => $pekerjaans,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];

        return view('pages/rab/detail/editDetailRab', $data);
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
            return redirect()->to('/daftar-rab/detail/' . $idRab)->with('success', 'Data berhasil diperbarui.');
        } else {
            // Failure, show error message
            $error = $db->error();
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $error['message']);
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

        $rabDetailModel->delete($id);

        return redirect()->to('/daftar-rab/detail/' . $detail['id_rab']);
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

        $model->insert($data);

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

        // Simpan perubahan ke dalam database
        $userModel->update($id, $userData);

        // Redirect kembali ke halaman kelola pengguna atau halaman lain yang sesuai
        return redirect()->to('/kelola-pengguna')->with('success', 'Data pengguna berhasil diperbarui.');
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
            return redirect()->to('/');
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
            return redirect()->to('/');
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
