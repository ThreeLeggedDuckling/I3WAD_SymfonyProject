<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $login = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $password = null;

    /**
     * @var Collection<int, Advert>
     */
    #[ORM\OneToMany(targetEntity: Advert::class, mappedBy: 'author', orphanRemoval: true)]
    private Collection $publishedAdverts;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'author')]
    private Collection $postedComments;

    public function __construct()
    {
        $this->publishedAdverts = new ArrayCollection();
        $this->postedComments = new ArrayCollection();
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

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Advert>
     */
    public function getPublishedAdverts(): Collection
    {
        return $this->publishedAdverts;
    }

    public function addPublishedAdvert(Advert $publishedAdvert): static
    {
        if (!$this->publishedAdverts->contains($publishedAdvert)) {
            $this->publishedAdverts->add($publishedAdvert);
            $publishedAdvert->setAuthor($this);
        }

        return $this;
    }

    public function removePublishedAdvert(Advert $publishedAdvert): static
    {
        if ($this->publishedAdverts->removeElement($publishedAdvert)) {
            // set the owning side to null (unless already changed)
            if ($publishedAdvert->getAuthor() === $this) {
                $publishedAdvert->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getPostedComments(): Collection
    {
        return $this->postedComments;
    }

    public function addPostedComment(Comment $postedComment): static
    {
        if (!$this->postedComments->contains($postedComment)) {
            $this->postedComments->add($postedComment);
            $postedComment->setAuthor($this);
        }

        return $this;
    }

    public function removePostedComment(Comment $postedComment): static
    {
        if ($this->postedComments->removeElement($postedComment)) {
            // set the owning side to null (unless already changed)
            if ($postedComment->getAuthor() === $this) {
                $postedComment->setAuthor(null);
            }
        }

        return $this;
    }
}
