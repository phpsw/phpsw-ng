<?php

namespace Phpsw\Website\Tests\Importer\EntityImporter;

use DateTime;
use Phpsw\Website\Entity\Location;
use Phpsw\Website\Importer\EntityImporter\Form\DateTransformer;
use Phpsw\Website\Repository\InMemory\LocationRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Tests Date transformer
 */
class DateTransformerTest extends TestCase
{
    /**
     * @var DateTransformer
     */
    private $dateTransformer;

    public function setUp()
    {
        $this->dateTransformer = new DateTransformer();
    }

    public function validDateDataProvider()
    {
        return [
            ['November 2016', '2016', '11'],
            ['March 2017', '2017', '03'],
        ];
    }


    /**
     * @dataProvider validDateDataProvider
     *
     * @param string $input
     * @param string $expectedYear
     * @param string $expectedMonth
     */
    public function testValidDate(string $input, string $expectedYear, string $expectedMonth)
    {
        /** @var DateTime $date */
        $date = $this->dateTransformer->reverseTransform($input);
        $this->assertEquals($expectedMonth, $date->format('m'));
        $this->assertEquals($expectedYear, $date->format('Y'));
    }

    public function testTransformEmptyData()
    {
        $actual = $this->dateTransformer->transform(null);
        $this->assertNull($actual);
    }

}
