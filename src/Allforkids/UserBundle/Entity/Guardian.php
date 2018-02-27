<?php

namespace Allforkids\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Guardian
 *
 * @ORM\Table(name="Guardian")
 * @ORM\Entity(repositoryClass="Allforkids/UserBundle\Repository\GuardianRepository")
 */

class Guardian
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    //one to many m3a commandes
    /**
     * @ORM\OneToMany(targetEntity="shopBundle\Entity\Commande", mappedBy="guardian",cascade={"persist","remove"})
     */
    private $commandes;
    /**
     * @ORM\OneToMany(targetEntity="Allforkids\UserBundle\Entity\Enfant", mappedBy="guardian",cascade={"persist","remove"})
     */
    private $enfants;
    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="numTel", type="string", length=8)
     */
    private $numTel;


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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Guardian
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set numTel
     *
     * @param string $numTel
     *
     * @return Guardian
     */
    public function setNumTel($numTel)
    {
        $this->numTel = $numTel;

        return $this;
    }

    /**
     * Get numTel
     *
     * @return string
     */
    public function getNumTel()
    {
        return $this->numTel;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->enfants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add commande
     *
     * @param \shopBundle\Entity\Commande $commande
     *
     * @return Guardian
     */
    public function addCommande(\shopBundle\Entity\Commande $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \shopBundle\Entity\Commande $commande
     */
    public function removeCommande(\shopBundle\Entity\Commande $commande)
    {
        $this->commandes->removeElement($commande);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Add enfant
     *
     * @param \Allforkids\UserBundle\Entity\Enfant $enfant
     *
     * @return Guardian
     */
    public function addEnfant(\Allforkids\UserBundle\Entity\Enfant $enfant)
    {
        $this->enfants[] = $enfant;

        return $this;
    }

    /**
     * Remove enfant
     *
     * @param \Allforkids\UserBundle\Entity\Enfant $enfant
     */
    public function removeEnfant(\Allforkids\UserBundle\Entity\Enfant $enfant)
    {
        $this->enfants->removeElement($enfant);
    }

    /**
     * Get enfants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnfants()
    {
        return $this->enfants;
    }
}
