<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\GetBooksRequest;
use App\Response\GetBooksResponse;
use App\Service\Book\BookService;
use OpenApi\Spec\Operation\Get;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final readonly class GetBooksController
{
    public function __construct(
        private BookService $bookService,
    ) {
    }

    #[Get(summary: 'Get a filtered list of books', tags: ['Books'])]
    #[Route('/api/v1/books', name: 'v1_get_books', methods: ['GET'])]
    public function __invoke(
        GetBooksRequest $request = new GetBooksRequest(),
    ): JsonResponse {
        return new GetBooksResponse(
            $this->bookService->getAll()
        );
    }
}
