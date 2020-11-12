<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

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
            if ($this->session->has('stepOne') && !$this->session->has('stepTwo')) {
                return new RedirectResponse('biker_registration_step_two');
            }
        }
    }

    /**
     * @param $userId
     */
    public function saveStepOne($userId): void
    {
        $stepOne = 'jgkfg564g86f53g4dfdez4586q' . $userId;
        $this->session->set('stepOne', $stepOne);
    }

    /**
     * @return mixed
     */
    public function getStepOne()
    {
        return $this->session->get('stepOne');
    }

    /**
     * @param $bikerId
     */
    public function saveStepTwo($bikerId): void
    {
        $stepTwo = 'jgkfg564g86f53g4dfdez4586q' . $bikerId;
        $this->session->set('stepTwo', $stepTwo);
    }

    /**
     * @return mixed
     */
    public function getStepTwo()
    {
        return $this->session->get('stepTwo');
    }
}
