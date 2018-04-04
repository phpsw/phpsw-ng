<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Phpsw\Website\Entity\Event;
use Phpsw\Website\Repository\EventRepositoryInterface;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Transforms between string representing Entity slug and Entity object.
 */
class EventTransformer implements DataTransformerInterface
{
    /**
     * @var EventRepositoryInterface
     */
    private $entityRepository;

    /**
     * EventTransformer constructor.
     *
     * @param EventRepositoryInterface $entityRepository
     */
    public function __construct(EventRepositoryInterface $entityRepository)
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
        /** @var Event $value */
        if (is_null($value)) {
            return null;
        }

        return $value->getId();
    }

    /**
     * Transforms a slug to a Entity.
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
