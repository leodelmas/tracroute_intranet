<?php

namespace App\Entity;

use App\Repository\PlannedSlotCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlannedSlotCategoryRepository::class)]
class PlannedSlotCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\OneToMany(mappedBy: 'plannedSlotCategory', targetEntity: PlannedSlot::class, orphanRemoval: true)]
    private Collection $plannedSlots;

    public function __construct()
    {
        $this->plannedSlots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, PlannedSlot>
     */
    public function getPlannedSlots(): Collection
    {
        return $this->plannedSlots;
    }

    public function addPlannedSlot(PlannedSlot $plannedSlot): self
    {
        if (!$this->plannedSlots->contains($plannedSlot)) {
            $this->plannedSlots->add($plannedSlot);
            $plannedSlot->setPlannedSlotCategory($this);
        }

        return $this;
    }

    public function removePlannedSlot(PlannedSlot $plannedSlot): self
    {
        if ($this->plannedSlots->removeElement($plannedSlot)) {
            // set the owning side to null (unless already changed)
            if ($plannedSlot->getPlannedSlotCategory() === $this) {
                $plannedSlot->setPlannedSlotCategory(null);
            }
        }

        return $this;
    }
}
