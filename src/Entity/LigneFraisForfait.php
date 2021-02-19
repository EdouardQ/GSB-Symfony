<?php

namespace App\Entity;

use App\Repository\LigneFraisForfaitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LigneFraisForfaitRepository::class)
 */
class LigneFraisForfait
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
     * @ORM\ManyToOne(targetEntity=FraisForfait::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idFraisForfait;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantite;

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

    public function getIdFraisForfait(): ?FraisForfait
    {
        return $this->idFraisForfait;
    }

    public function setIdFraisForfait(?FraisForfait $idFraisForfait): self
    {
        $this->idFraisForfait = $idFraisForfait;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
