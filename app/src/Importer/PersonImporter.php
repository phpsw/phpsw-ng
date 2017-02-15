<?php

namespace Phpsw\Website\Importer;

use Phpsw\Website\Entity\Person;
use Phpsw\Website\Repository\PersonRepositoryInterface;

class PersonImporter implements EntityImporterInterface
{
    /**
     * @var PersonRepositoryInterface
     */
    private $personRepository;

    /**
     * PersonImporter constructor.
     *
     * @param PersonRepositoryInterface $personRepository
     */
    public function __construct(PersonRepositoryInterface $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    /**
     * Import a Person.
     *
     * {@inheritdoc}
     */
    public function importEntity(string $slug, array $entityData)
    {
        $person = new Person();
        $person->setSlug($slug);
        $person->setName($entityData['name'] ?? null);
        $person->setPhotoUrl($entityData['photo-url'] ?? null);
        $person->setDescription($entityData['description'] ?? null);
        $person->setTwitterHandle($entityData['twitter-handle'] ?? null);
        $person->setGithubHandle($entityData['github-handle'] ?? null);
        $person->setWebsiteUrl($entityData['website-url'] ?? null);
        $person->setMeetupId($entityData['meetup-id'] ?? null);
        $this->personRepository->persist($person);
    }
}
