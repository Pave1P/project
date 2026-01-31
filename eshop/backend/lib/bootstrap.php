<?php
declare(strict_types=1);

function bootstrap(string $application): array
{
    // Название страницы
    $pageTitle = 'eShop24 - '.$application;

    // Данные для инициализации Vue
    $pageData = require __DIR__ . '/../config/data.php';

    // Конфигурационный файл
    $config = require __DIR__ . '/../config/settings.php';

    $debug = (bool)($config['debug']['value'] ?? false);
    if ($debug)
    {
        $viteHost = (string)($config['debug']['viteHost'] ?? false);
        $vitePort = (integer)($config['debug']['vitePort'] ?? false);

        $jsFiles = [
            "http://{$viteHost}:{$vitePort}/@vite/client",
            "http://{$viteHost}:{$vitePort}/src/application/{$application}.js",
        ];

        return [$pageTitle, $pageData, [], $jsFiles];
    }

    // PROD: manifest
    $manifestPath = resolve_manifest_path();
    if (!is_file($manifestPath)) {
        throw new RuntimeException("Vite manifest not found: {$manifestPath}");
    }

    $manifest = json_decode((string)file_get_contents($manifestPath), true);
    if (!is_array($manifest)) {
        throw new RuntimeException("Vite manifest is not valid JSON: {$manifestPath}");
    }

    $entryKey = "src/application/{$application}.js";
    if (!isset($manifest[$entryKey])) {
        throw new RuntimeException("Vite manifest entry not found for key: {$entryKey}");
    }

    $jsFile = $manifest[$entryKey]['file'] ?? null;
    if (!is_string($jsFile) || $jsFile === '') {
        throw new RuntimeException("Vite manifest entry has no 'file' for key: {$entryKey}");
    }

    $cssFiles = collect_css_recursive($manifest, $entryKey);
    $cssFiles = array_values(array_unique($cssFiles));

    $jsFiles = [$jsFile];

    return [$pageTitle, $pageData, $cssFiles, $jsFiles];
}

function resolve_manifest_path(): string
{
    return dirname(__DIR__, 2) . '/public/.vite/manifest.json';
}

function collect_css_recursive(array $manifest, string $key, array &$visited = []): array
{
    if (isset($visited[$key])) {
        return [];
    }
    $visited[$key] = true;

    if (!isset($manifest[$key]) || !is_array($manifest[$key])) {
        return [];
    }

    $item = $manifest[$key];

    $css = [];
    if (isset($item['css']) && is_array($item['css'])) {
        $css = $item['css'];
    }

    if (isset($item['imports']) && is_array($item['imports'])) {
        foreach ($item['imports'] as $import) {
            if (is_string($import) && $import !== '') {
                $css = array_merge($css, collect_css_recursive($manifest, $import, $visited));
            }
        }
    }

    return $css;
}