<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $scheduled = null;

    #[ORM\Column(nullable: true)]
    private ?int $runTime = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campaign $campaign = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScheduled(): ?\DateTimeInterface
    {
        return $this->scheduled;
    }

    public function setScheduled(\DateTimeInterface $scheduled): static
    {
        $this->scheduled = $scheduled;

        return $this;
    }

    public function getRunTime(): ?int
    {
        return $this->runTime;
    }

    public function setRunTime(?int $runTime): static
    {
        $this->runTime = $runTime;

        return $this;
    }

    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?Campaign $campaign): static
    {
        $this->campaign = $campaign;

        return $this;
    }
}
