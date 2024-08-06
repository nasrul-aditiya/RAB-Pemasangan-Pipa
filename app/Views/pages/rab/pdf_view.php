<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAB PDF</title>
    <style>
        @page {
            size: A4;
            margin-top: 25mm;
            margin-bottom: 20mm;
            margin-left: 10mm;
            margin-right: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 12px;
        }

        .container {
            margin: 0 auto;
            width: 100%;
            overflow-x: auto;
            /* Allow horizontal scroll if necessary */
        }

        h5 {
            margin: 0 0 5px 0;
            font-size: 12px;
            font-weight: normal;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h5 span {
            display: inline-block;
            width: 90px;
            /* Adjust width to fit your design */
        }


        h4 {
            margin: 0 0 10px 0;
            font-size: 12px;
        }

        h1 {
            margin: 0 0 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 2px solid black;
            /* Allow columns to adjust based on content */
        }

        thead th {
            text-align: center;
        }


        th,
        td {
            border-right: 2px solid black;
            padding: 4px;
            text-align: left;
            font-size: 10px;
            word-wrap: break-word;
        }

        thead th {
            background-color: #f2f2f2;
            border-bottom: 2px solid black;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        th,
        td {
            min-width: 60px;
        }

        .batas {
            border-top: 2px solid black;
            border-bottom: 2px solid black;
        }

        .batas-bawah {
            border-bottom: 2px solid black;
        }

        /* Set custom widths for columns */
        .col-number {
            text-align: center;
            width: 5px;
            /* Adjust percentage as needed */
        }

        .col-uraian {
            /* Adjust percentage as needed */
        }

        .col-satuan {
            text-align: center;
            /* Adjust percentage as needed */
        }

        .col-volume {
            text-align: right;
            /* Adjust percentage as needed */
        }

        .col-harga {
            text-align: right;
            /* Adjust percentage as needed */
        }

        .col-jumlah {
            text-align: right;
        }

        /* Media query for print */
        @media print {
            .container {
                width: 100%;
                overflow: hidden;
            }

            table {
                page-break-inside: auto;
            }
        }

        /* CSS for sectioning */
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .footer .section {
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .footer .section div {
            width: 33%;
            text-align: center;
        }

        .footer .section div:first-child {
            text-align: left;
        }

        .footer .section div:last-child {
            text-align: right;
        }

        .footer .section .center {
            text-align: center;
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

        <?php foreach ($items as $item) : ?>
            <h1>RENCANA ANGGARAN BIAYA</h1>
            <h5><span>NO. RAB</span>: <?= $item['id_rab']; ?></h5>
            <h5><span>PEKERJAAN</span>: <?= $item['nama_pekerjaan']; ?></h5>
            <h5><span>LOKASI</span>: <?= $item['lokasi']; ?></h5>

            <h4>PERUSAHAAN UMUM DAERAH AIR MINUM TIRTA KHATULISTIWA KOTA PONTIANAK</h4>
            <table>
                <thead>
                    <tr>
                        <th class="col-number" scope="col">No</th>
                        <th class="col-uraian" scope="col">Uraian Pekerjaan</th>
                        <th class="col-satuan" scope="col">Satuan</th>
                        <th scope="col">Volume</th>
                        <th scope="col">Harga Satuan<br>(Rp.)</th>
                        <th scope="col">Jumlah Biaya<br>(Rp.)</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($item['jenis_pekerjaan'] as $jenisPekerjaan) : ?>

                        <?php $totalBiayaPekerjaan = 0; ?>

                        <tr>
                            <th class="col-number" scope="row"><?= $i++; ?></th>
                            <td><?= $jenisPekerjaan['jenis']; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <?php foreach ($jenisPekerjaan['sub_pekerjaan'] as $subPekerjaan) : ?>
                            <?php $totalBiayaSubPekerjaan = 0; ?>
                            <tr>
                                <td></td>
                                <th><?= $subPekerjaan['sub_jenis']; ?></th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php foreach ($subPekerjaan['pekerjaan'] as $pekerjaan) : ?>

                                <?php $totalBiayaPekerjaanIndividu = 0;
                                $totalHargaSatuan = 0; ?>

                                <tr>
                                    <td></td>
                                    <td>
                                        <span style="margin-left: 10px;"><?= esc($pekerjaan['pekerjaan_name']); ?></span>
                                    </td>
                                    <td class="col-satuan"><?= $pekerjaan['nama_satuan']; ?></td>
                                    <td class="col-volume"><?= esc(number_format($pekerjaan['volume_rab'], 2, ',', '.')); ?></td>
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
                                    <td class="col-harga"><?= esc(number_format($totalHargaSatuan, 2, ',', '.')); ?></td>
                                    <td class="col-jumlah"><?= esc(number_format($totalBiayaPekerjaanIndividu, 2, ',', '.')); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="col-harga">Total</th>
                                <th class="col-jumlah"><?= esc(number_format($totalBiayaSubPekerjaan, 2, ',', '.')); ?></th>
                            </tr>
                        <?php endforeach; ?>
                        <?php
                        $totalBiayaPekerjaanAll += $totalBiayaPekerjaan; // Add the total biaya pekerjaan for each jenis_pekerjaan to the total biaya pekerjaan for all pekerjaan 
                        ?>
                        <tr>
                            <th class="batas-bawah"></th>
                            <th class="batas" colspan="4">Total</th>
                            <th class="batas col-jumlah"><?= esc(number_format($totalBiayaPekerjaan, 2, ',', '.')); ?></th>
                        </tr>

                    <?php endforeach; ?>

                <?php endforeach; ?>

                <?php
                $hargaSurvey = $totalBiayaPekerjaanAll * 0.04;
                $hargaPengawasan = $totalBiayaPekerjaanAll * 0.03;
                $nomor = $i;
                ?>

                <tr>
                    <td class="col-number"><?= $nomor; ?></td>
                    <td class="col-uraian">BIAYA LAIN-LAIN</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="col-number"></td>
                    <td class="col-uraian">
                        <span class="indent">Biaya Survey dan Perencanaan</span>
                    </td>
                    <td class="small-text col-satuan">ls</td>
                    <td class="small-text col-volume">1.0000</td>
                    <td class="small-text col-harga"><?= esc(number_format($hargaSurvey, 2, ',', '.')); ?></td>
                    <td class="small-text col-jumlah"><?= esc(number_format($hargaSurvey, 2, ',', '.')); ?></td>
                </tr>
                <tr>
                    <td class="col-number"></td>
                    <td class="col-uraian">
                        <span class="indent">Biaya Pengawasan</span>
                    </td>
                    <td class="small-text col-satuan">ls</td>
                    <td class="small-text col-volume">1.0000</td>
                    <td class="small-text col-harga"><?= esc(number_format($hargaPengawasan, 2, ',', '.')); ?></td>
                    <td class="small-text col-jumlah"><?= esc(number_format($hargaPengawasan, 2, ',', '.')); ?></td>
                </tr>
                <tr>
                    <td class="col-number"></td>
                    <td class="col-uraian">
                        <span class="indent">Biaya Administrasi</span>
                    </td>
                    <td class="small-text col-satuan">ls</td>
                    <td class="small-text col-volume">1.0000</td>
                    <?php foreach ($items as $item) : ?>
                        <td class="small-text col-harga"><?= esc(number_format($item['administrasi'], 2, ',', '.')); ?></td>
                        <td class="small-text col-jumlah"><?= esc(number_format($item['administrasi'], 2, ',', '.')); ?></td>
                </tr>

                <?php
                        $jumlahBiayaLain = $hargaSurvey + $hargaPengawasan + $item['administrasi'];
                ?>

                <tr>
                    <th></th>
                    <th class="batas"></th>
                    <th class="batas " colspan="2">Total Harga Satuan</th>
                    <th class="batas col-jumlah"><?= esc(number_format($jumlahBiayaLain, 2, ',', '.')); ?></th>
                    <th class="batas"></th>
                </tr>
                <tr>
                    <th></th>
                    <th class="batas" colspan="3"></th>
                    <th class="batas">Jumlah Biaya</th>
                    <th class="batas col-jumlah"><?= esc(number_format($jumlahBiayaLain, 2, ',', '.')); ?></th>
                </tr>

                <?php
                        $totalBiaya = $totalBiayaPekerjaanAll + $jumlahBiayaLain;
                        $ppn = $totalBiaya * 0.11;
                        $totalKeseluruhan = $totalBiaya + $ppn;
                        $bulatkan = ceil($totalKeseluruhan / 1000) * 1000;
                ?>

                <tr>
                    <th class="batas" colspan="2"></th>
                    <th class="batas" colspan="3">Total Biaya</th>
                    <th class="batas col-jumlah"><?= esc(number_format($totalBiaya, 2, ',', '.')); ?></th>
                </tr>
                <tr>
                    <th class="batas" colspan="2"></th>
                    <th class="batas" colspan="3">PPN 11%</th>
                    <th class="batas col-jumlah"><?= esc(number_format($ppn, 2, ',', '.')); ?></th>
                </tr>
                <tr>
                    <th class="batas" colspan="2"></th>
                    <th class="batas" colspan="3">Total Keseluruhan</th>
                    <th class="batas col-jumlah"><?= esc(number_format($totalKeseluruhan, 2, ',', '.')); ?></th>
                </tr>
                <tr>
                    <th class="batas" colspan="2"></th>
                    <th class="batas" colspan="3">Dibulatkan</th>
                    <th class="batas col-jumlah"><?= esc(number_format($bulatkan, 2, ',', '.')); ?></th>
                </tr>
                <tr>
                    <th colspan="6" style="text-align:center"><?= terbilang($bulatkan); ?> Rupiah</th>
                </tr>

            <?php endforeach; ?>

                </tbody>
            </table>
            <table class="center-table" style="font-family: Arial, Helvetica, sans-serif; padding-top: 5px; width: 100%; border: none;">
                <tr>
                    <td style="width: 33%; vertical-align: top; border: none;">
                        <table class="center-table" style="font-family: Arial, Helvetica, sans-serif; padding-top: 5px; border: none;">
                            <tr>

                            </tr>
                        </table>
                    </td>
                    <td style="width: 33%; vertical-align: top; border: none;">
                        <table class="center-table" style="font-family: Arial, Helvetica, sans-serif; padding-top: 5px; border: none;">
                            <tr>

                            </tr>
                        </table>
                    </td>
                    <td style="width: 33%; vertical-align: top; border: none;">
                        <table class="center-table" style="font-family: Arial, Helvetica, sans-serif; padding-top: 5px; border: none;">
                            <tr>
                                <td style="border: none; text-align:center;">
                                    <font style="font-size: 10px">Pontianak, <?= $rab['tanggal']; ?></font><br>

                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; text-align:center; background-color:white;">
                                    <font style="font-size: 10px">Perusahaan Umum Daerah Air Minum</font><br>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; text-align:center;">
                                    <font style="font-size: 10px">Tirta Khatulistiwa Kota Pontianak</font><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- baris kedua -->
                <tr>
                    <td style="width: 33%; vertical-align: top; border: none;">
                        <table class="center-table" style="font-family: Arial, Helvetica, sans-serif; padding-top: 5px; border: none;">
                            <tr>
                                <td style="padding-bottom: 50px; border: none; text-align:center;">
                                    <font style="font-size: 10px">Disetujui :</font><br>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; text-align:center; background-color:white;">
                                    <font style="font-size: 10px; text-decoration:underline; font-weight:bold;">
                                        <?php foreach ($disetujui as $item) : ?>
                                            <?= $item['nama']; ?>
                                        <?php endforeach; ?>
                                    </font><br>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; text-align:center;">
                                    <font style="font-size: 10px">
                                        <?php foreach ($disetujui as $item) : ?>
                                            <?= $item['jabatan']; ?>
                                        <?php endforeach; ?>
                                    </font><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 33%; vertical-align: top; border: none;">
                        <table class="center-table" style="font-family: Arial, Helvetica, sans-serif; padding-top: 5px; border: none;">
                            <tr>
                                <td style="padding-bottom: 50px; border: none; text-align:center;">
                                    <font style="font-size: 10px">Diperiksa :</font><br>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; text-align:center; background-color:white;">
                                    <font style="font-size: 10px; text-decoration:underline; font-weight:bold;">
                                        <?php foreach ($pemeriksa as $item) : ?>
                                            <?= $item['nama']; ?>
                                        <?php endforeach; ?>
                                    </font><br>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; text-align:center;">
                                    <font style="font-size: 10px">
                                        <?php foreach ($pemeriksa as $item) : ?>
                                            <?= $item['jabatan']; ?>
                                        <?php endforeach; ?>
                                    </font><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 33%; vertical-align: top; border: none;">
                        <table class="center-table" style="font-family: Arial, Helvetica, sans-serif; padding-top: 5px; border: none;">
                            <tr>
                                <td style="padding-bottom: 50px; border: none; text-align:center;">
                                    <font style="font-size: 10px">Dibuat Oleh :</font><br>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; text-align:center; background-color:white;">
                                    <font style="font-size: 10px; text-decoration:underline; font-weight:bold;">
                                        <?php foreach ($pembuat as $item) : ?>
                                            <?= $item['nama']; ?>
                                        <?php endforeach; ?>
                                    </font><br>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; text-align:center;">
                                    <font style="font-size: 10px">
                                        <?php foreach ($pembuat as $item) : ?>
                                            <?= $item['jabatan']; ?>
                                        <?php endforeach; ?>
                                    </font><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- baris ketiga -->
                <tr>
                    <td style="width: 33%; vertical-align: top; border: none;">
                        <table class="center-table" style="font-family: Arial, Helvetica, sans-serif; padding-top: 5px; border: none;">
                            <tr>

                            </tr>
                        </table>
                    </td>
                    <td style="width: 33%; vertical-align: top; border: none;">
                        <table class="center-table" style="font-family: Arial, Helvetica, sans-serif; padding-top: 5px; border: none;">
                            <tr>
                                <td style="padding-bottom: 50px; border: none; text-align:center;">
                                    <font style="font-size: 10px">Mengetahui :</font><br>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; text-align:center; background-color:white;">
                                    <font style="font-size: 10px; text-decoration:underline; font-weight:bold;">
                                        <?php foreach ($mengetahui as $item) : ?>
                                            <?= $item['nama']; ?>
                                        <?php endforeach; ?>
                                    </font><br>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; text-align:center;">
                                    <font style="font-size: 10px">
                                        <?php foreach ($mengetahui as $item) : ?>
                                            <?= $item['jabatan']; ?>
                                        <?php endforeach; ?>
                                    </font><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 33%; vertical-align: top; border: none;">
                        <table class="center-table" style="font-family: Arial, Helvetica, sans-serif; padding-top: 5px; border: none;">
                            <tr>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
    </div>
</body>

</html>