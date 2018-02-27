<?php

namespace shopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="wishlist")
 * @ORM\Entity(repositoryClass="shopBundle\Repository\WishlistRepository")
 */
class Wishlist
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    //relation user commande
    /**
     * @ORM\ManyToOne(targetEntity="Allforkids\UserBundle\Entity\Enfant", inversedBy="wishlists")
     * @ORM\JoinColumn(nullable=true)
     */
    private $enfant;

    //relation wishlist produits
    /**
     * @ORM\ManyToOne(targetEntity="shopBundle\Entity\Produit", inversedBy="wishlistsProd")
     * @ORM\JoinColumn(nullable=true)
     */
    private $produit;






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
     * Set produit
     *
     * @param \shopBundle\Entity\produit $produit
     *
     * @return Commande
     */
    public function setProduit(\shopBundle\Entity\produit $produit = null)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \shopBundle\Entity\produit
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set enfant
     *
     * @param \Allforkids\UserBundle\Entity\Enfant $enfant
     *
     * @return Wishlist
     */
    public function setEnfant(\Allforkids\UserBundle\Entity\Enfant $enfant = null)
    {
        $this->enfant = $enfant;

        return $this;
    }

    /**
     * Get enfant
     *
     * @return \Allforkids\UserBundle\Entity\Enfant
     */
    public function getEnfant()
    {
        return $this->enfant;
    }
}
