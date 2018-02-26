<?php

namespace Phpsw\Website\DataFileGenerator;

use Phpsw\Website\Entity\Event;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateEventFileCommand extends Command
{
    /** @var EventFileGenerator */
    private $eventFileGenerator;

    /**
     * GenerateEventFileCommand constructor.
     *
     * @param EventFileGenerator $eventFileGenerator
     */
    public function __construct(EventFileGenerator $eventFileGenerator)
    {
        parent::__construct();
        $this->eventFileGenerator = $eventFileGenerator;
    }

    protected function configure()
    {
        $this->setName('phpsw:generate-file-event');
        $this->setDescription('Generates an event JSON file, optionally pulling in as much data from Meetup as possible.');
        $this->addArgument('meetupId', InputArgument::OPTIONAL, 'Does this event have a Meetup ID?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $meetupId = $input->getArgument('meetupId');

            if ($meetupId) {
                $output->writeln("Pulling data from Meetup for event {$meetupId}...");
                try {
                    $event = $this->eventFileGenerator->getEventFromMeetup($meetupId);
                } catch (\Exception $e) {
                    $output->writeln('Failed to retrieve the event from Meetup:');
                    $output->writeln($e->getMessage());

                    return;
                }
            } else {
                $event = new Event();
            }

            $filePath = $this->eventFileGenerator->generateFile($event);

            $output->writeln("<info>File saved in {$filePath}</info>");
        } catch (\Exception $e) {
            $output->writeln('<error>Failed to generate an event file:</error>');
            $output->writeln($e->getMessage());
        }
    }
}
