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
                <form action="/daftar-rab/update/<?= $rab['id']; ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="id_rab" class="form-label">ID RAB</label>
                        <input type="text" class="form-control" id="id_rab" name="id_rab" value="<?= esc($rab['id_rab']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nama_pekerjaan" class="form-label">Nama RAB</label>
                        <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan" value="<?= esc($rab['nama_pekerjaan']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <textarea class="form-control" id="lokasi" name="lokasi" rows="3"><?= esc($rab['lokasi']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= esc($rab['tanggal']); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="/daftar-rab" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>