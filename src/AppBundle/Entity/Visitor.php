<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visitor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\VisitorRepository")
 */
class Visitor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;

    /**
     * @var integer
     *
     * @ORM\Column(name="nVisits", type="integer")
     */
    private $nVisits;


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
     * Set ip
     *
     * @param string $ip
     * @return Visitor
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set nVisits
     *
     * @param integer $nVisits
     * @return Visitor
     */
    public function setNVisits($nVisits)
    {
        $this->nVisits = $nVisits;

        return $this;
    }

    /**
     * Get nVisits
     *
     * @return integer 
     */
    public function getNVisits()
    {
        return $this->nVisits;
    }
}
