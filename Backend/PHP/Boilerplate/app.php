<?php

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Fulll\App\Command\CreateFleetCommand;
use Fulll\App\Command\LocalizeVehicleCommand;
use Fulll\App\Command\RegisterVehicleCommand;

// Doctrine ORM configuration
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration([__DIR__."/src"], $isDevMode);
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
);

$entityManager = EntityManager::create($conn, $config);
$vehicleRepository = new \Fulll\Infra\VehicleRepository();

$application = new Application();

$application->add(new CreateFleetCommand($entityManager));
$application->add(new LocalizeVehicleCommand($entityManager, $vehicleRepository));
$application->add(new RegisterVehicleCommand($entityManager));

$application->run();