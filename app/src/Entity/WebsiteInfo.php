<?php

namespace Phpsw\Website\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Holds information shown on home page.
 */
class WebsiteInfo
{

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $emailAddress;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $meetupUrl;

    /**
     * @var string;
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $slug;

    /**
     * @var Sponsor[]
     *
     * @Assert\Collection()
     * @Assert\Count(min="1")
     */
    private $sponsors;

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

    /**
     * @return Sponsor[]
     */
    public function getSponsors()
    {
        return $this->sponsors;
    }

    /**
     * @param Sponsor[] $sponsors
     */
    public function setSponsors($sponsors)
    {
        $this->sponsors = $sponsors;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param string $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return string
     */
    public function getMeetupUrl()
    {
        return $this->meetupUrl;
    }

    /**
     * @param string $meetupUrl
     */
    public function setMeetupUrl($meetupUrl)
    {
        $this->meetupUrl = $meetupUrl;
    }
}
