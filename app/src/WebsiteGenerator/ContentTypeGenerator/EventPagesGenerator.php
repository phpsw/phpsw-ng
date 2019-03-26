<?php

namespace Phpsw\Website\WebsiteGenerator\ContentTypeGenerator;

use Phpsw\Website\Entity\Event;
use Phpsw\Website\Repository\EventRepositoryInterface;
use Phpsw\Website\WebsiteGenerator\TemplateRenderer\TemplateRenderer;

/**
 * Generates:.
 *
 * - events page: lists all events
 * - event page: One per event, this lists all the talks the happened on that event
 */
class EventPagesGenerator implements ContentTypeGeneratorsInterface
{
    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    /**
     * EventPagesGenerator constructor.
     *
     * @param EventRepositoryInterface $eventRepository
     */
    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Generate pages for content type.
     *
     * This includes:
     * - a page that lists all events
     * - a page for each event
     *
     * {@inheritdoc}
     */
    public function generatePages(TemplateRenderer $templateRenderer)
    {
        $events = $this->eventRepository->getAll();

        // Order by date
        usort($events, function (Event $a, Event $b) {
            return $a->getDate()->getTimestamp() <=> $b->getDate()->getTimestamp();
        });

        foreach ($events as $event) {
            $this->generateEventPage($templateRenderer, $event);
        }

        $templateRenderer->render('events/index.html', 'events.html', [
            'events' => $events,
        ]);
    }

    private function generateEventPage(TemplateRenderer $templateRenderer, Event $event)
    {
        $filename = "events/{$event->getYear()}/{$event->getMonth()}/{$event->getSlug()}/index.html";
        $templateRenderer->render($filename, 'event.html', ['event' => $event]);
    }
}
