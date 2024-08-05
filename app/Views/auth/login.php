<?= $this->extend('layouts/fullpage') ?>

<?= $this->section('title') ?>Iniciar sesión<?= $this->endSection() ?>

<?= $this->section('fullpage_content') ?>
    <!-- Card del formulario de inicio de sesión -->
    <main class="card bg-base-100 shadow-xl sm:w-full sm:max-w-xl sm:mx-auto mx-4 my-auto">
        <div class="card-body">
            <h1 class="card-title">Iniciar sesión</h1>

            <!-- Formulario de inicio de sesión -->
            <?= form_open(url_to('auth.loginAction'), ['class' => 'flex flex-col gap-y-2']) ?>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Email:</span>
                    </div>
                    <input
                        type="text"
                        name="correo"
                        required
                        maxlength="50"
                        value="<?= set_value('correo') ?>"
                        placeholder="Escribe tu correo electrónico"
                        class="input input-bordered w-full">
                    <div class="label">
                        <span class="label-text-alt"><?= validation_show_error('correo', 'field') ?></span>
                    </div>
                </label>

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Contraseña:</span>
                    </div>
                    <input
                        type="password"
                        name="contrasena"
                        required
                        maxlength="25"
                        value=""
                        placeholder="Escribe tu contraseña"
                        class="input input-bordered w-full">
                    <div class="label">
                        <span class="label-text-alt"><?= validation_show_error('contrasena', 'field') ?></span>
                    </div>
                </label>

                <input type="submit" value="Ingresar" class="btn btn-primary btn-block text-neutral-content">
            <?= form_close() ?>
        </div>
    </main>
<?= $this->endSection() ?>
