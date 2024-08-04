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

                    <!-- Dropdown untuk Jenis Pekerjaan -->
                    <div class="form-group">
                        <label for="jenis2">Pilih Jenis Pekerjaan:</label>
                        <select name="jenis2" id="jenis2" class="form-control" required>
                            <option value="">-- Pilih Jenis Pekerjaan --</option>
                            <?php foreach ($jenis_pekerjaan as $key => $value) : ?>
                                <option value="<?= esc($key); ?>"><?= esc($value['jenis_pekerjaan']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Dropdown untuk Sub Jenis Pekerjaan -->
                    <div class="form-group">
                        <label for="sub_jenis">Pilih Sub Jenis Pekerjaan:</label>
                        <select name="sub_jenis" id="sub_jenis" class="form-control" required>
                            <option value="">-- Pilih Sub Jenis Pekerjaan --</option>
                        </select>
                    </div>

                    <!-- Dropdown untuk Pekerjaan -->
                    <div class="form-group">
                        <label for="id_pekerjaan">Pilih Pekerjaan:</label>
                        <select name="id_pekerjaan" id="id_pekerjaan" class="form-control" required>
                            <option value="">-- Pilih Pekerjaan --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="volume" class="form-label">Volume</label>
                        <input type="number" class="form-control" id="volume" name="volume" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- JavaScript untuk dropdown dinamis dengan Select2 -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pastikan Select2 sudah terinisialisasi setelah semua elemen siap
        $('#jenis2').select2({
            placeholder: "-- Pilih Jenis Pekerjaan --",
            width: "100%"
        });

        $('#sub_jenis').select2({
            placeholder: "-- Pilih Sub Jenis Pekerjaan --",
            width: "100%"
        });
        $('#id_pekerjaan').select2({
            placeholder: "-- Pilih Pekerjaan --",
            width: "100%"
        });

        // Ambil elemen select
        const jenis2Select = $('#jenis2');
        const subJenisSelect = $('#sub_jenis');
        const pekerjaanSelect = $('#id_pekerjaan');

        // Data sub jenis pekerjaan
        const subJenisData = <?= json_encode($jenis_pekerjaan, JSON_HEX_TAG); ?>;

        // Event listener untuk perubahan jenis pekerjaan
        jenis2Select.on('change', function() {
            const selectedJenis2 = $(this).val();
            updateSubJenisSelect(selectedJenis2);
        });

        // Fungsi untuk memperbarui sub jenis
        function updateSubJenisSelect(selectedJenis2) {
            // Kosongkan opsi sebelumnya
            subJenisSelect.empty().append('<option value="">-- Pilih Sub Jenis Pekerjaan --</option>');

            // Cek apakah sub jenis data tersedia
            if (subJenisData[selectedJenis2] && subJenisData[selectedJenis2]['subjenis_pekerjaan']) {
                // Iterasi dan tambahkan setiap sub jenis pekerjaan ke dropdown
                Object.entries(subJenisData[selectedJenis2]['subjenis_pekerjaan']).forEach(([key, value]) => {
                    const option = new Option(value['sub_jenis'], key, false, false);
                    subJenisSelect.append(option);
                });
            }

            // Refresh select2 untuk sub jenis
            subJenisSelect.trigger('change');
        }

        // Event listener untuk perubahan jenis pekerjaan
        subJenisSelect.on('change', function() {
            const selectedSubJenis = $(this).val();
            updatePekerjaanSelect(selectedSubJenis);
        });

        // Fungsi untuk memperbarui pekerjaan
        function updatePekerjaanSelect(selectedSubJenis) {
            // Kosongkan opsi sebelumnya
            pekerjaanSelect.empty().append('<option value="">-- Pilih Pekerjaan --</option>');

            // Cek apakah pekerjaan data tersedia
            if (subJenisData[jenis2Select.val()] && subJenisData[jenis2Select.val()]['subjenis_pekerjaan'][selectedSubJenis]) {
                // Iterasi dan tambahkan setiap pekerjaan ke dropdown
                Object.entries(subJenisData[jenis2Select.val()]['subjenis_pekerjaan'][selectedSubJenis]['pekerjaan']).forEach(([key, value]) => {
                    const option = new Option(value['nama'], value['id'], false, false);
                    pekerjaanSelect.append(option);
                });
            }

            // Refresh select2 untuk pekerjaan
            pekerjaanSelect.trigger('change');
        }

        // Focus on the search input when the dropdown is opened
        $('#jenis2').on('select2:open', function() {
            // Focus on the search input field
            setTimeout(function() {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 100); // Add a slight delay to ensure the dropdown is fully rendered
        });
        // Focus on the search input when the dropdown is opened
        $('#sub_jenis').on('select2:open', function() {
            // Focus on the search input field
            setTimeout(function() {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 100); // Add a slight delay to ensure the dropdown is fully rendered
        });
        // Focus on the search input when the dropdown is opened
        $('#id_pekerjaan').on('select2:open', function() {
            // Focus on the search input field
            setTimeout(function() {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 100); // Add a slight delay to ensure the dropdown is fully rendered
        });
    });
</script>
<?= $this->endSection(); ?>