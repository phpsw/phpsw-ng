<?php

namespace Phpsw\Website\WebsiteGenerator\TemplateRenderer;

use Phpsw\Website\WebsiteGenerator\WebsiteBaseDirectory;
use Symfony\Component\Filesystem\Filesystem;
use Twig_Environment;

/**
 * Uses Twig to render templates.
 */
class TemplateRenderer
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var WebsiteBaseDirectory
     */
    private $websiteBaseDirectory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * TemplateRenderer constructor.
     *
     * @param TwigWrapper $twigWrapper
     * @param WebsiteBaseDirectory $websiteBaseDirectory
     */
    public function __construct(TwigWrapper $twigWrapper, WebsiteBaseDirectory $websiteBaseDirectory)
    {
        $this->websiteBaseDirectory = $websiteBaseDirectory;
        $this->filesystem = new Filesystem();
        $this->twig = $twigWrapper->getTwigEnvironment();
    }

    /**
     * Renders a template and dumps to $filename.
     *
     * NOTE: $filename is relative to the output directory
     *
     * @param string $filename
     * @param string $templateName
     * @param array $data
     */
    public function render(string $filename, string $templateName, array $data)
    {
        $fullPath = "{$this->websiteBaseDirectory->getWebsiteBaseDirectory()}/$filename";
        $dir = dirname($fullPath);
        if (!$this->filesystem->exists($dir)) {
            $this->filesystem->mkdir($fullPath, 0755);
        }

        $contents = $this->twig->render("{$templateName}.twig.html", $data);
        $this->filesystem->dumpFile($fullPath, $contents);
    }
}
