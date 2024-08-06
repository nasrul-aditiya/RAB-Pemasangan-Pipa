<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= esc($title); ?></h4>
        </div>
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Form <?= esc($title); ?></h5>
            </div>
            <div class="card-body">
                <form action="/kelola-pengguna/store" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <select name="role" class="form-select my-4 py-2" aria-label="Role" required>
                        <option selected disabled>-- Pilih Role --</option>
                        <option value="Admin">Admin</option>
                        <option value="Kepala Regu">Kepala Regu</option>
                        <option value="Kasi">Kasi</option>
                        <option value="Kabag">Kabag</option>
                        <option value="Dirtek">Dirtek</option>
                    </select>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah</button>

                </form>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>