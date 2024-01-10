<?php

declare(strict_types=1);

namespace Fulll\Infra;

use Fulll\Domain\Vehicle;

class VehicleRepository
{
    private $vehicles;

    public function __construct()
    {
        $this->vehicles = [];
    }

    public function addVehicle(Vehicle $vehicle): void
    {
        $this->vehicles[$vehicle->getId()] = $vehicle;
    }

    public function getVehicleById(string $vehicleId): ?Vehicle
    {
        return $this->vehicles[$vehicleId] ?? null;
    }
}