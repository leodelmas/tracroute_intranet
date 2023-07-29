<?php

namespace App\Entity;

use App\Repository\ReceptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReceptionRepository::class)]
class Reception
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'receptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ServiceNote $serviceNote = null;

    #[ORM\ManyToOne(inversedBy: 'receptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceNote(): ?ServiceNote
    {
        return $this->serviceNote;
    }

    public function setServiceNote(?ServiceNote $serviceNote): self
    {
        $this->serviceNote = $serviceNote;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
