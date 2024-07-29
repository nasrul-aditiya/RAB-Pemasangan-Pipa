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
                                    <h4><?= $materialsThisMonth; ?></h4>
                                    <p class="mb-0">+<?= $materialsDifference; ?> bulan ini</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="p-3 m-1">
                                    <p>Daftar Upah</p>
                                    <h4><?= $pekerjasThisMonth; ?></h4>
                                    <p class="mb-0">+<?= $pekerjasDifference; ?> bulan ini</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="p-3 m-1">
                                    <p>Daftar Pekerjaan</p>
                                    <h4><?= $pekerjaansThisMonth; ?></h4>
                                    <p class="mb-0">+<?= $pekerjaansDifference; ?> bulan ini</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="p-3 m-1">
                                    <p>Daftar RAB</p>
                                    <h4><?= $rabsThisMonth; ?></h4>
                                    <p class="mb-0">+<?= $rabsDifference; ?> bulan ini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Table Element -->
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title">Proyek Tahun 2024</h5>
            </div>
            <div class="card-body">
                <canvas id="myChart" height="100"></canvas>
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