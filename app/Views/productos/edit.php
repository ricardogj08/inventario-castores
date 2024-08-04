<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Editar Producto<?= $this->endSection() ?>

<?= $this->section('dashboard_content') ?>
    <div class="flex items-center justify-between flex-wrap gap-4">
        <h1 class="card-title">Editar Producto</h1>

        <a href="<?= url_to('productos.index') ?>" class="btn btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Volver
        </a>
    </div>

    <div class="divider"></div>

    <!-- Formulario de modificación de productos -->
    <?= form_open(url_to('productos.update', $product['id'])) ?>
        <div class="grid md:grid-cols-2 gap-2 mb-2">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Nombre:</span>
                </div>
                <input
                    type="text"
                    name="nombre"
                    required
                    maxlength="40"
                    <?= $userAuthRol === 'Almacenista' ? 'disabled' : '' ?>
                    value="<?= set_value('nombre', $product['nombre']) ?>"
                    placeholder="Escribe el nombre del producto"
                    class="input input-bordered w-full">
                <div class="label">
                    <span class="label-text-alt"><?= validation_show_error('nombre', 'field') ?></span>
                </div>
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Precio:</span>
                </div>
                <input
                    type="text"
                    name="precio"
                    required
                    pattern="^\d{1,14}(\.\d{1,2})?$"
                    <?= $userAuthRol === 'Almacenista' ? 'disabled' : '' ?>
                    value="<?= set_value('precio', $product['precio']) ?>"
                    placeholder="$ 0.00"
                    class="input input-bordered w-full">
                <div class="label">
                    <span class="label-text-alt"><?= validation_show_error('precio', 'field') ?></span>
                </div>
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Inventario:</span>
                </div>
                <input
                    type="number"
                    disabled
                    value="<?= esc($product['cantidad']) ?>"
                    class="input input-bordered w-full">
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Fecha de registro:</span>
                </div>
                <input
                    type="datetime"
                    disabled
                    value="<?= esc($product['fecha_registro']) ?>"
                    class="input input-bordered w-full">
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Cantidad de entrada:</span>
                </div>
                <input
                    type="number"
                    name="cantidad"
                    required
                    step="1"
                    min="0"
                    value="<?= set_value('cantidad', 0) ?>"
                    placeholder="0"
                    class="input input-bordered w-full">
                <div class="label">
                    <span class="label-text-alt"><?= validation_show_error('cantidad', 'field') ?></span>
                </div>
            </label>

            <div class="form-control w-full">
                <div class="label">
                    <span class="label-text">Estatus:</span>
                </div>
                <label class="label cursor-pointer">
                    <span class="label-text">Activar:</span>
                    <input
                        type="checkbox"
                        name="estatus"
                        <?= $userAuthRol === 'Almacenista' ? 'disabled' : '' ?>
                        value="1"
                        <?= set_checkbox('estatus', '1', $product['estatus']) ?>
                        class="toggle">
                </label>
                <div class="label">
                    <span class="label-text-alt"><?= validation_show_error('estatus', 'field') ?></span>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-2 justify-end">
            <input type="submit" value="Guardar" class="btn btn-primary text-neutral-content">
            <a href="<?= url_to('productos.index') ?>" class="btn btn-secondary text-neutral-content">Cancelar</a>
        </div>
    <?= form_close() ?>
<?= $this->endSection() ?>
