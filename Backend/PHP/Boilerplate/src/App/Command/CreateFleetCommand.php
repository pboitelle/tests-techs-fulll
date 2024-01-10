<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Fulll\Domain\Fleet;
use Fulll\Domain\User;
use Doctrine\ORM\EntityManagerInterface;

class CreateFleetCommand extends Command
{
    protected static $defaultName = 'fleet:create';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a fleet for a user')
            ->addArgument('userId', InputArgument::REQUIRED, 'User ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userId = (int)$input->getArgument('userId');
        $user = new User($userId);
        $fleet = new Fleet($userId);
        $user->setFleet($fleet);

        $this->entityManager->persist($fleet);
        $this->entityManager->flush();

        $output->writeln('Fleet created for User ID ' . $userId);
        return Command::SUCCESS;
    }
}