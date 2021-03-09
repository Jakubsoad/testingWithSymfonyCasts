<?php


namespace AppBundle\Factory;


use AppBundle\Entity\Dinosaur;
use AppBundle\Service\DinosaurLengthDeterminator;
use Exception;

class DinosaurFactory
{
    /**
     * @var DinosaurLengthDeterminator
     */
    private $determinator;

    /**
     * DinosaurFactory constructor.
     * @param DinosaurLengthDeterminator $determinator
     */
    public function __construct(DinosaurLengthDeterminator $determinator)
    {
        $this->determinator = $determinator;
    }


    /**
     * @param int $length
     * @return Dinosaur
     */
    public function growVelociraptor(int $length): Dinosaur
    {
        return $this->createDinosaur('Velociraptor', true, $length);
    }

    /**
     * @param string $specification
     * @return Dinosaur
     * @throws Exception
     */
    public function growFromSpecification(string $specification): Dinosaur
    {
        $codeName = 'InG-' . random_int(1, 99999);
        $length = $this->determinator->getLengthFromSpecification($specification);
        $isCarnivorous = false;

        if (stripos($specification, 'carnivorous') !== false) {
            $isCarnivorous = true;
        }

        return $this->createDinosaur($codeName, $isCarnivorous, $length);
    }

    /**
     * @param string $genus
     * @param bool $isCarnivorous
     * @param int $length
     * @return Dinosaur
     */
    private function createDinosaur(string $genus, bool $isCarnivorous, int $length): Dinosaur
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);
        $dinosaur->setLength($length);

        return $dinosaur;
    }
}
