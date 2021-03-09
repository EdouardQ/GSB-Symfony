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
    private $expenseForm;

    /**
     * @ORM\ManyToOne(targetEntity=ExpenseBundle::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $expenseBundle;

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

    public function getExpenseForm(): ?ExpenseForm
    {
        return $this->expenseForm;
    }

    public function setExpenseForm(?ExpenseForm $expenseForm): self
    {
        $this->expenseForm = $expenseForm;

        return $this;
    }

    public function getExpenseBundle(): ?ExpenseBundle
    {
        return $this->expenseBundle;
    }

    public function setExpenseBundle(?ExpenseBundle $expenseBundle): self
    {
        $this->expenseBundle = $expenseBundle;

        return $this;
    }
}
