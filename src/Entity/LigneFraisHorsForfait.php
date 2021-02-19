<?php

namespace App\Entity;

use App\Repository\LigneFraisHorsForfaitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LigneFraisHorsForfaitRepository::class)
 */
class LigneFraisHorsForfait
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=FicheFrais::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idFicheFrais;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $montant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFicheFrais(): ?FicheFrais
    {
        return $this->idFicheFrais;
    }

    public function setIdFicheFrais(?FicheFrais $idFicheFrais): self
    {
        $this->idFicheFrais = $idFicheFrais;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(?string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }
}
