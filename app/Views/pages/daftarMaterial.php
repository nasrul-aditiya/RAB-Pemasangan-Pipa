<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
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
                        <a href="/daftar-material/tambah" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                    </div>
                    <div class="col-md-3 text-md-end">
                        <form action="/daftar-material" method="GET" class="form-inline">
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
                            <th scope="col">Nama</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Koefisien</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php if (!empty($materials) && is_array($materials)) : ?>
                            <?php foreach ($materials as $material) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= esc($material['nama_material']); ?></td>
                                    <td>Rp. <?= esc($material['harga']); ?></td>
                                    <td><?= esc($material['koefisien']); ?></td>
                                    <td>
                                        <a href="/daftar-material/edit/<?= $material['id']; ?>" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="/daftar-material/delete/<?= $material['id']; ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center">No materials found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>