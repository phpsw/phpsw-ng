<?php

namespace Phpsw\Website\WebsiteGenerator\TemplateRenderer;

use Phpsw\Website\Common\RootDirectory;
use Phpsw\Website\WebsiteGenerator\WebsiteBaseDirectory;
use Symfony\Component\Filesystem\Filesystem;
use Twig_Environment;
use Twig_Loader_Filesystem;

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
     * @param RootDirectory $rootDirectory
     * @param WebsiteBaseDirectory $websiteBaseDirectory
     */
    public function __construct(RootDirectory $rootDirectory, WebsiteBaseDirectory $websiteBaseDirectory)
    {
        $this->websiteBaseDirectory = $websiteBaseDirectory;
        $this->filesystem = new Filesystem();
        $twigLoader = new Twig_Loader_Filesystem($rootDirectory->getRootDirectory().'/app/resources/views');
        $this->twig = new Twig_Environment($twigLoader);
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
        $fullPath = "{$this->websiteBaseDirectory}/$filename}";
        $dir = dirname($fullPath);
        if (!$this->filesystem->exists($dir)) {
            $this->filesystem->mkdir($fullPath, 0755);
        }

        $contents = $this->twig->render($templateName, $data);
        $this->filesystem->dumpFile($filename, $contents);
    }
}
