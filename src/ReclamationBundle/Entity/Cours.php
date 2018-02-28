<?php

namespace ReclamationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cours
 *
 * @ORM\Table(name="cours")
 * @ORM\Entity(repositoryClass="ReclamationBundle\Repository\CoursRepository")
 */
class Cours
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @return int
     */
    public function getTemps()
    {
        return $this->temps;
    }

    /**
     * @param int $temps
     */
    public function setTemps($temps)
    {
        $this->temps = $temps;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="temps", type="integer")
     */
    private $temps;

    /**
     * @return mixed
     */
    public function getCible()
    {
        return $this->cible;
    }

    /**
     * @param mixed $cible
     */
    public function setCible($cible)
    {
        $this->cible = $cible;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="cible", type="integer")
     */
    private $cible;
    /**
     * @var string
     *
     * @ORM\Column(name="niveaux", type="string",length=255)
     */
    private $niveaux;

    /**
     * @return mixed
     */
    public function getNiveaux()
    {
        return $this->niveaux;
    }

    /**
     * @param mixed $niveaux
     */
    public function setNiveaux($niveaux)
    {
        $this->niveaux = $niveaux;
    }

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\Image()
     */
    private $image;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;


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
     * Set categorie
     *
     * @param string $categorie
     *
     * @return Cours
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Cours
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
