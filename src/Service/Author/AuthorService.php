<?php

declare(strict_types=1);

namespace App\Service\Author;

use App\DTO\AuthorDTO;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Request\Author\UpdateAuthorRequest;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\UuidInterface;

readonly class AuthorService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private AuthorRepository $authorRepository,
        private LoggerInterface $bookStoreLogger,
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function create(
        string $name,
        ?string $biography
    ): AuthorDTO {
        $author = new Author(
            $name,
            $biography
        );

        try {
            $this->entityManager->persist($author);
            $this->entityManager->flush();

            $this->bookStoreLogger->info('Author created successfully', [
                'author_uuid' => $author->getId()->toString(),
                'name' => $name,
                'biography' => $biography,
            ]);

            return AuthorDTO::fromAuthor($author);
        } catch (\Throwable $exception) {
            $this->bookStoreLogger->error('Author creation failed.', [
                'name' => $name,
                'error_message' => $exception->getMessage(),
            ]);

            throw $exception;
        }
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

    /**
     * @throws \Throwable
     */
    public function update(UuidInterface $id, UpdateAuthorRequest $request): AuthorDTO
    {
        $author = $this->authorRepository->findById($id);

        if (null === $author) {
            throw AuthorNotFoundException::createFromId($id);
        }

        $author->setName($request->name);
        $author->setBiography($request->biography);

        try {
            $this->entityManager->flush();

            $this->bookStoreLogger->info('Author updated successfully.', [
                'author_uuid' => $id->toString(),
                'name' => $author->getName(),
                'biography' => $author->getBiography(),
            ]);

            return AuthorDTO::fromAuthor($author);
        } catch (\Throwable $exception) {
            $this->bookStoreLogger->error('Author update failed.', [
                'author_uuid' => $id->toString(),
                'name' => $request->name,
                'biography' => $request->biography,
                'error_message' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }

    /**
     * @throws \Throwable
     */
    public function delete(UuidInterface $id): void
    {
        $author = $this->authorRepository->findById($id);

        if (null === $author) {
            throw AuthorNotFoundException::createFromId($id);
        }

        try {
            $this->entityManager->remove($author);
            $this->entityManager->flush();

            $this->bookStoreLogger->info('Author deleted successfully.', [
                'author_uuid' => $id->toString(),
            ]);
        } catch (\Throwable $exception) {
            $this->bookStoreLogger->error('Author deletion failed.', [
                'author_uuid' => $id->toString(),
                'error_message' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }
}
