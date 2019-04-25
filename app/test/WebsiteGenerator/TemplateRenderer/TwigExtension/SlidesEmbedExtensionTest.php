<?php

declare(strict_types=1);

namespace Phpsw\Website\Tests\WebsiteGenerator\TemplateRenderer\TwigExtension;

use Phpsw\Website\Entity\Talk;
use Phpsw\Website\WebsiteGenerator\TemplateRenderer\TwigExtension\SlidesEmbedExtension;
use PHPUnit\Framework\TestCase;

class SlidesEmbedExtensionTest extends TestCase
{
    /**
     * When the slides url is a link to a website, we should get an iFrame back.
     */
    public function testGetSlidesEmbedStandardLink()
    {
        $talk = new Talk();
        $talk->setSlidesUrl('https://talks.philsturgeon.uk/instances/phpsw-jan18/http-caching-to-save-the-polar-bears/html/#/');

        $slidesEmbedExtension = new SlidesEmbedExtension();
        $actual = $slidesEmbedExtension->getSlidesEmbed($talk);
        $this->assertEquals(
            '<iframe class="w-full" style="height:300px" src="https://talks.philsturgeon.uk/instances/phpsw-jan18/http-caching-to-save-the-polar-bears/html/#/" frameborder="0" allowfullscreen mozallowfullscreen webkitallowfullscreen></iframe>',
            $actual
        );
    }

    /**
     * When the slides url is a PDF, we should get an iFrame back.
     * The iFrame should link to the mozilla tooling which helps show the PDF.
     */
    public function testGetSlidesEmbedPdf()
    {
        $talk = new Talk();
        $talk->setSlidesUrl('https://slides.phpsw.uk/2018/01/command-emission-promise.pdf');

        $slidesEmbedExtension = new SlidesEmbedExtension();
        $actual = $slidesEmbedExtension->getSlidesEmbed($talk);
        $this->assertEquals(
            '<iframe class="w-full" style="height:300px" src="https://mozilla.github.io/pdf.js/web/viewer.html?file=https://slides.phpsw.uk/2018/01/command-emission-promise.pdf#zoom=page-fit" frameborder="0" allowfullscreen mozallowfullscreen webkitallowfullscreen></iframe>',
            $actual
        );
    }

    /**
     * When the slides url is slideshare, we get an embedly embed back.
     */
    public function testGetSlidesEmbedSlideshare()
    {
        $talk = new Talk();
        $talk->setSlidesUrl('https://www.slideshare.net/asgrim1/crafting-quality-php-applications-an-overview-phpsw-march-2018');
        $talk->setTitle('Crafting Quality PHP Applications: an overview');

        $slidesEmbedExtension = new SlidesEmbedExtension();
        $actual = $slidesEmbedExtension->getSlidesEmbed($talk);
        $this->assertEquals(
            '<blockquote class="embedly-card"><h4><a href="https://www.slideshare.net/asgrim1/crafting-quality-php-applications-an-overview-phpsw-march-2018">Crafting Quality PHP Applications: an overview</a></h4></blockquote><script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>',
            $actual
        );
    }

    /**
     * When the slides url is a link to a website, we should get a standard link back.
     */
    public function testGetSlidesLinkStandardLink()
    {
        $talk = new Talk();
        $talk->setSlidesUrl('https://talks.philsturgeon.uk/instances/phpsw-jan18/http-caching-to-save-the-polar-bears/html/#/');

        $slidesEmbedExtension = new SlidesEmbedExtension();
        $actual = $slidesEmbedExtension->getSlidesLink($talk);
        $this->assertEquals(
            '<a href="https://talks.philsturgeon.uk/instances/phpsw-jan18/http-caching-to-save-the-polar-bears/html/#/" class="block mb-1" target="_blank">
                <svg class="fill-current w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.26 13a2 2 0 0 1 .01-2.01A3 3 0 0 0 9 5H5a3 3 0 0 0 0 6h.08a6.06 6.06 0 0 0 0 2H5A5 5 0 0 1 5 3h4a5 5 0 0 1 .26 10zm1.48-6a2 2 0 0 1-.01 2.01A3 3 0 0 0 11 15h4a3 3 0 0 0 0-6h-.08a6.06 6.06 0 0 0 0-2H15a5 5 0 0 1 0 10h-4a5 5 0 0 1-.26-10z"></path></svg>
                View Slides
                </a>',
            $actual
        );
    }

    /**
     * When the slides url is a slideshare link, we should get a standard link back.
     */
    public function testGetSlidesLinkSlideshare()
    {
        $talk = new Talk();
        $talk->setSlidesUrl('https://www.slideshare.net/asgrim1/crafting-quality-php-applications-an-overview-phpsw-march-2018');

        $slidesEmbedExtension = new SlidesEmbedExtension();
        $actual = $slidesEmbedExtension->getSlidesLink($talk);
        $this->assertEquals(
            '<a href="https://www.slideshare.net/asgrim1/crafting-quality-php-applications-an-overview-phpsw-march-2018" class="block mb-1" target="_blank">
                <svg class="fill-current w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.26 13a2 2 0 0 1 .01-2.01A3 3 0 0 0 9 5H5a3 3 0 0 0 0 6h.08a6.06 6.06 0 0 0 0 2H5A5 5 0 0 1 5 3h4a5 5 0 0 1 .26 10zm1.48-6a2 2 0 0 1-.01 2.01A3 3 0 0 0 11 15h4a3 3 0 0 0 0-6h-.08a6.06 6.06 0 0 0 0-2H15a5 5 0 0 1 0 10h-4a5 5 0 0 1-.26-10z"></path></svg>
                View Slides
                </a>',
            $actual
        );
    }

    /**
     * When the slides url is a PDF, we should get a PDF link back.
     */
    public function testGetSlidesLinkPdf()
    {
        $talk = new Talk();
        $talk->setSlidesUrl('https://slides.phpsw.uk/2018/01/command-emission-promise.pdf');

        $slidesEmbedExtension = new SlidesEmbedExtension();
        $actual = $slidesEmbedExtension->getSlidesLink($talk);
        $this->assertEquals(
            '<a href="https://slides.phpsw.uk/2018/01/command-emission-promise.pdf" class="block mb-1" target="_blank">
                <svg class="fill-current w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4,18 L4,2 L12,2 L12,6 L16,6 L16,18 L4,18 Z M2,19 L2,0 L3,0 L12,0 L14,0 L18,4 L18,6 L18,20 L17,20 L2,20 L2,19 Z" id="Combined-Shape"></path></svg>
                View PDF
                </a>',
            $actual
        );
    }
}
