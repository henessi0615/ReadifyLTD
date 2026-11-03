<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\AuthorRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class AuthorExistsValidator extends ConstraintValidator
{
    public function __construct(
        private readonly AuthorRepository $authorRepository
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (! $constraint instanceof AuthorExists) {
            throw new UnexpectedTypeException($constraint, AuthorExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (null === $this->authorRepository->find($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}
