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
                <form action="/daftar-rab/store" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="id_rab" class="form-label">ID RAB</label>
                        <input type="text" class="form-control" id="id_rab" name="id_rab" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                        <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan" required>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <textarea name="lokasi" id="" class="form-control my-4 py-2" placeholder="Lokasi"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="" class="form-control my-4 py-2" placeholder="Tanggal" />
                    </div>
                    <div class="mb-3">
                        <label for="administrasi" class="form-label">Biaya Administrasi</label>
                        <input type="number" class="form-control" id="administrasi" name="administrasi">
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="/daftar-rab" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>