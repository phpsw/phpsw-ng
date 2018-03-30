<?php

namespace Phpsw\Website\Importer\DirectoryReader;

use Phpsw\Website\Common\RootDirectory;

/**
 * The data importer reads in data for entities from JSON files.
 *
 * Each type of entity lives in a different directory. The filename is used as the slug for the entity.
 * This provides a means of getting all the files in a directory, mapping the slug name to each file.
 */
class DirectoryReader
{
    /**
     * @var RootDirectory
     */
    public $rootDirectory;

    /**
     * DirectoryReader constructor.
     *
     * @param RootDirectory $rootDirectory
     */
    public function __construct(RootDirectory $rootDirectory)
    {
        $this->rootDirectory = $rootDirectory;
    }

    /**
     * Returns mappings of entity slug (the file name with no extension) to full file path.
     *
     * Example returned array might be:
     * [
     *     '/home/phpsw/data/people/fred-blogs.json' => 'fred-blogs',
     *     '/home/phpsw/data/people/john-smith.json' => 'john-smith',
     * ]
     *
     *
     * @param string $directory of files to import relative to RootDirectory
     *
     * @return array mappings
     */
    public function getFileNameMappings(string $directory)
    {
        return $this->getDirectoryContentsRecursively($this->rootDirectory->getRootDirectory()."/$directory");
    }

    private function getDirectoryContentsRecursively(string $directory): array
    {
        $files = scandir($directory);

        $return = [];
        foreach ($files as $file) {
            $fullPath = "$directory/$file";

            if (is_dir("$directory/$file") && (!in_array($file, ['.', '..']))) {
                $return = array_merge($return, $this->getDirectoryContentsRecursively($fullPath));
            } elseif ('.json' === substr($file, -5)) {
                $entityName = substr($file, 0, -5);
                $return[$fullPath] = $entityName;
            }
        }

        return $return;
    }
}
