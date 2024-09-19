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
     * @var Collection<int, Campain>
     */
    #[ORM\OneToMany(targetEntity: Campain::class, mappedBy: 'playing_group', orphanRemoval: true)]
    private Collection $campains;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'groups')]
    private Collection $members;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'is_admin')]
    private Collection $admins;

    public function __construct()
    {
        $this->campains = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->admins = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->addGroup($this);
        }

        return $this;
    }

    public function removeMember(User $member): static
    {
        if ($this->members->removeElement($member)) {
            $member->removeGroup($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAdmins(): Collection
    {
        return $this->admins;
    }

    public function addAdmin(User $admin): static
    {
        if (!$this->admins->contains($admin)) {
            $this->admins->add($admin);
            $admin->addIsAdmin($this);
        }

        return $this;
    }

    public function removeAdmin(User $admin): static
    {
        if ($this->admins->removeElement($admin)) {
            $admin->removeIsAdmin($this);
        }

        return $this;
    }
}
