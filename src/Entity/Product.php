<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $designation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $stock = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favori')]
    private Collection $users;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'evaluer')]
    private Collection $reviews;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\ManyToMany(targetEntity: Order::class, mappedBy: 'panier')]
    private Collection $orders;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'products')]
    private Collection $tag;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $categoriser = null;

    /**
     * @var Collection<int, Picture>
     */
    #[ORM\ManyToMany(targetEntity: Picture::class, inversedBy: 'products')]
    private Collection $picture;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->tag = new ArrayCollection();
        $this->picture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addFavori($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavori($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setEvaluer($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getEvaluer() === $this) {
                $review->setEvaluer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->addPanier($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            $order->removePanier($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tag->contains($tag)) {
            $this->tag->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tag->removeElement($tag);

        return $this;
    }

    public function getCategoriser(): ?Category
    {
        return $this->categoriser;
    }

    public function setCategoriser(?Category $categoriser): static
    {
        $this->categoriser = $categoriser;

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPicture(): Collection
    {
        return $this->picture;
    }

    public function addPicture(Picture $picture): static
    {
        if (!$this->picture->contains($picture)) {
            $this->picture->add($picture);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        $this->picture->removeElement($picture);

        return $this;
    }
}
