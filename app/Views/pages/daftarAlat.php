<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="swal" data-swal="<?= session()->getFlashdata('success'); ?>"></div>
        <div class="mb-3 text-center">
            <h4><?= $title; ?></h4>
        </div>
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Tabel <?= $title; ?></h5>
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <div class="col-md-9 text-md-start">
                        <?php if (isset($role) && ($role == "Kepala Regu" || $role == "Admin")) : ?>
                            <a href="/daftar-alat/tambah" class="btn btn-outline-primary shadow"><i class="fas fa-plus"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3 text-md-end">
                        <form action="/daftar-alat" method="GET" class="form-inline">
                            <div class="input-group shadow">
                                <input type="text" name="keyword" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2" value="<?= esc($keyword); ?>">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="row mb-3 mt-3 align-items-center">
                        <div class="col-md-1 text-md-start">
                            <form action="/daftar-alat" method="GET" class="form-inline">
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
                            <th scope="col">Nama</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Harga</th>
                            <?php if (isset($role) && ($role == "Kepala Regu" || $role == "Admin")) : ?>
                                <th scope="col">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $i = 1 + ($perPage * ($page - 1));
                        ?>
                        <?php if (!empty($alats) && is_array($alats)) : ?>
                            <?php foreach ($alats['alat'] as $alat) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= esc($alat['kode']); ?> <?= esc($alat['nama_alat']); ?></td>
                                    <td><?= esc($alat['satuan_nama']); ?></td>
                                    <td>Rp. <?= esc(number_format($alat['harga'], 2, ',', '.')); ?></td>
                                    <td>
                                        <?php if (isset($role) && ($role == "Kepala Regu" || $role == "Admin")) : ?>
                                            <a href="/daftar-alat/edit/<?= $alat['id']; ?>" class="btn btn-outline-warning shadow"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="/daftar-alat/delete/<?= $alat['id']; ?>" class="btn btn-outline-danger shadow btn-hapus"><i class="fa-solid fa-trash"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center">No alats found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <div class="">
                        <i>Menampilkan <?= 1 + ($perPage * ($page - 1)) ?> sampai <?= $i - 1 ?> dari <?= $alats['pager']->getTotal() ?> entri</i>
                    </div>
                    <div class="">
                        <?= $alats['pager']->links('default', 'pagination'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>