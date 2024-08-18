<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= $title; ?></h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card w-100">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-3">
                                <div class="p-3 m-1">
                                    <p>Daftar Material</p>
                                    <h4><?= $allMaterial; ?></h4>
                                    <p class="mb-0">+<?= $materialsThisMonth; ?> bulan ini</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="p-3 m-1">
                                    <p>Daftar Upah</p>
                                    <h4><?= $allUpah; ?></h4>
                                    <p class="mb-0">+<?= $pekerjasThisMonth; ?> bulan ini</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="p-3 m-1">
                                    <p>Daftar Pekerjaan</p>
                                    <h4><?= $allPekerjaan; ?></h4>
                                    <p class="mb-0">+<?= $pekerjaansThisMonth; ?> bulan ini</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="p-3 m-1">
                                    <p>Daftar RAB</p>
                                    <h4><?= $allRab; ?></h4>
                                    <p class="mb-0">+<?= $rabsThisMonth; ?> bulan ini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Table Element -->
        <div class="row">
            <div class="col-xl-9">
                <div class="card border-0">
                    <div class="card-header">
                        <h5 class="card-title">Proyek Tahun 2024</h5>
                    </div>
                    <div class="card-body" style="height: 320px">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>

            <?php
            function timeAgo($timestamp)
            {
                $time = strtotime($timestamp);
                $currentTime = time();
                $diff = $currentTime - $time;

                $units = [
                    'tahun' => 31536000, // seconds in a year
                    'bulan' => 2592000,  // seconds in a month
                    'minggu' => 604800,  // seconds in a week
                    'hari' => 86400,     // seconds in a day
                    'jam' => 3600,       // seconds in an hour
                    'menit' => 60,       // seconds in a minute
                    'detik' => 1         // seconds
                ];

                foreach ($units as $unit => $value) {
                    if ($diff >= $value) {
                        $count = floor($diff / $value);
                        return "$count $unit" . " yang lalu";
                    }
                }

                return "baru saja"; // Just now
            }
            ?>

            <div class="col-xl-3">
                <div class="card border-0">
                    <div class="card-header">
                        <h5 class="card-title">Pemberitahuan</h5>
                    </div>
                    <div class="card-body" style="height: 320px; overflow-y: auto;">
                        <div class="list-group">
                            <?php if (isset($role) && $role == "Kepala Regu" && count($rabsNoStatus ?? []) > 0) : ?>
                                <a href="/daftar-rab?filter=dibuat" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">RAB</h5>
                                        <small class="text-muted"><?php echo timeAgo($noStatusDate); ?></small>
                                    </div>
                                    <p class="mb-1">Rab Belum Diajukan.</p>
                                    <small><?php echo count($rabsNoStatus); ?> RAB belum diajukan untuk diverifikasi.</small>
                                </a>
                            <?php endif; ?>

                            <?php if (isset($role) && $role == "Kepala Regu" && count($rabsDitolak ?? []) > 0) : ?>
                                <a href="/daftar-rab?filter=dibuat" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">RAB</h5>
                                        <small class="text-muted"><?php echo timeAgo($ditolakDate); ?></small>
                                    </div>
                                    <p class="mb-1">RAB Ditolak</p>
                                    <small><?php echo count($rabsDitolak); ?> RAB ditolak.</small>
                                </a>
                            <?php endif; ?>

                            <?php if (isset($role) && $role == "Kasi" && count($rabsDibuat ?? []) > 0) : ?>
                                <a href="/daftar-rab?filter=dibuat" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">RAB</h5>
                                        <small class="text-muted"><?php echo timeAgo($dibuatDate); ?></small>
                                    </div>
                                    <p class="mb-1">RAB Siap Diverifikasi</p>
                                    <small class="text-muted"><?php echo count($rabsDibuat); ?> RAB dibuat. Siap untuk diverifikasi.</small>
                                </a>
                            <?php endif; ?>

                            <?php if (isset($role) && $role == "Kabag" && count($rabsDiperiksa ?? []) > 0) : ?>
                                <a href="/daftar-rab?filter=diperiksa" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">RAB</h5>
                                        <small class="text-muted"><?php echo timeAgo($diperiksaDate); ?></small>
                                    </div>
                                    <p class="mb-1">RAB Siap Diverifikasi</p>
                                    <small class="text-muted"><?php echo count($rabsDiperiksa); ?> RAB siap untuk diverifikasi.</small>
                                </a>
                            <?php endif; ?>

                            <?php if (isset($role) && $role == "Dirtek" && count($rabsDisetujui ?? []) > 0) : ?>
                                <a href="/daftar-rab?filter=diverifikasi" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">RAB</h5>
                                        <small class="text-muted"><?php echo timeAgo($disetujuiDate); ?></small>
                                    </div>
                                    <p class="mb-1">RAB Siap Diverifikasi</p>
                                    <small class="text-muted"><?php echo count($rabsDisetujui); ?> RAB siap untuk diverifikasi.</small>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        var ctx = document.getElementById('myChart').getContext('2d');
        var chartData = <?php echo json_encode($chartData); ?>;
        var labels = [];
        var data = [];

        chartData.forEach(item => {
            labels.push(item.bulan);
            data.push(item.jumlah);
        });

        var myChart = new Chart(ctx, {
            type: 'line', // bisa juga 'line', 'pie', dll.
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<?= $this->endSection(); ?>