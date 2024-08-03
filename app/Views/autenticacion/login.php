<?= $this->extend('layouts/default') ?>

<?= $this->section('title') ?>Iniciar sesión<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card bg-base-100 shadow-xl sm:w-full sm:max-w-xl sm:mx-auto mx-4 my-auto">
        <div class="card-body">
            <?php if (! empty(session()->getFlashdata('error'))): ?>
                <?= view_cell('AlertMessageCell', [
                    'type'    => 'error',
                    'message' => session()->getFlashdata('error'),
                ]) ?>
            <?php endif ?>

            <h1 class="card-title">Iniciar sesión</h1>

            <?= form_open(url_to('autenticacion.loginAction'), ['class' => 'flex flex-col gap-y-2']) ?>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Email:</span>
                    </div>
                    <input
                        type="text"
                        name="email"
                        required
                        maxlength="50"
                        value="<?= set_value('email') ?>"
                        placeholder="Escribe tu correo electrónico"
                        class="input input-bordered w-full">
                    <div class="label">
                        <span class="label-text-alt"><?= validation_show_error('email', 'field') ?></span>
                    </div>
                </label>

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Contraseña:</span>
                    </div>
                    <input
                        type="password"
                        name="password"
                        required
                        value=""
                        maxlength="25"
                        placeholder="Escribe tu contraseña"
                        class="input input-bordered w-full">
                    <div class="label">
                        <span class="label-text-alt"><?= validation_show_error('password', 'field') ?></span>
                    </div>
                </label>

                <input type="submit" value="Ingresar" class="btn btn-primary btn-block text-neutral-content">
            <?= form_close() ?>
        </div>
    </div>
<?= $this->endSection() ?>
