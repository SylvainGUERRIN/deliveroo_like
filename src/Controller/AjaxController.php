<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Services\ManageBikerMultiStepsFormService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class AjaxController
{
    private $twig;
    private $bikerMultiStepsFormService;
    private $form;
    private $request;
    private $doctrine;
    private $security;
    private $session;

    /**
     * BikerController constructor.
     * @param Environment $twig
     * @param ManageBikerMultiStepsFormService $bikerMultiStepsFormService
     * @param FormFactoryInterface $form
     * @param RequestStack $request
     * @param ManagerRegistry $registry
     * @param Security $security
     * @param SessionInterface $session
     */
    public function __construct(
        Environment $twig,
        ManageBikerMultiStepsFormService $bikerMultiStepsFormService,
        FormFactoryInterface $form,
        RequestStack $request,
        ManagerRegistry $registry,
        Security $security,
        SessionInterface $session
    )
    {
        $this->twig = $twig;
        $this->bikerMultiStepsFormService = $bikerMultiStepsFormService;
        $this->form = $form;
        $this->request = $request;
        $this->doctrine = $registry;
        $this->security = $security;
        $this->session = $session;
    }

    /**
     * @Route("/city-search", name="city_search")
     * @param Request $request
     * @param CityRepository $cityRepository
     * @return JsonResponse|RedirectResponse
     */
    public function searchCityWithAjax(Request $request, CityRepository $cityRepository)
    {
        if($request->isXmlHttpRequest()){
//            $data = '';
            $value = $request->get('value');
            $search = $cityRepository->searchCity($value);
            $cityArray = [];
            if(count($search) > 1){
                foreach ($search as $s){
                    $cityArray[] = [$s->getName(), $s->getZipCode() ];
                }
            }

            return new JsonResponse([
                $cityArray
            ]);
        }
        return new RedirectResponse('/');
    }
}
