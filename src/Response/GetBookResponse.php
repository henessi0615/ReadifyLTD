<?php

declare(strict_types=1);

namespace App\Response;

use App\DTO\BookDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetBookResponse extends JsonResponse
{
    public function __construct(BookDTO $bookDto)
    {
        parent::__construct([
            'status' => 'success',
            'data' => $bookDto->jsonSerialize(),
        ], status: Response::HTTP_OK);
    }
}
