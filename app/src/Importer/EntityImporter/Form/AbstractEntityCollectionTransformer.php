<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transforms between array of strings representing Entity slugs and Entity objects.
 */
abstract class AbstractEntityCollectionTransformer implements DataTransformerInterface
{
    private $entityRepository;

    /**
     * AbstractEntityCollectionTransformer constructor.
     *
     * @param $entityRepository
     */
    public function __construct($entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    /**
     * Transforms collection of Entity objects to a collection of strings of their slugs.
     *
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (is_null($value)) {
            return null;
        }

        $slugs = [];
        foreach ($value as $entity) {
            $slugs[] = $entity->getSlug();
        }

        return $slugs;
    }

    /**
     * Transforms collection of strings representing Entity slugs to a collection of Entity objects.
     *
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        $entities = [];
        if (!empty($value)) {
            foreach ($value as $slug) {
                $entity = $this->entityRepository->findBySlug($slug);
                if (is_null($entity)) {
                    throw new TransformationFailedException("Could not find entity [$slug]");
                }
                $entities[] = $entity;
            }
        }

        return $entities;
    }
}
