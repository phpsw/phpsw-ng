<?php

namespace Phpsw\Website\Tests\Importer;

use Phpsw\Website\Container\Container;
use Phpsw\Website\Entity\Location;
use Phpsw\Website\Entity\Person;
use Phpsw\Website\Entity\Sponsor;
use Phpsw\Website\Importer\Importer;
use Phpsw\Website\Repository\LocationRepositoryInterface;
use Phpsw\Website\Repository\PersonRepositoryInterface;
use Phpsw\Website\Repository\SponsorRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * This is more of an integration test for the Importer.
 *
 * The importer is run with entity data in the app/test/data directory.
 * Checks using the repositories are used to make sure the correct data has been imported.
 */
class ImporterTest extends TestCase
{
    public function testImport()
    {
        $container = new Container('test');

        /** @var Importer $importer */
        $importer = $container->get('app.importer');
        $importer->import();

        $this->assertPeople($container);
        $this->assertLocations($container);
        $this->assertSponsors($container);
    }

    private function assertPeople(Container $container)
    {
        /** @var PersonRepositoryInterface $personRepository */
        $personRepository = $container->get('app.common.personRepository');

        $fredBlogs = new Person();
        $fredBlogs->setSlug('fred-blogs');
        $fredBlogs->setName('Fred Blogs');
        $fredBlogs->setDescription('Developer for Blogs Limited');
        $fredBlogs->setTwitterHandle('FredBlogs');

        $johnSmith = new Person();
        $johnSmith->setSlug('john-smith');
        $johnSmith->setName('John Smith');
        $johnSmith->setDescription('Developer for Smith Limited');
        $johnSmith->setGithubHandle('JSmith');

        $this->assertEquals([$fredBlogs, $johnSmith], $personRepository->getAll());
    }

    private function assertLocations(Container $container)
    {
        /** @var LocationRepositoryInterface $locationRepository */
        $locationRepository = $container->get('app.common.locationRepository');

        $basekit = new Location();
        $basekit->setSlug('basekit');
        $basekit->setName('Basekit');
        $basekit->setAddress('5th Floor One Castle Park, Tower Hill, Bristol');
        $basekit->setPostcode('BS2 0JA');
        $basekit->setMapsUrl('http://map.google.com/basekit');
        $this->assertEquals([$basekit], $locationRepository->getAll());
    }

    private function assertSponsors(Container $container)
    {
        /** @var SponsorRepositoryInterface $sponsorRepository */
        $sponsorRepository = $container->get('app.common.sponsorRepository');

        $acme = new Sponsor();
        $acme->setSlug('acme');
        $acme->setName('Acme');
        $acme->setWebsiteUrl('http://acme.com');
        $acme->setLogoUrl('http://acme.com/logo');

        $this->assertEquals([$acme], $sponsorRepository->getAll());
    }
}
