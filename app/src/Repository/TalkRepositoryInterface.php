<?php

namespace Phpsw\Website\Repository;

use Phpsw\Website\Entity\Talk;

interface TalkRepositoryInterface
{
    /**
     * Save or update a Talk entity.
     *
     * @param Talk $talk
     */
    public function persist(Talk $talk);

    /**
     * Returns all talks ordered by talk slug (in alphabetical order).
     *
     * @return Talk[]
     */
    public function getAll();

    /**
     * Returns Talk object with the given slug of null if none exist.
     *
     * @param string $slug
     *
     * @return Talk|null
     */
    public function findBySlug(string $slug);
}
