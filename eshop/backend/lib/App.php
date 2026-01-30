<?php

namespace Eshop;

class App
{
    public readonly string $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getTitle(): string
    {
        return 'eShop24 - ' . $this->name;
    }

    public function getPageData(): array
    {
        return [];
    }

    public function getConfig(): array
    {
        return require __DIR__ . '/../config/settings.php';
    }

    public function isDebug(): bool
    {
        return (bool)($config['debug']['value'] ?? false);
    }

    public function getCssFiles()
    {
        if ($this->isDebug()) {
            return [];
        }

        $manifest = $this->getManifest();
        $entryKey = "src/application/{$this->name}.js";

        if (!isset($manifest[$entryKey])) {
            throw new RuntimeException("Vite manifest entry not found for key: {$entryKey}");
        }

        $cssFiles = $this->collectCssRecursive($manifest, $entryKey);

        return array_values(array_unique($cssFiles));
    }

    public function getJsFiles()
    {
        if ($this->isDebug()) {
            $config = $this->getConfig();
            $viteHost = (string)($config['debug']['viteHost'] ?? false);
            $vitePort = (integer)($config['debug']['vitePort'] ?? false);

            return [
                "http://{$viteHost}:{$vitePort}/@vite/client",
                "http://{$viteHost}:{$vitePort}/src/application/{$this->name}.js",
            ];
        }

        $manifest = $this->getManifest();
        $entryKey = "src/application/{$this->name}.js";
        if (!isset($manifest[$entryKey])) {
            throw new RuntimeException("Vite manifest entry not found for key: {$entryKey}");
        }

        $jsFile = $manifest[$entryKey]['file'] ?? null;
        if (!is_string($jsFile) || $jsFile === '') {
            throw new RuntimeException("Vite manifest entry has no 'file' for key: {$entryKey}");
        }
        return  [$jsFile];
    }

    public function bootstrap(): array
    {
        return [
          $this->getTitle(),
          $this->getPageData(),
          $this->getCssFiles(),
          $this->getJsFiles(),
        ];
    }

    protected function getManifest(): array
    {
        $manifestPath = PROJECT_ROOT . '/public/.vite/manifest.json';
        if (!is_file($manifestPath)) {
            throw new RuntimeException("Vite manifest not found: {$manifestPath}");
        }

        $manifest = json_decode((string)file_get_contents($manifestPath), true);
        if (!is_array($manifest)) {
            throw new RuntimeException("Vite manifest is not valid JSON: {$manifestPath}");
        }

        return $manifest;
    }

    protected function collectCssRecursive(array $manifest, string $key, array &$visited = []): array
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
                    $css = array_merge($css, $this->collectCssRecursive($manifest, $import, $visited));
                }
            }
        }

        return $css;
    }

}
