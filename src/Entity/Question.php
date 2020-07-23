<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
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
    private $libelleQuestion;

    /**
     * @ORM\Column(type="time")
     */
    private $timeQuestion;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idQuestionPrecedent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Qcm", inversedBy="questions")
     */
    private $qcm;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proposition", cascade={"remove"}, mappedBy="question")
     */
    private $propositions;

    public function __construct()
    {
        $this->propositions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleQuestion(): ?string
    {
        return $this->libelleQuestion;
    }

    public function setLibelleQuestion(string $libelleQuestion): self
    {
        $this->libelleQuestion = $libelleQuestion;

        return $this;
    }

    public function getTimeQuestion(): ?\DateTimeInterface
    {
        return $this->timeQuestion;
    }

    public function setTimeQuestion(\DateTimeInterface $timeQuestion): self
    {
        $this->timeQuestion = $timeQuestion;

        return $this;
    }

    public function getQcm(): ?Qcm
    {
        return $this->qcm;
    }

    public function setQcm(?Qcm $qcm): self
    {
        $this->qcm = $qcm;

        return $this;
    }

    /**
     * @return Collection|Proposition[]
     */
    public function getPropositions(): Collection
    {
        return $this->propositions;
    }

    public function addProposition(Proposition $proposition): self
    {
        if (!$this->propositions->contains($proposition)) {
            $this->propositions[] = $proposition;
            $proposition->setQuestion($this);
        }

        return $this;
    }

    public function removeProposition(Proposition $proposition): self
    {
        if ($this->propositions->contains($proposition)) {
            $this->propositions->removeElement($proposition);
            // set the owning side to null (unless already changed)
            if ($proposition->getQuestion() === $this) {
                $proposition->setQuestion(null);
            }
        }

        return $this;
    }
}
