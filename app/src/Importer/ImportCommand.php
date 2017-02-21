<?php

namespace Phpsw\Website\Importer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
{
    /**
     * @var Importer
     */
    private $importer;

    /**
     * ImportCommand constructor.
     *
     * @param Importer $importer
     */
    public function __construct(Importer $importer)
    {
        parent::__construct();
        $this->importer = $importer;
    }

    protected function configure()
    {
        $this->setName('data:validate');
        $this->setDescription('Imports and validates data and reports any problems it finds.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeln('Importing data in directory...');
            $this->importer->import();
            $output->writeln('All data imported successfully.');
        } catch (ValidationException $e) {
            $output->writeln('Failed to import data:');
            $output->writeln($e->getMessage());
        }
    }
}
