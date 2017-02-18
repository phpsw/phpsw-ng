<?php

namespace Phpsw\Website\Tests\Repository;

use Phpsw\Website\Container\Container;
use Phpsw\Website\Entity\Person;
use Phpsw\Website\Repository\PersonRepositoryInterface;
use PHPUnit\Framework\TestCase;

class PersonRepositoryTest extends TestCase
{
    public function testPersonRepository()
    {
        $container = new Container('test');

        /** @var PersonRepositoryInterface $personRepository */
        $personRepository = $container->get('app.common.personRepository');

        $person1 = new Person();
        $person1->setSlug('jenny');
        $person1->setName('Jenny Jones');
        $personRepository->persist($person1);

        $person2 = new Person();
        $person2->setSlug('adam');
        $person2->setName('Adam Smith');
        $personRepository->persist($person2);

        $actual = $personRepository->getAll();

        // People should be returned in alphabetical order of their slug values
        $expected = [$person2, $person1];

        $this->assertEquals($expected, $actual);
    }
}
