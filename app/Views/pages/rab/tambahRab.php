<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" />

    <title><?= $title; ?></title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            font-size: 0.875rem;
            opacity: 1;
            margin: 0;
            background-color: #3C8DBC;
        }
    </style>
</head>

<body>
    <section>
        <div class="container mt-5 pt-5">
            <div class="row">
                <div class="col-12 col-sm-7 col-md-6 m-auto">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <div class="logo text-center">
                                <img src="/img/logo.png" alt="logo" width="200">
                                <h2><?= $title; ?></h2>
                            </div>
                            <form action="/daftar-rab/store" method="post">
                                <input type="text" name="nama_pekerjaan" id="" class="form-control my-4 py-2" placeholder="Nama Pekerjaan" />
                                <input type="text" name="nama_pekerjaan" id="" class="form-control my-4 py-2" placeholder="Nama Pekerjaan" />
                                <textarea name="lokasi" id="" class="form-control my-4 py-2" placeholder="Lokasi"></textarea>
                                <input type="date" name="tanggal" id="" class="form-control my-4 py-2" placeholder="Tanggal" />
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>

</html>


<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= $title; ?></h4>
        </div>
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Form <?= $title; ?></h5>
            </div>
            <div class="card-body">
                <form action="/daftar-rab/store" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="id_rab" class="form-label">ID RAB</label>
                        <input type="text" class="form-control" id="id_rab" name="id_rab" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                        <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan" required>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <textarea name="lokasi" id="" class="form-control my-4 py-2" placeholder="Lokasi"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="" class="form-control my-4 py-2" placeholder="Tanggal" />
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="/daftar-pekerjaan" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>