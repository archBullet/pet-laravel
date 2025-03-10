<?php

declare(strict_types=1);

namespace App\Domains\Orders\Dto;

use App\Domains\Orders\Http\Requests\ListOrderRequest;
use App\Domains\Users\Models\User;

class ListOrdersDto
{
    public function __construct(
        public User $user,
    ) {
    }

    public static function fromRequest(ListOrderRequest $request): self
    {
        return new self(
            auth()->user()
        );
    }
}