<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= esc($title); ?></h4>
        </div>
        <!-- Table Element -->
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Tabel <?= esc($title); ?></h5>
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <!-- Button Add -->
                    <div class="col-md-9 text-md-start">
                        <a href="/kelola-pengguna/tambah" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                    </div>
                    <!-- Search Bar -->
                    <div class="col-md-3 text-md-end">
                        <form action="/kelola-pengguna" method="GET" class="form-inline">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th> <!-- Kolom Aksi -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php if (!empty($users) && is_array($users)) : ?>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= esc($user['nama']); ?></td>
                                    <td><?= esc($user['role']); ?></td>
                                    <td>
                                        <a href="/kelola-pengguna/edit/<?= $user['id']; ?>" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="/kelola-pengguna/delete/<?= $user['id']; ?>" class="btn btn-danger btn-hapus"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>