<?php

declare(strict_types=1);

namespace App\Controller\Author;

use App\Request\Author\GetAuthorRequest;
use App\Response\Author\GetAuthorResponse;
use App\Service\Author\AuthorService;
use OpenApi\Spec\Operation\Get;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final readonly class GetAuthorController
{
    public function __construct(
        private AuthorService $authorService,
    ) {
    }

    #[Get(summary: 'Get a specific author by ID', tags: ['Authors'])]
    #[Route('/api/v1/authors/{id}', name: 'v1_get_author', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function __invoke(
        string $id,
    ): GetAuthorResponse {
        $uuid = Uuid::fromString($id);

        $request = new GetAuthorRequest($uuid);

        $authorDto = $this->authorService->getById($request->id);

        return new GetAuthorResponse($authorDto);
    }
}
