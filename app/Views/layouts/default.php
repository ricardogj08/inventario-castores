<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($this->renderSection('title')) ?></title>
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body class="bg-base-200 min-h-screen flex flex-col">
    <?= $this->renderSection('content') ?>

    <footer class="footer footer-center bg-base-300 text-base-content p-4 mt-auto">
        <aside>
            <p>Copyright © 2024 - Todos los derechos reservados Ricardo García Jiménez</p>
        </aside>
    </footer>
</body>
</html>
