<?php

namespace Phpsw\Website\Container\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormExtensionInterface;

/**
 * Used by FormBuilder to load the correct FormInterface.
 */
class DependencyInjectionFormExtension implements FormExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType($name)
    {
        // TODO once Symfony DI has been added update this. Currently FormInterface may only have 0 arg constructors.
        return new $name();
    }

    /**
     * {@inheritdoc}
     */
    public function hasType($name)
    {
        return is_subclass_of($name, AbstractType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getTypeExtensions($name)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function hasTypeExtensions($name)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getTypeGuesser()
    {
        return null;
    }
}
