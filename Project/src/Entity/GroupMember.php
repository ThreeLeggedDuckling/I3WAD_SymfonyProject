<?php

namespace App\Entity;

use App\Repository\GroupMemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupMemberRepository::class)]
class GroupMember
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Group $inGroup = null;

    #[ORM\ManyToOne(inversedBy: 'groups')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $isAdmin = null;

    /**
     * @var Collection<int, Campain>
     */
    #[ORM\OneToMany(targetEntity: Campain::class, mappedBy: 'gameMaster')]
    private Collection $masters;

    /**
     * @var Collection<int, File>
     */
    #[ORM\OneToMany(targetEntity: File::class, mappedBy: 'author')]
    private Collection $files;

    public function __construct()
    {
        $this->masters = new ArrayCollection();
        $this->files = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInGroup(): ?Group
    {
        return $this->inGroup;
    }

    public function setInGroup(?Group $inGroup): static
    {
        $this->inGroup = $inGroup;

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

    public function isAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setAdmin(bool $isAdmin): static
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * @return Collection<int, Campain>
     */
    public function getMasters(): Collection
    {
        return $this->masters;
    }

    public function addMaster(Campain $master): static
    {
        if (!$this->masters->contains($master)) {
            $this->masters->add($master);
            $master->setGameMaster($this);
        }

        return $this;
    }

    public function removeMaster(Campain $master): static
    {
        if ($this->masters->removeElement($master)) {
            // set the owning side to null (unless already changed)
            if ($master->getGameMaster() === $this) {
                $master->setGameMaster(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, File>
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): static
    {
        if (!$this->files->contains($file)) {
            $this->files->add($file);
            $file->setAuthor($this);
        }

        return $this;
    }

    public function removeFile(File $file): static
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getAuthor() === $this) {
                $file->setAuthor(null);
            }
        }

        return $this;
    }
}
