<?php


namespace App\Controller;


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

class CategoryController
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
     * @Route("/type-de-cuisine/{slug}", name="food_category")
     * @param $slug
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function foodCategory($slug): Response
    {
        return new Response($this->twig->render('site/categories/single-category.html.twig'));
    }
}
