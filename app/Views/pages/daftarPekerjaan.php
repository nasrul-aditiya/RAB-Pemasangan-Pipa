<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= esc($title); ?></h4>
        </div>
        <!-- Table Element -->
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Tabel <?= esc($title); ?></h5>
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <!-- Button Add -->
                    <div class="col-md-9 text-md-start">
                        <a href="/daftar-pekerjaan/tambah" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                    </div>
                    <!-- Search Bar -->
                    <div class="col-md-3 text-md-end">
                        <form action="/daftar-pekerjaan" method="GET" class="form-inline">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Pekerjaan</th>
                            <th scope="col">Jenis Pekerjaan</th>
                            <th scope="col">Overhead & Profit</th>
                            <th scope="col">Aksi</th> <!-- Kolom Aksi -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php if (!empty($pekerjaans) && is_array($pekerjaans)) : ?>
                            <?php foreach ($pekerjaans as $pekerjaan) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= esc(number_format($pekerjaan['volume'], 2, ',', '.')) . ' ' . esc($pekerjaan['nama_satuan']) . ' ' . esc($pekerjaan['nama_pekerjaan']); ?></td>
                                    <td><?= $pekerjaan['jenis_pekerjaan']; ?></td>
                                    <td><?= $pekerjaan['profit']; ?>%</td>
                                    <td>
                                        <a href="/daftar-pekerjaan/detail/<?= $pekerjaan['id']; ?>" class="btn btn-info"><i class="fa-solid fa-file"></i></a>
                                        <a href="/daftar-pekerjaan/edit/<?= $pekerjaan['id']; ?>" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="/daftar-pekerjaan/delete/<?= $pekerjaan['id']; ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center">No pekerjaans found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>