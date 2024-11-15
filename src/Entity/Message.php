<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $sendAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'sendMessages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\Column]
    private ?bool $toGroup = null;

    #[ORM\ManyToOne(inversedBy: 'receivedMessages')]
    private ?User $userTarget = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?Group $groupTarget = null;

    public function __construct()
    {
        $this->setSendAt(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSendAt(): ?\DateTimeInterface
    {
        return $this->sendAt;
    }

    public function setSendAt(?\DateTimeInterface $sendAt): static
    {
        $this->sendAt = $sendAt;

        return $this;
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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function isToGroup(): ?bool
    {
        return $this->toGroup;
    }

    public function setToGroup(bool $toGroup): static
    {
        $this->toGroup = $toGroup;

        return $this;
    }

    public function getUserTarget(): ?User
    {
        return $this->userTarget;
    }

    public function setUserTarget(?User $userTarget): static
    {
        $this->userTarget = $userTarget;

        return $this;
    }

    public function getGroupTarget(): ?Group
    {
        return $this->groupTarget;
    }

    public function setGroupTarget(?Group $groupTarget): static
    {
        $this->groupTarget = $groupTarget;

        return $this;
    }

    // récupération target
    public function getTarget(): User|Group
    {
        if($this->isToGroup()) {
            return $this->getGroupTarget();
        }

        return $this->getUserTarget();
    }

    public function setTarget(User|Group $target): static
    {
        if($this->isToGroup()) {
            $this->setGroupTarget($target);
        } else {
            $this->setUserTarget($target);
        }

        return $this;
    }

}