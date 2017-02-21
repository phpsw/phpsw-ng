<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Phpsw\Website\Repository\PersonRepositoryInterface;

/**
 * Transforms between array of strings representing Person slugs and Person objects.
 */
class PeopleTransformer extends AbstractEntityCollectionTransformer
{
    /**
     * PeopleTransformer constructor.
     *
     * @param PersonRepositoryInterface $personRepository
     */
    public function __construct(PersonRepositoryInterface $personRepository)
    {
        parent::__construct($personRepository);
    }
}
