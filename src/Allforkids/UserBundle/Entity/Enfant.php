<?php

namespace Allforkids\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enfant
 *
 * @ORM\Table(name="Enfant")
 * @ORM\Entity(repositoryClass="Allforkids/UserBundle\Repository\EnfantRepository")
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
     * @ORM\OneToMany(targetEntity="shopBundle\Entity\Wishlist", mappedBy="enfant",cascade={"persist","remove"})
     */
    private $wishlists;

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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->wishlists = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add wishlist
     *
     * @param \shopBundle\Entity\Wishlist $wishlist
     *
     * @return Enfant
     */
    public function addWishlist(\shopBundle\Entity\Wishlist $wishlist)
    {
        $this->wishlists[] = $wishlist;

        return $this;
    }

    /**
     * Remove wishlist
     *
     * @param \shopBundle\Entity\Wishlist $wishlist
     */
    public function removeWishlist(\shopBundle\Entity\Wishlist $wishlist)
    {
        $this->wishlists->removeElement($wishlist);
    }

    /**
     * Get wishlists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWishlists()
    {
        return $this->wishlists;
    }
}
