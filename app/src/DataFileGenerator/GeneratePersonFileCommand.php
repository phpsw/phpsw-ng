<?php

namespace Phpsw\Website\DataFileGenerator;

use Phpsw\Website\Entity\Person;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class GeneratePersonFileCommand extends Command
{
    /** @var PersonFileGenerator */
    private $personFileGenerator;

    /**
     * GeneratePersonFileCommand constructor.
     *
     * @param PersonFileGenerator $personFileGenerator
     */
    public function __construct(PersonFileGenerator $personFileGenerator)
    {
        parent::__construct();
        $this->personFileGenerator = $personFileGenerator;
    }

    protected function configure()
    {
        $this->setName('phpsw:generate-file-person');
        $this->setDescription('Generates a person JSON file, optionally pulling in as much data from Meetup as possible.');
        $this->addArgument('meetupId', InputArgument::OPTIONAL, 'Does this person have a Meetup ID?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $meetupId = $input->getArgument('meetupId');

            if ($meetupId) {
                $output->writeln("Pulling data from Meetup for user {$meetupId}...");
                try {
                    $person = $this->personFileGenerator->getPersonFromMeetup($meetupId);
                } catch (\Exception $e) {
                    $output->writeln('Failed to retrieve the member from Meetup:');
                    $output->writeln($e->getMessage());

                    return;
                }
            } else {
                $person = new Person();
            }

            $this->checkMissingData($person, $input, $output);

            $filePath = $this->personFileGenerator->generateFile($person);

            $output->writeln("<info>File saved in {$filePath}</info>");
        } catch (\Exception $e) {
            $output->writeln('<error>Failed to generate a person file:</error>');
            $output->writeln($e->getMessage());
        }
    }

    /**
     * Checks if any of the data is missing and prompts the user to enter at least the required info.
     *
     * @param Person $person
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @throws \Exception
     */
    private function checkMissingData(Person $person, InputInterface $input, OutputInterface $output)
    {
        $missing = false;

        if (empty($person->getName())) {
            $missing = true;
            $output->writeln('<error>Missing name (required)</error>');

            $name = $this->askUserQuestion('Enter the full name of this person: ', $input, $output);
            if (empty($name)) {
                throw new \Exception('missing required full name');
            }
            $person->setName($name);
        }

        if (empty($person->getDescription())) {
            $missing = true;
            $output->writeln('<error>Missing description (required)</error>');

            $description = $this->askUserQuestion('Enter this person\'s description: ', $input, $output);
            if (empty($description)) {
                throw new \Exception('missing required description');
            }
            $person->setDescription($description);
        }

        if (empty($person->getPhotoUrl())) {
            $missing = true;
            $output->writeln('<comment>Missing photo URL</comment>');
            $photoUrl = $this->askUserQuestion('Enter photo URL or leave blank to skip: ', $input, $output);
            if (!empty($photoUrl)) {
                $person->setPhotoUrl($photoUrl);
            }
        }

        if (empty($person->getWebsiteUrl())) {
            $missing = true;
            $output->writeln('<comment>Missing website URL</comment>');
            $websiteUrl = $this->askUserQuestion('Enter website URL or leave blank to skip: ', $input, $output);
            if (!empty($websiteUrl)) {
                $person->setWebsiteUrl($websiteUrl);
            }
        }

        if (empty($person->getTwitterHandle())) {
            $missing = true;
            $output->writeln('<comment>Missing twitter handle</comment>');
            $twitter = $this->askUserQuestion('Enter twitter handle or leave blank to skip: ', $input, $output);
            if (!empty($twitter)) {
                $person->setTwitterHandle($twitter);
            }
        }

        if (empty($person->getGithubHandle())) {
            $missing = true;
            $output->writeln('<comment>Missing github handle</comment>');
            $github = $this->askUserQuestion('Enter github handle or leave blank to skip: ', $input, $output);
            if (!empty($github)) {
                $person->setGithubHandle($github);
            }
        }

        if (empty($person->getMeetupId())) {
            $missing = true;
            $output->writeln('<comment>Missing meetup ID</comment>');
            $meetupId = $this->askUserQuestion('Enter meetup ID or leave blank to skip: ', $input, $output);
            if (!empty($meetupId)) {
                $person->setMeetupId($meetupId);
            }
        }

        if (!$missing) {
            $output->writeln('<info>All data available</info>');
        }
    }

    private function askUserQuestion($question, InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $q = new Question($question, null);

        return $helper->ask($input, $output, $q);
    }
}
