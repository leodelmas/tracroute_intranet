<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: HolidaysPeriod::class, orphanRemoval: true)]
    private Collection $holidaysPeriods;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PlannedSlot::class, orphanRemoval: true)]
    private Collection $plannedSlots;

    public function __construct()
    {
        $this->holidaysPeriods = new ArrayCollection();
        $this->plannedSlots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, HolidaysPeriod>
     */
    public function getHolidaysPeriods(): Collection
    {
        return $this->holidaysPeriods;
    }

    public function addHolidaysPeriod(HolidaysPeriod $holidaysPeriod): self
    {
        if (!$this->holidaysPeriods->contains($holidaysPeriod)) {
            $this->holidaysPeriods->add($holidaysPeriod);
            $holidaysPeriod->setUser($this);
        }

        return $this;
    }

    public function removeHolidaysPeriod(HolidaysPeriod $holidaysPeriod): self
    {
        if ($this->holidaysPeriods->removeElement($holidaysPeriod)) {
            // set the owning side to null (unless already changed)
            if ($holidaysPeriod->getUser() === $this) {
                $holidaysPeriod->setUser(null);
            }
        }

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
            $plannedSlot->setUser($this);
        }

        return $this;
    }

    public function removePlannedSlot(PlannedSlot $plannedSlot): self
    {
        if ($this->plannedSlots->removeElement($plannedSlot)) {
            // set the owning side to null (unless already changed)
            if ($plannedSlot->getUser() === $this) {
                $plannedSlot->setUser(null);
            }
        }

        return $this;
    }
}
