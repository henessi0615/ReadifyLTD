<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class BookDeletedResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct(status: Response::HTTP_NO_CONTENT);
    }
}
