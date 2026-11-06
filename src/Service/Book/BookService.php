<?php

declare(strict_types=1);

namespace App\Service\Book;

use App\DTO\AuthorDTO;
use App\DTO\BookDTO;
use App\Entity\Author;
use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Request\Book\UpdateBookRequest;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

readonly class BookService
{
    public function __construct(
        private BookRepository $bookRepository,
        private AuthorRepository $authorRepository,
        private EntityManagerInterface $entityManager,
        private MoneyParser $moneyParser,
        private LoggerInterface $bookStoreLogger
    ) {
    }

    /**
     * @param string[] $authorIds
     *
     * @throws \Throwable
     */
    public function create(
        string $title,
        string $description,
        string $isbn,
        string $priceAmount,
        string $priceCurrency,
        array $authorIds,
    ): BookDTO {
        $authorUuids = array_map(
            static fn (string $id): UuidInterface => Uuid::fromString($id),
            $authorIds
        );

        $authors = $this->authorRepository->findBy([
            'uuid' => $authorUuids,
        ]);

        if (count($authors) !== count($authorUuids)) {
            throw new \RuntimeException('One or more authors were not found.');
        }

        $price = $this->moneyParser->createFromString($priceAmount, $priceCurrency);

        $book = new Book(
            $title,
            $description,
            $isbn,
            $price,
            $authors
        );

        try {
            $this->entityManager->persist($book);
            $this->entityManager->flush();

            $formattedPrice = $this->moneyParser->format($price);

            $authorDtos = array_map(
                static fn ($author): AuthorDTO => AuthorDTO::fromAuthor($author),
                $authors
            );

            $this->bookStoreLogger->info('Book created successfully.', [
                'uuid' => $book->getId()->toString(),
                'title' => $book->getTitle(),
                'description' => $book->getDescription(),
                'isbn' => $book->getIsbn(),
                'author_uuids' => array_map(static fn ($id) => $id->toString(), $authorUuids),
                'price_amount' => $formattedPrice,
                'price_currency' => $price->getCurrency()->getCode(),
            ]);

            return BookDTO::createWithAuthors(
                uuid: $book->getId(),
                title: $book->getTitle(),
                description: $book->getDescription(),
                isbn: $book->getIsbn(),
                price: $price,
                authorDtos: $authorDtos
            );
        } catch (\Throwable $exception) {
            $this->bookStoreLogger->error('Book creation failed.', [
                'title' => $title,
                'description' => $description,
                'isbn' => $isbn,
                'error_message' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    public function getById(UuidInterface $id): BookDTO
    {
        $book = $this->bookRepository->findById($id);

        if (null === $book) {
            throw BookNotFoundException::createFromId($id);
        }

        $authorDtos = array_map(
            static fn (Author $author): AuthorDTO => AuthorDTO::fromAuthor($author),
            $book->getAuthors()->toArray()
        );

        return BookDTO::createWithAuthors(
            uuid: $book->getId(),
            title: $book->getTitle(),
            description: $book->getDescription(),
            isbn: $book->getIsbn(),
            price: $book->getPrice(),
            authorDtos: $authorDtos
        );
    }

    /**
     * @return BookDTO[]
     */
    public function getAll(): array
    {
        return array_map(
            function (Book $book): BookDTO {
                $authorDtos = array_map(
                    static fn (Author $author): AuthorDTO => AuthorDTO::fromAuthor($author),
                    $book->getAuthors()->toArray()
                );

                return BookDTO::createWithAuthors(
                    uuid: $book->getId(),
                    title: $book->getTitle(),
                    description: $book->getDescription(),
                    isbn: $book->getIsbn(),
                    price: $book->getPrice(),
                    authorDtos: $authorDtos
                );
            },
            $this->bookRepository->findAll()
        );
    }

    /**
     * @throws \Throwable
     */
    public function update(UuidInterface $id, UpdateBookRequest $request): BookDTO
    {
        $book = $this->bookRepository->findById($id);

        if (null === $book) {
            throw BookNotFoundException::createFromId($id);
        }

        $authorUuids = array_map(
            static fn (string $authorId): UuidInterface => Uuid::fromString($authorId),
            $request->authorIds
        );

        $authors = $this->authorRepository->findBy([
            'uuid' => $authorUuids,
        ]);

        if (count($authors) !== count($authorUuids)) {
            throw new \RuntimeException('One or more authors were not found.');
        }

        $price = $this->moneyParser->createFromString($request->priceAmount, $request->priceCurrency);

        $formattedPrice = $this->moneyParser->format($price);

        $book->setTitle($request->title);
        $book->setDescription($request->description);
        $book->setIsbn($request->isbn);
        $book->setPrice($price);
        $currentAuthors = $book->getAuthors()->toArray();
        foreach ($currentAuthors as $oldAuthor) {
            $book->removeAuthor($oldAuthor);
        }

        foreach ($authors as $newAuthor) {
            $book->addAuthor($newAuthor);
        }

        try {
            $this->entityManager->flush();

            $authorDtos = array_map(
                static fn ($author): AuthorDTO => AuthorDTO::fromAuthor($author),
                $authors
            );

            $this->bookStoreLogger->info('Book updated successfully.', [
                'book_uuid' => $book->getId()->toString(),
                'title' => $book->getTitle(),
                'description' => $book->getDescription(),
                'isbn' => $book->getIsbn(),
                'author_uuids' => array_map(static fn ($id) => $id->toString(), $authorUuids),
                'price_amount' => $formattedPrice,
                'price_currency' => $price->getCurrency()->getCode(),
            ]);

            return BookDTO::createWithAuthors(
                uuid: $book->getId(),
                title: $book->getTitle(),
                description: $book->getDescription(),
                isbn: $book->getIsbn(),
                price: $book->getPrice(),
                authorDtos: $authorDtos
            );
        } catch (\Throwable $exception) {
            $this->bookStoreLogger->error('Book update failed.', [
                'book_uuid' => $id->toString(),
                'title' => $request->title,
                'description' => $request->description,
                'isbn' => $request->isbn,
                'price_amount' => $request->priceAmount,
                'price_currency' => $request->priceCurrency,
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
        $book = $this->bookRepository->findById($id);

        if (null === $book) {
            throw BookNotFoundException::createFromId($id);
        }

        try {
            $this->entityManager->remove($book);
            $this->entityManager->flush();

            $this->bookStoreLogger->info('Book deleted successfully.', [
                'book_uuid' => $id->toString(),
            ]);
        } catch (\Throwable $exception) {
            $this->bookStoreLogger->error('Book deletion failed.', [
                'book_uuid' => $id->toString(),
                'error_message' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }
}
