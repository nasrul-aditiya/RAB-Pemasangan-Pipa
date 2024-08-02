<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= $title; ?></h4>
        </div>
        <!-- Table Element -->
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Tabel <?= $title; ?></h5>
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <!-- Button Add -->
                    <div class="col-md-9 text-md-start">
                        <a href="/daftar-rab/tambah" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                    </div>
                    <!-- Search Bar -->
                    <div class="col-md-3 text-md-end">
                        <form action="/daftar-rab" method="GET" class="form-inline">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2" value="<?= esc($keyword); ?>">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="row mb-3 mt-3 align-items-center">
                        <div class="col-md-1 text-md-start">
                            <form action="/daftar-rab" method="GET" class="form-inline">
                                <div class="input-group">
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
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">No RAB</th>
                            <th scope="col">Nama RAB</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Aksi</th> <!-- Kolom Aksi -->
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $i = 1 + ($perPage * ($page - 1));
                        ?>
                        <?php if (!empty($rabs) && is_array($rabs)) : ?>
                            <?php foreach ($rabs['rab'] as $rab) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= esc($rab['id_rab']); ?></td>
                                    <td><?= esc($rab['nama_pekerjaan']); ?></td>
                                    <td><?= esc($rab['lokasi']); ?></td>
                                    <td><?= esc($rab['tanggal']); ?></td>
                                    <td>
                                        <a href="/daftar-rab/detail/<?= $rab['id']; ?>" class="btn btn-info"><i class="fa-solid fa-file"></i></a>
                                        <?php if (isset($role) && $role == "Admin") : ?>
                                            <a href="/daftar-rab/edit/<?= $rab['id']; ?>" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="/daftar-rab/delete/<?= $rab['id']; ?>" class="btn btn-danger btn-hapus"><i class="fa-solid fa-trash"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center">No RABs found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <div class="">
                        <i>Menampilkan <?= 1 + ($perPage * ($page - 1)) ?> sampai <?= $i - 1 ?> dari <?= $rabs['pager']->getTotal() ?> entri</i>
                    </div>
                    <div class="">
                        <?= $rabs['pager']->links('default', 'pagination'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>