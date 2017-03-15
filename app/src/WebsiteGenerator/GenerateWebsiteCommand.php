<?php

namespace Phpsw\Website\WebsiteGenerator;

use Exception;
use Phpsw\Website\Importer\Importer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateWebsiteCommand extends Command
{
    /**
     * @var WebsiteGenerator
     */
    private $websiteGenerator;

    /**
     * @var Importer
     */
    private $importer;

    /**
     * GenerateWebsiteCommand constructor.
     *
     * @param WebsiteGenerator $websiteGenerator
     * @param Importer $importer
     */
    public function __construct(WebsiteGenerator $websiteGenerator, Importer $importer)
    {
        parent::__construct();
        $this->websiteGenerator = $websiteGenerator;
        $this->importer = $importer;
    }

    protected function configure()
    {
        $this->setName('phpsw:generate-website');
        $this->setDescription('Imports data and generates website.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeln('Importing data...');
            $this->importer->import();
            $output->writeln('Generating website....');
            $this->websiteGenerator->generateWebsite();
            $output->writeln('Done');
        } catch (Exception $e) {
            $output->writeln('Failed to generate website:');
            $output->writeln($e->getMessage());
        }
    }
}
