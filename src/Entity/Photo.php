<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Photo
 *
 * @ORM\Table(name="photo", indexes={@ORM\Index(name="ck1", columns={"idU"})})
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_photo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPhoto;

    /**
     * @var string
     * @Assert\File(mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Please upload a valid image"
     * )
     * @ORM\Column(name="url", type="string", length=100, nullable=false)
     */
    private $url;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=4)
     * @ORM\Column(name="titre", type="string", length=30, nullable=false)
     */
    private $titre;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="theme", type="string", length=50, nullable=false)
     */
    private $theme;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="date_ajout", type="string", length=255, nullable=false)
     */
    private $dateAjout;

    /**
     * @var string
     * @ORM\Column(name="couleur", type="string", length=25, nullable=false)
     */
    private $couleur;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="localisation", type="string", length=35, nullable=false)
     */
    private $localisation;

    /**
     * @var \Userr
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idU", referencedColumnName="idU")
     * })
     */
    private $idu;

    public function getIdPhoto(): ?int
    {
        return $this->idPhoto;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getDateAjout(): ?string
    {
        return $this->dateAjout;
    }

    public function setDateAjout(string $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getIdu(): ?User
    {
        return $this->idu;
    }

    public function setIdu(?User $idu): self
    {
        $this->idu = $idu;

        return $this;
    }


}
