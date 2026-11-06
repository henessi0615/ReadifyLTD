<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Request\User\LoginUserRequest;
use App\Response\User\UserAuthenticatedResponse;
use App\Service\User\UserService;
use OpenApi\Spec\Operation\Post;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final readonly class LoginController
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    /**
     * @throws \Throwable
     */
    #[Post(summary: 'Login an existing user', tags: ['User'])]
    #[Route('/api/v1/authentication/login', name: 'v1_authentication_login', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload]
        LoginUserRequest $request,
    ): UserAuthenticatedResponse {
        $authData = $this->userService->login(
            email: $request->email,
            plainPassword: $request->password,
        );

        return new UserAuthenticatedResponse($authData);
    }
}
