<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Movimientos<?= $this->endSection() ?>

<?= $this->section('dashboard_content') ?>
    <h1 class="card-title">Movimientos</h1>

    <div class="divider"></div>

    <!-- Formulario de los filtros de búsqueda -->
    <?= form_open(current_url(), ['method' => 'get', 'class' => 'flex item-center gap-2 flex-wrap']) ?>
        <select name="search[idTipoMovimiento]" class="select select-bordered w-full max-w-xs">
            <option selected>Tipos de movimientos</option>
            <?php foreach ($typesTransactions as $typeTransaction): ?>
                <option value="<?= esc($typeTransaction['id']) ?>"><?= esc($typeTransaction['nombre']) ?></option>
            <?php endforeach ?>
        </select>

        <button type="submit" class="btn btn-secondary text-neutral-content">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z" clip-rule="evenodd" />
            </svg>
            Filtrar
        </button>
    <?= form_close() ?>

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
