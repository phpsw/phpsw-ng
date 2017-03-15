<?php

namespace Phpsw\Website\WebsiteGenerator\ContentTypeGenerator;

use Phpsw\Website\WebsiteGenerator\TemplateRenderer\TemplateRenderer;

/**
 * Interface for content type generators (e.g. speakers, talks, etc).
 */
interface ContentTypeGeneratorsInterface
{
    /**
     * Generate pages for content type.
     *
     * @param TemplateRenderer $templateRenderer
     */
    public function generatePages(TemplateRenderer $templateRenderer);
}
