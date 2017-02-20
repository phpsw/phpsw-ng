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
    private $locations = [];

    /**
     * {@inheritdoc}
     */
    public function persist(Location $location)
    {
        $this->locations[$location->getSlug()] = $location;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $locations = $this->locations;
        ksort($locations);

        return array_values($locations);
    }
}
