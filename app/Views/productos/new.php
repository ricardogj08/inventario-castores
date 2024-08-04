<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Nuevo producto<?= $this->endSection() ?>

<?= $this->section('dashboard_content') ?>
    <?= form_open(url_to('productos.create'), ['class' => 'flex flex-col gap-y-4']) ?>
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Nombre:</span>
            </div>
            <input
                type="text"
                name="name"
                value="<?= set_value('name') ?>"
                placeholder="Escribe el nombre del producto"
                class="input input-bordered w-full">
            <div class="label">
                <span class="label-text-alt"><?= validation_show_error('name', 'field') ?></span>
            </div>
        </label>

        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Precio:</span>
            </div>
            <input
                type="text"
                name="price"
                pattern="\d{1,14}(\.\d{1,2})?"
                value="<?= set_value('price') ?>"
                placeholder="$ 0.00"
                class="input input-bordered w-full">
            <div class="label">
                <span class="label-text-alt"><?= validation_show_error('name', 'field') ?></span>
            </div>
        </label>

        <input type="submit" value="Guardar" class="btn btn-primary btn-block text-neutral-content">
    <?= form_close() ?>
<?= $this->endSection() ?>
