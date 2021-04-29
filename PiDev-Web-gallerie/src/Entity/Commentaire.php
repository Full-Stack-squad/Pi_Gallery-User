<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="ck3", columns={"idU"}), @ORM\Index(name="ck2", columns={"id_photo"})})
 * @ORM\Entity(repositoryClass="App\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_comm", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idComm;

    /**
     * @var string
     *
     * @ORM\Column(name="comm", type="string", length=255, nullable=false)
     */
    private $comm;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_user", type="string", length=255, nullable=false)
     */
    private $nomUser;

    /**
     * @var int
     *
     * @ORM\Column(name="id_photo", type="integer", nullable=false)
     */
    private $idPhoto;

    /**
     * @var int
     *
     * @ORM\Column(name="idU", type="integer", nullable=false)
     */
    private $idu;

    public function getIdComm(): ?int
    {
        return $this->idComm;
    }

    public function getComm(): ?string
    {
        return $this->comm;
    }

    public function setComm(string $comm): self
    {
        $this->comm = $comm;

        return $this;
    }

    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }

    public function setNomUser(string $nomUser): self
    {
        $this->nomUser = $nomUser;

        return $this;
    }

    public function getIdPhoto(): ?int
    {
        return $this->idPhoto;
    }

    public function setIdPhoto(int $idPhoto): self
    {
        $this->idPhoto = $idPhoto;

        return $this;
    }

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function setIdu(int $idu): self
    {
        $this->idu = $idu;

        return $this;
    }


}
