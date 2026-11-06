<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\User;
use JsonSerializable;
use Ramsey\Uuid\UuidInterface;

readonly class UserDTO implements JsonSerializable
{
    public function __construct(
        public UuidInterface $id,
        public string $email,
        public string $displayName,
        public string $createdAt,
    ) {
    }

    public static function fromUser(User $user): self
    {
        return new self(
            $user->getId(),
            $user->getEmail(),
            $user->getDisplayName(),
            $user->getCreatedAt()->format(\DateTimeInterface::ATOM),
        );
    }

    /**
     * @return array{userId: UuidInterface, email: string,
     *     displayName: string, createdAt: string}
     */
    public function jsonSerialize(): array
    {
        return [
            'userId' => $this->id,
            'email' => $this->email,
            'displayName' => $this->displayName,
            'createdAt' => $this->createdAt,
        ];
    }
}
