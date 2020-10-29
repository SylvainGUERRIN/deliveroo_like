<?php


namespace App\Controller;


use App\Entity\User;
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

class SecurityController
{
    private $twig;
    private $form;
    private $request;
    private $session;
    private $doctrine;

    /**
     * SiteController constructor.
     * @param Environment $twig
     * @param FormFactoryInterface $form
     * @param RequestStack $request
     * @param SessionInterface $session
     * @param ManagerRegistry $registry
     */
    public function __construct(
        Environment $twig,
        FormFactoryInterface $form,
        RequestStack $request,
        SessionInterface $session,
        ManagerRegistry $registry
    )
    {
        $this->twig = $twig;
        $this->form = $form;
        $this->request = $request;
        $this->session = $session;
        $this->doctrine = $registry;
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
        $user = new User();

        $form = $this->form->create(RegistrationType::class, $user);
        $form->handleRequest($this->request->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $hashPass = $userPasswordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashPass);
            $user->setCreatedAt(new \DateTime('now'));
            $user->setRole(['ROLE_USER']);

            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();
            $this->session->getFlashBag()->add(
                'success',
                'Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !'
            );

            return new RedirectResponse('user_connexion');
        }

        return new Response($this->twig->render('user/mail-registration.html.twig',[
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/connexion", name="login")
     * @param AuthenticationUtils $helper
     * @param Security $security
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function login(AuthenticationUtils $helper, Security $security): Response
    {
        if ($security->isGranted('ROLE_USER')) {
            return new RedirectResponse('user_profil');
        }

//        $error = $utils->getLastAuthenticationError();
//        $username = $utils->getLastUsername();
        return new Response($this->twig->render('user/login.html.twig',[
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
        ]));
    }
}
