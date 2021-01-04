<?php

namespace App\Controller\Biker;

use App\Repository\BikerRepository;
use App\Services\OpenWeatherService;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class BikerAccountController
{
    private $twig;
    private $form;
    private $request;
    private $doctrine;
    private $security;
    private $session;
    private $bikerRepository;

    /**
     * BikerController constructor.
     * @param Environment $twig
     * @param FormFactoryInterface $form
     * @param RequestStack $request
     * @param ManagerRegistry $registry
     * @param Security $security
     * @param SessionInterface $session
     * @param BikerRepository $bikerRepository
     */
    public function __construct(
        Environment $twig,
        FormFactoryInterface $form,
        RequestStack $request,
        ManagerRegistry $registry,
        Security $security,
        SessionInterface $session,
        BikerRepository $bikerRepository
    )
    {
        $this->twig = $twig;
        $this->form = $form;
        $this->request = $request;
        $this->doctrine = $registry;
        $this->security = $security;
        $this->session = $session;
        $this->bikerRepository = $bikerRepository;
    }

    /**
     * @Route("/biker/dashboard", name="biker_dashboard")
     * @param OpenWeatherService $openWeatherService
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws NonUniqueResultException|DecodingExceptionInterface
     */
    public function dashboard(OpenWeatherService $openWeatherService): Response
    {
        $userID = $this->security->getUser()->getId();
        $getWeather = $openWeatherService->getBikerTime($userID, 'oneDay');
        dump($getWeather);
        return new Response($this->twig->render('biker/dashboard.html.twig', [
            'weather' => $getWeather
        ]));
    }

    /**
     * @Route ("biker/weather", name="biker_weather")
     * @param OpenWeatherService $openWeatherService
     * @return Response
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws LoaderError
     * @throws NonUniqueResultException
     * @throws RedirectionExceptionInterface
     * @throws RuntimeError
     * @throws ServerExceptionInterface
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     */
    public function weatherFourWeeks(OpenWeatherService $openWeatherService): Response
    {
        $userID = $this->security->getUser()->getId();
        $biker = $this->bikerRepository->findByUserId($userID);
        $getWeather = $openWeatherService->getBikerTime($userID, 'manyDay');
        dump($getWeather);
        return new Response($this->twig->render('biker/weather.html.twig', [
            'biker' => $biker,
            'weather' => $getWeather
        ]));
    }
}
