<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $adress = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(length: 255)]
    private ?string $numSecu = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(type: Types::TEXT,  nullable: true)]
    private ?string $infoSupAdress = null;

    #[ORM\Column(length: 255)]
    private ?string $fullNameMedecinTraitant = null;

    #[ORM\Column(length: 255)]
    private ?string $PhoneMedecinTraitant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PharmacieName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PhonePharmacie = null;

    #[ORM\Column(length: 255)]
    private ?string $fullNameUrgentContact = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneUrgentContact = null;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Meet::class)]
    private Collection $meets;

    #[ORM\ManyToOne(inversedBy: 'patients')]
    private ?User $user = null;

    public function __construct()
    {
        $this->meets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getNumSecu(): ?string
    {
        return $this->numSecu;
    }

    public function setNumSecu(string $numSecu): static
    {
        $this->numSecu = $numSecu;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getInfoSupAdress(): ?string
    {
        return $this->infoSupAdress;
    }

    public function setInfoSupAdress(string $infoSupAdress): static
    {
        $this->infoSupAdress = $infoSupAdress;

        return $this;
    }

    public function getFullNameMedecinTraitant(): ?string
    {
        return $this->fullNameMedecinTraitant;
    }

    public function setFullNameMedecinTraitant(string $fullNameMedecinTraitant): static
    {
        $this->fullNameMedecinTraitant = $fullNameMedecinTraitant;

        return $this;
    }

    public function getPhoneMedecinTraitant(): ?string
    {
        return $this->PhoneMedecinTraitant;
    }

    public function setPhoneMedecinTraitant(string $PhoneMedecinTraitant): static
    {
        $this->PhoneMedecinTraitant = $PhoneMedecinTraitant;

        return $this;
    }

    public function getPharmacieName(): ?string
    {
        return $this->PharmacieName;
    }

    public function setPharmacieName(?string $PharmacieName): static
    {
        $this->PharmacieName = $PharmacieName;

        return $this;
    }

    public function getPhonePharmacie(): ?string
    {
        return $this->PhonePharmacie;
    }

    public function setPhonePharmacie(?string $PhonePharmacie): static
    {
        $this->PhonePharmacie = $PhonePharmacie;

        return $this;
    }

    public function getFullNameUrgentContact(): ?string
    {
        return $this->fullNameUrgentContact;
    }

    public function setFullNameUrgentContact(string $fullNameUrgentContact): static
    {
        $this->fullNameUrgentContact = $fullNameUrgentContact;

        return $this;
    }

    public function getPhoneUrgentContact(): ?string
    {
        return $this->phoneUrgentContact;
    }

    public function setPhoneUrgentContact(string $phoneUrgentContact): static
    {
        $this->phoneUrgentContact = $phoneUrgentContact;

        return $this;
    }

    /**
     * @return Collection<int, Meet>
     */
    public function getMeets(): Collection
    {
        return $this->meets;
    }

    public function addMeet(Meet $meet): static
    {
        if (!$this->meets->contains($meet)) {
            $this->meets->add($meet);
            $meet->setPatient($this);
        }

        return $this;
    }

    public function removeMeet(Meet $meet): static
    {
        if ($this->meets->removeElement($meet)) {
            // set the owning side to null (unless already changed)
            if ($meet->getPatient() === $this) {
                $meet->setPatient(null);
            }
        }

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
}
