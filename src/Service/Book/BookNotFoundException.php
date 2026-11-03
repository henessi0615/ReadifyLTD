<?php

declare(strict_types=1);

namespace App\Service\Book;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class BookNotFoundException extends NotFoundHttpException
{
    public static function createFromId(UuidInterface $id): self
    {
        return new self(sprintf('Book with ID %d not found.', $id));
    }
}
