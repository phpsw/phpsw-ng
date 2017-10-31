<?php

namespace Phpsw\Website\WebsiteGenerator\ContentTypeGenerator;

use Phpsw\Website\Repository\WebsiteInfoRepositoryInterface;
use Phpsw\Website\WebsiteGenerator\TemplateRenderer\TemplateRenderer;


/**
 * Generates:
 *
 * - index.html
 */
class HomePageGenerator implements ContentTypeGeneratorsInterface
{

    /**
     * @var WebsiteInfoRepositoryInterface
     */
    private $websiteInfoRepository;

    /**
     * HomePageGenerator constructor.
     * @param WebsiteInfoRepositoryInterface $websiteInfoRepository
     */
    public function __construct(WebsiteInfoRepositoryInterface $websiteInfoRepository)
    {
        $this->websiteInfoRepository = $websiteInfoRepository;
    }


    /**
     * Generate home page.
     *
     * {@inheritdoc}
     */
    public function generatePages(TemplateRenderer $templateRenderer)
    {
        $websiteInfo = $this->websiteInfoRepository->getWebsiteInfo();

        $templateRenderer->render('index.html', 'home', [
            'info' => $websiteInfo,
        ]);
    }

}
