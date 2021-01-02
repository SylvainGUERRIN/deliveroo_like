<?php

namespace App\Services;

use App\Entity\Biker;
use App\Repository\BikerRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class OpenWeatherService
 * @package App\Services
 */
class OpenWeatherService
{
    protected HttpClientInterface $client;

    protected BikerRepository $bikerRepository;

    public function __construct(HttpClientInterface $client, BikerRepository $bikerRepository)
    {
        $this->client = $client;
        $this->bikerRepository = $bikerRepository;
    }

    /**
     * @param $userID
     * @return string|boolean
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws NonUniqueResultException
     */
    public function getWeather($userID)
    {
        /** @var Biker $biker */
        $biker = $this->bikerRepository->findByUserId($userID);
        //dump($biker);

        //find city with biker
        $city = $biker->getCityWorkWith()->getName();

        if($city !== null){
            $response = $this->client->request(
                'GET',
                'https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&lang=fr&appid=' . $_ENV['OPEN_WEATHER_MAP_KEY']
            );

            if($response->getStatusCode() === 200){
                return $response->getContent(); //put api data here
            }
        }

        return false;
    }
}
