<?php

declare(strict_types=1);

namespace Fulll\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Vehicle
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Fleet", inversedBy="vehicles")
     * @ORM\JoinColumn(name="fleet_id", referencedColumnName="id")
     */
    private $fleet;

    /**
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    private $location;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFleet(): ?Fleet
    {
        return $this->fleet;
    }


    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    public function parkAtLocation(Location $location): bool
    {
        $this->setLocation($location);
        return true;
    }
}