<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
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
     * @return array|string|void
     */
    public function verifyStepInSession($step)
    {
        if($step === 'one'){
            if ($this->session->has('stepOne')) {
                return ['redirect','/biker-inscription/etape-deux'];
            }
            if ($this->session->has('stepTwo')) {
                return ['redirect','/biker-inscription/etape-trois'];
            }
            return null;
        }

        if($step === 'two'){
            if(!$this->session->has('stepOne')) {
                return ['redirect','/biker-inscription/etape-une'];
            }
            return null;
        }

        if($step === 'three'){
            if(!$this->session->has('stepOne') && !$this->session->has('stepTwo')) {
                return ['redirect','/biker-inscription/etape-une'];
            }
            if ($this->session->has('stepOne') && !$this->session->has('stepTwo')) {
                return ['redirect','/biker-inscription/etape-deux'];
            }
            return null;
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
