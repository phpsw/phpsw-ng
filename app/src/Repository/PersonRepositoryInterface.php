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

    /**
     * Returns all people ordered by person slug (in alphabetical order).
     *
     * @return Person[]
     */
    public function getAll();

    /**
     * Returns Person object with the given id or null if none exist.
     *
     * @param string $id
     *
     * @return Person|null
     */
    public function findById(string $id);
}
