<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Repository\RestaurantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class RestaurantsController
{
    private $twig;
    private $form;
    private $request;
    private $doctrine;
    private $security;
    private $session;
    private $cityRepository;

    /**
     * BikerController constructor.
     * @param Environment $twig
     * @param FormFactoryInterface $form
     * @param RequestStack $request
     * @param ManagerRegistry $registry
     * @param Security $security
     * @param SessionInterface $session
     * @param CityRepository $cityRepository
     */
    public function __construct(
        Environment $twig,
        FormFactoryInterface $form,
        RequestStack $request,
        ManagerRegistry $registry,
        Security $security,
        SessionInterface $session,
        CityRepository $cityRepository
    )
    {
        $this->twig = $twig;
        $this->form = $form;
        $this->request = $request;
        $this->doctrine = $registry;
        $this->security = $security;
        $this->session = $session;
        $this->cityRepository = $cityRepository;
    }

    /**
     * @Route ("restaurant/{city}", name="restaurants_by_city")
     * @param $city
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function restaurantsByCity($city): Response
    {
        dump($city);
        //dump($this->request->getCurrentRequest()->query->get('city'));
        return new Response($this->twig->render('site/restaurantsByCity.html.twig',[
            //'categories' => $categoryRepository->findAll()
            'city' => $this->cityRepository->findBy(['name' => $city])[0]
        ]));
    }

    /**
     * @Route ("restaurant/{city}/{restaurant}", name="restaurant_show")
     * @param $city
     * @param $restaurant
     * @param RestaurantRepository $restaurantRepository
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function showRestaurant($city, $restaurant, RestaurantRepository $restaurantRepository): Response
    {
        dump($restaurant);
        dump($city);
        //dump($this->request->getCurrentRequest()->query->get('city'));
        return new Response($this->twig->render('site/restaurant.html.twig',[
            'city' => $this->cityRepository->findBy(['name' => $city])[0],
            'restaurant' => $this->restaurantRepository->findBy(['name' => $restaurant])[0]
        ]));
    }
}
