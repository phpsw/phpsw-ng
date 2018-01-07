<?php

namespace Phpsw\Website\WebsiteGenerator\ContentTypeGenerator;

use Phpsw\Website\Repository\WebsiteInfoRepositoryInterface;
use Phpsw\Website\WebsiteGenerator\TemplateRenderer\TemplateRenderer;

/**
 * Generates:.
 *
 * - sponsors page (this shows only the current sponsors)
 */
class SponsorsPageGenerator implements ContentTypeGeneratorsInterface
{
    /**
     * @var WebsiteInfoRepositoryInterface
     */
    private $websiteInfoRepository;

    /**
     * SponsorsPageGenerator constructor.
     *
     * @param WebsiteInfoRepositoryInterface $websiteInfoRepository
     */
    public function __construct(WebsiteInfoRepositoryInterface $websiteInfoRepository)
    {
        $this->websiteInfoRepository = $websiteInfoRepository;
    }

    /**
     * Generate pages for content type.
     *
     * This includes:
     * - a page listing current sponsors
     *
     * {@inheritdoc}
     */
    public function generatePages(TemplateRenderer $templateRenderer)
    {
        $websiteInfo = $this->websiteInfoRepository->getWebsiteInfo();

        $templateRenderer->render('sponsors/index.html', 'sponsors', [
            'sponsors' => $websiteInfo->getSponsors(),
        ]);
    }
}
