<?php

namespace Phpsw\Website\DataFileGenerator;

use Phpsw\Website\Entity\Event;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateTalkFileCommand extends Command
{
    /** @var TalkFileGenerator */
    private $talkFilesGenerator;

    /**
     * GenerateTalkFilesCommand constructor.
     *
     * @param TalkFileGenerator $talkFilesGenerator
     */
    public function __construct(TalkFileGenerator $talkFilesGenerator)
    {
        parent::__construct();
        $this->talkFilesGenerator = $talkFilesGenerator;
    }

    protected function configure()
    {
        $this->setName('phpsw:generate-file-talk');
        $this->setDescription('Pulls down the full event description from meetup and saves it in a JSON file along with the event slug.');
        $this->addArgument('meetupId', InputArgument::OPTIONAL, 'Does this event have a Meetup ID?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $meetupId = $input->getArgument('meetupId');

            if ($meetupId) {
                $output->writeln("Pulling the full description from Meetup for event {$meetupId}...");
                try {
                    $event = $this->talkFilesGenerator->getEventDescriptionFromMeetup($meetupId);
                } catch (\Exception $e) {
                    $output->writeln('Failed to retrieve the event from Meetup:');
                    $output->writeln($e->getMessage());

                    return;
                }
            } else {
                $event = new Event();
            }

            $filePath = $this->talkFilesGenerator->generateFile($event);

            $output->writeln("<info>File saved in {$filePath}</info>");
        } catch (\Exception $e) {
            $output->writeln('<error>Failed to generate an event file:</error>');
            $output->writeln($e->getMessage());
        }
    }
}
