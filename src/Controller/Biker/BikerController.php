<?php

namespace App\Controller\Biker;

use App\Entity\Biker;
use App\Entity\User;
use App\Form\RegistrationBikerType;
use App\Form\RegistrationCityType;
use App\Form\RegistrationType;
use App\Repository\BikerRepository;
use App\Services\ManageBikerMultiStepsFormService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class BikerController
{
    private $twig;
    private $bikerMultiStepsFormService;
    private $form;
    private $request;
    private $doctrine;

    /**
     * BikerController constructor.
     * @param Environment $twig
     * @param ManageBikerMultiStepsFormService $bikerMultiStepsFormService
     * @param FormFactoryInterface $form
     * @param RequestStack $request
     * @param ManagerRegistry $registry
     */
    public function __construct(
        Environment $twig,
        ManageBikerMultiStepsFormService $bikerMultiStepsFormService,
        FormFactoryInterface $form,
        RequestStack $request,
        ManagerRegistry $registry)
    {
        $this->twig = $twig;
        $this->bikerMultiStepsFormService = $bikerMultiStepsFormService;
        $this->form = $form;
        $this->request = $request;
        $this->doctrine = $registry;
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
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function stepOne(UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        //add logic for biker multi form service
        $this->bikerMultiStepsFormService->verifyStepInSession($step = 'one');

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
//            $this->session->getFlashBag()->add(
//                'success',
//                'Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !'
//            );

            return new RedirectResponse('biker_registration_step_two');
        }

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
        //add logic for biker multi form service
        $this->bikerMultiStepsFormService->verifyStepInSession($step = 'two');

        $biker = new Biker();

        $form = $this->form->create(RegistrationBikerType::class, $biker);
        $form->handleRequest($this->request->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {

            //don't forget relation with user, catch id with session

            $em = $this->doctrine->getManager();
            $em->persist($biker);
            $em->flush();
//            $this->session->getFlashBag()->add(
//                'success',
//                'Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !'
//            );

            return new RedirectResponse('biker_registration_step_three');
        }

        return new Response($this->twig->render('biker/account/registration/registration-step-two.html.twig'));
    }

    /**
     * @Route("/biker-inscription/etape-trois", name="biker_registration_step_three")
     * @param BikerRepository $bikerRepository
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function stepThree(BikerRepository $bikerRepository): Response
    {
        //add logic for biker multi form service
//        $bikerId = $this->bikerMultiStepsFormService
//        $biker = $bikerRepository->find($bikerId);

        $form = $this->form->create(RegistrationCityType::class, $biker);
        $form->handleRequest($this->request->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {

            //don't forget relation with biker, catch id with session
            //and add city to biker entity

            $em = $this->doctrine->getManager();
            $em->persist($biker);
//            $this->session->getFlashBag()->add(
//                'success',
//                'Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !'
//            );

            return new RedirectResponse('login');
        }

        return new Response($this->twig->render('biker/account/registration/registration-step-three.html.twig'));
    }
}
