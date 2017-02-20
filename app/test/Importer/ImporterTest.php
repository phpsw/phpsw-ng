<?php

namespace Phpsw\Website\Tests\Importer;

use Phpsw\Website\Container\Container;
use Phpsw\Website\Entity\Location;
use Phpsw\Website\Entity\Person;
use Phpsw\Website\Entity\Sponsor;
use Phpsw\Website\Entity\WebsiteInfo;
use Phpsw\Website\Importer\Importer;
use Phpsw\Website\Repository\LocationRepositoryInterface;
use Phpsw\Website\Repository\PersonRepositoryInterface;
use Phpsw\Website\Repository\SponsorRepositoryInterface;
use Phpsw\Website\Repository\WebsiteInfoRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * This is more of an integration test for the Importer.
 *
 * The importer is run with entity data in the app/test/data directory.
 * Checks using the repositories are used to make sure the correct data has been imported.
 */
class ImporterTest extends TestCase
{
    /**
     * @var Container
     */
    private $container;

    public function setup()
    {
        $this->container = new Container('test');

        /** @var Importer $importer */
        $importer = $this->container->get('app.importer');
        $importer->import();
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
        $this->assertEquals([$basekit], $locationRepository->getAll());
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
        $organisers = [$this->getFredBlogs(), $this->getJohnSmith()];
        $websiteInfo = $this->getWebsiteInfo($organisers);
        $this->assertEquals([$websiteInfo], $websiteInfoRepository->getAll());
    }

    /**
     * @return Person
     */
    private function getFredBlogs()
    {
        $fredBlogs = new Person();
        $fredBlogs->setSlug('fred-blogs');
        $fredBlogs->setName('Fred Blogs');
        $fredBlogs->setDescription('Developer for Blogs Limited');
        $fredBlogs->setTwitterHandle('FredBlogs');

        return $fredBlogs;
    }

    /**
     * @return Person
     */
    private function getJohnSmith()
    {
        $johnSmith = new Person();
        $johnSmith->setSlug('john-smith');
        $johnSmith->setName('John Smith');
        $johnSmith->setDescription('Developer for Smith Limited');
        $johnSmith->setGithubHandle('JSmith');

        return $johnSmith;
    }

    /**
     * @return Location
     */
    private function getLocationBasekit()
    {
        $basekit = new Location();
        $basekit->setSlug('basekit');
        $basekit->setName('Basekit');
        $basekit->setAddress('5th Floor One Castle Park, Tower Hill, Bristol');
        $basekit->setPostcode('BS2 0JA');
        $basekit->setMapsUrl('http://map.google.com/basekit');

        return $basekit;
    }

    /**
     * @return Sponsor
     */
    private function getSponsorAcme()
    {
        $acme = new Sponsor();
        $acme->setSlug('acme');
        $acme->setName('Acme');
        $acme->setWebsiteUrl('http://acme.com');
        $acme->setLogoUrl('http://acme.com/logo');

        return $acme;
    }

    /**
     * @param Person[] $organisers
     *
     * @return WebsiteInfo
     */
    private function getWebsiteInfo($organisers)
    {
        $website = new WebsiteInfo();
        $website->setSlug('website');
        $website->setDescription('PHPSW is amazing');
        $website->setPhotoUrl('http://phpsq.uk/logo');
        $website->setOrganisers($organisers);

        return $website;
    }
}
