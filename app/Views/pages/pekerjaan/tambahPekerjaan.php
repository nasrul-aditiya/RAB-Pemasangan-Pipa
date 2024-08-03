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
                            <option value="">-- Pilih Jenis Pekerjaan 2 --</option>
                            <?php foreach ($jenis_pekerjaan as $key => $pekerjaan) : ?>
                                <option value="<?= esc($key); ?>"><?= esc($pekerjaan['jenis_pekerjaan']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sub_jenis" class="form-label">Sub Jenis Pekerjaan</label>
                        <select class="form-control" id="sub_jenis" name="sub_jenis" required>
                            <option value="">-- Pilih Sub Jenis Pekerjaan --</option>
                            <!-- Options will be populated by JavaScript -->
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
        const jenis2Select = document.getElementById('jenis2');
        const subJenisSelect = document.getElementById('sub_jenis');

        const subJenisData = <?= json_encode($jenis_pekerjaan); ?>;

        jenis2Select.addEventListener('change', function() {
            const selectedJenis2 = jenis2Select.value;
            updateSubJenisSelect(selectedJenis2);
        });

        function updateSubJenisSelect(selectedJenis2) {
            // Hapus opsi sebelumnya
            subJenisSelect.innerHTML = '<option value="">-- Pilih Sub Jenis Pekerjaan --</option>';

            // Filter sub jenis berdasarkan jenis pekerjaan 2 yang dipilih
            if (subJenisData[selectedJenis2]) {
                Object.keys(subJenisData[selectedJenis2]['subjenis_pekerjaan']).forEach(subJenis => {
                    const option = document.createElement('option');
                    option.value = subJenis;
                    option.textContent = subJenis;
                    subJenisSelect.appendChild(option);
                });
            }
        }
    });
</script>

<?= $this->endSection(); ?>