<?php

namespace Phpsw\Website\WebsiteGenerator\TemplateRenderer;

use Phpsw\Website\Common\RootDirectory;
use Twig_Environment;
use Twig_ExtensionInterface;
use Twig_Loader_Filesystem;

/**
 * Wraps up twig environment.
 *
 * Allows additional extensions to be registered.
 */
class TwigWrapper
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * TemplateRenderer constructor.
     *
     * @param RootDirectory $rootDirectory
     */
    public function __construct(RootDirectory $rootDirectory)
    {
        $twigLoader = new Twig_Loader_Filesystem($rootDirectory->getRootDirectory().'/app/resources/views');
        $this->twig = new Twig_Environment($twigLoader, [
            'strict_variables' => true,
        ]);
    }

    /**
     * Add twig extension.
     *
     * @param Twig_ExtensionInterface $twigExtension
     */
    public function addExtension(Twig_ExtensionInterface $twigExtension)
    {
        $this->twig->addExtension($twigExtension);
    }

    /**
     * @return Twig_Environment
     */
    public function getTwigEnvironment()
    {
        return $this->twig;
    }
}
