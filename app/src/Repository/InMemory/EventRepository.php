<?php

namespace Phpsw\Website\Repository\InMemory;

use Phpsw\Website\Entity\Event;
use Phpsw\Website\Repository\EventRepositoryInterface;

/**
 * In memory implementation of a EventRepository.
 */
class EventRepository extends AbstractRepository implements EventRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persist(Event $event)
    {
        $this->persistEntity($event);
    }

    public function findByEventId(string $eventId): ?Event
    {
        /** @var Event $event */
        foreach ($this->getAll() as $event) {
            if ($eventId === $event->getEventId()) {
                return $event;
            }
        }

        return null;
    }
}
