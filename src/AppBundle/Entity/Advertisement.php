<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Client;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AppAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Advertisement entity.
 *
 * @ORM\Table(name="advertisement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdvertisementRepository")
 *
 * @UniqueEntity(
 *     fields={"name", "client"},
 *     errorPath="name",
 *     message="This client already owns advertisement with provided name."
 * )
 * @AppAssert\DateRange
 */
class Advertisement
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="text")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=3,max=200)
     */
    private $name;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="advertisements")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $client;

    /**
     * @var integer
     * @ORM\Column(name="width", type="integer", nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @Assert\Range(min=0,max=1000)
     */
    private $width;

    /**
     * @var integer
     * @ORM\Column(name="height", type="integer", nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @Assert\Range(min=0,max=1000)
     */
    private $height;

    /**
     * @var integer
     * @ORM\Column(name="views", type="integer", nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @Assert\Range(min=0)
     */
    private $views;

    /**
     * @var integer
     * @ORM\Column(name="clicks", type="integer", nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @Assert\Range(min=0)
     */
    private $clicks;

    /**
     * @var \DateTime
     * @ORM\Column(name="start_date", type="datetime", nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $start_date;

    /**
     * @var \DateTime
     * @ORM\Column(name="end_date", type="datetime", nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $end_date;

    /**
     * @var string
     * @ORM\Column(name="url", type="text")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=3,max=200)
     * @Assert\Url()
     */
    private $url;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Image(
     *     maxSize="1024k",
     *     minWidth=10,
     *     maxWidth=1000,
     *     minHeight=10,
     *     maxHeight=1000,
     *     mimeTypes={"image/jpeg","image/png","image/gif"}
     * )
     */
    private $image;

    /**
     * Initializes entity.
     */
    public function __construct()
    {
        $this->width = 0;
        $this->height = 0;
        $this->views = 0;
        $this->clicks = 0;
    }

    /**
     * Returns string representation of an entity.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Gets id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets name.
     *
     * @param string $name
     * @return Advertisement
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets client.
     *
     * @param Client $client
     * @return Advertisement
     */
    public function setClient(Client $client = null)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Gets client.
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Sets width.
     *
     * @param integer $width
     * @return Advertisement
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Gets width.
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Sets height.
     *
     * @param integer $height
     * @return Advertisement
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Gets height.
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Sets views.
     *
     * @param integer $views
     * @return Advertisement
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Gets views.
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Sets clicks.
     *
     * @param integer $clicks
     * @return Advertisement
     */
    public function setClicks($clicks)
    {
        $this->clicks = $clicks;

        return $this;
    }

    /**
     * Gets clicks.
     *
     * @return integer
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * Sets start date.
     *
     * @param \DateTime $startDate
     * @return Advertisement
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->start_date = $startDate;
        return $this;
    }

    /**
     * Gets start date.
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Sets end date.
     *
     * @param \DateTime $endDate
     * @return Advertisement
     */
    public function setEndDate(\DateTime $endDate)
    {
        $this->end_date = $endDate;
        return $this;
    }

    /**
     * Gets end date.
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Sets url.
     *
     * @param string $url
     * @return Advertisement
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Gets url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets image.
     *
     * @param string $image
     * @return Advertisement
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Gets image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}
