<?php

namespace App\Entity;

use App\Repository\SpeciesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: SpeciesRepository::class)]
class Species
{
    #[ORM\Id]
    #[ORM\GeneratedValue('NONE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    public string $name;

    #[ORM\Column]
    public string $classification;

    #[ORM\Column]
    public string $designation;

    #[ORM\Column]
    public string $average_height;

    #[ORM\Column]
    public string $skin_colors;

    #[ORM\Column]
    public string $hair_colors;

    #[ORM\Column]
    public string $eye_colors;

    #[ORM\Column]
    public string $average_lifespan;

    #[ORM\Column]
    public string $language;

    #[ORM\Column]
    public \DateTime $created;

    #[ORM\Column]
    public \DateTime $edited;

    #[ORM\Column]
    public string $url;

    /**
     * @var Collection<int, Hero>
     */
    #[ORM\ManyToMany(targetEntity: Hero::class, mappedBy: 'species')]
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

    public function getClassification(): string
    {
        return $this->classification;
    }

    public function setClassification(string $classification): void
    {
        $this->classification = $classification;
    }

    public function getDesignation(): string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): void
    {
        $this->designation = $designation;
    }

    public function getAverageHeight(): string
    {
        return $this->average_height;
    }

    public function setAverageHeight(string $average_height): void
    {
        $this->average_height = $average_height;
    }

    public function getSkinColors(): string
    {
        return $this->skin_colors;
    }

    public function setSkinColors(string $skin_colors): void
    {
        $this->skin_colors = $skin_colors;
    }

    public function getHairColors(): string
    {
        return $this->hair_colors;
    }

    public function setHairColors(string $hair_colors): void
    {
        $this->hair_colors = $hair_colors;
    }

    public function getEyeColors(): string
    {
        return $this->eye_colors;
    }

    public function setEyeColors(string $eye_colors): void
    {
        $this->eye_colors = $eye_colors;
    }

    public function getAverageLifespan(): string
    {
        return $this->average_lifespan;
    }

    public function setAverageLifespan(string $average_lifespan): void
    {
        $this->average_lifespan = $average_lifespan;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
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
            $hero->addSpecies($this);
        }

        return $this;
    }

    public function removeHero(Hero $hero): static
    {
        if ($this->heroes->removeElement($hero)) {
            $hero->removeSpecies($this);
        }

        return $this;
    }
}
