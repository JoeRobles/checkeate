<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseUpdateCommand extends ContainerAwareCommand
{
    protected $route;

    public function __construct()
    {
        parent::__construct();
        $this->route = 'cd ' . __DIR__ . '/../../../;php app/console ';
    }

    protected function configure()
    {
        $this->setName('database:update')
            ->setDescription('Delete and reconstruct database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Dropping database >> ');
        $output->writeln(shell_exec($this->route . 'doctrine:database:drop --force'));

        $output->write('Creating database >> ');
        $output->writeln(shell_exec($this->route . 'doctrine:database:create'));

        $output->write('Creating schema >> ');
        $output->writeln(shell_exec($this->route . 'doctrine:schema:create'));

        $output->write('Loading fixtures >> ');
        $output->writeln(shell_exec($this->route . 'doctrine:fixtures:load -n'));

        $output->writeln('Finished successfully.');
    }
}
