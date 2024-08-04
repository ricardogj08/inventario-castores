<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Nuevo producto<?= $this->endSection() ?>

<?= $this->section('dashboard_content') ?>
    <div class="flex items-center justify-between flex-wrap gap-4">
        <h1 class="card-title">Nuevo producto</h1>

        <a href="<?= url_to('productos.index') ?>" class="btn btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Volver
        </a>
    </div>

    <div class="divider"></div>

    <!-- Formulario de registro de nuevos productos -->
    <?= form_open(url_to('productos.create'), ['class' => 'flex flex-col gap-y-2']) ?>
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Nombre:</span>
            </div>
            <input
                type="text"
                name="nombre"
                required
                maxlength="40"
                value="<?= set_value('nombre') ?>"
                placeholder="Escribe el nombre del producto"
                class="input input-bordered input-primary w-full">
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
                pattern="^\d{1,14}(\.\d{1,2})?$"
                required
                value="<?= set_value('precio') ?>"
                placeholder="$ 0.00"
                class="input input-bordered input-primary w-full">
            <div class="label">
                <span class="label-text-alt"><?= validation_show_error('precio', 'field') ?></span>
            </div>
        </label>

        <div class="ml-auto">
            <input type="submit" value="Guardar" class="btn btn-primary text-neutral-content">
            <a href="<?= url_to('productos.index') ?>" class="btn btn-secondary text-neutral-content">Cancelar</a>
        </div>
    <?= form_close() ?>
<?= $this->endSection() ?>
