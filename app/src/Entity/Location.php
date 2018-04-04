<?php

namespace Phpsw\Website\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a location (e.g. a venue where a meetup took place or a pub for drinks afterwards).
 */
class Location
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
    private $name;

    /**
     * @var string;
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $address;

    /**
     * @var string;
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $postcode;

    /**
     * @var string;
     *
     * @Assert\Type("string")
     * @Assert\Url()
     */
    private $mapsUrl;

    /**
     * @var string;
     *
     * @Assert\Type("string")
     * @Assert\Url()
     */
    private $website;

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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     * @return string
     */
    public function getMapsUrl()
    {
        return $this->mapsUrl;
    }

    /**
     * @param string $mapsUrl
     */
    public function setMapsUrl($mapsUrl)
    {
        $this->mapsUrl = $mapsUrl;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * Returns a unique ID for the Location.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->getSlug();
    }
}
