<?php

declare(strict_types=1);

namespace App\Controller\Book;

use App\Request\Book\DeleteBookRequest;
use App\Response\Book\BookDeletedResponse;
use App\Service\Book\BookService;
use OpenApi\Spec\Operation\Delete;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final readonly class DeleteBookController
{
    public function __construct(
        private BookService $bookService,
    ) {
    }

    /**
     * @throws \Throwable
     */
    #[Delete(summary: 'Delete a book by ID', tags: ['Books'])]
    #[Route('/api/v1/books/{id}', name: 'v1_delete_book', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['DELETE'])]
    public function __invoke(
        string $id
    ): BookDeletedResponse {
        $uuid = Uuid::fromString($id);

        $request = new DeleteBookRequest($uuid);

        $this->bookService->delete($request->id);

        return new BookDeletedResponse();
    }
}
