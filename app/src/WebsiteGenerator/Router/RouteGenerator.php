<?php

namespace Phpsw\Website\WebsiteGenerator\Router;

use Phpsw\Website\Common\RootDirectory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RequestContext;

/**
 * Wrapper for generating URLs for routes for the generated website.
 */
class RouteGenerator
{
    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * RouteGenerator constructor.
     *
     * @param RootDirectory $rootDirectory
     */
    public function __construct(RootDirectory $rootDirectory)
    {
        $directory = $rootDirectory->getRootDirectory().'/app/config';
        $locator = new FileLocator($directory);
        $loader = new YamlFileLoader($locator);
        $routeCollection = $loader->load('generated_website_routes.yml');

        $context = new RequestContext();

        $this->urlGenerator = new UrlGenerator($routeCollection, $context);
    }

    /**
     * Returns absolute path for route.
     *
     * @param string $routeName
     * @param array $parameters
     *
     * @return string
     */
    public function getPath(string $routeName, array $parameters = []): string
    {
        return $this->urlGenerator->generate($routeName, $parameters);
    }
}
