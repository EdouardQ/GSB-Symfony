<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 */
class Report
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Practitioner::class, inversedBy="reports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $practitioner;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reasonVisit;

    /**
     * @ORM\Column(type="text")
     */
    private $summary;

    /**
     * @ORM\OneToMany(targetEntity=SamplesOffer::class, mappedBy="report")
     */
    private $samplesOffers;

    public function __construct()
    {
        $this->samplesOffers = new ArrayCollection();
    }

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

    public function getPractitioner(): ?Practitioner
    {
        return $this->practitioner;
    }

    public function setPractitioner(?Practitioner $practitioner): self
    {
        $this->practitioner = $practitioner;

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

    public function getReasonVisit(): ?string
    {
        return $this->reasonVisit;
    }

    public function setReasonVisit(string $reasonVisit): self
    {
        $this->reasonVisit = $reasonVisit;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * @return Collection|SamplesOffer[]
     */
    public function getSamplesOffers(): Collection
    {
        return $this->samplesOffers;
    }

    public function addSamplesOffer(SamplesOffer $samplesOffer): self
    {
        if (!$this->samplesOffers->contains($samplesOffer)) {
            $this->samplesOffers[] = $samplesOffer;
            $samplesOffer->setReport($this);
        }

        return $this;
    }

    public function removeSamplesOffer(SamplesOffer $samplesOffer): self
    {
        if ($this->samplesOffers->removeElement($samplesOffer)) {
            // set the owning side to null (unless already changed)
            if ($samplesOffer->getReport() === $this) {
                $samplesOffer->setReport(null);
            }
        }

        return $this;
    }
}
