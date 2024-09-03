<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= esc($title); ?></h4>
        </div>
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Edit Detail Pekerjaan untuk <?= esc($rab['nama_pekerjaan']); ?></h5>
            </div>
            <div class="card-body">
                <form action="/daftar-rab/detail/update/<?= esc($detail['id']); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" value="<?= esc($detail['id']); ?>">
                    <input type="hidden" name="id_rab" value="<?= esc($rab['id']); ?>">

                    <!-- Dropdown untuk Jenis Pekerjaan -->
                    <div class="form-group">
                        <label for="jenis2">Pilih Jenis Pekerjaan:</label>
                        <select name="jenis2" id="jenis2" class="form-control" required>
                            <option value="">-- Pilih Jenis Pekerjaan --</option>
                            <?php foreach ($jenis_pekerjaan as $key => $value) : ?>
                                <option value="<?= esc($key); ?>" <?= $key == $selected_jenis ? 'selected' : ''; ?>>
                                    <?= esc($value['jenis_pekerjaan']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Dropdown untuk Pekerjaan -->
                    <div class="form-group">
                        <label for="id_pekerjaan">Pilih Item Pekerjaan:</label>
                        <select name="id_pekerjaan" id="id_pekerjaan" class="form-control" required>
                            <option value="">-- Pilih Pekerjaan --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jenis_pekerjaan">Pilih Jenis Pekerjaan:</label>
                        <select name="jenis_pekerjaan" id="jenis_pekerjaan" class="form-control" required>
                            <option value="">-- Pilih Jenis Pekerjaan --</option>
                            <?php foreach ($jenis_pekerjaan_rab as $key => $value) : ?>
                                <option value="<?= esc($key); ?>" <?= $key == $selected_jenis ? 'selected' : ''; ?>>
                                    <?= esc($value['jenis_pekerjaan']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subjenis_pekerjaan">Pilih Sub Jenis Pekerjaan:</label>
                        <select name="subjenis_pekerjaan" id="subjenis_pekerjaan" class="form-control" required>
                            <option value="">-- Pilih Sub Jenis Pekerjaan --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                        <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan" value="<?= esc($detail['nama_pekerjaan']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="volume" class="form-label">Volume</label>
                        <input type="number" class="form-control" id="volume" name="volume" value="<?= esc($detail['volume']); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="/daftar-rab/detail/<?= $rab['id']; ?>" class="btn btn-secondary">Kembali</a>
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
            placeholder: "-- Pilih Item Jenis Pekerjaan --",
            tags: "true",
            width: "100%"
        });

        $('#id_pekerjaan').select2({
            placeholder: "-- Pilih Item Pekerjaan --",
            width: "100%"
        });

        $('#jenis_pekerjaan').select2({
            placeholder: "-- Pilih Jenis Pekerjaan --",
            tags: "true",
            width: "100%"
        });

        $('#subjenis_pekerjaan').select2({
            placeholder: "-- Pilih Sub Jenis Pekerjaan --",
            tags: "true",
            width: "100%"
        });

        // Ambil elemen select
        const jenis2Select = $('#jenis2');
        const pekerjaanSelect = $('#id_pekerjaan');
        const jenisPekerjaanSelect = $('#jenis_pekerjaan');
        const subJenisPekerjaanSelect = $('#subjenis_pekerjaan');

        // Data sub jenis pekerjaan
        const pekerjaanData = <?= json_encode($jenis_pekerjaan, JSON_HEX_TAG); ?>;
        const pekerjaanDataRab = <?= json_encode($jenis_pekerjaan_rab, JSON_HEX_TAG); ?>;


        // Event listener untuk perubahan jenis pekerjaan
        jenis2Select.on('change', function() {
            const selectedJenis2 = $(this).val();
            updatePekerjaanSelect(selectedJenis2);
        });


        // Fungsi untuk memperbarui sub jenis
        function updatePekerjaanSelect(selectedJenis2) {
            // Kosongkan opsi sebelumnya
            pekerjaanSelect.empty().append('<option value="">-- Pilih Pekerjaan --</option>');

            // Cek apakah sub jenis data tersedia
            if (pekerjaanData[selectedJenis2] && pekerjaanData[selectedJenis2]['pekerjaan']) {
                // Iterasi dan tambahkan setiap sub jenis pekerjaan ke dropdown
                Object.entries(pekerjaanData[selectedJenis2]['pekerjaan']).forEach(([key, value]) => {
                    const option = new Option(value['nama'], value['id'], false, false);
                    pekerjaanSelect.append(option);
                });
            }

            // Refresh select2 untuk sub jenis
            pekerjaanSelect.trigger('change');
        }

        // Event listener untuk perubahan jenis pekerjaan
        jenisPekerjaanSelect.on('change', function() {
            const selectedJenisPekerjaan = $(this).val();
            updateSubJenisPekerjaanSelect(selectedJenisPekerjaan);
        });


        // Fungsi untuk memperbarui sub jenis
        function updateSubJenisPekerjaanSelect(selectedJenisPekerjaan) {
            // Kosongkan opsi sebelumnya
            subJenisPekerjaanSelect.empty().append('<option value="">-- Pilih Sub Jenis Pekerjaan --</option>');

            // Cek apakah sub jenis data tersedia
            if (pekerjaanDataRab[selectedJenisPekerjaan] && pekerjaanDataRab[selectedJenisPekerjaan]['subjenis_pekerjaan']) {
                // Iterasi dan tambahkan setiap sub jenis pekerjaan ke dropdown
                Object.entries(pekerjaanDataRab[selectedJenisPekerjaan]['subjenis_pekerjaan']).forEach(([key, value]) => {
                    const option = new Option(value['sub_jenis'], key, false, false);
                    subJenisPekerjaanSelect.append(option);
                });
            }

            // Refresh select2 untuk sub jenis
            subJenisPekerjaanSelect.trigger('change');
        }


        // Focus on the search input when the dropdown is opened
        $('#jenis2').on('select2:open', function() {
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

        // Focus on the search input when the dropdown is opened
        $('#jenis_pekerjaan').on('select2:open', function() {
            // Focus on the search input field
            setTimeout(function() {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 100); // Add a slight delay to ensure the dropdown is fully rendered
        });
        $('#subjenis_pekerjaan').on('select2:open', function() {
            // Focus on the search input field
            setTimeout(function() {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 100); // Add a slight delay to ensure the dropdown is fully rendered
        });

        // Inisialisasi dropdown dengan nilai yang sudah dipilih sebelumnya jika ada
        const initialJenis = "<?= esc($selected_jenis); ?>";
        const initialPekerjaan = "<?= esc($detail['id_pekerjaan']); ?>";
        const initialJenisPekerjaan = "<?= esc($detail['jenis_pekerjaan']); ?>";
        const initialSubJenisPekerjaan = "<?= esc($detail['subjenis_pekerjaan']); ?>";

        if (initialJenis) {
            jenis2Select.val(initialJenis).trigger('change');
        }

        if (initialPekerjaan) {
            pekerjaanSelect.val(initialPekerjaan).trigger('change');
        }

        if (initialJenisPekerjaan) {
            jenisPekerjaanSelect.val(initialJenisPekerjaan).trigger('change');
        }

        if (initialSubJenisPekerjaan) {
            subJenisPekerjaanSelect.val(initialSubJenisPekerjaan).trigger('change');
        }
    });
</script>
<?= $this->endSection(); ?>