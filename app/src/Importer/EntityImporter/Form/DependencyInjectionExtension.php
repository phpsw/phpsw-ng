<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormExtensionInterface;

class DependencyInjectionExtension implements FormExtensionInterface
{
    /**
     * Holds mappings between Entity FQCN and the FormType that converts form data into the entity.
     *
     * @var array
     */
    private $types = [];

    /**
     * Adding mapping between Entity FQCN and the FormType used to populate the Entity with data.
     *
     * This must only be called when building the container.
     *
     * @param string $entityFqcn
     * @param AbstractType $formType
     */
    public function addFormType(string $entityFqcn, AbstractType $formType)
    {
        $this->types[$entityFqcn] = $formType;
    }

    /**
     * {@inheritdoc}
     */
    public function getType($name)
    {
        if (!array_key_exists($name, $this->types)) {
            throw new \InvalidArgumentException("Invalid type name [$name]");
        }

        return $this->types[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasType($name)
    {
        return array_key_exists($name, $this->types);
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
