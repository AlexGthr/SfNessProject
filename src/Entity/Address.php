<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $zipCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\ManyToOne(inversedBy: 'address')]
    private ?User $users = null;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'userAdress')]
    private Collection $livrer;

    public function __construct()
    {
        $this->livrer = new ArrayCollection();
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): static
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getLivrer(): Collection
    {
        return $this->livrer;
    }

    public function addLivrer(Order $livrer): static
    {
        if (!$this->livrer->contains($livrer)) {
            $this->livrer->add($livrer);
            $livrer->setUserAdress($this);
        }

        return $this;
    }

    public function removeLivrer(Order $livrer): static
    {
        if ($this->livrer->removeElement($livrer)) {
            // set the owning side to null (unless already changed)
            if ($livrer->getUserAdress() === $this) {
                $livrer->setUserAdress(null);
            }
        }

        return $this;
    }

}
