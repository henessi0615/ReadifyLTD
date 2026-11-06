<?php

declare(strict_types=1);

namespace App\Controller\Author;

use App\Request\Author\DeleteAuthorRequest;
use App\Response\Author\AuthorDeletedResponse;
use App\Service\Author\AuthorService;
use OpenApi\Spec\Operation\Delete;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final readonly class DeleteAuthorController
{
    public function __construct(
        private AuthorService $authorService
    ) {
    }

    /**
     * @throws \Throwable
     */
    #[Delete(summary: 'Delete an author by ID', tags: ['Authors'])]
    #[Route('/api/v1/authors/{id}', name: 'v1_delete_author', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['DELETE'])]
    public function __invoke(
        string $id
    ): AuthorDeletedResponse {
        $uuid = Uuid::fromString($id);

        $request = new DeleteAuthorRequest($uuid);

        $this->authorService->delete($request->id);

        return new AuthorDeletedResponse();
    }
}
