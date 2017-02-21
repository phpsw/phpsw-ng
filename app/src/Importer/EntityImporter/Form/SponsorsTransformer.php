<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Phpsw\Website\Repository\SponsorRepositoryInterface;

/**
 * Transforms between array of strings representing Sponsor slugs and Sponsor objects.
 */
class SponsorsTransformer extends AbstractEntityCollectionTransformer
{
    /**
     * SponsorsTransformer constructor.
     *
     * @param SponsorRepositoryInterface $sponsorRepository
     */
    public function __construct(SponsorRepositoryInterface $sponsorRepository)
    {
        parent::__construct($sponsorRepository);
    }
}
