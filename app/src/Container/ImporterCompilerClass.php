<?php

namespace Phpsw\Website\Container;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This looks for all services tagged with EntityImporter and registers them with the Importer (via addImporter method).
 *
 * Note that when tagging a service as an EntityImporter you must also supply:
 * - directory: The directory (relative to root directory) where the entity JSON files are stored.
 * - order: The order in which the EntityImporter must be run in. Lowest first.
 */
class ImporterCompilerClass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('app.importer');
        $taggedServices = $container->findTaggedServiceIds('EntityImporter');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $tag) {
                $definition->addMethodCall('addImporter', [new Reference($id), $tag['directory'], $tag['order']]);
            }
        }
    }
}
