<?php

declare(strict_types=1);

namespace App\DTO;

use JsonSerializable;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Ramsey\Uuid\UuidInterface;

readonly class BookDTO implements JsonSerializable
{
    /**
     * @param AuthorDTO[] $authors
     */
    public function __construct(
        public UuidInterface $uuid,
        public string $title,
        public string $description,
        public string $isbn,
        public Money $price,
        public array $authors
    ) {
    }

    /**
     * @param AuthorDTO[] $authorDtos
     */
    public static function createWithAuthors(
        UuidInterface $uuid,
        string $title,
        string $description,
        string $isbn,
        Money $price,
        array $authorDtos
    ): self {
        return new self($uuid, $title, $description, $isbn, $price, $authorDtos);
    }

    /**
     * @return array{
     *     book_uuid: string,
     *     title: string,
     *     description: string,
     *     isbn: string,
     *     price_amount: string,
     *     price_currency: string,
     *     authors: array<int, array{authorId: string, name: string, biography: string|null}>
     * }
     */
    public function jsonSerialize(): array
    {
        $decimalFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        $serializedAuthors = array_map(
            static fn (AuthorDTO $authorDto): array => $authorDto->jsonSerialize(),
            $this->authors
        );

        return [
            'book_uuid' => $this->uuid->toString(),
            'title' => $this->title,
            'description' => $this->description,
            'isbn' => $this->isbn,
            'price_amount' => $decimalFormatter->format($this->price),
            'price_currency' => $this->price->getCurrency()->getCode(),
            'authors' => array_values($serializedAuthors),
        ];
    }
}
