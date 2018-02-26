<?php

declare(strict_types=1);

namespace Phpsw\Website\Tests\WebsiteGenerator\TemplateRenderer\TwigExtension;

use DateTime;
use Phpsw\Website\Entity\Event;
use Phpsw\Website\WebsiteGenerator\TemplateRenderer\TwigExtension\DateTwigExtension;
use PHPUnit\Framework\TestCase;

class DateTwigExtensionTest extends TestCase
{
    public function testMarch2017()
    {
        $event = new Event();
        $event->setDate(new DateTime('2017-03-28'));

        $dateTwigExtension = new DateTwigExtension();
        $actual = $dateTwigExtension->getEventDate($event);

        $this->assertEquals('March 2017', $actual);
    }
}
