<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RabDetailModel;
use App\Models\RabModel;
use Dompdf\Dompdf;

class CetakController extends Controller
{
    public function cetak($id)
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
            'items' => $groupedRabDetails,
            'nama' => $session->get('nama'),
            'role' => $session->get('role'),
        ];

        $dompdf = new Dompdf();

        $html = view('pages/rab/pdf_view', $data);

        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($html);

        // Render PDF
        $dompdf->render();
        $dompdf->stream("rab.pdf", array("Attachment" => false));
    }
}
