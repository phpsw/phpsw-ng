<?php

namespace Phpsw\Website\Importer;

use Phpsw\Website\Importer\DirectoryReader\DirectoryReader;
use Phpsw\Website\Importer\EntityImporter\EntityImporterInterface;

const ORDER = 'order';

class Importer
{
    const DIRECTORY = 'directory';
    const IMPORTER = 'importer';
    const ORDER = 'order';
    /**
     * @var array where the key is the directory and the value is the EntityImporter
     */
    private $entityImporterMappings;

    /**
     * @var DirectoryReader
     */
    private $directoryReader;

    /**
     * Importer constructor.
     *
     * @param DirectoryReader $directoryReader
     */
    public function __construct(DirectoryReader $directoryReader)
    {
        $this->directoryReader = $directoryReader;
        $this->entityImporterMappings = [];
    }

    /**
     * Add an importer and the directory (relative to the root directory) of where entity files to be imported live.
     *
     * @param EntityImporterInterface $entityImporterInterface
     * @param string $directory
     */
    public function addImporter(EntityImporterInterface $entityImporterInterface, string $directory, int $order)
    {
        $this->entityImporterMappings[] = [
            self::DIRECTORY => $directory,
            self::IMPORTER => $entityImporterInterface,
            self::ORDER => $order,
        ];
    }

    /**
     * Import data for all registered importers.
     *
     * @throws ValidationException
     */
    public function import()
    {
        // Reorder importers
        usort($this->entityImporterMappings, function ($a, $b) {
            return $a[ORDER] <=> $b[ORDER];
        });

        // Import each entity type in turn
        foreach ($this->entityImporterMappings as $entityImporterMapping) {
            $files = $this->directoryReader->getFileNameMappings($entityImporterMapping[self::DIRECTORY]);
            foreach ($files as $slug => $filename) {
                $fileContents = file_get_contents($filename);
                $entityData = json_decode($fileContents, true);
                $entityImporterMapping[self::IMPORTER]->importEntity($slug, $entityData);
            }
        }
    }
}
