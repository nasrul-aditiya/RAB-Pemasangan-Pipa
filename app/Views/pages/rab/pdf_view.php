<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAB PDF</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
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
            font-size: 9px;
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
            width: 35%;
            /* Adjust percentage as needed */
        }

        .col-satuan {
            text-align: center;
            width: 5%;
            /* Adjust percentage as needed */
        }

        .col-volume {
            text-align: right;
            width: 10%;
            /* Adjust percentage as needed */
        }

        .col-harga {
            text-align: right;
            width: 20%;
            /* Adjust percentage as needed */
        }

        .col-jumlah {
            text-align: right;
            width: 25%;
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
    </style>
</head>

<body>
    <div class="container">
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

                        <?php foreach ($jenisPekerjaan['pekerjaan'] as $pekerjaan) : ?>

                            <?php $totalBiayaPekerjaanIndividu = 0;
                            $totalHargaSatuan = 0; ?>

                            <tr>
                                <td></td>
                                <td>
                                    <?= esc($pekerjaan['pekerjaan_name']); ?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <?php foreach ($pekerjaan['items'] as $item) : ?>
                                <tr>
                                    <td></td>
                                    <td class="double-indent small-text col-uraian">
                                        <?= esc($item['item_name']); ?>
                                    </td>
                                    <td class="small-text col-satuan"><?= esc($item['nama_satuan']); ?></td>
                                    <td class="small-text col-volume"><?= esc(number_format($item['volume_rab'], 2, ',', '.')); ?></td>
                                    <td class="small-text col-harga">

                                        <?php
                                        $jumlahBiaya = $item['harga'] * $item['koefisien_item'] * $item['koefisien'] / $item['volume_pekerjaan'];
                                        $jumlahBiayaDenganProfit = $jumlahBiaya * (1 + $item['profit'] / 100);
                                        $totalBiayaDenganProfit = $jumlahBiayaDenganProfit * $item['volume_rab'];
                                        ?>

                                        <?= esc(number_format($jumlahBiayaDenganProfit, 2, ',', '.')); ?>
                                    </td>
                                    <td class="small-text col-jumlah"><?= esc(number_format($totalBiayaDenganProfit, 2, ',', '.')); ?></td>
                                </tr>

                                <?php
                                $totalBiayaPekerjaanIndividu += $totalBiayaDenganProfit;
                                $totalHargaSatuan += $jumlahBiayaDenganProfit;
                                $totalBiayaPekerjaan += $totalBiayaDenganProfit;
                                ?>
                            <?php endforeach; ?>

                            <tr>
                                <th></th>
                                <th class="batas"></th>
                                <th class="batas" colspan="2">Total Harga Satuan</th>
                                <th class="batas col-jumlah"><?= esc(number_format($totalHargaSatuan, 2, ',', '.')); ?></th>
                                <th class="batas"></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th class="batas" colspan="3"></th>
                                <th class="batas">Jumlah Biaya</th>
                                <th class="batas col-jumlah"><?= esc(number_format($totalBiayaPekerjaanIndividu, 2, ',', '.')); ?></th>
                            </tr>
                        <?php endforeach; ?>

                        <tr>
                            <th class="batas-bawah"></th>
                            <th class="batas" colspan="4">Total</th>
                            <th class="batas col-jumlah"><?= esc(number_format($totalBiayaPekerjaan, 2, ',', '.')); ?></th>
                        </tr>

                        <?php
                        $totalBiayaPekerjaanAll += $totalBiayaPekerjaan;
                        ?>

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

            <?php endforeach; ?>

                </tbody>
            </table>
    </div>
</body>

</html>