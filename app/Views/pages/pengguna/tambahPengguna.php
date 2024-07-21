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
                            <form action="/kelola-pengguna/store" method="post">
                                <input type="text" name="username" id="" class="form-control my-4 py-2" placeholder="Username" />
                                <input type="text" name="nama" id="" class="form-control my-4 py-2" placeholder="Nama" />
                                <select name="role" class="form-select my-4 py-2" aria-label="Role" required>
                                    <option selected disabled>Pilih Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Kepala Regu">Kepala Regu</option>
                                    <option value="Kasi">Kasi</option>
                                    <option value="Kabag">Kabag</option>
                                    <option value="Dirtek">Dirtek</option>
                                </select>
                                <input type="password" name="password" id="" class="form-control my-4 py-2" placeholder="Password" />
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