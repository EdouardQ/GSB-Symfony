<?php

namespace App\Entity;

use App\Repository\MedicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedicationRepository::class)
 */
class Medication
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $family;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $composition;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $sideEffects;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contraindications;

    /**
     * @ORM\OneToMany(targetEntity=SamplesOffer::class, mappedBy="medication")
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getComposition(): ?string
    {
        return $this->composition;
    }

    public function setComposition(string $composition): self
    {
        $this->composition = $composition;

        return $this;
    }

    public function getSideEffects(): ?string
    {
        return $this->sideEffects;
    }

    public function setSideEffects(?string $sideEffects): self
    {
        $this->sideEffects = $sideEffects;

        return $this;
    }

    public function getContraindications(): ?string
    {
        return $this->contraindications;
    }

    public function setContraindications(?string $contraindications): self
    {
        $this->contraindications = $contraindications;

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
            $samplesOffer->setMedication($this);
        }

        return $this;
    }

    public function removeSamplesOffer(SamplesOffer $samplesOffer): self
    {
        if ($this->samplesOffers->removeElement($samplesOffer)) {
            // set the owning side to null (unless already changed)
            if ($samplesOffer->getMedication() === $this) {
                $samplesOffer->setMedication(null);
            }
        }

        return $this;
    }
}
