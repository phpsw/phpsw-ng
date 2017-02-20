<?php

namespace Phpsw\Website\Repository\InMemory;

use Phpsw\Website\Entity\Sponsor;
use Phpsw\Website\Repository\SponsorRepositoryInterface;

/**
 * In memory implementation of a SponsorRepository.
 */
class SponsorRepository implements SponsorRepositoryInterface
{
    /**
     * @var array
     */
    private $sponsors = [];

    /**
     * {@inheritdoc}
     */
    public function persist(Sponsor $sponsor)
    {
        $this->sponsors[$sponsor->getSlug()] = $sponsor;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $sponsors = $this->sponsors;
        ksort($sponsors);

        return array_values($sponsors);
    }
}
