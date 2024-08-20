<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4>Tambah Pekerjaan</h4>
        </div>
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Form Tambah Pekerjaan</h5>
            </div>
            <div class="card-body">
                <form action="/daftar-pekerjaan/store" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pekerjaan</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis2" class="form-label">Jenis Pekerjaan</label>
                        <select class="form-control" id="jenis2" name="jenis2" required>
                            <option value="">-- Pilih Jenis Pekerjaan --</option>
                            <?php foreach ($jenis_pekerjaan as $key => $pekerjaan) : ?>
                                <option value="<?= esc($key); ?>"><?= esc($pekerjaan['jenis_pekerjaan']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="volume" class="form-label">Volume</label>
                        <input type="number" class="form-control" id="volume" name="volume" required>
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select class="form-control" id="satuan" name="satuan" required>
                            <option value="">-- Pilih Satuan --</option>
                            <?php foreach ($satuans as $satuan) : ?>
                                <option value="<?= esc($satuan['id']); ?>"><?= esc($satuan['nama_satuan']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="profit" class="form-label">Overhead & Profit (%)</label>
                        <input type="number" class="form-control" id="profit" name="profit">
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="/daftar-pekerjaan" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- JavaScript untuk dropdown dinamis -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pastikan Select2 sudah terinisialisasi setelah semua elemen siap
        $('#jenis2').select2({
            placeholder: "-- Pilih Jenis Pekerjaan --",
            tags: "true",
            width: "100%"
        });
        $('#satuan').select2({
            placeholder: "-- Pilih Satuan --",
            width: "100%"
        });
        // Focus on the search input when the dropdown is opened
        $('#jenis2').on('select2:open', function() {
            // Focus on the search input field
            setTimeout(function() {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 100); // Add a slight delay to ensure the dropdown is fully rendered
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