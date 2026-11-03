<?php

declare(strict_types=1);

namespace App\Response;

use App\DTO\AuthorDTO;
use OpenApi\Spec\Property;
use OpenApi\Spec\Schema;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @property AuthorDTO $data
 */
#[Schema(component: 'AuthorCreatedResponse')]
final class AuthorCreatedResponse extends JsonResponse
{
    #[Property(schema: new Schema(type: 'string', example: 'success'))]
    public string $status = 'success';

    public function __construct(AuthorDTO $authorDto)
    {
        parent::__construct([
            'status' => 'success',
            'data' => $authorDto->jsonSerialize(),
        ], status: Response::HTTP_CREATED);
    }
}
