<?php

namespace App\Entity;

use App\Repository\HeroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeroRepository::class)]
class Hero
{
    #[ORM\Id]
    #[ORM\GeneratedValue('NONE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private string $height;

    #[ORM\Column]
    private string $mass;

    #[ORM\Column]
    private string $hair_color;

    #[ORM\Column]
    private string $skin_color;

    #[ORM\Column]
    private string $eye_color;

    #[ORM\Column]
    private string $birth_year;

    #[ORM\Column]
    private string $gender;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'heroes')]
    private ?Planet $homeworld = null;

    /**
     * @var Collection<int, Film>
     */
    #[ORM\ManyToMany(targetEntity: Film::class, inversedBy: 'heroes', cascade: ['persist'])]
    private Collection $films;

    /**
     * @var Collection<int, Species>
     */
    #[ORM\ManyToMany(targetEntity: Species::class, inversedBy: 'heroes', cascade: ['persist'])]
    private Collection $species;

    /**
     * @var Collection<int, Vehicle>
     */
    #[ORM\ManyToMany(targetEntity: Vehicle::class, inversedBy: 'heroes', cascade: ['persist'])]
    private Collection $vehicles;

    /**
     * @var Collection<int, Starship>
     */
    #[ORM\ManyToMany(targetEntity: Starship::class, inversedBy: 'heroes', cascade: ['persist'])]
    private Collection $starships;

    #[ORM\Column]
    private \DateTime $created;

    #[ORM\Column]
    private \DateTime $edited;

    #[ORM\Column]
    private string $url;

    public function __construct()
    {
        $this->films = new ArrayCollection();
        $this->species = new ArrayCollection();
        $this->vehicles = new ArrayCollection();
        $this->starships = new ArrayCollection();
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

    public function getHeight(): string
    {
        return $this->height;
    }

    public function setHeight(string $height): void
    {
        $this->height = $height;
    }

    public function getMass(): string
    {
        return $this->mass;
    }

    public function setMass(string $mass): void
    {
        $this->mass = $mass;
    }

    public function getHairColor(): string
    {
        return $this->hair_color;
    }

    public function setHairColor(string $hair_color): void
    {
        $this->hair_color = $hair_color;
    }

    public function getSkinColor(): string
    {
        return $this->skin_color;
    }

    public function setSkinColor(string $skin_color): void
    {
        $this->skin_color = $skin_color;
    }

    public function getEyeColor(): string
    {
        return $this->eye_color;
    }

    public function setEyeColor(string $eye_color): void
    {
        $this->eye_color = $eye_color;
    }

    public function getBirthYear(): string
    {
        return $this->birth_year;
    }

    public function setBirthYear(string $birth_year): void
    {
        $this->birth_year = $birth_year;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function getHomeworld(): ?Planet
    {
        return $this->homeworld;
    }

    public function setHomeworld(?Planet $homeworld): static
    {
        $this->homeworld = $homeworld;

        return $this;
    }

    /**
     * @return Collection<int, Film>
     */
    public function getFilms(): Collection
    {
        return $this->films;
    }

    public function addFilm(Film $film): static
    {
        if (!$this->films->contains($film)) {
            $this->films->add($film);
        }

        return $this;
    }

    public function removeFilm(Film $film): static
    {
        $this->films->removeElement($film);

        return $this;
    }

    /**
     * @return Collection<int, Species>
     */
    public function getSpecies(): Collection
    {
        return $this->species;
    }

    public function addSpecies(Species $species): static
    {
        if (!$this->species->contains($species)) {
            $this->species->add($species);
        }

        return $this;
    }

    public function removeSpecies(Species $species): static
    {
        $this->species->removeElement($species);

        return $this;
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        $this->vehicles->removeElement($vehicle);

        return $this;
    }

    /**
     * @return Collection<int, Starship>
     */
    public function getStarships(): Collection
    {
        return $this->starships;
    }

    public function addStarship(Starship $starship): static
    {
        if (!$this->starships->contains($starship)) {
            $this->starships->add($starship);
        }

        return $this;
    }

    public function removeStarship(Starship $starship): static
    {
        $this->starships->removeElement($starship);

        return $this;
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
}
