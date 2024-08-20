<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">

        <div class="mb-3 text-center">
            <h4><?= esc($title); ?></h4>
        </div>
        <div class="row d-flex align-items-stretch h-100">

            <div class="col-lg-4 mb-3">
                <div class="card mb-4 h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                        <?php
                        $avatar = session()->get('avatar') ? session()->get('avatar') : 'profil.png';
                        ?>
                        <form id="avatarForm" action="/update-akun" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="username" value="<?= esc($user['username']); ?>">
                            <input type="hidden" name="nama" value="<?= esc($user['nama']); ?>">
                            <input type="hidden" name="role" value="<?= esc($user['role']); ?>">
                            <input type="hidden" name="password" value="<?= esc($user['password']); ?>">
                            <input type="hidden" name="jabatan" value="<?= esc($user['jabatan']); ?>">
                            <label for="avatar" class="avatar-label">
                                <div class="gambar">
                                    <img src="/uploads/avatars/<?= esc($avatar); ?>" alt="avatar" class="rounded-circle img-fluid image" style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;" />
                                    <div class="middle" style="cursor: pointer;">
                                        <div class="text">Tambahkan Gambar</div>
                                    </div>
                                </div>
                            </label>
                            <input type="file" class="form-control mt-3 d-none" id="avatar" name="avatar" accept="image/*" onchange="submitAvatarForm()">
                        </form>
                        <h5 class="my-3"><?= esc($user['nama']); ?></h5>
                        <p class="text-muted mb-1"><?= esc($user['role']); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 mb-3">
                <div class="card border-0 h-100">
                    <div class="card-header">
                        <h5 class="card-title">Kelola Akun</h5>
                    </div>
                    <div class="card-body">
                        <form action="/update-akun" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="role" value="<?= esc($user['role']); ?>">
                            <input type="hidden" name="avatar" value="<?= esc($user['avatar']); ?>">
                            <input type="hidden" name="jabatan" value="<?= esc($user['jabatan']); ?>">
                            <input type="hidden" name="nama" value="<?= esc($user['nama']); ?>">
                            <div class="mb-3 row">
                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="username" name="username" value="<?= esc($user['username']); ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="password" name="password" value="<?= esc($user['password']); ?>">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<style>
    .gambar {
        position: relative;
    }

    .image {
        opacity: 1;
        display: block;
        width: 100%;
        height: auto;
        transition: .5s ease;
        backface-visibility: hidden;
    }

    .middle {
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%)
    }

    .gambar:hover .image {
        opacity: 0.3;
    }

    .gambar:hover .middle {
        opacity: 1;
    }

    .text {
        color: black;
        font-size: 12px;
        padding: 16px 32px;
    }
</style>
<script>
    function submitAvatarForm() {
        document.getElementById('avatarForm').submit();
    }
</script>

<?= $this->endSection(); ?>