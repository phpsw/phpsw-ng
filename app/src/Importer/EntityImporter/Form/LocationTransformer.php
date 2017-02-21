<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Phpsw\Website\Repository\InMemory\LocationRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class LocationTransformer implements DataTransformerInterface
{
    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * LocationTransformer constructor.
     *
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * Transforms a Location object to a slug.
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
     * Transforms a slug to a Location.
     *
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        $location = $this->locationRepository->findBySlug($value);
        if (is_null($location)) {
            throw new TransformationFailedException("Could not find person [$value]");
        }

        return $location;
    }
}
