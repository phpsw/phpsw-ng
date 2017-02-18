<?php

namespace Phpsw\Website\Container;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Wrapper around Symfony DI container.
 */
class Container
{
    /**
     * @var ContainerBuilder
     */
    private $containerBuilder;

    public function __construct()
    {
        $this->containerBuilder = new ContainerBuilder($this->getParameters());
        $loader = new YamlFileLoader($this->containerBuilder, new FileLocator(__DIR__.'/../../config/'));
        $loader->load('services.yml');
        $this->containerBuilder->compile();
    }

    /**
     * Get class of given name.
     *
     * @param string $className
     *
     * @return mixed
     */
    public function get(string $className)
    {
        return $this->containerBuilder->get($className);
    }

    private function getParameters()
    {
        return new ParameterBag([
            'rootDirectory' => __DIR__.'/../../..',
        ]);
    }
}
