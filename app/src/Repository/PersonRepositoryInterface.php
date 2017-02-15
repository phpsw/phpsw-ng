<?php

namespace Phpsw\Website\Repository;

use Phpsw\Website\Entity\Person;

interface PersonRepositoryInterface
{
    /**
     * Save or update a Person entity.
     *
     * @param Person $person
     */
    public function persist(Person $person);
}
