<?php

namespace Phpsw\Website\WebsiteGenerator\ContentTypeGenerator;

use Phpsw\Website\Entity\Person;
use Phpsw\Website\Repository\PersonRepositoryInterface;
use Phpsw\Website\WebsiteGenerator\TemplateRenderer\TemplateRenderer;


/**
 * Generates:
 *
 * - speakers page: lists all speakers
 * - speaker page: One per person, this lists all the talks the speaker has given
 */
class SpeakerPagesGenerator implements ContentTypeGeneratorsInterface
{
    /**
     * @var PersonRepositoryInterface
     */
    private $personRepository;

    /**
     * SpeakerPagesGenerator constructor.
     *
     * @param PersonRepositoryInterface $personRepository
     */
    public function __construct(PersonRepositoryInterface $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    /**
     * Generate pages for content type.
     *
     * This includes:
     * - a page that lists all speakers
     * - a page for each speaker
     *
     * {@inheritdoc}
     */
    public function generatePages(TemplateRenderer $templateRenderer)
    {
        $people = $this->personRepository->getAll();

        foreach ($people as $person) {
            $this->generateSpeakerPage($templateRenderer, $person);
        }

        $templateRenderer->render('speakers.html', 'speakers', [
            'speakers' => $people,
        ]);
    }

    private function generateSpeakerPage(TemplateRenderer $templateRenderer, Person $person)
    {
        $filename = "speakers/{$person->getSlug()}.html";
        $templateRenderer->render($filename, 'speaker', ['speaker' => $person]);
    }
}
