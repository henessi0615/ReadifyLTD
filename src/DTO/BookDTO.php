<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Author;
use App\Entity\Book;
use JsonSerializable;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Ramsey\Uuid\UuidInterface;

readonly class BookDTO implements JsonSerializable
{
    public function __construct(
        public UuidInterface $id,
        public string $title,
        public string $description,
        public string $isbn,
        public Money $price,
        public Author $author
    ) {
    }

    public static function fromBook(Book $book): self
    {
        return new self(
            $book->getId(),
            $book->getTitle(),
            $book->getDescription(),
            $book->getIsbn(),
            $book->getPrice(),
            $book->getAuthor()
        );
    }

    /**
     * @return array{bookId: UuidInterface, title: string,
     *      description: string, isbn: string,
     *      priceAmount: string, priceCurrency: string,
     *      author: Author}
     */
    public function jsonSerialize(): array
    {
        $formattedPriceAmount = new DecimalMoneyFormatter(new ISOCurrencies());

        return [
            'bookId' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'isbn' => $this->isbn,
            'priceAmount' => $formattedPriceAmount->format($this->price),
            'priceCurrency' => $this->price->getCurrency()->getCode(),
            'author' => $this->author,
        ];
    }
}
