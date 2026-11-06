<?php

declare(strict_types=1);

namespace App\Service\Book;

use App\DTO\BookDTO;
use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Request\Book\UpdateBookRequest;
use App\Service\Author\AuthorNotFoundException;
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
     * @throws \Throwable
     */
    public function create(
        string $title,
        string $description,
        string $isbn,
        string $priceAmount,
        string $priceCurrency,
        string $authorId,
    ): BookDTO {
        $authorUuid = Uuid::fromString($authorId);

        $author = $this->authorRepository->find($authorUuid);

        if (null === $author) {
            throw AuthorNotFoundException::createFromId($authorUuid);
        }

        $price = $this->moneyParser->createFromString($priceAmount, $priceCurrency);

        $book = new Book(
            $title,
            $description,
            $isbn,
            $price,
            $author
        );

        try {
            $this->entityManager->persist($book);
            $this->entityManager->flush();

            $this->bookStoreLogger->info('Book created successfully.', [
                'book_uuid' => $book->getId()->toString(),
                'title' => $book->getTitle(),
                'description' => $book->getDescription(),
                'isbn' => $book->getIsbn(),
                'price_amount' => $price->getAmount(),
                'price_currency' => $price->getCurrency()->getCode(),
            ]);

            return BookDTO::fromBook($book);
        } catch (\Throwable $exception) {
            $this->bookStoreLogger->error('Book creation failed.', [
                'title' => $title,
                'description' => $description,
                'isbn' => $isbn,
                'price_amount' => $price->getAmount(),
                'price_currency' => $price->getCurrency()->getCode(),
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

        return BookDTO::fromBook($book);
    }

    /**
     * @return BookDTO[]
     */
    public function getAll(): array
    {
        return array_map(
            static fn (Book $book): BookDTO => BookDTO::fromBook($book),
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

        $authorId = Uuid::fromString($request->authorId);

        $author = $this->authorRepository->findById($authorId);
        if (null === $author) {
            throw AuthorNotFoundException::createFromId($authorId);
        }

        $price = $this->moneyParser->createFromString($request->priceAmount, $request->priceCurrency);

        $book->setTitle($request->title);
        $book->setDescription($request->description);
        $book->setIsbn($request->isbn);
        $book->setPrice($price);
        $book->setAuthor($author);

        try {
            $this->entityManager->flush();

            $this->bookStoreLogger->info('Book updated successfully.', [
                'book_uuid' => $book->getId()->toString(),
                'title' => $book->getTitle(),
                'description' => $book->getDescription(),
                'isbn' => $book->getIsbn(),
                'price_amount' => $price->getAmount(),
                'price_currency' => $price->getCurrency()->getCode(),
            ]);

            return BookDTO::fromBook($book);
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
