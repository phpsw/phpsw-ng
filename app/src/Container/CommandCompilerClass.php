<?php

namespace Phpsw\Website\Container;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This looks for all services tagged with ConsoleCommand and registers them with the Symfony Console Application.
 *
 * Commands should be thin wrappers for the functionality they run (e.g. Importer).
 */
class CommandCompilerClass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('app.cli');
        $taggedServices = $container->findTaggedServiceIds('ConsoleCommand');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('add', [new Reference($id)]);
        }
    }
}
