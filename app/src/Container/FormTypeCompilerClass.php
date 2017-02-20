<?php

namespace Phpsw\Website\Container;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This looks for all services tagged with FormType and registers them with the Form DI extension.
 *
 * This maps the FQCN of the Entity to the the AbstractType that converts populates the Entity with data from form.
 */
class FormTypeCompilerClass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('app.importer.formBuilderDependencyInjectionExtension');
        $taggedServices = $container->findTaggedServiceIds('FormType');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $tag) {
                $definition->addMethodCall('addFormType', [$tag['entityFqcn'], new Reference($id)]);
            }
        }
    }
}
