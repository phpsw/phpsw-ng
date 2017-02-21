<?php

namespace Phpsw\Website\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Event
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $slug;

    /**
     * @var string
     *
     * @Assert\Type("string")
     */
    private $meetupId;

    /**
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\NotBlank()
     */
    private $date;

    /**
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @Assert\Type("string")
     */
    private $description;

    /**
     * @var Location
     */
    private $venue;

    /**
     * @var Location
     */
    private $pub;

    /**
     * @var Person[]
     *
     * @Assert\Collection()
     */
    private $organisers;

    /**
     * @var Sponsor[]
     *
     * @Assert\Collection()
     */
    private $sponsors;

    /**
     * @var string
     *
     * @Assert\Type("string")
     */
    private $joindInUrl;

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
    public function getMeetupId()
    {
        return $this->meetupId;
    }

    /**
     * @param string $meetupId
     */
    public function setMeetupId($meetupId)
    {
        $this->meetupId = $meetupId;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * @return Location
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * @param Location $venue
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
    }

    /**
     * @return Location
     */
    public function getPub()
    {
        return $this->pub;
    }

    /**
     * @param Location $pub
     */
    public function setPub($pub)
    {
        $this->pub = $pub;
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
    public function getJoindInUrl()
    {
        return $this->joindInUrl;
    }

    /**
     * @param string $joindInUrl
     */
    public function setJoindInUrl($joindInUrl)
    {
        $this->joindInUrl = $joindInUrl;
    }
}
