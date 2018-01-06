<?php

namespace Phpsw\Website\WebsiteGenerator\ContentTypeGenerator;

use Phpsw\Website\WebsiteGenerator\Router\RouteGenerator;
use Phpsw\Website\WebsiteGenerator\TemplateRenderer\TemplateRenderer;
use Symfony\Component\Routing\Route;

/**
 * Generates:.
 *
 * - static pages
 */
class StaticPagesGenerator implements ContentTypeGeneratorsInterface
{
    const TEMPLATE_OPTION = 'template';

    /**
     * @var RouteGenerator
     */
    private $routeGenerator;

    /**
     * StaticPagesGenerator constructor.
     *
     * @param RouteGenerator $routeGenerator
     */
    public function __construct(RouteGenerator $routeGenerator)
    {
        $this->routeGenerator = $routeGenerator;
    }

    /**
     * Generate static pages.
     *
     * Static pages are routes that have an are defined with a template in the options section of the route definition
     * in generated_website_routes.yml
     *
     *
     * {@inheritdoc}
     */
    public function generatePages(TemplateRenderer $templateRenderer)
    {
        $routes = $this->routeGenerator->getRoutes();

        foreach ($routes as $route) {
            $template = $this->getTemplateNameIfExists($route);

            if ($template !== null) {
                $this->generateStaticPage($templateRenderer, $route, $template);
            }
        }
    }

    private function generateStaticPage(TemplateRenderer $templateRenderer, Route $route, string $template)
    {
        $filename = $route->getPath().'.html';
        $templateRenderer->render($filename, $template, []);
    }

    /**
     * Iterate through route options to see if a template name exists.
     *
     * @param Route $route
     *
     * @return string|null
     */
    private function getTemplateNameIfExists(Route $route)
    {
        return $this->findTemplateName($route->getOptions());
    }

    private function findTemplateName(array $array)
    {
        foreach ($array as $key => $value) {
            if ($key === self::TEMPLATE_OPTION) {
                return $value;
            }

            if (is_array($value)) {
                $templateName = $this->findTemplateName($value);

                if ($templateName !== null) {
                    return $templateName;
                }
            }
        }

        return null;
    }
}
