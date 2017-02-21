<?php

namespace Phpsw\Website\Tests\Importer\EntityImporter;

use Phpsw\Website\Entity\Sponsor;
use Phpsw\Website\Importer\EntityImporter\Form\SponsorsTransformer;
use Phpsw\Website\Repository\InMemory\SponsorRepository;
use Phpsw\Website\Repository\SponsorRepositoryInterface;
use PHPUnit\Framework\TestCase;

class SponsorsTransformerTest extends TestCase
{
    const SPONSOR_1 = 'sponsor-1';
    const SPONSOR_2 = 'sponsor-2';
    const INVALID_SLUG = 'invalid-slug';

    /**
     * @var Sponsor
     */
    private $sponsor1;

    /**
     * @var Sponsor
     */
    private $sponsor2;

    /**
     * @var SponsorsTransformer
     */
    private $sponsorsTransformer;

    public function setUp()
    {
        $this->setupVariables();
    }

    /**
     * DataProviders are run before setup the first time through a test execution.
     * https://phpunit.de/manual/current/en/writing-tests-for-phpunit.html#writing-tests-for-phpunit.data-providers.
     *
     * So setup needs potentially doing in either setup or a dataprovider, they both call this method for setup.
     */
    private function setupVariables()
    {
        // dataProvider is run before setup the first time round, so we can't do all setup in either method
        if (is_null($this->sponsorsTransformer)) {
            $sponsorRepository = new SponsorRepository();
            $this->sponsor1 = $this->createSponsor(self::SPONSOR_1, $sponsorRepository);
            $this->sponsor2 = $this->createSponsor(self::SPONSOR_2, $sponsorRepository);
            $this->sponsorsTransformer = new SponsorsTransformer($sponsorRepository);
        }
    }

    /**
     * DataProvider for tests, provides mappings between slugs and objects.
     *
     * @return array in format [[<slug>...], [<Sponsor objects>...]]
     */
    public function dataProvider()
    {
        $this->setupVariables();

        return [
            [[], []],
            [[self::SPONSOR_1], [$this->sponsor1]],
            [[self::SPONSOR_2, self::SPONSOR_1], [$this->sponsor2, $this->sponsor1]],
        ];
    }

    /**
     * Tests transforming data from Sponsor objects to slugs.
     *
     * @dataProvider dataProvider
     *
     * @param string[] $slugs
     * @param Sponsor[] $sponsorObjects
     */
    public function testTransformData($slugs, $sponsorObjects)
    {
        $actual = $this->sponsorsTransformer->transform($sponsorObjects);
        $this->assertEquals($slugs, $actual);
    }

    /**
     * Tests transforming data from slugs to Sponsor objects.
     *
     * @dataProvider dataProvider
     *
     * @param string[] $slugs
     * @param Sponsor[] $sponsorObjects
     */
    public function testReverseTransformData($slugs, $sponsorObjects)
    {
        $actual = $this->sponsorsTransformer->reverseTransform($slugs);
        $this->assertEquals($sponsorObjects, $actual);
    }

    /**
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function testInvalidSlug()
    {
        $this->sponsorsTransformer->reverseTransform([self::SPONSOR_1, self::SPONSOR_2, self::INVALID_SLUG]);
    }

    private function createSponsor(string $slug, SponsorRepositoryInterface $sponsorRepository)
    {
        $sponsor = new Sponsor();
        $sponsor->setSlug($slug);
        $sponsorRepository->persist($sponsor);

        return $sponsor;
    }
}
