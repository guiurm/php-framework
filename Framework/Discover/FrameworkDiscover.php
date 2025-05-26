<?php

namespace Framework\Discover;

use Framework\Routing\RouteCollection;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;

class FrameworkDiscover
{
    private static FrameworkDiscover $instance;
    private string $DiscoverPath;
    /**
     * @var array<string, callable(ReflectionClass): void>
     */
    private array $config;

    public function __construct(string $DiscoverPath, array $config = [])
    {
        if (isset(self::$instance)) {
            self::$instance;
        } else {
            self::$instance = $this;
            $this->DiscoverPath = $DiscoverPath;
            $this->config = $config;
        }
    }

    public static function getInstance(): FrameworkDiscover
    {
        if (!isset(self::$instance)) {
            self::$instance = new self('default_path', []);
        }
        return self::$instance;
    }

    public function getDiscoverPath(): string
    {
        return $this->DiscoverPath;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function setDiscoverPath(string $DiscoverPath): self
    {
        $this->DiscoverPath = $DiscoverPath;
        return $this;
    }

    public function setConfig(array $config): self
    {
        $this->config = $config;
        return $this;
    }

    public function discover(?string $path = null): self
    {
        if (empty($path)) {
            $path = $this->DiscoverPath;
        }


        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        foreach ($rii as $file) {
            // pre($file);

            if ($file->isDir() || $file->getExtension() !== 'php') {
                continue;
            }

            // Get the fully qualified class name from the file
            $className = $this->getClassFullNameFromFile($file->getPathname());
            if (!$className || !class_exists($className)) {
                continue;
            }



            $refClass = new ReflectionClass($className);

            foreach ($this->config as $targetClass => $callback) {

                if (!$refClass->isSubclassOf($targetClass) && $refClass->getName() !== $targetClass) {
                    continue;
                }

                $callback($refClass);

                // pre($targetClass);
                // pre($className);
                // if ($refClass->isSubclassOf($targetClass)) {
                //     pre("$className es hija de $targetClass");
                // } else {
                //     pre("$className NO es hija de $targetClass");
                // }
            }

            // pre('--------------------------------');


            // $this->addClassReflectionToCollection($refClass, $collection, $className);
        }

        // Aquí podrías implementar la lógica de descubrimiento de rutas, controladores, etc.
        // Por ahora, simplemente llamamos a un método privado para simular el descubrimiento.
        return $this;
    }



    /**
     * Extracts the fully qualified class name from a PHP file.
     */
    private function getClassFullNameFromFile(string $file): ?string
    {
        $src = file_get_contents($file);
        if (!preg_match('/namespace\s+(.+?);/', $src, $m)) {
            return null;
        }
        $namespace = $m[1];
        if (!preg_match('/class\s+([a-zA-Z0-9_]+)/', $src, $m)) {
            return null;
        }
        $class = $m[1];
        return $namespace . '\\' . $class;
    }
}
