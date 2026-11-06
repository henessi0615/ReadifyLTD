<?php

declare(strict_types=1);

namespace App\Response\User;

use App\DTO\UserDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class UserAuthenticatedResponse extends JsonResponse
{
    /**
     * @param array{jwtToken: string, user: UserDTO} $authData
     */
    public function __construct(array $authData)
    {
        parent::__construct([
            'status' => 'success',
            'data' => [
                'jwtToken' => $authData['jwtToken'],
                'user' => $authData['user']->jsonSerialize(),
            ],
        ], status: Response::HTTP_OK);
    }
}
