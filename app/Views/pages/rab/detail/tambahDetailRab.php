<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= esc($title); ?></h4>
        </div>
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Tambah Detail Pekerjaan untuk <?= esc($rab['nama_pekerjaan']); ?></h5>
            </div>
            <div class="card-body">
                <form action="/daftar-rab/detail/store" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_rab" value="<?= esc($rab['id']); ?>">
                    <!-- Selection for Item Type -->
                    <div class="form-group">
                        <label for="id_pekerjaan">Pilih Pekerjaan:</label>
                        <select name="id_pekerjaan" id="id_pekerjaan" class="form-control" required>
                            <option value="">-- Pilih Pekerjaan --</option>
                            <?php foreach ($pekerjaans as $pekerjaan) : ?>
                                <option value="<?= esc($pekerjaan['id']) ?>"><?= esc($pekerjaan['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="volume" class="form-label">Volume</label>
                        <input type="number" class="form-control" id="volume" name="volume" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>