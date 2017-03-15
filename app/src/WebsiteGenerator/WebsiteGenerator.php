<?php

namespace Phpsw\Website\WebsiteGenerator;

use Phpsw\Website\Common\RootDirectory;
use Phpsw\Website\WebsiteGenerator\ContentTypeGenerator\ContentTypeGeneratorsInterface;
use Phpsw\Website\WebsiteGenerator\TemplateRenderer\TemplateRenderer;
use Symfony\Component\Filesystem\Filesystem;

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
     * @var RootDirectory
     */
    private $rootDirectory;

    /**
     * @var TemplateRenderer
     */
    private $templateRenderer;

    /**
     * @var ContentTypeGeneratorsInterface[]
     */
    private $contentTypeGenerators;

    /**
     * WebsiteGenerator constructor.
     *
     * @param WebsiteBaseDirectory $websiteBaseDirectory
     * @param RootDirectory $rootDirectory
     * @param TemplateRenderer $templateRenderer
     */
    public function __construct(
        WebsiteBaseDirectory $websiteBaseDirectory,
        RootDirectory $rootDirectory,
        TemplateRenderer $templateRenderer
    ) {
        $this->websiteBaseDirectory = $websiteBaseDirectory;
        $this->rootDirectory = $rootDirectory;
        $this->templateRenderer = $templateRenderer;
        $this->contentTypeGenerators = [];
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
        $this->copyAssets();
        $this->generateContent();
    }

    /**
     * Copy over all data in the resources web directory (this should contain things like css).
     */
    private function copyAssets()
    {
        $fileSystem = new Filesystem();
        $sourceWebDirectory = "{$this->rootDirectory->getRootDirectory()}/app/resources/assets";
        $fileSystem->mirror($sourceWebDirectory, $this->websiteBaseDirectory->getWebsiteBaseDirectory());
    }

    /**
     * Generate the content using each content type generator.
     */
    private function generateContent()
    {
        foreach ($this->contentTypeGenerators as $contentTypeGenerator) {
            $contentTypeGenerator->generatePages($this->templateRenderer);
        }
    }
}
