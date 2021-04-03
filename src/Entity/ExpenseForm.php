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
    private $month;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbSupportingDocuments;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2)
     */
    private $validAmount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpdate;

    /**
     * @ORM\ManyToOne(targetEntity=State::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=59)
     */
    private $token;

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

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(string $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getNbSupportingDocuments(): ?int
    {
        return $this->nbSupportingDocuments;
    }

    public function setNbSupportingDocuments(int $nbSupportingDocuments): self
    {
        $this->nbJustifnbSupportingDocumentsicatifs = $nbSupportingDocuments;

        return $this;
    }

    public function getValidAmount(): ?string
    {
        return $this->validAmount;
    }

    public function setValidAmount(string $validAmount): self
    {
        $this->validAmount = $validAmount;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->dateUpdate;
    }

    public function setDateUpdate(\DateTimeInterface $dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;

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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
