<?php

namespace App\Entity;

use App\Repository\NewsletterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterRepository::class)]
class Newsletter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    /**
     * @var Collection<int, Abonne>
     */
    #[ORM\ManyToMany(targetEntity: Abonne::class, mappedBy: 'inscription')]
    private Collection $abonnes;

    public function __construct()
    {
        $this->abonnes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, Abonne>
     */
    public function getAbonnes(): Collection
    {
        return $this->abonnes;
    }

    public function addAbonne(Abonne $abonne): static
    {
        if (!$this->abonnes->contains($abonne)) {
            $this->abonnes->add($abonne);
            $abonne->addInscription($this);
        }

        return $this;
    }

    public function removeAbonne(Abonne $abonne): static
    {
        if ($this->abonnes->removeElement($abonne)) {
            $abonne->removeInscription($this);
        }

        return $this;
    }
}
