<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Phpsw\Website\Entity\Person;
use Phpsw\Website\Repository\PersonRepositoryInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transforms between array of strings representing Person slugs and Person objects.
 */
class PeopleTransformer implements DataTransformerInterface
{
    /**
     * @var PersonRepositoryInterface
     */
    private $personRepository;

    /**
     * PeopleTransformer constructor.
     *
     * @param PersonRepositoryInterface $personRepository
     */
    public function __construct(PersonRepositoryInterface $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    /**
     * Transforms collection of Person objects to a collection of strings of their slugs.
     *
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (is_null($value)) {
            return null;
        }

        $slugs = [];
        /** @var Person $person */
        foreach ($value as $person) {
            $slugs[] = $person->getSlug();
        }

        return $slugs;
    }

    /**
     * Tranforms collection of strings representing Person slugs to a collection of Person objects.
     *
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        $people = [];
        if (!empty($value)) {
            foreach ($value as $slug) {
                $person = $this->personRepository->findBySlug($slug);
                if (is_null($person)) {
                    throw new TransformationFailedException("Could not find person [$slug]");
                }
                $people[] = $person;
            }
        }

        return $people;
    }
}
