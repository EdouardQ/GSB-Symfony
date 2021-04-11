<?php

namespace App\Entity;

use App\Repository\SamplesOfferRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SamplesOfferRepository::class)
 */
class SamplesOffer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Report::class, inversedBy="samplesOffers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $report;

    /**
     * @ORM\ManyToOne(targetEntity=Medication::class, inversedBy="samplesOffers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $medication;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReport(): ?Report
    {
        return $this->report;
    }

    public function setReport(?Report $report): self
    {
        $this->report = $report;

        return $this;
    }

    public function getMedication(): ?Medication
    {
        return $this->medication;
    }

    public function setMedication(?Medication $medication): self
    {
        $this->medication = $medication;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
