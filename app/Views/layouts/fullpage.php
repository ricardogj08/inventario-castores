<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
    <!-- Plantilla base para todas las páginas genéricas -->
    <div class="min-h-screen flex flex-col">
        <?= $this->renderSection('fullpage_content') ?>

        <?= $this->include('layouts/footer') ?>
    </div>
<?= $this->endSection() ?>
