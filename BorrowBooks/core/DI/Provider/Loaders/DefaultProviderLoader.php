<?php

namespace Core\DI\Provider\Loaders;

use Core\DI\Attributes\Injectable;
use Core\DI\Interfaces\ProviderLoaderInterface;
use Core\DI\Provider;

class DefaultProviderLoader implements ProviderLoaderInterface
{
    /**
     * @var Provider[]
     */
    private array $providers = [];

    public function __construct(
        private readonly array $directories,
        private readonly array $ignored = []
    ) {}

    public function load(): void
    {
        $directories = [];
        foreach ($this->directories as $directory) {
            $resolved = glob($directory, GLOB_BRACE);
            $directories = array_merge($directories, $resolved);
        }
        foreach ($this->ignored as $directory) {
            $resolved = glob($directory, GLOB_BRACE);
            $directories = array_diff($directories, $resolved);
        }
        foreach ($directories as $directory) {
            $file = new \SplFileInfo($directory);
            if ($file->isDir()) {
                $it = new \RecursiveDirectoryIterator($directory);
                /** @var \SplFileInfo $file */
                foreach (new \RecursiveIteratorIterator($it) as $file) {
                    if (in_array(strtolower($file->getExtension()), ['php', 'php'])) {
                        $class = extract_namespace($file->getRealPath()) . '\\' . $file->getBasename('.php');
                        $this->addProvider($class);
                    }
                }
            } else {
                if (in_array(strtolower($file->getExtension()), ['php', 'php'])) {
                    $class = extract_namespace($file->getRealPath()) . '\\' . $file->getBasename('.php');
                    $this->addProvider($class);
                }
            }
        }
    }

    public function getProviders(): array
    {
        return $this->providers;
    }

    private function addProvider(string $class): void
    {
        $token = $class;
        $existing = null;
        $options = Provider::DEFAULT_OPTIONS;

        $reflection = new \ReflectionClass($class);

        $attributes = $reflection->getAttributes(Injectable::class);
        if (!empty($attributes)) {
            /** @var Injectable $attribute */
            $attribute = $attributes[0]->newInstance();
            $token = ($attribute->getProvides() ?? $token);
            if (!is_null($attribute->getAliasing())) {
                $existing = $attribute->getAliasing();
                $class = null;
            }
            $options['shared'] = $attribute->isShared();
            $options['multi'] = $attribute->isMulti();
            $options['tags'] = $attribute->getTags();
        }

        $this->providers[] = new Provider($token, $class, existing: $existing, options: $options);
    }
}
