<?php

declare(strict_types=1);

namespace App\Services\ApiService\Dto;

use App\Services\ApiService\Enums\ApiServiceStatusEnum;
use Illuminate\Http\Client\Response;

class ApiServiceResponseDto
{
    public function __construct(
        public ApiServiceStatusEnum $status,
        public string $uuid,
    ) {
    }

    public static function fromResponse(Response $response): self
    {
        return new self(
            status: ApiServiceStatusEnum::tryFrom($response->json('data.status')),
            uuid: $response->json('data.uuid'),
        );
    }
}