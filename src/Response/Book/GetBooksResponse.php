<?php

declare(strict_types=1);

namespace App\Response\Book;

use App\DTO\BookDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetBooksResponse extends JsonResponse
{
    /**
     * @param BookDTO[] $books
     */
    public function __construct(array $books)
    {
        parent::__construct([
            'status' => 'success',
            'data' => $books,
        ], status: Response::HTTP_OK);
    }
}
