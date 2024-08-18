<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4>Tambah Upah</h4>
        </div>
        <!-- Form Element -->
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Form Tambah Upah</h5>
            </div>
            <div class="card-body">
                <form action="/daftar-upah/store" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="kode" name="kode" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" value="<?= old('harga'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select class="form-control" id="satuan" name="satuan" required>
                            <option value="">-- Pilih Satuan --</option>
                            <?php foreach ($satuan as $unit) : ?>
                                <option value="<?= esc($unit['id']); ?>" <?= (old('satuan') == $unit['id']) ? 'selected' : ''; ?>><?= esc($unit['nama_satuan']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <input type="hidden" name="jenis" value="upah">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="/daftar-upah" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>
<!-- Initialize Select2 -->
<script>
    $(document).ready(function() {
        $('#satuan').select2({
            placeholder: "-- Pilih Satuan --",
            allowClear: true,
            width: '100%' // Ensures the dropdown is as wide as its container
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