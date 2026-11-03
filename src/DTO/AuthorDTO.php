<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Author;
use JsonSerializable;
use Ramsey\Uuid\UuidInterface;

readonly class AuthorDTO implements JsonSerializable
{
    public function __construct(
        public UuidInterface $id,
        public string $name,
        public ?string $biography
    ) {
    }

    public static function fromAuthor(Author $author): self
    {
        return new self(
            $author->getId(),
            $author->getName(),
            $author->getBiography()
        );
    }

    /**
     * @return array{authorId: UuidInterface, name: string, biography: string|null}
     */
    public function jsonSerialize(): array
    {
        return [
            'authorId' => $this->id,
            'name' => $this->name,
            'biography' => $this->biography,
        ];
    }
}
