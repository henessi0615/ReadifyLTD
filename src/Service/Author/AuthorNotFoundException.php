<?php

declare(strict_types=1);

namespace App\Service\Author;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class AuthorNotFoundException extends NotFoundHttpException
{
    public static function createFromId(UuidInterface $id): self
    {
        return new self(sprintf('Author with ID %d not found.', $id));
    }
}
