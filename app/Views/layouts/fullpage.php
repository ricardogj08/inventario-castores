<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
    <?= $this->renderSection('fullpage_content') ?>

    <?= $this->include('layouts/footer') ?>
<?= $this->endSection() ?>

