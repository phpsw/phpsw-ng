<?php

namespace Phpsw\Website\DataFileGenerator;

use Phpsw\Website\Entity\Person;

class PersonFileGenerator
{
    const GITHUB_BASE_URL = 'https://github.com/';

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
     * @return Person
     */
    public function getPersonFromMeetup(int $meetupId)
    {
        $result = $this->meetupAPIClient->getMembers(['member_id' => $meetupId]);
        if (count($result->results) !== 1) {
            throw new \Exception("more than one member profile returned for id {$meetupId}");
        }

        $member = $result->results[0];

        $person = new Person();
        $person->setMeetupId($meetupId);

        if (!empty($member->name)) {
            $person->setName($member->name);
        }

        if (!empty($member->photo->highres_link)) {
            $person->setPhotoUrl($member->photo->highres_link);
        }

        if (!empty($member->bio)) {
            $person->setDescription($member->bio);
        } else {
            // /members seems to not be returning the bio, so try the /profiles endpoint
            // (this will only work if this person is a member of the php-sw meetup group)
            $r = $this->meetupAPIClient->getProfiles(['member_id' => $meetupId, 'group_urlname' => 'php-sw']);
            if (count($r->results) === 1) {
                $m = $r->results[0];

                if (!empty($m->other_services->twitter->identifier)) {
                    $person->setTwitterHandle(str_replace('@', '', $m->other_services->twitter->identifier));
                }
            }
        }

        if (!empty($member->other_services->twitter->identifier)) {
            $person->setTwitterHandle(str_replace('@', '', $member->other_services->twitter->identifier));
        }

        if (!empty($member->site_url)) {
            $person->setWebsiteUrl($member->site_url);
        }

        $person->setGithubHandle($this->guessGithub($person));

        return $person;
    }

    /**
     * Tries the twitter handle and the slug as the github ID,
     * if either works the full URL is returned. Otherwise returns null.
     *
     * @param Person $person
     *
     * @return string|null
     */
    private function guessGithub(Person $person)
    {
        if (!empty($person->getTwitterHandle())) {
            if ($fp = curl_init(self::GITHUB_BASE_URL.$person->getTwitterHandle())) {
                return self::GITHUB_BASE_URL.$person->getTwitterHandle();
            }
        }

        if (!empty($person->getSlug())) {
            if ($fp = curl_init(self::GITHUB_BASE_URL.$person->getSlug())) {
                return self::GITHUB_BASE_URL.$person->getSlug();
            }
        }

        return null;
    }

    /**
     * @param Person $person
     *
     * @throws \Exception
     *
     * @return string
     */
    public function generateFile(Person $person)
    {
        $fileName = strtolower(str_replace(' ', '-', $person->getName())).'.json';

        if ($fileName === '.json') {
            throw new \Exception('no filename available for this file - does this person have a name?');
        }
        $filePath = './data/people/'.$fileName;

        $data = [
            'name' => $person->getName(),
            'photo-url' => $person->getPhotoUrl(),
            'description' => $person->getDescription(),
            'twitter-handle' => $person->getTwitterHandle(),
            'github-handle' => $person->getGithubHandle(),
            'website-url' => $person->getWebsiteUrl(),
            'meetup-id' => $person->getMeetupId(),
        ];

        $handle = fopen($filePath, 'w') or die('Cannot open file:  '.$filePath);
        fwrite($handle, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        fclose($handle);

        return $filePath;
    }
}
