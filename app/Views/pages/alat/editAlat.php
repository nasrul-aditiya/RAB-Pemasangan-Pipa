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
                <h5 class="card-title">Form <?= esc($title); ?></h5>
            </div>
            <div class="card-body">
                <form action="/daftar-alat/update/<?= esc($alat['id']); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= esc($alat['nama']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode <span class="opsi">(Opsional)</span></label>
                        <input type="text" class="form-control" id="kode" name="kode" value="<?= esc($alat['kode']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" value="<?= esc($alat['harga']); ?>" step="any" required>
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select class="form-control" id="satuan" name="satuan" required>
                            <?php foreach ($satuan as $unit) : ?>
                                <option value="<?= esc($unit['id']); ?>" <?= $alat['satuan'] == $unit['id'] ? 'selected' : ''; ?>>
                                    <?= esc($unit['nama_satuan']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <input type="hidden" name="jenis" value="alat">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="/daftar-alat" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function() {
        // Initialize the Select2 plugin for the 'satuan' dropdown
        $('#satuan').select2({
            placeholder: "-- Pilih Satuan --",
            allowClear: false,
            width: '100%' // Ensure the dropdown matches the container width
        });

        // Focus on the search input when the dropdown is opened
        $('#satuan').on('select2:open', function() {
            // Focus on the search input field
            setTimeout(function() {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 100); // Add a slight delay to ensure the dropdown is fully rendered
        });
    });
</script>

<?= $this->endSection(); ?>