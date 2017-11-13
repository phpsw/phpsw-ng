<?php

namespace Phpsw\Website\WebsiteGenerator\TemplateRenderer\TwigExtension;

use Phpsw\Website\Entity\Person;
use Phpsw\Website\WebsiteGenerator\Router\RouteGenerator;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Provides functions to get URLs of routes.
 *
 * The following twig functions are added:
 *
 * url(string routeName, array parameters = []) Returns URL for route name and optional parameters
 * personUrl(Person $person)  Returns URL for person
 */
class UrlTwigExtension extends Twig_Extension
{
    /**
     * @var RouteGenerator
     */
    private $routeGenerator;

    /**
     * UrlTwigExtension constructor.
     *
     * @param RouteGenerator $routeGenerator
     */
    public function __construct(RouteGenerator $routeGenerator)
    {
        $this->routeGenerator = $routeGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('url', [$this, 'getUrl']),
            new Twig_SimpleFunction('personUrl', [$this, 'getPersonUrl']),
        ];
    }

    public function getUrl(string $routeName, array $parameters = []): string
    {
        return $this->routeGenerator->getPath($routeName, $parameters);
    }

    public function getPersonUrl(Person $person): string
    {
        return $this->getUrl('speaker', ['speakerSlug' => $person->getSlug()]);
    }
}
