<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

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
     * Transforms a slug to a Entity.
     *
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (empty($value)) {
            throw new TransformationFailedException('Could not find entity null slug');
        }
        $entity = $this->entityRepository->findBySlug($value);
        if (is_null($entity)) {
            throw new TransformationFailedException("Could not find entity [$value]");
        }

        return $entity;
    }
}
