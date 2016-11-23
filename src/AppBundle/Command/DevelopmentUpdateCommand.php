<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DevelopmentUpdateCommand extends ContainerAwareCommand
{
    protected $route;

    public function __construct()
    {
        parent::__construct();
        $this->route = 'cd ' . __DIR__ . '/../../../;php app/console ';
    }

    protected function configure()
    {
        $this->setName('development:update')
            ->setDescription('Development update.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Pulling from git repository >> ');
        $output->writeln(shell_exec('cd ' . __DIR__ . '/../../../;git pull'));

        $output->write('Clearing cache >> ');
        $output->writeln(shell_exec($this->route . 'cache:clear'));

        $output->write('Installing assets >> ');
        $output->writeln(shell_exec($this->route . 'assets:install web --symlink'));

        $output->write('Updating schema >> ');
        $output->writeln(shell_exec($this->route . 'doctrine:schema:update --force'));

        $output->writeln('Finished successfully.');
    }
}
