<?php

declare(strict_types=1);

namespace App\Response\Author;

use App\DTO\AuthorDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class UpdatedAuthorResponse extends JsonResponse
{
    public function __construct(AuthorDTO $authorDto)
    {
        parent::__construct([
            'status' => 'success',
            'data' => $authorDto->jsonSerialize(),
        ], status: Response::HTTP_OK);
    }
}
