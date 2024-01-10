<?php

declare(strict_types=1);

namespace Fulll\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $lat;

    /**
     * @ORM\Column(type="float")
     */
    private $lng;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $alt;

    public function __construct(int $id, float $lat, float $lng, float $alt)
    {
        $this->id = $id;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->alt = $alt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): int
    {
        $this->id = $id;
        return $this;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function setLat(float $lat): void
    {
        $this->lat = $lat;
    }

    public function getLng(): float
    {
        return $this->lng;
    }

    public function setLng(float $lng): void
    {
        $this->lng = $lng;
    }

    public function getAlt(): ?float
    {
        return $this->alt;
    }

    public function setAlt(?float $alt): void
    {
        $this->alt = $alt;
    }

    public function __toString(): string
    {
        return sprintf('Location %d: %f, %f, %f', $this->id, $this->lat, $this->lng, $this->alt);
    }
}
