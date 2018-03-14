<?php

namespace Phpsw\Website\Tests\DataFileGenerator;

use Phpsw\Website\DataFileGenerator\EventFileGenerator;
use Phpsw\Website\DataFileGenerator\MeetupApiClient;
use PHPUnit\Framework\TestCase;

class EventFileGeneratorTest extends TestCase
{
    /** @var MeetupApiClient */
    private $mockMeetupApiClient;

    /** @var EventFileGenerator */
    private $eventFileGenerator;

    public function setUp()
    {
        $this->mockMeetupApiClient = $this->getMockBuilder('Phpsw\Website\DataFileGenerator\MeetupApiClient')
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventFileGenerator = new EventFileGenerator($this->mockMeetupApiClient);
    }

    public function testCreatingEventFromMeetupData()
    {
        $this->mockMeetupApiClient->expects($this->once())
            ->method('getEvents')
            ->will($this->returnValue($this->getMockMeetupAPIGetEventResponse()));

        $event = $this->eventFileGenerator->getEventFromMeetup(248129528);

        $this->assertEquals('248129528', $event->getMeetupId());
        $this->assertEquals(1521053100, $event->getDate()->getTimestamp());
        $this->assertEquals('A fantastic event!', $event->getTitle());
        $this->assertEquals('foo-bar', $event->getVenue()->getSlug());
        $this->assertEquals("In March we're holding a night of talks around the topic of Code Quality.", $event->getDescription());
    }

    public function testPubIsSetToVolunteerTavernIfMentionedInDescription()
    {
        $this->mockMeetupApiClient->expects($this->once())
            ->method('getEvents')
            ->will($this->returnValue($this->getMockMeetupAPIGetEventResponse()));

        $event = $this->eventFileGenerator->getEventFromMeetup(248129528);

        $this->assertEquals('volunteer-tavern', $event->getPub()->getSlug());
    }

    public function testReturnsEmptyEventIfDataMissingFromMeetup()
    {
        $response = new \stdClass();
        $response->results[0] = new \stdClass();

        $this->mockMeetupApiClient->expects($this->once())
            ->method('getEvents')
            ->will($this->returnValue($response));

        $event = $this->eventFileGenerator->getEventFromMeetup(12345);

        $this->assertEquals(12345, $event->getMeetupId());
        $this->assertEmpty($event->getDate());
        $this->assertEmpty($event->getTitle());
        $this->assertEmpty($event->getVenue());
        $this->assertEmpty($event->getDescription());
        $this->assertEmpty($event->getPub());
    }

    public function testExceptionThrownIfMeetupDoesNotReturnAnyEventsForRequestedId()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('no events or more than one event returned for id '. 123);

        $noResults = new \stdClass();
        $noResults->results = [];

        $this->mockMeetupApiClient->expects($this->once())
            ->method('getEvents')
            ->will($this->returnValue($noResults));

        $this->eventFileGenerator->getEventFromMeetup(123);
    }

    public function testExceptionThrownIfMeetupReturnsMoreThanOneEventForRequestedId()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('no events or more than one event returned for id '. 345);

        $manyResults = new \stdClass();
        $manyResults->results = [new \stdClass(), new \stdClass()];

        $this->mockMeetupApiClient->expects($this->once())
            ->method('getEvents')
            ->will($this->returnValue($manyResults));

        $this->eventFileGenerator->getEventFromMeetup(345);
    }

    /**
     * @return \stdClass
     */
    private function getMockMeetupAPIGetEventResponse()
    {
        $event = new \stdClass();

        $venue = new \stdClass();
        $venue->name = 'Foo Bar';
        $event->venue = $venue;

        $event->description = <<<EOQ
<p>In March we're holding a night of talks around the topic of Code Quality.</p> <p>Thanks to Brightpeal for kindly hosting us this month.</p> <p>Our talks this month:</p> <p>- Crafting Quality PHP Applications: an overview<br/>James Titcumb (<a href="http://twitter.com/asgrim" class="linkified">http://twitter.com/asgrim</a>), Conference speaker and developer with Roave (<a href="https://roave.com/" class="linkified">https://roave.com/</a>)</p> <p>This prototype works, but it's not pretty, and now it's in production. That legacy application really needs some TLC. Where do we start? When creating long lived applications, it's imperative to focus on good practices. The solution is to improve the whole development life cycle; from planning, better coding and testing, to automation, peer review and more. In this talk, we'll take a quick look into each of these areas, looking at how we can make positive, actionable change in our workflow.</p> <p>- Second Talk TBC</p> <p>--</p> <p>As always, a big thanks to our meetup sponsors Ents24 (<a href="http://www.ents24.com/" class="linkified">http://www.ents24.com/</a>), Brightpearl (<a href="http://www.brightpearl.com/" class="linkified">http://www.brightpearl.com/</a>), Space 48 (<a href="https://www.space48.com/" class="linkified">https://www.space48.com/</a>), Helastel (<a href="https://www.helastel.com/" class="linkified">https://www.helastel.com/</a>) &amp; Deep Blue Sky (<a href="http://deepbluesky.com/" class="linkified">http://deepbluesky.com/</a>) without whom we wouldn't be able to put on our meetups.</p> <p>Afterwards we'll head to the pub, probably the Volunteer Tavern (<a href="http://volunteertavern.co.uk/real-ales" class="linkified">http://volunteertavern.co.uk/real-ales</a>)!</p>
EOQ;

        $event->name = 'A fantastic event!';
        $event->id = '248129528';
        $event->time = 1521053100000;

        $response = new \stdClass();
        $response->results = [$event];

        return $response;
    }
}
