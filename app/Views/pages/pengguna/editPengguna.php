<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= esc($title); ?></h4>
        </div>
        <!-- Form Element -->
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Form <?= $title; ?></h5>
            </div>
            <div class="card-body">
                <?php if (session()->has('error')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->get('error'); ?>
                    </div>
                <?php endif; ?>
                <form action="/kelola-pengguna/update/<?= $user['id']; ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= esc($user['username']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= esc($user['nama']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="Admin" <?= ($user['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="Kepala Regu" <?= ($user['role'] == 'Kepala Regu') ? 'selected' : ''; ?>>Kepala Regu</option>
                            <option value="Kasi" <?= ($user['role'] == 'Kasi') ? 'selected' : ''; ?>>Kasi</option>
                            <option value="Kabag" <?= ($user['role'] == 'Kabag') ? 'selected' : ''; ?>>Kabag</option>
                            <option value="Dirtek" <?= ($user['role'] == 'Dirtek') ? 'selected' : ''; ?>>Dirtek</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password" value="<?= esc($user['password']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= esc($user['jabatan']); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="/kelola-pengguna" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>