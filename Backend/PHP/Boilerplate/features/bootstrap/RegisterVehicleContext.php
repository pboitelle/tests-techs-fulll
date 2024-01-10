<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Fulll\App\RegisterVehicle;
use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicle;
use Fulll\Domain\User;

class RegisterVehicleContext implements Context
{
    private $user;
    private $otherUser;
    private $fleet;
    private $otherFleet;
    private $vehicle;
    private $registrationResult;


    /**
     * @Given my fleet
     */
    public function myFleet(): void
    {
        $this->user = new User(1);
        $this->fleet = new Fleet(1);
        $this->user->setFleet($this->fleet);
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle(): void
    {
        $this->vehicle = new Vehicle('ABC123');
    }


    //SCENARIO: I can register a vehicle  

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        $this->registrationResult = $this->fleet->registerVehicle($this->vehicle);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        if (!$this->registrationResult) {
            throw new \RuntimeException('Vehicle registration failed.');
        }
    }

    // SCENARIO: I can't register same vehicle twice  

    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $this->fleet->registerVehicle($this->vehicle);
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet(): void
    {
        $this->registrationResult = $this->fleet->registerVehicle($this->vehicle);
    }

    /**
     * @Then I should be informed that this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThatThisVehicleHasBeenRegisteredIntoMyFleet(): void
    {
        if ($this->registrationResult) {
            throw new \RuntimeException('Vehicle registration should have failed, but it succeeded.');
        }
    }


    // SCENARIO: Same vehicle can belong to more than one fleet  

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser(): void
    {
        $this->otherUser = new User(2);
        $this->otherFleet = new Fleet(2);
        $this->otherUser->setFleet($this->otherFleet);
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUserFleet(): void
    {
        $this->otherFleet->registerVehicle($this->vehicle);
    }

}