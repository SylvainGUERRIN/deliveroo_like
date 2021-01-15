<?php

namespace App\Controller\owner;

use App\Form\RestaurantDetailsType;
use App\Form\RestaurantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class OwnerController
{
    private $twig;
    private $form;
    private $request;
    private $doctrine;
    private $security;
    private $session;

    /**
     * BikerController constructor.
     * @param Environment $twig
     * @param FormFactoryInterface $form
     * @param RequestStack $request
     * @param ManagerRegistry $registry
     * @param Security $security
     * @param SessionInterface $session
     */
    public function __construct(
        Environment $twig,
        FormFactoryInterface $form,
        RequestStack $request,
        ManagerRegistry $registry,
        Security $security,
        SessionInterface $session
    )
    {
        $this->twig = $twig;
        $this->form = $form;
        $this->request = $request;
        $this->doctrine = $registry;
        $this->security = $security;
        $this->session = $session;
    }

    /**
     * @Route ("owner/restaurant/details", name="owner_restaurant_details")
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function RestaurantDetails(): Response
    {
        $restaurant = $this->security->getUser()->getOwners();
        $form = $this->form->create(RestaurantDetailsType::class, $restaurant);
        $form->handleRequest($this->request->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->doctrine->getManager();
            $em->persist($restaurant);
            $em->flush();

            $this->session->getFlashBag()->add(
                'success',
                'Les modifications sur votre restaurant ont bien étées prise en compte.'
            );

//            return new RedirectResponse('user/account/connexion');
        }

        return new Response($this->twig->render('owner/restaurant-details.html.twig', [
//            'restaurant' => $this->security->getUser()->getOwners()
            'form' => $form->createView(),
        ]));
    }
}
