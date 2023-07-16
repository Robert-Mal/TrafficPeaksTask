<?php

namespace App\Entity;

use App\Repository\StarshipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: StarshipRepository::class)]
class Starship
{
    #[ORM\Id]
    #[ORM\GeneratedValue('NONE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    public string $name;

    #[ORM\Column]
    public string $model;

    #[ORM\Column]
    public string $manufacturer;

    #[ORM\Column]
    public string $cost_in_credits;

    #[ORM\Column]
    public string $length;

    #[ORM\Column]
    public string $max_atmosphering_speed;

    #[ORM\Column]
    public string $crew;

    #[ORM\Column]
    public string $passengers;

    #[ORM\Column]
    public string $cargo_capacity;

    #[ORM\Column]
    public string $consumables;

    #[ORM\Column]
    public string $hyperdrive_rating;

    #[ORM\Column]
    #[SerializedName('MGLT')]
    public string $mGLT;

    #[ORM\Column]
    public string $starship_class;

    #[ORM\Column]
    public \DateTime $created;

    #[ORM\Column]
    public \DateTime $edited;

    #[ORM\Column]
    public string $url;

    /**
     * @var Collection<int, Hero>
     */
    #[ORM\ManyToMany(targetEntity: Hero::class, mappedBy: 'starships')]
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

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    public function getCostInCredits(): string
    {
        return $this->cost_in_credits;
    }

    public function setCostInCredits(string $cost_in_credits): void
    {
        $this->cost_in_credits = $cost_in_credits;
    }

    public function getLength(): string
    {
        return $this->length;
    }

    public function setLength(string $length): void
    {
        $this->length = $length;
    }

    public function getMaxAtmospheringSpeed(): string
    {
        return $this->max_atmosphering_speed;
    }

    public function setMaxAtmospheringSpeed(string $max_atmosphering_speed): void
    {
        $this->max_atmosphering_speed = $max_atmosphering_speed;
    }

    public function getCrew(): string
    {
        return $this->crew;
    }

    public function setCrew(string $crew): void
    {
        $this->crew = $crew;
    }

    public function getPassengers(): string
    {
        return $this->passengers;
    }

    public function setPassengers(string $passengers): void
    {
        $this->passengers = $passengers;
    }

    public function getCargoCapacity(): string
    {
        return $this->cargo_capacity;
    }

    public function setCargoCapacity(string $cargo_capacity): void
    {
        $this->cargo_capacity = $cargo_capacity;
    }

    public function getConsumables(): string
    {
        return $this->consumables;
    }

    public function setConsumables(string $consumables): void
    {
        $this->consumables = $consumables;
    }

    public function getHyperdriveRating(): string
    {
        return $this->hyperdrive_rating;
    }

    public function setHyperdriveRating(string $hyperdrive_rating): void
    {
        $this->hyperdrive_rating = $hyperdrive_rating;
    }

    public function getMGLT(): string
    {
        return $this->mGLT;
    }

    public function setMGLT(string $mGLT): void
    {
        $this->mGLT = $mGLT;
    }

    public function getStarshipClass(): string
    {
        return $this->starship_class;
    }

    public function setStarshipClass(string $starship_class): void
    {
        $this->starship_class = $starship_class;
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
            $hero->addStarship($this);
        }

        return $this;
    }

    public function removeHero(Hero $hero): static
    {
        if ($this->heroes->removeElement($hero)) {
            $hero->removeStarship($this);
        }

        return $this;
    }
}
