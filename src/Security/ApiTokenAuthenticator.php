<?php

namespace App\Security;

use App\Repository\ApiTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;

final class ApiTokenAuthenticator extends AbstractAuthenticator
{
    private ApiTokenRepository $apiTokenRepository;

    public function __construct(ApiTokenRepository $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization') &&
            0 === strpos($request->headers->get('Authorization'), 'Bearer ');
    }

    public function authenticate(Request $request): Passport
    {
        $credentials = substr($request->headers->get('Authorization'), 7);

        $token = $this->apiTokenRepository->findOneBy([
            'token' => $credentials
        ]);
        if (!$token) {
            throw new CustomUserMessageAuthenticationException(
                'Invalid API Token'
            );
        }
        if ($token->isExpired()) {
            throw new CustomUserMessageAuthenticationException(
                'Token expired'
            );
        }

        if ($token->getUser() == null) {
            throw new CustomUserMessageAuthenticationException(
                'Token invalid'
            );
        }
        $user = $token->getUser();

        return new Passport(new UserBadge($user->getEmail()), new CustomCredentials(
            function ($credentials, UserInterface $user) {
                return $this->apiTokenRepository->findOneBy([
                    'token' => $credentials
                ]) != null;
            },
            $token->getToken()
        ));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) : Response
    {
        return new JsonResponse([
            'message' => $exception->getMessageKey()
        ], 403);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) : ?Response
    {
        return null; // allow data to be sent
    }

}
