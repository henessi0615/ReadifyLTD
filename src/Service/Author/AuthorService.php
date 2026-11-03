<?php

declare(strict_types=1);

namespace App\Service\Author;

use App\DTO\AuthorDTO;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Request\UpdateAuthorRequest;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

readonly class AuthorService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private AuthorRepository $authorRepository
    ) {
    }

    public function create(
        string $name,
        ?string $biography
    ): AuthorDTO {
        $author = new Author(
            $name,
            $biography
        );

        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return AuthorDTO::fromAuthor($author);
    }

    public function getById(UuidInterface $id): AuthorDTO
    {
        $author = $this->authorRepository->findById($id);

        if (null === $author) {
            throw AuthorNotFoundException::createFromId($id);
        }

        return AuthorDTO::fromAuthor($author);
    }

    /**
     * @return AuthorDTO[]
     */
    public function getAll(): array
    {
        return array_map(
            static fn (Author $author): AuthorDTO => AuthorDTO::fromAuthor($author),
            $this->authorRepository->findAll()
        );
    }

    public function update(UuidInterface $id, UpdateAuthorRequest $request): AuthorDTO
    {
        $author = $this->authorRepository->findById($id);

        if (null === $author) {
            throw AuthorNotFoundException::createFromId($id);
        }

        $author->setName($request->name);
        $author->setBiography($request->biography);

        $this->entityManager->flush();

        return AuthorDTO::fromAuthor($author);
    }

    public function delete(UuidInterface $id): void
    {
        $author = $this->authorRepository->findById($id);

        if (null === $author) {
            throw AuthorNotFoundException::createFromId($id);
        }

        $this->entityManager->remove($author);
        $this->entityManager->flush();
    }
}
