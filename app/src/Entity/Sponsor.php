<?php

namespace Phpsw\Website\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Sponsor
{
    /**
     * Full sponsor.
     */
    const SPONSOR_FULL = 'full';

    /**
     * Sponsor only covers occasional events.
     */
    const SPONSOR_EVENT = 'event';

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $slug;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Url()
     */
    private $logoUrl;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Url()
     */
    private $websiteUrl;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Choice(callback="getSponsorTypes")
     */
    private $sponsorType;

    /**
     * @var string
     */
    private $description;

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    /**
     * @param string $logoUrl
     */
    public function setLogoUrl($logoUrl)
    {
        $this->logoUrl = $logoUrl;
    }

    /**
     * @return string
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * @param string $websiteUrl
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;
    }

    /**
     * @return string
     */
    public function getSponsorType()
    {
        return $this->sponsorType;
    }

    /**
     * @param string $sponsorType
     */
    public function setSponsorType(string $sponsorType)
    {
        $this->sponsorType = $sponsorType;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Returns true if sponsor type is valid.
     *
     * @param string $sponsorType
     *
     * @return bool
     */
    public static function isValidSponsorType(string $sponsorType): bool
    {
        return in_array($sponsorType, self::getSponsorTypes());
    }

    /**
     * Returns valid sponsor types.
     *
     * @return string[]
     */
    public static function getSponsorTypes(): array
    {
        return [
            self::SPONSOR_FULL,
            self::SPONSOR_EVENT,
        ];
    }
}
