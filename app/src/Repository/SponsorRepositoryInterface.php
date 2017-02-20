<?php

namespace Phpsw\Website\Repository;

use Phpsw\Website\Entity\Sponsor;

interface SponsorRepositoryInterface
{
    /**
     * Save or update a Sponsor entity.
     *
     * @param Sponsor $sponsor
     */
    public function persist(Sponsor $sponsor);

    /**
     * Returns all sponsors ordered by sponsor slug (in alphabetical order).
     *
     * @return Sponsor[]
     */
    public function getAll();
}
