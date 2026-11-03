<?php

declare(strict_types=1);

namespace App\Service\Book;

use App\DTO\BookDTO;
use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Request\UpdateBookRequest;
use App\Service\Author\AuthorNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

readonly class BookService
{
    public function __construct(
        private BookRepository $bookRepository,
        private AuthorRepository $authorRepository,
        private EntityManagerInterface $entityManager,
        private MoneyParser $moneyParser,
    ) {
    }

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

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return BookDTO::fromBook($book);
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

        $this->entityManager->flush();

        return BookDTO::fromBook($book);
    }

    public function delete(UuidInterface $id): void
    {
        $book = $this->bookRepository->findById($id);

        if (null === $book) {
            throw BookNotFoundException::createFromId($id);
        }

        $this->entityManager->remove($book);
        $this->entityManager->flush();
    }
}
