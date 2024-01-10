<?php

declare(strict_types=1);

namespace Fulll\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Fleet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="fleet")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Vehicle", mappedBy="fleet")
     */
    private $vehicles;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->vehicles = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function registerVehicle(Vehicle $vehicle): bool
    {
        $vehicleId = $vehicle->getId();

        if (isset($this->vehicles[$vehicleId])) {
            return false; // Le véhicule est déjà enregistré dans la flotte
        }

        $this->vehicles[$vehicleId] = $vehicle;

        return true; // Enregistrement réussi
    }

    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function getVehicleById(string $vehicleId): ?Vehicle
    {
        return $this->vehicles[$vehicleId] ?? null;
    }
}
