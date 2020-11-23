<?php


namespace App\Controller;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SiteController
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
     * @Route("/", name="home")
     * @param CategoryRepository $categoryRepository
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function home(CategoryRepository $categoryRepository): Response
    {
        return new Response($this->twig->render('site/home.html.twig',[
            'categories' => $categoryRepository->findAll()
        ]));
    }

    /**
     * @Route("/", name="contact")
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function contact(): Response
    {
        return new Response($this->twig->render('site/contact.html.twig'));
    }
}
