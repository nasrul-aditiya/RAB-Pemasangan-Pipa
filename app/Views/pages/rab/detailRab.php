<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= esc($title); ?></h4>
        </div>
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title"><?= esc($rab['nama_pekerjaan']); ?></h5>
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <!-- Button Add -->
                    <div class="col-md-9 text-md-start">
                        <?php if (isset($role) && $role == "Kepala Regu") : ?>
                            <a href="/daftar-rab/detail/tambah/<?= $rab['id']; ?>" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3 text-md-end">
                        <?php if (isset($rab) && $rab['mengetahui'] != "0") : ?>
                            <a href="/daftar-rab/detail/cetak/<?= $id; ?>" target="_blank" class="btn btn-outline-danger shadow float-right ml-2">PDF<i class="fa-solid fa-file-pdf"></i></i></a>
                            <a href="/daftar-rab/detail/excel/<?= $id; ?>" target="_blank" class="btn btn-outline-success shadow float-right">Excel <i class="fa-solid fa-print"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Uraian</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Volume</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah Biaya</th>
                            <?php if (isset($role) && $role == "Kepala Regu") : ?>

                                <th scope="col">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $i = 1; ?>
                        <?php $totalBiayaPekerjaanAll = 0; // Initialize the total biaya pekerjaan for all pekerjaan 
                        ?>

                        <?php foreach ($items as $item) : ?>

                            <h5>No. RAB : <?= $item['id_rab']; ?></h5>
                            <h5>Pekerjaan: <?= $item['nama_pekerjaan']; ?></h5>
                            <h5>Lokasi : <?= $item['lokasi']; ?></h5>

                            <?php foreach ($item['jenis_pekerjaan'] as $jenisPekerjaan) : ?>

                                <?php
                                $totalBiayaPekerjaan = 0; // Initialize the total biaya pekerjaan for each jenis_pekerjaan
                                ?>

                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <th><?= $jenisPekerjaan['jenis']; ?></th>
                                    <td colspan="4"></td>
                                    <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                        <th></th>
                                    <?php endif; ?>
                                </tr>

                                <?php foreach ($jenisPekerjaan['sub_pekerjaan'] as $subPekerjaan) : ?>
                                    <?php $totalBiayaSubPekerjaan = 0; ?>
                                    <tr>
                                        <td></td>
                                        <th><?= $subPekerjaan['sub_jenis']; ?></th>
                                        <td colspan="4"></td>
                                        <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                            <th></th>
                                        <?php endif; ?>
                                    </tr>
                                    <?php foreach ($subPekerjaan['pekerjaan'] as $pekerjaan) : ?>

                                        <?php $totalBiayaPekerjaanIndividu = 0; // Initialize the total biaya for each individual pekerjaan 
                                        $totalHargaSatuan = 0;
                                        ?>

                                        <tr>
                                            <td></td>
                                            <td>
                                                <span style="margin-left: 10px;"><?= esc($pekerjaan['pekerjaan_name']); ?></span>
                                            </td>
                                            <td><?= $pekerjaan['nama_satuan']; ?></td>
                                            <td><?= esc(number_format($pekerjaan['volume_rab'], 2, ',', '.')); ?></td>
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
                                            <td>Rp. <?= esc(number_format($totalHargaSatuan, 2, ',', '.')); ?></td>
                                            <td>Rp. <?= esc(number_format($totalBiayaPekerjaanIndividu, 2, ',', '.')); ?></td>
                                            <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                                <td>
                                                    <a href="/daftar-rab/detail/edit/<?= $pekerjaan['id']; ?>" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="/daftar-rab/detail/delete/<?= $pekerjaan['id']; ?>" class="btn btn-danger btn-hapus"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- Display the total biaya pekerjaan for the current jenis_pekerjaan -->

                                    <tr>
                                        <th></th>
                                        <th colspan="3"></th>
                                        <th>Total</th>
                                        <th>Rp. <?= esc(number_format($totalBiayaSubPekerjaan, 2, ',', '.')); ?></th>
                                        <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                            <th></th>
                                        <?php endif; ?>
                                    </tr>



                                <?php endforeach; ?>
                                <?php
                                $totalBiayaPekerjaanAll += $totalBiayaPekerjaan; // Add the total biaya pekerjaan for each jenis_pekerjaan to the total biaya pekerjaan for all pekerjaan 
                                ?>
                                <tr>
                                    <th></th>
                                    <th>Total</th>
                                    <th colspan="3"></th>
                                    <th>Rp. <?= esc(number_format($totalBiayaPekerjaan, 2, ',', '.')); ?></th>
                                    <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                        <th></th>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>

                        <?php endforeach; ?>

                        <!-- Calculate Biaya Pengawasan and Biaya Administrasi -->
                        <?php
                        $hargaSurvey = $totalBiayaPekerjaanAll * 0.04; // 4% of the total biaya pekerjaan
                        $hargaPengawasan = $totalBiayaPekerjaanAll * 0.03; // 3% of the total biaya pekerjaan
                        $nomor = $i; // Initialize $nomor with the last value of $i
                        ?>

                        <!-- Display Biaya Lain-lain -->
                        <tr>
                            <td><?= $nomor; ?></td>
                            <th>BIAYA LAIN-LAIN</th>
                            <td colspan="4"></td>
                            <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <td></td>
                            <th>
                                <span style="margin-left: 10px;">Biaya Survey dan Perencanaan</span>
                            </th>
                            <td>ls</td>
                            <td>1.00</td>
                            <td>Rp. <?= esc(number_format($hargaSurvey, 2, ',', '.')); ?></td>
                            <td>Rp. <?= esc(number_format($hargaSurvey, 2, ',', '.')); ?></td>
                            <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <td></td>
                            <th>
                                <span style="margin-left: 10px;">Biaya Pengawasan</span>
                            </th>
                            <td>ls</td>
                            <td>1.00</td>
                            <td>Rp. <?= esc(number_format($hargaPengawasan, 2, ',', '.')); ?></td>
                            <td>Rp. <?= esc(number_format($hargaPengawasan, 2, ',', '.')); ?></td>
                            <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <td></td>
                            <th>
                                <span style="margin-left: 10px;">Biaya Administrasi</span>
                            </th>
                            <td>ls</td>
                            <td>1.00</td>
                            <?php foreach ($items as $item) : ?>
                                <td>Rp. <?= esc(number_format($item['administrasi'], 2, ',', '.')); ?></td>
                                <td>Rp. <?= esc(number_format($item['administrasi'], 2, ',', '.')); ?></td>
                                <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                    <th></th>
                                <?php endif; ?>
                        </tr>

                        <?php
                                $jumlahBiayaLain = $hargaSurvey + $hargaPengawasan + $item['administrasi'];
                        ?>
                        <tr>
                            <th colspan="4"></th>
                            <th>Total</th>
                            <th>Rp. <?= esc(number_format($jumlahBiayaLain, 2, ',', '.')); ?></th>
                            <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Total</th>
                            <th colspan="3"></th>
                            <th>Rp. <?= esc(number_format($jumlahBiayaLain, 2, ',', '.')); ?></th>
                            <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>

                        <!-- Calculate the totalBiaya, ppn, totalKeseluruhan, and bulatkan -->
                        <?php
                                $totalBiaya = $totalBiayaPekerjaanAll + $jumlahBiayaLain; // Total biaya
                                $ppn = $totalBiaya * 0.11; // PPN 11%
                                $totalKeseluruhan = $totalBiaya + $ppn; // Total keseluruhan
                                $bulatkan = ceil($totalKeseluruhan / 1000) * 1000; // Round up to the nearest thousand
                        ?>

                        <tr>
                            <th colspan="2"></th>
                            <th colspan="3">Total Biaya</th>
                            <th>Rp. <?= esc(number_format($totalBiaya, 2, ',', '.')); ?></th>
                            <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <th colspan="2"></th>
                            <th colspan="3">PPN 11%</th>
                            <th>Rp. <?= esc(number_format($ppn, 2, ',', '.')); ?></th>
                            <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <th colspan="2"></th>
                            <th colspan="3">Total Keseluruhan</th>
                            <th>Rp. <?= esc(number_format($totalKeseluruhan, 2, ',', '.')); ?></th>
                            <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <th colspan="2"></th>
                            <th colspan="3">Dibulatkan</th>
                            <th>Rp. <?= esc(number_format($bulatkan, 2, ',', '.')); ?></th>
                            <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>

                    <?php endforeach; ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>