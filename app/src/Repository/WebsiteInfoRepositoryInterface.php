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
     * Returns all websiteInfos ordered by websiteInfo slug (in alphabetical order).
     *
     * @return WebsiteInfo[]
     */
    public function getAll();
}
