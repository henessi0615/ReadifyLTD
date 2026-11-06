<?php

declare(strict_types=1);

namespace App\Request\User;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class LoginUserRequest
{
    public function __construct(
        #[Assert\Sequentially([
            new Assert\NotBlank(message: 'Email cannot be blank.'),
            new Assert\Email(message: 'Email is not a valid email address.'),
        ])]
        public string $email,
        #[Assert\Sequentially([
            new Assert\NotBlank(message: 'Password cannot be blank.'),
            new Assert\Length(
                min: 8,
                max: 48,
                minMessage: 'Your password must be at least {{ limit }} characters long.'
            ),
        ])]
        #[\SensitiveParameter]
        public string $password,
    ) {
    }
}
