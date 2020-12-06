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
     * @ORM\JoinColumn(name="personid", referencedColumnName="personid")
     */
    private $personid;

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
     * Set personid
     *
     * @param \Acme\ApiBundle\Entity\PersonOrder $personid
     * @return Phone
     */
    public function setPersonid(\Acme\ApiBundle\Entity\PersonOrder $personid = null)
    {
        $this->personid = $personid;
    
        return $this;
    }

    /**
     * Get personid
     *
     * @return \Acme\ApiBundle\Entity\PersonOrder 
     */
    public function getPersonid()
    {
        return $this->personid;
    }
}