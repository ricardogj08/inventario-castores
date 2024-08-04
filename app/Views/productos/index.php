<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Inventario<?= $this->endSection() ?>

<?= $this->section('dashboard_content') ?>
    <div class="flex items-center justify-between flex-wrap gap-4">
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
                    <th><?= esc($product['id']) ?></th>
                    <td><?= esc($product['nombre']) ?></td>
                    <td><?= esc($product['precio']) ?></td>
                    <td><?= esc($product['cantidad']) ?></td>
                    <td>
                        <?php if (empty($product['estatus'])): ?>
                            <div class="badge badge-error">Inactivo</div>
                        <?php else: ?>
                            <div class="badge badge-success">Activo</div>
                        <?php endif ?>
                    </td>
                    <td><?= esc($product['fecha_registro']) ?></td>
                    <td>
                        <a href="<?= url_to('productos.edit', $product['id']) ?>" class="btn btn-circle btn-info btn-outline btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>
