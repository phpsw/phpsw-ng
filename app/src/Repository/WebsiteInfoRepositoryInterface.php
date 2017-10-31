<?php

namespace Phpsw\Website\Repository;

use Phpsw\Website\Entity\WebsiteInfo;

interface WebsiteInfoRepositoryInterface
{
    /**
     * Save or update a WebsiteInfo entity.
     *
     * @param WebsiteInfo $websiteInfo
     */
    public function persist(WebsiteInfo $websiteInfo);

    /**
     * Returns WebsiteInfo (there shoud only be one)
     *
     * @return WebsiteInfo
     */
    public function getWebsiteInfo(): WebsiteInfo;
}
