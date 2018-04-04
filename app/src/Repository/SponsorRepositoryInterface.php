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

    /**
     * Returns Sponsor object with the given id or null if none exist.
     *
     * @param string $id
     *
     * @return Sponsor|null
     */
    public function findById(string $id);

    /**
     * Returns all sponsors of the give type (see Sponsor object).
     *
     * @param string $sponsorType
     *
     * @return Sponsor[]
     */
    public function getByType(string $sponsorType);
}
