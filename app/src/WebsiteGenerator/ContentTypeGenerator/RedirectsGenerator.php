<?php

namespace Phpsw\Website\WebsiteGenerator\ContentTypeGenerator;

use Phpsw\Website\Entity\Talk;
use Phpsw\Website\Repository\TalkRepositoryInterface;
use Phpsw\Website\WebsiteGenerator\Router\RouteGenerator;
use Phpsw\Website\WebsiteGenerator\TemplateRenderer\TemplateRenderer;

/**
 * Generates a redirect file.
 */
class RedirectsGenerator implements ContentTypeGeneratorsInterface
{
    /**
     * @var TalkRepositoryInterface
     */
    private $talkRepository;

    /**
     * @var RouteGenerator
     */
    private $routeGenerator;

    /**
     * @param TalkRepositoryInterface $talkRepository
     * @param RouteGenerator $routeGenerator
     */
    public function __construct(
        TalkRepositoryInterface $talkRepository,
        RouteGenerator $routeGenerator
    ) {
        $this->talkRepository = $talkRepository;
        $this->routeGenerator = $routeGenerator;
    }

    /**
     * Generate pages for content type.
     *
     * This includes:
     * - a page for each talk
     *
     * {@inheritdoc}
     */
    public function generatePages(TemplateRenderer $templateRenderer): void
    {
        $talks = $this->talkRepository->getAll();

        $redirects = [];

        foreach ($talks as $talk) {
            $oldPage = $talk->getOriginalRelativeUrl();
            if (null !== $oldPage) {
                $redirects[] = $talk;
            }
        }

        $templateRenderer->render('.htaccess', 'htaccess', ['talks' => $talks]);

        // See RedirectMap option: https://serverfault.com/questions/441235/maintaining-redirects-in-nginx-from-an-external-source
        $templateRenderer->render('.redirect.map', 'redirectMap', ['talks' => $talks]);
    }
}
