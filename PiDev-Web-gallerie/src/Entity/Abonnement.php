<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement")
 * @ORM\Entity(repositoryClass="App\Repository\AbonnementRepository")
 */
class Abonnement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Anom", type="string", length=100, nullable=false)
     */
    private $anom;

    /**
     * @var int
     *
     * @ORM\Column(name="idU", type="integer", nullable=false)
     */
    private $idu;

    /**
     * @var int
     *
     * @ORM\Column(name="idA", type="integer", nullable=false)
     */
    private $ida;

    /**
     * @var string
     *
     * @ORM\Column(name="nomA", type="string", length=255, nullable=false)
     */
    private $noma;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnom(): ?string
    {
        return $this->anom;
    }

    public function setAnom(string $anom): self
    {
        $this->anom = $anom;

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

    public function getIda(): ?int
    {
        return $this->ida;
    }

    public function setIda(int $ida): self
    {
        $this->ida = $ida;

        return $this;
    }

    public function getNoma(): ?string
    {
        return $this->noma;
    }

    public function setNoma(string $noma): self
    {
        $this->noma = $noma;

        return $this;
    }


}
