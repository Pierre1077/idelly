<?php

namespace App\Entity;

use App\Repository\MessagingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagingRepository::class)]
class Messaging
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateContent = null;

    #[ORM\ManyToOne(inversedBy: 'messagings')]
    private ?user $auteur = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?GroupChat $groupChat = null;

    public function __construct()
    {
        $this->groupChats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getDateContent(): ?\DateTimeInterface
    {
        return $this->dateContent;
    }

    public function setDateContent(\DateTimeInterface $dateContent): static
    {
        $this->dateContent = $dateContent;

        return $this;
    }

    public function getAuteur(): ?user
    {
        return $this->auteur;
    }

    public function setAuteur(?user $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getGroupChat(): ?GroupChat
    {
        return $this->groupChat;
    }

    public function setGroupChat(?GroupChat $groupChat): static
    {
        $this->groupChat = $groupChat;

        return $this;
    }
}
