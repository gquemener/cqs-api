<?php

declare (strict_types = 1);

namespace App\Security;

use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use App\Authentication\Domain\TokenValue;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class TokenAuthenticator extends AbstractGuardAuthenticator
{
    public function supports(Request $request)
    {
        $header = $request->headers->get('Authorization');
        if (null === $header) {
            return false;
        }

        return 0 === strpos($header, 'Bearer ');
    }

    public function getCredentials(Request $request)
    {
        return [
            'token' => substr($request->headers->get('Authorization'), 7)
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $tokenValue = $credentials['token'];

        return $userProvider->loadUserByUsername($tokenValue);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'title' => 'Authentication failed',
            'detail' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
    }

    public function supportsRememberMe()
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            'title' => 'Authentication Required',
            'detail' => '',
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
