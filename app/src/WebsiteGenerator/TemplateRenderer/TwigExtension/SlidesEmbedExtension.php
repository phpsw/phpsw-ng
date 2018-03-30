<?php
/**
 * Created by PhpStorm.
 * User: lee.stone
 * Date: 29/03/2018
 * Time: 18:42.
 */

namespace Phpsw\Website\WebsiteGenerator\TemplateRenderer\TwigExtension;

use Phpsw\Website\Entity\Talk;
use Twig_Extension;
use Twig_SimpleFunction;

class SlidesEmbedExtension extends Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('embedSlides', [$this, 'getSlidesEmbed'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('slidesLink', [$this, 'getSlidesLink'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Returns the string to embed the slides.
     *
     * How we embed them will differ depending on the source
     *
     * @param Talk $talk
     *
     * @return string
     */
    public function getSlidesEmbed(Talk $talk): string
    {
        $iFrameUrl = '';
        $embedString = '';

        if ('.pdf' == substr($talk->getSlidesUrl(), -4)) {
            // PDFs can be embedded via an iFrame
            $iFrameUrl = "https://mozilla.github.io/pdf.js/web/viewer.html?file={$talk->getSlidesUrl()}#zoom=page-fit";
        } elseif (strpos($talk->getSlidesUrl(), 'slideshare')) {
            // We use embedly to embed slideshare
            $embedString = '<blockquote class="embedly-card"><h4><a href="'.$talk->getSlidesUrl().'">'.$talk->getTitle().'</a></h4></blockquote>
                <script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>';
        } else {
            $iFrameUrl = $talk->getSlidesUrl();
        }

        // If we have an iFrame URL, the embeddable should be an iFrame
        if ($iFrameUrl) {
            $embedString = "<iframe class=\"w-full\" style=\"height:300px\" src=\"$iFrameUrl\" frameborder=\"0\" allowfullscreen mozallowfullscreen webkitallowfullscreen></iframe>";
        }

        return $embedString;
    }

    public function getSlidesLink(Talk $talk): string
    {
        if ('.pdf' == substr($talk->getSlidesUrl(), -4)) {
            return '<a href="'.$talk->getSlidesUrl().'" class="block mb-1" target="_blank">
                <svg class="fill-current w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4,18 L4,2 L12,2 L12,6 L16,6 L16,18 L4,18 Z M2,19 L2,0 L3,0 L12,0 L14,0 L18,4 L18,6 L18,20 L17,20 L2,20 L2,19 Z" id="Combined-Shape"></path></svg>
                View PDF
                </a>';
        } else {
            return '<a href="'.$talk->getSlidesUrl().'" class="block mb-1" target="_blank">
                <svg class="fill-current w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.26 13a2 2 0 0 1 .01-2.01A3 3 0 0 0 9 5H5a3 3 0 0 0 0 6h.08a6.06 6.06 0 0 0 0 2H5A5 5 0 0 1 5 3h4a5 5 0 0 1 .26 10zm1.48-6a2 2 0 0 1-.01 2.01A3 3 0 0 0 11 15h4a3 3 0 0 0 0-6h-.08a6.06 6.06 0 0 0 0-2H15a5 5 0 0 1 0 10h-4a5 5 0 0 1-.26-10z"></path></svg>
                View Slides
                </a>';
        }
    }
}
