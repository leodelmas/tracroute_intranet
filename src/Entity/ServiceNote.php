<?php

namespace App\Entity;

use App\Repository\ServiceNoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceNoteRepository::class)]
class ServiceNote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $object = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'serviceNote', targetEntity: Reception::class, orphanRemoval: true)]
    private Collection $receptions;

    public function __construct()
    {
        $this->receptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, Reception>
     */
    public function getReceptions(): Collection
    {
        return $this->receptions;
    }

    public function addReception(Reception $reception): self
    {
        if (!$this->receptions->contains($reception)) {
            $this->receptions->add($reception);
            $reception->setServiceNote($this);
        }

        return $this;
    }

    public function removeReception(Reception $reception): self
    {
        if ($this->receptions->removeElement($reception)) {
            // set the owning side to null (unless already changed)
            if ($reception->getServiceNote() === $this) {
                $reception->setServiceNote(null);
            }
        }

        return $this;
    }

    /**
     * Check if the given user has validated this service note.
     *
     * @param User $user The user to check for validate.
     * @return bool
     */
    public function isValidatedByUser(User $user): bool
    {
        foreach ($this->receptions as $reception) {
            if ($reception->getUser() === $user) {
                return true;
            }
        }

        return false;
    }
}
