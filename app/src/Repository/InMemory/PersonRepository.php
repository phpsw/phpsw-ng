<?php

namespace Phpsw\Website\Repository\InMemory;

use Phpsw\Website\Entity\Person;
use Phpsw\Website\Repository\PersonRepositoryInterface;

/**
 * In memory implementation of a PersonRepository.
 */
class PersonRepository extends AbstractRepository implements PersonRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persist(Person $person)
    {
        $this->persistEntity($person);
    }
}
