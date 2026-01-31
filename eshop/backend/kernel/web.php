<?php
declare(strict_types=1);

Use Eshop\App;

if (!isset($application) || !is_string($application) || $application === '') {
    throw new RuntimeException('Application is not specified ($application).');
}

require_once __DIR__ . '/../boot.php';


$app = new App($application);

[$pageTitle, $pageData, $cssFiles, $jsFiles] = $app->bootstrap();


?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars((string)$pageTitle, ENT_QUOTES, 'UTF-8') ?></title>

  <script>
    window.__APP_DATA__ = <?= json_encode($pageData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
  </script>

  <?php foreach ($cssFiles as $css): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars((string)$css, ENT_QUOTES, 'UTF-8') ?>">
  <?php endforeach; ?>

  <?php foreach ($jsFiles as $js): ?>
    <script type="module" src="<?= htmlspecialchars((string)$js, ENT_QUOTES, 'UTF-8') ?>"></script>
  <?php endforeach; ?>
</head>
<body id="application"></body>
</html>