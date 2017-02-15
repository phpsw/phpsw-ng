<?php

namespace Phpsw\Website\Importer;

/**
 * Interface for all entity importers.
 *
 * E.g. entity has a slug (e.g. fred-blogs) and an array of data that is used to populate the new entity.
 */
interface EntityImporterInterface
{
    /**
     * Import a single entity.
     *
     * @param string $slug
     * @param array $entityData
     */
    public function importEntity(string $slug, array $entityData);
}
