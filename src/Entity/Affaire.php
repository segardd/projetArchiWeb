<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AffaireRepository")
 * @UniqueEntity(fields="designation")
 */
class Affaire
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
    private $designation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Politicien", inversedBy="affaires")
     * @ORM\JoinColumn(nullable=true)
     */
    private $politicien;

    public function __construct()
    {
        $this->politicien = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection|Politicien[]
     */
    public function getPoliticien(): Collection
    {
        return $this->politicien;
    }

    public function addPoliticien(Politicien $politicien): self
    {
        if (!$this->politicien->contains($politicien)) {
            $this->politicien[] = $politicien;
        }

        return $this;
    }

    public function removePoliticien(Politicien $politicien): self
    {
        if ($this->politicien->contains($politicien)) {
            $this->politicien->removeElement($politicien);
        }

        return $this;
    }

    public function __toString(){
        return $this->getDesignation();
    }

    
}
