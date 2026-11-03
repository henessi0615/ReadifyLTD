<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\GetAuthorsRequest;
use App\Response\GetAuthorsResponse;
use App\Service\Author\AuthorService;
use OpenApi\Spec\Operation\Get;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final readonly class GetAuthorsController
{
    public function __construct(
        private AuthorService $authorService,
    ) {
    }

    #[Get(summary: "Get a filtered Authors's list", tags: ['Authors'])]
    #[Route('/api/v1/authors', name: 'v1_get_authors', methods: ['GET'])]
    public function __invoke(
        GetAuthorsRequest $request = new GetAuthorsRequest(),
    ): JsonResponse {
        return new GetAuthorsResponse(
            $this->authorService->getAll()
        );
    }
}
