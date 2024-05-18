<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    /**
     * @var Collection<int, Faq>
     */
    #[ORM\OneToMany(targetEntity: Faq::class, mappedBy: 'theme')]
    private Collection $theme;

    public function __construct()
    {
        $this->theme = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Faq>
     */
    public function getTheme(): Collection
    {
        return $this->theme;
    }

    public function __toString() 
    {
        return $this->name;
    }

    public function addTheme(Faq $theme): static
    {
        if (!$this->theme->contains($theme)) {
            $this->theme->add($theme);
            $theme->setTheme($this);
        }

        return $this;
    }

    public function removeTheme(Faq $theme): static
    {
        if ($this->theme->removeElement($theme)) {
            // set the owning side to null (unless already changed)
            if ($theme->getTheme() === $this) {
                $theme->setTheme(null);
            }
        }

        return $this;
    }
}
