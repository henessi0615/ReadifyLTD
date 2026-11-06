<?php

declare(strict_types=1);

namespace App\Request\Book;

use App\Validator\AuthorExists;
use App\Validator\UniqueIsbn;
use OpenApi\Spec\Schema;
use Symfony\Component\Validator\Constraints as Assert;

#[Schema(title: 'UpdateBookRequest')]
#[UniqueIsbn]
final readonly class UpdateBookRequest
{
    public function __construct(
        #[Assert\Sequentially([
            new Assert\NotBlank(message: 'The book title cannot be blank.'),
            new Assert\Length(max: 255, maxMessage: 'The book title cannot exceed {{ limit }} characters.'),
        ])]
        public string $title,
        #[Assert\Sequentially([
            new Assert\NotBlank(message: 'The book description cannot be blank.'),
            new Assert\Length(
                min: 10,
                max: 2000,
                minMessage: 'The book description cannot be less than {{ limit }} characters.',
                maxMessage: 'The book description cannot be longer than {{ limit }} characters.'
            ),
        ])]
        public string $description,
        #[Assert\Sequentially([
            new Assert\NotBlank(message: 'The ISBN cannot be blank.'),
            new Assert\Length(min: 13, max: 13, exactMessage: 'The ISBN must be exactly {{ limit }} characters long.'),
        ])]
        public string $isbn,
        #[Assert\Sequentially([
            new Assert\NotBlank(message: 'The price cannot be blank.'),
            new Assert\GreaterThanOrEqual(value: 0, message: 'The price cannot be negative.'),
            new Assert\Regex(pattern: '/^(?=\d)\d+(?:\.\d{2})?$/', message: 'Invalid price format.'),
        ])]
        public string $priceAmount,
        #[Assert\Sequentially([
            new Assert\NotBlank(message: 'The currency cannot be blank.'),
            new Assert\Currency(message: 'Invalid currency.'),
        ])]
        public string $priceCurrency,
        #[Assert\Sequentially([
            new Assert\NotBlank(message: 'The author ID is required.'),
            new AuthorExists(),
            new Assert\Uuid(message: 'The author ID must be a valid ID.'),
        ])]
        public string $authorId
    ) {
    }
}
