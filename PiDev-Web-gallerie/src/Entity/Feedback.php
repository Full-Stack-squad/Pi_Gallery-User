<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feedback
 *
 * @ORM\Table(name="feedback", indexes={@ORM\Index(name="id_membre", columns={"id_membre"}), @ORM\Index(name="id_abonne", columns={"id_abonne"})})
 * @ORM\Entity(repositoryClass="App\Repository\FeedbackRepository")
 */
class Feedback
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_feedback", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFeedback;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=60, nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=60, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer", nullable=false)
     */
    private $rating;

    /**
     * @var \Userr
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_abonne", referencedColumnName="idU")
     * })
     */
    private $idAbonne;

    /**
     * @var \Userr
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_membre", referencedColumnName="idU")
     * })
     */
    private $idMembre;

    public function getIdFeedback(): ?int
    {
        return $this->idFeedback;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getIdAbonne(): ?User
    {
        return $this->idAbonne;
    }

    public function setIdAbonne(?User $idAbonne): self
    {
        $this->idAbonne = $idAbonne;

        return $this;
    }

    public function getIdMembre(): ?User
    {
        return $this->idMembre;
    }

    public function setIdMembre(?User $idMembre): self
    {
        $this->idMembre = $idMembre;

        return $this;
    }


}
