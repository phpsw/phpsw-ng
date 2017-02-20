<?php

namespace Phpsw\Website\Repository\InMemory;

use Phpsw\Website\Entity\Location;
use Phpsw\Website\Repository\LocationRepositoryInterface;

/**
 * In memory implementation of a LocationRepository.
 */
class LocationRepository extends AbstractRepository implements LocationRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persist(Location $location)
    {
        $this->persistEntity($location);
    }
}
