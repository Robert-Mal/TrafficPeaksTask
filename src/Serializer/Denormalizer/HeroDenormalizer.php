<?php

namespace App\Serializer\Denormalizer;

use App\Entity\Film;
use App\Entity\Hero;
use App\Entity\Planet;
use App\Entity\Species;
use App\Entity\Starship;
use App\Entity\Vehicle;
use App\Service\HeroApiService;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @method getSupportedTypes(?string $format)
 */
class HeroDenormalizer implements DenormalizerInterface
{
    public function __construct(
        private readonly ObjectNormalizer $normalizer,
        private readonly HeroApiService $heroApiService
    ) {
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Hero
    {
        $heroDecoded = json_decode($data, true);
        $heroId = $this->heroApiService->extractIdFromUrl($heroDecoded['url']);
        $heroAdditionalData = [
            'homeworldUrl' => $heroDecoded['homeworld'],
            'filmUrls' => $heroDecoded['films'],
            'speciesUrls' => $heroDecoded['species'],
            'vehicleUrls' => $heroDecoded['vehicles'],
            'starshipUrls' => $heroDecoded['starships'],
        ];
        unset(
            $heroDecoded['homeworld'],
            $heroDecoded['films'],
            $heroDecoded['species'],
            $heroDecoded['vehicles'],
            $heroDecoded['starships']
        );
        /** @var Hero $hero */
        $hero = $this->normalizer->denormalize($heroDecoded, $type, $format, $context);
        $hero->setId($heroId);
        $homeworld = $this->heroApiService->getEntity($heroAdditionalData['homeworldUrl'], Planet::class);
        $hero->setHomeworld($homeworld);
        foreach ($heroAdditionalData['filmUrls'] as $filmUrl) {
            $film = $this->heroApiService->getEntity($filmUrl, Film::class);
            $hero->addFilm($film);
        }
        foreach ($heroAdditionalData['speciesUrls'] as $speciesUrl) {
            $species = $this->heroApiService->getEntity($speciesUrl, Species::class);
            $hero->addSpecies($species);
        }
        foreach ($heroAdditionalData['vehicleUrls'] as $vehicleUrl) {
            $vehicle = $this->heroApiService->getEntity($vehicleUrl, Vehicle::class);
            $hero->addVehicle($vehicle);
        }
        foreach ($heroAdditionalData['starshipUrls'] as $starshipUrl) {
            $starship = $this->heroApiService->getEntity($starshipUrl, Starship::class);
            $hero->addStarship($starship);
        }

        return $hero;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return Hero::class === $type;
    }
}