<?php

namespace Phpsw\Website\Common;

/**
 * This represents the root directory of the PHPSW project.
 */
class RootDirectory
{
    /**
     * @var string
     */
    private $rootDirectory;

    /**
     * RootDirectory constructor.
     *
     * @param string $rootDirectory
     */
    public function __construct(string $rootDirectory)
    {
        $this->rootDirectory = $rootDirectory;
    }

    /**
     * @return string
     */
    public function getRootDirectory()
    {
        return $this->rootDirectory;
    }
}
