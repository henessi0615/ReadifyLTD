<?php

declare(strict_types=1);

namespace App\Request;

use OpenApi\Spec\Schema;
use Symfony\Component\Validator\Constraints as Assert;

#[Schema(title: 'UpdateAuthorRequest')]
final readonly class UpdateAuthorRequest
{
    public function __construct(
        #[Assert\Sequentially([
            new Assert\NotBlank(message: 'Author name cannot be blank.'),
            new Assert\Length(max: 24, maxMessage: 'Author name cannot exceed {{ limit }} characters.'),
        ])]
        public string $name,
        #[Assert\Length(max: 2000, maxMessage: 'Biography cannot exceed {{ limit }} characters.')]
        public string $biography,
    ) {
    }
}
