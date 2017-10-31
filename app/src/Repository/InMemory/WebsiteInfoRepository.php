<?php

namespace Phpsw\Website\Repository\InMemory;

use Phpsw\Website\Entity\WebsiteInfo;
use Phpsw\Website\Repository\WebsiteInfoRepositoryInterface;

/**
 * In memory implementation of a WebsiteInfoRepository.
 */
class WebsiteInfoRepository extends AbstractRepository implements WebsiteInfoRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persist(WebsiteInfo $websiteInfo)
    {
        $this->persistEntity($websiteInfo);
    }


    /**
     * Returns WebsiteInfo (there should only be one)
     *
     * @return WebsiteInfo
     */
    public function getWebsiteInfo(): WebsiteInfo
    {
        $websiteInfos = $this->getAll();
        if (count($websiteInfos) != 1) {
            throw new \RuntimeException("There must be only 1 WebsiteInfo object");
        }
        return $websiteInfos[0];
    }
}
