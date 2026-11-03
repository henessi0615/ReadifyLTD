<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\UpdateAuthorRequest;
use App\Response\UpdatedAuthorResponse;
use App\Service\Author\AuthorService;
use OpenApi\Spec\Operation\Put;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final readonly class UpdateAuthorController
{
    public function __construct(
        private AuthorService $authorService,
    ) {
    }

    #[Put(summary: 'Full update an existing author', tags: ['Authors'])]
    #[Route('/api/v1/authors/{id}', name: 'v1_update_author', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['PUT'])]
    public function __invoke(
        string $id,
        #[MapRequestPayload]
        UpdateAuthorRequest $request,
    ): UpdatedAuthorResponse {
        $uuid = Uuid::fromString($id);
        $authorDto = $this->authorService->update(
            $uuid,
            $request
        );

        return new UpdatedAuthorResponse($authorDto);
    }
}
