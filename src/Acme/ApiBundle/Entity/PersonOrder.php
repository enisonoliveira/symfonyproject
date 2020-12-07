<?php

namespace Acme\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PersonOrder
 * @ORM\Table()
 * @ORM\Entity
 */
class PersonOrder
{
    /**
     * @var integer
     *
     * @ORM\Column(name="personid", type="integer")
     * @ORM\Id
     */
    private $personid;

    /**
     * @var text
     * @ORM\Column(name="personname", type="text")
     */

    private  $personname;


    /**
     * @ORM\OneToMany(targetEntity="\Acme\ApiBundle\Entity\Phone", mappedBy="person_id")
     */

    protected $phone;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phone = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set personid
     *
     * @param integer $personid
     *
     * @return PersonOrder
     */
    public function setPersonid($personid)
    {
        $this->personid = $personid;

        return $this;
    }

    /**
     * Get personid
     *
     * @return integer
     */
    public function getPersonid()
    {
        return $this->personid;
    }

    /**
     * Set personname
     *
     * @param string $personname
     *
     * @return PersonOrder
     */
    public function setPersonname($personname)
    {
        $this->personname = $personname;

        return $this;
    }

    /**
     * Get personname
     *
     * @return string
     */
    public function getPersonname()
    {
        return $this->personname;
    }

    /**
     * Add phone
     *
     * @param \Acme\ApiBundle\Entity\Phone $phone
     *
     * @return PersonOrder
     */
    public function addPhone(\Acme\ApiBundle\Entity\Phone $phone)
    {
        $this->phone[] = $phone;

        return $this;
    }

    /**
     * Remove phone
     *
     * @param \Acme\ApiBundle\Entity\Phone $phone
     */
    public function removePhone(\Acme\ApiBundle\Entity\Phone $phone)
    {
        $this->phone->removeElement($phone);
    }

    /**
     * Get phone
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhone()
    {
        return $this->phone;
    }
}
