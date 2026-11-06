<?php

declare(strict_types=1);

namespace App\Response\User;

use App\DTO\UserDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class UserRegisteredResponse extends JsonResponse
{
    public function __construct(UserDTO $userDto)
    {
        parent::__construct([
            'status' => 'success',
            'data' => $userDto->jsonSerialize(),
        ], status: Response::HTTP_CREATED);
    }
}
