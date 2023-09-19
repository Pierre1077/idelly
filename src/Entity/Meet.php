<?php

namespace App\Entity;

use App\Repository\MeetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeetRepository::class)]
class Meet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $infoComplementaire = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $typeSoin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255)]
    private ?string $typePassage = null;

    #[ORM\ManyToOne(inversedBy: 'meets')]
    private ?Patient $patient = null;

    #[ORM\ManyToOne(inversedBy: 'meet')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'meet', targetEntity: Passage::class)]
    private Collection $passages;

    public function __construct()
    {
        $this->passages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInfoComplementaire(): ?string
    {
        return $this->infoComplementaire;
    }

    public function setInfoComplementaire(?string $infoComplementaire): static
    {
        $this->infoComplementaire = $infoComplementaire;

        return $this;
    }

    public function getTypeSoin(): ?string
    {
        return $this->typeSoin;
    }

    public function setTypeSoin(string $typeSoin): static
    {
        $this->typeSoin = $typeSoin;

        return $this;
    }

    public function getDateDebut(): ?string
    {
        return $this->dateDebut;
    }

    public function setDateDebut(string $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getTypePassage(): ?string
    {
        return $this->typePassage;
    }

    public function setTypePassage(string $typePassage): static
    {
        $this->typePassage = $typePassage;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Passage>
     */
    public function getPassages(): Collection
    {
        return $this->passages;
    }

    public function addPassage(Passage $passage): static
    {
        if (!$this->passages->contains($passage)) {
            $this->passages->add($passage);
            $passage->setMeet($this);
        }

        return $this;
    }

    public function removePassage(Passage $passage): static
    {
        if ($this->passages->removeElement($passage)) {
            // set the owning side to null (unless already changed)
            if ($passage->getMeet() === $this) {
                $passage->setMeet(null);
            }
        }

        return $this;
    }
}
