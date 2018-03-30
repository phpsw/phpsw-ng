<?php

declare(strict_types=1);

namespace Phpsw\Website\Tests\WebsiteGenerator\TemplateRenderer\TwigExtension;

use Phpsw\Website\Entity\Talk;
use Phpsw\Website\WebsiteGenerator\TemplateRenderer\TwigExtension\YouTubeEmbedUrlExtension;
use PHPUnit\Framework\TestCase;

class YouTubeEmbedUrlExtensionTest extends TestCase
{
    public function testGetYouTubeEmbedUrl()
    {
        $talk = new Talk();
        $talk->setVideoUrl('https://www.youtube.com/watch?v=nMeDxw4wUXI');

        $youTubeEmberUrlExtension = new YouTubeEmbedUrlExtension();
        $actual = $youTubeEmberUrlExtension->getYouTubeEmbedUrl($talk);

        $this->assertEquals('https://www.youtube.com/embed/nMeDxw4wUXI', $actual);
    }

    /**
     * Checks that query strings which could also exist in the YouTube URL are removed.
     */
    public function testGetYouTubeEmbedUrlWithQueryString()
    {
        $talk = new Talk();
        $talk->setVideoUrl('https://www.youtube.com/watch?time_continue=635&v=nMeDxw4wUXI');

        $youTubeEmberUrlExtension = new YouTubeEmbedUrlExtension();
        $actual = $youTubeEmberUrlExtension->getYouTubeEmbedUrl($talk);

        $this->assertEquals('https://www.youtube.com/embed/nMeDxw4wUXI', $actual);
    }
}
