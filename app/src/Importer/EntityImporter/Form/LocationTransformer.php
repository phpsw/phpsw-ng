<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Phpsw\Website\Repository\InMemory\LocationRepository;

class LocationTransformer extends AbstractEntityTransformer
{
    /**
     * LocationTransformer constructor.
     *
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        parent::__construct($locationRepository);
    }
}
