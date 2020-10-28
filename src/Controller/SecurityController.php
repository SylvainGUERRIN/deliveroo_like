<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SecurityController
{
    private $twig;

    /**
     * SiteController constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
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
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function mailRegistration(): Response
    {
        return new Response($this->twig->render('user/mail-registration.html.twig'));
    }

    /**
     * @Route("/connexion", name="login")
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function login(): Response
    {
        return new Response($this->twig->render('user/login.html.twig'));
    }
}
