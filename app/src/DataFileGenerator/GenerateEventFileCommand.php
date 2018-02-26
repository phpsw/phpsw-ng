<?php

namespace Phpsw\Website\DataFileGenerator;

use Phpsw\Website\Entity\Event;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

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

//            $this->addMissingData($event, $input, $output);

            $filePath = $this->eventFileGenerator->generateFile($event);

            $output->writeln("<info>File saved in {$filePath}</info>");
        } catch (\Exception $e) {
            $output->writeln('<error>Failed to generate an event file:</error>');
            $output->writeln($e->getMessage());
        }
    }

    /**
     * Checks if any of the data is missing and prompts the user to enter at least the required info.
     *
     * @param Event $event
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @throws \Exception
     */
    private function addMissingData(Event $event, InputInterface $input, OutputInterface $output)
    {
//        $missing = false;
//
//        if (empty($event->getName())) {
//            $missing = true;
//            $output->writeln('<error>Missing name (required)</error>');
//
//            $name = $this->askUserQuestion('Enter the full name of this person: ', $input, $output);
//            if (empty($name)) {
//                throw new \Exception('missing required full name');
//            }
//            $event->setName($name);
//        }
//
//        if (empty($event->getDescription())) {
//            $missing = true;
//            $output->writeln('<error>Missing description (required)</error>');
//
//            $description = $this->askUserQuestion('Enter this person\'s description: ', $input, $output);
//            if (empty($description)) {
//                throw new \Exception('missing required description');
//            }
//            $event->setDescription($description);
//        }
//
//        if (empty($event->getPhotoUrl())) {
//            $missing = true;
//            $output->writeln('<comment>Missing photo URL</comment>');
//            $photoUrl = $this->askUserQuestion('Enter photo URL or leave blank to skip: ', $input, $output);
//            if (!empty($photoUrl)) {
//                $event->setPhotoUrl($photoUrl);
//            }
//        }
//
//        if (empty($event->getWebsiteUrl())) {
//            $missing = true;
//            $output->writeln('<comment>Missing website URL</comment>');
//            $websiteUrl = $this->askUserQuestion('Enter website URL or leave blank to skip: ', $input, $output);
//            if (!empty($websiteUrl)) {
//                $event->setWebsiteUrl($websiteUrl);
//            }
//        }
//
//        if (empty($event->getTwitterHandle())) {
//            $missing = true;
//            $output->writeln('<comment>Missing twitter handle</comment>');
//            $twitter = $this->askUserQuestion('Enter twitter handle or leave blank to skip: ', $input, $output);
//            if (!empty($twitter)) {
//                $event->setTwitterHandle($twitter);
//            }
//        }
//
//        if (empty($event->getGithubHandle())) {
//            $missing = true;
//            $output->writeln('<comment>Missing github handle</comment>');
//            $github = $this->askUserQuestion('Enter github handle or leave blank to skip: ', $input, $output);
//            if (!empty($github)) {
//                $event->setGithubHandle($github);
//            }
//        }
//
//        if (empty($event->getMeetupId())) {
//            $missing = true;
//            $output->writeln('<comment>Missing meetup ID</comment>');
//            $meetupId = $this->askUserQuestion('Enter meetup ID or leave blank to skip: ', $input, $output);
//            if (!empty($meetupId)) {
//                $event->setMeetupId($meetupId);
//            }
//        }
//
//        if (!$missing) {
//            $output->writeln('<info>All data available</info>');
//        }
    }

    private function askUserQuestion($question, InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $q = new Question($question, null);

        return $helper->ask($input, $output, $q);
    }
}
