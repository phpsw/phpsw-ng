<?php

namespace Phpsw\Website\DataFileGenerator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GeneratePersonFileCommand extends Command
{
    private $meetupAPIClient;

    /** @var PersonFileGenerator */
    private $personFileGenerator;

    /**
     * GeneratePersonFileCommand constructor.
     *
     * @param $meetupAPIClient
     * @param PersonFileGenerator $speakerFileGenerator
     */
    public function __construct(PersonFileGenerator $speakerFileGenerator)
    {
        parent::__construct();
//        $this->meetupAPIClient = $meetupAPIClient;
        $this->personFileGenerator = $speakerFileGenerator;
    }

    protected function configure()
    {
        $this->setName('phpsw:generate-file-speaker');
        $this->setDescription('Generates a speaker JSON file with as much data from Meetup as possible.');
        $this->addArgument('meetupId', InputArgument::OPTIONAL, 'Does this person have a Meetup ID?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $meetupID = $input->getArgument('meetupId');

            if ($meetupID) {
                $output->writeln("Pulling data from Meetup for user {$meetupID}...");
            }

            // query meetup and fill in the data

//            $this->personFileGenerator->generatePersonFile();

            $output->writeln('Done');
        } catch (\Exception $e) {
            $output->writeln('Failed to generate a speaker file:');
            $output->writeln($e->getMessage());
        }
    }
}