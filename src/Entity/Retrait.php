<?php

namespace App\Entity;

use App\Repository\RetraitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RetraitRepository::class)]
class Retrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $typeRetrait = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeRetrait(): ?string
    {
        return $this->typeRetrait;
    }

    public function setTypeRetrait(string $typeRetrait): static
    {
        $this->typeRetrait = $typeRetrait;

        return $this;
    }
}
