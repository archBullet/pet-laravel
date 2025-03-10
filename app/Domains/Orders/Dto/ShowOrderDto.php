<?php

declare(strict_types=1);

namespace App\Domains\Orders\Dto;

use App\Domains\Orders\Http\Requests\ShowOrderRequest;
use App\Domains\Users\Models\User;

class ShowOrderDto
{
    public function __construct(
        public string $uuid,
        public User $user,
    ) {
    }

    public static function fromRequest(ShowOrderRequest $request): self
    {
        return new self(
            $request->input('order'),
            auth()->user(),
        );
    }
}