<?php

namespace App\Command;

use App\Entity\Film;
use App\Entity\Hero;
use App\Entity\Planet;
use App\Entity\Species;
use App\Entity\Starship;
use App\Entity\Vehicle;
use App\Serializer\Denormalizer\HeroDenormalizer;
use App\Service\HeroApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'api:download',
    description: 'Download heroes and their additional data from api and save it to database',
)]
class ApiDownloadCommand extends Command
{
    private readonly SerializerInterface $serializer;

    public function __construct(
        private readonly NormalizerInterface $heroNormalizer,
        private readonly HeroApiService $heroApiService,
        private readonly EntityManagerInterface $entityManager,
        private readonly HeroDenormalizer $denormalizer
    ) {
        $this->serializer = new Serializer([$heroNormalizer], [new JsonEncoder()]);
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->purgeDatabase();

        $io->note('Tables purged');

        $heroes = $this->heroApiService->getHeroes();
        $progressBar = new ProgressBar($output, count($heroes));
        $progressBar->start();
        foreach ($heroes as $hero) {
            $heroEntity = $this->denormalizer->denormalize($hero, Hero::class, 'json');
            $this->entityManager->persist($heroEntity);
            $this->entityManager->flush();
            $progressBar->advance();
        }
        $progressBar->finish();

        $io->success('Data downloaded');

        return Command::SUCCESS;
    }

    private function purgeDatabase(): void
    {
        $heroes = $this->entityManager->getRepository(Hero::class)->findAll();
        foreach ($heroes as $hero) {
            $this->entityManager->remove($hero);
        }
        $films = $this->entityManager->getRepository(Film::class)->findAll();
        foreach ($films as $film) {
            $this->entityManager->remove($film);
        }
        $planets = $this->entityManager->getRepository(Planet::class)->findAll();
        foreach ($planets as $planet) {
            $this->entityManager->remove($planet);
        }
        $species = $this->entityManager->getRepository(Species::class)->findAll();
        foreach ($species as $s) {
            $this->entityManager->remove($s);
        }
        $starships = $this->entityManager->getRepository(Starship::class)->findAll();
        foreach ($starships as $starship) {
            $this->entityManager->remove($starship);
        }
        $vehicles = $this->entityManager->getRepository(Vehicle::class)->findAll();
        foreach ($vehicles as $vehicle) {
            $this->entityManager->remove($vehicle);
        }

        $this->entityManager->flush();
    }
}
