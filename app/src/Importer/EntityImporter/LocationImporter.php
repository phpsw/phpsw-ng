<?php

namespace Phpsw\Website\Importer\EntityImporter;

use Phpsw\Website\Importer\EntityImporter\Form\LocationType;
use Phpsw\Website\Repository\LocationRepositoryInterface;

class LocationImporter implements EntityImporterInterface
{
    /**
     * @var LocationRepositoryInterface
     */
    private $locationRepository;

    /**
     * @var DataToEntityConverter
     */
    private $dataToEntityConverter;

    /**
     * LocationImporter constructor.
     *
     * @param LocationRepositoryInterface $locationRepository
     * @param DataToEntityConverter $dataToEntityConverter
     */
    public function __construct(
        LocationRepositoryInterface $locationRepository,
        DataToEntityConverter $dataToEntityConverter
    ) {
        $this->locationRepository = $locationRepository;
        $this->dataToEntityConverter = $dataToEntityConverter;
    }

    /**
     * Import a Location.
     *
     * {@inheritdoc}
     */
    public function importEntity(string $slug, array $entityData)
    {
        $location = $this->dataToEntityConverter->getEntity(LocationType::class, $slug, $entityData);
        $this->locationRepository->persist($location);
    }
}
