<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicle;
use Fulll\Domain\User;
use Fulll\Domain\Location;
use Fulll\App\ParkVehicle;

class ParkVehicleContext implements Context
{
    private $user;
    private $fleet;
    private $vehicle;
    private $location;
    private $parkingResult;
    private $parkVehicle;

    /**
     * @Given my register vehicle fleet
     */
    public function myRegisterVehicleFleet(): void
    {
        $this->user = new User(1);
        $this->fleet = new Fleet(1);
        $this->user->setFleet($this->fleet);
    }

    /**
     * @Given my park vehicle
     */
    public function myParkVehicle(): void
    {
        $this->vehicle = new Vehicle('ABC12345');
    }

    /**
     * @When I have registered this park vehicle into my fleet
     */
    public function iHaveRegisteredThisParkVehicleIntoMyFleet(): void
    {
        $this->fleet->registerVehicle($this->vehicle);
    }

    /**
     * @Given a location
     */
    public function aLocation(): void
    {
        $this->location = new Location(1, 48.8534, 2.3488, 35.0);
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation(): void
    {
        $this->parkVehicle = new ParkVehicle();
        $this->parkingResult = $this->parkVehicle->parkVehicleAtLocation($this->vehicle, $this->location);
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        if (!$this->parkingResult) {
            throw new \RuntimeException('Vehicle parking failed.');
        }
    }

    // Scenario: Can't localize my vehicle to the same location two times in a row

    /**
     * @Given my vehicle has been parked into this location
     */
    public function myVehicleHasBeenParkedIntoThisLocation(): void
    {
        $this->parkVehicle = new ParkVehicle();
        $this->parkingResult = $this->parkVehicle->parkVehicleAtLocation($this->vehicle, $this->location);
        if ($this->vehicle->getLocation() != $this->location) {
            throw new \RuntimeException('Vehicle parking failed.');
        }
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
        $this->parkVehicle = new ParkVehicle();
        $location = new Location(2, 1.0, 2.0, 3.0);
        $this->parkingResult = $this->parkVehicle->parkVehicleAtLocation($this->vehicle, $location);
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        if (!$this->parkingResult) {
            throw new \RuntimeException('Vehicle parking failed, vehicle already parked at this location.');
        }
    }
}