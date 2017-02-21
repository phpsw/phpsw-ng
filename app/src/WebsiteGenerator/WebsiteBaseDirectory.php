<?php

namespace Phpsw\Website\WebsiteGenerator;

/**
 * Holds base directory for website output.
 */
class WebsiteBaseDirectory
{
    /**
     * @var string
     */
    private $websiteBaseDirectory;

    /**
     * WebsiteBaseDirectory constructor.
     *
     * @param string $websiteBaseDirectory
     */
    public function __construct(string $websiteBaseDirectory)
    {
        $this->websiteBaseDirectory = $websiteBaseDirectory;
    }

    /**
     * @return string
     */
    public function getWebsiteBaseDirectory()
    {
        return $this->websiteBaseDirectory;
    }
}
