<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\PoliticienRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PoliticienRepository")
 * @UniqueEntity(fields="nom")
 * @ORM\HasLifecycleCallbacks()
 */
class Politicien
{


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=1)
     * @Assert\Regex(pattern="(M|F|m|f)",message="M pour homme, F pour femme")
     */
    private $sexe;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual( value = 18,
     * message="la personne doit être majeur, 18+ ans")
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Mairie", inversedBy="politiciens")
     */
    private $mairie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parti", inversedBy="politiciens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parti;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Affaire", mappedBy="politicien", cascade={"remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $affaires;

    public function __construct()
    {
        $this->affaires = new ArrayCollection();
    }



    public function __toString()
    {
        return $this->getNom();
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

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = strtoupper($sexe);

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getMairie(): ?Mairie
    {
        return $this->mairie;
    }

    public function setMairie(?Mairie $mairie): self
    {
        $this->mairie = $mairie;

        return $this;
    }

    public function getParti(): ?Parti
    {
        return $this->parti;
    }

    public function setParti(?Parti $parti): self
    {
        $this->parti = $parti;

        return $this;
    }

    /**
     * @return Collection|Affaire[]
     */
    public function getAffaires(): Collection
    {
        return $this->affaires;
    }

    public function addAffaire(Affaire $affaire): self
    {
        if (!$this->affaires->contains($affaire)) {
            $this->affaires[] = $affaire;
            $affaire->addPoliticien($this);
        }

        return $this;
    }

    public function removeAffaire(Affaire $affaire): self
    {
        if ($this->affaires->contains($affaire)) {
            $this->affaires->removeElement($affaire);
            $affaire->removePoliticien($this);
        }

        return $this;
    }

    


    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function sexeUpper()
    {
        $this->sexe = strtoupper($this->sexe);
    }
}
