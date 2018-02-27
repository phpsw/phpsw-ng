<?php

namespace Phpsw\Website\Repository\InMemory;

use Phpsw\Website\Entity\Sponsor;
use Phpsw\Website\Repository\SponsorRepositoryInterface;
use RuntimeException;

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

    /**
     * {@inheritdoc}
     */
    public function getByType(string $sponsorType)
    {
        if (false === Sponsor::isValidSponsorType($sponsorType)) {
            throw new RuntimeException("Invalid sponsor type [{$sponsorType}]");
        }

        return array_filter($this->getAll(), function (Sponsor $sponsor) use ($sponsorType) {
            return $sponsor->getSponsorType() === $sponsorType;
        });
    }
}
