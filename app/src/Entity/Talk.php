<?php

namespace Phpsw\Website\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Talk
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
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @Assert\Type("string")
     */
    private $abstract;

    /**
     * @var Event
     *
     * @Assert\NotBlank()
     */
    private $event;

    /**
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\Url()
     */
    private $slidesUrl;

    /**
     * @var string
     *
     * @Assert\Type("string")
     */
    private $joindinUrl;

    /**
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\Url()
     */
    private $videoUrl;

    /**
     * @var Person[]
     *
     * @Assert\Collection()
     * @Assert\Count(min="1")
     */
    private $speakers;

    /**
     * @var bool
     */
    private $showcase = false;

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
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * @param string $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
        $event->addTalk($this);
    }

    /**
     * @return string
     */
    public function getSlidesUrl()
    {
        return $this->slidesUrl;
    }

    /**
     * @param string $slidesUrl
     */
    public function setSlidesUrl($slidesUrl)
    {
        $this->slidesUrl = $slidesUrl;
    }

    /**
     * @return string
     */
    public function getJoindinUrl()
    {
        return $this->joindinUrl;
    }

    /**
     * @param string $joindinUrl
     */
    public function setJoindinUrl($joindinUrl)
    {
        $this->joindinUrl = $joindinUrl;
    }

    /**
     * @return string
     */
    public function getVideoUrl()
    {
        return $this->videoUrl;
    }

    /**
     * @param string $videoUrl
     */
    public function setVideoUrl($videoUrl)
    {
        $this->videoUrl = $videoUrl;
    }

    /**
     * @return Person[]
     */
    public function getSpeakers()
    {
        return $this->speakers;
    }

    /**
     * @param Person[] $speakers
     */
    public function setSpeakers($speakers)
    {
        $this->speakers = $speakers;
        foreach ($speakers as $speaker) {
            $speaker->addTalk($this);
        }
    }

    /**
     * PHP-SW's best talks should have the showcase flag set to true. These talks will be shown on the talks page.
     *
     * @return bool
     */
    public function isShowcase(): bool
    {
        return $this->showcase;
    }

    /**
     * @param bool $showcase
     */
    public function setShowcase(bool $showcase)
    {
        $this->showcase = $showcase;
    }

    /**
     * Returns a unique ID for the Talk.
     *
     * @return string
     */
    public function getId(): string
    {
        return "{$this->getEvent()->getSlug()}-{$this->getSlug()}";
    }
}
