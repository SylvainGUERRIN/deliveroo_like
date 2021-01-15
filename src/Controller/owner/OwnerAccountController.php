<?php

namespace App\Controller\owner;

use App\Entity\Address;
use App\Entity\City;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Form\RegistrationOwnerType;
use App\Form\RegistrationType;
use App\Repository\BikerRepository;
use App\Repository\CityRepository;
use App\Repository\RestaurantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class OwnerAccountController
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
     * @Route ("/owner/registration", name="owner_registration")
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param CityRepository $cityRepository
     * @return RedirectResponse|Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function ownerRegister(UserPasswordEncoderInterface $userPasswordEncoder, CityRepository $cityRepository)
    {
        if ($this->security->isGranted('ROLE_USER')) {
            return new RedirectResponse('/user-profile');
        }

        $form = $this->form->create(RegistrationOwnerType::class);
        $form->handleRequest($this->request->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            //dump($form->getViewData());
            //dd($form->getData());
            $em = $this->doctrine->getManager();

//            dump($form['profile']);
//            //dd($form['profile']->getData());

            //user
            $user = $form['profile']->getData();
            $hashPass = $userPasswordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashPass);
            $user->setCreatedAt(new \DateTimeImmutable('now'));
            $user->setRole(['ROLE_OWNER']);

            $em->persist($user);
            $em->flush();

            //city
            $city = $form['city']->getData();
//            $zipCode = $form['line1']->getData();
//            dump($cityRepository->findByName($city));
            $cityInBdd = $cityRepository->findByName($city)[0];
//            $cityInBdd = $cityRepository->findByNameAndZipCode($city, $zipCode);
//            dd($cityInBdd);

            //address
            $address = new Address();
            $address->setName($form['name']->getData());
            $address->setLine1($form['line1']->getData());
            $address->setLine2($form['line2']->getData());
            $address->setCity($cityInBdd);
            $em->persist($address);
            $em->flush();
           //dump($address);

            //restaurant
            $restaurant = $form['restaurant']->getData();
            $restaurant->setCreatedAt(new \DateTimeImmutable('now'));
            $restaurant->setAddress($address);
            $restaurant->setCity($cityInBdd);
            $restaurant->setOwner($user);
            $restaurant->setEnabled(false);
            $restaurant->setPublished(false);
            $em->persist($restaurant);
            $em->flush();
            //dump($restaurant);

            $this->session->getFlashBag()->add(
                'success',
                'Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !'
            );

            return new RedirectResponse('user/account/connexion');
        }

        return new Response($this->twig->render('owner/registration.html.twig',[
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route ("/owner/dashboard", name="owner_dashboard")
     * @param RestaurantRepository $restaurantRepository
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function OwnerDashboard(RestaurantRepository $restaurantRepository): Response
    {
        //dump($this->security->getUser());
        return new Response($this->twig->render('owner/dashboard.html.twig', [
            'restaurant' => $this->security->getUser()->getOwners()
        ]));
    }
}
