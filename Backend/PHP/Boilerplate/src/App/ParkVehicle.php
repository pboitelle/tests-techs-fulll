<?php

declare(strict_types=1);

namespace Fulll\App;

use Fulll\Domain\Location;
use Fulll\Domain\Vehicle;

class ParkVehicle
{
    public function parkVehicleAtLocation(Vehicle $vehicle, Location $location): bool
    {
        if ($vehicle->getLocation() !== null && $vehicle->getLocation()->getId() === $location->getId()) {
            return false;
        }
        return $vehicle->parkAtLocation($location);
    }
}