<?php

namespace Phpsw\Website\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Holds information shown on home page.
 */
class WebsiteInfo
{
    /**
     * @var string;
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
    private $description;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Url()
     * @Assert\Type("string")
     */
    private $photoUrl;

    /**
     * @var Person[]
     *
     * @Assert\Collection()
     * @Assert\Count(min="1")
     */
    private $organisers;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    /**
     * @param string $photoUrl
     */
    public function setPhotoUrl($photoUrl)
    {
        $this->photoUrl = $photoUrl;
    }

    /**
     * @return Person[]
     */
    public function getOrganisers()
    {
        return $this->organisers;
    }

    /**
     * @param Person[] $organisers
     */
    public function setOrganisers($organisers)
    {
        $this->organisers = $organisers;
    }
}
