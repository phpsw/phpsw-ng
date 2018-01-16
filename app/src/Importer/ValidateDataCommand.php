<?php

namespace Phpsw\Website\Importer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ValidateDataCommand extends Command
{
    /**
     * @var Importer
     */
    private $importer;

    /**
     * ValidateDataCommand constructor.
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
        $this->setName('phpsw:validate-data');
        $this->setDescription('Validates data and reports any problems it finds.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeln('Validating data...');
            $this->importer->import();
            $output->writeln('All data is valid.');

            return 0;
        } catch (ValidationException $e) {
            $output->writeln('Validation failed:');
            $output->writeln($e->getMessage());

            return 1;
        }
    }
}
