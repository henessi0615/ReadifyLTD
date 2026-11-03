<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\CreateBookRequest;
use App\Response\BookCreatedResponse;
use App\Service\Book\BookService;
use OpenApi\Spec\Operation\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final readonly class CreateBookController
{
    public function __construct(
        private BookService $bookService,
    ) {
    }

    #[Post(summary: 'Create a new book', tags: ['Books'])]
    #[Route('/api/v1/books', name: 'v1_create_book', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload]
        CreateBookRequest $request,
    ): JsonResponse {
        $bookDto = $this->bookService->create(
            title: $request->title,
            description: $request->description,
            isbn: $request->isbn,
            priceAmount: $request->priceAmount,
            priceCurrency: $request->priceCurrency,
            authorId: $request->authorId
        );

        return new BookCreatedResponse($bookDto);
    }
}
