<?php

namespace Phpsw\Website\Tests\Importer;

use DateTime;
use Phpsw\Website\Container\Container;
use Phpsw\Website\Entity\Event;
use Phpsw\Website\Entity\Location;
use Phpsw\Website\Entity\Person;
use Phpsw\Website\Entity\Sponsor;
use Phpsw\Website\Entity\Talk;
use Phpsw\Website\Entity\WebsiteInfo;
use Phpsw\Website\Importer\Importer;
use Phpsw\Website\Repository\EventRepositoryInterface;
use Phpsw\Website\Repository\LocationRepositoryInterface;
use Phpsw\Website\Repository\PersonRepositoryInterface;
use Phpsw\Website\Repository\SponsorRepositoryInterface;
use Phpsw\Website\Repository\TalkRepositoryInterface;
use Phpsw\Website\Repository\WebsiteInfoRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * This is more of an integration test for the Importer.
 *
 * The importer is run with entity data in the app/test/data directory.
 * Checks using the repositories are used to make sure the correct data has been imported.
 *
 * Due to circular references between Talk and other objects we need to be careful about how we create the expected
 * objects (the ones created by the get*() methods). These should only be called once per test case, the values are
 * cached and subsequent calls mean that cached versions are returned.
 * If we didn't do this then we'd either get caught in an infinite loop or have missing related entities.
 *
 * An example related entity is Talk to Person (via Talk's speakers property). When setting a Talk's speakers the
 * Talk::setSpeakers method calls the Person::addTalk method to give the 2 way connection (e.g. emulating a many to
 * many relationship). By making sure only one instance of a Person (e.g. John Smith) is created per test case, by
 * using a cache mechanism, prevents test code from going into infinite loops.
 */
class ImporterTest extends TestCase
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var array
     */
    private $cache;

    public function setup()
    {
        $this->container = new Container('test');

        /** @var Importer $importer */
        $importer = $this->container->get('app.importer');
        $importer->import();

        // Empty cache for test case
        $this->cache = [];

        // This needs to be called to update all relationships between Talk and Person objects.
        $this->getTalk();
    }

    public function testImportPeople()
    {
        /** @var PersonRepositoryInterface $personRepository */
        $personRepository = $this->container->get('app.common.personRepository');

        $fredBlogs = $this->getFredBlogs();
        $johnSmith = $this->getJohnSmith();

        $this->assertEquals([$fredBlogs, $johnSmith], $personRepository->getAll());
    }

    public function testImportLocations()
    {
        /** @var LocationRepositoryInterface $locationRepository */
        $locationRepository = $this->container->get('app.common.locationRepository');
        $basekit = $this->getLocationBasekit();
        $pub = $this->getLocationPub();
        $this->assertEquals([$basekit, $pub], $locationRepository->getAll());
    }

    public function testImportSponsors()
    {
        /** @var SponsorRepositoryInterface $sponsorRepository */
        $sponsorRepository = $this->container->get('app.common.sponsorRepository');
        $acme = $this->getSponsorAcme();
        $this->assertEquals([$acme], $sponsorRepository->getAll());
    }

    public function testImportWebsite()
    {
        /** @var WebsiteInfoRepositoryInterface $websiteInfoRepository */
        $websiteInfoRepository = $this->container->get('app.common.websiteInfoRepository');
        $websiteInfo = $this->getWebsiteInfo();
        $this->assertEquals($websiteInfo, $websiteInfoRepository->getWebsiteInfo());
    }

    public function testImportEvent()
    {
        /** @var EventRepositoryInterface $eventRepository */
        $eventRepository = $this->container->get('app.common.eventRepository');
        $event = $this->getEvent();
        $this->assertEquals([$event], $eventRepository->getAll());
    }

    public function testImportTalk()
    {
        /** @var TalkRepositoryInterface $talkRepository */
        $talkRepository = $this->container->get('app.common.talkRepository');
        $talk = $this->getTalk();
        $this->assertEquals([$talk], $talkRepository->getAll());
    }

    /**
     * @return Person
     */
    private function getFredBlogs()
    {
        return $this->getValue('fredBlogs', function () {
            $fredBlogs = new Person();
            $fredBlogs->setSlug('fred-blogs');
            $fredBlogs->setName('Fred Blogs');
            $fredBlogs->setDescription('Developer for Blogs Limited');
            $fredBlogs->setTwitterHandle('FredBlogs');

            return $fredBlogs;
        });
    }

    /**
     * @return Person
     */
    private function getJohnSmith()
    {
        return $this->getValue('johnSmith', function () {
            $johnSmith = new Person();
            $johnSmith->setSlug('john-smith');
            $johnSmith->setName('John Smith');
            $johnSmith->setDescription('Developer for Smith Limited');
            $johnSmith->setGithubHandle('JSmith');

            return $johnSmith;
        });
    }

    /**
     * @return Location
     */
    private function getLocationBasekit()
    {
        return $this->getValue('basekit', function () {
            $basekit = new Location();
            $basekit->setSlug('basekit');
            $basekit->setName('Basekit');
            $basekit->setAddress('5th Floor One Castle Park, Tower Hill, Bristol');
            $basekit->setPostcode('BS2 0JA');
            $basekit->setMapsUrl('http://map.google.com/basekit');

            return $basekit;
        });
    }

    /**
     * @return Location
     */
    private function getLocationPub()
    {
        return $this->getValue('pub', function () {
            $pub = new Location();
            $pub->setSlug('pub');
            $pub->setName('Pub');
            $pub->setAddress('1 road');
            $pub->setPostcode('BS1 2AB');
            $pub->setMapsUrl('http://map.google.com/pub');

            return $pub;
        });
    }

    /**
     * @return Sponsor
     */
    private function getSponsorAcme()
    {
        return $this->getValue('acme', function () {
            $acme = new Sponsor();
            $acme->setSlug('acme');
            $acme->setName('Acme');
            $acme->setWebsiteUrl('http://acme.com');
            $acme->setLogoUrl('http://acme.com/logo');

            return $acme;
        });
    }

    /**
     * @return WebsiteInfo
     */
    private function getWebsiteInfo()
    {
        return $this->getValue('website', function () {
            $organisers = [$this->getFredBlogs(), $this->getJohnSmith()];
            $sponsors = [$this->getSponsorAcme()];
            $website = new WebsiteInfo();
            $website->setSlug('website');
            $website->setEmailAddress('test@example.com');
            $website->setMeetupUrl('http://example.com');
            $website->setSponsors($sponsors);
            $website->setOrganisers($organisers);
            $website->setFriends($this->getFriends());

            return $website;
        });
    }

    /**
     * @return Event
     */
    private function getEvent()
    {
        $timestamp = strtotime('November 2016');
        $dateTime = new DateTime();
        $dateTime->setTimestamp($timestamp);

        return $this->getValue('event', function () use ($dateTime) {
            $event = new Event();
            $event->setSlug('new-skills');
            $event->setDescription('learn something new');
            $event->setDate($dateTime);
            $event->setMeetupId('123');
            $event->setOrganisers([$this->getJohnSmith()]);
            $event->setPub($this->getLocationPub());
            $event->setVenue($this->getLocationBasekit());
            $event->setSponsors([$this->getSponsorAcme()]);
            $event->setTitle('New skills');

            return $event;
        });
    }

    private function getTalk()
    {
        return $this->getValue('talk', function () {
            $talk = new Talk();
            $talk->setSlug('soft-skills');
            $talk->setTitle('Soft skills');
            $talk->setAbstract('Learn more soft skills');
            $talk->setEvent($this->getEvent());
            $talk->setSlidesUrl('http://talk.com/slides');
            $talk->setVideoUrl('http://talk.com/video');
            $talk->setJoindinUrl('http://joindin.com/talk');
            $talk->setSpeakers([$this->getFredBlogs()]);

            return $talk;
        });
    }

    private function getValue(string $key, callable $func)
    {
        if (!array_key_exists($key, $this->cache)) {
            $this->cache[$key] = $func();
        }

        return $this->cache[$key];
    }

    private function getFriends() {
        return [
            [
                'name' => 'A friend',
                'logoUrl' => 'logo.png',
                'websiteUrl' => 'http://example.com',
            ]
        ];
    }
}
