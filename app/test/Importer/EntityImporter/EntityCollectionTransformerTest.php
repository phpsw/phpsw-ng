<?php

namespace Phpsw\Website\Tests\Importer\EntityImporter;

use Phpsw\Website\Entity\Person;
use Phpsw\Website\Importer\EntityImporter\Form\PeopleTransformer;
use Phpsw\Website\Repository\InMemory\PersonRepository;
use Phpsw\Website\Repository\PersonRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests AbstractEntityCollectionTransformer using the PeopleTransformer concrete implementation.
 */
class EntityCollectionTransformerTest extends TestCase
{
    const PERSON_1 = 'person-1';
    const PERSON_2 = 'person-2';
    const INVALID_SLUG = 'invalid-slug';

    /**
     * @var Person
     */
    private $person1;

    /**
     * @var Person
     */
    private $person2;

    /**
     * @var PeopleTransformer
     */
    private $peopleTransformer;

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
        if (is_null($this->peopleTransformer)) {
            $personRepository = new PersonRepository();
            $this->person1 = $this->createPerson(self::PERSON_1, $personRepository);
            $this->person2 = $this->createPerson(self::PERSON_2, $personRepository);
            $this->peopleTransformer = new PeopleTransformer($personRepository);
        }
    }

    /**
     * DataProvider for tests, provides mappings between slugs and objects.
     *
     * @return array in format [[<slug>...], [<Person objects>...]]
     */
    public function dataProvider()
    {
        $this->setupVariables();

        return [
            [[], []],
            [[self::PERSON_1], [$this->person1]],
            [[self::PERSON_2, self::PERSON_1], [$this->person2, $this->person1]],
        ];
    }

    /**
     * Tests transforming data from Person objects to slugs.
     *
     * @dataProvider dataProvider
     *
     * @param string[] $slugs
     * @param Person[] $personObjects
     */
    public function testTransformData($slugs, $personObjects)
    {
        $actual = $this->peopleTransformer->transform($personObjects);
        $this->assertEquals($slugs, $actual);
    }

    /**
     * Tests transforming data from slugs to Person objects.
     *
     * @dataProvider dataProvider
     *
     * @param string[] $slugs
     * @param Person[] $personObjects
     */
    public function testReverseTransformData($slugs, $personObjects)
    {
        $actual = $this->peopleTransformer->reverseTransform($slugs);
        $this->assertEquals($personObjects, $actual);
    }

    public function testInvalidSlug()
    {
        $actual = $this->peopleTransformer->reverseTransform([self::PERSON_1, self::INVALID_SLUG, self::PERSON_2]);
        $expected = [$this->person1, $this->person2];
        $this->assertEquals($expected, $actual);
    }

    private function createPerson(string $slug, PersonRepositoryInterface $personRepository)
    {
        $person = new Person();
        $person->setSlug($slug);
        $personRepository->persist($person);

        return $person;
    }
}
