<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4>Edit Pekerjaan</h4>
        </div>
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Form Edit Pekerjaan</h5>
            </div>
            <div class="card-body">
                <form action="/daftar-pekerjaan/update/<?= $pekerjaan['id']; ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pekerjaan</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= esc($pekerjaan['nama']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis Pekerjaan</label>
                        <select class="form-control" id="jenis" name="jenis" required>
                            <option value="">-- Pilih Jenis Pekerjaan --</option>
                            <?php foreach ($jenis_pekerjaan as $key => $value) : ?>
                                <option value="<?= esc($key); ?>" <?= $pekerjaan['jenis_pekerjaan'] == $value['jenis_pekerjaan'] ? 'selected' : ''; ?>>
                                    <?= esc($value['jenis_pekerjaan']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sub_jenis" class="form-label">Sub Jenis Pekerjaan</label>
                        <select class="form-control" id="sub_jenis" name="sub_jenis" required>
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="volume" class="form-label">Volume</label>
                        <input type="number" class="form-control" id="volume" name="volume" value="<?= esc($pekerjaan['volume']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select class="form-control" id="satuan" name="satuan" required>
                            <?php foreach ($satuans as $satuan) : ?>
                                <option value="<?= $satuan['id']; ?>" <?= $pekerjaan['satuan'] == $satuan['id'] ? 'selected' : ''; ?>>
                                    <?= esc($satuan['nama_satuan']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="profit" class="form-label">Overhead & Profit (%)</label>
                        <input type="number" class="form-control" id="profit" name="profit" value="<?= esc($pekerjaan['profit']); ?>" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="/daftar-pekerjaan" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- JavaScript untuk dropdown dinamis -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisSelect = document.getElementById('jenis');
        const subJenisSelect = document.getElementById('sub_jenis');

        // Data sub jenis pekerjaan, dikelompokkan berdasarkan jenis pekerjaan
        const subJenisData = <?= json_encode($jenis_pekerjaan); ?>;
        const selectedSubJenis = <?= json_encode($pekerjaan['subjenis_pekerjaan']); ?>;

        // Update dropdown sub_jenis sesuai pilihan jenis pekerjaan
        function updateSubJenisSelect(selectedJenis) {

            // Tambahkan opsi baru berdasarkan pilihan jenis pekerjaan
            if (subJenisData[selectedJenis]) {
                for (const subJenis in subJenisData[selectedJenis]['subjenis_pekerjaan']) {
                    const option = document.createElement('option');
                    option.value = subJenis;
                    option.textContent = subJenisData[selectedJenis]['subjenis_pekerjaan'][subJenis]['sub_jenis'];
                    if (subJenis === selectedSubJenis) {
                        option.selected = true;
                    }
                    subJenisSelect.appendChild(option);
                }
            }
        }

        // Event listener untuk perubahan pilihan jenis pekerjaan
        jenisSelect.addEventListener('change', function() {
            const selectedJenis = jenisSelect.value;
            updateSubJenisSelect(selectedJenis);
        });

        // Inisialisasi dropdown sub_jenis saat halaman dimuat
        updateSubJenisSelect(jenisSelect.value);
    });
</script>
<?= $this->endSection(); ?>