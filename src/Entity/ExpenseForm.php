<?php

namespace App\Entity;

use App\Repository\ExpenseFormRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExpenseFormRepository::class)
 */
class ExpenseForm
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $mois;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbJustificatifs;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2)
     */
    private $montantValide;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateModif;

    /**
     * @ORM\ManyToOne(targetEntity=State::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    public function getId(): ?int
    {
        return $this->id;
    }   

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(string $mois): self
    {
        $this->mois = $mois;

        return $this;
    }

    public function getNbJustificatifs(): ?int
    {
        return $this->nbJustificatifs;
    }

    public function setNbJustificatifs(int $nbJustificatifs): self
    {
        $this->nbJustificatifs = $nbJustificatifs;

        return $this;
    }

    public function getMontantValide(): ?string
    {
        return $this->montantValide;
    }

    public function setMontantValide(string $montantValide): self
    {
        $this->montantValide = $montantValide;

        return $this;
    }

    public function getDateModif(): ?\DateTimeInterface
    {
        return $this->dateModif;
    }

    public function setDateModif(\DateTimeInterface $dateModif): self
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }
}
