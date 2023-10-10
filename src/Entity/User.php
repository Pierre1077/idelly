<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Patient::class)]
    private Collection $patients;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Meet::class)]
    private Collection $meet;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Messaging::class)]
    private Collection $messagings;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
        $this->meet = new ArrayCollection();
        $this->messagings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Patient>
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): static
    {
        if (!$this->patients->contains($patient)) {
            $this->patients->add($patient);
            $patient->setUser($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): static
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getUser() === $this) {
                $patient->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Meet>
     */
    public function getMeet(): Collection
    {
        return $this->meet;
    }

    public function addMeet(Meet $meet): static
    {
        if (!$this->meet->contains($meet)) {
            $this->meet->add($meet);
            $meet->setUser($this);
        }

        return $this;
    }

    public function removeMeet(Meet $meet): static
    {
        if ($this->meet->removeElement($meet)) {
            // set the owning side to null (unless already changed)
            if ($meet->getUser() === $this) {
                $meet->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Messaging>
     */
    public function getMessagings(): Collection
    {
        return $this->messagings;
    }

    public function addMessaging(Messaging $messaging): static
    {
        if (!$this->messagings->contains($messaging)) {
            $this->messagings->add($messaging);
            $messaging->setUser($this);
        }

        return $this;
    }

    public function removeMessaging(Messaging $messaging): static
    {
        if ($this->messagings->removeElement($messaging)) {
            // set the owning side to null (unless already changed)
            if ($messaging->getUser() === $this) {
                $messaging->setUser(null);
            }
        }

        return $this;
    }
}
