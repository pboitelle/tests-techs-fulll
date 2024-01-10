<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Fulll\Domain\Fleet;
use Fulll\Domain\Location;
use Fulll\Domain\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Fulll\Infra\VehicleRepository;

class LocalizeVehicleCommand extends Command
{
    protected static $defaultName = 'fleet:localize-vehicle';

    private $entityManager;
    private $vehicleRepository;

    public function __construct(EntityManagerInterface $entityManager, VehicleRepository $vehicleRepository)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->vehicleRepository = $vehicleRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Localize a vehicle in a fleet')
            ->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet ID')
            ->addArgument('vehicleId', InputArgument::REQUIRED, 'Vehicle ID')
            ->addArgument('lat', InputArgument::REQUIRED, 'Latitude')
            ->addArgument('lng', InputArgument::REQUIRED, 'Longitude')
            ->addArgument('alt', InputArgument::OPTIONAL, 'Altitude');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {     
        $fleetId = (int)$input->getArgument('fleetId');
        $vehicleId = (string)$input->getArgument('vehicleId');
        $lat = (float)$input->getArgument('lat');
        $lng = (float)$input->getArgument('lng');
        $alt = $input->getArgument('alt') ? (float)$input->getArgument('alt') : null;

        // Retrieve the fleet from the repository
        $fleet = $this->entityManager->getRepository(Fleet::class)->find($fleetId);

        // Retrieve the vehicle from the repository
        $vehicleFromRepository = $this->vehicleRepository->getVehicleById($vehicleId);

        if ($vehicleFromRepository) {

            // Retrieve the vehicle from the fleet
            $vehicleFromFleet = $fleet->getVehicleById($vehicleId);

            if ($vehicleFromFleet) {
                $vehicleFromFleet->parkAtLocation(new Location($lat, $lng, $alt));


                $output->writeln('Vehicle ' . $vehicleId . ' localized in Fleet ID ' . $fleetId . ' at ' . $lat . ', ' . $lng . ', ' . $alt);

                return Command::SUCCESS;

            } else {
                $output->writeln('Vehicle is not registered in Fleet ID ' . $fleetId);

                return Command::FAILURE;
            }

        } else {

            $output->writeln('Vehicle does not exist');

            return Command::FAILURE;
        }
        

    }
}