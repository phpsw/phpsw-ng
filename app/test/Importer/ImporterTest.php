<?php

namespace Phpsw\Website\Tests\Importer;

use Phpsw\Website\Container\Container;
use Phpsw\Website\Entity\Person;
use Phpsw\Website\Importer\Importer;
use Phpsw\Website\Repository\PersonRepositoryInterface;
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
}
