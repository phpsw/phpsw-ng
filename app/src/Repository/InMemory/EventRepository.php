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
}
