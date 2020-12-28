<?php


namespace App\Security\Guard;


use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class AdminAuthenticator extends AbstractFormLoginAuthenticator
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfTokenManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    /**
     * UserAuthenticator constructor.
     * @param UrlGeneratorInterface $urlGenerator
     * @param UserRepository $userRepository
     * @param RouterInterface $router
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        UserRepository $userRepository,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $userPasswordEncoder
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->userRepository = $userRepository;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @return string
     */
    protected function getLoginUrl(): string
    {
        return $this->urlGenerator->generate("admin_connexion");
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request): bool
    {
//        dd($request->isMethod(Request::METHOD_POST) && $request->attributes->get('_route') === 'user_connexion');
        return $request->isMethod(Request::METHOD_POST) && $request->attributes->get('_route') === 'admin_connexion';
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getCredentials(Request $request): array
    {
        $credentials = [
            'mail' => $request->request->get('_username'),
            'password' => $request->request->get('_password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['mail']
        );

        return $credentials;
    }

    /**
     * @param $credentials
     * @param UserProviderInterface $userProvider
     * @return mixed
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException('It\'s an invalid token csrf');
        }
        return $this->userRepository->findOneBy(['mail' => $credentials['mail']]);
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $this->userPasswordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param $providerKey
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): RedirectResponse
    {
        return new RedirectResponse($this->router->generate('admin_dashboard'));
    }
}
