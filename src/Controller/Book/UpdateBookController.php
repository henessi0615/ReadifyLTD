<?php

declare(strict_types=1);

namespace App\Controller\Book;

use App\Request\Book\UpdateBookRequest;
use App\Response\Book\UpdatedBookResponse;
use App\Service\Book\BookService;
use OpenApi\Spec\Operation\Put;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final readonly class UpdateBookController
{
    public function __construct(
        private BookService $bookService,
    ) {
    }

    /**
     * @throws \Throwable
     */
    #[Put(summary: 'Full update an existing book', tags: ['Books'])]
    #[Route('/api/v1/books/{id}', name: 'v1_update_book', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['PUT'])]
    public function __invoke(
        string $id,
        #[MapRequestPayload]
        UpdateBookRequest $request,
    ): UpdatedBookResponse {
        $uuid = Uuid::fromString($id);
        $bookDTO = $this->bookService->update(
            $uuid,
            $request
        );

        return new UpdatedBookResponse($bookDTO);
    }
}
