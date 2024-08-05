<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Movimientos<?= $this->endSection() ?>

<?= $this->section('dashboard_content') ?>
    <h1 class="card-title">Movimientos</h1>

    <div class="divider"></div>

    <!-- Tabla de movimientos -->
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Tipo</th>
                    <th>Usuario</th>
                    <th>Fecha de registro</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr class="hover">
                        <th><?= esc($transaction['id']) ?></th>
                        <td><?= esc($transaction['producto']) ?></td>
                        <td><?= esc($transaction['cantidad']) ?></td>
                        <td>
                            <?php if ($transaction['tipo'] === 'Entrada'): ?>
                                <div class="badge badge-success">
                            <?php else: ?>
                                <div class="badge badge-info">
                            <?php endif ?>
                                <?= esc($transaction['tipo']) ?>
                            <div>
                        </td>
                        <td><?= esc($transaction['usuario']) ?></td>
                        <td><?= esc($transaction['fecha_registro']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>
