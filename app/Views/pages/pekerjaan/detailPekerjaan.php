<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 text-center">
            <h4><?= esc($title); ?></h4>
        </div>
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title"><?= esc($pekerjaan['nama_pekerjaan']); ?></h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Item</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Volume</th>
                            <th scope="col">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php if (!empty($items) && is_array($items)) : ?>
                            <?php foreach ($items as $item) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= esc($item['item_name']); ?></td>
                                    <td>Rp. <?= esc(number_format($item['price'], 2, ',', '.')); ?></td>
                                    <td><?= esc($item['volume']); ?></td>
                                    <td>Rp. <?= esc(number_format($item['total_price'], 2, ',', '.')); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="2" class="text-center">No items found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>