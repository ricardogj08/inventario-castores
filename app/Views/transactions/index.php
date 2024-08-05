<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Movimientos<?= $this->endSection() ?>

<?= $this->section('dashboard_content') ?>
    <h1 class="card-title">Movimientos</h1>

    <div class="divider"></div>

    <?= validation_list_errors('group') ?>

    <!-- Formulario de los filtros de búsqueda -->
    <?= form_open(current_url(), ['method' => 'get', 'class' => 'flex items-end gap-2 flex-wrap']) ?>
        <label class="form-control w-full max-w-xs">
            <div class="label">
                <span class="label-text">Tipo de movimiento:</span>
            </div>
            <select name="search[idTipoMovimiento]" class="select select-bordered">
                <option value="" selected>Todos</option>
                <?php foreach ($typesTransactions as $transactionType): ?>
                    <option
                        value="<?= esc($transactionType['idTipoMovimiento']) ?>"
                        <?= $transactionType['idTipoMovimiento'] === $filters['search[idTipoMovimiento]'] ? 'selected' : '' ?>>
                        <?= esc($transactionType['nombre']) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </label>

        <button type="submit" class="btn btn-secondary text-neutral-content">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z" clip-rule="evenodd" />
            </svg>
            Filtrar
        </button>

        <a href="<?= url_to('transactions.index') ?>" class="btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
            Limpiar
        </a>
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
                    <th>Fecha de Modificación</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr class="hover">
                        <th><?= esc($transaction['idMovimiento']) ?></th>
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
                        <td><?= esc($transaction['fecha_modificacion']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>
