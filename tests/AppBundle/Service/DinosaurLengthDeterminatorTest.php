<?php


namespace Tests\AppBundle\Service;


use AppBundle\Entity\Dinosaur;
use AppBundle\Service\DinosaurLengthDeterminator;
use PHPUnit\Framework\TestCase;

class DinosaurLengthDeterminatorTest extends TestCase
{

    /**
     * @dataProvider getSpecLengthTest()
     */
    public function testItReturnsCorrectLengthRange($spec, $minExpectedSize, $maxExceptedSize)
    {
        $determinator = new DinosaurLengthDeterminator();
        $actualSize = $determinator->getLengthFromSpecification($spec);

        $this->assertGreaterThanOrEqual($minExpectedSize, $actualSize);
        $this->assertLessThanOrEqual($maxExceptedSize, $actualSize);
    }

    /**
     * @return array[]
     */
    public function getSpecLengthTest()
    {
        return [
            ['large carnivorous dinosaur', Dinosaur::LARGE, Dinosaur::HUGE - 1],
            ['give me all the cookies!', 0, Dinosaur::LARGE - 1],
            ['large herbivore', Dinosaur::LARGE, Dinosaur::HUGE - 1],
            ['huge herbivore', Dinosaur::HUGE, 100],
        ];
    }
}