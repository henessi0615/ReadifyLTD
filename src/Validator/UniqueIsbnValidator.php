<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\BookRepository;
use App\Request\Book\CreateBookRequest;
use App\Request\Book\UpdateBookRequest;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueIsbnValidator extends ConstraintValidator
{
    public function __construct(
        private readonly BookRepository $bookRepository,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (! $constraint instanceof UniqueIsbn) {
            throw new UnexpectedTypeException($constraint, UniqueIsbn::class);
        }

        if (! is_object($value)) {
            return;
        }

        /**
         * @var CreateBookRequest|UpdateBookRequest $value
         */
        if (! property_exists($value, 'isbn')) {
            return;
        }

        $isbn = (string) $value->isbn;

        if ('' === $isbn) {
            return;
        }

        $existingBook = $this->bookRepository->findOneBy([
            'isbn' => $isbn,
        ]);

        if (null !== $existingBook) {
            $existingBookId = $existingBook->getId()->toString();

            if (property_exists($value, 'uuid') && $existingBookId === $value->uuid) {
                return;
            }

            $this->context->buildViolation($constraint->message)
                ->atPath('isbn')
                ->addViolation()
            ;
        }
    }
}
