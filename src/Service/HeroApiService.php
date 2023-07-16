<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class HeroApiService
{
    private SerializerInterface $serializer;

    public function __construct(
        private readonly ClientInterface $myClientClient,
        private readonly EntityManagerInterface $entityManager,
        private readonly ObjectNormalizer $normalizer
    ) {
        $this->serializer = new Serializer([new ObjectNormalizer(null, null, null, new ReflectionExtractor())], [new JsonEncoder()]);
    }

    /**
     * @return StreamInterface[]
     */
    public function getHeroes(): array
    {
        $responses = [];
        $requests = function () {
            for ($i = 1; $i <= 83; ++$i) {
                yield function () use ($i) {
                    return $this->myClientClient->requestAsync('GET', 'https://swapi.dev/api/people/'.$i);
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

    public function extractIdFromUrl(string $url): int
    {
        return (int) filter_var($url, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * @template T
     *
     * @param class-string<T> $className
     *
     * @return ?T
     */
    private function getFromApi(string $url, string $className)
    {
        try {
            $apiResponse = $this->myClientClient->request('GET', $url)->getBody();
        } catch (GuzzleException $e) {
            return null;
        }
        $entityId = $this->extractIdFromUrl($url);
        $entity = $this->normalizer->denormalize(json_decode($apiResponse, true), $className, 'json');
        $entity->setId($entityId);

        return $entity;
    }

    /**
     * @template T
     *
     * @param class-string<T> $className
     *
     * @return T
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
