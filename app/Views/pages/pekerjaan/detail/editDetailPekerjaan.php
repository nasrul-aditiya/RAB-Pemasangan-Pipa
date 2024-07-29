<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= esc($title); ?></h4>
        </div>
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Edit Detail Pekerjaan untuk <?= esc($pekerjaan['nama']); ?></h5>
            </div>
            <div class="card-body">
                <form action="/daftar-pekerjaan/detail/update/<?= esc($pekerjaanDetail['id']); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="pekerjaan_id" value="<?= esc($pekerjaan['id']); ?>">

                    <div class="mb-3">
                        <label for="item_id" class="form-label">Nama Item</label>
                        <select class="form-select" id="item_id" name="item_id" required>
                            <option value="">-- Pilih Item --</option>
                            <?php foreach ($items as $item) : ?>
                                <option value="<?= $item['id']; ?>" <?= ($item['id'] == $pekerjaanDetail['item_id']) ? 'selected' : ''; ?>>
                                    <?= esc($item['nama']); ?> (<?= esc($item['jenis']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="koefisien" class="form-label">Koefisien</label>
                        <input type="text" class="form-control" id="koefisien" name="koefisien" value="<?= esc($pekerjaanDetail['koefisien']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>