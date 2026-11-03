<?php

declare(strict_types=1);

namespace App\Request;

use Ramsey\Uuid\UuidInterface;

final readonly class DeleteBookRequest
{
    public function __construct(
        public UuidInterface $id
    ) {
    }
}
