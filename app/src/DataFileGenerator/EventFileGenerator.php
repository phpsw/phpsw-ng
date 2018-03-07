<?php

namespace Phpsw\Website\DataFileGenerator;

use Phpsw\Website\Common\StringUtils;
use Phpsw\Website\Entity\Event;
use Phpsw\Website\Entity\Location;

class EventFileGenerator
{
    /** @var MeetupApiClient */
    private $meetupAPIClient;

    /**
     * PersonFileGenerator constructor.
     *
     * @param MeetupApiClient $meetupAPIClient
     */
    public function __construct(MeetupApiClient $meetupAPIClient)
    {
        $this->meetupAPIClient = $meetupAPIClient;
    }

    /**
     * @param int $meetupId
     *
     * @throws \Exception
     *
     * @return Event
     */
    public function getEventFromMeetup(int $meetupId)
    {
        $result = $this->meetupAPIClient->getEvents(['event_id' => $meetupId]);

        if (1 !== count($result->results)) {
            throw new \Exception("more than one event returned for id {$meetupId}");
        }

        $eventRaw = $result->results[0];

        $event = new Event();
        $event->setMeetupId($meetupId);

        if (!empty($eventRaw->time)) {
            $dt = new \DateTime();
            $dt->setTimestamp(($eventRaw->time / 1000));
            $event->setDate($dt);
        }

        if (!empty($eventRaw->name)) {
            $event->setTitle($eventRaw->name);
        }

        if (!empty($eventRaw->description)) {
            $description = strip_tags($eventRaw->description);
            // take the first sentence only
            $event->setDescription(substr($description, 0, strpos($description, '.') + 1));

            // guess the pub too
            $pub = '';
            if (false !== strpos($eventRaw->description, 'Volunteer Tavern')) {
                $pub = StringUtils::slugify('Volunteer Tavern');
            }
            $event->setPub($pub);
        }

        if (!empty($eventRaw->venue->name)) {
            $venue = new Location();
            $venue->setSlug(StringUtils::slugify($eventRaw->venue->name));
            $event->setVenue($venue);
        }

        return $event;
    }

    /**
     * @param Event $event
     *
     * @throws \Exception
     *
     * @return string
     */
    public function generateFile(Event $event)
    {
        if (empty($event->getTitle())) {
            throw new \Exception('no filename available for this file - does this event have a name?');
        }

        $organisers = [];
        // rough guesses - delete as appropriate from each file
        if ($event->getDate()->getTimestamp() > strtotime('2016-02-10')) {
            $organisers = ['lee-stone', 'dave-liddament', 'kat-zien', 'oliver-davies'];
        } elseif (
            $event->getDate()->getTimestamp() > strtotime('2013-11-01')
            && $event->getDate()->getTimestamp() < strtotime('2015-10-01')
        ) {
            $organisers = ['steve-lacey', 'adrian-slade'];
        } elseif (
            $event->getDate()->getTimestamp() < strtotime('2013-12-01')
        ) {
            $organisers = ['andrew-martin', 'adrian-slade'];
        }

        $data = [
            'meetup-id' => $event->getMeetupId(),
            'title' => $event->getTitle(),
            'description' => $event->getDescription(),
            'date' => $event->getDate()->format('d F Y'),
            'venue' => $event->getVenue()->getSlug(),
            'pub' => $event->getPub(),
            'organisers' => $organisers,
            'sponsors' => ['basekit', 'brightpearl', 'deep-blue-sky', 'ents24', 'equiniti', 'meanbee'],
        ];

        $dir = './data/events/generated/'.$event->getDate()->format('Y');
        $fileName = StringUtils::slugify($event->getTitle()).'.json';
        $filePath = "{$dir}/{$fileName}";

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $handle = fopen($filePath, 'w') or die('Cannot open file:  '.$filePath);
        fwrite($handle, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        fclose($handle);

        return $filePath;
    }
}
