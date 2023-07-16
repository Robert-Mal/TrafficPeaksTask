<?php

namespace App\Entity;

use App\Repository\PlanetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: PlanetRepository::class)]
class Planet
{
    #[ORM\Id]
    #[ORM\GeneratedValue('NONE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    public string $name;

    #[ORM\Column]
    public string $rotation_period;

    #[ORM\Column]
    public string $orbital_period;

    #[ORM\Column]
    public string $diameter;

    #[ORM\Column]
    public string $climate;

    #[ORM\Column]
    public string $gravity;

    #[ORM\Column]
    public string $terrain;

    #[ORM\Column]
    public string $surface_water;

    #[ORM\Column]
    public string $population;

    #[ORM\Column]
    public \DateTime $created;

    #[ORM\Column]
    public \DateTime $edited;

    #[ORM\Column]
    public string $url;

    /**
     * @var Collection<int, Hero>
     */
    #[ORM\OneToMany(mappedBy: 'homeworld', targetEntity: Hero::class)]
    #[Ignore]
    private Collection $heroes;

    public function __construct()
    {
        $this->heroes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getRotationPeriod(): string
    {
        return $this->rotation_period;
    }

    public function setRotationPeriod(string $rotation_period): void
    {
        $this->rotation_period = $rotation_period;
    }

    public function getOrbitalPeriod(): string
    {
        return $this->orbital_period;
    }

    public function setOrbitalPeriod(string $orbital_period): void
    {
        $this->orbital_period = $orbital_period;
    }

    public function getDiameter(): string
    {
        return $this->diameter;
    }

    public function setDiameter(string $diameter): void
    {
        $this->diameter = $diameter;
    }

    public function getClimate(): string
    {
        return $this->climate;
    }

    public function setClimate(string $climate): void
    {
        $this->climate = $climate;
    }

    public function getGravity(): string
    {
        return $this->gravity;
    }

    public function setGravity(string $gravity): void
    {
        $this->gravity = $gravity;
    }

    public function getTerrain(): string
    {
        return $this->terrain;
    }

    public function setTerrain(string $terrain): void
    {
        $this->terrain = $terrain;
    }

    public function getSurfaceWater(): string
    {
        return $this->surface_water;
    }

    public function setSurfaceWater(string $surface_water): void
    {
        $this->surface_water = $surface_water;
    }

    public function getPopulation(): string
    {
        return $this->population;
    }

    public function setPopulation(string $population): void
    {
        $this->population = $population;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function setCreated(\DateTime $created): void
    {
        $this->created = $created;
    }

    public function getEdited(): \DateTime
    {
        return $this->edited;
    }

    public function setEdited(\DateTime $edited): void
    {
        $this->edited = $edited;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return Collection<int, Hero>
     */
    public function getHeroes(): Collection
    {
        return $this->heroes;
    }

    public function addHero(Hero $hero): static
    {
        if (!$this->heroes->contains($hero)) {
            $this->heroes->add($hero);
            $hero->setHomeworld($this);
        }

        return $this;
    }

    public function removeHero(Hero $hero): static
    {
        if ($this->heroes->removeElement($hero)) {
            // set the owning side to null (unless already changed)
            if ($hero->getHomeworld() === $this) {
                $hero->setHomeworld(null);
            }
        }

        return $this;
    }
}
