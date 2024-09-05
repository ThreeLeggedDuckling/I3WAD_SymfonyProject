<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, GroupMember>
     */
    #[ORM\OneToMany(targetEntity: GroupMember::class, mappedBy: 'inGroup', orphanRemoval: true)]
    private Collection $members;

    /**
     * @var Collection<int, Campain>
     */
    #[ORM\OneToMany(targetEntity: Campain::class, mappedBy: 'playing_group', orphanRemoval: true)]
    private Collection $campains;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->campains = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, GroupMember>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(GroupMember $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->setInGroup($this);
        }

        return $this;
    }

    public function removeMember(GroupMember $member): static
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getInGroup() === $this) {
                $member->setInGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Campain>
     */
    public function getCampains(): Collection
    {
        return $this->campains;
    }

    public function addCampain(Campain $campain): static
    {
        if (!$this->campains->contains($campain)) {
            $this->campains->add($campain);
            $campain->setPlayingGroup($this);
        }

        return $this;
    }

    public function removeCampain(Campain $campain): static
    {
        if ($this->campains->removeElement($campain)) {
            // set the owning side to null (unless already changed)
            if ($campain->getPlayingGroup() === $this) {
                $campain->setPlayingGroup(null);
            }
        }

        return $this;
    }
}
