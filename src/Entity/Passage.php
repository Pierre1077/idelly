<?php

namespace App\Entity;

use App\Repository\PassageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PassageRepository::class)]
class Passage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hour = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePassage = null;

    #[ORM\Column]
    private ?bool $etatPassage = null;

    #[ORM\ManyToOne(inversedBy: 'passages')]
    private ?Meet $meet = null;

    public function __construct()
    {
        $this->etatPassage = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHour(): ?\DateTimeInterface
    {
        return $this->hour;
    }

    public function setHour(\DateTimeInterface $hour): static
    {
        $this->hour = $hour;

        return $this;
    }

    public function getDatePassage(): ?\DateTimeInterface
    {
        return $this->datePassage;
    }

    public function setDatePassage(\DateTimeInterface $datePassage): static
    {
        $this->datePassage = $datePassage;

        return $this;
    }

    public function isEtatPassage(): ?bool
    {
        return $this->etatPassage;
    }

    public function setEtatPassage(bool $etatPassage): static
    {
        $this->etatPassage = $etatPassage;

        return $this;
    }

    public function getMeet(): ?Meet
    {
        return $this->meet;
    }

    public function setMeet(?Meet $meet): static
    {
        $this->meet = $meet;

        return $this;
    }
}
