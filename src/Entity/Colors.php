<?php

namespace App\Entity;

use App\Repository\ColorsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColorsRepository::class)]
class Colors
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    /**
     * @var Collection<int, Cupcake>
     */
    #[ORM\ManyToMany(targetEntity: Cupcake::class, inversedBy: 'colors')]
    private Collection $cupcake;

    public function __construct()
    {
        $this->cupcake = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Cupcake>
     */
    public function getCupcake(): Collection
    {
        return $this->cupcake;
    }

    public function addCupcake(Cupcake $cupcake): static
    {
        if (!$this->cupcake->contains($cupcake)) {
            $this->cupcake->add($cupcake);
        }

        return $this;
    }

    public function removeCupcake(Cupcake $cupcake): static
    {
        $this->cupcake->removeElement($cupcake);

        return $this;
    }
}
