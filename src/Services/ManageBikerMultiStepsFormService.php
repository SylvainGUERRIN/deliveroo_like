<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * to manage session between forms, initialize at each pages
 * Class ManageBikerMultiStepsFormService
 * @package App\Services
 */
class ManageBikerMultiStepsFormService
{
    protected $session;

    /**
     * ManageBikerMultiStepsFormService constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param $step
     * @return RedirectResponse|void
     */
    public function verifyStepInSession($step)
    {
        if($step === 'one'){
            if ($this->session->has('stepOne')) {
                return new RedirectResponse('biker_registration_step_two');
            }
        }

        if($step === 'two'){
            if($this->session->has('stepTwo')) {
                return new RedirectResponse('biker_registration_step_three');
            }
        }

        if($step === 'three'){
            if(!$this->session->has('stepOne') && !$this->session->has('stepTwo')) {
                return new RedirectResponse('biker_registration_step_one');
            }
        }
    }
}
