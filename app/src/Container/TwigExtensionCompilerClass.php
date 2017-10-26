<?php

namespace Phpsw\Website\Container;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers TwigExtensions with the template renderer.
 *
 */
class TwigExtensionCompilerClass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('app.websiteGenerator.twigWrapper');
        $taggedServices = $container->findTaggedServiceIds('TwigExtension');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('add', [new Reference($id)]);
        }
    }
}