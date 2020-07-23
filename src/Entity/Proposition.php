<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropositionRepository")
 */
class Proposition
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $libelleProposition;

    /**
     * @ORM\Column(type="integer")
     */
    private $resultatVraiFaux;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="propositions")
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reponse", mappedBy="idProposition")
     */
    private $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleProposition(): ?string
    {
        return $this->libelleProposition;
    }

    public function setLibelleProposition(string $libelleProposition): self
    {
        $this->libelleProposition = $libelleProposition;

        return $this;
    }

    public function getResultatVraiFaux()
    {
        return $this->resultatVraiFaux;
    }

    public function setResultatVraiFaux($resultatVraiFaux): self
    {
        $this->resultatVraiFaux = $resultatVraiFaux;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return Collection|Reponse[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setIdProposition($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->contains($reponse)) {
            $this->reponses->removeElement($reponse);
            // set the owning side to null (unless already changed)
            if ($reponse->getIdProposition() === $this) {
                $reponse->setIdProposition(null);
            }
        }

        return $this;
    }
}
