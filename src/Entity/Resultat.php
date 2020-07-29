<?php

namespace App\Entity;

use App\Entity\Resultat;
use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultatRepository")
 */
class Resultat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $affecttedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $realiseAt;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="resultats")
     */
    private $Enseignant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="resultats")
     */
    private $Eleve;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Qcm", inversedBy="resultats")
     */
    private $qcm;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reponse", mappedBy="idResultat")
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

    public function getAffecttedAt(): ?\DateTimeInterface
    {
        return $this->affecttedAt;
    }

    public function setAffecttedAt(\DateTimeInterface $affecttedAt): self
    {
        $this->affecttedAt = $affecttedAt;

        return $this;
    }

    public function getRealiseAt(): ?\DateTimeInterface
    {
        return $this->realiseAt;
    }

    public function setRealiseAt(?\DateTimeInterface $realiseAt): self
    {
        $this->realiseAt = $realiseAt;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getEnseignant(): ?User
    {
        return $this->Enseignant;
    }

    public function setEnseignant(?User $Enseignant): self
    {
        $this->Enseignant = $Enseignant;

        return $this;
    }

    public function getEleve(): ?User
    {
        return $this->Eleve;
    }

    public function setEleve(?User $Eleve): self
    {
        $this->Eleve = $Eleve;

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
            $reponse->setIdResultat($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->contains($reponse)) {
            $this->reponses->removeElement($reponse);
            // set the owning side to null (unless already changed)
            if ($reponse->getIdResultat() === $this) {
                $reponse->setIdResultat(null);
            }
        }

        return $this;
    }



    public function CalculNoteQCM(Resultat $result, ReponseRepository $reponse)
    {
        $quest = $result->getQcm()->getQuestions();
        
        $point_total =0 ;
        $nbqs = count($quest);

        foreach ($quest as  $question) {
            $point_total +=$question->CalculPointsQuestion($question,$result,$reponse);
            
        }
      
        $note = (floatval($point_total) * 20)/floatval($nbqs);
        return number_format($note,2) ;

    }

    public function NbQuestValider(Resultat $result, ReponseRepository $reponse)
    {
        $questions = $result->getQcm()->getQuestions();
        $nbvalider = 0;

        foreach ($questions as  $question) {

            if($question->CalculPointsQuestion($question,$result,$reponse)==1){
                
                $nbvalider ++;
            }

            
        }

       dump($nbvalider);
        return $nbvalider;
    }
}
