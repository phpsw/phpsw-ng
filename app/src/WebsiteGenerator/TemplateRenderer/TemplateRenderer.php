<?php

namespace Phpsw\Website\WebsiteGenerator\TemplateRenderer;

use Phpsw\Website\Repository\WebsiteInfoRepositoryInterface;
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
     * @var WebsiteInfoRepositoryInterface
     */
    private $websiteInfoRepository;

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
    public function __construct(
        TwigWrapper $twigWrapper,
        WebsiteBaseDirectory $websiteBaseDirectory,
        WebsiteInfoRepositoryInterface $websiteInfoRepository
    ) {
        $this->websiteBaseDirectory = $websiteBaseDirectory;
        $this->filesystem = new Filesystem();
        $this->twig = $twigWrapper->getTwigEnvironment();
        $this->websiteInfoRepository = $websiteInfoRepository;
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
            $this->filesystem->mkdir($dir, 0755);
        }

        $data['page']['template'] = $templateName;

        $this->twig->addGlobal('info', $this->websiteInfoRepository->getWebsiteInfo());

        $contents = $this->twig->render("{$templateName}.html.twig", $data);
        $this->filesystem->dumpFile($fullPath, $contents);
    }
}
