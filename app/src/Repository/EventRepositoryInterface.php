<?php

namespace Phpsw\Website\Repository;

use Phpsw\Website\Entity\Event;

interface EventRepositoryInterface
{
    /**
     * Save or update a Event entity.
     *
     * @param Event $event
     */
    public function persist(Event $event);

    /**
     * Returns all events ordered by event slug (in alphabetical order).
     *
     * @return Event[]
     */
    public function getAll();

    /**
     * Each event has it's own unique ID. This returns the matching event.
     *
     * @param string $eventId
     *
     * @return null|Event
     */
    public function findByEventId(string $eventId): ?Event;
}
