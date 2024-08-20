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
                        <a href="/daftar-pekerjaan/tambah" class="btn btn-outline-primary shadow"><i class="fas fa-plus"></i></a>
                    </div>
                    <!-- Search Bar -->
                    <div class="col-md-3 text-md-end">
                        <form action="/daftar-pekerjaan" method="GET" class="form-inline">
                            <div class="input-group shadow">
                                <input type="text" name="keyword" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2" value="<?= esc($keyword); ?>">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="row mb-3 mt-3 align-items-center">
                        <div class="col-md-1 text-md-start">
                            <form action="/daftar-pekerjaan" method="GET" class="form-inline">
                                <div class="input-group shadow">
                                    <select class="form-select" name="per_page" id="perPageSelect" onchange="this.form.submit()">
                                        <option value="5" <?= ($perPage == 5) ? 'selected' : ''; ?>>5</option>
                                        <option value="10" <?= ($perPage == 10) ? 'selected' : ''; ?>>10</option>
                                        <option value="15" <?= ($perPage == 15) ? 'selected' : ''; ?>>15</option>
                                        <option value="20" <?= ($perPage == 20) ? 'selected' : ''; ?>>20</option>
                                    </select>
                                </div>
                            </form>
                        </div>
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
                        <?php
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $i = 1 + ($perPage * ($page - 1));
                        ?>
                        <?php if (!empty($pekerjaans) && is_array($pekerjaans)) : ?>
                            <?php foreach ($pekerjaans['pekerjaan'] as $pekerjaan) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= esc(number_format($pekerjaan['volume'], 2, ',', '.')) . ' ' . esc($pekerjaan['nama_satuan']) . ' ' . esc($pekerjaan['nama_pekerjaan']); ?></td>
                                    <td><?= $pekerjaan['jenis_pekerjaan']; ?></td>
                                    <td><?= $pekerjaan['profit']; ?>%</td>
                                    <td>
                                        <a href="/daftar-pekerjaan/detail/<?= $pekerjaan['id']; ?>" class="btn btn-outline-info shadow"><i class="fa-solid fa-file"></i></a>
                                        <a href="/daftar-pekerjaan/edit/<?= $pekerjaan['id']; ?>" class="btn btn-outline-warning shadow"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="/daftar-pekerjaan/delete/<?= $pekerjaan['id']; ?>" class="btn btn-outline-danger shadow btn-hapus"><i class="fa-solid fa-trash"></i></a>
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
                <div class="d-flex justify-content-between">
                    <div class="">
                        <i>Menampilkan <?= 1 + ($perPage * ($page - 1)) ?> sampai <?= $i - 1 ?> dari <?= $pekerjaans['pager']->getTotal() ?> entri</i>
                    </div>
                    <div class="">
                        <?= $pekerjaans['pager']->links('default', 'pagination'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>