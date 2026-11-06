<?php

declare(strict_types=1);

namespace App\Request\Author;

use Ramsey\Uuid\UuidInterface;

final readonly class DeleteAuthorRequest
{
    public function __construct(
        public UuidInterface $id
    ) {
    }
}
