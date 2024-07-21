<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= $title; ?></h4>
        </div>
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Form <?= $title; ?></h5>
            </div>
            <div class="card-body">
                <form action="/daftar-material/store" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="nama_material" class="form-label">Nama Material</label>
                        <input type="text" class="form-control" id="nama_material" name="nama_material" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select class="form-control" id="satuan" name="satuan" required>
                            <?php foreach ($satuan as $unit) : ?>
                                <option value="<?= $unit['id']; ?>"><?= $unit['nama_satuan']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="koefisien" class="form-label">Koefisien</label>
                        <input type="text" class="form-control" id="koefisien" name="koefisien" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="/daftar-material" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>