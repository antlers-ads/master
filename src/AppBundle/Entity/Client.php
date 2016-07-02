<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Advertisement;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Client entity.
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClientRepository")
 *
 * @UniqueEntity("name")
 */
class Client
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="text", unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=3,max=50)
     */
    private $name;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Advertisement", mappedBy="client")
     */
    private $advertisements;

    /**
     * Initializes entity.
     */
    public function __construct()
    {
        $this->advertisements = new ArrayCollection();
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets name.
     *
     * @param string $name
     * @return Client
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
     * Adds advertisement.
     *
     * @param Advertisement $advertisement
     * @return Client
     */
    public function addAdvertisement(Advertisement $advertisement)
    {
        $this->advertisements[] = $advertisement;
        return $this;
    }

    /**
     * Removes advertisement.
     *
     * @param Advertisement $advertisement
     */
    public function removeAdvertisement(Advertisement $advertisement)
    {
        $this->advertisements->removeElement($advertisement);
    }

    /**
     * Gets advertisements.
     *
     * @return Collection
     */
    public function getAdvertisements()
    {
        return $this->advertisements;
    }
}
