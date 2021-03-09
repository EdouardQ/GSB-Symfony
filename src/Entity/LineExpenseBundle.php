<?php

namespace App\Entity;

use App\Repository\LineExpenseBundleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LineExpenseBundleRepository::class)
 */
class LineExpenseBundle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=ExpenseForm::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idExpenseForm;

    /**
     * @ORM\ManyToOne(targetEntity=ExpenseBundle::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idExpenseBundle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getIdExpenseForm(): ?ExpenseForm
    {
        return $this->idExpenseForm;
    }

    public function setIdExpenseForm(?ExpenseForm $idExpenseForm): self
    {
        $this->idExpenseForm = $idExpenseForm;

        return $this;
    }

    public function getIdExpenseBundle(): ?ExpenseBundle
    {
        return $this->idExpenseBundle;
    }

    public function setIdExpenseBundle(?ExpenseBundle $idExpenseBundle): self
    {
        $this->idExpenseBundle = $idExpenseBundle;

        return $this;
    }
}
