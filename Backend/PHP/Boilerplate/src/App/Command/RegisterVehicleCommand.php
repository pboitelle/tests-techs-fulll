<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicle;
use Doctrine\ORM\EntityManagerInterface;

class RegisterVehicleCommand extends Command
{
    protected static $defaultName = 'fleet:register-vehicle';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Register a vehicle to a fleet')
            ->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet ID')
            ->addArgument('vehicleId', InputArgument::REQUIRED, 'Vehicle ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fleetId = (int)$input->getArgument('fleetId');
        $vehicleId = (string)$input->getArgument('vehicleId');

        $fleet = $this->entityManager->getRepository(Fleet::class)->find($fleetId);
        $vehicle = new Vehicle($vehicleId);

        $result = $fleet->registerVehicle($vehicle);

        if ($result) {
            $this->entityManager->persist($vehicle);
            $this->entityManager->flush();

            $output->writeln('Vehicle registered to Fleet ID ' . $fleetId);
            return Command::SUCCESS;
        } else {
            $output->writeln('Vehicle is already registered in Fleet ID ' . $fleetId);
            return Command::FAILURE;
        }
    }
}