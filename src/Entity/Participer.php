<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participer
 *
 * @ORM\Table(name="participer")
 * @ORM\Entity(repositoryClass="App\Repository\ParticiperRepository")
 */
class Participer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_participer", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idParticiper;

    /**
     * @var int
     *
     * @ORM\Column(name="id_evenement", type="integer", nullable=false)
     */
    private $idEvenement;

    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    public function getIdParticiper(): ?int
    {
        return $this->idParticiper;
    }

    public function getIdEvenement(): ?int
    {
        return $this->idEvenement;
    }

    public function setIdEvenement(int $idEvenement): self
    {
        $this->idEvenement = $idEvenement;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }


}
