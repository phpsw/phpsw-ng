<?php
/**
 * Created by PhpStorm.
 * User: lee.stone
 * Date: 29/03/2018
 * Time: 17:51.
 */

namespace Phpsw\Website\WebsiteGenerator\TemplateRenderer\TwigExtension;

use Phpsw\Website\Entity\Talk;
use Twig_Extension;
use Twig_SimpleFunction;

class YouTubeEmbedUrlExtension extends Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('youTubeEmbedUrl', [$this, 'getYouTubeEmbedUrl']),
        ];
    }

    /**
     * Returns the URL which can be used for a YouTube iFrame embed.
     *
     * @param Talk $talk
     *
     * @return string
     */
    public function getYouTubeEmbedUrl(Talk $talk): string
    {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $talk->getVideoUrl(), $matches);

        return $matches[1];
    }
}
