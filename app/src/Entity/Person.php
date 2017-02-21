<?php

namespace Phpsw\Website\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a person. This could be a speaker or organiser (not an attendee).
 *
 * It seems that until 7.1 support for nullable return types comes along we can't specify return types and setter
 * parameter types on entities, the problem is specific to using Symfony Form processing. See:
 * http://angelovdejan.me/2016/06/01/symfony3-form-component-and-type-hinting-in-php-7.html
 */
class Person
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
     * @var string
     *
     * @Assert\Url()
     * @Assert\Type("string")
     */
    private $photoUrl;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     * @Assert\Type("string")
     */
    private $description;

    /**
     * @var string
     * @Assert\Type("string")
     */
    private $twitterHandle;

    /**
     * @var string
     * @Assert\Type("string")
     */
    private $githubHandle;

    /**
     * @var string
     * @Assert\Type("string")
     * @Assert\Url()
     */
    private $websiteUrl;

    /**
     * @var int
     * @Assert\Type("int")
     * @Assert\GreaterThan(0)
     */
    private $meetupId;

    /**
     * @var Talk[]
     */
    private $talks = [];

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
    public function getTwitterHandle()
    {
        return $this->twitterHandle;
    }

    /**
     * @param string $twitterHandle
     */
    public function setTwitterHandle($twitterHandle)
    {
        $this->twitterHandle = $twitterHandle;
    }

    /**
     * @return string
     */
    public function getGithubHandle()
    {
        return $this->githubHandle;
    }

    /**
     * @param string $githubHandle
     */
    public function setGithubHandle($githubHandle)
    {
        $this->githubHandle = $githubHandle;
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
     * @return int
     */
    public function getMeetupId()
    {
        return $this->meetupId;
    }

    /**
     * @param int $meetupId
     */
    public function setMeetupId($meetupId)
    {
        $this->meetupId = $meetupId;
    }

    /**
     * Adds talk to speaker.
     *
     * Note: It is the Talk object that controls the relationship between Person and Talk.
     *
     * @param Talk $talk
     */
    public function addTalk(Talk $talk)
    {
        $this->talks[] = $talk;
    }

    /**
     * @return Talk[]
     */
    public function getTalks()
    {
        return $this->talks;
    }
}
