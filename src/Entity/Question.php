<?php

namespace App\Entity;

use App\Entity\Proposition;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\Resultat;
use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
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


public function CalculPointsQuestion(Question $question,Resultat $resultat,ReponseRepository $rep)
 {
    $po = $question->getPropositions();
    $propoqcm = $question->getQcm();

    static $point=0;
    static $mauvaise_reponse=0;
    static $bonne_reponse=0;
    foreach ($po as  $value) {
        $reponse = $rep->findBy(
                ['idResultat' => $resultat,
                 'idProposition' => $value
                    ],
                );
        
        

        if ($reponse == [])
        { 
            
            $point = 0;
            dump('pas reponse'.$point);
            return $point;

            dump('pas reponse'.$point);
        }else{
           
            if($value->getResultatVraiFaux()==$reponse[0]->getReponseEleve()){
              $bonne_reponse +=1 ;
              dump('bon'.$bonne_reponse);

            }else{
                $mauvaise_reponse++;
            }
        }
    }

    dump('toto');

    if($bonne_reponse>$mauvaise_reponse && $mauvaise_reponse==0){
      $point=1;
    }else{
      $point=0;
    }
    $bonne_reponse=0;
    $mauvaise_reponse=0;

    return $point;


}


    public function ValiditéQuestion(Question $question,Resultat $resultat, ReponseRepository $reponse): string
    {
     
        $po = $question->getPropositions();

        $nbresp = 0;
        foreach ($po as $value) {
            
          
            $reponse_eleve = $reponse->findBy(
                    ['idResultat' => $resultat->getId(),
                    'idProposition' => $value->getId()
                ],
                    
                );
            if ($reponse_eleve) 
            {
                $nbresp+=1;

            }
        }
        
        
       
        if ($nbresp==0)
        {
           return 'Non';

        }else{
          return 'Oui';

        }
    }


 }

