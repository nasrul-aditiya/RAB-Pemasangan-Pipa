<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rab.xls");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAB PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12pt;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        // Fungsi untuk mengubah angka menjadi teks terbilang
        function terbilang($angka)
        {
            $angka = (float) $angka;
            $bilangan = array(
                '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'
            );

            if ($angka < 12) {
                return $bilangan[$angka];
            } else if ($angka < 20) {
                return $bilangan[$angka - 10] . ' Belas';
            } else if ($angka < 100) {
                return $bilangan[(int)($angka / 10)] . ' Puluh ' . $bilangan[$angka % 10];
            } else if ($angka < 200) {
                return 'Seratus ' . terbilang($angka - 100);
            } else if ($angka < 1000) {
                return $bilangan[(int)($angka / 100)] . ' Ratus ' . terbilang($angka % 100);
            } else if ($angka < 2000) {
                return 'Seribu ' . terbilang($angka - 1000);
            } else if ($angka < 1000000) {
                return terbilang((int)($angka / 1000)) . ' Ribu ' . terbilang($angka % 1000);
            } else if ($angka < 1000000000) {
                return terbilang((int)($angka / 1000000)) . ' Juta ' . terbilang($angka % 1000000);
            } else if ($angka < 1000000000000) {
                return terbilang((int)($angka / 1000000000)) . ' Miliar ' . terbilang($angka % 1000000000);
            } else if ($angka < 1000000000000000) {
                return terbilang((int)($angka / 1000000000000)) . ' Triliun ' . terbilang($angka % 1000000000000);
            } else {
                return 'Angka terlalu besar';
            }
        }
        ?>


        <?php $i = 1; ?>
        <?php $totalBiayaPekerjaanAll = 0; ?>
        <table>
            <?php foreach ($items as $item) : ?>
                <tr>
                    <td style="font-size: 24pt; font-weight: bold;" colspan="15">
                        RENCANA ANGGARAN BIAYA
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        NO. RAB
                    </td>
                    <td colspan="13">
                        : <?= $item['id_rab']; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        PEKERJAAN
                    </td>
                    <td colspan="13">
                        : <?= $item['nama_pekerjaan']; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        LOKASI
                    </td>
                    <td colspan="13">
                        : <?= $item['lokasi']; ?>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;" colspan="15">
                        PERUSAHAAN UMUM DAERAH AIR MINUM TIRTA KHATULISTIWA KOTA PONTIANAK
                    </td>
                </tr>
                <tr>
                    <td colspan="15">
                    </td>
                </tr>

        </table>
        <table style="border: 2px solid black;">
            <thead>
                <tr style="border: 2px solid black;">
                    <th>No</th>
                    <th colspan="8">Uraian Pekerjaan</th>
                    <th>Satuan</th>
                    <th>Volume</th>
                    <th colspan="2">Harga Satuan<br>(Rp.)</th>
                    <th colspan="2">Jumlah Biaya<br>(Rp.)</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($item['jenis_pekerjaan'] as $jenisPekerjaan) : ?>

                    <?php $totalBiayaPekerjaan = 0; ?>

                    <tr>
                        <th class="col-number" style="border-right: 2px solid black;" scope="row"><?= $i++; ?></th>
                        <td style="border-right: 2px solid black;" colspan="8"><?= $jenisPekerjaan['jenis']; ?></td>
                        <td style="border-right: 2px solid black;"></td>
                        <td style="border-right: 2px solid black;"></td>
                        <td style="border-right: 2px solid black;" colspan="2"></td>
                        <td colspan="2"></td>
                    </tr>

                    <?php foreach ($jenisPekerjaan['sub_pekerjaan'] as $subPekerjaan) : ?>
                        <?php $totalBiayaSubPekerjaan = 0; ?>
                        <tr>
                            <td style="border-right: 2px solid black;"></td>
                            <td style="border-right: 2px solid black;" colspan="8"><?= $subPekerjaan['sub_jenis']; ?></td>
                            <td style="border-right: 2px solid black;"></td>
                            <td style="border-right: 2px solid black;"></td>
                            <td style="border-right: 2px solid black;" colspan="2"></td>
                            <td colspan="2"></td>
                        </tr>
                        <?php foreach ($subPekerjaan['pekerjaan'] as $pekerjaan) : ?>

                            <?php $totalBiayaPekerjaanIndividu = 0;
                            $totalHargaSatuan = 0; ?>

                            <tr>
                                <td style="border-right: 2px solid black;"></td>
                                <td style="border-right: 2px solid black;" colspan="8">
                                    <span style="margin-left: 10px;"><?= esc($pekerjaan['pekerjaan_name']); ?></span>
                                </td>
                                <th style="border-right: 2px solid black;" class="col-satuan"><?= $pekerjaan['nama_satuan']; ?></th>
                                <td style="border-right: 2px solid black;" class="col-volume"><?= esc(number_format($pekerjaan['volume_rab'], 2, ',', '.')); ?></td>
                                <?php foreach ($pekerjaan['items'] as $item) : ?>
                                    <?php
                                    $jumlahBiaya = $item['harga'] * $item['koefisien_item'] * $item['koefisien'] / $item['volume_pekerjaan'];
                                    $jumlahBiayaDenganProfit = $jumlahBiaya * (1 + $item['profit'] / 100);
                                    $totalBiayaDenganProfit = $jumlahBiayaDenganProfit * $item['volume_rab'];
                                    ?>


                                    <?php
                                    // Add the total_biaya of each item to the total biaya for this pekerjaan
                                    $totalBiayaPekerjaanIndividu += $totalBiayaDenganProfit;
                                    $totalHargaSatuan += $jumlahBiayaDenganProfit;
                                    // Add the total_biaya of each item to the total biaya pekerjaan
                                    $totalBiayaPekerjaan += $totalBiayaDenganProfit;
                                    $totalBiayaSubPekerjaan += $totalBiayaDenganProfit;
                                    ?>
                                <?php endforeach; ?>
                                <!-- Display the total biaya for the current pekerjaan -->
                                <td style="border-right: 2px solid black; text-align:end;" colspan="2"><?= esc(number_format($totalHargaSatuan, 2, ',', '.')); ?></td>
                                <td style="text-align:end;" colspan="2"><?= esc(number_format($totalBiayaPekerjaanIndividu, 2, ',', '.')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th style="border-right: 2px solid black;"></th>
                            <th style="border-right: 2px solid black;" colspan="8"></th>
                            <th style="border-right: 2px solid black;"></th>
                            <th style="border-right: 2px solid black;"></th>
                            <th style="border-right: 2px solid black;" colspan="2">Total</th>
                            <td style="border-top: 1px solid black; border-bottom: 1px solid black; text-align:end;" colspan="2"><?= esc(number_format($totalBiayaSubPekerjaan, 2, ',', '.')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php
                    $totalBiayaPekerjaanAll += $totalBiayaPekerjaan; // Add the total biaya pekerjaan for each jenis_pekerjaan to the total biaya pekerjaan for all pekerjaan 
                    ?>
                    <tr>
                        <th style="border-top: 2px solid black; border-bottom: 2px solid black;"></th>
                        <td style="border-right: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;" colspan="12">Jumlah Biaya</td>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; text-align:end;" colspan="2"><?= esc(number_format($totalBiayaPekerjaan, 2, ',', '.')); ?></td>
                    </tr>

                <?php endforeach; ?>

            <?php endforeach; ?>

            <?php
            $hargaSurvey = $totalBiayaPekerjaanAll * 0.04;
            $hargaPengawasan = $totalBiayaPekerjaanAll * 0.03;
            $nomor = $i;
            ?>

            <tr>
                <td style="border-right: 2px solid black;"><?= $nomor; ?></td>
                <td style="border-right: 2px solid black;" colspan="8">BIAYA LAIN-LAIN</td>
                <td style="border-right: 2px solid black;"></td>
                <td style="border-right: 2px solid black;"></td>
                <td style="border-right: 2px solid black;" colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td style="border-right: 2px solid black;"></td>
                <td style="border-right: 2px solid black;" colspan="8">
                    Biaya Survey dan Perencanaan
                </td>
                <th style="border-right: 2px solid black;">ls</th>
                <td style="border-right: 2px solid black;">1.00</td>
                <td style="border-right: 2px solid black; text-align:end;" colspan="2"><?= esc(number_format($hargaSurvey, 2, ',', '.')); ?></td>
                <td style="text-align:end;" colspan="2"><?= esc(number_format($hargaSurvey, 2, ',', '.')); ?></td>
            </tr>
            <tr>
                <td style="border-right: 2px solid black;"></td>
                <td style="border-right: 2px solid black;" colspan="8">
                    Biaya Pengawasan
                </td>
                <th style="border-right: 2px solid black;">ls</th>
                <td style="border-right: 2px solid black;">1.00</td>
                <td style="border-right: 2px solid black; text-align:end;" colspan="2"><?= esc(number_format($hargaPengawasan, 2, ',', '.')); ?></td>
                <td style="text-align:end;" colspan="2"><?= esc(number_format($hargaPengawasan, 2, ',', '.')); ?></td>
            </tr>
            <tr>
                <td style="border-right: 2px solid black;"></td>
                <td style="border-right: 2px solid black;" colspan="8">
                    Biaya Administrasi
                </td>
                <th style="border-right: 2px solid black;">ls</th>
                <td style="border-right: 2px solid black;">1.00</td>
                <?php foreach ($items as $item) : ?>
                    <td style="border-right: 2px solid black; text-align:end;" colspan="2"><?= esc(number_format($item['administrasi'], 2, ',', '.')); ?></td>
                    <td style="border-right: 2px solid black; text-align:end;" colspan="2"><?= esc(number_format($item['administrasi'], 2, ',', '.')); ?></td>
            </tr>

            <?php
                    $jumlahBiayaLain = $hargaSurvey + $hargaPengawasan + $item['administrasi'];
            ?>

            <tr>
                <th style="border-right: 2px solid black;"></th>
                <th style="border-right: 2px solid black;" colspan="8"></th>
                <th style="border-right: 2px solid black;"></th>
                <th style="border-right: 2px solid black;"></th>
                <th style="border-right: 2px solid black;" colspan="2">Total</th>
                <td style="border-top: 1px solid black; border-bottom: 1px solid black; text-align:end;" colspan="2"><?= esc(number_format($jumlahBiayaLain, 2, ',', '.')); ?></td>
            </tr>
            <tr>
                <th style="border-top: 2px solid black; border-bottom: 2px solid black;"></th>
                <td style="border-right: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;" colspan="12">Jumlah Biaya</td>
                <td style="border-top: 2px solid black; border-bottom: 2px solid black; text-align:end;" colspan="2"><?= esc(number_format($jumlahBiayaLain, 2, ',', '.')); ?></td>
            </tr>

            <?php
                    $totalBiaya = $totalBiayaPekerjaanAll + $jumlahBiayaLain;
                    $ppn = $totalBiaya * 0.11;
                    $totalKeseluruhan = $totalBiaya + $ppn;
                    $bulatkan = ceil($totalKeseluruhan / 1000) * 1000;
            ?>

            <tr>
                <th style="border-right: 2px solid black;"></th>
                <th style="border-bottom: 2px solid black;" colspan="8"></th>
                <td style="border-right: 2px solid black; border-bottom: 2px solid black;" colspan="4">Total Biaya</td>
                <td style="border-bottom: 2px solid black; text-align:end;" colspan="2"><?= esc(number_format($totalBiaya, 2, ',', '.')); ?></td>
            </tr>
            <tr>
                <th style="border-right: 2px solid black;"></th>
                <th style="border-bottom: 2px solid black;" colspan="8"></th>
                <td style="border-right: 2px solid black; border-bottom: 2px solid black;" colspan="4">PPN 11%</td>
                <td style="border-bottom: 2px solid black; text-align:end;" colspan="2"><?= esc(number_format($ppn, 2, ',', '.')); ?></td>
            </tr>
            <tr>
                <th style="border-right: 2px solid black;"></th>
                <th style="border-bottom: 2px solid black;" colspan="8"></th>
                <td style="border-right: 2px solid black; border-bottom: 2px solid black;" colspan="4">Total Keseluruhan</td>
                <td style="border-bottom: 2px solid black; text-align:end;" colspan="2"><?= esc(number_format($totalKeseluruhan, 2, ',', '.')); ?></td>
            </tr>
            <tr>
                <th style="border-right: 2px solid black; border-bottom: 2px solid black;"></th>
                <th style="border-bottom: 2px solid black;" colspan="8"></th>
                <td style="border-right: 2px solid black; border-bottom: 2px solid black;" colspan="4">Dibulatkan</td>
                <td style="border-bottom: 2px solid black; text-align:end;" colspan="2"><?= esc(number_format($bulatkan, 2, ',', '.')); ?></td>
            </tr>
            <tr>
                <th></th>
                <th colspan="2">Terbilang:</th>
                <th colspan="12" style="text-align:center"><?= terbilang($bulatkan); ?> Rupiah</th>
            </tr>

        <?php endforeach; ?>

            </tbody>
        </table>

        <table>
            <tr>
                <td colspan="15"></td>
            </tr>
            <tr>
                <td colspan="10"></td>
                <td colspan="5" style="text-align:center">Pontianak, <?= $rab['tanggal']; ?></td>
            </tr>
            <tr>
                <td colspan="10"></td>
                <td colspan="5" style="text-align:center">Perusahaan Umum Daerah Air Minum</td>
            </tr>
            <tr>
                <td colspan="10"></td>
                <td colspan="5" style="text-align:center">Tirta Khatulistiwa Kota Pontianak</td>
            </tr>
            <tr>
                <td colspan="15"></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align:center">Disetujui:</td>
                <td colspan="5" style="text-align:center">Diperiksa:</td>
                <td colspan="5" style="text-align:center">Dibuat Oleh:</td>
            </tr>
            <tr>
                <td colspan="15"></td>
            </tr>
            <tr>
                <td colspan="15"></td>
            </tr>
            <tr>
                <td colspan="15"></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align:center; text-decoration:underline; font-weight:bold;">
                    <?php foreach ($disetujui as $item) : ?>
                        <?= $item['nama']; ?>
                    <?php endforeach; ?>
                </td>
                <td colspan="5" style="text-align:center; text-decoration:underline; font-weight:bold;">
                    <?php foreach ($pemeriksa as $item) : ?>
                        <?= $item['nama']; ?>
                    <?php endforeach; ?>
                </td>
                <td colspan="5" style="text-align:center; text-decoration:underline; font-weight:bold;">
                    <?php foreach ($pembuat as $item) : ?>
                        <?= $item['nama']; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <td colspan="5" style="text-align:center">
                    <?php foreach ($disetujui as $item) : ?>
                        <?= $item['jabatan']; ?>
                    <?php endforeach; ?>
                </td>
                <td colspan="5" style="text-align:center">
                    <?php foreach ($pemeriksa as $item) : ?>
                        <?= $item['jabatan']; ?>
                    <?php endforeach; ?>
                </td>
                <td colspan="5" style="text-align:center">
                    <?php foreach ($pembuat as $item) : ?>
                        <?= $item['jabatan']; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <td colspan="15"></td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td colspan="5" style="text-align:center">Mengetahui:</td>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="15"></td>
            </tr>
            <tr>
                <td colspan="15"></td>
            </tr>
            <tr>
                <td colspan="15"></td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td colspan="5" style="text-align:center; text-decoration:underline; font-weight:bold;">
                    <?php foreach ($mengetahui as $item) : ?>
                        <?= $item['nama']; ?>
                    <?php endforeach; ?>
                </td>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td colspan="5" style="text-align:center">
                    <?php foreach ($mengetahui as $item) : ?>
                        <?= $item['jabatan']; ?>
                    <?php endforeach; ?>
                </td>
                <td colspan="5"></td>
            </tr>
        </table>
    </div>
</body>

</html>