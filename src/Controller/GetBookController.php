<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\GetBookRequest;
use App\Response\GetBookResponse;
use App\Service\Book\BookService;
use OpenApi\Spec\Operation\Get;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final readonly class GetBookController
{
    public function __construct(
        private BookService $bookService
    ) {
    }

    #[Get(summary: 'Get a specific book by ID', tags: ['Books'])]
    #[Route('/api/v1/books/{id}', name: 'v1_get_book', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function __invoke(
        string $id,
    ): GetBookResponse {
        $uuid = Uuid::fromString($id);

        $request = new GetBookRequest($uuid);

        $bookDto = $this->bookService->getById($request->id);

        return new GetBookResponse($bookDto);
    }
}
