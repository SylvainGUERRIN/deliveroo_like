<?php


namespace App\Controller;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function home(CategoryRepository $categoryRepository, Request $request): Response
    {
        //dump($request);
        if($request->isMethod('post') === true){

            //dump($request->request->get('zip-code'));
            //dump($request->request->get('get_city_cityName'));
            $cityName = $request->request->get('get_city_cityName');
            return new RedirectResponse('restaurant/'. $cityName);
        }

        return new Response($this->twig->render('site/home.html.twig',[
            'categories' => $categoryRepository->findAll()
        ]));
    }

    /**
     * @Route ("/carrieres", name="careers")
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function careers(): Response
    {
        return new Response($this->twig->render('site/careers.html.twig'));
    }

    /**
     * @Route("/contact", name="contact")
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
