<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\CreateAuthorRequest;
use App\Response\AuthorCreatedResponse;
use App\Service\Author\AuthorService;
use OpenApi\Spec\Operation\Post;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final readonly class CreateAuthorController
{
    public function __construct(
        private AuthorService $authorService,
    ) {
    }

    #[Post(summary: 'Create a new Author', tags: ['Author'])]
    #[Route('/api/v1/authors', name: 'v1_create_author', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload]
        CreateAuthorRequest $request
    ): AuthorCreatedResponse {
        $authorDto = $this->authorService->create(
            name: $request->name,
            biography: $request->biography,
        );

        return new AuthorCreatedResponse($authorDto);
    }
}
