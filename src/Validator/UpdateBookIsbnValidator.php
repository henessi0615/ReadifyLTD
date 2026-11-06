<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\BookRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request; // Используем базовый компонент запроса
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UpdateBookIsbnValidator extends ConstraintValidator
{
    public function __construct(
        private readonly BookRepository $bookRepository,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (! $constraint instanceof UpdateBookIsbn) {
            throw new UnexpectedTypeException($constraint, UpdateBookIsbn::class);
        }

        if (! is_object($value) || ! property_exists($value, 'isbn')) {
            return;
        }

        if (! is_string($value->isbn)) {
            return;
        }

        $newIsbn = $value->isbn;

        if ('' === $newIsbn) {
            return;
        }

        $request = Request::createFromGlobals();

        $bookId = $request->attributes->get('id');

        if (! is_string($bookId)) {
            return;
        }

        $updatingBook = $this->bookRepository->findById(Uuid::fromString($bookId));

        if (null === $updatingBook) {
            return;
        }

        if ($updatingBook->getIsbn() === $newIsbn) {
            return;
        }

        $existingBook = $this->bookRepository->findOneBy([
            'isbn' => $newIsbn,
        ]);

        if (null !== $existingBook) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ isbn }}', $newIsbn)
                ->atPath('isbn')
                ->addViolation()
            ;
        }
    }
}
