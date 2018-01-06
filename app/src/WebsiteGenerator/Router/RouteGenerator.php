<?php

namespace Phpsw\Website\WebsiteGenerator\Router;

use Phpsw\Website\Common\RootDirectory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

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
     * @var RouteCollection
     */
    private $routeCollection;

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
        $this->routeCollection = $loader->load('generated_website_routes.yml');

        $context = new RequestContext();

        $this->urlGenerator = new UrlGenerator($this->routeCollection, $context);
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


    /**
     * @return array|Route[]
     */
    public function getRoutes(): array
    {
        return $this->routeCollection->all();
    }
}
