<?php

namespace Phpsw\Website\Repository\InMemory;

use Phpsw\Website\Entity\Person;
use Phpsw\Website\Repository\PersonRepositoryInterface;

/**
 * In memory implementation of a PersonRepository.
 */
class PersonRepository implements PersonRepositoryInterface
{
    /**
     * @var array
     */
    private $people = [];

    /**
     * {@inheritdoc}
     */
    public function persist(Person $person)
    {
        $this->people[$person->getSlug()] = $person;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $people = $this->people;
        ksort($people);

        return array_values($people);
    }
}
