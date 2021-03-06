<?php

namespace Allforkids\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enfant
 *
 * @ORM\Table(name="Enfant")
 * @ORM\Entity(repositoryClass="AllforkidsUserBundle\Repository\EnfantRepository")
 */
class Enfant
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Allforkids\UserBundle\Entity\Guardian", inversedBy="enfants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $guardian;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set guardian
     *
     * @param \Allforkids\UserBundle\Entity\Guardian $guardian
     *
     * @return Enfant
     */
    public function setGuardian(\Allforkids\UserBundle\Entity\Guardian $guardian = null)
    {
        $this->guardian = $guardian;

        return $this;
    }

    /**
     * Get guardian
     *
     * @return \Allforkids\UserBundle\Entity\Guardian
     */
    public function getGuardian()
    {
        return $this->guardian;
    }
}
