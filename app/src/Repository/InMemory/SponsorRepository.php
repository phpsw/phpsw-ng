<?php

namespace Phpsw\Website\Repository\InMemory;

use Phpsw\Website\Entity\Sponsor;
use Phpsw\Website\Repository\SponsorRepositoryInterface;

/**
 * In memory implementation of a SponsorRepository.
 */
class SponsorRepository extends AbstractRepository implements SponsorRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persist(Sponsor $sponsor)
    {
        $this->persistEntity($sponsor);
    }
}
