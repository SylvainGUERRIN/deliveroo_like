<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\RegistrationType;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class SecurityController
 * @package App\Controller
 * @Route("/user/account")
 */
class SecurityController
{
    private $twig;
    private $form;
    private $request;
    private $session;
    private $doctrine;
    private $security;

    /**
     * SiteController constructor.
     * @param Environment $twig
     * @param FormFactoryInterface $form
     * @param RequestStack $request
     * @param SessionInterface $session
     * @param ManagerRegistry $registry
     * @param Security $security
     */
    public function __construct(
        Environment $twig,
        FormFactoryInterface $form,
        RequestStack $request,
        SessionInterface $session,
        ManagerRegistry $registry,
        Security $security
    )
    {
        $this->twig = $twig;
        $this->form = $form;
        $this->request = $request;
        $this->session = $session;
        $this->doctrine = $registry;
        $this->security = $security;
    }

    /**
     * @Route("/registration", name="registration")
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function registration(): Response
    {
        return new Response($this->twig->render('user/registration.html.twig'));
    }

    /**
     * @Route("/mail-registration", name="mail_registration")
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function mailRegistration(UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        if ($this->security->isGranted('ROLE_USER')) {
            return new RedirectResponse('/user-profile');
        }

        $user = new User();

        $form = $this->form->create(RegistrationType::class, $user);
        $form->handleRequest($this->request->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $hashPass = $userPasswordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashPass);
            $user->setCreatedAt(new \DateTimeImmutable('now'));
            $user->setRole(['ROLE_USER']);

            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();
            $this->session->getFlashBag()->add(
                'success',
                'Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !'
            );

            return new RedirectResponse('login');
        }

        return new Response($this->twig->render('user/mail-registration.html.twig',[
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/connexion", name="login")
     * @param AuthenticationUtils $helper
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function login(AuthenticationUtils $helper): Response
    {
        if ($this->security->isGranted('ROLE_USER')) {
            return new RedirectResponse('/user-profile');
        }

        return new Response($this->twig->render('user/login.html.twig',[
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
        ]));
    }

    /**
     * @Route("/user-profile", name="profile")
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function profile(): Response
    {
        //find way to get user without global container
        $user = $this->security->getUser();
        //dd($user);

//        $oldImage = $user->getAvatarUrl();
//        $avatar = new Avatar();

        $form = $this->form->create(AccountType::class, $user);
        //dd($form);

        $form->handleRequest($this->request->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {

//            $user->setUpdatedAt(new DateTime('now'));

            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();

            $this->session->getFlashBag()->add(
                'success',
                "Les données du profil ont bien étés modifiées."
            );
        }

        return new Response($this->twig->render('user/profile.html.twig',[
            'form' => $form->createView(),
            'user' => $user
        ]));
    }

    /**
     * permet de se deconnecter
     * @Route("/deconnexion", name="logout")
     * @return void
     */
    public function logout(): void
    {
        //automatic redirection
    }
}
