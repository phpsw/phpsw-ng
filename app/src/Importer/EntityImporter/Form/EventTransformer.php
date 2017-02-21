<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Phpsw\Website\Repository\InMemory\EventRepository;

class EventTransformer extends AbstractEntityTransformer
{
    /**
     * EventTransformer constructor.
     *
     * @param EventRepository $eventRepository
     */
    public function __construct(EventRepository $eventRepository)
    {
        parent::__construct($eventRepository);
    }
}
