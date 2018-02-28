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
 * @ORM\Entity()
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
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
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
     * @ORM\OneToMany(targetEntity="ReclamationBundle\Entity\Reclamation", mappedBy="user")
     */
    private $reclamations;

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
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
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
     * Set reclamation
     *
     * @param \ReclamationBundle\Entity\Reclamation $reclamation
     *
     * @return User
     */
    public function setReclamation(\ReclamationBundle\Entity\Reclamation $reclamation = null)
    {
        $this->reclamation = $reclamation;

        return $this;
    }

    /**
     * Get reclamation
     *
     * @return \ReclamationBundle\Entity\Reclamation
     */
    public function getReclamation()
    {
        return $this->reclamation;
    }

    /**
     * Add reclamation
     *
     * @param \ReclamationBundle\Entity\Reclamation $reclamation
     *
     * @return User
     */
    public function addReclamation(\ReclamationBundle\Entity\Reclamation $reclamation)
    {
        $this->reclamations[] = $reclamation;

        return $this;
    }

    /**
     * Remove reclamation
     *
     * @param \ReclamationBundle\Entity\Reclamation $reclamation
     */
    public function removeReclamation(\ReclamationBundle\Entity\Reclamation $reclamation)
    {
        $this->reclamations->removeElement($reclamation);
    }

    /**
     * Get reclamations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReclamations()
    {
        return $this->reclamations;
    }
}
