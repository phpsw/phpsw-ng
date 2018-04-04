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
     * Returns all the talks order by talk slug (in alphabetical order) that are flagged as show case talks.
     *
     * A showcase talk is one that shows PHP-SW at it's best. These talks will appear on the talks page.
     *
     * @return Talk[]
     */
    public function getShowcaseTalks();

    /**
     * Returns Talk object with the given ID or null if none exist.
     *
     * @param string $id
     *
     * @return Talk|null
     */
    public function findById(string $id);
}
