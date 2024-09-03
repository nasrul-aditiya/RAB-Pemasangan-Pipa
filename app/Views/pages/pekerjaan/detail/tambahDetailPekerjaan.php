<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= esc($title); ?></h4>
        </div>
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Tambah Detail Pekerjaan untuk <?= esc($pekerjaan['nama_pekerjaan']); ?></h5>
            </div>
            <div class="card-body">
                <form action="/daftar-pekerjaan/detail/store" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="pekerjaan_id" value="<?= esc($pekerjaan['id']); ?>">

                    <div class="mb-3">
                        <label for="item_type" class="form-label">Jenis Item</label>
                        <select class="form-select" id="item_type" name="item_type" required>
                            <option value="">-- Pilih Jenis Item --</option>
                            <option value="material">Material</option>
                            <option value="upah">Upah</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="item_id" class="form-label">Nama Item</label>
                        <select class="form-select" id="item_id" name="item_id" required>
                            <option value="">-- Pilih Item --</option>
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="koefisien" class="form-label">Koefisien</label>
                        <input type="text" class="form-control" id="koefisien" name="koefisien" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="/daftar-pekerjaan/detail/<?= $pekerjaan['id']; ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Initialize Select2 and handle item type changes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemTypeSelect = document.getElementById('item_type');
        const itemSelect = $('#item_id'); // Use jQuery for Select2

        const items = <?= json_encode($items); ?>; // Data items from PHP

        itemTypeSelect.addEventListener('change', function() {
            const selectedType = itemTypeSelect.value;
            updateItemSelect(selectedType);
        });

        function updateItemSelect(selectedType) {
            // Clear previous options
            itemSelect.empty().append('<option value="">-- Pilih Item --</option>');

            // Filter items based on selected type
            const filteredItems = items.filter(item => item.jenis === selectedType);

            // Populate the item dropdown with filtered items
            filteredItems.forEach(item => {
                const option = new Option(`${item.nama}`, item.id, false, false);
                itemSelect.append(option);
            });

            // Refresh Select2 to show new options
            itemSelect.trigger('change');
        }

        // Initialize Select2 for the Nama Item dropdown
        itemSelect.select2({
            placeholder: "-- Pilih Item --",
            allowClear: false,
            width: '100%' // Ensures the dropdown is as wide as its container
        });

        // Focus on the search input when the dropdown is opened
        itemSelect.on('select2:open', function() {
            // Set a timeout to allow the dropdown to fully render before focusing
            setTimeout(function() {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 100);
        });
    });
</script>

<?= $this->endSection(); ?>