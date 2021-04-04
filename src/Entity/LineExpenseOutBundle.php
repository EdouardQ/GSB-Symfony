<?php

namespace App\Entity;

use App\Repository\LineExpenseOutBundleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=LineExpenseOutBundleRepository::class)
 */
class LineExpenseOutBundle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $wording;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="decimal", precision=9, scale=2)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=ExpenseForm::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $expenseForm;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $supportingDocument;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWording(): ?string
    {
        return $this->wording;
    }

    public function setWording(?string $wording): self
    {
        $this->wording = $wording;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

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

    public function getSupportingDocument(): null|string|UploadedFile
    {
        return $this->supportingDocument;
    }

    public function setSupportingDocument(null|string|UploadedFile $supportingDocument): self
    {
        $this->supportingDocument = $supportingDocument;

        return $this;
    }

    public function getValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }
}
