<?php

namespace Phpsw\Website\WebsiteGenerator\TemplateRenderer\TwigExtension;

use Phpsw\Website\Entity\Event;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Provides data formatting.
 */
class DateTwigExtension extends Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('eventDate', [$this, 'getEventDate']),
        ];
    }

    /**
     * Returns human readable version of an events date (format <month name> <year>).
     *
     * @param Event $event
     *
     * @return string
     */
    public function getEventDate(Event $event): string
    {
        return date('F Y', mktime(0, 0, 0, $event->getMonth(), 1, $event->getYear()));
    }
}
