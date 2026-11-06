<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Request\User\RegisterUserRequest;
use App\Response\User\UserRegisteredResponse;
use App\Service\User\UserService;
use OpenApi\Spec\Operation\Post;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final readonly class RegisterController
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    /**
     * @throws \Throwable
     */
    #[Post(summary: 'Register a new user', tags: ['User'])]
    #[Route('/api/v1/users/register', name: 'v1_register_user', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload]
        RegisterUserRequest $request,
    ): UserRegisteredResponse {
        $userDto = $this->userService->register(
            email: $request->email,
            plainPassword: $request->password,
            displayName: $request->displayName,
        );

        return new UserRegisteredResponse($userDto);
    }
}
