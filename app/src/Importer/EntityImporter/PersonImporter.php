<?php

namespace Phpsw\Website\Importer\EntityImporter;

use Phpsw\Website\Importer\EntityImporter\Form\PersonType;
use Phpsw\Website\Repository\PersonRepositoryInterface;

class PersonImporter implements EntityImporterInterface
{
    /**
     * @var PersonRepositoryInterface
     */
    private $personRepository;

    /**
     * @var DataToEntityConverter
     */
    private $dataToEntityConverter;

    /**
     * PersonImporter constructor.
     *
     * @param PersonRepositoryInterface $personRepository
     * @param DataToEntityConverter $dataToEntityConverter
     */
    public function __construct(
        PersonRepositoryInterface $personRepository,
        DataToEntityConverter $dataToEntityConverter
    ) {
        $this->personRepository = $personRepository;
        $this->dataToEntityConverter = $dataToEntityConverter;
    }

    /**
     * Import a Person.
     *
     * {@inheritdoc}
     */
    public function importEntity(string $slug, array $entityData)
    {
        $person = $this->dataToEntityConverter->getEntity(PersonType::class, $slug, $entityData);
        $this->personRepository->persist($person);
    }
}
