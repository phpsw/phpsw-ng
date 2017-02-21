<?php

namespace Phpsw\Website\WebsiteGenerator;

/**
 * Interface for content type generators (e.g. speakers, talks, etc).
 */
interface ContentTypeGeneratorsInterface
{
    /**
     * Generate pages for content type.
     *
     * @param WebsiteBaseDirectory $websiteBaseDirectory
     */
    public function generatePages(WebsiteBaseDirectory $websiteBaseDirectory);
}
