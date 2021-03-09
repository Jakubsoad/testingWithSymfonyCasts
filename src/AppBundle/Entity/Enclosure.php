<?php


namespace AppBundle\Entity;


use AppBundle\Exception\DinosaursAreRunningRampantException;
use AppBundle\Exception\NotABuffetException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="enclosure")
 */
class Enclosure
{
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dinosaur", mappedBy="enclosure", cascade={"persist"})
     */
    private $dinosaurs;

    /**
     * @var Collection|Security[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Enclosure", inversedBy="securities", cascade={"persist"})
     */
    private $securities;

    /**
     * Enclosure constructor.
     */
    public function __construct(bool $withBasicSecurity = false)
    {
        $this->dinosaurs = new ArrayCollection();
        $this->securities = new ArrayCollection();

        if ($withBasicSecurity) {
            $this->addSecurity(new Security('Fence', true, $this));
        }
    }

    /**
     * @return Collection
     */
    public function getDinosaurs(): Collection
    {
        return $this->dinosaurs;
    }

    /**
     * @param Dinosaur $dinosaur
     * @throws NotABuffetException
     * @throws DinosaursAreRunningRampantException
     */
    public function addDinosaur(Dinosaur $dinosaur)
    {
        if (!$this->canAddDinosaur($dinosaur)) {
            throw new NotABuffetException();
        }

        if (!$this->isSecurityActive()) {
            throw new DinosaursAreRunningRampantException('Are ya crazy?!');
        }
        $this->dinosaurs->add($dinosaur);
    }

    public function isSecurityActive(): bool
    {
        foreach ($this->securities as $security) {
            if ($security->getIsActive()) {

                return true;
            }
        }

        return false;
    }

    private function canAddDinosaur(Dinosaur $dinosaur): bool
    {
        return count($this->dinosaurs) === 0
            || $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous();
    }

    private function addSecurity(Security $security)
    {
        $this->securities->add($security);
    }
}