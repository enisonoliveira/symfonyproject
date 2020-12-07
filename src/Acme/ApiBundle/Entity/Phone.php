<?php

namespace Acme\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phone
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Phone
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @ORM\ManyToOne(targetEntity="Acme\ApiBundle\Entity\PersonOrder", inversedBy="phone")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="personid")
     */
    private $person_id;

    /**
     * @var text
     * @ORM\Column(name="phone", type="text")
     */
    private $phone;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set personId
     *
     * @param \Acme\ApiBundle\Entity\PersonOrder $personId
     *
     * @return Phone
     */
    public function setPersonId(\Acme\ApiBundle\Entity\PersonOrder $personId = null)
    {
        $this->person_id = $personId;

        return $this;
    }

    /**
     * Get personId
     *
     * @return \Acme\ApiBundle\Entity\PersonOrder
     */
    public function getPersonId()
    {
        return $this->person_id;
    }
}
