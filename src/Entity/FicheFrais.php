<?php

namespace App\Entity;

use App\Repository\FicheFraisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FicheFraisRepository::class)
 */
class FicheFrais
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idVisiteur;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=6)
     */
    private $mois;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbJustificatifs;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $montantValide;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idEtat;

    public function getIdVisiteur(): ?User
    {
        return $this->idVisiteur;
    }

    public function setIdVisiteur(?User $idVisiteur): self
    {
        $this->idVisiteur = $idVisiteur;

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

    public function setNbJustificatifs(?int $nbJustificatifs): self
    {
        $this->nbJustificatifs = $nbJustificatifs;

        return $this;
    }

    public function getMontantValide(): ?string
    {
        return $this->montantValide;
    }

    public function setMontantValide(?string $montantValide): self
    {
        $this->montantValide = $montantValide;

        return $this;
    }

    public function getDateModif(): ?\DateTimeInterface
    {
        return $this->dateModif;
    }

    public function setDateModif(?\DateTimeInterface $dateModif): self
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    public function getIdEtat(): ?Etat
    {
        return $this->idEtat;
    }

    public function setIdEtat(?Etat $idEtat): self
    {
        $this->idEtat = $idEtat;

        return $this;
    }
}
