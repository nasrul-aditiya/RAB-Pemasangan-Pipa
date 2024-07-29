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
                        <a href="/daftar-rab/detail/tambah/<?= $rab['id']; ?>" class="btn btn-primary"><i class="fas fa-plus"></i></a>
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
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
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
                                    <td><?= $jenisPekerjaan['jenis']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <?php foreach ($jenisPekerjaan['pekerjaan'] as $pekerjaan) : ?>
                                    <?php $totalBiayaPekerjaanIndividu = 0; // Initialize the total biaya for each individual pekerjaan 
                                    $totalHargaSatuan = 0;
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <span style="margin-left: 10px;"><?= esc($pekerjaan['pekerjaan_name']); ?></span>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <a href="/daftar-rab/detail/edit/<?= $pekerjaan['id']; ?>" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="/daftar-rab/detail/delete/<?= $pekerjaan['id']; ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>

                                    <?php foreach ($pekerjaan['items'] as $item) : ?>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <small style="margin-left: 20px;"><?= esc($item['item_name']); ?></small>
                                            </td>
                                            <td><?= esc($item['nama_satuan']); ?></td>
                                            <td><?= esc($item['volume_rab']); ?></td>
                                            <td>
                                                <?php
                                                $jumlahBiaya = $item['harga'] * $item['koefisien_item'] * $item['koefisien'] / $item['volume_pekerjaan'];
                                                $jumlahBiayaDenganProfit = $jumlahBiaya * (1 + $item['profit'] / 100);
                                                $totalBiayaDenganProfit = $jumlahBiayaDenganProfit * $item['volume_rab'];
                                                ?>
                                                Rp. <?= esc(number_format($jumlahBiayaDenganProfit, 2, ',', '.')); ?>
                                            </td>
                                            <td>Rp. <?= esc(number_format($totalBiayaDenganProfit, 2, ',', '.')); ?></td>
                                            <td></td>
                                        </tr>

                                        <?php
                                        // Add the total_biaya of each item to the total biaya for this pekerjaan
                                        $totalBiayaPekerjaanIndividu += $totalBiayaDenganProfit;

                                        $totalHargaSatuan += $jumlahBiayaDenganProfit;

                                        // Add the total_biaya of each item to the total biaya pekerjaan
                                        $totalBiayaPekerjaan += $totalBiayaDenganProfit;
                                        ?>

                                    <?php endforeach; ?>
                                    <!-- Display the total biaya for the current pekerjaan -->
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total Harga Satuan</th>
                                        <th>Rp. <?= esc(number_format($totalHargaSatuan, 2, ',', '.')); ?></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Jumlah Biaya</th>
                                        <th>Rp. <?= esc(number_format($totalBiayaPekerjaanIndividu, 2, ',', '.')); ?></th>
                                        <th></th>
                                    </tr>
                                <?php endforeach; ?>
                                <!-- Display the total biaya pekerjaan for the current jenis_pekerjaan -->
                                <tr>
                                    <th></th>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Rp. <?= esc(number_format($totalBiayaPekerjaan, 2, ',', '.')); ?></th>
                                    <th></th>
                                </tr>
                            <?php endforeach; ?>


                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>