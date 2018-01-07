<?php

namespace Phpsw\Website\WebsiteGenerator\ContentTypeGenerator;

use Phpsw\Website\Entity\Talk;
use Phpsw\Website\Repository\TalkRepositoryInterface;
use Phpsw\Website\WebsiteGenerator\TemplateRenderer\TemplateRenderer;

/**
 * Generates:.
 *
 * - talk page: One per talk
 */
class TalkPagesGenerator implements ContentTypeGeneratorsInterface
{
    /**
     * @var TalkRepositoryInterface
     */
    private $talkRepository;

    /**
     * TalkPagesGenerator constructor.
     *
     * @param TalkRepositoryInterface $talkRepository
     */
    public function __construct(TalkRepositoryInterface $talkRepository)
    {
        $this->talkRepository = $talkRepository;
    }

    /**
     * Generate pages for content type.
     *
     * This includes:
     * - a page for each talk
     *
     * {@inheritdoc}
     */
    public function generatePages(TemplateRenderer $templateRenderer)
    {
        $talks = $this->talkRepository->getAll();

        foreach ($talks as $talk) {
            $this->generateTalkPage($templateRenderer, $talk);
        }
    }

    private function generateTalkPage(TemplateRenderer $templateRenderer, Talk $talk)
    {
        $event = $talk->getEvent();
        $filename = "events/{$event->getYear()}/{$event->getMonth()}/{$event->getSlug()}/{$talk->getSlug()}/index.html";
        $templateRenderer->render($filename, 'talk', ['talk' => $talk]);
    }
}
