<?php
/**
 * Created by PhpStorm.
 * User: belig
 * Date: 07/02/2018
 * Time: 22:11
 */
namespace Allforkids\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    public function __construct()
    {
        parent::__construct();
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(

     *     max=255,

     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $nom;

    /**
     *@ORM\OneToOne(targetEntity="Guardian")
     *@ORM\JoinColumn(name="guardian_id", referencedColumnName="id")
     */
    private $parent;
    /**
     *@ORM\OneToOne(targetEntity="Etablissement")
     *@ORM\JoinColumn(name="Etablissement_id", referencedColumnName="id")
     */
    private $etablissement;
    /**
     *@ORM\OneToOne(targetEntity="Enfant")
     *@ORM\JoinColumn(name="Enfant_id", referencedColumnName="id")
     */
    private $enfant;

//image a inserer pour photo de profil
    /**
     * @var string
     * @ORM\Column(name="image",type="string", nullable=true)
     * @Assert\Image()
     */
    private $image;

    /**
 * @ORM\Column(type="string", length=255)
 *
 * @Assert\NotBlank(message="Please enter your second name.", groups={"Registration", "Profile"})
 * @Assert\Length(

 *     max=255,

 *     maxMessage="The name is too long.",
 *     groups={"Registration", "Profile"}
 * )
 */
    protected $prenom;

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }


    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return User
     */
    public function setImage($image)
    {

        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set parent
     *
     * @param \Allforkids\UserBundle\Entity\Guardian $parent
     *
     * @return User
     */
    public function setParent(\Allforkids\UserBundle\Entity\Guardian $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Allforkids\UserBundle\Entity\Guardian
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set etablissement
     *
     * @param \Allforkids\UserBundle\Entity\Etablissement $etablissement
     *
     * @return User
     */
    public function setEtablissement(\Allforkids\UserBundle\Entity\Etablissement $etablissement = null)
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * Get etablissement
     *
     * @return \Allforkids\UserBundle\Entity\Etablissement
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * Set enfant
     *
     * @param \Allforkids\UserBundle\Entity\Enfant $enfant
     *
     * @return User
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

    /**
     * Add commande
     *
     * @param \shopBundle\Entity\Produit $commande
     *
     * @return User
     */
    public function addCommande(\shopBundle\Entity\Produit $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \shopBundle\Entity\Produit $commande
     */
    public function removeCommande(\shopBundle\Entity\Produit $commande)
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
}
