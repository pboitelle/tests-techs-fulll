<?php

declare(strict_types=1);

namespace Fulll\Domain;

use Doctrine\ORM\Mapping as ORM;
use Fulll\Domain\Fleet;

/**
 * @ORM\Entity()
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Fleet", mappedBy="user")
     */
    private $fleet;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->fleet = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setFleet(Fleet $fleet): void
    {
        $this->fleet = $fleet;
    }

    public function getFleet(): ?Fleet
    {
        return $this->fleet;
    }
}