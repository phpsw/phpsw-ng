<?php

namespace Phpsw\Website\Tests\Importer\EntityImporter;

use Phpsw\Website\Container\Container;
use Phpsw\Website\Entity\Person;
use Phpsw\Website\Importer\EntityImporter\PersonImporter;
use Phpsw\Website\Importer\ValidationException;
use Phpsw\Website\Repository\PersonRepositoryInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

class PersonImporterTest extends TestCase
{
    const NAME = 'John Smith';
    const PHOTO_URL = 'http://photo/john-smith';
    const DESCRIPTION = 'Developer at Acme';
    const TWITTER_HANDLE = '@johnsmith';
    const GITHUB_HANDLE = 'johnsmith';
    const WEBSITE_URL = 'http://www.johnsmith.com';
    const MEETUP_ID = 123;
    const SLUG = 'john-smith';

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $mockPersonRepository;

    /**
     * @var PersonImporter
     */
    private $personImporter;

    public function setUp()
    {
        $container = new Container('test');
        $dataToEntityConverter = $container->get('app.importer.dataToEntityImporter');

        $this->mockPersonRepository = $this->getMockBuilder(PersonRepositoryInterface::class)->getMock();
        $this->personImporter = new PersonImporter($this->mockPersonRepository, $dataToEntityConverter);
    }

    public function testImportPersonAllFieldsSet()
    {
        // Given
        $expectedPerson = new Person();
        $expectedPerson->setSlug(self::SLUG);
        $expectedPerson->setName(self::NAME);
        $expectedPerson->setPhotoUrl(self::PHOTO_URL);
        $expectedPerson->setDescription(self::DESCRIPTION);
        $expectedPerson->setTwitterHandle(self::TWITTER_HANDLE);
        $expectedPerson->setGithubHandle(self::GITHUB_HANDLE);
        $expectedPerson->setWebsiteUrl(self::WEBSITE_URL);
        $expectedPerson->setMeetupId(self::MEETUP_ID);

        $inputData = [
            'name' => self::NAME,
            'photo-url' => self::PHOTO_URL,
            'description' => self::DESCRIPTION,
            'twitter-handle' => self::TWITTER_HANDLE,
            'github-handle' => self::GITHUB_HANDLE,
            'website-url' => self::WEBSITE_URL,
            'meetup-id' => self::MEETUP_ID,
        ];

        // Expect
        $this->mockPersonRepository->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($expectedPerson));

        // When
        $this->personImporter->importEntity(self::SLUG, $inputData);
    }

    public function testImportPersonWithSomeFieldsSet()
    {
        //Given
        $expectedPerson = new Person();
        $expectedPerson->setSlug(self::SLUG);
        $expectedPerson->setName(self::NAME);
        $expectedPerson->setDescription(self::DESCRIPTION);

        $inputData = [
            'name' => self::NAME,
            'description' => self::DESCRIPTION,
        ];

        // When
        $this->mockPersonRepository->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($expectedPerson));

        // Expect
        $this->personImporter->importEntity(self::SLUG, $inputData);
    }

    public function testImportPersonWithMissingDescriptionField()
    {
        $inputData = [
            'name' => self::NAME,
        ];

        try {
            $this->personImporter->importEntity(self::SLUG, $inputData);
            $this->fail('Expected ValidatorException to be thrown');
        } catch (ValidationException $e) {
            $this->assertValidationErrors([
                ['field' => 'description', 'entity' => self::SLUG],
            ], $e);
        }
    }

    public function testImportPersonWithInvalidData()
    {
        $inputData = [
            'name' => self::NAME,
            'description' => self::DESCRIPTION,
            'meetup-id' => 'foo',
            'website-url' => 'Not a web address',
        ];

        try {
            $this->personImporter->importEntity(self::SLUG, $inputData);
            $this->fail('Expected ValidatorException to be thrown');
        } catch (ValidationException $e) {
            $this->assertValidationErrors([
                ['field' => 'meetup-id', 'entity' => self::SLUG],
                ['field' => 'website-url', 'entity' => self::SLUG],
            ], $e);
        }
    }

    /**
     * @param array $expectedValidationErrors
     * @param ValidationException $e
     */
    private function assertValidationErrors(array $expectedValidationErrors, ValidationException $e)
    {
        $actualValidationErrors = $e->getValidationErrors();
        $this->assertEquals(count($expectedValidationErrors), count($actualValidationErrors));

        foreach ($expectedValidationErrors as $expectedValidationError) {
            $found = false;
            foreach ($actualValidationErrors as $actualValidationError) {
                if (($actualValidationError->getEntityType() == Person::class) &&
                    ($actualValidationError->getField() == $expectedValidationError['field']) &&
                    ($actualValidationError->getEntity() == $expectedValidationError['entity'])
                ) {
                    $found = true;
                }
            }
            if (!$found) {
                $this->fail("Could not find error for field [{$expectedValidationError['field']}]");
            }
        }
    }
}
