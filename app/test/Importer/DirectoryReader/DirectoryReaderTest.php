<?php

namespace Phpsw\Website\Tests\Importer\DirectoryReader;

use Phpsw\Website\Common\RootDirectory;
use Phpsw\Website\Container\Container;
use Phpsw\Website\Importer\DirectoryReader\DirectoryReader;
use PHPUnit\Framework\TestCase;

class DirectoryReaderTest extends TestCase
{
    const TEST_DIRECTORY = 'app/test/Importer/DirectoryReader/dir1';

    public function testReadDirectory()
    {
        $container = new Container();

        /** @var RootDirectory $rootDirectory */
        $rootDirectory = $container->get('app.common.rootDirectory');
        $fullDir = $rootDirectory->getRootDirectory().'/'.self::TEST_DIRECTORY;

        $directoryReader = new DirectoryReader($rootDirectory);
        $actual = $directoryReader->getFileNameMappings(self::TEST_DIRECTORY);

        $expected = [
            'fred-bloggs' => "$fullDir/fred-bloggs.json",
            'john-smith' => "$fullDir/john-smith.json",
        ];

        $this->assertEquals($expected, $actual);
    }
}
