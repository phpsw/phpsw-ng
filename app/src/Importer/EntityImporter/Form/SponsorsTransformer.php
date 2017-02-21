<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Phpsw\Website\Entity\Sponsor;
use Phpsw\Website\Repository\SponsorRepositoryInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transforms between array of strings representing Sponsor slugs and Sponsor objects.
 */
class SponsorsTransformer implements DataTransformerInterface
{
    /**
     * @var SponsorRepositoryInterface
     */
    private $sponsorRepository;

    /**
     * SponsorsTransformer constructor.
     *
     * @param SponsorRepositoryInterface $sponsorRepository
     */
    public function __construct(SponsorRepositoryInterface $sponsorRepository)
    {
        $this->sponsorRepository = $sponsorRepository;
    }

    /**
     * Transforms collection of Sponsor objects to a collection of strings of their slugs.
     *
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (is_null($value)) {
            return null;
        }

        $slugs = [];
        /** @var Sponsor $sponsor */
        foreach ($value as $sponsor) {
            $slugs[] = $sponsor->getSlug();
        }

        return $slugs;
    }

    /**
     * Transforms collection of strings representing Sponsor slugs to a collection of Sponsor objects.
     *
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        $sponsors = [];
        if (!empty($value)) {
            foreach ($value as $slug) {
                $sponsor = $this->sponsorRepository->findBySlug($slug);
                if (is_null($sponsor)) {
                    throw new TransformationFailedException("Could not find sponsor [$slug]");
                }
                $sponsors[] = $sponsor;
            }
        }

        return $sponsors;
    }
}
