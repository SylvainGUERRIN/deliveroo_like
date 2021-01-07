<?php

namespace App\Controller\owner;

use App\Entity\Restaurant;
use App\Entity\User;
use App\Form\RegistrationOwnerType;
use App\Form\RegistrationType;
use App\Repository\BikerRepository;
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
     * @return RedirectResponse|Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function ownerRegister(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        if ($this->security->isGranted('ROLE_USER')) {
            return new RedirectResponse('/user-profile');
        }

//        $user = new User();
        $restaurant = new Restaurant();

        $form = $this->form->create(RegistrationOwnerType::class);
        $form->handleRequest($this->request->getCurrentRequest());

//        if ($form->isSubmitted() && $form->isValid()) {
//            $hashPass = $userPasswordEncoder->encodePassword($user, $user->getPassword());
//            $user->setPassword($hashPass);
//            $user->setCreatedAt(new \DateTimeImmutable('now'));
//            $user->setRole(['ROLE_OWNER']);
//
//            $em = $this->doctrine->getManager();
//            $em->persist($user);
//            $em->flush();
//            $this->session->getFlashBag()->add(
//                'success',
//                'Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !'
//            );
//
//            return new RedirectResponse('login');
//        }

        return new Response($this->twig->render('owner/registration.html.twig',[
            'form' => $form->createView(),
        ]));
    }
}
