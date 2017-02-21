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

    /**
     * Container constructor.
     *
     * @param string $environment
     */
    public function __construct(string $environment)
    {
        $this->containerBuilder = new ContainerBuilder($this->getParameters());
        $loader = new YamlFileLoader($this->containerBuilder, new FileLocator(__DIR__.'/../../config/'));
        $loader->load("config_$environment.yml");
        $this->containerBuilder->addCompilerPass(new FormTypeCompilerClass());
        $this->containerBuilder->addCompilerPass(new ImporterCompilerClass());
        $this->containerBuilder->addCompilerPass(new CommandCompilerClass());
        $this->containerBuilder->addCompilerPass(new ContentTypeGeneratorCompilerClass());
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
