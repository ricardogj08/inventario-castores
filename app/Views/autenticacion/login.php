<?= $this->extend('layouts/default') ?>

<?= $this->section('title') ?>Iniciar sesión<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card bg-base-100 shadow-xl sm:w-full sm:max-w-xl sm:mx-auto mx-4 my-auto">
        <div class="card-body">
            <h1 class="card-title">Iniciar sesión</h1>

            <form method="post" action="<?= url_to('autenticacion.loginAction') ?>" class="flex flex-col gap-y-4">
                <?= csrf_field() ?>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Email:</span>
                    </div>
                    <input
                        type="text"
                        name="email"
                        placeholder="Escribe tu correo electrónico"
                        class="input input-bordered w-full">
                </label>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Contraseña:</span>
                    </div>
                    <input
                        type="password"
                        name="password"
                        placeholder="Escribe tu contraseña"
                        class="input input-bordered w-full">
                </label>
                <input type="submit" value="Ingresar" class="btn btn-primary btn-block text-neutral-content">
            </form>
        </div>
    </div>
<?= $this->endSection() ?>
