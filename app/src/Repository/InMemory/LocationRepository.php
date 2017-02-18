<?php

namespace Phpsw\Website\Repository\InMemory;

use Phpsw\Website\Entity\Location;
use Phpsw\Website\Repository\LocationRepositoryInterface;

/**
 * In memory implementation of a LocationRepository.
 */
class LocationRepository implements LocationRepositoryInterface
{
    /**
     * @var array
     */
    private $people = [];

    /**
     * {@inheritdoc}
     */
    public function persist(Location $location)
    {
        $this->people[$location->getSlug()] = $location;
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
