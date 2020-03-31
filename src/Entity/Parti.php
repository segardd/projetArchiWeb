<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartiRepository")
 * @UniqueEntity(fields="nom")
 */
class Parti
{

    private $nbM;

    private $nbF;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Politicien", mappedBy="parti")
     */
    private $politiciens;

    public function __construct()
    {
        $this->politiciens = new ArrayCollection();
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

    /**
     * @return Collection|Politicien[]
     */
    public function getPoliticiens(): Collection
    {
        return $this->politiciens;
    }

    public function addPoliticien(Politicien $politicien): self
    {
        if (!$this->politiciens->contains($politicien)) {
            $this->politiciens[] = $politicien;
            $politicien->setParti($this);
        }

        return $this;
    }

    public function removePoliticien(Politicien $politicien): self
    {
        if ($this->politiciens->contains($politicien)) {
            $this->politiciens->removeElement($politicien);
            // set the owning side to null (unless already changed)
            if ($politicien->getParti() === $this) {
                $politicien->setParti(null);
            }
        }

        return $this;
    }

    public function getParite(){
        $this->nbM=0;
        $this->nbF=0;
        $count=0;
        foreach ($this->politiciens as $politicien) {
            if($politicien->getSexe() == "M"){
                $this->nbM++;
            }

            else{
                $this->nbF++;
            }
            $count++;

            
        }

        if($count==0)
        {
            $count=1;
            $this->nbM=0;
            $this->nbF=0;
        }

        $this->nbM=number_format(($this->nbM/$count)*100,2);
        $this->nbF=number_format(($this->nbF/$count)*100,2);
        return array('M' =>$this->nbM, 'F' => $this->nbF );
    }

    public function __toString(){
        return $this->nom;
    }

    public function getMoyenneAge(){
        $count=0;
        $somme=0;
        foreach ($this->politiciens as $politicien) {
           $somme+= $politicien->getAge();
            $count++;    
        }
        if($count==0)
        {
            $count=1;
        }
        return number_format(($somme/$count),0);
    }
}
