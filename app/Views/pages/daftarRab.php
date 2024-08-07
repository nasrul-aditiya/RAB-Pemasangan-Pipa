<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<style>
    .capsule {
        display: flex;
        border: 1px solid #ccc;
        border-radius: 25px;
        overflow: hidden;
        width: 50%;
        padding: 0;
    }

    .capsule-item {
        flex: 1;
        padding: 10px 0;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .capsule-item.active {
        background-color: #00e0e0;
        border-radius: 25px;
        color: white;
    }

    .capsule-item:not(.active):hover {
        background-color: #f0f0f0;
    }
</style>
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
                <div class="row justify-content-center mb-3">
                    <div class="capsule">
                        <div class="capsule-item <?= ($filter == 'dibuat') ? 'active' : '' ?>" onclick="window.location.href='?filter=dibuat'">Dibuat</div>
                        <div class="capsule-item <?= ($filter == 'diperiksa') ? 'active' : '' ?>" onclick="window.location.href='?filter=diperiksa'">Diperiksa</div>
                        <div class="capsule-item <?= ($filter == 'diverifikasi') ? 'active' : '' ?>" onclick="window.location.href='?filter=diverifikasi'">Diverifikasi</div>
                        <div class="capsule-item <?= ($filter == 'disetujui') ? 'active' : '' ?>" onclick="window.location.href='?filter=disetujui'">Disetujui</div>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <!-- Button Add -->
                    <div class="col-md-9 text-md-start">
                        <?php if (isset($role) && $role == "Kepala Regu") : ?>
                            <a href="/daftar-rab/tambah" class="btn btn-outline-primary shadow"><i class="fas fa-plus"></i></a>
                        <?php endif; ?>
                    </div>
                    <!-- Search Bar -->
                    <div class="col-md-3 text-md-end">
                        <form action="/daftar-rab" method="GET" class="form-inline">
                            <input type="hidden" name="filter" value="<?= esc($filter); ?>">
                            <input type="hidden" name="per_page" value="<?= esc($perPage); ?>">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2" value="<?= esc($keyword); ?>">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="row mb-3 mt-3 align-items-center">
                        <div class="col-md-1 text-md-start">
                            <form action="/daftar-rab" method="GET" class="form-inline">
                                <input type="hidden" name="filter" value="<?= esc($filter); ?>">
                                <input type="hidden" name="keyword" value="<?= esc($keyword); ?>">
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
                            <th scope="col">#</th>
                            <th scope="col">No RAB</th>
                            <th scope="col">Nama RAB</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Aksi</th> <!-- Kolom Aksi -->
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
                                        <a href="/daftar-rab/detail/<?= $rab['id']; ?>" class="btn btn-outline-info shadow"><i class="fa-solid fa-file"></i></a>
                                        <?php if (isset($role) && $role == "Kepala Regu") : ?>
                                            <?php if (isset($filter) && $filter == "dibuat") : ?>
                                                <?php if ($rab['pembuat'] == 0) : ?>
                                                    <a href="/daftar-rab/edit/<?= $rab['id']; ?>" class="btn btn-outline-warning shadow"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="/daftar-rab/delete/<?= $rab['id']; ?>" class="btn btn-outline-danger shadow btn-hapus"><i class="fa-solid fa-trash"></i></a>
                                                    <a href="/daftar-rab/dibuat/<?= $rab['id']; ?>" class="btn btn-outline-success shadow btn-dibuat"><i class="fas fa-check"></i></a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (isset($role) && $role == "Kasi") : ?>
                                            <?php if (isset($filter) && $filter == "dibuat") : ?>
                                                <?php if ($rab['pemeriksa'] == 0) : ?>
                                                    <a href="/daftar-rab/diperiksa/<?= $rab['id']; ?>" class="btn btn-outline-success shadow btn-verifikasi"><i class="fas fa-check"></i></a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (isset($role) && $role == "Kabag") : ?>
                                            <?php if (isset($filter) && $filter == "diperiksa") : ?>
                                                <?php if ($rab['disetujui'] == 0) : ?>
                                                    <a href="/daftar-rab/diverifikasi/<?= $rab['id']; ?>" class="btn btn-outline-success shadow btn-verifikasi"><i class="fas fa-check"></i></a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (isset($role) && $role == "Dirtek") : ?>
                                            <?php if (isset($filter) && $filter == "diverifikasi") : ?>
                                                <?php if ($rab['mengetahui'] == 0) : ?>
                                                    <a href="/daftar-rab/disetujui/<?= $rab['id']; ?>" class="btn btn-outline-success shadow btn-verifikasi"><i class="fas fa-check"></i></a>
                                                <?php endif; ?>
                                            <?php endif; ?>
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