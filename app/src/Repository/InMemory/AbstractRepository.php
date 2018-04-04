<?php

namespace Phpsw\Website\Repository\InMemory;

class AbstractRepository
{
    private $entities = [];

    /**
     * Persist the entity.
     *
     * @param $entity
     */
    protected function persistEntity($entity)
    {
        $this->entities[$entity->getId()] = $entity;
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

    /**
     * Returns entity object with the given id or null if none exist.
     *
     * @param string $id
     *
     * @return mixed|null
     */
    public function findById(string $id)
    {
        return $this->entities[$id] ?? null;
    }
}
