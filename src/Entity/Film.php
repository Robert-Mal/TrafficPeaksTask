<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: FilmRepository::class)]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue('NONE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 127)]
    public string $title;

    #[ORM\Column(length: 127)]
    public int $episode_id;

    #[ORM\Column(length: 1023)]
    public string $opening_crawl;

    #[ORM\Column(length: 127)]
    public string $director;

    #[ORM\Column(length: 127)]
    public string $producer;

    #[ORM\Column(length: 127)]
    public string $release_date;

    #[ORM\Column]
    public \DateTime $created;

    #[ORM\Column]
    public \DateTime $edited;

    #[ORM\Column(length: 127)]
    public string $url;

    /**
     * @var Collection<int, Hero>
     */
    #[ORM\ManyToMany(targetEntity: Hero::class, mappedBy: 'films')]
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getEpisodeId(): int
    {
        return $this->episode_id;
    }

    public function setEpisodeId(int $episode_id): void
    {
        $this->episode_id = $episode_id;
    }

    public function getOpeningCrawl(): string
    {
        return $this->opening_crawl;
    }

    public function setOpeningCrawl(string $opening_crawl): void
    {
        $this->opening_crawl = $opening_crawl;
    }

    public function getDirector(): string
    {
        return $this->director;
    }

    public function setDirector(string $director): void
    {
        $this->director = $director;
    }

    public function getProducer(): string
    {
        return $this->producer;
    }

    public function setProducer(string $producer): void
    {
        $this->producer = $producer;
    }

    public function getReleaseDate(): string
    {
        return $this->release_date;
    }

    public function setReleaseDate(string $release_date): void
    {
        $this->release_date = $release_date;
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
            $hero->addFilm($this);
        }

        return $this;
    }

    public function removeHero(Hero $hero): static
    {
        if ($this->heroes->removeElement($hero)) {
            $hero->removeFilm($this);
        }

        return $this;
    }
}
