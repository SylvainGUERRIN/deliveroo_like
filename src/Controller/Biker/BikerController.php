<?php

namespace App\Controller\Biker;

use App\Entity\Biker;
use App\Entity\User;
use App\Form\RegistrationBikerType;
use App\Form\RegistrationCityType;
use App\Form\RegistrationType;
use App\Repository\BikerRepository;
use App\Repository\UserRepository;
use App\Services\ManageBikerMultiStepsFormService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
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
    private $security;

    /**
     * BikerController constructor.
     * @param Environment $twig
     * @param ManageBikerMultiStepsFormService $bikerMultiStepsFormService
     * @param FormFactoryInterface $form
     * @param RequestStack $request
     * @param ManagerRegistry $registry
     * @param Security $security
     */
    public function __construct(
        Environment $twig,
        ManageBikerMultiStepsFormService $bikerMultiStepsFormService,
        FormFactoryInterface $form,
        RequestStack $request,
        ManagerRegistry $registry,
        Security $security
    )
    {
        $this->twig = $twig;
        $this->bikerMultiStepsFormService = $bikerMultiStepsFormService;
        $this->form = $form;
        $this->request = $request;
        $this->doctrine = $registry;
        $this->security = $security;
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
        if ($this->security->isGranted('ROLE_USER')) {
            return new RedirectResponse('/user-profile');
        }

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

            $this->bikerMultiStepsFormService->saveStepOne($user->getId());

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
     * @param UserRepository $userRepository
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function stepTwo(UserRepository $userRepository): Response
    {
        if ($this->security->isGranted('ROLE_USER')) {
            return new RedirectResponse('/user-profile');
        }

        //add logic for biker multi form service
        $this->bikerMultiStepsFormService->verifyStepInSession($step = 'two');

        $biker = new Biker();

        $form = $this->form->create(RegistrationBikerType::class, $biker);
        $form->handleRequest($this->request->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->doctrine->getManager();
            $em->persist($biker);
            $em->flush();

            //don't forget relation with user, catch id with session
            $userId = str_replace('jgkfg564g86f53g4dfdez4586q','',$this->bikerMultiStepsFormService->getStepOne());
            $user = $userRepository->find($userId);
            $user->setBikers($biker);
            $em->persist($user);
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
        if ($this->security->isGranted('ROLE_USER')) {
            return new RedirectResponse('/user-profile');
        }

        //add logic for biker multi form service
        $bikerId = str_replace('jgkfg564g86f53g4dfdez4586q','',$this->bikerMultiStepsFormService->getStepTwo());
        $biker = $bikerRepository->find($bikerId);

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
