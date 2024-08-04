<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Inventario<?= $this->endSection() ?>

<?= $this->section('dashboard_content') ?>
    <div class="flex items-center justify-between flex-wrap gap-y-4">
        <h1 class="card-title">Inventario</h1>

        <a href="<?= url_to('productos.new') ?>" class="btn btn-primary text-neutral-content">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd"/>
            </svg>
            Nuevo producto
        </a>
    </div>

    <div class="divider"></div>

    <!-- Tabla de productos -->
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Status</th>
                    <th>Fecha de registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr class="hover">
                    <th><?= $product['id'] ?></th>
                    <td><?= esc($product['nombre']) ?></td>
                    <td><?= $product['precio'] ?></td>
                    <td><?= $product['cantidad'] ?></td>
                    <td><?= $product['estatus'] ?></td>
                    <td><?= $product['fecha_registro'] ?></td>
                    <td></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>
