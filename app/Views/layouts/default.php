<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($this->renderSection('title')) ?></title>
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%2210 0 100 100%22><text y=%22.90em%22 font-size=%2290%22>🦫</text></svg>"></link>
</head>
<body class="bg-base-200">
    <!-- Plantilla base para todas las plantillas -->
    <?= $this->renderSection('content') ?>

    <!-- Muestra mensajes de alerta -->
    <?php foreach(['info', 'success', 'warning', 'error', 'default'] as $type): ?>
        <?php if (! empty(session()->getFlashdata($type))): ?>
            <?= view_cell('AlertMessageCell', [
                'type'    => $type,
                'message' => session()->getFlashdata($type),
            ]) ?>
        <?php endif ?>
    <?php endforeach ?>
</body>
</html>
