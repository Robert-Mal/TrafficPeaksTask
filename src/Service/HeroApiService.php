<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class HeroApiService
{
    /**
     * @var string HERO_API_URL
     */
    private const HERO_API_URL = 'https://swapi.dev/api/people/';
    /**
     * @var int FIRST_HERO_NUMBER
     */
    private const FIRST_HERO_NUMBER = 1;
    /**
     * @var int LAST_HERO_NUMBER
     */
    private const LAST_HERO_NUMBER = 83;

    /**
     * @param ClientInterface $myClientClient
     * @param EntityManagerInterface $entityManager
     * @param ObjectNormalizer $normalizer
     */
    public function __construct(
        private readonly ClientInterface $myClientClient,
        private readonly EntityManagerInterface $entityManager,
        private readonly ObjectNormalizer $normalizer
    ) {
    }

    /**
     * @return StreamInterface[]
     */
    public function getHeroes(): array
    {
        $responses = [];
        $requests = function () {
            for ($i = self::FIRST_HERO_NUMBER; $i <= self::LAST_HERO_NUMBER; ++$i) {
                yield function () use ($i) {
                    return $this->myClientClient->requestAsync('GET', self::HERO_API_URL.$i);
                };
            }
        };
        $pool = new Pool($this->myClientClient, $requests(), [
            'concurrency' => 10,
            'fulfilled' => function (Response $response) use (&$responses) {
                $responses[] = $response->getBody();
            },
        ]);
        $pool->promise()->wait();

        return $responses;
    }

    /**
     * @param string $url
     * @return int
     */
    public function extractIdFromUrl(string $url): int
    {
        return (int) filter_var($url, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $className
     *
     * @return ?T
     */
    private function getFromApi(string $url, string $className)
    {
        try {
            $apiResponse = $this->myClientClient->request('GET', $url)->getBody();
        } catch (GuzzleException) {
            return null;
        }
        $entityId = $this->extractIdFromUrl($url);
        $entity = $this->normalizer->denormalize(json_decode($apiResponse, true), $className, 'json');
        $entity->setId($entityId);

        return $entity;
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $className
     *
     * @return ?T
     */
    public function getEntity(string $url, string $className)
    {
        $entityRepository = $this->entityManager->getRepository($className);
        $entityId = $this->extractIdFromUrl($url);
        $entity = $entityRepository->find($entityId);
        if (!$entity) {
            return $this->getFromApi($url, $className);
        }

        return $entity;
    }
}
