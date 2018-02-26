<?php

namespace Phpsw\Website\Tests\Common;

use Phpsw\Website\Common\StringUtils;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase
{
    public function testSlugify()
    {
        $cases = [
            'John Doe ' => 'john-doe',
            'This, is a talk "title"' => 'this-is-a-talk-title',
            'Command & Emission Control' => 'command-emission-control',
            'Foo $ B_ar' => 'foo-b-ar',
            ' So (many) {brackets} it\'s crazy[!] ' => 'so-many-brackets-its-crazy',
            '   Rob %Allén ' => 'rob-allen',
        ];

        foreach ($cases as $input => $expected) {
            $this->assertEquals($expected, StringUtils::slugify($input));
        }
    }
}
