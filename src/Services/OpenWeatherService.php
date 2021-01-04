<?php

namespace App\Services;

use App\Entity\Biker;
use App\Repository\BikerRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

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
     * @param $city
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getWeatherOfDay($city): ResponseInterface
    {
        return $this->client->request(
            'GET',
            'https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&units=metric&lang=fr&appid=' . $_ENV['OPEN_WEATHER_MAP_KEY']
        );
    }

    /**
     * @param $city
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getWeatherOfWeek($city): ResponseInterface
    {
        // i need lat and lon because i have free account in open weather
        //i use open cage data api to get lat and lon

        $coordinatesResponse = $this->client->request(
            'GET',
            'https://api.opencagedata.com/geocode/v1/json?q=' . $city . '&key=' . $_ENV['OPEN_CAGE_DATA']
        );
        $coordinates = $coordinatesResponse->toArray();
//        dd($coordinates);

        $lat = $coordinates['results'][0]['geometry']['lat'];
        $lon = $coordinates['results'][0]['geometry']['lng'];

        return $this->client->request(
            'GET',
            'https://api.openweathermap.org/data/2.5/onecall?lat=' . $lat . '&lon=' . $lon . '&units=metric&lang=fr&appid=' . $_ENV['OPEN_WEATHER_MAP_KEY']
//            'https://api.openweathermap.org/data/2.5/forecast/daily?q=' . $city . '&units=metric&lang=fr&cnt=7&appid=' . $_ENV['OPEN_WEATHER_MAP_KEY']
        );
    }

    /**
     * @param $userID
     * @param $period
     * @return array|false
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws NonUniqueResultException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getBikerTime($userID, $period)
    {
        /** @var Biker $biker */
        $biker = $this->bikerRepository->findByUserId($userID);
        //dump($biker);

        //find city with biker
        $city = $biker->getCityWorkWith()->getName();

        if($city !== null){
            if($period === 'oneDay'){
                $response = $this->getWeatherOfDay($city);
            }else{
                $response = $this->getWeatherOfWeek($city);
            }

            if($response->getStatusCode() === 200){
                return $response->toArray();
//                return $response->getContent(); //put api data here
            }

            return false;
        }

        return false;
    }
}
