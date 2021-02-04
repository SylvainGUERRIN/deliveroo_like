<?php

namespace App\Controller;

use App\Data\SortingData;
use App\Form\SortingType;
use App\Repository\CityRepository;
use App\Repository\RestaurantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
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
    private $restaurantRepository;

    /**
     * BikerController constructor.
     * @param Environment $twig
     * @param FormFactoryInterface $form
     * @param RequestStack $request
     * @param ManagerRegistry $registry
     * @param Security $security
     * @param SessionInterface $session
     * @param CityRepository $cityRepository
     * @param RestaurantRepository $restaurantRepository
     */
    public function __construct(
        Environment $twig,
        FormFactoryInterface $form,
        RequestStack $request,
        ManagerRegistry $registry,
        Security $security,
        SessionInterface $session,
        CityRepository $cityRepository,
        RestaurantRepository $restaurantRepository
    )
    {
        $this->twig = $twig;
        $this->form = $form;
        $this->request = $request;
        $this->doctrine = $registry;
        $this->security = $security;
        $this->session = $session;
        $this->cityRepository = $cityRepository;
        $this->restaurantRepository = $restaurantRepository;
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
        //dump($city);
        $cityForRestaurants = $this->cityRepository->findBy(['name' => $city])[0];
//        dump($this->restaurantRepository->findBy(['city' => $cityForRestaurants]));
//        dd($cityForRestaurants);
        //dump($this->request->getCurrentRequest()->query->get('city'));

        $data = new SortingData();
        $data->page = $this->request->getCurrentRequest()->get('page', 1);
//        $data->page = $request->get('page', 1);
        $form = $this->form->create(SortingType::class, $data);

        $form->handleRequest($this->request->getCurrentRequest());

        if($form->isSubmitted() && $form->isValid()){
            $restaurants = $this->restaurantRepository->findSortingData($data);
        }else{
            $restaurants = $this->restaurantRepository->findBy(['city' => $cityForRestaurants]);
        }

        return new Response($this->twig->render('site/restaurantsByCity.html.twig',[
            //'categories' => $categoryRepository->findAll()
            'city' => $cityForRestaurants,
            'restaurants' => $restaurants,
//            'restaurants' => $this->restaurantRepository->findBy(['city' => $cityForRestaurants]),
            'form' => $form->createView()
        ]));
    }

    /**
     * @Route ("restaurant/{city}/{restaurant}", name="restaurant_show")
     * @param $city
     * @param $restaurant
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function showRestaurant($city, $restaurant): Response
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
