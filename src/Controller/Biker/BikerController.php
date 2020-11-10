<?php

namespace App\Controller\Biker;

use App\Services\ManageBikerMultiStepsFormService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class BikerController
{
    private $twig;
    private $bikerMultiStepsFormService;

    /**
     * BikerController constructor.
     * @param Environment $twig
     * @param ManageBikerMultiStepsFormService $bikerMultiStepsFormService
     */
    public function __construct(Environment $twig, ManageBikerMultiStepsFormService $bikerMultiStepsFormService)
    {
        $this->twig = $twig;
        $this->bikerMultiStepsFormService = $bikerMultiStepsFormService;
    }

    /**
     * @Route("/biker-presentation", name="biker_presentation")
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(): Response
    {
        return new Response($this->twig->render('biker/index.html.twig'));
    }

    /**
     * @Route("/biker-inscription/etape-une", name="biker_registration_step_one")
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function stepOne(): Response
    {
        return new Response($this->twig->render('biker/account/registration/registration-step-one.html.twig'));
    }

    /**
     * @Route("/biker-inscription/etape-deux", name="biker_registration_step_two")
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function stepTwo(): Response
    {
        return new Response($this->twig->render('biker/account/registration/registration-step-two.html.twig'));
    }

    /**
     * @Route("/biker-inscription/etape-trois", name="biker_registration_step_three")
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function stepThree(): Response
    {
        return new Response($this->twig->render('biker/account/registration/registration-step-three.html.twig'));
    }
}
