<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReponseRepository")
 */
class Reponse
{


    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Resultat", inversedBy="reponses")
     */
    private $idResultat;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Proposition", inversedBy="reponses")
     */
    private $idProposition;

    /**
     * @ORM\Column(type="binary")
     */
    private $reponseEleve;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdResultat(): ?Resultat
    {
        return $this->idResultat;
    }

    public function setIdResultat(?Resultat $idResultat): self
    {
        $this->idResultat = $idResultat;

        return $this;
    }

    public function getIdProposition(): ?Proposition
    {
        return $this->idProposition;
    }

    public function setIdProposition(?Proposition $idProposition): self
    {
        $this->idProposition = $idProposition;

        return $this;
    }

    public function getReponseEleve()
    {
        return $this->reponseEleve;
    }

    public function setReponseEleve($reponseEleve): self
    {
        $this->reponseEleve = $reponseEleve;

        return $this;
    }
}
