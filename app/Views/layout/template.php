<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" />
    <script src="https://kit.fontawesome.com/b2130b7ab2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/style.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/css/sweetalert2.min.css" />
    <script src="/js/sweetalert2.all.min.js"></script>
    <script src="/js/myscript.js"></script>
</head>

<body>
    <div class="wrapper">

        <?= $this->include('layout/sidebar'); ?>
        <div class="main">
            <?= $this->include('layout/navbar'); ?>
            <?= $this->renderSection('content'); ?>
            <?= $this->include('layout/footer'); ?>

        </div>
    </div>
    <!-- Cek apakah ada pesan flash sukses -->
    <script>
        // Cek apakah ada pesan flash sukses
        <?php if (session()->getFlashdata('success')) : ?>
            showSuccessToast('<?= session()->getFlashdata('success'); ?>');
        <?php endif; ?>

        // Cek apakah ada pesan flash error
        <?php if (session()->getFlashdata('error')) : ?>
            showErrorToast('<?= session()->getFlashdata('error'); ?>');
        <?php endif; ?>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/script.js"></script>


</body>

</html>