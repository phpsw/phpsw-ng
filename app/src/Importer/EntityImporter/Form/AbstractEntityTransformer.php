<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Transforms between string representing Entity slug and Entity object.
 */
abstract class AbstractEntityTransformer implements DataTransformerInterface
{
    private $entityRepository;

    /**
     * EntityTransformer constructor.
     *
     * @param $entityRepository
     */
    public function __construct($entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    /**
     * Transforms a Entity object to a slug.
     *
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (is_null($value)) {
            return null;
        }

        return $value->getSlug();
    }

    /**
     * Transforms an ID to an Entity.
     *
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (empty($value)) {
            return null;
        }

        return $this->entityRepository->findById($value);
    }
}
