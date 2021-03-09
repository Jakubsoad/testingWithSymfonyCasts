<?php


namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Dinosaur;
use AppBundle\Exception\DinosaursAreRunningRampantException;
use AppBundle\Exception\NotABuffetException;
use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Enclosure;

class EnclosureTest extends TestCase
{
    public function testItHasNoDinosaursByDefault()
    {
        $enclosure = new Enclosure();

        $this->assertEmpty($enclosure->getDinosaurs());
    }

    public function testItAddsDinosaurs()
    {
        $enclosure = new Enclosure(true);

        $enclosure->addDinosaur(new Dinosaur());
        $enclosure->addDinosaur(new Dinosaur());

        $this->assertCount(2, $enclosure->getDinosaurs());
    }

    public function testItDoesNotAllowCarnivorousDinosaursToMixWithHerbivorous()
    {
        $enclosure = new Enclosure(true);
        $enclosure->addDinosaur(new Dinosaur());

        $this->expectException(NotABuffetException::class);

        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
    }

    public function testItDoesNotAllowToAddDinosaursToUnsecureEnclosures()
    {
        $enclosure = new Enclosure();

        $this->expectException(DinosaursAreRunningRampantException::class);
        $this->expectExceptionMessage('Are ya crazy?!');

        $enclosure->addDinosaur(new Dinosaur());
    }
}