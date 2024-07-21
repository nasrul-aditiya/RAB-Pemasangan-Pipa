<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= esc($title); ?></h4>
        </div>
        <!-- Form Element -->
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title"><?= $title; ?></h5>
            </div>
            <div class="card-body">
                <?php if (session()->has('error')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->get('error'); ?>
                    </div>
                <?php endif; ?>
                <form action="/daftar-pekerja/update/<?= $pekerja['id']; ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="nama_pekerja" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama_pekerja" name="nama_pekerja" value="<?= esc($pekerja['nama_pekerja']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga" value="<?= esc($pekerja['harga']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select class="form-control" id="satuan" name="satuan">
                            <?php foreach ($satuan as $unit) : ?>
                                <option value="<?= $unit['id']; ?>" <?= $pekerja['satuan'] == $unit['id'] ? 'selected' : ''; ?>><?= $unit['nama_satuan']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="koefisien" class="form-label">Koefisien</label>
                        <input type="text" class="form-control" id="koefisien" name="koefisien" value="<?= esc($pekerja['koefisien']); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="/daftar-pekerja" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>