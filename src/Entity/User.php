<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *  fields = {"username"},
 *  message = "Le login que vous indiqué est deja utilise !"
 *)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbQcnCreer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbQcmRealises;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $moyenneQcm;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Qcm", mappedBy="autheur")
     */
    private $qcms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Resultat", mappedBy="Enseignant")
     */
    private $resultats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Appartenir", mappedBy="idUser")
     */
    private $appartenirs;

    public function __construct()
    {
        $this->qcms = new ArrayCollection();
        $this->resultats = new ArrayCollection();
        $this->appartenirs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNbQcnCreer(): ?int
    {
        return $this->nbQcnCreer;
    }

    public function setNbQcnCreer(?int $nbQcnCreer): self
    {
        $this->nbQcnCreer = $nbQcnCreer;

        return $this;
    }

    public function getNbQcmRealises(): ?int
    {
        return $this->nbQcmRealises;
    }

    public function setNbQcmRealises(?int $nbQcmRealises): self
    {
        $this->nbQcmRealises = $nbQcmRealises;

        return $this;
    }

    public function getMoyenneQcm(): ?string
    {
        return $this->moyenneQcm;
    }

    public function setMoyenneQcm(?string $moyenneQcm): self
    {
        $this->moyenneQcm = $moyenneQcm;

        return $this;
    }

    public function getRoles(): ?array
    {
         $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function eraseCredentials(){

    }

    public function getSalt(){}

    /**
     * @return Collection|Qcm[]
     */
    public function getQcms(): Collection
    {
        return $this->qcms;
    }

    public function addQcm(Qcm $qcm): self
    {
        if (!$this->qcms->contains($qcm)) {
            $this->qcms[] = $qcm;
            $qcm->setAutheur($this);
        }

        return $this;
    }

    public function removeQcm(Qcm $qcm): self
    {
        if ($this->qcms->contains($qcm)) {
            $this->qcms->removeElement($qcm);
            // set the owning side to null (unless already changed)
            if ($qcm->getAutheur() === $this) {
                $qcm->setAutheur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Resultat[]
     */
    public function getResultats(): Collection
    {
        return $this->resultats;
    }

    public function addResultat(Resultat $resultat): self
    {
        if (!$this->resultats->contains($resultat)) {
            $this->resultats[] = $resultat;
            $resultat->setEnseignant($this);
        }

        return $this;
    }

    public function removeResultat(Resultat $resultat): self
    {
        if ($this->resultats->contains($resultat)) {
            $this->resultats->removeElement($resultat);
            // set the owning side to null (unless already changed)
            if ($resultat->getEnseignant() === $this) {
                $resultat->setEnseignant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Appartenir[]
     */
    public function getAppartenirs(): Collection
    {
        return $this->appartenirs;
    }

    public function addAppartenir(Appartenir $appartenir): self
    {
        if (!$this->appartenirs->contains($appartenir)) {
            $this->appartenirs[] = $appartenir;
            $appartenir->setIdUser($this);
        }

        return $this;
    }

    public function removeAppartenir(Appartenir $appartenir): self
    {
        if ($this->appartenirs->contains($appartenir)) {
            $this->appartenirs->removeElement($appartenir);
            // set the owning side to null (unless already changed)
            if ($appartenir->getIdUser() === $this) {
                $appartenir->setIdUser(null);
            }
        }

        return $this;
    }

  

}
