<?php

declare(strict_types=1);

namespace App\Response;

use App\DTO\AuthorDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetAuthorsResponse extends JsonResponse
{
    /**
     * @param AuthorDTO[] $authors
     */
    public function __construct(array $authors)
    {
        parent::__construct([
            'status' => 'success',
            'data' => $authors,
        ], status: Response::HTTP_OK);
    }
}
