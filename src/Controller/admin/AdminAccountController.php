<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\RegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
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
 * Class AdminAccountController
 * @package App\Controller\Admin
 * @Route("/deliv-admin/account")
 */
class AdminAccountController
{
    private $twig;
    private $security;
    private $request;
    private $form;
    private $session;
    private $doctrine;

    /**
     * SiteController constructor.
     * @param Environment $twig
     * @param Security $security
     * @param RequestStack $request
     * @param FormFactoryInterface $form
     * @param SessionInterface $session
     * @param ManagerRegistry $registry
     */
    public function __construct(
        Environment $twig,
        Security $security,
        RequestStack $request,
        FormFactoryInterface $form,
        SessionInterface $session,
        ManagerRegistry $registry
    )
    {
        $this->twig = $twig;
        $this->security = $security;
        $this->request = $request;
        $this->form = $form;
        $this->session = $session;
        $this->doctrine = $registry;
    }

    /**
     * @Route("/registration", name="admin_registration")
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function adminRegistration(UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse('/user-profile');
        }

        $user = new User();

        $form = $this->form->create(RegistrationType::class, $user);
        $form->handleRequest($this->request->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $hashPass = $userPasswordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashPass);
            $user->setCreatedAt(new \DateTimeImmutable('now'));
            $user->setRole(['ROLE_ADMIN']);

            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();
            $this->session->getFlashBag()->add(
                'success',
                'Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !'
            );

            return new RedirectResponse('connexion');
        }

        return new Response($this->twig->render('admin/account/admin-registration.html.twig',[
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/connexion", name="admin_connexion")
     * @param AuthenticationUtils $utils
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function login(AuthenticationUtils $utils): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse('/admin/account/profile');
        }

        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return new Response($this->twig->render('admin/account/login.html.twig',[
            'error' => $error !== null,
            'last_username' => $username
        ]));
    }

    /**
     * @Route("/admin-deconnexion", name="admin_deconnexion")
     */
    public function deconnexion(): void
    {

    }

    /**
     * @Route("/profil", name="admin_profile")
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function profile(): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse('/admin/account/profile');
        }

        $user = $this->security->getUser();
//        $oldImage = $user->getAvatarUrl();
//        $avatar = new Avatar();

        $form = $this->form->create(AccountType::class, $user);

        $form->handleRequest($this->request);

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

        return new Response($this->twig->render('admin/account/login.html.twig',[
            'form' => $form->createView()
        ]));
    }

    /**
     * @Route("/dashboard", name="admin_dashboard")
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function dashboard(): Response
    {
        return new Response($this->twig->render('admin/dashboard.html.twig'));
    }
}
