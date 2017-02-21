<?php

namespace Phpsw\Website\WebsiteGenerator;

/**
 * Entry point for generating the website.
 *
 * The website is basically a pages made up of different content types (pages on speakers, talks, events, etc).
 * This executes each of the content type generators in term.
 */
class WebsiteGenerator
{
    /**
     * @var WebsiteBaseDirectory
     */
    private $websiteBaseDirectory;

    /**
     * @var ContentTypeGeneratorsInterface[]
     */
    private $contentTypeGenerators = [];

    /**
     * WebsiteGenerator constructor.
     *
     * @param WebsiteBaseDirectory $websiteBaseDirectory
     */
    public function __construct(WebsiteBaseDirectory $websiteBaseDirectory)
    {
        $this->websiteBaseDirectory = $websiteBaseDirectory;
    }

    /**
     * Add content type generator.
     *
     * @param ContentTypeGeneratorsInterface $contentTypeGenerator
     */
    public function addContentTypeGenerator(ContentTypeGeneratorsInterface $contentTypeGenerator)
    {
        $this->contentTypeGenerators[] = $contentTypeGenerator;
    }

    /**
     * Generate the web pages.
     */
    public function generateWebsite()
    {
        // TODO maybe delete existing contents of website directory .
        // TODO maybe keep resources like css, JS, images, etc in an resources directory and copy these over.

        foreach ($this->contentTypeGenerators as $contentTypeGenerator) {
            $contentTypeGenerator->generatePages($this->websiteBaseDirectory);
        }
    }
}
