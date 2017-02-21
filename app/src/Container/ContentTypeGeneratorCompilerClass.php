<?php

namespace Phpsw\Website\Container;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This looks for all services tagged with ContentTypeGenerator and registers them with the Symfony Console Application.
 *
 * Commands should be thin wrappers for the functionality they run (e.g. Importer).
 */
class ContentTypeGeneratorCompilerClass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('app.websiteGenerator');
        $taggedServices = $container->findTaggedServiceIds('ContentTypeGenerator');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addContentTypeGenerator', [new Reference($id)]);
        }
    }
}
