<?php


namespace Phpsw\Entity;


class Event
{

    /**
     * @var string
     */
    private $meetupId;

    /**
     * @var string
     */
    private $date;


    /**
     * @var string
     */
    private $title;


    /**
     * @var
     */
    private $description;


    /**
     * @var Talk[]
     */
    private $talks;


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
     */
    private $organisers;


    /**
     * @var Sponsor[]
     */
    private $sponsors;


    /**
     * @var string
     */
    private $joindInUrl;


    
}

