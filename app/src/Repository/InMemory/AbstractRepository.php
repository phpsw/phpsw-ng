<?php

namespace Phpsw\Website\Repository\InMemory;

class AbstractRepository
{
    private $entities;

    /**
     * Persist the entity.
     *
     * @param $entity
     */
    protected function persistEntity($entity)
    {
        $this->entities[$entity->getSlug()] = $entity;
    }

    /**
     * Return array of entities ordered by their slug.
     *
     * @return array
     */
    public function getAll()
    {
        $entities = $this->entities;
        ksort($entities);

        return array_values($entities);
    }
}
