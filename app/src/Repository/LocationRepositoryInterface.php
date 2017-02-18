<?php

namespace Phpsw\Website\Repository;

use Phpsw\Website\Entity\Location;

interface LocationRepositoryInterface
{
    /**
     * Save or update a Location entity.
     *
     * @param Location $location
     */
    public function persist(Location $location);

    /**
     * Returns all people ordered by location slug (in alphabetical order).
     *
     * @return Location[]
     */
    public function getAll();
}
