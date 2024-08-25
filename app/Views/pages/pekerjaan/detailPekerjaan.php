<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= esc($title); ?></h4>
        </div>
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title"><?= esc(number_format($pekerjaan['volume'], 2, ',', '.')) . ' ' . esc($pekerjaan['nama_satuan']) . ' ' . esc($pekerjaan['nama_pekerjaan']); ?></h5>
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <!-- Button Add -->
                    <div class="col-md-9 text-md-start">
                        <a href="/daftar-pekerjaan/detail/tambah/<?= $pekerjaan['id']; ?>" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Item</th>
                            <th scope="col">Jenis Item</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Koefisien</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah Biaya</th>
                            <?php if (isset($role) && $role == "Kepala Regu" || $role == "Admin") : ?>
                                <th scope="col">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $totalBiaya = 0; // Inisialisasi variabel total biaya
                        ?>
                        <?php if (!empty($items) && is_array($items)) : ?>
                            <?php foreach ($items as $item) : ?>
                                <?php $jumlahBiaya = $item['harga'] * $item['koefisien']; ?>
                                <?php $totalBiaya += $jumlahBiaya; // Tambahkan ke total 
                                ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= esc($item['item_name']); ?></td>
                                    <td><?= esc(ucfirst($item['jenis'])); ?></td>
                                    <td><?= esc($item['nama_satuan']); ?></td>
                                    <td><?= esc(number_format($item['koefisien'], 2, ',', '.')); ?></td>
                                    <td>Rp. <?= esc(number_format($item['harga'], 2, ',', '.')); ?></td>
                                    <td>Rp. <?= esc(number_format($jumlahBiaya, 2, ',', '.')); ?></td>
                                    <?php if (isset($role) && $role == "Kepala Regu" || $role == "Admin") : ?>
                                        <td>
                                            <a href="/daftar-pekerjaan/detail/edit/<?= $item['id']; ?>" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="/daftar-pekerjaan/detail/delete/<?= $item['id']; ?>" class="btn btn-danger btn-hapus"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                            <!-- Baris Total -->
                            <tr>
                                <td colspan="6" class="text-end"><strong>Jumlah</strong></td>
                                <td><strong>Rp. <?= esc(number_format($totalBiaya, 2, ',', '.')); ?></strong></td>
                                <?php if (isset($role) && $role == "Kepala Regu" || $role == "Admin") : ?>
                                    <td></td>
                                <?php endif; ?>
                            </tr>
                            <!-- Baris PPN -->
                            <?php $ppn = $totalBiaya * ($pekerjaan['profit'] / 100); ?>
                            <tr>
                                <td colspan="6" class="text-end"><strong>Overhead % Profit (<?= esc($pekerjaan['profit']); ?>%)</strong></td>
                                <td><strong>Rp. <?= esc(number_format($ppn, 2, ',', '.')); ?></strong></td>
                                <?php if (isset($role) && $role == "Kepala Regu" || $role == "Admin") : ?>
                                    <td></td>
                                <?php endif; ?>
                            </tr>
                            <!-- Baris Total Biaya -->
                            <?php $totalHarga = $totalBiaya + $ppn; ?>
                            <tr>
                                <td colspan="6" class="text-end"><strong>Total Biaya</strong></td>
                                <td><strong>Rp. <?= esc(number_format($totalHarga, 2, ',', '.')); ?></strong></td>
                                <?php if (isset($role) && $role == "Kepala Regu" || $role == "Admin") : ?>
                                    <td></td>
                                <?php endif; ?>
                            </tr>
                            <!-- Baris Total Biaya Satuan Pekerjaan -->
                            <?php $totalBiayaSatuan = $totalHarga / $pekerjaan['volume']; ?>
                            <tr>
                                <td colspan="6" class="text-end"><strong>Total Biaya Satuan Pekerjaan</strong></td>
                                <td><strong>Rp. <?= esc(number_format($totalBiayaSatuan, 2, ',', '.')); ?></strong></td>
                                <?php if (isset($role) && $role == "Kepala Regu" || $role == "Admin") : ?>
                                    <td></td>
                                <?php endif; ?>
                            </tr>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="text-center">No items found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>