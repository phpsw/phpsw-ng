<?php

namespace Phpsw\Website\Tests\WebsiteGenerator\Router;

use Phpsw\Website\Common\RootDirectory;
use Phpsw\Website\WebsiteGenerator\Router\RouteGenerator;
use PHPUnit\Framework\TestCase;

class RouteGeneratorTest extends TestCase
{
    /**
     * @var RouteGenerator
     */
    private $routeGenerator;

    protected function setUp()
    {
        $rootDirectory = new RootDirectory(__DIR__.'/../../../../');
        $this->routeGenerator = new RouteGenerator($rootDirectory);
    }

    public function validRoutesDataProvider()
    {
        return [
            // expected URL, routeName, parameters
            ['/', 'home', []],
            ['/speakers/dave', 'speaker', ['speakerSlug' => 'dave']],
        ];
    }

    /**
     * @dataProvider validRoutesDataProvider
     *
     * @param string $expectedUrl
     * @param string $routeName
     * @param array $parameters
     */
    public function testRoutes(string $expectedUrl, string $routeName, array $parameters)
    {
        $actualUrl = $this->routeGenerator->getPath($routeName, $parameters);
        $this->assertEquals($expectedUrl, $actualUrl);
    }
}
