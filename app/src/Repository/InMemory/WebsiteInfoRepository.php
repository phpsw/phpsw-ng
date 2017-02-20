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
}
