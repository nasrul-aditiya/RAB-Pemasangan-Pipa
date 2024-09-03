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
                        <label for="item_type" class="form-label">Jenis Item</label>
                        <select class="form-select" id="item_type" name="item_type" required>
                            <option value="">-- Pilih Jenis Item --</option>
                            <option value="material" <?= ($selectedType === 'material') ? 'selected' : ''; ?>>Material</option>
                            <option value="upah" <?= ($selectedType === 'upah') ? 'selected' : ''; ?>>Upah</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="item_id" class="form-label">Nama Item</label>
                        <select class="form-select select2" id="item_id" name="item_id" required>
                            <option value="">-- Pilih Item --</option>
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="koefisien" class="form-label">Koefisien</label>
                        <input type="text" class="form-control" id="koefisien" name="koefisien" value="<?= esc($pekerjaanDetail['koefisien']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="/daftar-pekerjaan/detail/<?= $pekerjaan['id']; ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        const itemTypeSelect = $('#item_type');
        const itemSelect = $('#item_id');

        const items = <?= json_encode($items); ?>; // Data items dari PHP
        const selectedType = '<?= esc($selectedType); ?>'; // Jenis item yang sudah dipilih sebelumnya
        const selectedItem = '<?= esc($pekerjaanDetail['item_id']); ?>'; // Item yang sudah dipilih sebelumnya

        function updateItemSelect(type) {
            // Clear previous options
            itemSelect.empty().append('<option value="">-- Pilih Item --</option>');

            // Filter items based on selected type
            const filteredItems = items.filter(item => item.jenis === type || type === '');

            // Populate the item dropdown
            filteredItems.forEach(item => {
                const option = new Option(`${item.nama}`, item.id);
                itemSelect.append(option);
            });

            // Set the previously selected item
            if (selectedItem) {
                itemSelect.val(selectedItem).trigger('change');
            }
        }

        // Initialize the item dropdown with Select2
        itemSelect.select2({
            placeholder: "-- Pilih Item --",
            allowClear: false,
            width: '100%' // Ensures the dropdown matches the container width
        });

        // Initialize the item dropdown based on the selected type
        updateItemSelect(selectedType);

        // Add event listener to update item dropdown on type change
        itemTypeSelect.on('change', function() {
            const type = itemTypeSelect.val();
            updateItemSelect(type);
        });

        // Focus on the search input when the dropdown is opened
        itemSelect.on('select2:open', function() {
            // Focus on the search input field
            setTimeout(function() {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 100); // Add a slight delay to ensure the dropdown is fully rendered
        });
    });
</script>

<?= $this->endSection(); ?>