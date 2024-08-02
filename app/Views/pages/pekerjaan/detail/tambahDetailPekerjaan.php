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
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemTypeSelect = document.getElementById('item_type');
        const itemSelect = document.getElementById('item_id');

        const items = <?= json_encode($items); ?>; // Data items dari PHP

        itemTypeSelect.addEventListener('change', function() {
            const selectedType = itemTypeSelect.value;
            updateItemSelect(selectedType);
        });

        function updateItemSelect(selectedType) {
            // Clear previous options
            itemSelect.innerHTML = '<option value="">-- Pilih Item --</option>';

            // Filter items based on selected type
            const filteredItems = items.filter(item => item.jenis === selectedType);

            // Populate the item dropdown
            filteredItems.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = `${item.nama} (${item.jenis})`;
                itemSelect.appendChild(option);
            });
        }
    });
</script>

<?= $this->endSection(); ?>