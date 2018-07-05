<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class LoginPasswordAuthenticator extends AbstractGuardAuthenticator
{
    public function supports(Request $request)
    {
        $param = $request->request->all();

        return isset($param['login']) && isset($param['password']);
    }

    public function getCredentials(Request $request)
    {
        return [
            'login' => $request->request->get('login'),
            'password' => $request->request->get('password'),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials['login']);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return false;
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
        $data = [
            'title' => 'Authentication Required',
            'detail' => '',
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
