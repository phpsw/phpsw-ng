<?php

namespace Phpsw\Website\DataFileGenerator;

use Phpsw\Website\Common\StringUtils;
use Phpsw\Website\Entity\Event;

class TalkFileGenerator
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
    public function getEventDescriptionFromMeetup(int $meetupId)
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
            $event->setDescription($eventRaw->description);
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

        $eventTitleSlug = StringUtils::slugify($event->getTitle());

        $data = [
            'description' => $event->getDescription(),
            'event' => $eventTitleSlug,
        ];

        $dir = __DIR__.'/../../../data/talks/generated/'.$event->getDate()->format('Y/m');
        $fileName = $eventTitleSlug.'.json';
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
