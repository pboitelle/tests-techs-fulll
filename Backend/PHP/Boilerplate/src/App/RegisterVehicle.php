<?php

declare(strict_types=1);

namespace Fulll\App;

use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicle;

class RegisterVehicle
{
    public function registerVehicle(Fleet $fleet, Vehicle $vehicle): bool
    {
        return $fleet->registerVehicle($vehicle);
    }
}